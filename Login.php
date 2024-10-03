<?php

class Database {
  private $host = 'localhost';
  private $username = 'root';
  private $password = '020504';
  private $database = 'CAT1';

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

session_start();

if (isset($_POST['login'])) {
  $db = new Database();

  $username = $_POST['username'];
  $password = $_POST['password'];

  // Fetch the user from the database
  $sql = 'SELECT * FROM users WHERE username = :username';
  $stmt = $db->query($sql, [':username' => $username]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    // Password is correct, set session variables
    $_SESSION['username'] = $user['username'];
    echo 'Login successful. Welcome, ' . $user['username'] . '!';
    // Redirect to another page (e.g., dashboard.php) if desired
    // header("Location: dashboard.php");
    exit;
  } else {
    echo 'Invalid username or password.';
  }
}

?>

<html>
<head>
  <title>Login Form</title>
  <style>
    body {
      font-family: sans-serif;
      background-image: url('image/car.jpg'); 
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
      margin: 0;
      padding: 0;
      height: 100vh;
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
  <h1>Login Form</h1>

  <form action="" method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
  </form>
</body>
</html>
