<?php
session_start();
include "server.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['first_name'];
    setcookie("lastLogin", date("Y-m-d H:i:s"), time() + 3600);
    header("Location: homepage.php");
    exit();
  }
}

echo "Invalid email or password. <a href='login.html'>Try again</a>";
$conn->close();
?>
