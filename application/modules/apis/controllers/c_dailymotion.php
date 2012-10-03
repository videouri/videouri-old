<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Dailymotion extends MX_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('caching');
        $this->load->library('API/dailymotion');

        $this->_debug['on']  = false;
        $this->cache_timeout = $this->config->item('cache_timeout');
        
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
        if(isset($parameters['sort'])) {

            switch($parameters['sort'])
            {
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


        switch($parameters['period'])
        {
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

        if(isset($parameters['query']))
        {
            $query = $parameters['query'];
            if(isset($parameters['page']))
            {
                $dynamic_variable = "query_{$query}_page{$parameters['page']}";
            }
            else
            {
                $dynamic_variable = "query_{$query}";
            }

        }
        elseif(isset($parameters['id']))
        {
            $id = $parameters['id'];
            $dynamic_variable = "video_{$id}";

        } else {

            $dynamic_variable = "{$parameters['content']}";

        }

        // Get Data from Cache
        $cache_variable = "dailymotion_".$dynamic_variable."_cached";
        $result = $this->caching->get($cache_variable);

        if ( ! $result) {

            $this->_debug['inside-if'] = 'yes, I\'m inside';

            switch ($parameters['content'])
            {
                /* Home content */
                case 'newest':
                    $result = $this->dailymotion->call(
                        '/videos',
                        array(
                            'fields'        => array('id', 'duration', 'url', 'title', 'description', 'thumbnail_medium_url'),
                            'limit'         => 10,
                            'sort'          => "recent",
                            'family_filter' => $this->cookie
                        )
                    );
                break;
                case 'top_rated':
                    $result = $this->dailymotion->call(
                        '/videos',
                        array(
                            'fields'        => array('id', 'duration', 'url', 'title', 'description', 'thumbnail_medium_url'),
                            'limit'         => 10,
                            'sort'          => "rated{$period}",
                            'family_filter' => $this->cookie
                        )
                    );
                break;
                case 'most_viewed':
                    $result = $this->dailymotion->call(
                        '/videos',
                        array(
                            'fields'        => array('id', 'duration', 'url', 'title', 'description', 'thumbnail_medium_url'),
                            'limit'         => 10,
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
                            'fields'        => array('id', 'duration', 'title', 'thumbnail_medium_url', 'url'),
                            'search'        => $parameters['query'],
                            'page'          => $parameters['page'],
                            'limit'         => 10,
                            'sort'          => $parameters['sort'],
                            'family_filter' => $this->cookie
                        )
                    );

                break;
                case 'tag':
                    $result = $this->dailymotion->call(
                        '/videos',
                        array(
                            'fields'        => array('id', 'duration', 'title', 'thumbnail_medium_url', 'url'),
                            'tags'          => $parameters['query'], 
                            'page'          => $parameters['page'],
                            'limit'         => 10,
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
                            'fields' => array('title', 'description', 'embed_html', 'channel', 'tags', 'swf_url', 'thumbnail_medium_url')
                        )
                    );
                break;

            }

            $this->caching->save($cache_variable, $result, $this->cache_timeout);

        }

        if($this->_debug['on']) {

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
        $result = $this->caching->get("dailymotion_relatedTo-{$id}_cached");

        if( ! $result) {

            $this->_debug['inside-if'] = ' yes, I\'m inside `if( !$result)` of function related() ';

            $result = $this->dailymotion->call(
                "/video/{$id}/related",
                array(
                    'fields'        => array('id', 'duration', 'title', 'thumbnail_small_url', 'url'),
                    'family_filter' => $this->cookie
                )
            );

            $this->caching->save("dailymotion_relatedTo-{$id}_cached", $result, $this->cache_timeout);
        }

        if($this->_debug['on']) {

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