<?php

	$ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, 'http://www.ringcentral.com/api/index.php?cmd=getCountries');

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

	var_dump($output);
	echo "<br/><pre>";
	print_r($headers);
	echo "</pre>";

?>