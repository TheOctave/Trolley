<?php

include 'config.php';
include 'libs/Hash.php';

if (isset($_GET['route']) && isset($_GET['value'])) {
    
    $route = $_POST['route'];
    $value = filter_var($_GET['value'], FILTER_VALIDATE_BOOLEAN);
    
    if (!is_bool($value)) {
        $result = array('status' => 'failure');
        json_encode($result);
    }
    
    $query = "UPDATE `racers` WHERE `handle` = :handle AND `current_device` = :device";
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
    
    echo json_encode($result);
} else {
    $result = array(
        'status' => 'failure'
    );
    
    echo json_encode($result);
}