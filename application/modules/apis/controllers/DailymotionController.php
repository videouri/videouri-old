<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class DailymotionController extends MX_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->library('API/dailymotion');

        if (!class_exists('CI_CACHE')) {
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => 'videouri_'));
        }

        #$this->_debug['on'] = true;

        $this->cookie = ($this->input->cookie('ff') == "off" ? false : true);
    }

    /**
    * The function that interacts with Dailymotion API Library to retrieve data
    *
    * @param array $parameters containing the data to be sent when querying the api
    * @return the json_decoded array data.
    */
    function data($parameters = array())
    {
        if (isset($parameters['sort'])) {
            switch($parameters['sort']) {
                case 'published':
                    $parameters['sort'] = 'recent';
                break;
                case 'views':
                    $parameters['sort'] = 'visited';
                break;
                case 'rating':
                    $parameters['sort'] = 'rated';
                break;
            }
        }

        switch ($parameters['period']) {
            case 'today':
                $period = '-today';
                break;
            
            case 'week':
                $period = '-week';
                break;

            case 'month':
                $period = '-month';
                break;

            case 'ever':
            default:
                $period = '';
                break;
        }

        if (isset($parameters['query'])) {
            if (isset($parameters['page'])) {
                $dynamic_variable = "query_{$parameters['query']}_page{$parameters['page']}";
            } else {
                $dynamic_variable = "query_{$parameters['query']}";
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
        if (!empty($period)) {
            $varPeriod = substr($period, 1);
            $cache_variable = "dailymotion_{$dynamic_variable}_{$varPeriod}_cached";
        } else {
            $cache_variable = "dailymotion_{$dynamic_variable}_cached";
        }

        #$result = $this->cache->get($cache_variable);
        $result = null;
        
        $commonFields = array('id', 'duration', 'url', 'title', 'description', 'thumbnail_medium_url', 'rating', 'views_total');

        if ( ! $result) {
            $this->_debug['inside-if'] = 'yes, I\'m inside';

            switch ($parameters['content']) {
                /* Home content */
                case 'newest':
                    $result = $this->dailymotion->call(
                        '/videos',
                        array(
                            'fields'        => $commonFields,
                            'limit'         => $parameters['maxResults'],
                            'sort'          => "recent",
                            'family_filter' => $this->cookie
                        )
                    );
                    break;

                case 'top_rated':
                    $result = $this->dailymotion->call(
                        '/videos',
                        array(
                            'fields'        => $commonFields,
                            'limit'         => $parameters['maxResults'],
                            'sort'          => "rated{$period}",
                            'family_filter' => $this->cookie
                        )
                    );
                    break;

                case 'most_viewed':
                    $result = $this->dailymotion->call(
                        '/videos',
                        array(
                            'fields'        => $commonFields,
                            'limit'         => $parameters['maxResults'],
                            'sort'          => "visited{$period}",
                            'family_filter' => $this->cookie
                        )
                    );
                    break;

                /* Search and tags content */
                case 'search':
                    $result = $this->dailymotion->call(
                        '/videos',
                        array(
                            'fields'        => $commonFields,
                            'search'        => $parameters['query'],
                            'page'          => $parameters['page'],
                            'limit'         => $parameters['maxResults'],
                            'sort'          => $parameters['sort'],
                            'family_filter' => $this->cookie
                        )
                    );
                    break;
                
                case 'tag':
                    $result = $this->dailymotion->call(
                        '/videos',
                        array(
                            'fields'        => $commonFields,
                            'tags'          => $parameters['query'], 
                            'page'          => $parameters['page'],
                            'limit'         => $parameters['maxResults'],
                            'sort'          => $parameters['sort'],
                            'family_filter' => $this->cookie
                        )
                    );
                    break;

                /* Video page with video data and related videos */
                case 'getVideoEntry':
                    $result = $this->dailymotion->call(
                        '/video/'.$id,
                        array(
                            'fields' => array_merge($commonFields, array('embed_html', 'channel', 'tags', 'swf_url'))
                        )
                    );
                    break;

                default:
                    $result = '';
                    break;
            }

            #$this->cache->save($cache_variable, $result, $this->cache_timeout);
        }
        
        if ($this->_debug['on']) {

            $this->_debug['cache-name']   = "dailymotion_{$dynamic_variable}_cached";
            $this->_debug['dynamic-name'] = $dynamic_variable;
            $this->_debug['time-out']     = $this->cache_timeout;
            $this->_debug['cache']        = apc_fetch("dailymotion_{$dynamic_variable}_cached");
            
            prePrint($this->_debug);
            exit;

        } else {
            return $result;
        }
        
    }

    function related($id)
    {
        // Get Data from Cache
        $result = $this->cache->get("dailymotion_relatedTo-{$id}_cached");

        if ( ! $result) {

            $this->_debug['inside-if'] = ' yes, I\'m inside `if ( !$result)` of function related() ';

            $result = $this->dailymotion->call(
                "/video/{$id}/related",
                array(
                    'fields'        => array('id', 'duration', 'title', 'thumbnail_small_url', 'url'),
                    'family_filter' => $this->cookie
                )
            );

            $this->cache->save("dailymotion_relatedTo-{$id}_cached", $result, $this->cache_timeout);
        }

        if ($this->_debug['on']) {

            $this->_debug['cache-name']   = "dailymotion_{$dynamic_variable}_cached";
            $this->_debug['dynamic-name'] = $dynamic_variable;
            $this->_debug['time-out']     = $this->cache_timeout;
            $this->_debug['cache']        = apc_fetch("dailymotion_{$dynamic_variable}_cached");
            
            prePrint($this->_debug);
            exit;

        } else {
            return $result;
        }

    }
}

/* End of file c_dailymotion.php */
/* Location: ./application/modules/apis/controllers/c_dailymotion.php */