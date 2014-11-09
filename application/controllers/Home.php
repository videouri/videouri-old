<?php defined('BASEPATH') OR exit("No direct script access allowed");

class Home extends MY_Controller {

    /**
     * Default parameters for homepage 
     * 
     * @var array
     */
    private $parameters = [
        'apis'       => ['YouTube', 'Dailymotion'],
        // 'content'    => ['top_rated', 'most_viewed'],
        'content'    => ['most_viewed'],
        'period'     => 'today',
        'maxResults' => 8,
    ];

    public function __construct()
    {
        parent::__construct();
        
        $this->parametersHash = md5(serialize($this->parameters));
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $content = self::runAPIs();

        #$content['apis']      = $this->parameters['apis'];
        $content['canonical'] = '';
        $content['time']      = array(
                                'today'      => 'today',
                                'this week'  => 'week',
                                'this month' => 'month',
                                'ever'       => 'ever'
                            );

        // Choose not to show home page content
        $content['fakeContent'] = false;

        $this->template->body_id = 'home';

        $this->template->home_featured->view('home/featured');
        $this->template->content->view('home/index-4cols', $content);
        $this->template->publish();
    }

    /**
     * Function to process specific request for each API.
     * @return array Content data
     */
    private function runAPIs()
    {
        $this->load->driver('cache');
        $this->load->library('Videouri/ApiProcessing');
        $cache = $this->cache->apc;

        $period = $this->parameters['period'];

        if (! $viewData = $cache->get($this->parametersHash)) {

            ////
            // Here is where, the keys and their values in $this->parameters, 
            // are being asigned to their respective objects in the ApiProcessing class
            ////
            foreach ($this->parameters as $key => $value) {
                $this->apiprocessing->{$key} = $value;
            }

            $apiResults = $this->apiprocessing->interogateApis();
            // dd($apiResults);

            $viewData = array();
            foreach ($apiResults as $content => $contentData) {
                foreach ($contentData as $api => $apiData) {
                    $results = $this->apiprocessing->parseApiResult($api, $apiData, $content);
                    if (!empty($results)) {
                        $viewData['data'][$content][$api] = $results[$content][$api];
                    }
                } // $sortData as $api => $apiData
            } // $api_response as $sortName => $sortData


            // Caching results
            $cache->save($this->parametersHash, $viewData, $this->_periodCachingTime[$period]);
        }

        return $viewData;
    }

}
