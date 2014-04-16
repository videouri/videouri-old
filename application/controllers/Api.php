<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Ajax API handling operations
 *
 */

class Api extends MX_Controller
{
    /**
     * Override construct()
     *
     * @access public
     */
    public function __construct()
    {
        if ($_SERVER['SERVER_ADDR'] !== $_SERVER['REMOTE_ADDR']) {
            exit('Bad boy....');
        }

        parent::__construct();

        $this->load->library(array('response', 'Videouri/ApiProcessing'));
    }

    /**
     * Method to retrieve specific video data
     *
     * @access public
     * @param  string $id Video ID
     * @return JSON
    */
    public function getVideo($id)
    {
        if ($this->input->is_ajax_request()) {
            
            // Mock up Ajax request to load data from model
            // Configure this to your liking
            $id = $_POST['id'];
            if ($id != null) {
                
                // Query and/or process here
                //$this->load->model('example_model');
                //$data = $this->example_model->get($id);

                // just example data to show we are making connection. delete
                $data = array('success' => 'true');
            }

            // Error fallback
            if (empty($data)) {
                $data = array('success' => 'false');
            }
            $this->return_json($data);

        } else {
            // Access Error Fallback
            exit('Boo...');
        }
    }


    /**
     * Method to generate or serve a JSON containing
     * a specific list of videos (default: top today's rated from everywhere)
     *
     * @access public
     * @param  string $source [Api source]
     * @param  string $period [Time period (today, week...)]
     * @param  string $sorts  [Most viewed, Most Rated?]
     * @param  string $format [json default]
     * @return JSON
    */
    public function getVideos($returnFormat = 'json')
    {
        #$this->apiprocessing->sorts  = ['top_rated', 'most_viewed'];
        #$this->apiprocessing->period = 'today';
        
        if (!empty($this->input->get('maxResults'))) {
            $this->apiprocessing->maxResults = $this->input->get('maxResults');
        }

        if (!empty($this->input->get('source')) && $this->input->get('source') !== 'all') {
            $apis = $this->input->get('source');
            
            if (strpos($apis, ',') !== false) {
                $apis = explode(',', $apis);
            } else {
                $apis = array($apis);
            }

            $this->apiprocessing->apis = $apis;
        }

        if (!empty($this->input->get('period')) && $this->input->get('period') !== 'ever') {
            $this->apiprocessing->period = $this->input->get('period');
        }

        if (empty($this->input->get('content'))) {
            die('No content desired specified');
        }
        else {
            $content = $this->input->get('content');
            
            if (strpos($content, ',') !== false) {
                $content = explode(',', $content);
            }/* else {
                $content = array($content);
            }*/

            $this->apiprocessing->content = $content;
        }

        $apiResults = $this->apiprocessing->interogateApis();

        $data = array();
        foreach ($apiResults as $sort => $sortData) {
            foreach ($sortData as $api => $apiData) {
                $results = $this->apiprocessing->parseApiResult($api, $apiData, $sort);
                if (!empty($results)) {
                    $data[$sort][$api] = $results[$sort][$api];
                }
            } // $sortData as $api => $apiData
        } // $api_response as $sortName => $sortData

        if ($returnFormat === 'json') {
            return $this->response->json($data);
        } elseif ($returnFormat === 'array') {
            return $data;
        } elseif ($returnFormat === 'serialized') {
            return serialize($data);
        }
    }


    /**
     * If you want to use GET in your ajax calls you could use without forcing POST
     * basic $GET data from Ajax in URL
     *
     * @access public
     * @param String $id
     * @return JSON
    */
    public function get($id = null) {

        if ( $this->input->is_ajax_request() ) {
            if ($id != null) {

                // Query here
                // $foo = 'bar';

                // and customize your callback if need be
                $data = array(
                    //'baz' => $foo,
                    'success' => 'true'
                );
            }

            // Error fallback
            if (empty($data)) {
                $data = array('success' => 'false');
            }

            // Return JSON
            $this->return_json($data);

        } else {
            // Access Error Fallback
            exit('Boo...');
        }
    }

    /**
     * If your intention is to update your db or some other data manipulation,
     * force your api to only accept POST, its safer
     *
     * @access public 
     * @return JSON
     */
    public function post() {
        if ($this->input->is_ajax_request() && !empty($_POST)) {

            // Mock up Ajax request to load data from model
            // Configure this to your liking
            $id = $_POST['id'];
            if ($id != null) {
                // do some query or updating here

                // and customize your callback
                $data = array('success' => 'true');
            }

            // Error fallback
            if (empty($data)) {
                $data = array('success' => 'false');
            }

            // Return JSON
            $this->return_json($data);

        } else {
            // Access Error Fallback
            exit('Boo...');
        }
    }
}