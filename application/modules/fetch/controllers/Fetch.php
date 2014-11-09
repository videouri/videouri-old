<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fetch extends MX_Controller {

    var $apis = array(
                'dailymotion',
                'metacafe',
                'vimeo',
                'youtube'
            );

    public function __construct()
    {
        parent::__construct();

        $this->load->library('Videouri/ApiProcessing');

        $this->lang->load('error');

        $this->load->driver('cache',
            array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => 'videouri_')
        );
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
        $this->load->helper('htmlpurifier');

        /*
        #First the regular expression approach:
        if (preg_match("/([\<])([^\>]{1,})*([\>])/i", $string)) {
            echo "string contains html";
        }

        #And here is the other approach:
        if(strlen($string) != strlen(strip_tags($string)){
          echo "string contains HTML";
        }
        */

        $action = ($this->input->get('search') == NULL) ? 'search' : $this->input->get('search', TRUE);
        $page   = $this->input->get('page', TRUE);
        $sort   = $this->input->get('sort', TRUE);
        $parameters = array(
            'query'     => strip_tags($this->input->get('search_query', TRUE)),
            'page'      => !empty($page) ? $page : 1,
            'sort'      => !empty($sort) ? $sort : 'relevance',
            'filter'    => $this->input->get('search_filter', TRUE),
            'action'    => $action,
            'view'      => $action.'sPage'
        );

        // Collect the posted search query
        #$parameters['query'] = strtolower(mysql_real_escape_string($parameters['query']));

        // Clean up by removing unwanted characters
        #$qclean = ereg_replace("[^ 0-9a-zA-Z]", " ", $q);

        // Remove multiple adjacent spaces
        while (strstr($parameters['query'], "  ")) {
           $parameters['query'] = str_replace("  ", " ", $parameters['query']);
        }

        // Replace single spaces with a URL friendly plus sign
        $parameters['query'] = str_replace(" ", "+", $parameters['query']);

        if( ! empty($parameters['query'])) {
            $this->apiprocessing->content  = 'search';
            $this->apiprocessing->searchQuery  = $parameters['query'];

            if(empty($parameters['filter'])) {

                $this->apiprocessing->apis     = 'all';
                
                foreach($this->apis as $key => $api) {
                    try {
                        $searchResults[$api] = modules::run("apis/c_$api/data", $parameters);
                    }
                    catch(ParameterException $e) {
                        #echo "Encountered an API error -- code {$e->getCode()} - {$e->getMessage()}";
                    }
                    catch(Exception $e) {
                        #echo "Some other Exception was thrown -- code {$e->getCode()} - {$e->getMessage()}";
                    }
                }
            }

            else {
                
                foreach($parameters['filter'] as $key => $api) {
                    $this->apiprocessing->apis = $api;
                    
                    try {
                        $searchResults[$api] = modules::run("apis/c_$api/data", $parameters);
                    }
                    catch(ParameterException $e) {
                        #echo "Encountered an API error -- code {$e->getCode()} - {$e->getMessage()}";
                    }
                    catch(Exception $e) {
                        #echo "Some other Exception was thrown -- code {$e->getCode()} - {$e->getMessage()}";
                    }
                }
            }

            $dailymotion = !empty($searchResults['dailymotion']['list']) ? $searchResults['dailymotion']['list'] : null;
            $metacafe    = !empty($searchResults['metacafe']->channel->item) ? $searchResults['metacafe']->channel->item : null;
            $vimeo       = !empty($searchResults['vimeo']->videos->video) ? $searchResults['vimeo']->videos->video : null;
            $youtube     = !empty($searchResults['youtube']['feed']['entry']) ? $searchResults['youtube']['feed']['entry'] : null;

            if(!empty($searchResults)) {

                dd($searchResults);

                if( ! (($dailymotion) || ($metacafe) || ($vimeo) || ($youtube)) == NULL) {

                    foreach ($searchResults as $key => $value) {

                        if(empty($value)) continue;

                        switch ($key)
                        {
                            case "dailymotion":
                                $i = 0;
                                foreach ($searchResults['dailymotion']['list'] as $video) {
                                    preg_match('@video/([^_]+)_([^/]+)@', $video['url'], $match);
                                    $url = $match[1].'/'.$match[2];
                                    $url = site_url('video/'.substr($url,0,1).'d'.substr($url,1));

                                    $data['data']['dailymotion'][$i]['url']   = $url;
                                    $data['data']['dailymotion'][$i]['title'] = trim_text($video['title'], 83);
                                    $data['data']['dailymotion'][$i]['img']   = $video['thumbnail_medium_url'];
                                    $i++;
                                }
                                break;

                            case "metacafe":
                                $i = 0;
                                foreach ($searchResults['metacafe']->channel->item as $video) {
                                    preg_match('/http:\/\/[w\.]*metacafe\.com\/watch\/([^?&#"\']*)/is', $video->link, $match);
                                    $id  = substr($match[1],0,-1);
                                    $url = site_url('video/'.substr($id,0,1).'M'.substr($id,1));

                                    $data['data']['metacafe'][$i]['url']   = $url;
                                    $data['data']['metacafe'][$i]['title'] = trim_text($video->title, 83);
                                    $data['data']['metacafe'][$i]['img']   = "http://www.metacafe.com/thumb/$video->id.jpg";
                                    $i++;
                                }
                                break;

                            case "vimeo":
                                $i = 0;
                                if(!empty($searchResults['vimeo']->videos->video)) {
                                    foreach ($searchResults['vimeo']->videos->video as $video) {
                                        $id  = substr($video->id,0,1).'v'.substr($video->id,1);
                                        $url = site_url('video/'.$id);

                                        $data['data']['vimeo'][$i]['url']   = $url;
                                        $data['data']['vimeo'][$i]['title'] = trim_text($video->title, 83);
                                        $data['data']['vimeo'][$i]['img']   = $video->thumbnails->thumbnail[1]->_content;
                                        $i++;
                                    }
                                }
                                break;

                            case "youtube":
                                $i = 0;
                                foreach ($searchResults['youtube']['feed']['entry'] as $video) {
                                    $origid = substr( $video['id']['$t'], strrpos( $video['id']['$t'], '/' )+1 );
                                    $id     = substr($origid,0,1).'y'.substr($origid,1);
                                    $url    = site_url('video/'.$id);

                                    $data['data']['youtube'][$i]['url']   = $url;
                                    $data['data']['youtube'][$i]['author']   = $video['author'][0]['name']['$t'];
                                    $data['data']['youtube'][$i]['title'] = trim_text($video['title']['$t'], 83);
                                    $data['data']['youtube'][$i]['img']   = $video['media$group']['media$thumbnail'][0]['url'];
                                    $data['data']['youtube'][$i]['rating']   = $video['gd$rating']['average'];
                                    $i++;
                                }
                                break;
                        }
                    }
                }
                else
                {
                    $data['fail'] = $parameters['filter'];
                }
            }
            else
            {
                $data['fail'] = $parameters['filter'];
            }

            $data['query'] = $parameters['query'];
            $data['canonical'] = '';
            $this->template->content->view($parameters['view'], $data);
            $this->template->publish();

        }
        else
        {
            $this->index();
        }

    }

}

/* End of file fetch.php */
/* Location: ./application/modules/fetch/controllers/fetch.php */