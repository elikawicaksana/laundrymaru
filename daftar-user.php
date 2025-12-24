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

        $query = mysqli_query($conn, "SELECT tb_user.*, nama_outlet FROM db_laundry.tb_user
                                      LEFT JOIN db_laundry.tb_outlet ON tb_outlet.id_outlet=tb_user.id_outlet
                                     ")OR die(mysqli_error($conn));
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
                            <p class="text-muted">Now you are viewing the users page</p>
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
                                    <h3 class="card-title vertical-center">User Listing</h3>
                                    <a href="register.php"><button class="btn btn-md btn-light float-right"><i class="fa-solid fa-arrow-up-right-from-square"></i> Add new user</button></a>
                                </div>
                                <hr style="border: 1px solid #6C757D;margin-top:-1px;margin-bottom:-1px;">
                                <div class="card-body">
                                    <table id="tableData" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama User</th>
                                                <th>Username</th>
                                                <th>Outlet</th>
                                                <th>Role</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($fetch['id_user']==$_SESSION['id_user']){
                                                    
                                                }
                                                $i=1;
                                                while($fetch=mysqli_fetch_array($query)){ 
                                                    echo 
                                                    "<tr>
                                                        <td>".$i."</td>
                                                        <td>".$fetch['nama_user']."</td>
                                                        <td>".$fetch['username']."</td>
                                                        <td>".$fetch['nama_outlet']."</td>
                                                        <td>".$fetch['level']."</td>
                                                        <td>
                                                            <a href='edit-user.php?id_user=".$fetch['id_user']."'><button class='btn btn-xs btn-info' type='button'><i class='fa fa-edit'></i> Edit</button></a>&nbsp";
                                                            if($fetch['id_user']!=$_SESSION['id_user']){
                                                                echo "| <button class='btn btn-xs btn-danger' type='button' id='btnDel' data-id='".$fetch['id_user']."'><i class='fa-regular fa-trash-can'></i> Hapus</button>";
                                                            }
                                                        echo "
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
        var id_user=$(this).attr("data-id");
        // alert(id_user);
        var promise=$.ajax({
            url  : 'proses/prosesQuery.php',
            type : 'POST',
            dataType: 'json',
            cache   : false,
            data    : {
                flag  : "prosesHapusUser",
                id_user : id_user
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