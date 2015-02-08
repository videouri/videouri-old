<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class YouTubeController extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->library('API/youtube');

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

        switch ($parameters['content']) {
            /* Home content */
            case 'newest':
                $result = json_decode($this->youtube->getMostRecentVideoFeed(
                    array(
                        'max-results' => $parameters['maxResults'],
                        'fields'      => 'entry(id,title,author,gd:rating,yt:rating,yt:statistics,media:group(media:category(),media:description(),media:thumbnail(@url),yt:duration(@seconds)))',
                        'time'        => $period,
                        'alt'         => 'json',
                        'region'      => $this->session->userdata('country'),
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
                        'alt'         => 'json',
                        'region'      => $this->session->userdata('country'),
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
                        'alt'         => 'json',
                        'region'      => $this->session->userdata('country'),
                        )
                    )
                ,TRUE);
                break;

            /* Search and tags content */
            case 'search':
                $result = json_decode($this->youtube->getKeywordVideoFeed(
                    $parameters['searchQuery'],
                    array(
                        'max-results' => $parameters['maxResults'],
                        'start-index' => $this->page,
                        'orderby'     => $parameters['sort'],
                        'fields'      => "entry(id,title,author,gd:rating,yt:rating,yt:statistics,media:group(media:category(),media:description(),media:thumbnail(@url),yt:duration(@seconds)))",
                        'alt'         => 'json',
                        'region'      => $this->session->userdata('country'),
                        )
                    )
                ,TRUE);
                break;

            case 'tag':
                $tag = json_decode($this->youtube->getKeywordVideoFeed(
                    $parameters['searchQuery'],
                    array(
                        'max-results' => $parameters['maxResults'],
                        'start-index' => $this->page,
                        'orderby'     => $parameters['sort'],
                        'fields'      => "entry(id,title,author,gd:rating,yt:rating,yt:statistics,media:group(media:category(),media:description(),media:thumbnail(@url),yt:duration(@seconds)))",
                        'alt'         => 'json'
                        )
                    )
                ,TRUE);
                break;

            /* Video page with video data and related videos */
            case 'getVideoEntry':
                $result = $this->youtube->getVideoEntry($parameters['videoId'], false, array('alt' => 'json'));
                break;

            case 'getRelatedVideos':
                $result = json_decode($this->youtube->getRelatedVideoFeed(
                                $parameters['videoId'],
                                array(
                                    'max-results' => $parameters['maxResults'],
                                    'start-index' => $this->page,
                                    'fields'      => "entry(id,title,media:group(media:thumbnail(@url),yt:duration(@seconds)))",
                                    'alt'         => 'json'
                                )
                            ), TRUE);
                break;

        }

        #dd($result);

        return $result;
    }

}

/* End of file c_youtube.php */
/* Location: ./application/modules/apis/controllers/c_youtube.php */