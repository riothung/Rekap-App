<?php
require '../db.php';
$conn = OpenCon();

if(isset($_POST['submit'])){
  $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $jabatan = filter_var($_POST['jabatan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $noHp = filter_var($_POST['no_hp'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  // $kota = filter_var($_POST['kota'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  // $kabupaten = filter_var($_POST['kabupaten'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  // $provinsi = filter_var($_POST['provinsi'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $kota = "Kupang";
  // $kabupaten = "Kabupaten Kupang";


  $provinsi = "Nusa Tenggara Timur";


  $sql = "INSERT INTO user (name, email, username, password, jabatan, administrator, no_hp, kota, provinsi) VALUES('$name','$email', '$username', '$password','$jabatan', 0, '$noHp', '$kota', '$provinsi')";

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