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
        }

        include 'config/fungsi.php';
        include 'config/koneksi.php';
        include 'include/head.php';

        if($_SESSION['level']=='Admin' || $_SESSION['level']=='Owner' ){
            $queryInv=mysqli_query($conn,"SELECT *,DATE_FORMAT(tgl_trx,'%Y/%m/%d') AS tgl_trx
                                          FROM db_laundry.tb_transaksi
                                          LEFT JOIN db_laundry.tb_pelanggan ON tb_pelanggan.`id_pelanggan`=tb_transaksi.`id_pelanggan`
                                          ORDER BY tgl_trx DESC
                                        ") OR die(mysqli_error($conn));
            $outlet="All Outlet";

            $queryTT=mysqli_query($conn, "SELECT COUNT(*) FROM db_laundry.tb_transaksi");
            $queryUT=mysqli_query($conn, "SELECT COUNT(*) FROM db_laundry.tb_transaksi WHERE sts_bayar=2");
            $queryPT=mysqli_query($conn, "SELECT COUNT(*) FROM db_laundry.tb_transaksi WHERE sts_bayar=1");
            $queryST=mysqli_query($conn, "SELECT COUNT(*) FROM db_laundry.tb_transaksi WHERE sts_proses='Diambil'");

            $fetchTT=mysqli_fetch_array($queryTT);
            $fetchUT=mysqli_fetch_array($queryUT);
            $fetchPT=mysqli_fetch_array($queryPT);
            $fetchST=mysqli_fetch_array($queryST);
        }else{
            $queryInv=mysqli_query($conn,"SELECT *,DATE_FORMAT(tgl_trx,'%Y/%m/%d') AS tgl_trx
                                          FROM db_laundry.tb_transaksi
                                          LEFT JOIN db_laundry.tb_pelanggan ON tb_pelanggan.`id_pelanggan`=tb_transaksi.`id_pelanggan`
                                          WHERE id_outlet='".$_SESSION['id_outlet']."' ORDER BY tgl_trx DESC
                                        ") OR die(mysqli_error($conn));
            $queryOut=mysqli_query($conn,"SELECT nama_outlet FROM db_laundry.tb_outlet WHERE id_outlet='".$_SESSION['id_outlet']."'");
            $fetchOutlet=mysqli_fetch_array($queryOut);
            $outlet=$fetchOutlet['nama_outlet'];

            $queryTT=mysqli_query($conn, "SELECT COUNT(*) FROM db_laundry.tb_transaksi WHERE id_outlet='".$_SESSION['id_outlet']."'");
            $queryUT=mysqli_query($conn, "SELECT COUNT(*) FROM db_laundry.tb_transaksi WHERE sts_bayar=2 AND id_outlet='".$_SESSION['id_outlet']."'");
            $queryPT=mysqli_query($conn, "SELECT COUNT(*) FROM db_laundry.tb_transaksi WHERE sts_bayar=1 AND id_outlet='".$_SESSION['id_outlet']."'");
            $queryST=mysqli_query($conn, "SELECT COUNT(*) FROM db_laundry.tb_transaksi WHERE sts_proses='Diambil' AND id_outlet='".$_SESSION['id_outlet']."'");

            $fetchTT=mysqli_fetch_array($queryTT);
            $fetchUT=mysqli_fetch_array($queryUT);
            $fetchPT=mysqli_fetch_array($queryPT);
            $fetchST=mysqli_fetch_array($queryST);
        }
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
                            <h1 class="m-0">Welcome back, <?php echo $_SESSION['nama_user'] ?>!</h1>
                            <p class="text-muted">Now you are viewing the main page</p>
                        </div>
                        <div class="col-sm-6">
                            <a href="proses/logout.php" class="btn btn-outline-danger float-right"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content" style="margin-right: 30px; margin-left: 30px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Transactions</span>
                                    <span class="info-box-number">
                                        <?php echo $fetchTT['COUNT(*)'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Unpaid Transactions</span>
                                    <span class="info-box-number"><?php echo $fetchUT['COUNT(*)'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix hidden-md-up"></div>  
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Paid Transactions</span>
                                    <span class="info-box-number"><?php echo $fetchPT['COUNT(*)'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Success Transactions</span>
                                    <span class="info-box-number"><?php echo $fetchST['COUNT(*)'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- <hr style="border: 1px solid #6C757D;"> -->
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <form action="transaksi-cetak.php" method="post" autocomplete="off">
                                <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <div class="input-group date" id="tgl_awal" data-target-input="nearest">
                                                <div class="input-group-append" data-target="#tgl_awal" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                <input type="text" name="tgl_awal" class="form-control datetimepicker-input" data-inputmask-alias="datetime" id="datemask1" data-inputmask-inputformat="mm/dd/yyyy" data-mask data-target="#tgl_awal" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <label style="margin-top: 5px;">—</label>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <div class="input-group date" id="tgl_akhir" data-target-input="nearest">
                                                <input type="text" name="tgl_akhir" class="form-control datetimepicker-input" data-inputmask-alias="datetime" id="datemask2" data-inputmask-inputformat="mm/dd/yyyy" data-mask data-target="#tgl_akhir" required/>
                                                <div class="input-group-append" data-target="#tgl_akhir" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <button class="btn btn-info" id="btnGenerate">Generate Laporan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 class="card-title"><?php echo $outlet ?> Transaction List</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <hr style="border: 1px solid #6C757D;margin-top:-1px;margin-bottom:-1px;">
                                <div class="card-body">
                                    <table id="tableData" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Invoice</th>
                                                <th>Pelanggan</th>
                                                <th>Tanggal</th>
                                                <th>Tagihan</th>
                                                <th>Status Bayar</th>
                                                <th>Status Proses</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i=1;
                                            while($fetchInv=mysqli_fetch_array($queryInv)){
                                                if($fetchInv['sts_proses']=="Baru"){
                                                    $sts_proses="&nbsp<span class='badge badge-primary btn-xs'>Pesanan Baru</span>";
                                                    $btnSts="| <button id='btnSts' data-id='".$fetchInv['id_trx']."' data-sts='".$fetchInv['sts_proses']."' class='btn btn-xs btn-warning' type='button'><i class='fa fa-check-circle'></i> Update Status</button>";
                                                }elseif($fetchInv['sts_proses']=="Proses"){
                                                    $sts_proses="&nbsp<span class='badge badge-warning btn-xs'>Dalam Proses</span>";
                                                    $btnSts="| <button id='btnSts' data-id='".$fetchInv['id_trx']."' data-sts='".$fetchInv['sts_proses']."' class='btn btn-xs btn-info' type='button'><i class='fa fa-check-circle'></i> Update Status</button>";
                                                }elseif($fetchInv['sts_proses']=="Selesai"){
                                                    $sts_proses="&nbsp<span class='badge badge-info btn-xs'>Pesanan Selesai</span>";
                                                    $btnSts="| <button id='btnSts' data-id='".$fetchInv['id_trx']."' data-sts='".$fetchInv['sts_proses']."' class='btn btn-xs btn-success' type='button'><i class='fa fa-check-circle'></i> Update Status</button>";
                                                }elseif($fetchInv['sts_proses']=="Diambil"){
                                                    $sts_proses="&nbsp<span class='badge badge-success btn-xs'>Pesanan Diambil</span>";
                                                    $btnSts="";
                                                }
                                        
                                                if($fetchInv['sts_bayar']==2){
                                                    $sts_bayar="&nbsp<span class='badge badge-danger btn-xs'>Belum Lunas</span>";
                                                    $btnBayar="| <button id='btnBayar' data-id='".$fetchInv['id_trx']."' class='btn btn-xs btn-success' type='button'><i class='fa fa-check-circle'></i> Update Status</button>";
                                                }elseif($fetchInv['sts_bayar']==1){
                                                    $sts_bayar="&nbsp<span class='badge badge-success btn-xs'>Lunas</span>";
                                                    $btnBayar="";
                                                }
                                        
                                                $aksi="<a id='lihatRincian' data-id='".$fetchInv['id_trx']."' class='btn bg-purple btn-xs' type='button'><i class='fa fa-search'></i> Lihat Rincian</a>";
                                                
                                                echo 
                                                "<tr>
                                                    <td>".$i."</td>
                                                    <td>".$fetchInv['kd_inv']."</td>
                                                    <td>".$fetchInv['nama_pelanggan']."</td>
                                                    <td>".$fetchInv['tgl_trx']."</td>
                                                    <td>".formatUang($fetchInv['total_tagihan'])."</td>
                                                    <td>
                                                        ".$sts_bayar." 
                                                ";
                                                        if($_SESSION['level']!="Owner"){echo $btnBayar;}
                                                echo "
                                                    </td>
                                                    <td>
                                                        ".$sts_proses."
                                                ";
                                                        if($_SESSION['level']!="Owner"){echo $btnSts;}
                                                echo "
                                                    </td>
                                                    <td>".$aksi."</td>
                                                </tr>
                                                ";
                                                $i++;
                                            }											
                                        ?>	
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-rincian">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-body" id="datamodalRincian">
                                </div>
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
    $(function () {
        $('#datemask1').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        $('[data-mask]').inputmask()

        $('#tgl_awal').datetimepicker({
            format: 'L'
        });

        $('#tgl_akhir').datetimepicker({
            format: 'L'
        });
    })

    var tableData=$('#tableData');
    $(function () {
        tableData.DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });

    tableData.on("click","#btnBayar",function(){
        var validasi=confirm("Apakah anda ingin mengupdate status bayar menjadi lunas?");
        if(validasi){
            var id_trx=$(this).attr("data-id");
            var promise = $.ajax({
                url: 'proses/prosesQuery.php',
                type: 'POST',
                dataType: 'json',
                cache: false,
                data: {
                    flag: 'updateStsBayar',
                    id_trx: id_trx
                },
                success:function(data){
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.log("AJAX request error:", error);
                }
            });
        }
    });

    tableData.on("click","#btnSts",function(){
        var validasi=confirm("Apakah anda ingin mengupdate status proses?");
        if(validasi){
            var id_trx=$(this).attr("data-id");
            var sts_proses=$(this).attr("data-sts");
            var promise = $.ajax({
                url: "proses/prosesQuery.php",
                type: 'POST',
                dataType: 'json',
                cache: false,
                data: {
                    flag: 'updateStsProses',
                    id_trx: id_trx,
                    sts_proses: sts_proses
                },
                success:function(data){
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.log("AJAX request error:", error);
                }
            });
        }
    });

    tableData.on("click","#lihatRincian",function(){
        var id_trx=$(this).attr("data-id");
        var promise=$.ajax({
            url: "modal/modal-rincian.php",
			type: 'POST',
			cache: false,
            data: {
                id_trx : id_trx
            }
        });
		$("#modal-rincian").modal("show");
        promise.done(function(response){
			$('#datamodalRincian').html(response);
		});
	});
</script>
</body>
</html>