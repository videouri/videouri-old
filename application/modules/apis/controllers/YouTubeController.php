<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class YouTubeController extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->library('API/youtube');

        if (!class_exists('CI_CACHE')) {
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => 'videouri_'));
        }

        #$this->_debug['on'] = true;
    }

    /**
    * The function that will retrieve YouTube's api response data
    *
    * @param array $parameters containing the data to be sent when querying the api
    * @return the json_decoded or rss response from YouTube.
    */
    public function data($parameters = array())
    {
        $this->page = isset($parameters['page']) ? 1 + ($parameters['page'] - 1) * 10 : 1;

        if ((isset($parameters['sort'])) && ($parameters['sort'] === 'views')) {
            $parameters['sort'] = 'viewCount';
        }

        switch ((isset($parameters['period']) ? $parameters['period'] : '')) {
            case 'today':
                $period = 'today';
                break;
            
            case 'week':
                $period = 'this_week';
                break;

            case 'month':
                $period = 'this_month';
                break;

            case 'ever':
            default:
                $period = 'all_time';
                break;
        }

        if (isset($parameters['query'])) {
            $characters = array("-", "@");
            $query      = str_replace($characters, '', $parameters['query']);

            if (isset($parameters['page'])) {
                $dynamic_variable = "query_{$query}_page{$this->page}";
            }
            else {
                $dynamic_variable = "query_{$query}";
            }
        }

        elseif (isset($parameters['id'])) {
            $dynamic_variable = "video_{$parameters['id']}";
        }

        elseif (isset($parameters['maxResults'])) {
            $dynamic_variable = "{$parameters['maxResults']}_results";
        }

        else {
            $dynamic_variable = "{$parameters['content']}";
        }

        // Get Data from Cache
        $cache_variable = "youtube_{$dynamic_variable}_{$period}_cached";
        $result         = $this->cache->get($cache_variable);

        if ( ! $result) {
            $this->_debug['inside-if'] = 'yes, I\'m inside `if( !$result)` of function data()';

            switch ($parameters['content']) {
                /* Home content */
                case 'newest':
                    $result = json_decode($this->youtube->getMostRecentVideoFeed(
                        array(
                            'max-results' => $parameters['maxResults'],
                            'fields'      => 'entry(id,title,author,gd:rating,yt:rating,yt:statistics,media:group(media:category(),media:description(),media:thumbnail(@url),yt:duration(@seconds)))',
                            'time'        => $period,
                            'alt'         => 'json'
                            )
                        )
                    ,TRUE);
                    break;

                case 'top_rated':
                    $result = json_decode($this->youtube->getTopRatedVideoFeed(
                        array(
                            'max-results' => $parameters['maxResults'],
                            //'fields'       => '*',
                            'fields'      => 'entry(id,published,title,author,gd:rating,yt:rating,yt:statistics,media:group(media:category(),media:description(),media:thumbnail(@url),yt:duration(@seconds)))',
                            'time'        => $period,
                            'alt'         => 'json'
                            )
                        )
                    ,TRUE);
                    break;

                case 'most_viewed':
                    $result= json_decode($this->youtube->getMostPopularVideoFeed(
                        array(
                            'max-results' => $parameters['maxResults'],
                            'fields'      => "entry(id,published,title,author,gd:rating,yt:rating,yt:statistics,media:group(media:category(),media:description(),media:thumbnail(@url),yt:duration(@seconds)))",
                            'time'        => $period,
                            'alt'         => 'json'
                            )
                        )
                    ,TRUE);
                    break;

                /* Search and tags content */
                case 'search':
                    $result = json_decode($this->youtube->getKeywordVideoFeed(
                        $query,
                        array(
                            'max-results' => $parameters['maxResults'],
                            'start-index' => $this->page,
                            'orderby'     => $parameters['sort'],
                            'fields'      => "entry(id,title,author,gd:rating,yt:rating,yt:statistics,media:group(media:category(),media:thumbnail(@url),yt:duration(@seconds)))",
                            'alt'         => 'json'
                            )
                        )
                    ,TRUE);
                    break;

                case 'tag':
                    $tag = json_decode($this->youtube->getKeywordVideoFeed(
                        $query,
                        array(
                            'max-results' => $parameters['maxResults'],
                            'start-index' => $this->page,
                            'orderby'     => $parameters['sort'],
                            'fields'      => "entry(id,title,media:group(media:category(),media:thumbnail(@url),yt:duration(@seconds)))",
                            'alt'         => 'json'
                            )
                        )
                    ,TRUE);
                    break;

                /* Video page with video data and related videos */
                case 'getVideoEntry':
                    $result = $this->youtube->getVideoEntry($parameters['id'], false, array('alt'=>'rss'));
                    break;
            }
            
            $this->cache->save($cache_variable, $result, $this->cache_timeout);

        }

        #dd($result);

        if ($this->_debug['on']) {
            $this->_debug['cache-name']   = "youtube_{$dynamic_variable}_cached";
            $this->_debug['dynamic-name'] = $dynamic_variable;
            $this->_debug['time-out']     = $this->cache_timeout;
            $this->_debug['cache']        = apc_fetch("youtube_{$dynamic_variable}_cached");

            prePrint($this->_debug);
            exit;
        }

        else {
            if ($parameters['content'] === "getVideoEntry")
                return simplexml_load_string($result);
            else
                return $result;
        }
    }

    function related($id)
    {
        // Get Data from Cache
        $result = $this->cache->get("youtube_relatedTo-{$id}_cached");

        if ( ! $result) {

            $this->_debug['inside-if'] = ' yes, I\'m inside `if( !$result)` of function related() ';

            $result =   json_decode($this->youtube->getRelatedVideoFeed(
                            $id,
                            array(
                                'max-results' => $parameters['maxResults'],
                                'start-index' => $this->page,
                                'fields'      => "entry(id,title,media:group(media:thumbnail(@url),yt:duration(@seconds)))",
                                'alt'         => 'json'
                            )
                        ), TRUE);

            $this->cache->save("youtube_relatedTo-{$id}_cached", $result, $this->cache_timeout);

        }

        if ($this->_debug['on']) {

            $this->_debug['cache-name']   = "youtube_{$dynamic_variable}_cached";
            $this->_debug['dynamic-name'] = $dynamic_variable;
            $this->_debug['time-out']     = $this->cache_timeout;
            $this->_debug['cache']        = apc_fetch("youtube_{$dynamic_variable}_cached");

            prePrint($this->_debug);
            exit;

        } else {
            return $result;
        }

    }

}

/* End of file c_youtube.php */
/* Location: ./application/modules/apis/controllers/c_youtube.php */