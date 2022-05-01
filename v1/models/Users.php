<?php
class Users
{
  // DB
  private $conn;

  // post properties
  public $id;
  public $name;
  public $email;
  public $password;


  // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Register
  public function Register()
  {
    $query = 'SELECT email FROM users where email=?';
    $stmt = $this->conn->prepare($query);

    $this->email = htmlspecialchars($this->email);
    $stmt->execute([$this->email]);
    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
      http_response_code(400);
      $error = ['message' => 'Email already in use'];
      echo json_encode($error);
      die();
    } else {
      $query = 'INSERT INTO users(name,email,password) 
             VALUES (:name,:email,:password)';

      $stmt = $this->conn->prepare($query);



      $this->name = htmlspecialchars($this->name);
      $this->email = htmlspecialchars($this->email);
      $this->password = htmlspecialchars($this->password);
      // hashing password
      $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

      $user = array(
        'name' => $this->name,
        'email' => $this->email,
        'password' => $hashedPassword
      );

      if ($stmt->execute($user)) {
        // Get Inserted ID and get details to start session
        $insertedID = $this->conn->lastInsertId();
        $query = 'SELECT id,email,name FROM users WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$insertedID]);

        $row = $stmt->fetch();

        return  $row;
      } else {
        printf("Error: %s.\n", $stmt->error);
        return false;
      }
    }
  } //end create



  // LOGIN
  public function Login()
  {

    
    $query = 'SELECT * FROM users WHERE email = ?';
    $stmt = $this->conn->prepare($query);

    // Clean Data      
    $this->email = htmlspecialchars($this->email);
    $stmt->execute([$this->email]);

    $rowCount = $stmt->rowCount();
    $row = $stmt->fetch();
  
    if ($rowCount > 0) {
      // de-hashing password
      $passwordCheck = password_verify($this->password, $row['password']);

      if ($passwordCheck) {  //if true = password matched
        return $row;
      } else {
        http_response_code(400);
        $error = [
          'status' => 400,
          'message' => 'Password do not match'
        ];
        echo json_encode($error);
        exit();
      }
    } else {
      http_response_code(400);
      $error = [

        'status' => 400,
        'message' => 'No user match detected'
      ];
      echo json_encode($error);
      

      exit();
    }
  }
}
