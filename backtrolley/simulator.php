<?php

/*
 * This is a tiny script to simulate the movement of a trolley
 */
$myfile = fopen('coordinates.txt', 'r') or die('Unable to open file');

while (!feof($myfile)) {
    $line = fgets($myfile);
    $coordinates = explode(' ', $line);
    print_r($coordinates);
    
    /*
     * Transmit ccoordinates to the node server
     */
    $ch = curl_init();

    $postData = array(
        'name' => 'raven',
        'latitude' => $coordinates[0],
        'longitude' => $coordinates[1]
    );
    
    curl_setopt($ch, CURLOPT_URL, 'http://localhost:3000/update');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    
    $output = curl_exec($ch);
    
    echo '<br />';
    
    sleep(1);
}

fclose($myfile);