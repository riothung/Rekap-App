<?php 
include './partials/header.php';


$sql = "SELECT * FROM kecamatan";
$result = $conn->query($sql);
$data = array(); // initialize an empty array to store the rows
while ($row = $result->fetch_assoc()) {
    $data[] = $row; // append each row to the data array
}
$conn->close();
// echo json_encode($data);

?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Kecamatan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Kecamatan</li>
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
                  <?php if($user['administrator'] > 0):?>
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#verticalycentered">
                    <i class="bi bi-plus"></i>
                    Tambah Kecamatan
                  </button>
                  <div class="modal fade" id="verticalycentered" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Tambah Kecamatan</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="./controllers/kecamatanController.php?action=add" method="POST" class=" w-100 d-flex flex-column gap-3 bg-white rounded p-4">
                          <div>
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" placeholder="Kecamatan" autofocus name="kecamatan" required class="form-control">
                          </div>
                          <button type="submit" name="submit" class="btn btn-success">Tambah Kecamatan</button>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div><!-- End Vertically centered Modal-->
                  <?php endif;?>

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
                        <th scope="col">Nama Kecamatan</th>
                        <?php if($user['administrator'] > 0):?>
                          <th scope="col">Action</th>
                        <?php endif;?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($data as $key=>$row):?>
                      <tr>
                        <td><?= $key + 1?></td>
                        <td><a href="#" class="text-primary text-uppercase"><?=$row['kecamatan']?></a></td>
                        <?php if($user['administrator'] > 0):?>
                        <td>
                          <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editKecamatan<?=$key?>">
                            <i class="bi bi-pencil-square"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusKecamatan<?=$key?>">
                            <i class="bi bi-trash"></i>
                          </button>  

                          <div class="modal fade" id="editKecamatan<?=$key?>" tabindex="-1" aria-labelledby="editKecamatanLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="editKecamatanLabel">Edit Kecamatan</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form action="./controllers/kecamatanController.php?action=edit&id=<?=$row['id']?>" method="POST" class=" w-100 d-flex flex-column gap-3 bg-white rounded p-4">
                                  
                                  <div>
                                    <label for="kecamatan" class="form-label">Nama Kecamatan</label>
                                    <input value="<?=$row['kecamatan']?>" type="text" placeholder="Kecamatan" autofocus name="kecamatan" class="form-control">
                                  </div>
                                  <div class="modal-footer">
                                  <button type="submit" name="submit" class="btn btn-warning">Submit</button>
                                  </div>
                                </form>
                                </div>
                              </div>
                            </div>
                          </div>
    
                          <div class="modal fade" id="hapusKecamatan<?=$key?>" tabindex="-1" aria-labelledby="hapusKecamatanLabel" aria-hidden="true">
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
                                  <a class="btn btn-danger" href="./controllers/kecamatanController.php?action=delete&id=<?=$row['id']?>">Hapus</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <?php endif;?>

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