<?php 
    include "../config/koneksi.php"; 
    include '../config/fungsi.php';

    $selTransaksi=mysqli_query($conn,"SELECT nama_outlet,kd_inv,DATE_FORMAT(deadline_date,'%e %M %Y') AS deadline_date,DATE_FORMAT(tgl_trx,'%e %M %Y') AS tgl_trx,tb_pelanggan.* 
                                        FROM db_laundry.tb_transaksi 
                                        LEFT JOIN db_laundry.tb_pelanggan ON tb_pelanggan.id_pelanggan=tb_transaksi.id_pelanggan
                                        LEFT JOIN db_laundry.tb_outlet ON tb_outlet.id_outlet=tb_transaksi.id_outlet
                                        WHERE id_trx='".$_POST['id_trx']."'") OR die(mysqli_error($conn));
    $fetchTransaksi=mysqli_fetch_array($selTransaksi);
?>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-globe"></i> <?php echo $fetchTransaksi['nama_outlet'] ?>
                            <small class="float-right">Date: <?php echo $fetchTransaksi['tgl_trx'] ?></small>
                        </h4>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        Customer Details
                        <address>
                            <strong><?php echo $fetchTransaksi['nama_pelanggan'] ?></strong><br>
                            <?php echo $fetchTransaksi['alamat'] ?><br>
                            <?php echo $fetchTransaksi['telp'] ?><br>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>Invoice #<?php echo $fetchTransaksi['kd_inv'] ?></b><br>
                        <br>
                        <b>Deadline Date:</b> <?php echo $fetchTransaksi['deadline_date'] ?><br>
                    </div>
                </div><br/>
                <form>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped" id="tableData">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Paket</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Biaya Tambahan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=1;
                                        $queryProduk=mysqli_query($conn,"SELECT tb_det_trx.*, SUM(tb_det_trx.jumlah) AS jumlah, tb_produk.*,tb_transaksi.*
                                                                        FROM db_laundry.tb_det_trx
                                                                        LEFT JOIN db_laundry.tb_produk ON tb_produk.`id_produk`=tb_det_trx.`id_produk`
                                                                        LEFT JOIN db_laundry.tb_transaksi ON tb_transaksi.id_trx=tb_det_trx.id_trx
                                                                        WHERE tb_det_trx.id_trx='".$_POST['id_trx']."' 
                                                                        GROUP BY tb_det_trx.`id_produk` 
                                                                    ") OR die(mysqli_error($conn));
                                        while($fetchProduk=mysqli_fetch_array($queryProduk)){
                                            $total_harga=$fetchProduk['jumlah']*$fetchProduk['harga'];
                                            echo 
                                            "<tr>
                                                <td>".$i."</td>
                                                <td>".$fetchProduk['nama_produk']."</td>
                                                <td >".formatUang($fetchProduk['harga'])."</td>
                                                <td >".$fetchProduk['jumlah']."</td>
                                                <td >".formatUang($fetchProduk['biaya_tambahan'])."</td>
                                                <td>".$fetchProduk['ket']."</td>
                                            </tr>
                                            ";
                                            $i++;
                                            $totalBelanja+=$total_harga;
                                            if($fetchProduk['diskon']>0){
                                                $diskonshow = '10%';
                                            }else{
                                                $diskonshow = '0%';
                                            }
                                            $total_tambahan=$fetchProduk['total_tambahan'];
                                            $biaya_tambahan=$fetchProduk['biaya_tambahan'];
                                            $pajak=$fetchProduk['pajak'];
                                            $total_tagihan=$fetchProduk['total_tagihan'];
                                            $diskon=$fetchProduk['diskon'];
                                            $sts_bayar=$fetchProduk['sts_bayar'];
                                        }											
                                    ?>	
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="lead">Payment Status</p>
                            <?php
                                if($sts_bayar==2){
                                    echo "<h4 class='text-bold text-danger'>BELUM LUNAS</h4>";
                                }else{
                                    echo "<h4 class='text-bold text-success'>LUNAS</h4>";
                                }
                            ?>
                        </div>
                        <div class="col-6">
                            <p class="lead">Amount Due</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Total Awal</th>
                                        <td><?php echo formatUang($totalBelanja) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Biaya Tambahan</th>
                                        <td><?php echo formatUang($total_tambahan) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tax (0.75%)</th>
                                        <td><?php echo formatUang($pajak) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Diskon (<?php echo $diskonshow ?>)</th>
                                        <td>-<?php echo formatUang($diskon) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total Akhir</th>
                                        <td><?php echo formatUang($total_tagihan) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>    
    <a href="<?php echo "invoice-pdf.php?id_trx=".$_POST['id_trx']."" ?>" rel="noopener" target="_blank" class="btn btn-light float-right"><i class="fas fa-print"></i> Generate PDF</a>               
    <a href="<?php echo "invoice-print.php?id_trx=".$_POST['id_trx']."" ?>" rel="noopener" target="_blank" class="btn btn-light float-right"><i class="fas fa-print"></i> Print</a>               
</div>