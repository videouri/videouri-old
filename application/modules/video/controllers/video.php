<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends MX_Controller
{

    var $apis = array(
                'dailymotion',
                'metacafe',
                'vimeo',
                'youtube'
            );

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('error');
    }

    /**
    * This function will retrieve the video's data according to its id
    *
    * @param string $id The id for which to look for data
    * @return the php response from parsing the data.
    */
    public function id($custom_id, $extra = NULL)
    {

        $api = substr($custom_id,1,1);
        $id  = substr_replace($custom_id, '', 1, 1);

        switch ($api)
        {
            case 'd':
                $api = 'dailymotion';
            break;
            case 'v':
                $api = 'vimeo';
            break;
            case 'y':
                $api = 'youtube';
            break;
            case 'M':
                $api = 'metacafe';
                $long_id  = $id.'/'.$extra;
            break;
            default:
                show_error(lang('video_id',$custom_id));
            break;
        }

        $parameters = array(
                        'action' => 'getVideoEntry',
                        'api'    => $api,
                        'id'     => ($api=="metacafe") ? $long_id : $id
                    );

        $data['api']           = $api;
        $data['custom_id']     = $custom_id;

        try
        {
            $result = modules::run("apis/c_$api/data", $parameters);
            #if(!$result){ throw new Exception("Video deleted or censored", 404); }
        }
        catch(ParameterException $e)
        {
            //prePrint($e);
            //show_error($e->getMessage());
        }
        catch(Exception $e)
        {
            #prePrint($e);
            $code = $e->getCode() ? $e->getCode() : 404;
            //prePrint($e);
            show_error($e->getMessage(),$code);
        }

        if ($api == "dailymotion")
        {
            $data['data']['swf']['url']  = $result['swf_url'].'&enableApi=1&playerapiid=dmplayer';
            $data['data']['swf']['api']  = 'dmapiplayer';
            $data['data']['title']       = $result['title'];
            $data['data']['description'] = $result['description'];
            $data['data']['img']         = $result['thumbnail_medium_url'];
            $data['canonical']   = "video/$custom_id";
            $data['data']['tags']        = $result['tags'];
            $data['data']['related']     = $this->_relatedVideos(array('api'=>$api,'id'=>$id));
        }
        elseif ($api == "metacafe")
        {
            $data['data']['title']      = $result->title;
            if(preg_match('/http:\/\/[w\.]*metacafe\.com\/fplayer\/(.*).swf/is', $result['embed'], $match))
            {
                $data['data']['swf']['url'] = $result['embed'];
                $data['data']['swf']['api'] = 'mcapiplayer';
            }
            else
            {
                $data['data']['embed_html'] = $result['embed'];
            }
            $data['data']['img']         = 'http://www.metacafe.com/thumb/'.$id.'.jpg';

            $dom = new DOMDocument();
            $dom->loadHTML($result->description);
            $xml = simplexml_import_dom($dom);
            $p = (string)$xml->body->p;
            $data['data']['description'] = strstr($p, 'Ranked', true);

            $tags = array();
            for ($i=2;$i<=count((object)$xml->body->p[1]->a)-2;$i++)
            {
                $tag = (object)$xml->body->p[1]->a[$i];
                $tag = str_replace(array('News & Events'), '', $tag);
                $tags[] = $tag;
            }
            $data['canonical']   = "video/$long_id";
            $data['data']['tags']        = $tags;
            $data['data']['related']     = $this->_relatedVideos(array('api'=>$api,'id'=>$id));
        }
        elseif ($api == "vimeo")
        {
            #$data['data']['embed_html']  = html_entity_decode($result['videoCode']->html);
            $data['data']['swf']['url']  = "http://vimeo.com/moogaloop.swf?clip_id=".$id."&amp;server=vimeo.com&amp;color=00adef&amp;fullscreen=1&amp;autoplay=1";
            $data['data']['swf']['api']  = "vmapiplayer";
            $data['data']['title']       = $result->video[0]->title;
            $data['data']['description'] = $result->video[0]->description;
            $tags = array();
            if(!empty($result->video[0]->tags))
            {
                foreach($result->video[0]->tags->tag as $tag)
                {
                    $content = '_content';
                    $tags[] = $tag->$content;
                }
            }
            $data['data']['img']         = $result->video[0]->thumbnails->thumbnail[1]->_content;
            $data['canonical']           = "video/$custom_id";
            $data['data']['tags']        = $tags;
            #$data['data']['related']     = $this->_relatedVideos(null, array('api'=>$api,'tags'=>$data['data']['tags']));
        }
        elseif ($api == "youtube")
        {
            exit(preDump($result));
            #$data['data']['embed_html']  = $result['videoCode'];
            $data['data']['swf']['url']  = "http://www.youtube.com/v/".$id."?enablejsapi=1&playerapiid=ytplayer&version=3";
            $data['data']['swf']['api']  = "ytapiplayer";
            $data['data']['title']       = $result->title;
            $data['data']['description'] = $result->description;
            
            $tags = array();
            for($i=1;$i<=count($result->category);$i++)
            {
                $tags[] = $result->category[$i];
            }

            $data['data']['img']       = 'http://i.ytimg.com/vi/'.$id.'/0.jpg';
            $data['canonical']         = "video/$custom_id";
            $data['data']['tags']      = $tags;
            $data['data']['related']   = $this->_relatedVideos(array('api'=>$api,'id'=>$id));
        }

        $debug = $this->config->item('debug');
        if($debug['return_complete']===TRUE)
        {
            $data['data']['complete']   = $result;
            if($debug['print_complete']===TRUE)
            {
                prePrint($data['data']['complete']);
            }
        }

        $this->template->content->view('videoPage', $data);
        $this->template->publish();
    }



    /**
    * This function will retrieve related videos according to its id or some of its tags
    *
    * @param string $id The id for which to look for data
    * @return the php response from parsing the data.
    */
    private function _relatedVideos($parameters = array(), $tags = array())
    {
        if(!empty($parameters))
        {
            $id = $parameters['id'];
            $relatedVideos[$parameters['api']] = modules::run('apis/c_'.$parameters['api'].'/related', $id);
            switch ($parameters['api'])
            {
                case 'dailymotion':
                    $i = 0;
                    foreach ($relatedVideos['dailymotion']['list'] as $video)
                    {
                        preg_match('@video/([^_]+)_([^/]+)@', $video['url'], $match);
                        $url = $match[1].'/'.$match[2];
                        $url = site_url('video/'.substr($url,0,1).'d'.substr($url,1));

                        $related['dailymotion'][$i]['url']   = $url;
                        $related['dailymotion'][$i]['title'] = $video['title'];
                        $related['dailymotion'][$i]['img']   = $video['thumbnail_small_url'];
                        $i++;
                    }
                break;
                case "metacafe":
                    $i = 0;
                    foreach ($relatedVideos['metacafe']->channel->item as $video)
                    {
                        preg_match('/http:\/\/[w\.]*metacafe\.com\/watch\/([^?&#"\']*)/is', $video->link, $match);
                        $id  = substr($match[1],0,-1);
                        $url = site_url('video/'.substr($id,0,1).'M'.substr($id,1));

                        $related['metacafe'][$i]['url']   = $url;
                        $related['metacafe'][$i]['title'] = trim_text($video->title, 83);
                        $related['metacafe'][$i]['img']   = "http://www.metacafe.com/thumb/$video->id.jpg";
                        $i++;
                    }
                break;
                case "vimeo":
                    $i = 0;
                    foreach ($related['vimeo']->videos->video as $video)
                    {
                        $id  = substr($video->id,0,1).'v'.substr($video->id,1);
                        $url = site_url('video/'.$id);

                        $related['vimeo'][$i]['url']   = $url;
                        $related['vimeo'][$i]['title'] = trim_text($video->title, 83);
                        $related['vimeo'][$i]['img']   = $video->thumbnails->thumbnail[1]->_content;
                        $i++;
                    }
                break;
                case 'youtube':
                    $i = 0;
                    foreach ($relatedVideos['youtube']['feed']['entry'] as $video)
                    {
                        $origid = substr( $video['id']['$t'], strrpos( $video['id']['$t'], '/' )+1 );
                        $id     = substr($origid,0,1).'y'.substr($origid,1);
                        $url    = site_url('video/'.$id);

                        $related['youtube'][$i]['url']   = $url;
                        $related['youtube'][$i]['title'] = trim_text($video['title']['$t'], 83);
                        $related['youtube'][$i]['img']   = $video['media$group']['media$thumbnail'][0]['url'];
                        $i++;
                    }
                break;
            }
            return $related;
        }
        if(!empty($tags['tags']))
        {
            $parameters['api'] = $tags['api'];
            $parameters['action'] = 'tag';
            $vt = array();
            $i = 0;

            foreach($tags['tags'] as $tag)
            {
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
                    $parameters['query'] = $tag;
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