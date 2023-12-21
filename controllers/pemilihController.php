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

          $idKecamatan = $_REQUEST['idKecamatan'];

          $no_kk = filter_var($_POST['no_kk'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $nik = filter_var($_POST['nik'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $nama = filter_var($_POST['nama'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $tempat_lahir = filter_var($_POST['tempat_lahir'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $tanggal_lahir = filter_var($_POST['tanggal_lahir'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $jenis_kelamin = filter_var($_POST['jenis_kelamin'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $pekerjaan = filter_var($_POST['pekerjaan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $status_perkawinan = filter_var($_POST['status_perkawinan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $alamat = filter_var($_POST['alamat'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $kelurahan = filter_var($_POST['kelurahan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

          $kota = filter_var($_POST['kota'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $status_pemilih = filter_var($_POST['status_pemilih'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $tanggal_pindah_memilih = filter_var($_POST['tanggal_pindah_memilih'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $alasan = filter_var($_POST['alasan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $tps_asal = filter_var($_POST['tps_asal'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $tps_tujuan_pindah = filter_var($_POST['tps_tujuan_pindah'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        
          $sql = "INSERT INTO pemilih (no_kk, nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, pekerjaan, status_perkawinan, alamat, kelurahan, kecamatan, kota, status_pemilih, tanggal_pindah_memilih, alasan, tps_asal, tps_tujuan_pindah) 
          VALUES('$no_kk', '$nik', '$nama', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$pekerjaan', '$status_perkawinan', '$alamat', '$kelurahan', '$idKecamatan', '$kota', '$status_pemilih', '$tanggal_pindah_memilih', '$alasan', '$tps_asal', '$tps_tujuan_pindah')";
        
          // Move the uploaded image to a permanent location on the server
          try{
            $result = $conn->query($sql);
            $_SESSION['success-alert'] = 'Berhasil menambah data pemilih';
            header("Location: ../index.php");
            exit();
          }catch(PDOException $e){
            echo json_encode($e);
            $_SESSION['failed-alert'] = 'Gagal menambah data pemilih';
            header("Location: ../index.php");
            exit();
          }
        }
        $conn->close();
        break;

    case 'edit':
      if(isset($_POST['submit'])){

        $id = $_GET['id'];

        $no_kk = filter_var($_POST['no_kk'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $nik = filter_var($_POST['nik'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $nama = filter_var($_POST['nama'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tempat_lahir = filter_var($_POST['tempat_lahir'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tanggal_lahir = filter_var($_POST['tanggal_lahir'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $jenis_kelamin = filter_var($_POST['jenis_kelamin'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pekerjaan = filter_var($_POST['pekerjaan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $status_perkawinan = filter_var($_POST['status_perkawinan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $alamat = filter_var($_POST['alamat'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $kelurahan = filter_var($_POST['kelurahan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $kecamatan = filter_var($_POST['kecamatan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $kota = filter_var($_POST['kota'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $status_pemilih = filter_var($_POST['status_pemilih'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tanggal_pindah_memilih = isset($_POST['tanggal_pindah_memilih']) ? filter_var($_POST['tanggal_pindah_memilih'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : NULL;
        $alasan = isset($_POST['alasan']) ? filter_var($_POST['alasan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : NULL;
        $tps_asal = isset($_POST['tps_asal']) ? filter_var($_POST['tps_asal'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : NULL;
        $tps_tujuan_pindah = isset($_POST['tps_tujuan_pindah']) ? filter_var($_POST['tps_tujuan_pindah'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : NULL;
      
      
        $sql = "UPDATE pemilih 
        SET nama='$nama', 
        nik='$nik', 
        no_kk='$no_kk', 
        tempat_lahir='$tempat_lahir', 
        tanggal_lahir='$tanggal_lahir', 
        jenis_kelamin='$jenis_kelamin', 
        pekerjaan='$pekerjaan', 
        status_perkawinan='$status_perkawinan', 
        alamat='$alamat', 
        kelurahan='$kelurahan', 
        kecamatan='$kecamatan', 
        kota='$kota', 
        status_pemilih='$status_pemilih', 
        tanggal_pindah_memilih='$tanggal_pindah_memilih', 
        alasan='$alasan', 
        tps_asal='$tps_asal', 
        tps_tujuan_pindah='$tps_tujuan_pindah' WHERE id='$id'";
      
        // Move the uploaded image to a permanent location on the server
        try{
          $result = $conn->query($sql);
          $_SESSION['success-alert'] = 'Berhasil mengubah data pemilih';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        }catch(PDOException $e){
          $_SESSION['failed-alert'] = 'Gagal mengubah data pemilih';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        }
      }
      $conn->close();
        break;

    case 'delete':

        $id = $_GET['id'];
        $sql = "DELETE FROM pemilih WHERE id='$id'";
        try {
          $result = $conn->query($sql);
          $_SESSION['success-alert'] = 'Berhasil menghapus data pemilih';
          header("Location: " . $_SERVER['HTTP_REFERER']);
          exit();
        } catch (\Throwable $th) {
          $_SESSION['failed-alert'] = 'Gagal menghapus data pemilih';
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