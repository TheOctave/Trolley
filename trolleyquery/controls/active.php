<?php
/**
 * This script fetches the active trolleys
 */

/*
 * Check the parameters
 */
if (isset($_GET['campus']) && isset($_GET['extended']) &&
        isset($_GET['nathanBisk']) && isset($_GET['downtown'])) {
    
    /*
     * Convert the get variables to boolean
     */
    $campus = filter_var($_GET['campus'], FILTER_VALIDATE_BOOLEAN);
    $extended = filter_var($_GET['extended'], FILTER_VALIDATE_BOOLEAN);
    $nathanBisk = filter_var($_GET['nathanBisk'], FILTER_VALIDATE_BOOLEAN);
    $downtown = filter_var($_GET['downtown'], FILTER_VALIDATE_BOOLEAN);
    
    if (!$campus && !$extended && !$nathanBisk && !$downtown) {
        $data = array('status' => 'failure');
        echo json_encode($data);
        
        die;
    }
    
    /*
     * Set up the database
     */
    $db = new PDO(DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST , DB_USER , DB_PASS);
    
    /*
     * Build query string. This is a slightly complicated process because of the dynamic sql involved
     */
    $firstRoute = true;
    $query = "SELECT `trolley_name`, `present_route` FROM `trolleys` WHERE (";
    
    if ($campus === true) {
        $firstRoute = false;
        $query .= "`present_route` = 'campus'";
    }
    
    if ($extended === true) {
        if ($firstRoute === false) {
            $query .= " OR ";
        } else {
            $firstRoute = false;
        }
        $query .= "`present_route` = 'extended'";
    }
    
    if ($nathanBisk === true) {
        if ($firstRoute === false) {
            $query .= " OR ";
        } else {
            $firstRoute = false;
        }
        $query .= "`present_route` = 'nathanBisk'";
    }
    
    if ($downtown === true) {
        if ($firstRoute === false) {
            $query .= " OR ";
        } else {
            $firstRoute = false;
        }
        $query .= "`present_route` = 'downtown'";
    }
    
    $query .= ") AND `active` = 1";
    
    /*
     * Prepare the constructed query;
     */
    $sth = $db->prepare($query);
        
    /*
     * Execute the prepared query
     */
    $success = $sth->execute();

    /*
     * Create an array that will contain the result of the database query
     */
    $data = array();
    if ($success) {
        $trolleys = $sth->fetchAll(PDO::FETCH_ASSOC);
        $data['status'] = 'success';
        $data['trolleys'] = $trolleys;
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
     * Throw an error
     */
    $data['status'] == "failure";
    
    echo json_encode($data);
}