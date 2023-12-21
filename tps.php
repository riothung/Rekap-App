<?php 
include './partials/header.php';


$sql = "SELECT * FROM kecamatan";
$result = $conn->query($sql);
$data = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $data[] = $row; // append each row to the data array
}

$sqlTPS = "SELECT *, kecamatan.id as idKecamatan, tps.id as idTps FROM tps JOIN kecamatan ON tps.kecamatan=kecamatan.id";
$result = $conn->query($sqlTPS);
$dataTPS = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $dataTPS[] = $row; // append each row to the data array
}
$conn->close();
echo json_encode($data);

?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>TPS</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">TPS</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
          <?php if(isset($_SESSION['success-alert'])):?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            <?= $_SESSION['success-alert']; unset($_SESSION['success-alert'])?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php endif;?>
          <?php if(isset($_SESSION['failed-alert'])):?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            <?= $_SESSION['failed-alert']; unset($_SESSION['failed-alert'])?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php endif;?>
            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="p-3">
                  <!-- Vertically centered Modal -->
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#verticalycentered">
                    <i class="bi bi-plus"></i>
                    Tambah TPS
                  </button>
                  <div class="modal fade" id="verticalycentered" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Tambah TPS</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="./controllers/tpsController.php?action=add" method="POST" class=" w-100 d-flex flex-column gap-3 bg-white rounded p-4">
                          <div>
                            <label for="no_tps" class="form-label">No TPS</label>
                            <input type="text" autofocus name="no_tps" required class="form-control">
                          </div>
                          <div>
                            <label for="kelurahan" class="form-label">Kelurahan/Desa</label>
                            <input type="text" autofocus name="kelurahan" required class="form-control">
                          </div>
                          <div>
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select name="kecamatan" id="" class="form-select" required>
                              <option value="">--Pilih Kecamatan--</option>
                              <?php foreach($data as $value):?>
                                <option value="<?=$value['id']?>"><?=$value['kecamatan']?></option>
                              <?php endforeach;?>
                            </select>
                          </div>
                          <div>
                            <label for="kota" class="form-label">Kab/Kota</label>
                            <input type="text" autofocus name="kota" required class="form-control">
                          </div>
                          <div>
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control">
                          </div>
                          <button type="submit" name="submit" class="btn btn-success">Tambah TPS</button>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div><!-- End Vertically centered Modal-->

                </div>

                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">Data Kecamatan</h5>

                  <table class="table datatable table-hover table-responsive">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">No TPS</th>
                        <th scope="col">Kelurahan/Desa</th>
                        <th scope="col">Kecamatan</th>
                        <th scope="col">Kab/Kota</th>
                        <th scope="col">Provinsi</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($dataTPS as $key=>$row):?>
                      <tr>
                        <td><?= $key + 1?></td>
                        <td><?= $row['no_tps']?></td>
                        <td><?= $row['kelurahan']?></td>
                        <td><?= $row['kecamatan']?></td>
                        <td><?= $row['kota']?></td>
                        <td><?= $row['provinsi']?></td>
                        <td>
                          <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTPS<?=$key?>">
                            <i class="bi bi-pencil-square"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusTPS<?=$key?>">
                            <i class="bi bi-trash"></i>
                          </button>  

                          <div class="modal fade" id="editTPS<?=$key?>" tabindex="-1" aria-labelledby="editTPSLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="editTPSLabel">Edit TPS</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form action="./controllers/tpsController.php?action=edit&id=<?=$row['idTps']?>" method="POST" class=" w-100 d-flex flex-column gap-3 bg-white rounded p-4">
                                  <div>
                                    <label for="no_tps" class="form-label">No TPS</label>
                                    <input type="text" value="<?=$row['no_tps']?>" autofocus name="no_tps" required class="form-control">
                                  </div>
                                  <div>
                                    <label for="kelurahan" class="form-label">Kelurahan/Desa</label>
                                    <input type="text" value="<?=$row['kelurahan']?>" autofocus name="kelurahan" required class="form-control">
                                  </div>
                                  <div>
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <select name="kecamatan" id="" class="form-select" required>
                                      <option value="">--Pilih Kecamatan--</option>
                                      <?php foreach($data as $value):?>
                                        <option <?= $row['idKecamatan']==$value['id'] ? 'selected' : ''?> value="<?=$value['id']?>"><?=$value['kecamatan']?></option>
                                      <?php endforeach;?>
                                    </select>
                                  </div>
                                  <div>
                                    <label for="kota" class="form-label">Kab/Kota</label>
                                    <input type="text" value="<?=$row['kota']?>" autofocus name="kota" required class="form-control">
                                  </div>
                                  <div>
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <input type="text" value="<?=$row['provinsi']?>" autofocus name="provinsi" required class="form-control">
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" name="submit" class="btn btn-warning">Submit</button>
                                  </div>
                                </form>
                                </div>
                              </div>
                            </div>
                          </div>
    
                          <div class="modal fade" id="hapusTPS<?=$key?>" tabindex="-1" aria-labelledby="hapusTPSLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <p>Anda yakin ingin menghapus ?</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <a class="btn btn-danger" href="./controllers/tpsController.php?action=delete&id=<?=$row['idTps']?>">Hapus</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </td>

                      </tr>


                      <?php endforeach; ?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <?php include './partials/footer.php'?> 