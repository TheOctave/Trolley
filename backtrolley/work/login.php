<?php

/**
 * This script handles the login from the gps device
 */

include 'config.php';
include 'libs/Hash.php';
include 'deviceAlias.php';

/*
 * Check all params
 */
if (isset($_POST['handle']) && isset($_POST['password']) && isset($_POST['device'])
        && isset($trolleyAlias[$_POST['device']])) {
    
    $handle = $_POST['handle'];
    $password = Hash::generateHashedString($_POST['password']);
    $device = $_POST['device'];
    
    /*
     * Check for existence of user
     */
    $db = new PDO(DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST , DB_USER , DB_PASS);
    $query = "SELECT fname FROM `racers` WHERE `handle` = :handle AND `password` = :password";
    $sth = $db->prepare($query);
    $success = $sth->execute(array(
                    ':handle' => $handle,
                    ':password' => $password
                ));
    
    
    $result = array();
    if ($success) {
        
        $numRows = $sth->rowCount();
        if ($numRows == 1) {

            $resultArray = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            /*
             * Set the trolley as active
             */
            $query = "UPDATE `trolleys` SET `active` = 1 WHERE `device` = :device";
            $sth = $db->prepare($query);
            $successA = $sth->execute(array(
                ':device' => $device
            ));
            
            $query = "UPDATE `racers` SET `active` = 1, `current_device` = :device WHERE `handle` = :handle";
            $sth = $db->prepare($query);
            $successB = $sth->execute(array(
                ':handle' => $handle,
                ':device' => $device
            ));
            
            if ($successA && $successB) {
                
                /*
                 * Prepare the request status array to return
                 */
                $result['status'] = 'success';
                $result['user'] = $handle;
                $result['name'] = $resultArray[0]['fname'];
                $result['time'] = time();
            } else {
                $result['status'] = 'failure';
            }
        } else {
            
            $result['status'] = 'failure';
        }
        
    } else {
        
        $result['status'] = 'failure';
    }
    
    echo json_encode($result);
} else {
    
    /*
     * Return failure code
     */
    $result = array(
        'status' => 'failure'
    );
    
    echo json_encode($result);
}