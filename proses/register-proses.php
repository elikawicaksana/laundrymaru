<?php 
 	include "../config/koneksi.php";

    // var_dump($_POST['nama_user']);
    // var_dump($_POST['username']);
    // var_dump($_POST['passwd']);
    // var_dump($_POST['id_outlet']);
    // var_dump($_POST['level']);

 	if (strlen($_POST['nama_user'])>50){
		echo "<script type='text/javascript'>\n";
		echo "alert('Nama Lengkap Tidak Boleh Lebih Dari 50 Karakter');";
		echo "window.location = ('../register.php');";
		echo "</script>";
	}else if (strlen($_POST['username'])>20){
        echo "<script type='text/javascript'>\n";
        echo "alert('Username Tidak Boleh Lebih Dari 10 Karakter');";
        echo "window.location = ('../register.php');";
        echo "</script>";
    }else if(strlen($_POST['passwd'])<8 || strlen($_POST['passwd'])>18){
        echo "<script type='text/javascript'>\n";
        echo "alert('Maaf, Jumlah Password Tidak Boleh Kurang Dari 8 atau Lebih Dari 16');";
        echo "window.location = ('../register.php');";
        echo "</script>";
    }else if(trim($_POST['passwd'])!=trim($_POST['retype'])){
        echo "<script type='text/javascript'>\n";
        echo "alert('Maaf, Password dan Retype Anda Tidak Sama');";
        echo "window.location = ('../register.php');";
        echo "</script>";
    }else{
        $selQuery2=mysqli_query($conn,"SELECT * FROM db_laundry.tb_user WHERE username='".mysqli_real_escape_string($conn,trim($_POST['username']))."'") OR die(mysqli_error($conn));
        $jumQuery2=mysqli_num_rows($selQuery2);
        if($jumQuery2>0){
            echo "<script type='text/javascript'>\n";
            echo "alert('Maaf, Username Sudah Terpakai');";
            echo "window.location = ('../register.php');";
            echo "</script>";
        }else{
            $options = [
                'cost' => 10,
            ];
            $password_hash = password_hash($_POST['passwd'],PASSWORD_DEFAULT,$options);
            $insertUser=mysqli_query($conn,"INSERT INTO db_laundry.tb_user
                                            (nama_user, username, passwd, id_outlet,`level`,foto)
                                            VALUES
                                            ('".$_POST['nama_user']."','".$_POST['username']."','".$password_hash."','".$_POST['id_outlet']."','".$_POST['level']."','dist/img/Foto/user_default.jpg')
                                            ")OR die(mysqli_error($conn));
            if($insertUser==true){
                echo "<script type='text/javascript'>\n";
                echo "alert('Berhasil Terdaftar');";
                echo "window.location = ('../daftar-user.php');";
                echo "</script>";
            }else{
                echo "<script type='text/javascript'>\n";
                echo "alert('Maaf, Terjadi Kesalahan Pada Sistem');";
                echo "window.location = ('../register.php');";
                echo "</script>";
            }
        }	
    }
?>