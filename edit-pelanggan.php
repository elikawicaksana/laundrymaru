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
          echo "alert('Maaf, Anda Tidak Dapat Mengakses Halaman Ini');";
          echo "window.location = ('transaksi-list.php');";
          echo "</script>";
        }

        include 'config/koneksi.php';
        include 'include/head.php';

        $queryPel=mysqli_query($conn,"SELECT * FROM db_laundry.tb_pelanggan 
                                      WHERE id_pelanggan='".$_GET['id_pelanggan']."'
                                     ") OR die(mysqli_error($conn)); 
	    $fetchPel=mysqli_fetch_array($queryPel);
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
                    <h1 class="m-0">Edit <?php echo $fetchPel['nama_pelanggan'] ?>'s Information</h1>
                    <p class="text-muted">You can edit <?php echo $fetchPel['nama_pelanggan'] ?>'s information here!</p>
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
                    <h4 class="text-center">Edit Informasi <?php echo $fetchPel['nama_pelanggan'] ?></h4><br/>
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <div class="card card-default">
                                <form action="proses/prosesQuery.php" method="post" autocomplete="off">
                                    <input type="hidden" name="flag" value="prosesEditPelanggan">
                                    <input type="hidden" name="id_pelanggan" value="<?php echo $_GET['id_pelanggan']?>">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nama Pelanggan</label>
                                            <input type="text" class="form-control" name="nama_pelanggan" value="<?php echo $fetchPel['nama_pelanggan']; ?>" placeholder="Masukkan Nama..." required>
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis Kelamin</label>
                                            <select class="form-control" name="jenis_kelamin" required>
                                                <option disabled selected style="display: none;" value="">Pilih Jenis Kelamin</option>
                                                <option value="Perempuan" <?php if($fetchPel['jenis_kelamin']=="Perempuan"){echo "selected";} ?> >Perempuan</option>
                                                <option value="Laki-laki" <?php if($fetchPel['jenis_kelamin']=="Laki-laki"){echo "selected";} ?> >Laki-laki</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nomor Telp</label>
                                            <input type="tel" pattern="^(\+62|62|0)8[1-9][0-9]{6,9}$" class="form-control" name="telp" value="<?php echo $fetchPel['telp']; ?>" placeholder="Format: 08xxxxxxxxxx" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat..." required><?php echo $fetchPel['alamat']; ?></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-light btn-block">Simpan Data</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-4"></div>
                     </div>
                </div>
            </section>
        </div>
    </div>
</body>
<?php
    include 'include/script.php';
?>
</html>