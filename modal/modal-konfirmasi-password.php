<form action="proses/prosesQuery.php" method="post">
    <?php
		echo " 
			<input type='hidden' name='flag' value='changePasswd'>
			<input type='hidden' name='id_user' value='".$_POST['id_user']."'>
			<input type='hidden' name='passwd' value='".$_POST['passwd']."'>
        "; 
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
				<label>Masukkan Password Lama :</label>
				<input type="password" name="passwordLama" id="passwordLama" class="form-control" placeholder="Password Lama..." required>
			</div>
		</div>
		<div class="col-lg-12">
			<button type="submit" class="btn btn-block btn-success" id="btnPass"><i class="fa fa-save"></i> Confirm</button>
		</div>
	</div>
</form>
