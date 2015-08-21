<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fetch extends MX_Controller {

    var $apis = array(
                'Dailymotion',
                'Metacafe',
                'Vimeo',
                'YouTube'
            );

    public function __construct()
    {
        parent::__construct();

        $this->load->library('Videouri/ApiProcessing');

        $this->lang->load('error');
    }


    /**
    * This function will redirect to index when needed
    */
    public function index()
    {
        redirect('/', 'refresh');
    }


    /**
    * This function is ment for getting search or tag results for the query specified
    *
    * @return the php response from parsing the data.
    */
    public function results()
    {
        // $action = ($this->input->get('search') == NULL) ? 'search' : $this->input->get('search', TRUE);

        $this->apiprocessing->page = !empty($this->input->get('page')) ? $this->input->get('page') : 1;
        $this->apiprocessing->sort = !empty($this->input->get('sort')) ? $this->input->get('sort') : 'relevance';

        $this->apiprocessing->maxResults = 12;

        // $filter = $this->input->get('search_filter', TRUE);
        $this->apiprocessing->searchQuery = $searchQuery = strip_tags($this->input->get('search_query', TRUE));
        $this->apiprocessing->content     = 'search';

        // Replace single spaces with a URL friendly plus sign
        // $searchQuery = str_replace(" ", "+", $searchQuery);

        if (ctype_space($searchQuery)) {
            redirect('/');
        }

        // Remove multiple adjacent spaces
        // while (strstr($searchQuery, "  ")) {
        //     $searchQuery = str_replace("  ", " ", $searchQuery);
        // }

        // $this->apiprocessing->apis = 'all';

        try {
            $searchResultsRaw = $this->apiprocessing->mixedCalls()['search'];
            $searchResults    = array();

            foreach ($searchResultsRaw as $api => $apiData) {
                $searchResults = array_merge($searchResults, $this->apiprocessing->parseApiResult($api, $apiData));
            }

            // var_dump($searchResults);

            uasort($searchResults, 'sortByViews');

        }
        catch(ParameterException $e) {
            dd($e);
            #echo "Encountered an API error -- code {$e->getCode()} - {$e->getMessage()}";
        }
        catch(Exception $e) {
            dd($e);
            #echo "Some other Exception was thrown -- code {$e->getCode()} - {$e->getMessage()}";
        }

        $data['data'] = $searchResults;
        $data['apis'] = $this->apiprocessing->apis;

        $data['canonical']   = '';
        $data['searchQuery'] = $searchQuery;

        $this->template->title = $searchQuery . ' - Videouri';
        $this->template->description = 'Searching for ' . $searchQuery . ', on ' . implode(', ', $data['apis']);
        $this->template->content->view('searchsPage', $data);
        $this->template->publish();

    }
}