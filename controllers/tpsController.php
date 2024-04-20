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
          $no_tps = filter_var($_POST['no_tps'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $kelurahan = filter_var($_POST['kelurahan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $kecamatan = filter_var($_POST['kecamatan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $kota = filter_var($_POST['kota'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $provinsi = filter_var($_POST['provinsi'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
          $sql = "INSERT INTO tps (kelurahan, no_tps, kecamatan, kota, provinsi) VALUES('$kelurahan','$no_tps', '$kecamatan', '$kota', '$provinsi')";
        
          // Move the uploaded image to a permanent location on the server
          try{
            $result = $conn->query($sql);
            $_SESSION['success-alert'] = 'Berhasil menambah data tps';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
          }catch(PDOException $e){
            $_SESSION['failed-alert'] = 'Gagal menambah data tps';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
          }
        }
        $conn->close();
        break;

    case 'edit':
      if(isset($_POST['submit'])){

        $id = $_GET['id'];

        $no_tps = filter_var($_POST['no_tps'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $kelurahan = filter_var($_POST['kelurahan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $kecamatan = filter_var($_POST['kecamatan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $kota = filter_var($_POST['kota'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $provinsi = filter_var($_POST['provinsi'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      
      
        $sql = "UPDATE tps SET no_tps='$no_tps', kelurahan='$kelurahan', kecamatan='$kecamatan', kota='$kota', provinsi='$provinsi' WHERE id='$id'";
      
        // Move the uploaded image to a permanent location on the server
        try{
          $result = $conn->query($sql);
          $_SESSION['success-alert'] = 'Berhasil mengubah data tps';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        }catch(PDOException $e){
          $_SESSION['failed-alert'] = 'Gagal mengubah data tps';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        }
      }
      $conn->close();
        break;

    case 'delete':

        $id = $_GET['id'];
        $sql = "DELETE FROM tps WHERE id='$id'";
        try {
          $result = $conn->query($sql);
          $_SESSION['success-alert'] = 'Berhasil menghapus data tps';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        } catch (\Throwable $th) {
          $_SESSION['failed-alert'] = 'Gagal menghapus data tps';
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