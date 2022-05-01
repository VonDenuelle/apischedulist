<?php
  header('Access-Control-Allow-Origin: *');


header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Access-Control-Allow-Headers, Accept, Access-Control-Allow-Credentials, Access-Control-Allow-Methods, Content-Type,  Authorization, X-Requested-With ');



include_once '../config/Database.php';
include_once '../models/Schedule.php';
include_once '../models/jwt/jwt.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Schedule  object
$schedule = new Schedule($db);


$schedule->id = $_GET['id'];


if ($row = $schedule->scheduleById()) {
    echo json_encode(array('response' => $row));
} else {
    echo json_encode(array("success" => 'success'));
}
