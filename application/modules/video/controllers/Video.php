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

        // dd($results);

        if ($api === "Dailymotion") {
            $httpsUrl             = preg_replace("/^http:/i", "https:", $results['url']);
            $data['video']['url'] = $httpsUrl;
            
            $thumbnailUrl         = preg_replace("/^http:/i", "https:", $results['thumbnail_medium_url']);
            $data['video']['img'] = $thumbnailUrl;
            
            // $data['video']['ratings']     = $results['ratings'];
            $data['video']['title']       = $results['title'];
            $data['video']['description'] = $results['description'];
            $data['video']['tags']        = $results['tags'];
            $data['video']['views']       = humanizeNumber($results['views_total']);
            $data['video']['duration']    = humanizeSeconds($results['duration']);

            $data['video']['related']     = $this->_relatedVideos($api, $origId);
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
            // dd($video);

            $data['video']['url']         = "https://vimeo.com/".$origId;
            $data['video']['title']       = $video['name'];
            $data['video']['description'] = $video['description'];

            $tags = array();
            if (!empty($video['tags'])) {
                foreach($video['tags'] as $tag) {
                    $tags[] = $tag['name'];
                }
            }
            // $data['video']['ratings']     = $results['ratings'];
            $data['video']['views']       = humanizeNumber($video['stats']['plays']);
            $data['video']['duration']    = humanizeSeconds($video['duration']);

            $data['video']['img']         = $video['pictures']['sizes'][2]['link'];
            $data['video']['tags']        = $tags;
            $data['video']['related']     = $this->_relatedVideos($api, $origId);
        }

        elseif ($api == "YouTube") {
            $results = json_decode($results, true)['entry'];
            // dd($results);

            $data['video']['url']         = "https://www.youtube.com/watch?v=".$origId;
            $data['video']['title']       = $results['title']['$t'];
            $data['video']['description'] = $results['media$group']['media$description']['$t'];
            
            $tags = array();
            $categoriesCount = count($results['category']) - 1;
            for ($i = 1; $i <= $categoriesCount; $i++) {
                $tags[] = $results['category'][$i]['term'];
            }

            // $data['video']['ratings']     = $results['gd$rating']['average'];
            $data['video']['views']       = humanizeNumber($results['yt$statistics']['viewCount']);
            $data['video']['duration']    = humanizeSeconds($results['media$group']['yt$duration']['seconds']);

            $data['video']['img']       = 'https://i.ytimg.com/vi/'.$origId.'/0.jpg';
            $data['video']['tags']      = $tags;
            $data['video']['related']   = $this->_relatedVideos($api, $origId);
        }

        $data['img']       = $data['video']['img'];
        $data['customId']  = $customId;
        $data['origId']    = $origId;
        $data['source']    = $api;
        $data['canonical'] = "video/$customId";

        // don't wrap the partia view in div.container
        $this->template->bodyId   = 'videoPage';
        $this->template->dontWrap = true;

        $this->template->title = $data['video']['title'] . ' - Videouri';
        $this->template->description = trim_text($data['video']['description'], 100);
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
    private function _relatedVideos($api, $origId = null)
    {
        $this->apiprocessing->content    = 'getRelatedVideos';
        $this->apiprocessing->maxResults = 8;
        // $this->apiprocessing->api = $api;
        // $this->apiprocessing->videoId = $origId;
         
        $results = $this->apiprocessing->individualCall($api);
        // $results = $this->apiprocessing->parseApiResult($api, $results);
        // dd($results);

        $related = [];

        switch ($api)
        {
            case 'Dailymotion':
                $i = 0;
                // dd($results);
                foreach ($results['list'] as $video)
                {
                    preg_match('@video/([^_]+)_([^/]+)@', $video['url'], $match);
                    $url = $match[1].'/'.$match[2];
                    $url = site_url('video/'.substr($url,0,1).'d'.substr($url,1));

                    $httpsUrl           = preg_replace("/^http:/i", "https:", $url);
                    $related[$i]['url'] = $httpsUrl;
                    
                    $thumbnailUrl       = preg_replace("/^http:/i", "https:", $video['thumbnail_240_url']);
                    $related[$i]['img'] = $thumbnailUrl;

                    $related[$i]['title']  = $video['title'];                    
                    $related[$i]['source'] = 'Dailymotion';
                    $i++;
                }
            break;
            case "Metacafe":
                $i = 0;
                foreach ($results->channel->item as $video)
                {
                    preg_match('/http:\/\/[w\.]*metacafe\.com\/watch\/([^?&#"\']*)/is', $video->link, $match);
                    $id  = substr($match[1],0,-1);
                    $url = site_url('video/'.substr($id,0,1).'M'.substr($id,1));

                    $related[$i]['url']    = $url;
                    $related[$i]['title']  = trim_text($video->title, 83);
                    $related[$i]['img']    = "http://www.metacafe.com/thumb/$video->id.jpg";
                    $related[$i]['source'] = 'Metacafe';
                    $i++;
                }
            break;
            case "Vimeo":
                $i = 0;
                foreach ($results['body']['data'] as $video)
                {
                    $origid = explode('/', $video['uri'])[2];
                    $id     = substr($origid,0,1).'v'.substr($origid,1);
                    $url = site_url('video/'.$id);

                    $related[$i]['url']    = $url;
                    $related[$i]['title']  = trim_text($video['name'], 83);
                    $related[$i]['img']    = $video['pictures']['sizes'][2]['link'];
                    $related[$i]['source'] = 'Metacafe';
                    $i++;
                }
            break;
            case 'YouTube':
                $i = 0;
                foreach ($results['feed']['entry'] as $video) {
                    $origid = substr( $video['id']['$t'], strrpos( $video['id']['$t'], '/' )+1 );
                    $id     = substr($origid,0,1).'y'.substr($origid,1);
                    $url    = site_url('video/'.$id);

                    $related[$i]['url']    = $url;
                    $related[$i]['title']  = trim_text($video['title']['$t'], 83);
                    $thumbnailUrl          = preg_replace("/^http:/i", "https:", $video['media$group']['media$thumbnail'][0]['url']);
                    $related[$i]['img']    = $thumbnailUrl;
                    $related[$i]['source'] = 'YouTube';
                    $i++;
                }
            break;
        }

        return $related;
    }
}

/* End of file video.php */
/* Location: ./application/modules/video/controllers/video.php */