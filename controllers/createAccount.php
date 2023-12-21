<?php
require '../db.php';
$conn = OpenCon();

if(isset($_POST['submit'])){
  $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


  $sql = "INSERT INTO user (name, email, username, password, administrator) VALUES('$name','$email', '$username', '$password', 0)";

  // Move the uploaded image to a permanent location on the server
  try{
    $result = $conn->query($sql);
    header("Location: ../login.php");
    exit();
  }catch(PDOException $e){
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
  }
}


$conn->close();
?>