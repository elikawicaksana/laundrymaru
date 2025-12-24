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
        }else if(($_SESSION['level'])!='Admin' && ($_SESSION['level'])!='Kasir'){
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
                            <h1 class="m-0">Transaction</h1>
                            <p class="text-muted">You are at the first step of transaction</p>
                        </div>
                        <div class="col-sm-6">
                            <a href="proses/logout.php" class="btn btn-outline-danger float-right"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="col-2"></div> -->
                        <div class="col-md-12">
                            <div class="p-0">
                                <div class="bs-stepper">
                                    <div class="bs-stepper-header">
                                        <div class="step active">
                                            <div class="step-trigger">
                                                <span class="bs-stepper-circle text-bold h5">1</span>
                                                <span class="bs-stepper-label text-white">Customer Information</span>
                                            </div>
                                        </div>
                                        <div class="line" style="border:2px solid #6C757D;"></div>
                                        <div class="step">
                                            <div class="step-trigger">
                                                <span class="bs-stepper-circle text-bold h5">2</span>
                                                <span class="bs-stepper-label">Package Choices</span>
                                            </div>
                                        </div>
                                        <div class="line" style="border:2px solid #6C757D;"></div>
                                        <div class="step">
                                            <div class="step-trigger">
                                                <span class="bs-stepper-circle text-bold h5">3</span>
                                                <span class="bs-stepper-label">Review & Submit</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="border: 1px solid #6C757D;">
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <h4 class="text-center">Informasi Pelanggan</h4><br>
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <div class="card card-default">
                                 <form action="proses/prosesQuery.php" method="post" autocomplete="off">
                                    <input type="hidden" name="flag" value="buatInvoice">
                                    <input type="hidden" name="id_outlet" value="<?php echo $_SESSION['id_outlet'] ?>">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Pelanggan</label>
                                                    <input class="form-control" list="nama_member" name="nama_pelanggan" autocomplete="off" placeholder="Nama Pelanggan..." onchange="resetIfInvalid(this);" required>
                                                    <datalist id="nama_member">
                                                    <?php
                                                        $queryPel=mysqli_query($conn,"SELECT * FROM db_laundry.tb_pelanggan") OR die(mysqli_error($conn));
                                                        while ($fetchPel=mysqli_fetch_array($queryPel)) {
                                                            echo "<option value='".$fetchPel['nama_pelanggan']."'></option>";
                                                        }
                                                    ?>
                                                    </datalist>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-light btn-block">Next</button>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php
    include 'include/script.php';
?>
<script>
    function resetIfInvalid(el){
    //just for beeing sure that nothing is done if no value selected
    if (el.value == "")
        return;
    var options = el.list.options;
    for (var i = 0; i< options.length; i++) {
        if (el.value == options[i].value)
            //option matches: work is done
            return;
    }
    //no match was found: reset the value
    alert("Pelanggan Tidak Terdaftar");
    el.value = "";
    }
</script>
</body>
</html>