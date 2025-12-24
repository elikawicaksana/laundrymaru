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
        include 'config/fungsi.php';
        include 'include/head.php';

        $urlBack="transaksi-produk.php?id_trx=".$_GET['id_trx']."&id_pelanggan=".$_GET['id_pelanggan'];
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
                            <p class="text-muted">You are at the final step of transaction</p>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-outline-danger disabled float-right"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
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
                                                <span class="bs-stepper-circle text-bold h5"><i class="vertical-center fa-solid fa-check"></i></span>
                                                <span class="bs-stepper-label text-white">Customer Information</span>
                                            </div>
                                        </div>
                                        <div class="line" style="border:2px solid white;"></div>
                                        <div class="step active">
                                            <div class="step-trigger">
                                                <span class="bs-stepper-circle text-bold h5"><i class="vertical-center fa-solid fa-check"></i></span>
                                                <span class="bs-stepper-label text-white">Package Choices</span>
                                            </div>
                                        </div>
                                        <div class="line" style="border:2px solid white;"></div>
                                        <div class="step active">
                                            <div class="step-trigger">
                                                <span class="bs-stepper-circle text-bold h5">3</span>
                                                <span class="bs-stepper-label text-white">Review & Submit</span>
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
            <section class="content" style="margin-right: 40px; margin-left: 40px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="text-center text-bold">Rincian Transaksi</h4>
                                    <?php 
                                        $selTransaksi=mysqli_query($conn,"SELECT tb_transaksi.*,tb_pelanggan.nama_pelanggan 
                                                                            FROM db_laundry.tb_transaksi 
                                                                            LEFT JOIN db_laundry.tb_pelanggan ON tb_pelanggan.id_pelanggan=tb_transaksi.id_pelanggan
                                                                            WHERE id_trx='".$_GET['id_trx']."'") OR die(mysqli_error($conn));
                                        $fetchTransaksi=mysqli_fetch_array($selTransaksi);
                                    ?>
                                    <span>
                                        Invoice: <?php echo $fetchTransaksi['kd_inv'] ?><br>
                                        Pelanggan: <?php echo $fetchTransaksi['nama_pelanggan'] ?><br>
                                    </span><br>
                                </div>
                                <form action="proses/prosesQuery.php" method="post">
                                    <input type="hidden" name="flag" value="orderAkhir">
                                    <input type="hidden" name="id_trx" value="<?php echo $_GET['id_trx'] ?>">
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped" id="tableData">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Paket</th>
                                                        <th>Harga</th>
                                                        <th>Jumlah</th>
                                                        <th>Biaya Tambahan</th>
                                                        <th>Keterangan</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $i=1;
                                                        $queryProduk=mysqli_query($conn,"SELECT tb_det_trx.*, SUM(tb_det_trx.jumlah) AS jumlah, tb_produk.*,tb_transaksi.*
                                                                                        FROM db_laundry.tb_det_trx
                                                                                        LEFT JOIN db_laundry.tb_produk ON tb_produk.`id_produk`=tb_det_trx.`id_produk`
                                                                                        LEFT JOIN db_laundry.tb_transaksi ON tb_transaksi.id_trx=tb_det_trx.id_trx
                                                                                        WHERE tb_det_trx.id_trx='".$_GET['id_trx']."' 
                                                                                        GROUP BY tb_det_trx.`id_produk` 
                                                                                    ") OR die(mysqli_error($conn));
                                                        while($fetchProduk=mysqli_fetch_array($queryProduk)){
                                                            $total_harga=$fetchProduk['jumlah']*$fetchProduk['harga'];
                                                            echo 
                                                            "<tr>
                                                                <td>".$i."</td>
                                                                <td>".$fetchProduk['nama_produk']."</td>
                                                                <td >".formatUang($fetchProduk['harga'])."</td>
                                                                <td >".$fetchProduk['jumlah']."</td>
                                                                <td >".formatUang($fetchProduk['biaya_tambahan'])."</td>
                                                                <td>".$fetchProduk['ket']."</td>
                                                                <td>
                                                                    <button class='btn btn-danger' type='button' id='btnDel' data-id='".$fetchProduk['id_det_trx']."'><i class='fa fa-trash'></i> </button>
                                                                </td>
                                                            </tr>
                                                            ";
                                                            $i++;
                                                            $totalBelanja+=$total_harga;
                                                            if($fetchProduk['diskon']>0){
                                                                $diskonshow = '10%';
                                                            }else{
                                                                $diskonshow = '0%';
                                                            }
                                                            $total_tambahan=$fetchProduk['total_tambahan'];
                                                            $biaya_tambahan=$fetchProduk['biaya_tambahan'];
                                                            $pajak=$fetchProduk['pajak'];
                                                            $total_tagihan=$fetchProduk['total_tagihan'];
                                                            $diskon=$fetchProduk['diskon'];
                                                        }											
                                                    ?>	
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="lead">Choose Payment Status</p>
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="customRadio1" name="sts_bayar" value="1" required>
                                                    <label for="customRadio1" class="custom-control-label">Dibayar</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="customRadio2" name="sts_bayar" value="2">
                                                    <label for="customRadio2" class="custom-control-label">Belum Dibayar</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p class="lead">Amount Due</p>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th style="width:50%">Total Awal</th>
                                                        <td><?php echo formatUang($totalBelanja) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Biaya Tambahan</th>
                                                        <td><?php echo formatUang($total_tambahan) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tax (0.75%)</th>
                                                        <td><?php echo formatUang($pajak) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Diskon (<?php echo $diskonshow ?>)</th>
                                                        <td>-<?php echo formatUang($diskon) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Akhir</th>
                                                        <td><?php echo formatUang($total_tagihan) ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="<?php echo $urlBack ?>" class="btn btn-danger">
                                                <i class="fa fa-arrow-left"></i> Back
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit Payment</button>
                                        </div>
                                    </div>
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
    var tableData=$('#tableData');
    tableData.on("click","#btnDel",function(){
    	var validasi=confirm("Apakah anda yakin ingin menghapus data ini?");
    	if(!validasi){
	    	alert("Hati-hati dalam menekan tombol hapus");
            return
	    }
        var btn=$(this);
        var id_det_trx=$(this).attr("data-id");
        // alert(id_det_trx);
        var promise=$.ajax({
            url  : 'proses/prosesQuery.php',
            type : 'POST',
            dataType: 'json',
            cache   : false,
            data    : {
                flag  : "orderHapus",
                id_det_trx : id_det_trx,
                id_trx: "<?php echo $_GET['id_trx'] ?>",
                total_tagihan : "<?php echo $total_tagihan ?>",
                pajak : "<?php echo $pajak ?>",
                diskon : "<?php echo $diskon ?>",
                harga : "<?php echo $total_harga ?>",
                biaya_tambahan : "<?php echo $biaya_tambahan ?>"
            },
            success: function(data){
                // tableData
                // 		.row( btn.parents('tr') )
                // 		.remove()
                // 		.draw();
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.log("AJAX request error:", error);
            }
        });
    });
</script>
</body>
</html>