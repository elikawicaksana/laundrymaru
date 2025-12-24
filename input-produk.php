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
                            <h1 class="m-0">Add New Package</h1>
                            <p class="text-muted">You can add new package here</p>
                        </div>
                        <div class="col-sm-6">
                            <a href="proses/logout.php" class="btn btn-outline-danger float-right"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <?php
                        if(isset($_GET['submit'])){
                            echo "
                            <div class='row' style='margin-top: -15px;margin-right:30px; margin-left:30px;'>
                                <div class='col-md-2'></div>
                                <div class='col-md-8'>
                                    <div class='p-0'>
                                        <div class='bs-stepper'>
                                            <div class='bs-stepper-header'>
                                                <div class='step active'>
                                                    <div class='step-trigger'>
                                                        <span class='bs-stepper-circle text-bold h5'><i class='vertical-center fa-solid fa-check'></i></span>
                                                        <span class='bs-stepper-label text-white'>Choose Outlet</span>
                                                    </div>
                                                </div>
                                                <div class='line' style='border:2px solid white;'></div>
                                                <div class='step active'>
                                                    <div class='step-trigger'>
                                                        <span class='bs-stepper-circle text-bold h5'>2</span>
                                                        <span class='bs-stepper-label text-white'>Package Information</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style='margin-bottom: 30px;margin-right:30px; margin-left:30px;border: 1px solid #6C757D;'>
                            <h4 class='text-center'>Informasi Paket</h4><br>
                            <div class='row'>
                                <div class='col-4'></div>
                                <div class='col-4'>
                                    <div class='card card-default'>
                                        <form action='proses/prosesQuery.php' method='post' autocomplete='off'>
                                            <input type='hidden' name='flag' value='prosesInputProduk'>
                                            <input type='hidden' name='OutletChoose' value='".$_GET['OutletChoose']."'>
                                            <div class='card-body'>
                                                <div class='row'>
                                                    <div class='col-12'>
                                                        <div class='form-group'>
                                                            <label>Paket</label>
                                                            <input type='text' class='form-control' name='nama_produk' placeholder='Masukkan Nama Paket...' required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-12'>
                                                        <div class='form-group'>
                                                            <label>Jenis Paket</label>
                                                            <select class='form-control' name='jenis_produk' required>
                                                                <option disabled selected style='display: none;' value=''>Pilih Jenis</option>
                                                                <option value='Bedcover'>Bedcover</option>
                                                                <option value='Kaos'>Kaos</option>
                                                                <option value='Kiloan'>Kiloan</option>
                                                                <option value='Selimut'>Selimut</option>
                                                                <option value='Lainnya'>Lainnya</option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-12'>
                                                        <div class='form-group'>
                                                            <label>Harga</label>
                                                            <input type='number' class='form-control' name='harga' placeholder='Masukkan Harga...' required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type='submit' class='btn btn-light btn-block'>Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            ";
                        }else{
                            echo"
                            <div class='row' style='margin-top: -15px;margin-right:30px; margin-left:30px;'>
                                <div class='col-md-2'></div>
                                <div class='col-md-8'>
                                    <div class='p-0'>
                                        <div class='bs-stepper'>
                                            <div class='bs-stepper-header'>
                                                <div class='step active'>
                                                    <div class='step-trigger'>
                                                        <span class='bs-stepper-circle text-bold h5'>1</span>
                                                        <span class='bs-stepper-label text-white'>Choose Outlet</span>
                                                    </div>
                                                </div>
                                                <div class='line' style='border:2px solid #6C757D;'></div>
                                                <div class='step'>
                                                    <div class='step-trigger'>
                                                        <span class='bs-stepper-circle text-bold h5'>2</span>
                                                        <span class='bs-stepper-label'>Package Information</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style='margin-bottom: 30px;margin-right:30px; margin-left:30px;border: 1px solid #6C757D;'>
                            <h4 class='text-center'>Pilih Outlet</h4><br>
                            <div class='row'>
                                <div class='col-4'></div>
                                <div class='col-4'>
                                    <div class='card card-default'>
                                        <form method='get'>
                                            <div class='card-body'>
                                                <div class='form-group'>
                                                    <label>Outlet</label>
                                                    <select class='form-control' name='OutletChoose'>
                                                        <option disabled selected style='display: none;'>Pilih Kategori</option>
                                                        ";?><?php
                                                            $queryOut=mysqli_query($conn,"SELECT * FROM db_laundry.tb_outlet") OR die(mysqli_error($conn));
                                                            while ($fetchOut=mysqli_fetch_array($queryOut)) {
                                                                echo "<option value='".$fetchOut['id_outlet']."'>".$fetchOut['nama_outlet']."</option>";
                                                            }
                                                        ?><?php echo"
                                                    </select>
                                                    <input type='hidden' value='".$_GET['OutletChoose']."' />
                                                </div>
                                            </div>
                                            <input type='submit' class='btn btn-light btn-block' name='submit' value='Next'/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                    ?>
                </div>
            </section>
        </div>
    </div>
<?php
    include 'include/script.php';
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })
</script>
</body>
</html>