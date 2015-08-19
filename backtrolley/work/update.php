<?php

include 'deviceAlias.php';

/**
 * Make a check for all parameters
 */
if (isset($_POST['device']) && isset($_POST['latitude']) && isset($_POST['longitude'])
        && $trolleyAlias[$_POST['device']] && is_float(floatval($_POST['latitude'])) && is_float(floatval($_POST['longitude']))) {
    
    /*
     * Transmit coordinates and trolley name to the node.js server
     */
    $ch = curl_init();

    $postData = array(
        'name' => $trolleyAlias[$_POST['device']],
        'latitude' => $_POST['latitude'],
        'longitude' => $_POST['longitude']
    );
    
    curl_setopt($ch, CURLOPT_URL, 'http://localhost:3000/update');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    
    $output = curl_exec($ch);
    
    /*
     * Return a success status
     */
    $data = array(
        'status' => 'success',
        'device' => $_POST['device']
    );
    
    echo json_encode($data);
} else {
    
    $data = array(
        'status' => 'failure'
    );
    
    return json_encode($data);
}

