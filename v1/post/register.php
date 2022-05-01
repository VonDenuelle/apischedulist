<?php
  // Headers
  header('Access-Control-Allow-Origin: *');

    // CORS issue- sending options req before post resulting in multiple requests
    // make the content type- x-www-form but let the server auto decide

  header('Access-Control-Allow-Methods: POST'); //for POST
  header('Content-Type: application/json');
  header("Access-Control-Allow-Credentials: true");
  header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Accept, Access-Control-Allow-Credentials, Access-Control-Allow-Methods, Content-Type,  Authorization, X-Requested-With '); //X-requested-with for XSS and other stuff
  $method = $_SERVER['REQUEST_METHOD'];
  if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods:  POST'); 
    header('Content-Type: application/json');
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Access-Control-Allow-Headers, Accept, Access-Control-Allow-Credentials, Access-Control-Allow-Methods, Content-Type,  Authorization, X-Requested-With ');
    http_response_code(200);
    exit();
  }
  include_once '../config/Database.php';
  include_once '../models/Users.php';
  include_once '../models/jwt/jwt.php';
  // Instantiate DB and connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate object
    $user = new Users($db);


  // // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $user->name = $data->name;
  $user->email = $data->email;
  $user->password = $data->password;
  
  // $user->name = $_POST['name'];
  // $user->email = $_POST['email'];
  // $user->password = $_POST['password'];


// Register
  if ($res = $user->Register()) {
    // Generate Token
    $headers = array('alg' => 'HS256', 'typ' => 'JWT');

    $jwt = new JWT();
    $token = $jwt->generate_jwt($headers, $res);

    http_response_code(200);
    echo json_encode(array('token' => $token));

  } else {
    http_response_code(400);
    $error = ['message' => 'ERROR: Server Error'];
    echo json_encode($error);
  }
