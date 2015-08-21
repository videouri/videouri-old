<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DailymotionController extends MX_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->library('API/dailymotion');

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

        $commonFields = array('id', 'duration', 'url', 'title', 'description', 'channel', 'thumbnail_medium_url', 'rating', 'views_total');

        switch ($parameters['content']) {
            /* Home content */
            case 'newest':
                $result = $this->dailymotion->call(
                    '/videos',
                    array(
                        'fields'        => $commonFields,
                        'limit'         => $parameters['maxResults'],
                        'sort'          => "recent",
                        'family_filter' => $this->cookie,
                        // 'country'       => $this->session->userdata('country'),
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
                        'family_filter' => $this->cookie,
                        // 'country'       => $this->session->userdata('country'),
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
                        'family_filter' => $this->cookie,
                        // 'country'       => $this->session->userdata('country'),
                    )
                );
                break;

            /* Search and tags content */
            case 'search':
                $result = $this->dailymotion->call(
                    '/videos',
                    array(
                        'fields'        => $commonFields,
                        'search'        => $parameters['searchQuery'],
                        'page'          => $parameters['page'],
                        'limit'         => $parameters['maxResults'],
                        'sort'          => $parameters['sort'],
                        'family_filter' => $this->cookie,
                        // 'country'       => $this->session->userdata('country'),
                    )
                );
                break;

            case 'tag':
                $result = $this->dailymotion->call(
                    '/videos',
                    array(
                        'fields'        => $commonFields,
                        'tags'          => $parameters['searchQuery'],
                        'page'          => $parameters['page'],
                        'limit'         => $parameters['maxResults'],
                        'sort'          => $parameters['sort'],
                        'family_filter' => $this->cookie,
                        // 'country'       => $this->session->userdata('country'),
                    )
                );
                break;

            /* Video page with video data and related videos */
            case 'getVideoEntry':
                $result = $this->dailymotion->call(
                    '/video/'.$parameters['videoId'],
                    array(
                        'fields' => array_merge($commonFields, array('embed_html', 'channel', 'tags', 'swf_url'))
                    )
                );
                break;

            case 'getRelatedVideos':
                $result = $this->dailymotion->call(
                    '/video/' . $parameters['videoId'] . '/related',
                    array(
                        'fields'        => array('id', 'duration', 'title', 'thumbnail_240_url', 'url'),
                        'family_filter' => $this->cookie
                    )
                );
                break;

            default:
                $result = '';
                break;
        }

        return $result;
    }
}