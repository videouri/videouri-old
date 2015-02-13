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
        // $this->load->helper('htmlpurifier');

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

        // $Dailymotion = !empty($searchResults['Dailymotion']['list']) ? $searchResults['Dailymotion']['list'] : null;
        // $Metacafe    = !empty($searchResults['Metacafe']->channel->item) ? $searchResults['Metacafe']->channel->item : null;
        // $Vimeo       = !empty($searchResults['Vimeo']->videos->video) ? $searchResults['Vimeo']->videos->video : null;
        // $YouTube     = !empty($searchResults['YouTube']['feed']['entry']) ? $searchResults['YouTube']['feed']['entry'] : null;

        // // dd($YouTube);

        // if (!empty($searchResults)) {

        //     if ( ! (($Dailymotion) || ($Metacafe) || ($Vimeo) || ($YouTube)) == NULL) {

        //         foreach ($searchResults as $key => $value) {

        //             if (empty($value)) continue;

        //             switch ($key)
        //             {
        //                 case "Dailymotion":
        //                     $i = 0;
        //                     foreach ($searchResults['Dailymotion']['list'] as $video) {
        //                         preg_match('@video/([^_]+)_([^/]+)@', $video['url'], $match);
        //                         $url = $match[1].'/'.$match[2];
        //                         $url = site_url('video/'.substr($url,0,1).'d'.substr($url,1));

        //                         $data['data']['Dailymotion'][$i]['url']   = $url;
        //                         $data['data']['Dailymotion'][$i]['title'] = trim_text($video['title'], 83);
        //                         $data['data']['Dailymotion'][$i]['img']   = $video['thumbnail_medium_url'];
        //                         $i++;
        //                     }
        //                     break;

        //                 case "Metacafe":
        //                     $i = 0;
        //                     foreach ($searchResults['Metacafe']->channel->item as $video) {
        //                         preg_match('/http:\/\/[w\.]*Metacafe\.com\/watch\/([^?&#"\']*)/is', $video->link, $match);
        //                         $id  = substr($match[1],0,-1);
        //                         $url = site_url('video/'.substr($id,0,1).'M'.substr($id,1));

        //                         $data['data']['Metacafe'][$i]['url']   = $url;
        //                         $data['data']['Metacafe'][$i]['title'] = trim_text($video->title, 83);
        //                         $data['data']['Metacafe'][$i]['img']   = "http://www.Metacafe.com/thumb/$video->id.jpg";
        //                         $i++;
        //                     }
        //                     break;

        //                 case "YouTube":
        //                     $i = 0;
        //                     foreach ($searchResults['YouTube']['feed']['entry'] as $video) {
        //                         $origid = substr( $video['id']['$t'], strrpos( $video['id']['$t'], '/' )+1 );
        //                         $id     = substr($origid,0,1).'y'.substr($origid,1);
        //                         $url    = site_url('video/'.$id);

        //                         $data['data']['YouTube'][$i]['url']   = $url;
        //                         $data['data']['YouTube'][$i]['author']   = $video['author'][0]['name']['$t'];
        //                         $data['data']['YouTube'][$i]['title'] = trim_text($video['title']['$t'], 83);
        //                         $data['data']['YouTube'][$i]['img']   = $video['media$group']['media$thumbnail'][0]['url'];
        //                         $data['data']['YouTube'][$i]['rating']   = $video['gd$rating']['average'];
        //                         $i++;
        //                     }
        //                     break;
        //             }
        //         }
        //     }
        //     else
        //     {
        //         $data['fail'] = $parameters['filter'];
        //     }
        // }
        // else
        // {
        //     $data['fail'] = $parameters['filter'];
        // }
        
        // dd($searchResults);
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

/* End of file fetch.php */
/* Location: ./application/modules/fetch/controllers/fetch.php */