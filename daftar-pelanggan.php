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

        $query = mysqli_query($conn, "SELECT * FROM db_laundry.tb_pelanggan")OR die(mysqli_error($conn));
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
                            <p class="text-muted">Now you are viewing the customers page</p>
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title vertical-center">Customers Listing</h3>
                                    <a href="register-pelanggan.php"><button class="btn btn-md btn-light float-right"><i class="fa-solid fa-arrow-up-right-from-square"></i> Add new customer</button></a>
                                </div>
                                <hr style="border: 1px solid #6C757D;margin-top:-1px;margin-bottom:-1px;">
                                <div class="card-body">
                                    <table id="tableData" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pelanggan</th>
                                                <th>Nomor Telp</th>
                                                <th>Alamat</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i=1;
                                                while($fetch=mysqli_fetch_array($query)){ 
                                                    echo 
                                                    "<tr>
                                                        <td>".$i."</td>
                                                        <td>".$fetch['nama_pelanggan']."</td>
                                                        <td>".$fetch['telp']."</td>
                                                        <td>".$fetch['alamat']."</td>
                                                        <td>".$fetch['jenis_kelamin']."</td>
                                                        <td>
                                                            <a href='edit-pelanggan.php?id_pelanggan=".$fetch['id_pelanggan']."'><button class='btn btn-xs btn-info' type='button'><i class='fa fa-edit'></i> Edit</button></a> |
                                                            <button class='btn btn-xs btn-danger' type='button' id='btnDel' data-id='".$fetch['id_pelanggan']."'><i class='fa-regular fa-trash-can'></i> Hapus</button>
                                                        </td>
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
                </div>
            </section>
        </div>
    </div>
<?php
    include 'include/script.php';
?>

<script>
    var tableData=$('#tableData');

    $(function () {
        tableData.DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
    
    tableData.on("click","#btnDel",function(){
    	var validasi=confirm("Apakah anda yakin ingin menghapus data ini?");
    	if(!validasi){
	    	alert("Hati-hati dalam menekan tombol hapus");
            return
	    }
        var btn=$(this);
        var id_pelanggan=$(this).attr("data-id");
        // alert(id_pelanggan);
        var promise=$.ajax({
            url  : 'proses/prosesQuery.php',
            type : 'POST',
            dataType: 'json',
            cache   : false,
            data    : {
                flag  : "prosesHapusPelanggan",
                id_pelanggan : id_pelanggan
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