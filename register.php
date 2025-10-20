<?php
include "server.php";

$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$passport = $_POST['passport'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (first_name, last_name, email, phone, passport, password)
VALUES ('$fname', '$lname', '$email', '$phone', '$passport', '$password')";

if ($conn->query($sql) === TRUE) {
  echo "Registration successful! <a href='login.html'>Login now</a>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
