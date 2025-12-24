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

        $qtambahan=mysqli_query($conn,"SELECT total_tambahan,total_tagihan FROM db_laundry.tb_transaksi WHERE id_trx='".$_GET['id_trx']."'");
        $fetchtrx=mysqli_fetch_array($qtambahan);
        $query=mysqli_query($conn,"SELECT *
                                    FROM db_laundry.tb_produk
                                    WHERE id_outlet='".$_SESSION['id_outlet']."'
                                ") OR die(mysqli_error($conn));
        $jumlah=mysqli_num_rows($query);
        $urlCart="transaksi-rincian.php?id_trx=".$_GET['id_trx']."&id_pelanggan=".$_GET['id_pelanggan'];
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
                            <p class="text-muted">You are at the second step of transaction</p>
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
                                                <span class="bs-stepper-circle text-bold h5">2</span>
                                                <span class="bs-stepper-label text-white">Package Choices</span>
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
            <section class="content" style="margin-right: 30px; margin-left: 30px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="text-center">Pilihan Paket</h4>
                                    <br/>
                                </div>
                                <form action="proses/prosesQuery.php" method="post">
                                    <input type="hidden" name="flag" value="orderRincian">
                                    <input type="hidden" name="id_trx" value="<?php echo $_GET['id_trx'] ?>">
                                    <input type="hidden" name="total_tagihan" value="<?php echo $fetchtrx['total_tagihan'] ?>">
			                        <input type="hidden" name="id_pelanggan" value="<?php echo $_GET['id_pelanggan'] ?>">
                                    <div class="box-body" id="daftarId">
                                        <div class="row">
                                            <?php
                                                while($fetch=mysqli_fetch_array($query)){
                                                    echo "<div class='col-3'>
                                                            <div class='card card-info card-outline'>
                                                                <div class='card-body box-profile'>
                                                                    <div class='row'>
                                                                        <div class='col-12'>
                                                                            <h3 class='profile-username text-center'>".$fetch['nama_produk']."</h3>
                                                                            <p class='text-muted text-center'>".$fetch['jenis_produk']."</p>
                                                                            <ul class='list-group list-group-unbordered mb-3'>
                                                                                <li class='list-group-item'>
                                                                                    <b>Harga</b> <span class='float-right'>".formatUang($fetch['harga'])."</span>
                                                                                </li>
                                                                            <ul><br/>
                                                                        </div>
                                                                    </div>
                                                                    <div class='row'>
                                                                        <div class='col-12'>
                                                                            <a id='idOrder' data-id='".$fetch['id_produk']."' data-harga='".$fetch['harga']."' data-total='".$fetchtrx['total_tagihan']."' data-biaya='".$fetchtrx['total_tambahan']."' class='btn btn-info btn-block'><b>Tambah Paket</b></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    ";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-md btn-success float-right"><i class="fa fa-shopping-cart"></i> Lihat Rincian</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-jumlah">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" id="datamodalJumlah">
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
    $("#daftarId").on("click","#idOrder",function(){
		var id_produk=$(this).attr("data-id");
		var harga=$(this).attr("data-harga");
		var total_tagihan=$(this).attr("data-total");
		var total_tambahan=$(this).attr("data-biaya");

		var promise = $.ajax({
			url: "modal/modal-jumlah-order.php",
			type: 'POST',
			cache: false,
			data: {
				id_produk :id_produk,
				harga :harga,
                total_tagihan : total_tagihan,
                total_tambahan : total_tambahan,
				id_trx: "<?php echo $_GET['id_trx'] ?>",
				id_pelanggan: "<?php echo $_GET['id_pelanggan'] ?>"
			}
		});
		$("#modal-jumlah").modal('show');
		promise.done(function(response){
			$('#datamodalJumlah').html(response);
		});
	});	
</script>
</body>
</html>