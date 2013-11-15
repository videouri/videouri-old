<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller
{

    /**
     * List of available apis to return content for home page
     *
     * @var array
     */
    protected $_apis = array(
        'youtube',
        'metacafe',
        'dailymotion'
    );

    protected $_content =  array(
        'top_rated',
        'most_viewed'
    );

    /**
     * Array containing available time periods.
     *
     * @var array
     */
    var $valid_periods = array('ever', 'today', 'week', 'month');

    /**
     * Variable to contain the period of videos to load
     *
     * @var string
     */
    var $period = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ( ! $_SERVER['SERVER_ADDR'] == $_SERVER['REMOTE_ADDR'])
        {
          $this->output->set_status_header(400, 'No Remote Access Allowed');
          exit;
        }

        $this->period = $this->input->post('time', true);
        $this->default_content();
    }

    public function default_content()
    {
        $api_response = $this->_call_data();

        #prePrint($api_response['top_rated']['youtube']);
        #exit;

        foreach($api_response as $keySection => $valueSection)
        {
            foreach($valueSection as $key => $value)
            {
                switch ($key)
                {
                    case "youtube":
                        $i = 0;
                        $test_data = array();

                        foreach($value['feed']['entry'] as $video)
                        {
                            $origid = substr($video['id']['$t'], strrpos($video['id']['$t'], '/') + 1);
                            $id     = substr($origid,0,1).'y'.substr($origid,1);

                            $data['data'][$keySection]['youtube'][$i]['url']         = site_url('video/'.$id);
                            $data['data'][$keySection]['youtube'][$i]['title']       = trim_text($video['title']['$t'], 40);
                            $data['data'][$keySection]['youtube'][$i]['author']      = $video['author'][0]['name']['$t'];

                            $categories = array();
                            foreach ($video['media$group']['media$category'] as $category) {
                                $categories[] = $category['$t'];
                            }

                            $data['data'][$keySection]['youtube'][$i]['category']    = $categories;
                            $data['data'][$keySection]['youtube'][$i]['description'] = trim_text($video['media$group']['media$description']['$t'], 90);
                            $data['data'][$keySection]['youtube'][$i]['img']         = $video['media$group']['media$thumbnail'][0]['url'];

                            $test_data[] = $data['data'][$keySection]['youtube'][$i];
                            $i++;
                        }
                        #exit(prePrint($test_data));
                    break;

                    case "dailymotion":
                        /*$i = 0;
                        foreach ($value['list'] as $video)
                        {
                            preg_match('@video/([^_]+)_([^/]+)@', $video['url'], $match);
                            $url = $match[1].'/'.$match[2];
                            $url = site_url('video/'.substr($url,0,1).'d'.substr($url,1));

                            $data['data'][$keySection]['dailymotion'][$i]['url']         = $url;
                            $data['data'][$keySection]['dailymotion'][$i]['title']       = trim_text($video['title'], 30);
                            $data['data'][$keySection]['dailymotion'][$i]['author']      = trim_text($video['title']['$t'], 28);
                            $data['data'][$keySection]['dailymotion'][$i]['description'] = trim_text($video['content']['$t'], 98, false);
                            $data['data'][$keySection]['dailymotion'][$i]['img']         = $video['thumbnail_medium_url'];
                            $i++;
                        }*/
                    break;

                    case "metacafe":
                        $i = 0;
                        $maxResults=5;

                        foreach ($value->channel->item as $video)
                        {
                            preg_match('/http:\/\/[w\.]*metacafe\.com\/watch\/([^?&#"\']*)/is', $video->link, $match);
                            $id  = substr($match[1],0,-1);
                            $url = site_url('video/'.substr($id,0,1).'M'.substr($id,1));
                            
                            $data['data'][$keySection]['metacafe'][$i]['url']         = $url;
                            $data['data'][$keySection]['metacafe'][$i]['title']       = trim_text($video->title, 40);
                            $data['data'][$keySection]['metacafe'][$i]['author']      = $video->author;
                            $data['data'][$keySection]['metacafe'][$i]['category']    = $video->category;
                            $data['data'][$keySection]['metacafe'][$i]['description'] = trim_text($video['title']['$t'], 90);
                            $data['data'][$keySection]['metacafe'][$i]['img']         = "http://www.metacafe.com/thumb/$video->id.jpg";
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
        if(ENVIRONMENT == 'development')
        {
            //apc_clear_cache('user');
        }

        if( ! isset($this->period))
        {
            $this->period = 'ever';
        }
        else
        {
            if( ! in_array($this->period, $this->valid_periods))
            {
                $this->output->set_status_header(403, 'Operation not allowed');
                exit;
            }
        }

        $api_response = array();
        foreach ($this->_apis as $api)
        {
            try
            {
                foreach ($this->_content as $content)
                {
                    $api_response[$content][$api]   = modules::run("apis/c_$api/data", array('content' => $content, 'period' => $this->period));
                }
            }
            catch(ParameterException $e)
            {
                #echo "Encountered an API error -- code {$e->getCode()} - {$e->getMessage()}";
            }
            catch(Exception $e)
            {
                #prePrint($e);
                #echo "Some other Exception was thrown -- code {$e->getCode()} - {$e->getMessage()}";
            }
        }

        return $api_response;
    }

}

/* End of file home.php */
/* Location: ./application/modules/home/controllers/home.php */