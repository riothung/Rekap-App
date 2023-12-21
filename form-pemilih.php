<?php include './partials/header.php'?>
<?php 
$id = $_REQUEST['id'];
$sql = "SELECT * FROM kecamatan WHERE id='$id'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

$sqlTPS = "SELECT * FROM tps";
// $sqlTPS = "SELECT * FROM tps WHERE tps.kecamatan='$id'";
$result = $conn->query($sqlTPS);
$dataTPS = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $dataTPS[] = $row; // append each row to the data array
}
$conn->close();

?>
  <main id="main" class="main">

    
    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
         
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Form Data Pemilih</h5>

            <!-- Multi Columns Form -->
            <form method="POST" action="./controllers/pemilihController.php?action=add&idKecamatan=<?=$id?>" class="row g-3">
            <div class="col-md-6">
                <label for="inputEmail5" class="form-label">No.KK</label>
                <input type="text" name="no_kk" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label for="inputPassword5" class="form-label">NIK</label>
                <input type="text" name="nik" class="form-control" required>
              </div>
              <div class="col-md-12">
                <label for="inputName5" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label for="inputEmail5" class="form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" id="inputEmail5">
              </div>
              <div class="col-md-3">
                <label for="inputPassword5" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" id="inputPassword5">
              </div>
              <div class="col-md-3">
                <label for="inputPassword5" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" id="">
                  <option value="Perempuan">Perempuan</option>
                  <option value="Laki-Laki">Laki-Laki</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="inputPassword5" class="form-label">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control" id="inputPassword5">
              </div>
              <div class="col-6">
                <label for="inputAddress5" class="form-label">Status Perkawinan</label>
                <select name="status_perkawinan" class="form-select" id="">
                  <option value="Menikah">Menikah</option>
                  <option value="Belum Menikah">Belum Menikah</option>
                </select>
              </div>
              <div class="col-12">
                <label for="inputAddress2" class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" id="inputAddress2">
              </div>
              <div class="col-md-4">
                <label for="inputCity" class="form-label">Kelurahan</label>
                <input type="text" name="kelurahan" class="form-control" id="inputCity">
              </div>
              <div class="col-md-4">
                <label for="inputZip" class="form-label">Kecamatan</label>
                <input type="text" disabled value="<?=$data['kecamatan']?>" name="kecamatan" class="form-control" id="inputZip">
              </div>
              <div class="col-md-4">
                <label for="inputZip" class="form-label">Kab/Kota</label>
                <input type="text" name="kota" class="form-control" id="inputZip">
              </div>
              <div class="col-md-4">
                <label for="inputZip" class="form-label">Status Pemilih</label>
                <select name="status_pemilih" class="form-select" id="status_pemilih">
                  <option value="Khusus">Khusus</option>
                  <option value="Pindah Tugas">Pindah Tugas</option>
                  <option value="Pindah Karena Sakit">Pindah Karena Sakit</option>
                  <option value="Tahanan dan Pidana">Tahanan dan Pidana</option>
                  <option value="Bencana">Bencana</option>
                  <option value="Rawat Inap">Rawat Inap</option>
                  <option value="Mendampingi Keluarga Rawat Inap">Mendampingi Keluarga Rawat Inap</option>
                  <option value="Disabilitas">Disabilitas</option>
                  <option value="Narkoba">Narkoba</option>
                  <option value="Tugas Belajar">Tugas Belajar</option>
                  <option value="Pindah Domisili">Pindah Domisili</option>
                  <option value="Bekerja di Luar Domisili">Bekerja di Luar Domisili</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
              </div>
              <div class="row mt-3">
                <div class="col-md-4 d-none" id="tanggal_pindah">
                  <label for="inputZip" class="form-label">Tanggal Pendaftaran Pindah Memilih</label>
                  <input type="date" name="tanggal_pindah_memilih" class="form-control" id="inputZip">
                </div>
                <div class="col-md-6 d-none" id="alasan">
                  <label for="inputZip" class="form-label">Alasan</label>
                  <input type="text" name="alasan" class="form-control" id="inputZip">
                </div>
              </div>
              <div class="row pt-3" id='tps_asal'>
                <div class="col-md-6">
                  <label for="inputZip" class="form-label">TPS Asal</label>
                  <select name="tps_asal" class="form-select" id="">
                    <option value="">--Pilih TPS Asal--</option>
                    <?php foreach($dataTPS as $row):?>
                      <option value="<?=$row['id']?>"><?=$row['no_tps']?></option>
                    <?php endforeach?>
                  </select>
                </div>
                <div class="col-md-6 d-none" id="tps_pindah">
                  <label for="inputZip" class="form-label">TPS Tujuan Pindah</label>
                  <select name="tps_tujuan_pindah" class="form-select" id="">
                    <option value="">--Pilih TPS Tujuan Pindah--</option>
                    <?php foreach($dataTPS as $row):?>
                      <option value="<?=$row['id']?>"><?=$row['no_tps']?></option>
                    <?php endforeach?>
                  </select>
                </div>
              </div>
              <div class="text-center col-md-12">
                <button type="submit" name="submit" class="btn btn-primary w-100">Submit</button>
              </div>
            </form><!-- End Multi Columns Form -->

          </div>
        </div>

        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <script>
    let statusPemilih = document.getElementById('status_pemilih')
    let tanggalPindah = document.getElementById('tanggal_pindah')
    let alasan = document.getElementById('alasan')
    let tps_asal = document.getElementById('tps_asal')
    let tps_pindah = document.getElementById('tps_pindah')

    console.log(statusPemilih?.value);
    statusPemilih.addEventListener('change', ()=>{
      if(statusPemilih?.value !== 'Khusus'){
        tanggalPindah.classList.remove('d-none')
        tps_pindah.classList.remove('d-none')
      }else{
        tanggalPindah.classList.add('d-none')
        tps_pindah.classList.add('d-none')
      }

      if(statusPemilih.value === 'Lainnya'){
        alasan.classList.remove('d-none')
      }else{
        alasan.classList.add('d-none')

      }
    })
  </script>

  <?php include './partials/footer.php'?> 