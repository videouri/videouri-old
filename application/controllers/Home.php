<?php defined('BASEPATH') OR exit("No direct script access allowed");

class Home extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library('Videouri/ApiProcessing');

        /**
         * Default parameters for homepage
         */
        // $this->apiprocessing->apis       = ['YouTube', 'Dailymotion'];
        $this->apiprocessing->apis       = ['YouTube'];
        $this->apiprocessing->content    = ['most_viewed'];
        $this->apiprocessing->period     = 'today';
        $this->apiprocessing->maxResults = 8;
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $content = self::runAPIs();

        $content['apis']      = $this->apiprocessing->apis;
        $content['canonical'] = '';
        $content['time']      = array(
                                'today'      => 'today',
                                'this week'  => 'week',
                                'this month' => 'month',
                                'ever'       => 'ever'
                            );

        // Choose not to show home page content
        $content['fakeContent'] = false;

        $this->template->bodyId = 'home';

        // $this->template->home_featured->view('home/featured');
        $this->template->content->view('home/index-4cols', $content);
        // $this->template->javascript->add('dist/modules/home.js');
        $this->template->publish();
    }

    private function runAPIs()
    {
        $apiResults = $this->apiprocessing->mixedCalls();

        $viewData = array();
        foreach ($apiResults as $content => $contentData) {
            foreach ($contentData as $api => $apiData) {
                $results = $this->apiprocessing->parseApiResult($api, $apiData, $content);
                if (!empty($results)) {
                    if (!isset($viewData['data'][$content])) {
                        $viewData['data'][$content] = $results[$content];
                    } elseif (is_array($viewData['data'][$content])) {
                        $viewData['data'][$content] = array_merge($viewData['data'][$content], $results[$content]);
                    }
                }

                $viewsCount = [];
                // $ratings = [];
                foreach ($viewData['data'][$content] as $k => $v) {
                    $viewsCount[$k] = $v['viewsCount'];
                    // $ratings[$k] = $v['rating'];
                }

                array_multisort($viewsCount, SORT_DESC, $viewData['data'][$content]);
            } // $sortData as $api => $apiData

            // array_multisort($viewData['data'][$content], SORT_DESC, $viewData['data'][$content]);
            // $test = array_filter($viewData['data'][$content], function($v, $k) {
            //     echo('<pre>');
            //     var_dump($k['viewsCount']);
            //     // return strpos($k, 'theme');
            // });
    
        } // $api_response as $sortName => $sortData

        return $viewData;
    }

}
