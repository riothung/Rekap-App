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
}

// Include your view file or redirect to another page after processing

?>