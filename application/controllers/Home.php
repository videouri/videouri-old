<?php defined('BASEPATH') OR exit("No direct script access allowed");

class Home extends MX_Controller {

    public function index()
    {
        $this->load->library('Videouri/ApiProcessing');

        //$this->period = $this->input->post('time', true);

        $this->apiprocessing->apis       = ['YouTube', 'Dailymotion', 'Metacafe'];
        $this->apiprocessing->content    = ['top_rated', 'most_viewed'];
        $this->apiprocessing->period     = 'month';
        $this->apiprocessing->maxResults = 4;

        $apiResults = $this->apiprocessing->interogateApis();

        $data = array();
        foreach ($apiResults as $content => $contentData) {
            foreach ($contentData as $api => $apiData) {
                $results = $this->apiprocessing->parseApiResult($api, $apiData, $content);
                if (!empty($results)) {
                    $data['data'][$content][$api] = $results[$content][$api];
                }
            } // $sortData as $api => $apiData
        } // $api_response as $sortName => $sortData

        $data['apis']      = $this->apiprocessing->apis;
        $data['canonical'] = '';
        $data['time']      = array(
                                'today'      => 'today',
                                'this week'  => 'week',
                                'this month' => 'month',
                                'ever'       => 'ever'
                            );

        $this->template->body_id = 'home';
        $this->template->home_featured->view('home/featured');
        $this->template->content->view('home/index', $data);
        $this->template->publish();
    }

}
