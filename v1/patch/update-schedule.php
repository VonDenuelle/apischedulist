<?php
  header('Access-Control-Allow-Origin: *');


header('Access-Control-Allow-Methods: PATCH');
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

// JSon for patch methods (update)
$data = json_decode(file_get_contents("php://input"));

$schedule->day = $data->day;
$schedule->time = $data->time;
$schedule->title = $data->title;
$schedule->description = $data->description;
$schedule->vibrate = $data->vibrate === true ? 0 : 1; //boolean to tinyint
$schedule->toggle = $data->toggle === true ? 0 : 1;
$schedule->id = $data->id;
$schedule->notify = $data->notify;
$schedule->priority = $data->priority  == 'true' ? 0 : 1;
$schedule->ringtone = $data->ringtone;

if ($res = $schedule->updateSchedule()) { 
    echo json_encode(array('message' => 'Schedule Succesfully Updated', 'response' => $res));
} else {
  $error = [
    'status' => 500,
    'message' => 'ERROR: Cannot Create Task'
  ];
  echo json_encode($error);
}
