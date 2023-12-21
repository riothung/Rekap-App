<?php 
include './partials/header.php';

$sql = "SELECT * FROM user";
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
      <h1>User</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">User</li>
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
                    Tambah User
                  </button>
                  <div class="modal fade" id="verticalycentered" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Tambah User</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="./controllers/userController.php?action=add" method="POST" class=" w-100 d-flex flex-column gap-3 bg-white rounded p-4">
                          <div>
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" placeholder="Nama" autofocus name="name" required class="form-control">
                          </div>
                          <div>
                            <label for="email" class="form-label">Email</label>
                            <input type="text" placeholder="Email" autofocus name="email" required class="form-control">
                          </div>
                          <div>
                            <label for="username" class="form-label">Username</label>
                            <input type="text" placeholder="Username" autofocus name="username" required class="form-control">
                          </div>
                          <div>
                            <label for="password" class="form-label">Password</label>
                            <input type="text" placeholder="Password" autofocus name="password" required class="form-control">
                          </div>
                          <div>
                            <label for="password" class="form-label">Status</label>
                            <select name="administrator" id=" " class="form-select">
                              <option value="0">Pengawas</option>
                              <option value="1">Administrator</option>
                            </select>
                          </div>
                          <button type="submit" name="submit" class="btn btn-success">Tambah User</button>
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
                  <h5 class="card-title">Data User</h5>

                  <table class="table datatable table-hover table-responsive">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- <?php echo json_encode($data)?> -->
                      <?php foreach($data as $key=>$row):?>
                      <tr>
                        <td><?= $key + 1?></td>
                        <td><?=$row['name']?></td>
                        <td><?=$row['username']?></td>
                        <td><?=$row['email']?></td>
                        <td><?=$row['administrator'] > 0 ? '<span class="badge bg-warning">Admin</span>' : '<span class="badge bg-success">Pengawas</span>'?></td>
                        <td>
                          <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUser<?=$key?>">
                            <i class="bi bi-pencil-square"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusUser<?=$key?>">
                            <i class="bi bi-trash"></i>
                          </button>  

                          <div class="modal fade" id="editUser<?=$key?>" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="editUserLabel">Edit User</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form action="./controllers/userController.php?action=edit&id=<?=$row['id']?>" method="POST" class=" w-100 d-flex flex-column gap-3 bg-white rounded p-4">
                                <div>
                                  <label for="nama" class="form-label">Nama</label>
                                  <input type="text" value="<?=$row['name']?>" placeholder="Nama" autofocus name="name" required class="form-control">
                                </div>
                                <div>
                                  <label for="email" class="form-label">Email</label>
                                  <input type="text" value="<?=$row['email']?>" placeholder="Email" autofocus name="email" required class="form-control">
                                </div>
                                <div>
                                  <label for="username" class="form-label">Username</label>
                                  <input type="text" value="<?=$row['username']?>" placeholder="Username" autofocus name="username" required class="form-control">
                                </div>
                                <div>
                                  <label for="password" class="form-label">Password</label>
                                  <input type="password" value="<?=$row['password']?>" placeholder="Password" autofocus name="password" required class="form-control">
                                </div>
                                <div>
                                  <label for="password" class="form-label">Status</label>
                                  <select name="administrator" id="" class="form-select">
                                    <option <?php echo ($row['administrator'] == 0) ? 'selected' : ''; ?> value="0">Pengawas</option>
                                    <option <?php echo ($row['administrator'] == 1) ? 'selected' : ''; ?> value="1">Administrator</option>
                                  </select>
                                </div>
                                  <div class="modal-footer">
                                  <button type="submit" name="submit" class="btn btn-warning">Submit</button>
                                  </div>
                                </form>
                                </div>
                              </div>
                            </div>
                          </div>
    
                          <div class="modal fade" id="hapusUser<?=$key?>" tabindex="-1" aria-labelledby="hapusUserLabel" aria-hidden="true">
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
                                  <a class="btn btn-danger" href="./controllers/userController.php?action=delete&id=<?=$row['id']?>">Hapus</a>
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