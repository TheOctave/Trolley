<?php

/*
 * This little script helps collect coordinates around campus from the gps device
 */
$file = 'coordinates.txt';

$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$contents = $latitude . ' ' . $longitude . "\n";

$coordinate = file_put_contents($file, $contents, FILE_APPEND | LOCK_EX);
echo 'Completed';