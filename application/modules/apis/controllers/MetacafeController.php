<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MetacafeController extends MX_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->library('API/metacafe');

        $this->_debug['on']  = false;
        $this->cache_timeout = $this->config->item('cache_timeout');
    }

    /**
    * The function that interacts with Metacafe API Library to retrieve data
    *
    * @param array $parameters containing the data to be sent when querying the api
    * @return the json_decoded array data.
    */
	function data(array $parameters = array())
    {
        $page = isset($parameters['page']) ? 1 + ($parameters['page']-1) * 10 : 1;

        switch($parameters['sort'])
        {
            case 'relevance':
                $parameters['sort'] = 'rating';
            break;
            case 'published':
                $parameters['sort'] = 'updated';
            break;
            case 'views':
                $parameters['sort'] = 'viewCount';
            break;
        }

        if(isset($parameters['query']))
        {
            $query = $parameters['query'];
            if(isset($parameters['page']))
            {
                $dynamic_variable = "query_{$query}_page{$page}";
            }
            else
            {
                $dynamic_variable = "query_{$query}";
            }
        }
        elseif(isset($parameters['id']))
        {
            $id = explode('/', $parameters['id']);
            $dynamic_variable = "video_{$id['0']}";

        }
        else
        {
            $dynamic_variable = "{$parameters['content']}";
        }

        // Get Data from Cache
        $cache_variable = "metacafe_".$dynamic_variable."_cached";
        $result = $this->cache->get($cache_variable);
        
        if( ! $result)
        {
            $this->_debug['inside-if'] = 'yes, I\'m inside';

            switch ($parameters['content'])
            {
                /* Home content */
                case 'newest':
                    $result = $this->metacafe->getMostRecentVideoFeed();
                break;
                case 'top_rated':
                    $result = $this->metacafe->getTopRatedVideoFeed();
                break;
                case 'most_viewed':
                    $result = $this->metacafe->getMostViewedVideoFeed();
                break;

                /* Search and tags content */
                case 'search':
                    $result = $this->metacafe->getKeywordVideoFeed($parameters['query'], array('start-index'=>$page, 'max-results' => 10));
                break;
                case 'tag':
                    $result = $this->metacafe->getTagVideosFeed($parameters['query']);
                break;

                /* Video page with data and related videos */
                case 'getVideoEntry':
                    $result = $this->metacafe->getItemData($id[0]);
                break;
            }

        }


        if($this->_debug['on']=='data')
        {
            $this->_debug['cache-name']   = $cache_variable;
            $this->_debug['dynamic-name'] = $dynamic_variable;
            $this->_debug['time-out']     = $this->cache_timeout;
            $this->_debug['cache']        = apc_fetch($cache_variable);

            prePrint($this->_debug);
            exit;
        }
        else
        {
            $this->cache->save($cache_variable, $result, $this->cache_timeout);

            if ($parameters['content'] == "getVideoEntry")
            {
                $result = simplexml_load_string($result);
                $result = $result->channel->item;
                $result['embed'] = $this->metacafe->getEmbedData($parameters['id']);
                return $result;
            }
            else
            {
                return simplexml_load_string($result);
            }

        }

    }

    function related($id)
    {
        // Get Data from Cache
        $result = $this->cache->get("metacafe_relatedTo-{$id}_cached");

        if ( ! $result)
        {
            $this->_debug['inside-if'] = ' yes, I\'m inside `if( ! $result)` of function related() ';
            $result = $this->metacafe->getRelatedVideos($id);
        }

        if($this->_debug['on']=='related')
        {
            $this->_debug['cache-name'] = "metacafe_relatedTo-{$id}_cached";
            $this->_debug['related-to'] = $id;
            $this->_debug['time-out']   = $this->cache_timeout;
            $this->_debug['cache']      = apc_fetch("metacafe_relatedTo-{$id}_cached");

            prePrint($this->_debug);
            exit;
        }
        else
        {
            $this->cache->save("metacafe_relatedTo-{$id}_cached", $result, $this->cache_timeout);
            return simplexml_load_string($result);
        }

    }
    
}

/* End of file c_metacafe.php */
/* Location: ./application/modules/apis/controllers/c_metacafe.php */