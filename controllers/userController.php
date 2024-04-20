<?php
session_start();
// Check for the action parameter in the URL or form submission
$action = isset($_GET['action']) ? $_GET['action'] : '';

require '../db.php';
$conn = OpenCon();

// Handle different actions
switch ($action) {
    case 'add':
        if(isset($_POST['submit'])){
          $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
          $administrator = filter_var($_POST['administrator'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
        
        
          $sql = "INSERT INTO user (name, email, username, password, administrator) VALUES('$name','$email', '$username', '$password', '$administrator')";
        
          // Move the uploaded image to a permanent location on the server
          try{
            $result = $conn->query($sql);
            $_SESSION['success-alert'] = 'Berhasil menambah data user';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
          }catch(PDOException $e){
            $_SESSION['failed-alert'] = 'Gagal menambah data user';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
          }
        }
        $conn->close();
        break;

    case 'edit':
      if(isset($_POST['submit'])){

        $id = $_GET['id'];

        $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
        $administrator = filter_var($_POST['administrator'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
      
      
        $sql = "UPDATE user SET name='$name', email='$email', username='$username', password='$password', administrator='$administrator' WHERE id='$id' ";
      
        // Move the uploaded image to a permanent location on the server
        try{
          $result = $conn->query($sql);
          $_SESSION['success-alert'] = 'Berhasil mengubah data user';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        }catch(PDOException $e){
          $_SESSION['failed-alert'] = 'Gagal mengubah data user';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        }
      }
      $conn->close();
        break;

    case 'delete':

        $id = $_GET['id'];
        $sql = "DELETE FROM user WHERE id='$id'";
        try {
          $result = $conn->query($sql);
          $_SESSION['success-alert'] = 'Berhasil menghapus data user';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        } catch (\Throwable $th) {
          $_SESSION['failed-alert'] = 'Gagal menghapus data user';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        }
    
        $conn->close();
        
        break;

    default:
        // Default action or error handling
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
        break;

        case 'edit-profile':
          if(isset($_POST['submit'])){

            $id = $_GET['id'];

            $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $no_hp = filter_var($_POST['no_hp'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          
            $sql = "UPDATE user SET name='$name', email='$email', no_hp='$no_hp' WHERE id='$id' ";
          
            // Move the uploaded image to a permanent location on the server
            try{
              $result = $conn->query($sql);
              $_SESSION['success-alert'] = 'Berhasil mengubah data user';
              header("Location: " . $_SERVER['HTTP_REFERER']);
              exit();
            }catch(PDOException $e){
              $_SESSION['failed-alert'] = 'Gagal mengubah data user';
              header("Location: " . $_SERVER['HTTP_REFERER']);
              exit();
            }
          }
          $conn->close();
        break;

        case 'edit-password':
            $id = $_GET['id'];
            $newPassword = $_POST['newpassword'];
            $renewPassword = $_POST['renewpassword'];
            $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $usersql = "SELECT * FROM user WHERE id='$id'";
            $userpassword = $conn->query($usersql);
            $user = mysqli_fetch_assoc($userpassword);
          
            $sql = "UPDATE user SET password='$newPassword' WHERE id='$id' ";

            if($user['password'] !== $password){
              $_SESSION['failed-alert'] = 'Password salah';
              header("Location: " . $_SERVER['HTTP_REFERER']);
              exit();
            }else{
              if($newPassword === $renewPassword){
                try{
                  $result = $conn->query($sql);
                  $_SESSION['success-alert'] = 'Berhasil mengubah data user';
                  header("Location: " . $_SERVER['HTTP_REFERER']);
                  exit();
                }catch(PDOException $e){
                  $_SESSION['failed-alert'] = 'Gagal mengubah data user';
                  header("Location: " . $_SERVER['HTTP_REFERER']);
                  exit();
                }
              }else{
                $_SESSION['failed-alert'] = 'New password tidak sama';
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
              }
            }
          
          $conn->close();
        break;
}

// Include your view file or redirect to another page after processing

?>