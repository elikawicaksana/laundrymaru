<?php
    session_start();
    include "../config/koneksi.php";
    $username=$_POST['username'];

    $queryUser=mysqli_query($conn,"SELECT tb_user.*,tb_outlet.* 
                                    FROM db_laundry.tb_user
                                    LEFT JOIN db_laundry.tb_outlet ON tb_outlet.id_outlet=tb_user.id_outlet
                                    WHERE username='".$username."' 
                                ") OR die(mysqli_error($conn)); 

    $fetch=mysqli_fetch_array($queryUser);
    $password_hash = $fetch['passwd'];
    $passwd = $_POST['passwd'];
    if(password_verify($passwd,$password_hash)){    
        $jumlahUser=mysqli_num_rows($queryUser);
        if($jumlahUser>0){
            // setcookie('username', $username, time() + (60 * 60 * 24 * 5), '/');
            $status=1;
            $_SESSION['id_user']=$fetch['id_user'];
            $_SESSION['id_outlet']=$fetch['id_outlet'];
            $_SESSION['nama_user']=$fetch['nama_user'];
            $_SESSION['username']=$fetch['username'];
            $_SESSION['passwd']=$fetch['passwd'];
            $_SESSION['level']=$fetch['level'];
            $_SESSION['foto']=$fetch['foto'];

            header('location:../transaksi-list.php');
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Username atau Password Anda Salah!');";
            echo "window.location = ('../login.php');";
            echo "</script>";
        }
    }else{
        echo "<script type='text/javascript'>\n";
        echo "alert('Username atau Password Anda Salah!');";
        echo "window.location = ('../login.php');";
        echo "</script>";
    }
?>