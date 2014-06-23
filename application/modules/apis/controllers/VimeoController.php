<?php defined('BASEPATH') OR exit('No direct script access allowed');

class VimeoController extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->load->library('API/vimeo');

        if (!class_exists('CI_CACHE')) {
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => 'videouri_'));
        }

        #$this->_debug['on'] = true;
    }

    /**
    * The function that interacts with Vimeo API Library to retrieve data
    *
    * @param array $parameters containing the data to be sent when querying the api
    * @return the json_decoded array data.
    */
    function data(array $parameters = array())
    {
        $this->vimeo->enableCache(Vimeo::CACHE_FILE, APPPATH.'cache', $this->cache_timeout);
        
        if (isset($parameters['sort'])) {

            switch($parameters['sort']) {
                case 'relevance':
                    $sort = 'relevant';
                    break;

                case 'published':
                    $sort = 'newest';
                    break;

                case 'views':
                    $sort = 'most_played';
                    break;

                case 'rating':
                    $sort = 'most_liked';
                    break;
            }

        }

        if (isset($parameters['query'])) {
            
            $query = $parameters['query'];
            if (isset($parameters['page'])) {
                $dynamic_variable = "query_{$query}_page{$parameters['page']}";
            } else {
                $dynamic_variable = "query_{$query}";
            }

        } elseif (isset($parameters['id'])) {
            $dynamic_variable = "video_{$id}";
        }

        elseif (isset($parameters['maxResults'])) {
            $dynamic_variable = "{$parameters['maxResults']}_results}";
        }

        else {
            $dynamic_variable = "{$parameters['content']}";
        }

        // Get Data from Cache
        $cache_variable = "vimeo_{$dynamic_variable}_cached";
        $result         = $this->cache->get($cache_variable);

        if ( ! $result)
        {            
            $this->_debug['inside-if'] = 'yes, I\'m inside';

            switch ($parameters['content']) {
                /* Search and tags content */
                case 'search':
                    $result = $this->vimeo->call('videos.search', array('full_response' => TRUE, 'page' => $parameters['page'], 'per_page' => 10, 'sort' => $sort, 'query' => $parameters['query']));
                    break;

                case 'tag':
                    $result = $this->vimeo->call('videos.getByTag', array('full_response' => TRUE, 'page' => $parameters['page'], 'per_page' => 10, 'sort' => $sort, 'tag' => $parameters['query']));
                    break;

                /* Video page with video data and related videos */
                case 'getVideoEntry':
                    $result = $this->vimeo->call('videos.getInfo', array('video_id' => $id));

                    /*$video_url           = 'http://vimeo.com/'.$id;
                    $json_url            = 'http://vimeo.com/api/oembed.json?url=' . rawurlencode($video_url) . '&width=640';
                    $vimeo_data['videoCode'] =   json_decode(curl_get($json_url));*/
                    break;

                case 'related':
                    $result = $this->vimeo->call('videos.getByTag', array('full_response' => TRUE, 'page' => $parameters['page'], 'per_page' => 20, 'sort' => $sort, 'tag' => $parameters['query']));
                    break;
            }

            $this->cache->save($cache_variable, $result, $this->cache_timeout);

        }

        if ($this->_debug['on']) {
            
            $this->_debug['cache-name']   = "vimeo_{$dynamic_variable}_cached";
            $this->_debug['dynamic-name'] = $dynamic_variable;
            $this->_debug['time-out']     = $this->cache_timeout;
            $this->_debug['cache']        = apc_fetch("vimeo_{$dynamic_variable}_cached");

            prePrint($this->_debug);
            exit;
        }

        else {
            return $result;
        }

    }

}

/* End of file c_vimeo.php */
/* Location: ./application/modules/apis/controllers/c_vimeo.php */