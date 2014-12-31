<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ApiProcessing Class
 *
 * Class containing commons and usefull function to
 * interact with the API used in Videouri APP
 *
 * @category    Libraries
 * @author      Alexandru Budurovici
 * @version     1.0
 */

class ApiProcessing
{
    /**
     * List of available apis to process
     *
     * @var array
     */
    public $apis = array(
        'YouTube',
        // 'Metacafe',
        'Dailymotion',
        'Vimeo'
    );


    /**
     * Available contents
     * 
     * @var array
     */
    private $mixedContents =  array(
                'most_viewed',
                'newest',
                'top_rated',
                'search',
            ),
            $individualContents = array(
                'getVideoEntry',
                'getRelatedVideos',
                'tag'
            );


    /**
     * Variable to be used, to mention what action will be executed
     *
     * @var boolean
     */
    public $content = null;


    /**
     * Array containing available time periods.
     *
     * @var array
     */
    private $validPeriods = array('ever', 'today', 'week', 'month');


    /**
     * Default variable referring to video sorting period
     *
     * @var string
     */
    public $period = 'ever';


    /**
     * Variables to be populated by specific uses
     *
     * @var string
     */
    public $videoId = null,
           $searchQuery = null,
           $page = null,
           $sort = null;


    /**
     * Maximum results from response
     *
     * @var integer
     */
    public $maxResults = 5;


    /**
     * Variable to hold the sort parameter, for apiParser,
     * if set.
     * @var boolean
     */
    private $contentForParser = null;


    /**
     * Caching time span and timeout
     * @var array
     */
    private $_periodCachingTime = [
                'ever'  => 86400,  // 1 Day
                'today' => 86400,  // 1 Day
                'week'  => 172800, // 2 Days
                'month' => 259200  // 3 Days
            ],
            $_cacheTimeout = 10800;

    public function __construct()
    {
        // parent::__construct();
        $CI =& get_instance();

        // $CI->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc', 'key_prefix' => 'videouri_'));
        $CI->load->driver('cache', array('key_prefix' => 'videouri_'));
        $this->cache = $CI->cache->file;

        if ( ! in_array($this->period, $this->validPeriods)) {
            $this->period = 'today';
        }

    }

    public function mixedCalls()
    {
        $apiParameters = [
            'apis'        => $this->apis,
            'content'     => $this->content,
            'period'      => $this->period,
            'searchQuery' => $this->searchQuery,
            'page'        => $this->page,
            'sort'        => $this->sort
        ];
        $apiParametersHash = md5(serialize($apiParameters));

        if (!$apiResponse = $this->cache->get($apiParametersHash)) {
            // if (!is_array($this->content) && !in_array($this->content, $this->availableContents)) {
            if (!in_array_r($this->content, $this->mixedContents)) {
                throw new Exception("Error Processing Request.", 1);
            }

            $this->maxResults = (int) $this->maxResults;

            $apiResponse = array();
            foreach ($this->apis as $api) {
                try {
                    if (is_array($this->content)) {
                        foreach ($this->content as $content) {
                           $apiResponse[$content][$api] = self::getContent($content, $api);
                        }
                    } else {
                        $apiResponse[$this->content][$api] = self::getContent($this->content, $api);
                        // $apiResponse = self::getContent($this->content, $api);
                    }
                }

                catch (ParameterException $e) {
                    prePrint($e);
                    #echo "Encountered an API error -- code {$e->getCode()} - {$e->getMessage()}";
                }

                catch (Exception $e) {
                    prePrint($e);
                    #echo "Some other Exception was thrown -- code {$e->getCode()} - {$e->getMessage()}";
                }
            }

            // dd($apiResponse);

            // Caching results
            $this->cache->save($apiParametersHash, $apiResponse, $this->_periodCachingTime[$this->period]);
        }

        return $apiResponse;
    }


    public function individualCall($api)
    {
        if (!in_array_r($this->content, $this->individualContents)) {
            throw new Exception("Error Processing Request.", 1);
        }

        if (isset($this->videoId)) {
            if ($api == 'Metacafe') {
                $videoId = explode('/', $this->videoId);
                $this->videoId = $videoId[0];
            }

            $dynamicVariable = "video_{$this->videoId}";
            if ($this->content == 'getRelatedVideos') {
                $dynamicVariable = "relatedTo_{$this->videoId}";
            }

            $cacheVariable = "{$api}_{$dynamicVariable}";
        }

        else {
            if (isset($this->searchQuery)) {
                $characters  = array("-", "@");
                $searchQuery = str_replace($characters, '', $this->searchQuery);

                $dynamicVariable = "searchQuery_{$searchQuery}";
                if (isset($parameters['page'])) {
                    $dynamicVariable .= "_page{$this->page}";
                }
            }

            // elseif (isset($parameters['maxResults'])) {
            //     $dynamicVariable = "{$parameters['maxResults']}_results";
            // }

            else {
                $dynamicVariable = "{$this->content}";
            }
            
            $cacheVariable = "{$api}_{$dynamicVariable}_{$this->period}";
        }

        $apiResponse = $this->cache->get($cacheVariable);

        if (!$apiResponse) {
            $apiResponse = self::getContent($this->content, $api);
            $this->cache->save($cacheVariable, $apiResponse, $this->_cacheTimeout);
        }

        return $apiResponse;
    }


    private function getContent($content, $api)
    {
        $parameters = array(
                            'content'     => $content,
                            'period'      => $this->period,
                            'maxResults'  => $this->maxResults,
                        );

        if (isset($this->videoId)) {
            $parameters['videoId'] = $this->videoId;
        }
        elseif (isset($this->searchQuery)) {
            $parameters['page']        = $this->page;
            $parameters['sort']        = $this->sort;
            $parameters['searchQuery'] = $this->searchQuery;
        }

        return modules::run("apis/{$api}Controller/data", $parameters);
    }



    ////     ////
    // PARSERS //
    ////     ////
    public function parseApiResult($api = null, $data, $specificContent = null)
    {
        $apiParser = "{$api}Parser";

        if (!is_null($specificContent)) {
            $this->contentForParser = $specificContent;
        }

        return $this->$apiParser($data);
    }

    private function YouTubeParser($data)
    {
        $i = 0;
        $results = array();

        foreach ($data['feed']['entry'] as $video) {
            $origid = substr($video['id']['$t'], strrpos($video['id']['$t'], '/') + 1);
            $id     = substr($origid,0,1).'y'.substr($origid,1);

            $toMerge = $results[$i] = array(
                'url'    => site_url('video/'.$id),
                'title'  => $video['title']['$t'],
                'author' => $video['author'][0]['name']['$t'],
            );

            $categories = array();
            foreach ($video['media$group']['media$category'] as $category) {
                $categories[] = $category['$t'];
            }

            // $results['YouTube'][$i] = array_merge($toMerge, array(
            $results[$i] = array_merge($toMerge, array(
                'category'    => $categories,
                'description' => self::parseDescription($video['media$group']['media$description']['$t']),
                'rating'      => $video['gd$rating']['average'],
                'viewsCount'  => $video['yt$statistics']['viewCount'],
                // 'img'         => $video['media$group']['media$thumbnail'][0]['url'],
                'img'         => 'https://i.ytimg.com/vi/'.$origid.'/mqdefault.jpg',
                'source'      => 'YouTube',
            ));

            $i++;
        }

        if ($content = $this->contentForParser) {
            // $results[$content]['YouTube'] = $results['YouTube'];
            // unset($results['YouTube']);
            
            return array($content => $results);
        }

        return $results;
    }

    private function DailymotionParser($data)
    {
        $i = 0;
        $results = array();

        foreach ($data['list'] as $video) {
            preg_match('@video/([^_]+)_([^/]+)@', $video['url'], $match);
            $url = $match[1].'/'.$match[2];
            $url = site_url('video/'.substr($url,0,1).'d'.substr($url,1));

            $results[$i] = array(
                'url'         => $url,
                'title'       => $video['title'],
                'author'      => '',
                'description' => self::parseDescription($video['description']),
                'rating'      => $video['rating'],
                'viewsCount'  => $video['views_total'],
                'img'         => $video['thumbnail_medium_url'],
                'source'      => 'Dailymotion',
            );

            $i++;
        }

        if ($content = $this->contentForParser) {
            // $results[$content]['Dailymotion'] = $results['Dailymotion'];
            // unset($results['Dailymotion']);

            return array($content => $results);
        }

        return $results;
    }

    private function MetacafeParser($data)
    {
        $i = 1;
        $results = array();

        if (!$data) return false;

        foreach ($data->channel->item as $video) {
            $video = (array) $video;
            preg_match('/http:\/\/[w\.]*metacafe\.com\/watch\/([^?&#"\']*)/is', $video['link'], $match);
            $id  = substr($match[1],0,-1);
            $url = site_url('video/'.substr($id,0,1).'M'.substr($id,1));
            
            $results['Metacafe'][$i] = array(
                'url'         => $url,
                'title'       => $video['title'],
                'author'      => $video['author'],
                'category'    => $video['category'],
                'description' => self::parseDescription($video['title']),
                'rating'      => isset($video['rank']) ? $video['rank'] : 0,
                'viewsCount'  => 0,
                'img'         => "http://www.metacafe.com/thumb/{$video['id']}.jpg",
                'source'      => 'Metacafe',
            );

            if ($i === $this->maxResults) break;
            
            $i++;

        }

        if (isset($results['Metacafe']) && $content = $this->contentForParser) {
            $results[$content]['Metacafe'] = $results['Metacafe'];
            unset($results['Metacafe']);
        }

        return $results;
    }

    private function VimeoParser($data)
    {
        $i = 0;
        $results = array();

        foreach ($data['body']['data'] as $video) {
            $origid = explode('/', $video['uri'])[2];
            $id     = substr($origid,0,1).'v'.substr($origid,1);

            $results[$i] = array(
                'url'         => site_url('video/'.$id),
                'title'       => $video['name'],
                'author'      => $video['user']['name'],
                'category'    => '',
                'description' => self::parseDescription($video['description']),
                'rating'      => $video['metadata']['connections']['likes']['total'],
                'viewsCount'  => $video['stats']['plays'],
                'img'         => $video['pictures']['sizes'][2]['link'],
                'source'      => 'Vimeo',
            );

            if ($i === $this->maxResults) break;
            
            $i++;

        }

        if (isset($results['Vimeo']) && $content = $this->contentForParser) {
            $results[$content]['Vimeo'] = $results['Vimeo'];
            unset($results['Vimeo']);
        }

        return $results;
    }

    private function parseDescription($text)
    {
        if ($this->content === 'getVideoEntry') {
            return $text;
        } else {
            return trim_text($text, 90);
        }
    }
}