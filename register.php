<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    session_start();
    if(!isset($_SESSION['username']) && !isset($_SESSION['passwd'])){
      echo "<script type='text/javascript'>\n";
      echo "alert('Silahkan Login Terlebih Dahulu');";
      echo "window.location = ('login.php');";
      echo "</script>";
    }else if(($_SESSION['level'])!='Admin'){
      echo "<script type='text/javascript'>\n";
      echo "alert('Maaf, Anda Bukan Admin');";
      echo "window.location = ('transaksi-list.php');";
      echo "</script>";
    }

    include 'config/koneksi.php';
    include 'include/head.php';
  ?>
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <?php
      include 'include/sidebar.php';
    ?> 
    <div class="content-wrapper">
      <section class="content-header" style="margin-top: -30px; margin-right:30px; margin-left:30px;">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Register New User</h1>
              <p class="text-muted">You can register new user here!</p>
            </div>
            <div class="col-sm-6">
              <a href="proses/logout.php" class="btn btn-outline-danger float-right"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
            </div>
          </div>
          <hr style="border: 1px solid #6C757D;">
        </div>
      </section>
      <section class="content">
        <div class="container-fluid">
          <h4 class="text-center">Informasi User Baru</h4><br>
          <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
              <div class="card">
                <form action="proses/register-proses.php" method="post" autocomplete="off">
                  <div class="card-body">
                    <div class="form-group">
                      <label>Nama User</label>
                      <input type="text" class="form-control" name="nama_user" placeholder="Full name" maxlength="50" required>
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" name="username" placeholder="Username" maxlength="20" required>
                    </div>
                    <div class="form-group">
                      <label>Outlet</label>
                      <select class="form-control" name="id_outlet" required>
                        <option disabled selected style="display: none;" value="">Pilih Outlet</option>
                        <?php
                            $queryOutlet=mysqli_query($conn,"SELECT * FROM db_laundry.tb_outlet") OR die(mysqli_error($conn));
                            while ($fetchOutlet=mysqli_fetch_array($queryOutlet)) {
                                echo "<option value='".$fetchOutlet['id_outlet']."'>".$fetchOutlet['nama_outlet']."</option>";
                            }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Role User</label>
                      <select class="form-control" name="level" required>
                        <option disabled selected style="display: none;" value="">Pilih Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Kasir">Kasir</option>
                        <option value="Owner">Owner</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" name="passwd" placeholder="Password" maxlength="18" required>
                    </div>
                    <div class="form-group">
                      <label>Retype Password</label>
                      <input type="password" class="form-control" name="retype" placeholder="Retype password" maxlength="18" required>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-light btn-block">Register</button>
                </form>
              </div>
          </div>
        </div>
      </section>
    </div> 
  </div>
<?php
    include 'include/script.php';
?>
</body>
</html>
