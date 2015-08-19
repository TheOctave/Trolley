<?php

//check if the settings are made
if (isset($_GET['trolley'])) {
    
    $trolley = $_GET['trolley'];
    /*
     * Set up the database
     */
    $db = new PDO(DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST , DB_USER , DB_PASS);
    $query = "SELECT `trolley_name`, `last_longitude`, `last_latitude` FROM `trolleys` WHERE `trolley_name` = :trolley AND `active` = 1 ";
    $sth = $db->prepare($query);
    $success = $sth->execute(
            array(
                ':trolley' => $trolley
            ));

    /*
     * Create an array that will contain the result of the database query
     */
    $data = array();
    if ($success) {
        $latestCoordinate = $sth->fetch(PDO::FETCH_ASSOC);
        $data['status'] = 'success';
        $data['trolley'] = $latestCoordinate['trolley_name'];
        $data['long'] = $latestCoordinate['last_longitude'];
        $data['lat'] = $latestCoordinate['last_latitude'];
    } else {
        
        /*
         * A database error must have occured
         */
        $data['status'] = 'failure';
    }
    
    /*
     * an ajax call is presumed
     * return the longitude and latitude in json format
     */
    echo json_encode($data);
} else {
    
    /*
     * This is an error. respond with an error json
     */
    $data['status'] = 'failure';
    
    /*
     * echo back the failure in json format to the ajax call
     */
    echo json_encode($data);
}