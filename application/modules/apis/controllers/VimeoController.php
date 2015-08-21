<?php defined('BASEPATH') OR exit('No direct script access allowed');

class VimeoController extends MX_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->library('API/vimeo');

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

        switch ($parameters['content'])
        {
            /* Search and tags content */
            case 'search':
                $result = $this->vimeo->request('/videos', [
                    'page'     => $parameters['page'],
                    'per_page' => $parameters['maxResults'],
                    'sort'     => $sort,
                    'query'    => $parameters['searchQuery']
                ]);
                break;

            case 'tag':
                $result = $this->vimeo->request('/videos/getByTag', [
                    'page'     => $parameters['page'],
                    'per_page' => $parameters['maxResults'],
                    'sort'     => $sort,
                    'tag'      => $parameters['searchQuery']
                ]);
                break;

            /* Video page with video data and related videos */
            case 'getVideoEntry':
                $result = $this->vimeo->request("/videos/{$parameters['videoId']}");
                break;

            case 'getRelatedVideos':
                $result = $this->vimeo->request("/videos/{$parameters['videoId']}/videos", [
                    'page'     => $parameters['page'],
                    'per_page' => $parameters['maxResults'],
                    'filter'   => 'related',
                ]);
                break;

        }

        return $result;
    }
}