<?php
    include '../config/koneksi.php';
    session_start();

    $flag=$_POST['flag'];

    if($flag=="prosesRegisPelanggan"){
        // var_dump($_POST['nama_pelanggan']);
        // var_dump($_POST['alamat']);
        // var_dump($_POST['telp']);
        // var_dump($_POST['jenis_kelamin']);
        
        $insertUser=mysqli_query($conn,"INSERT INTO db_laundry.tb_pelanggan(nama_pelanggan, alamat, telp, jenis_kelamin)
                                        VALUES
                                        ('".$_POST['nama_pelanggan']."','".$_POST['alamat']."','".$_POST['telp']."','".$_POST['jenis_kelamin']."')
                                       ")OR die(mysqli_error($conn));

        if($insertUser==true){
            if($_SESSION['level']=='Admin'){
                echo "<script type='text/javascript'>\n";
                echo "alert('Data Berhasil Disimpan');";
                echo "window.location = ('../daftar-pelanggan.php');";
                echo "</script>";
            }else{
                echo "<script type='text/javascript'>\n";
                echo "alert('Data Berhasil Disimpan');";
                echo "window.location = ('../register-pelanggan.php');";
                echo "</script>";
            }
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Maaf, Terjadi Kesalahan Pada Sistem');";
            echo "window.location = ('../register-pelanggan.php');";
            echo "</script>";
        }
    }elseif($flag=="prosesInputOutlet"){
        // var_dump($_POST['nama_outlet']);
        // var_dump($_POST['alamat']);
        // var_dump($_POST['telp']);

        $insertOutlet=mysqli_query($conn,"INSERT INTO db_laundry.tb_outlet(nama_outlet, alamat, telp)
                                          VALUES
                                          ('".$_POST['nama_outlet']."','".$_POST['alamat']."','".$_POST['telp']."')
                                         ")OR die(mysqli_error($conn));

        if($insertOutlet==true){
            echo "<script type='text/javascript'>\n";
            echo "alert('Data Berhasil Disimpan');";
            echo "window.location = ('../daftar-outlet.php');";
            echo "</script>";
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Maaf, Terjadi Kesalahan Pada Sistem');";
            echo "window.location = ('../input-outlet.php');";
            echo "</script>";
        }
    }elseif($flag=="prosesHapusOutlet"){
        // var_dump($_POST['id_outlet']);

        $delOutlet=mysqli_query($conn, "DELETE FROM db_laundry.tb_outlet WHERE id_outlet='".$_POST['id_outlet']."'")OR die(mysqli_error($conn));
        
        if($delOutlet==true){
			$data['success']="sukses";
		}else{
			$data['success']="gagal";
		}
		echo json_encode($data);
    }elseif($flag=="prosesEditOutlet"){
        $id_outlet=$_POST['id_outlet'];
		$nama_outlet=$_POST['nama_outlet'];
		$alamat=$_POST['alamat'];
		$telp=$_POST['telp'];
		
		$updOutlet=mysqli_query($conn,"UPDATE db_laundry.tb_outlet 
                                       SET nama_outlet='".$nama_outlet."',alamat='".$alamat."',telp='".$telp."' 
                                       WHERE id_outlet='".$_POST['id_outlet']."'
									  ") OR die(mysqli_error($conn));

        if($updOutlet==true){
            echo "<script type='text/javascript'>\n";
            echo "alert('Data Berhasil Diedit');";
            echo "window.location = ('../daftar-outlet.php');";
            echo "</script>";
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Maaf, Terjadi Kesalahan Pada Sistem');";
            echo "window.location = ('../edit-outlet.php?id_outlet=".$id_outlet."');";
            echo "</script>";
        }
    }elseif($flag=="prosesInputProduk"){
        // var_dump($_POST['nama_produk']);
        // var_dump($_POST['id_outlet']);
        // var_dump($_POST['jenis_produk']);
        // var_dump($_POST['harga']);

        $insertPro=mysqli_query($conn,"INSERT INTO db_laundry.tb_produk(id_outlet, nama_produk, jenis_produk, harga)
                                        VALUES
                                        ('".$_POST['OutletChoose']."','".$_POST['nama_produk']."','".$_POST['jenis_produk']."', '".$_POST['harga']."')
                                        ")OR die(mysqli_error($conn));

        if($insertPro==true){
            echo "<script type='text/javascript'>\n";
            echo "alert('Data Berhasil Disimpan');";
            echo "window.location = ('../daftar-produk.php');";
            echo "</script>";
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Maaf, Terjadi Kesalahan Pada Sistem');";
            echo "window.location = ('../input-produk.php');";
            echo "</script>";
        }
    }elseif($flag=="prosesEditProduk"){
        // var_dump($_POST['id_produk']);
        // var_dump($_POST['id_outlet']);
        // var_dump($_POST['nama_produk']);
        // var_dump($_POST['jenis_produk']);
        // var_dump($_POST['harga']);
		$id_produk=$_POST['id_produk'];


		$updProduk=mysqli_query($conn,"UPDATE db_laundry.tb_produk 
                                       SET id_outlet='".$_POST['id_outlet']."',nama_produk='".$_POST['nama_produk']."',jenis_produk='".$_POST['jenis_produk']."',harga='".$_POST['harga']."'
                                       WHERE id_produk='".$id_produk."'
									  ") OR die(mysqli_error($conn));

        if($updProduk==true){
            echo "<script type='text/javascript'>\n";
            echo "alert('Data Berhasil Diedit');";
            echo "window.location = ('../daftar-produk.php');";
            echo "</script>";
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Maaf, Terjadi Kesalahan Pada Sistem');";
            echo "window.location = ('../edit-produk.php?id_produk=".$id_produk."');";
            echo "</script>";
        }
    }elseif($flag=="prosesHapusProduk"){
        // var_dump($_POST['id_produk']);

        $delProduk=mysqli_query($conn, "DELETE FROM db_laundry.tb_produk WHERE id_produk='".$_POST['id_produk']."'")OR die(mysqli_error($conn));
        
        if($delProduk==true){
			$data['success']="sukses";
		}else{
			$data['success']="gagal";
		}
		echo json_encode($data);
    }elseif($flag=="prosesEditPelanggan"){
        // var_dump($_POST['id_pelanggan']);
        // var_dump($_POST['nama_pelanggan']);
        // var_dump($_POST['alamat']);
        // var_dump($_POST['telp']);
        // var_dump($_POST['jenis_kelamin']);
		$id_pelanggan=$_POST['id_pelanggan'];


		$updPel=mysqli_query($conn,"UPDATE db_laundry.tb_pelanggan 
                                       SET nama_pelanggan='".$_POST['nama_pelanggan']."',alamat='".$_POST['alamat']."',telp='".$_POST['telp']."',jenis_kelamin='".$_POST['jenis_kelamin']."'
                                       WHERE id_pelanggan='".$id_pelanggan."'
									  ") OR die(mysqli_error($conn));

        if($updPel==true){
            echo "<script type='text/javascript'>\n";
            echo "alert('Data Berhasil Diedit');";
            echo "window.location = ('../daftar-pelanggan.php');";
            echo "</script>";
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Maaf, Terjadi Kesalahan Pada Sistem');";
            echo "window.location = ('../edit-pelanggan.php?id_pelanggan=".$id_pelanggan."');";
            echo "</script>";
        }
    }elseif($flag=="prosesHapusPelanggan"){
        // var_dump($_POST['id_pelanggan']);

        $delPel=mysqli_query($conn, "DELETE FROM db_laundry.tb_pelanggan WHERE id_pelanggan='".$_POST['id_pelanggan']."'")OR die(mysqli_error($conn));
        
        if($delPel==true){
			$data['success']="sukses";
		}else{
			$data['success']="gagal";
		}
		echo json_encode($data);
    }
    else if($flag=="prosesEditUser"){
        $id_user=$_POST['id_user'];
		$nama_user=$_POST['nama_user'];
		$username=$_POST['username'];
		$id_outlet=$_POST['id_outlet'];
		$level=$_POST['level'];

		$foto=$_POST['fotoLama'];
        if($_FILES['foto']['tmp_name']!=""){
			$folder= "dist/img/Foto";
			$tmp_name=$_FILES['foto']["tmp_name"];
			$img_name=$_FILES['foto']['name'];
			$foto=$folder."/".date('Ymd-His')."USER-".$img_name;
			move_uploaded_file($tmp_name,"../".$foto);
		}
		$editQuery=mysqli_query($conn,"UPDATE db_laundry.tb_user
                                       SET nama_user='".$nama_user."',username='".$username."',id_outlet='".$id_outlet."',level='".$level."',foto='".$foto."' 
                                       WHERE id_user='".$id_user."' 
                                      ") OR die(mysqli_error($conn));
		if($editQuery==true){
			echo "<script type='text/javascript'>\n";
            echo "alert('Profile Berhasil Diedit');";
            echo "window.location = ('../edit-user.php?id_user=".$id_user."');";
            echo "</script>";
		}else{
			echo "<script type='text/javascript'>\n";
            echo "alert('Maaf, Terjadi Kesalahan Pada Sistem');";
            echo "window.location = ('../edit-user.php?id_user=".$id_user."');";
            echo "</script>";
		}
	}
    elseif($flag=="prosesHapusUser"){
        // var_dump($_POST['id_user']);

        $delUs=mysqli_query($conn, "DELETE FROM db_laundry.tb_user WHERE id_user='".$_POST['id_user']."'")OR die(mysqli_error($conn));
        
        if($delUs==true){
			$data['success']="sukses";
		}else{
			$data['success']="gagal";
		}
		echo json_encode($data);
    }elseif($flag=="buatInvoice"){
        $nama_pelanggan=$_POST['nama_pelanggan'];
        $query_id_pelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_pelanggan FROM db_laundry.tb_pelanggan WHERE nama_pelanggan = '$nama_pelanggan'"));
        $id_pelanggan = $query_id_pelanggan['id_pelanggan'];
        $token="INV".$id_pelanggan.date("ymdhis");
        // var_dump($token);
        // var_dump($_SESSION['id_user']);
        // var_dump($id_pelanggan);
        $insInvoice=mysqli_query($conn,"INSERT INTO db_laundry.tb_transaksi 
                                        (id_outlet,tgl_trx,kd_inv,id_pelanggan,id_user)
                                        VALUES
                                        ('".$_SESSION['id_outlet']."',NOW(),'".$token."','".$id_pelanggan."','".$_SESSION['id_user']."')		
                                        ")OR die(mysqli_error($conn));
        if($insInvoice=true){
            $id_trx=mysqli_insert_id($conn);
            header("location: ../transaksi-produk.php?id_trx=".$id_trx."&id_pelanggan=".$id_pelanggan);
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Gagal Membuat Invoice');";
            echo "</script>";
            header("location: ../transaksi-pelanggan.php");
        }
    }elseif($flag=="orderProduk"){
        $id_produk=$_POST['id_produk'];
		$jumlah=$_POST['jumlah'];
		$id_trx=$_POST['id_trx'];
		$id_pelanggan=$_POST['id_pelanggan'];
        $total_tagihan=$_POST['total_tagihan'];
        $total_tambahan=$_POST['total_tambahan'];
        $ket=$_POST['ket'];

        if(isset($_POST['biaya_tambahan']) && $_POST['biaya_tambahan'] != ""){
            $biaya_tambahan=$_POST['biaya_tambahan'];
        }else{
            $biaya_tambahan=0;
        }

        $insProduk=mysqli_query($conn,"INSERT INTO db_laundry.tb_det_trx (id_trx,id_produk,jumlah,biaya_tambahan,ket)
                                       VALUES ('".$id_trx."','".$id_produk."','".$jumlah."','".$biaya_tambahan."','".$ket."') 
                                      ") OR die(mysqli_error($conn));
		
        $tambahan_tetap=$total_tambahan+$biaya_tambahan;
        $hargaTotal=$_POST['harga']*$jumlah+$biaya_tambahan;
		
        $updateTransaksi=mysqli_query($conn,"UPDATE db_laundry.tb_transaksi 
                                             SET total_tagihan=".$total_tagihan."+".$hargaTotal.", total_tambahan=".$tambahan_tetap."
                                             WHERE id_trx='".$id_trx."'
                                            ") OR die(mysqli_error($conn));
		
        if($updateTransaksi==true){
            echo "<script type='text/javascript'>\n";
            echo "alert('Berhasil Menambahkan Order');";
            echo "window.location = ('../transaksi-produk.php?id_trx=".$id_trx."&id_pelanggan=".$id_pelanggan."');";
            echo "</script>";
		}else{
			echo "<script type='text/javascript'>\n";
			echo "alert('Gagal Membuat Invoice');";
			echo "</script>";
			header("location: ../transaksi-produk.php?id_trx=".$id_trx."&id_pelanggan=".$id_pelanggan);
		}
    }elseif($flag=="orderRincian"){
        $id_trx=$_POST['id_trx'];
        $id_pelanggan=$_POST['id_pelanggan'];
        $total_tagihan=$_POST['total_tagihan'];
        $pajak=$total_tagihan*0.0075;
        $trx_disc=mysqli_num_rows(mysqli_query($conn,"SELECT id_pelanggan FROM db_laundry.tb_transaksi WHERE id_pelanggan='".$id_pelanggan."'"));
        if($trx_disc % 3 == 0 && $trx_disc != 0){
            $diskon = ($total_tagihan+$pajak)*0.1;
        }else{
            $diskon = 0;
        }
        $total_akhir=$total_tagihan+$pajak-$diskon;

        // var_dump($id_trx,$id_pelanggan,$total_tagihan,$pajak,$diskon,$total_akhir);

        $updRincianTrx=mysqli_query($conn, "UPDATE db_laundry.tb_transaksi
                                            SET total_tagihan=".$total_akhir.", 
                                            diskon=".$diskon.", 
                                            pajak=".$pajak." 
                                            WHERE id_trx='".$id_trx."'
                                            ")OR die(mysqli_error($conn));

        if($updRincianTrx==true){
            header("location: ../transaksi-rincian.php?id_trx=".$id_trx."&id_pelanggan=".$id_pelanggan);
		}else{
			echo "<script type='text/javascript'>\n";
			echo "alert('Gagal Membuat Order');";
            echo "window.location = ('../transaksi-produk.php?id_trx=".$id_trx."&id_pelanggan=".$id_pelanggan."');";
			echo "</script>";
		}
    }elseif($flag=="orderAkhir"){
        $id_trx=$_POST['id_trx'];
        $sts_bayar=$_POST['sts_bayar'];
        if($sts_bayar==1){
            $tgl_bayar="NOW()";
        }else{
            $tgl_bayar="NULL";
        }

        $updAkhirTrx=mysqli_query($conn, "UPDATE db_laundry.tb_transaksi
                                          SET deadline_date=NOW()+INTERVAL 3 DAY,
                                          tgl_bayar=".$tgl_bayar.", 
                                          sts_bayar=".$sts_bayar."
                                          WHERE id_trx=".$id_trx."
                                        ")OR die(mysqli_error($conn));

        if($updAkhirTrx==true){
            echo "<script type='text/javascript'>\n";
            echo "alert('Berhasil Membuat Order');";
            echo "window.location = ('../transaksi-list.php');";
            echo "</script>";
		}else{
			echo "<script type='text/javascript'>\n";
			echo "alert('Gagal Membuat Order');";
            echo "window.location = ('../transaksi-rincian.php?id_trx=".$id_trx."&id_pelanggan=".$id_pelanggan."');";
			echo "</script>";
		}
    }elseif($flag=="orderHapus"){
        $id_det_trx=$_POST['id_det_trx'];
        $id_trx=$_POST['id_trx'];
        $total_tagihan=$_POST['total_tagihan'];
        $pajak=$_POST['pajak'];
        $diskon=$_POST['diskon'];
        $harga=$_POST['harga'];
        $biaya_tambahan=$_POST['biaya_tambahan'];

        $total_awal=$total_tagihan+$diskon-$pajak-$biaya_tambahan-$harga; // harga tanpa produk yg didelete 
        $pajak_2=$total_awal*0.0075;
        if($diskon>0){
            $diskon = ($total_awal+$pajak_2)*0.1;
        }else{
            $diskon = 0;
        }
        $total_akhir=$total_awal+$pajak_2-$diskon;

        $delOrder=mysqli_query($conn, "DELETE FROM db_laundry.tb_det_trx WHERE id_det_trx='".$id_det_trx."'")OR die(mysqli_error($conn));
        
        $updDelTrx=mysqli_query($conn, "UPDATE db_laundry.tb_transaksi
                                          SET total_tagihan=".$total_akhir.", 
                                          diskon=".$diskon.", 
                                          pajak=".$pajak_2." 
                                          WHERE id_trx='".$id_trx."'
                                        ")OR die(mysqli_error($conn));
        
        if($updDelTrx==true){
			$data['success']="sukses";
		}else{
			$data['success']="gagal";
		}
		echo json_encode($data);
    }elseif($flag=="updateStsBayar"){
        $updSts=mysqli_query($conn, "UPDATE db_laundry.tb_transaksi SET sts_bayar=1 WHERE id_trx='".$_POST['id_trx']."'")OR die(mysqli_error($conn));

        if($updSts==true){
            $data['success']="sukses";
        }else{
            $data['success']="gagal";
        }
		echo json_encode($data);
    }elseif($flag=="updateStsProses"){
        $id_trx=$_POST['id_trx'];
        $sts_proses=$_POST['sts_proses'];

        if($sts_proses=="Baru"){
            $updSts=mysqli_query($conn, "UPDATE db_laundry.tb_transaksi SET sts_proses='Proses' WHERE id_trx='".$id_trx."'")OR die(mysqli_error($conn));
        }elseif($sts_proses=="Proses"){
            $updSts=mysqli_query($conn, "UPDATE db_laundry.tb_transaksi SET sts_proses='Selesai' WHERE id_trx='".$id_trx."'")OR die(mysqli_error($conn));
        }elseif($sts_proses=="Selesai"){
            $updSts=mysqli_query($conn, "UPDATE db_laundry.tb_transaksi SET sts_proses='Diambil' WHERE id_trx='".$id_trx."'")OR die(mysqli_error($conn));
        }

        if($updSts==true){
            $data['success']="sukses";
        }else{
            $data['success']="gagal";
        }
        echo json_encode($data);
    }elseif($flag=="changePasswd"){
        $id_user = $_POST['id_user'];
        $passwd = $_POST['passwd'];
        $passwordLama = $_POST['passwordLama'];
        $options = [
            'cost' => 10,
        ];
        $password_encry = password_hash($passwd,PASSWORD_DEFAULT,$options);
        
        $queryUser=mysqli_query($conn,"SELECT passwd 
                                        FROM db_laundry.tb_user
                                        WHERE id_user='".$id_user."' 
                                    ") OR die(mysqli_error($conn)); 

        $fetch=mysqli_fetch_array($queryUser);
        $password_hash = $fetch['passwd'];

        if(password_verify($passwordLama,$password_hash)){
            $updPass=mysqli_query($conn, "UPDATE db_laundry.tb_user SET passwd='".$password_encry."' WHERE id_user='".$id_user."'")OR die(mysqli_error($conn));
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Maaf, password anda salah');";
            echo "window.location = ('../edit-user.php?id_user=".$id_user."');";
            echo "</script>";
        }

        if($updPass==true){
            echo "<script type='text/javascript'>\n";
            echo "alert('Berhasil Mengubah Password');";
            echo "window.location = ('../edit-user.php?id_user=".$id_user."');";
            echo "</script>";
		}else{
			echo "<script type='text/javascript'>\n";
			echo "alert('Gagal Mengubah Password');";
            echo "window.location = ('../edit-user.php?id_user=".$id_user."');";
			echo "</script>";
		}
    }
?>