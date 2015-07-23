<?php

// IDEA

/* make sure this isn't called from a web browser */
if (isset($_SERVER['REMOTE_ADDR'])) die('Permission denied.');

$baseUrl = '';
switch ($_SERVER['PWD']) {
    case '/var/www/own-projects/videouri.com':
        $baseUrl = 'http://local.videouri.com';
        break;
    default:
        $baseUrl = 'http://videouri.com';
}

if ($argc <= 1 || $argc > 4) {
    showUsage();
}

$command = $argv[1];
if (!in_array($command, array('frontPageFeaturedVideos'))) {
    showUsage();
}

exec($command($baseUrl));

function frontPageFeaturedVideos($baseUrl)
{
    //?source=YouTube&sorts=most_viewed&period=week
    $source = 'YouTube,Metacafe,Dailymotion';
    $sorts  = 'most_viewed';
    $period = 'week';

    $urlToCall = $baseUrl.'/api/getVideos?source='.$source.'&sorts='.$sorts.'&period='.$period;
    $videos = curl_get($urlToCall);
    var_dump($videos);
    die;
}





function showUsage()
{
    echo "
###########
## Usage ##
###########\n";
    echo "\t php videouriCron.php command [arguments]\n";

    echo "
##############
## Commands ##
##############\n";
    echo "\tfrontPageFeaturedVideos SORT PERIOD SOURCE\n";
    echo "\t\t SORT   => top-rated, most-viewed, most_commented\n";
    echo "\t\t PERIOD => today, week, month, ever\n";
    echo "\t\t SOURCE => all, YouTube, Dailymotion, Metacafe, Vimeo\n";
    echo "\n\n";
    die();
}

function curl_get($url)
{
    // Initiate the curl session
    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);

    // Removes the headers from the output
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // Return the output instead of displaying it directly
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    // Execute the curl session
    $output = curl_exec($ch);

    // Return headers
    $headers = curl_getinfo($ch);
    
    // Close the curl session
    curl_close($ch);

    return $output;
}