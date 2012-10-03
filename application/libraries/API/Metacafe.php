<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Metacafe
{

    //http://www.metacafe.com/api/videos/?start-index=0&max-results=10&vq=drift&time=all_time&orderby=rating

	const URI_BASE = 'http://www.metacafe.com/';

    private $_uris = array(
    	//Today’s highest rated videos, movies & funny clips by Metacafe.
    	'TODAYS_TOP_RATED_VIDEOS'			=> 'rss.xml',

		//Today’s recently popular videos, movies & funny clips by Metacafe.
    	'TODAYS_RECENTLY_POPULAR'			=> 'recently_popular/rss.xml',

    	//Today’s most discussed videos, movies & funny clips by Metacafe.
    	'TODAYS_MOST_DISCUSSED'				=> 'most_interesting/rss.xml',

    	//Today’s most viewed videos, movies & funny clips by Metacafe.
    	'TODAYS_MOST_VIEWED'				=> 'most_popular/rss.xml',

    	//Today’s most recent videos, movies & funny clips by Metacafe.
    	'TODAYS_MOST_RECENT'				=> 'newest/rss.xml',

    	//Highest rated videos, movies & funny clips by Metacafe this week/this month/ever.
        'TOP_VIDEOS_WEEK'		            => 'top_videos/rss.xml',
        'TOP_VIDEOS_MONTH'		            => 'top_videos/month/rss.xml',
        'TOP_VIDEOS_EVER'		            => 'top_videos/ever/rss.xml',

        //Recently popular videos, movies & funny clips by Metacafe this week/this month/ever.
        'TOP_VIDEOS_RECENTLY_POPULAR_WEEK'	=> 'top_videos/recently_popular/rss.xml',
        'TOP_VIDEOS_RECENTLY_POPULAR_MONTH'	=> 'top_videos/recently_popular/month/rss.xml',
        'TOP_VIDEOS_RECENTLY_POPULAR_EVER'	=> 'top_videos/recently_popular/ever/rss.xml',

        //Most Interesting videos, movies & funny clips by Metacafe this week/this month/ever.
        'TOP_VIDEOS_MOST_DISCUSSED_WEEK'	=> 'top_videos/most_interesting/rss.xml',
        'TOP_VIDEOS_MOST_DISCUSSED_MONTH'	=> 'top_videos/most_interesting/month/rss.xml',
        'TOP_VIDEOS_MOST_DISCUSSED_EVER'	=> 'top_videos/most_interesting/ever/rss.xml',

        //Most Viewed videos, movies & funny clips by Metacafe this week/this month/ever.
        'TOP_VIDEOS_MOST_VIEWED_WEEK'		=> 'top_videos/most_popular/rss.xml',
        'TOP_VIDEOS_MOST_VIEWED_MONTH'		=> 'top_videos/most_popular/month/rss.xml',
        'TOP_VIDEOS_MOST_VIEWED_EVER'		=> 'top_videos/most_popular/ever/rss.xml',

        //Most Recent videos, movies & funny clips by Metacafe this week/this month/ever.
        'TOP_VIDEOS_MOST_RECENT_WEEK'		=> 'top_videos/newest/rss.xml',
        'TOP_VIDEOS_MOST_RECENT_MONTH'		=> 'top_videos/newest/month/rss.xml',
        'TOP_VIDEOS_MOST_RECENT_EVER'		=> 'top_videos/newest/ever/rss.xml'
    );

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * Executes a request that does not pass data, and returns the response.
     *
     * @param string $uri The URI that corresponds to the data we want.
     * @param array $params additional parameters to pass
     * @return the xml response from youtube.
     **/
    private function _response_request($uri, array $params = array())
    {
        if( ! empty($params))
            $uri .= '?'.http_build_query($params);

        $url = self::URI_BASE.substr($uri, 1);

        $data = curl_get($url);
        if($data)
            #return simplexml_load_string($data, 'SimpleXMLElement', LIBXML_COMPACT | LIBXML_NOCDATA | LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG );
            return $data;
        else
        	return false;
    }

    public function getTopRatedVideoFeed($case = 'EVER')
    {
    	switch($case)
    	{
    		case 'WEEK':
    			return $this->_response_request("/{$this->_uris['TOP_VIDEOS_WEEK']}");
    			break;
    		case 'MONTH':
    			return $this->_response_request("/{$this->_uris['TOP_VIDEOS_MONTH']}");
    			break;
    		case 'EVER':
    			return $this->_response_request("/{$this->_uris['TOP_VIDEOS_EVER']}");
    			break;
    	}
    }
    
    public function getMostViewedVideoFeed($case = 'EVER')
    {
    	switch($case)
    	{
    		case 'WEEK':
    			return $this->_response_request("/{$this->_uris['TOP_VIDEOS_MOST_VIEWED_WEEK']}");
    			break;
    		case 'MONTH':
    			return $this->_response_request("/{$this->_uris['TOP_VIDEOS_MOST_VIEWED_MONTH']}");
    			break;
    		case 'EVER':
    			return $this->_response_request("/{$this->_uris['TOP_VIDEOS_MOST_VIEWED_EVER']}");
    			break;
    	}
    }
    
    public function getMostDiscussedVideoFeed($case = 'EVER')
    {
    	switch($case)
    	{
    		case 'WEEK':
    			return $this->_response_request("/{$this->_uris['TOP_VIDEOS_MOST_DISCUSSED_WEEK']}");
    			break;
    		case 'MONTH':
    			return $this->_response_request("/{$this->_uris['TOP_VIDEOS_MOST_DISCUSSED_MONTH']}");
    			break;
    		case 'EVER':
    			return $this->_response_request("/{$this->_uris['TOP_VIDEOS_MOST_DISCUSSED_EVER']}");
    			break;
    	}
    }
    
    public function getMostRecentVideoFeed()
    {
        return $this->_response_request("/{$this->_uris['TODAYS_MOST_RECENT']}");
    }

    public function getKeywordVideoFeed($keywords, array $params = array())
    {
        $params['vq'] = str_replace(' ', '+', $keywords);
        #$params['vq'] = $keywords;
        return $this->_response_request("/api/videos/", array_merge(array('start-index'=>1, 'max-results'=>10, 'time' => 'all_time'), $params));
    }

    public function getTagVideosFeed($tag)
    {
        return $this->_response_request("/tags/".str_replace(' ', '+',mb_strtolower($tag))."/rss.xml");
    }

    public function getItemData($id)
    {
        return $this->_response_request("/api/item/$id/");
    }

    public function getRelatedVideos($id)
    {
        $id = explode('/', $id);
        return $this->_response_request("/api/$id[0]/related");
    }

    public function getEmbedData($id)
    {
        $url = "http://www.metacafe.com/fplayer/".$id.".swf";
        $data = curl_get($url);
        if($data == "Video does not exist")
        {
            return $result = '<span style="width: 640px; height: 330px; display: block; margin: 15px auto;"><a id="loadFrame" style="position: relative; top: 165px;" href="http://www.metacafe.com/watch/'.$id.'/">Click to load the video</a></span>';
        }
        else
        {
            return $result = $url;
            /*return '<object width="635" height="438"><param name="movie" value="'.$this->data["embed"].'"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="'.$this->data["embed"].'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$w.'" height="'.$h.'"></embed></object>';*/

            /*return '
            <embed flashVars="playerVars=autoPlay=no" src="'.$url.'" width="600" height="338" wmode="transparent" allowFullScreen="true" allowScriptAccess="always" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash">
            </embed>';*/
        }
    }
	
}