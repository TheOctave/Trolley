<?php

include 'config.php';
include 'libs/Hash.php';
include 'deviceAlias.php';
include 'routeCheck.php';

/*
 * Check for all params
 */
if (isset($_POST['device']) && isset($_POST['route']) && isset($trolleyAlias[$_POST['device']])
        && isValidRoute($_POST['route'])) {
    
    $device = $_POST['device'];
    $route = $_POST['route'];
    
    /*
     * Prepare and execute database query
     */
    $db = new PDO(DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST , DB_USER , DB_PASS);
    $query = "UPDATE `trolleys` SET `present_route` = :route WHERE `device` = :device";
    $sth = $db->prepare($query);
    $success = $sth->execute(array(
                    ':device' => $device,
                    ':route' => $route
                ));
    
    $result = array();
    /*
     * If query's successful, send the details about the route change to the node server
     */
    if ($success) {
        
        $ch = curl_init();

        $postData = array(
            'name' => $trolleyAlias[$_POST['device']],
            'route' => $_POST['route']
        );

        curl_setopt($ch, CURLOPT_URL, 'http://localhost:3000/routeChange');      
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

        $output = curl_exec($ch);
        
        $result['status'] = 'success';
    } else {
        
        $result['status'] = 'failure';
    }
    
    /*
     * Return status of request (success or failure)
     */
    echo json_encode($result);
} else {
    
    /*
     * Invalid params. Return a failure code
     */
    $result = array(
        'status' => 'failure'
    );
    
    echo json_encode($result);
}