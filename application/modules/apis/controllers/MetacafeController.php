<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MetacafeController extends MX_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->library('API/metacafe');

        if (!class_exists('CI_CACHE')) {
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => 'videouri_'));
        }

        #$this->_debug['on'] = true;
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

        /*switch ($parameters['sort']) {
            case 'relevance':
                $parameters['sort'] = 'rating';
                break;

            case 'published':
                $parameters['sort'] = 'updated';
                break;

            case 'views':
                $parameters['sort'] = 'viewCount';
                break;
        }*/

        switch ($parameters['content']) {
            /* Home content */
            case 'newest':
                $result = $this->metacafe->getMostRecentVideoFeed($parameters['period']);
                break;

            case 'top_rated':
                $result = $this->metacafe->getTopRatedVideoFeed($parameters['period']);
                break;

            case 'most_viewed':
                $result = $this->metacafe->getMostViewedVideoFeed($parameters['period']);
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

        if ($parameters['content'] == "getVideoEntry") {
            $result = simplexml_load_string($result);
            $result = $result->channel->item;
            $result['embed'] = $this->metacafe->getEmbedData($parameters['id']);
            return $result;
        }
        
        else {
            return simplexml_load_string($result);
        }
    }

    function related($id)
    {
        $result = $this->metacafe->getRelatedVideos($id);
        return simplexml_load_string($result);
    }
    
}

/* End of file c_metacafe.php */
/* Location: ./application/modules/apis/controllers/c_metacafe.php */