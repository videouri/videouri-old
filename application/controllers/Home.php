<?php defined('BASEPATH') OR exit("No direct script access allowed");

class Home extends MX_Controller {

    function __construct()
    {
    }

    public function index()
    {
        //$this->period = $this->input->post('time', true);

        #$this->apiprocessing->apis       = ['YouTube', 'Dailymotion', 'Metacafe'];
        $parameters = [
            'apis'       => ['YouTube', 'Dailymotion'],
            'content'    => ['top_rated', 'most_viewed'],
            'period'     => 'month',
            'maxResults' => 4,
        ];

        $data = self::runAPIs($parameters);

        $data['apis']      = $parameters['apis'];
        $data['canonical'] = '';
        $data['time']      = array(
                                'today'      => 'today',
                                'this week'  => 'week',
                                'this month' => 'month',
                                'ever'       => 'ever'
                            );

        $this->template->body_id = 'home';
        $this->template->home_featured->view('home/featured');
        $this->template->content->view('home/index-4cols', $data);
        $this->template->publish();
    }

    private function defaultData()
    {
        $this->load->helper('file');

        $this->load->driver('cache');
        $cache = $this->cache->file;

        if ($defaultData = $cache->get('defaultData')) {
            $apiResults = $defaultData;
        } else {

            $apisResults = self::runAPIs($parameters);
            $cache->save('defaultData', $apiResults, 86400);
        }

        return $apiResults;
    }

    private function runAPIs(array $parameters)
    {
        $this->load->driver('cache');
        $this->load->library('Videouri/ApiProcessing');
        $cache = $this->cache->file;

        if ($defaultData = $cache->get('defaultData')) {
            $apiResults = $defaultData;
        } else {
            foreach ($parameters as $key => $value) {
                $this->apiprocessing->{$key} = $value;
            }

            $apiResults = $this->apiprocessing->interogateApis();
            
            // Caching time
            $cache->save('defaultData', $apiResults, 86400);
        }

        $viewData = array();
        foreach ($apiResults as $content => $contentData) {
            foreach ($contentData as $api => $apiData) {
                $results = $this->apiprocessing->parseApiResult($api, $apiData, $content);
                if (!empty($results)) {
                    $viewData['data'][$content][$api] = $results[$content][$api];
                }
            } // $sortData as $api => $apiData
        } // $api_response as $sortName => $sortData

        return $viewData;
    }

}
