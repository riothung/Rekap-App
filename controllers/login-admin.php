<?php
  require '../db.php';
  session_start();
  $conn = OpenCon();

  if(isset($_POST['submit'])){
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$username){
      $_SESSION['login-admin-error'] = 'Username harus diisi';
    }elseif(!$password){
      $_SESSION['login-admin-error'] = 'Password harus diisi';
    }else{
      $query = "SELECT * FROM user WHERE username='$username' AND password='$password' AND administrator=1";
      $success;
      $fetch_user = $conn->query($query);
      if (mysqli_num_rows($fetch_user) == 1){
        $user = mysqli_fetch_assoc($fetch_user);
        $_SESSION['user-id'] = $user['id'];
        if($user['administrator'] > 0){
          $_SESSION['is-admin'] = true;
          header('Location: ../index.php');
          exit();
        }
        header('Location: ../index.php');
        exit();
        
      }else{
        $_SESSION['login-admin-error'] = 'User not found';
      }
    }

    if(isset($_SESSION['login-admin-error'])){
      $_SESSION['login-data'] = $_POST;
      header('Location: ../login-admin.php');
      exit();
    }
  }else{
    header('Location: ../login-admin.php');
    exit();
  }

  $conn->close();
?>