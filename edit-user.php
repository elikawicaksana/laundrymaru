<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        session_start();
        if((!isset($_SESSION['username']) && !isset($_SESSION['passwd']))){
          echo "<script type='text/javascript'>\n";
          echo "alert('Silahkan Login Terlebih Dahulu');";
          echo "window.location = ('login.php');";
          echo "</script>";
        }else if(($_SESSION['level'])!='Admin' && ($_SESSION['id_user'])!=($_GET['id_user'])){
          echo "<script type='text/javascript'>\n";
          echo "alert('Maaf, Anda Tidak Dapat Mengakses Halaman Ini');";
          echo "window.location = ('transaksi-list.php');";
          echo "</script>";
        }

        include 'config/koneksi.php';
        include 'include/head.php';

        $queryUs=mysqli_query($conn,"SELECT * FROM db_laundry.tb_user 
                                     LEFT JOIN db_laundry.tb_outlet ON tb_outlet.id_outlet=tb_user.id_outlet
                                      WHERE id_user='".$_GET['id_user']."'
                                     ") OR die(mysqli_error($conn)); 
	    $fetchUs=mysqli_fetch_array($queryUs);
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
                    <h1 class="m-0">Edit <?php echo $fetchUs['nama_user'] ?>'s Information</h1>
                    <p class="text-muted">You can change <?php echo $fetchUs['nama_user'] ?>'s information here!</p>
                    </div>
                    <div class="col-sm-6">
                    <a href="proses/logout.php" class="btn btn-outline-danger float-right"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                    </div>
                </div>
                <hr style="border: 1px solid #6C757D;">
                </div>
            </section>
            <section class="content" style="margin-right: 30px; margin-left: 30px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-widget widget-user">
                                <div class="widget-user-header bg-white">
                                    <h3 class="widget-user-username"><?php echo $fetchUs['nama_user'] ?></h3>
                                    <h5 class="widget-user-desc"><?php echo $fetchUs['level'] ?></h5>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle" src="<?php echo $fetchUs['foto'] ?>" alt="User Avatar">
                                </div>
                                <form action="proses/prosesQuery.php" method="post" autocomplete="off" enctype="multipart/form-data">
                                    <input type="hidden" name="flag" value="prosesEditUser">
                                    <input type="hidden" name="id_user" value="<?php echo $_GET['id_user']?>">
                                    <input type="hidden" name="fotoLama" value="<?php echo $fetchUs['foto'] ?>">
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Nama User</label>
                                                    <input type="text" class="form-control" name="nama_user" value="<?php echo $fetchUs['nama_user']; ?>" placeholder="Masukkan Nama..." required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" name="username" value="<?php echo $fetchUs['username']; ?>" placeholder="Masukkan Nama..." required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Outlet</label>
                                                    <select class="form-control" name="id_outlet">
                                                            <option disabled selected style="display: none;">Pilih Outlet</option>
                                                            <?php
                                                                $queryOut=mysqli_query($conn,"SELECT * FROM db_laundry.tb_outlet") OR die(mysqli_error($conn));
                                                                while ($fetchOut=mysqli_fetch_array($queryOut)) {
                                                                    $selected="";
                                                                    if($fetchOut['id_outlet']==$fetchUs['id_outlet']){
                                                                        $selected="selected";
                                                                    }
                                                                    echo "<option value='".$fetchOut['id_outlet']."' ".$selected.">".$fetchOut['nama_outlet']."</option>";
                                                                }
                                                            ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                                if($_SESSION['level']=='Admin'){
                                            ?>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Role</label>
                                                    <select class="form-control" name="level" required>
                                                        <option disabled selected style="display: none;" value="">Pilih Level</option>
                                                        <option value="Admin" <?php if($fetchUs['level']=="Admin"){echo "selected";} ?>>Admin</option>
                                                        <option value="Kasir" <?php if($fetchUs['level']=="Kasir"){echo "selected";} ?>>Kasir</option>
                                                        <option value="Owner" <?php if($fetchUs['level']=="Owner"){echo "selected";} ?>>Owner</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                                }else{
                                            ?>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Role</label>
                                                    <select disabled class="form-control" style="cursor: not-allowed;" name="level" required>
                                                        <option value="Admin" <?php if($fetchUs['level']=="Admin"){echo "selected";} ?>>Admin</option>
                                                        <option value="Kasir" <?php if($fetchUs['level']=="Kasir"){echo "selected";} ?>>Kasir</option>
                                                        <option value="Owner" <?php if($fetchUs['level']=="Owner"){echo "selected";} ?>>Owner</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Upload Foto</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="foto" accept="image/*">
                                                            <label class="custom-file-label">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-light btn-block">Edit Profile</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-white">
                                <div class="card-header">
                                    <h4 class="card-title">Change Password</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Masukkan Password Baru..." maxlength="18" required>
                                    </div>
                                </div>
                                <button id="btnPass" class="btn btn-light btn-block">Change Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="modal fade" id="modal-konfirmasi">
			<div class="modal-dialog">
				<div class="modal-content"> 
					<div class="modal-body text-center" id="datamodalKonfirmasi">
					</div>
				</div>
			</div>
		</div>
    </div>
<?php
    include 'include/script.php';
?>
<script>
    $("#btnPass").click(function(){
        var passcheck=$("#passwd").val().length;
        var passwd=$("#passwd").val();
        if(passcheck==""){
            alert("Isi Kolom Password Terlebih Dahulu");
            return
        }else if(passcheck<8 || passcheck>18){
            alert("Password tidak boleh kurang dari 8 atau lebih dari 18");
            return
        }
        var promise = $.ajax({
            url: "modal/modal-konfirmasi-password.php",
            type: 'POST',
            cache: false,
            data: {
                id_user :"<?php echo $_GET['id_user']?>",
                passwd : passwd
            }
        });
        $("#modal-konfirmasi").modal('show');
        promise.done(function(response){
            $('#datamodalKonfirmasi').html(response);
        });
    });
</script>
</body>
</html>