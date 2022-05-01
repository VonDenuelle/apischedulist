<?php
  header('Access-Control-Allow-Origin: *');


header('Access-Control-Allow-Methods: POST');
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


// Get raw  data
$data = json_decode(file_get_contents("php://input"));

$schedule->userid = $data->userid;
$schedule->day = $data->day;
$schedule->time = $data->time;



if ($schedule->checkDayAndTimeConflicts() > 0) {
    echo json_encode(array("message" => "There's a conflict of schedule: on ".$schedule->day.  ", " . $schedule->time));
} else {
    echo json_encode(array("message" => 'success'));
}
