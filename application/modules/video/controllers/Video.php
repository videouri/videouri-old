<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library('Videouri/ApiProcessing');
        $this->lang->load('error');
    }

    /**
    * This function will retrieve the video's data according to its id
    *
    * @param string $customId The id for which to look for data
    * @return the php response from parsing the data.
    */
    public function id($customId, $extra = NULL)
    {
        $api    = substr($customId, 1, 1);
        $origId = substr_replace($customId, '', 1, 1);

        switch ($api) {
            case 'd':
                $api = 'Dailymotion';
                break;

            case 'v':
                $api = 'Vimeo';
                break;

            case 'y':
                $api = 'YouTube';
                break;

            case 'M':
                $api = 'Metacafe';
                $long_id  = $origId.'/'.$extra;
                break;

            default:
                show_error(lang('video_id',$customId));
                break;
        }


        $this->apiprocessing->videoId = ($api === "Metacafe") ? $long_id : $origId;
        $this->apiprocessing->content = 'getVideoEntry';

        try {
            $results = $this->apiprocessing->individualCall($api);
        }

        catch (ParameterException $e) {
            prePrint($e);
            #show_error($e->getMessage());
        }

        catch (Exception $e) {
            #prePrint($e);
            $code = $e->getCode() ? $e->getCode() : 404;
            //prePrint($e);
            show_error($e->getMessage(),$code);
        }

        if ($api === "Dailymotion") {
            // $swfUrl = $result['swf_url'].'&enableApi=1&playerapiid=dmplayer';
            // $swfUrl = preg_replace("/^http:/i", "https:", $swfUrl);

            // $data['video']['swf']['url']  = $swfUrl;
            // $data['video']['swf']['api']  = 'dmapiplayer';
            $data['video']['title']       = $results['title'];
            $data['video']['description'] = $results['description'];

            $thumbnailUrl = preg_replace("/^http:/i", "https:", $results['thumbnail_medium_url']);
            $data['video']['img']         = $thumbnailUrl;
            $data['video']['tags']        = $results['tags'];
            // $data['video']['related']     = $this->_relatedVideos(array('api'=>$api,'id'=>$origId));
        }

        elseif ($api === "Metacafe") {
            // if (preg_match('/http:\/\/[w\.]*metacafe\.com\/fplayer\/(.*).swf/is', $results['embed'], $match)) {
            //     $data['video']['swf']['url'] = $results['embed'];
            //     $data['video']['swf']['api'] = 'mcapiplayer';
            // }

            // else {
            //     $data['video']['embed_html'] = $results['embed'];
            // }

            $data['video']['title'] = $results->title;
            $data['video']['img'] = 'http://www.metacafe.com/thumb/'.$origId.'.jpg';

            $dom = new DOMDocument();
            $dom->loadHTML($results->description);

            $xml = simplexml_import_dom($dom);
            $p   = (string)$xml->body->p;
            
            $data['video']['description'] = strstr($p, 'Ranked', true);

            $tags  = array();
            $count = count((object)$xml->body->p[1]->a) - 2;
            for ($i = 2; $i <= $count; $i++) {
                $tag = (object)$xml->body->p[1]->a[$i];
                $tag = str_replace(array('News & Events'), '', $tag);
                $tags[] = $tag;
            }

            $data['video']['tags']        = $tags;
            // $data['video']['related']     = $this->_relatedVideos(array('api'=>$api,'id'=>$origId));
        }

        elseif ($api == "Vimeo") {
            $video = $results['body'];

            $data['video']['url']         = "https://vimeo.com/".$origId;
            $data['video']['title']       = $video['name'];
            $data['video']['description'] = $video['description'];

            $tags = array();
            if (!empty($video['tags'])) {
                foreach($video['tags'] as $tag) {
                    $tags[] = $tag['name'];
                }
            }

            $data['video']['img']         = $video['pictures']['sizes'][2]['link'];
            $data['video']['tags']        = $tags;
            // $data['video']['related']     = $this->_relatedVideos(null, array('api'=>$api,'tags'=>$data['video']['tags']));
        }

        elseif ($api == "YouTube") {
            $results = json_decode($results, true)['entry'];

            $data['video']['url']         = "https://www.youtube.com/watch?v=".$origId;
            $data['video']['title']       = $results['title']['$t'];
            $data['video']['description'] = $results['media$group']['media$description']['$t'];
            
            $tags = array();
            $categoriesCount = count($results['category']) - 1;
            for ($i = 1; $i <= $categoriesCount; $i++) {
                $tags[] = $results['category'][$i]['term'];
            }

            $data['video']['img']       = 'https://i.ytimg.com/vi/'.$origId.'/0.jpg';
            $data['video']['tags']      = $tags;
            // $data['video']['related']   = $this->_relatedVideos(array('api'=>$api,'id'=>$origId));
        }

        $data['customId']  = $customId;
        $data['origId']    = $origId;
        $data['source']    = $api;
        $data['canonical'] = "video/$customId";

        $this->template->content->view('videoPage', $data);
        // $this->template->javascript->add('dist/modules/video.js');
        $this->template->publish();
    }



    /**
    * This function will retrieve related videos according to its id or some of its tags
    *
    * @param string $origId The id for which to look for data
    * @return the php response from parsing the data.
    */
    private function _relatedVideos($parameters = array(), $tags = array())
    {
        if (!empty($parameters)) {
            $id = $parameters['id'];
            $relatedVideos[$parameters['api']] = modules::run("apis/{$parameters['api']}Controller/related", $id);
            switch ($parameters['api'])
            {
                case 'Dailymotion':
                    $i = 0;
                    foreach ($relatedVideos['Dailymotion']['list'] as $video)
                    {
                        preg_match('@video/([^_]+)_([^/]+)@', $video['url'], $match);
                        $url = $match[1].'/'.$match[2];
                        $url = site_url('video/'.substr($url,0,1).'d'.substr($url,1));

                        $related['Dailymotion'][$i]['url']   = $url;
                        $related['Dailymotion'][$i]['title'] = $video['title'];
                        $thumbnailUrl = preg_replace("/^http:/i", "https:", $video['thumbnail_small_url']);
                        $related['Dailymotion'][$i]['img']   = $thumbnailUrl;
                        $i++;
                    }
                break;
                case "Metacafe":
                    $i = 0;
                    foreach ($relatedVideos['Metacafe']->channel->item as $video)
                    {
                        preg_match('/http:\/\/[w\.]*metacafe\.com\/watch\/([^?&#"\']*)/is', $video->link, $match);
                        $id  = substr($match[1],0,-1);
                        $url = site_url('video/'.substr($id,0,1).'M'.substr($id,1));

                        $related['Metacafe'][$i]['url']   = $url;
                        $related['Metacafe'][$i]['title'] = trim_text($video->title, 83);
                        $related['Metacafe'][$i]['img']   = "http://www.metacafe.com/thumb/$video->id.jpg";
                        $i++;
                    }
                break;
                case "Vimeo":
                    $i = 0;
                    foreach ($related['Vimeo']->videos->video as $video)
                    {
                        $id  = substr($video->id,0,1).'v'.substr($video->id,1);
                        $url = site_url('video/'.$id);

                        $related['Vimeo'][$i]['url']   = $url;
                        $related['Vimeo'][$i]['title'] = trim_text($video->title, 83);
                        $related['Vimeo'][$i]['img']   = $video->thumbnails->thumbnail[1]->_content;
                        $i++;
                    }
                break;
                case 'YouTube':
                    $i = 0;
                    foreach ($relatedVideos['YouTube']['feed']['entry'] as $video) {
                        $origid = substr( $video['id']['$t'], strrpos( $video['id']['$t'], '/' )+1 );
                        $id     = substr($origid,0,1).'y'.substr($origid,1);
                        $url    = site_url('video/'.$id);

                        $related['YouTube'][$i]['url']   = $url;
                        $related['YouTube'][$i]['title'] = trim_text($video['title']['$t'], 83);
                        $thumbnailUrl = preg_replace("/^http:/i", "https:", $video['media$group']['media$thumbnail'][0]['url']);
                        $related['YouTube'][$i]['img']   = $thumbnailUrl;
                        $i++;
                    }
                break;
            }
            return $related;
        }

        if (!empty($tags['tags'])) {
            $parameters['api']     = $tags['api'];
            $parameters['content'] = 'tag';
            $vt = array();
            $i = 0;

            foreach($tags['tags'] as $tag) {
                $vt[] = $tag;
                if($i == 5){break;}
                $i++;
            }

            $tc = count($tags);

            if($tc == 5)
            {
                $results = array();
                foreach($vt as $tag)
                {
                    $parameters['searchQuery'] = $tag;
                    $results[$parameters['api']][$i] = $this->$parameters['api']($parameters);
                    if($i == 2){break;}
                    $i++;
                }
                /*foreach($results as $key => $value)
                {
                    prePrint($key);
                }*/
            }

            if(($tc < 5) && ($tc !== 0))
            {
                
            }
        }
    }
}

/* End of file video.php */
/* Location: ./application/modules/video/controllers/video.php */