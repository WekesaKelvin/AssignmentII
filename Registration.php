<?php

class Database {
  private $host = 'localhost';
  private $username = 'root';
  private $password = '';
  private $database = 'my_database';

  private $pdo;

  public function __construct() {
    $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->username, $this->password);
  }

  public function query($sql, $params = []) {
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt;
  }
}

if (isset($_POST['register'])) {
  $db = new Database();

  $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
  $stmt = $db->query($sql, [
    ':username' => $_POST['username'],
    ':email' => $_POST['email'],
    ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
  ]);

  if ($stmt->rowCount() > 0) {
    echo 'User successfully registered';
  } else {
    echo 'Error registering user.';
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    
    // Check if the username already exists
    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $stmt_check->bindParam(':username', $username);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();
    
    if ($count > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
        // Proceed with the insertion
        $stmt_insert = $pdo->prepare("INSERT INTO users (username, email) VALUES (:username, :email)");
        $stmt_insert->bindParam(':username', $username);
        $stmt_insert->bindParam(':email', $email);
        
        if ($stmt_insert->execute()) {
            echo "Registration successful.";
        } else {
            echo "Error: " . $stmt_insert->errorInfo()[2];
        }
    }
}

  
$db = new Database();

$sql = 'SELECT * FROM users';
$stmt = $db->query($sql);

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
  echo $user['username'] . ' - ' . $user['email'] . '<br>';
}
}

?>

<html>
<head>
  <title>Registration Form</title>
  <style>
    body {
      font-family: sans-serif;
      background-image: url('image/car.jpg'); 
    background-size: cover;
    background-position: center;
    background-attachment: fixed; /* Optional, for a fixed background */
    background-repeat: no-repeat;
    margin: 0;
    padding: 0;
    height: 100vh
    }

    form {
      width: 500px;
      margin: 0 auto;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
    }

    button {
      background-color: #000;
      color: #fff;
      padding: 10px;
      margin-top: 10px;
      border: none;
    }
    h1 {
      text-align: center;
      background-color: aqua;
    }
  </style>
</head>
<body>
  <h1>Registration Form</h1>

  <form action="" method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <button type="submit" name="register">Register</button>
  </form>
</body>
</html>


