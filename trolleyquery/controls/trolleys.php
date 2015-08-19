<?php

/*
 * Set up the database
 */
$db = new PDO(DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);

/*
 * Prepare the query
 */
$query = "SELECT trolley_name, present_route, active FROM trolleys";
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
