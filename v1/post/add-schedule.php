<?php
  header('Access-Control-Allow-Origin: *');


header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/x-www-form-urlencoded');
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


//  Form Data
$schedule->userid = $_POST['userid'];
$schedule->day = $_POST['day'];
$schedule->time = $_POST['time'];
$schedule->title = $_POST['title'];
$schedule->description = $_POST['description'];
$schedule->vibrate = $_POST['vibrate'] == 'true' ? 0 : 1;
$schedule->toggle = $_POST['toggle'] == 'true' ? 0 : 1;
$schedule->notify = $_POST['notify']; 
$schedule->priority = $_POST['priority'] == 'true' ? 0 : 1;
$schedule->ringtone = $_POST['ringtone'];

if ($schedule->AddSchedule() > 0) {  // RETURNS ROWCOUNT
    echo json_encode(array('message' => 'Schedule Succesfully Created'));
} else {
  $error = [
    'status' => 500,
    'message' => 'ERROR: Cannot Create Task'
  ];
  echo json_encode($error);
}
