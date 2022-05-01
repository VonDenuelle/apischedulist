<?php
  header('Access-Control-Allow-Origin: *');


header('Access-Control-Allow-Methods: DELETE');
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

if ($schedule->deleteSchedule()) {
    echo json_encode(array('message' => 'Schedule Successfully Deleted'));
} else {
    echo json_encode(array("success" => 'success'));
}
