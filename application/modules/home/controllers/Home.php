<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller {

    /**
     * List of available apis to return content for home page
     *
     * @var array
     */
    private $_apis = array(
        'YouTube',
        'Metacafe',
        'Dailymotion'
    );

    private $_homeContents =  array(
        'top_rated',
        'most_viewed'
    );

    /**
     * Array containing available time periods.
     *
     * @var array
     */
    private $_validPeriods = array('ever', 'today', 'week', 'month');

    /**
     * Variable to contain the period of videos to load
     *
     * @var string
     */
    var $period = null;

    public function __construct()
    {
        parent::__construct();

        $this->load->driver('cache',
            array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => 'videouri_')
        );
    }

    public function index()
    {
        if ( ! $_SERVER['SERVER_ADDR'] == $_SERVER['REMOTE_ADDR']) {
          $this->output->set_status_header(400, 'No Remote Access Allowed');
          exit;
        }

        $this->period = $this->input->post('time', true);
        $this->default_content();
    }

    public function default_content()
    {
        $api_response = $this->_call_data();

        foreach ($api_response as $keySection => $valueSection) {

            foreach ($valueSection as $key => $value) {

                switch ($key) {
                    case "YouTube":
                        $i = 0;
                        $test_data = array();

                        foreach ($value['feed']['entry'] as $video) {
                            #var_dump($video);
                            $origid = substr($video['id']['$t'], strrpos($video['id']['$t'], '/') + 1);
                            $id     = substr($origid,0,1).'y'.substr($origid,1);

                            $data['data'][$keySection]['YouTube'][$i]['url']         = site_url('video/'.$id);
                            $data['data'][$keySection]['YouTube'][$i]['title']       = trim_text($video['title']['$t'], 40);
                            $data['data'][$keySection]['YouTube'][$i]['author']      = $video['author'][0]['name']['$t'];

                            $categories = array();
                            foreach ($video['media$group']['media$category'] as $category) {
                                $categories[] = $category['$t'];
                            }

                            $data['data'][$keySection]['YouTube'][$i]['category']    = $categories;
                            $data['data'][$keySection]['YouTube'][$i]['description'] = trim_text($video['media$group']['media$description']['$t'], 90);
                            $data['data'][$keySection]['YouTube'][$i]['img']         = $video['media$group']['media$thumbnail'][0]['url'];

                            $test_data[] = $data['data'][$keySection]['YouTube'][$i];
                            $i++;
                        }
                        break;

                    case "Dailymotion":
                        /*$i = 0;
                        foreach ($value['list'] as $video)
                        {
                            preg_match('@video/([^_]+)_([^/]+)@', $video['url'], $match);
                            $url = $match[1].'/'.$match[2];
                            $url = site_url('video/'.substr($url,0,1).'d'.substr($url,1));

                            $data['data'][$keySection]['Dailymotion'][$i]['url']         = $url;
                            $data['data'][$keySection]['Dailymotion'][$i]['title']       = trim_text($video['title'], 30);
                            $data['data'][$keySection]['Dailymotion'][$i]['author']      = trim_text($video['title']['$t'], 28);
                            $data['data'][$keySection]['Dailymotion'][$i]['description'] = trim_text($video['content']['$t'], 98, false);
                            $data['data'][$keySection]['Dailymotion'][$i]['img']         = $video['thumbnail_medium_url'];
                            $i++;
                        }*/
                    break;

                    case "Metacafe":
                        $i = 0;
                        $maxResults=5;

                        foreach ($value->channel->item as $video) {
                            preg_match('/http:\/\/[w\.]*metacafe\.com\/watch\/([^?&#"\']*)/is', $video->link, $match);
                            $id  = substr($match[1],0,-1);
                            $url = site_url('video/'.substr($id,0,1).'M'.substr($id,1));
                            
                            $data['data'][$keySection]['Metacafe'][$i]['url']         = $url;
                            $data['data'][$keySection]['Metacafe'][$i]['title']       = trim_text($video->title, 40);
                            $data['data'][$keySection]['Metacafe'][$i]['author']      = $video->author;
                            $data['data'][$keySection]['Metacafe'][$i]['category']    = $video->category;
                            $data['data'][$keySection]['Metacafe'][$i]['description'] = trim_text($video['title']['$t'], 90);
                            $data['data'][$keySection]['Metacafe'][$i]['img']         = "http://www.metacafe.com/thumb/$video->id.jpg";
                            $i++;
                            if($i==$maxResults) break;
                        }
                    break;
                } // switch($key)
            } // $valueSection as $key => $value
        } // $api_response as $keySection => $valueSection

        $data['apis']      = $this->_apis;
        $data['canonical'] = '';
        $data['time']      = array(
                                'today'      => 'today',
                                'this week'  => 'week',
                                'this month' => 'month',
                                'ever'       => 'ever'
                            );
        $this->template->content->view('home', $data);
        $this->template->publish();
    }

    private function _call_data()
    {
        if (ENVIRONMENT == 'development') {
            //apc_clear_cache('user');
        }

        if( ! isset($this->period)) {
            $this->period = 'ever';
        }

        else {
            if (! in_array($this->period, $this->_validPeriods)) {
                $this->output->set_status_header(403, 'Operation not allowed');
                exit;
            }
        }

        $api_response = array();
        foreach ($this->_apis as $api) {
            try {
                foreach ($this->_homeContents as $content) {
                    $api_response[$content][$api] = modules::run("apis/{$api}Controller/data", array(
                                                        'content' => $content,
                                                        'period'  => $this->period)
                                                    );
                }
            }

            catch(ParameterException $e) {
                #echo "Encountered an API error -- code {$e->getCode()} - {$e->getMessage()}";
            }

            catch(Exception $e) {
                #prePrint($e);
                #echo "Some other Exception was thrown -- code {$e->getCode()} - {$e->getMessage()}";
            }
        }

        return $api_response;
    }

}

/* End of file home.php */
/* Location: ./application/modules/home/controllers/home.php */