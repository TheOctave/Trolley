<?php

/**
 * This script handles the logout from the gps device
 */

include 'config.php';
include 'libs/Hash.php';
include 'deviceAlias.php';

/*
 * Check for all params
 */
if (isset($_POST['handle']) && isset($_POST['device']) && isset($trolleyAlias[$_POST['device']])) {
    
    $handle = $_POST['handle'];
    $device = $_POST['device'];
    
    $db = new PDO(DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST , DB_USER , DB_PASS);
    
    $query = "SELECT fname FROM `racers` WHERE `handle` = :handle AND `current_device` = :device";
    $sth = $db->prepare($query);
    $success = $sth->execute(array(
        ':handle' => $handle,
        ':device' => $device
    ));
    
    $result = array();
    if ($success) {
        
        $numRows = $sth->rowCount();
        if ($numRows == 1) {
            
            $query = "UPDATE `racers` SET `active` = 0, `current_device` = NULL WHERE `handle` = :handle";
            $sth = $db->prepare($query);
            $successA = $sth->execute(array(
                ':handle' => $handle
            ));
            
            $query = "UPDATE `trolleys` SET `active` = 0 WHERE `device` = :device";
            $sth = $db->prepare($query);
            $successB = $sth->execute(array(
                ':device' => $device
            ));
            
            if ($successA && $successB) {
                
                $ch = curl_init();

                $postData = array(
                    'name' => $trolleyAlias[$_POST['device']]
                );

                curl_setopt($ch, CURLOPT_URL, 'http://localhost:3000/stopTrolley');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

                $output = curl_exec($ch);
                
                $result['status'] = 'success';
            } else {
                $result['status'] = 'failure';
            }
        } else {
            
            $result['status'] = 'failure';
        }
        
    } else {
        
        $result['status'] = 'failure';
    }
    
    /*
     * Return status of request (success or failure)
     */
    echo json_encode($result);
} else {
    /*
     * Params are incorrect. Return failure code
     */
    $result = array(
        'status' => 'failure'
    );
    
    echo json_encode($result);
}