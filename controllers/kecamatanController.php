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
        $kecamatan = filter_var($_POST['kecamatan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
      
      
        $sql = "INSERT INTO kecamatan (kecamatan) VALUES('$kecamatan')";
      
        // Move the uploaded image to a permanent location on the server
        try{
          $result = $conn->query($sql);
          $_SESSION['success-alert'] = 'Berhasil menambah data kecamatan';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        }catch(PDOException $e){
          $_SESSION['failed-alert'] = 'Gagal menambah data kecamatan';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        }
      }
        $conn->close();
        break;

    case 'edit':
      if(isset($_POST['submit'])){

        $id = $_REQUEST['id'];
      
        $kecamatan = filter_var($_POST['kecamatan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
      
      
        $sql = "UPDATE kecamatan SET kecamatan='$kecamatan' WHERE id='$id'";
      
        // Move the uploaded image to a permanent location on the server
        try{
          $result = $conn->query($sql);
          $_SESSION['success-alert'] = 'Berhasil mengubah data kecamatan';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        }catch(PDOException $e){
          $_SESSION['failed-alert'] = 'Gagal mengubah data kecamatan';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        }
      }
      $conn->close();
        break;

    case 'delete':

        $id = $_GET['id'];
        $sql = "DELETE FROM kecamatan WHERE id='$id'";
        try {
          $result = $conn->query($sql);
          $_SESSION['success-alert'] = 'Berhasil menghapus data kecamatan';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        } catch (\Throwable $th) {
          $_SESSION['failed-alert'] = 'Gagal menghapus data kecamatan';
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