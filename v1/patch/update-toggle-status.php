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

$schedule->toggle = $data->toggle == true ? 0 : 1;  //boolean to tinyint
$schedule->id = $data->id;

if ($schedule->updateToggle()) { 
    echo json_encode(array('message' => $schedule->toggle));
} else {
  $error = [
    'status' => 500,
    'message' => 'ERROR: Cannot Create Task'
  ];
  echo json_encode($error);
}
