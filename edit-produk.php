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

        $queryPro=mysqli_query($conn,"SELECT * FROM db_laundry.tb_produk 
                                      WHERE id_produk='".$_GET['id_produk']."'
                                     ") OR die(mysqli_error($conn)); 
	    $fetchPro=mysqli_fetch_array($queryPro);
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
                        <h1 class="m-0">Edit Package Information</h1>
                        <p class="text-muted">You can change package information here!</p>
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
                    <h4 class="text-center">Edit Informasi Paket</h4><br/>
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <div class="card card-default">
                                <form action="proses/prosesQuery.php" method="post" autocomplete="off">
                                    <input type="hidden" name="flag" value="prosesEditProduk">
                                    <input type="hidden" name="id_produk" value="<?php echo $_GET['id_produk']?>">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Outlet</label>
                                            <select class="form-control" name="id_outlet">
													<option disabled selected style="display: none;">Pilih Kategori</option>
                                                    <?php
                                                        $queryOut=mysqli_query($conn,"SELECT * FROM db_laundry.tb_outlet") OR die(mysqli_error($conn));
                                                        while ($fetchOut=mysqli_fetch_array($queryOut)) {
                                                            $selected="";
                                                            if($fetchOut['id_outlet']==$fetchPro['id_outlet']){
                                                                $selected="selected";
                                                            }
                                                            echo "<option value='".$fetchOut['id_outlet']."' ".$selected.">".$fetchOut['nama_outlet']."</option>";
                                                        }
                                                    ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Produk</label>
                                            <input type="text" class="form-control" name="nama_produk" value="<?php echo $fetchPro['nama_produk']; ?>" placeholder="Masukkan Nama..." required>
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis Produk</label>
                                            <select class="form-control" name="jenis_produk" required>
                                                <option disabled selected style="display: none;" value="">Pilih Produk</option>
                                                <option value="Bedcover" <?php if($fetchPro['jenis_produk']=="Bedcover"){echo "selected";} ?> >Bedcover</option>
                                                <option value="Kaos" <?php if($fetchPro['jenis_produk']=="Kaos"){echo "selected";} ?>>Kaos</option>
                                                <option value="Kiloan" <?php if($fetchPro['jenis_produk']=="Kiloan"){echo "selected";} ?>>Kiloan</option>
                                                <option value="Selimut" <?php if($fetchPro['jenis_produk']=="Selimut"){echo "selected";} ?>>Selimut</option>
                                                <option value="Lainnya" <?php if($fetchPro['jenis_produk']=="Lainnya"){echo "selected";} ?>>Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Harga</label>
                                            <input type="number" class="form-control" name="harga" value="<?php echo $fetchPro['harga']; ?>" placeholder="Masukkan Harga..." required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-light btn-block">Save Changes</button>
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