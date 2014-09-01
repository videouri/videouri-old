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
        'Metacafe',
        'Dailymotion',
        'Vimeo'
    );


    /**
     * Available methods
     * 
     * @var array
     */
    private $availableContents =  array(
        'most_viewed',
        'newest',
        'top_rated',
        'getVideoEntry',
        'getRelatedVideos',
    );


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
     * Initiate the videoId variable
     *
     * @var boolean
     */
    public $videoId = null;


    /**
     * Variable to be used, to mention what action will be executed
     *
     * @var boolean
     */
    public $content = null;


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
    private $sortForParser = null;

    public function __construct()
    {
        // parent::__construct();

        if ( ! in_array($this->period, $this->validPeriods)) {
            $this->period = 'today';
        }

    }

    public function interogateApis()
    {
        if (!is_array($this->content) && !in_array($this->content, $this->availableContents)) {
            throw new Exception("Error Processing Request. No such method", 1);
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

        return $apiResponse;
    }

    public function parseApiResult($api, $data, $sort = null)
    {
        $apiParser = "{$api}Parser";

        if (!is_null($sort)) {
            $this->sortForParser = $sort;
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

            $toMerge = $results['YouTube'][$i] = array(
                'url'    => site_url('video/'.$id),
                'title'  => $video['title']['$t'],
                'author' => $video['author'][0]['name']['$t'],
            );

            $categories = array();
            foreach ($video['media$group']['media$category'] as $category) {
                $categories[] = $category['$t'];
            }

            $results['YouTube'][$i] = array_merge($toMerge, array(
                'category'    => $categories,
                'description' => trim_text($video['media$group']['media$description']['$t'], 90),
                'rating'      => $video['gd$rating']['average'],
                'viewsCount'  => $video['yt$statistics']['viewCount'],
                // 'img'         => $video['media$group']['media$thumbnail'][0]['url'],
                'img'         => 'https://i.ytimg.com/vi/'.$origid.'/mqdefault.jpg',
            ));

            $i++;
        }

        if ($sort = $this->sortForParser) {
            $results[$sort]['YouTube'] = $results['YouTube'];
            unset($results['YouTube']);
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

            $results['Dailymotion'][$i] = array(
                'url'         => $url,
                'title'       => $video['title'],
                'author'      => '',
                'description' => trim_text($video['description'], 98),
                'rating'      => $video['rating'],
                'viewsCount'  => $video['views_total'],
                'img'         => $video['thumbnail_medium_url'],
            );

            $i++;
        }

        if (isset($results['Dailymotion']) && $sort = $this->sortForParser) {
            $results[$sort]['Dailymotion'] = $results['Dailymotion'];
            unset($results['Dailymotion']);
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
                'description' => trim_text($video['title'], 90),
                'rating'      => isset($video['rank']) ? $video['rank'] : 0,
                'viewsCount'  => 0,
                'img'         => "http://www.metacafe.com/thumb/{$video['id']}.jpg",
            );

            if ($i === $this->maxResults) break;
            
            $i++;

        }

        if (isset($results['Metacafe']) && $sort = $this->sortForParser) {
            $results[$sort]['Metacafe'] = $results['Metacafe'];
            unset($results['Metacafe']);
        }

        return $results;
    }

    private function VimeoParser()
    {

    }

    private function getContent($content, $api)
    {
        $parameters = array(
                            'content' => $content,
                            'period'  => $this->period,
                            'maxResults' => $this->maxResults,
                        );

        if (isset($this->videoId)) {
            $parameters['videoId'] = $this->videoId;
        }

        return modules::run("apis/{$api}Controller/data", $parameters);
    }
}