<div class="modal-body">
	<form method="POST" action="proses/prosesQuery.php" role="form" autocomplete="off">
		<?php
			echo " 
			<h4 class='modal-title text-center'>Detail Order</h4><br/>
			<input type='hidden' name='flag' value='orderProduk'>
			<input type='hidden' name='id_produk' value='".$_POST['id_produk']."'>
			<input type='hidden' name='id_trx' value='".$_POST['id_trx']."'>
			<input type='hidden' name='id_pelanggan' value='".$_POST['id_pelanggan']."'>
			<input type='hidden' name='harga' value='".$_POST['harga']."'>
			<input type='hidden' name='total_tagihan' value='".$_POST['total_tagihan']."'>
			<input type='hidden' name='total_tambahan' value='".$_POST['total_tambahan']."'>
			
			<label>Jumlah</label>
			<input type='number' name='jumlah' class='form-control' placeholder='Dalam satuan kg/pcs' required><br/>
			<label>Biaya Tambahan</label>
			<input type='number' name='biaya_tambahan' class='form-control' placeholder='Biaya tambahan jika ada request tambahan'><br/>
			<label>Keterangan</label>
			<input type='text' name='ket' class='form-control' placeholder='Keterangan jika ada request order'><br/>
			"; 
		?>
		<div class="modal-footer justify-content-between">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-success">Add Order</button>
		</div>
	</form>
</div>