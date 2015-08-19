<?php
/*
* Set up the database
*/
$db = new PDO(DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST , DB_USER , DB_PASS);
$query = "SELECT `key`, `name`, `alias`, `longitude`, `latitude` FROM `trolley_stops`";
$sth = $db->prepare($query);
$success = $sth->execute();

/*
* Create an array that will contain the result of the database query
*/
$data = array();
if ($success) {
   $stopsData = $sth->fetchAll(PDO::FETCH_ASSOC);
   $data['status'] = 'success';
   $data['stops'] = $stopsData;
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