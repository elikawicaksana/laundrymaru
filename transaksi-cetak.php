<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cetak Laporan | Laundry Maru</title>
    <?php 
        session_start();
        include "include/head.php"; 
        include "config/koneksi.php"; 
        include "config/fungsi.php"; 

        $orderdate1 = explode('/', $_POST['tgl_awal']);
        $month1 = $orderdate1[0];
        $day1   = $orderdate1[1];
        $year1  = $orderdate1[2];
        $tgl_awal = $year1."-".$month1."-".$day1;

        $orderdate2 = explode('/', $_POST['tgl_akhir']);
        $month2 = $orderdate2[0];
        $day2   = $orderdate2[1];
        $year2  = $orderdate2[2];
        $tgl_akhir = $year2."-".$month2."-".$day2;
        
        $awal=tgl_indo($_POST['tgl_awal']);
        $akhir=tgl_indo($_POST['tgl_akhir']);
    ?>
    <style>
        .outlet{
            background-color: yellow;
        }

        @media print{
            .outlet{
                background-color: yellow !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body id="laporan_wrapper">
    <h2 class="text-center"><b>LAPORAN TRANSAKSI LAUNDRY MARU</b></h2>
    <h4 class="text-center">Periode : <?php echo $awal." - ".$akhir ?></h4>
    <hr style="border: 2px solid black;"><hr>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <table class="table table-bordered">
                <?php
                    if($_SESSION['level']=='Admin' OR $_SESSION['level']=='Owner'){
                        $query_outlet = mysqli_query($conn,"SELECT tb_outlet.* 
                                                            FROM db_laundry.tb_transaksi
                                                            LEFT JOIN db_laundry.tb_outlet ON tb_transaksi.id_outlet=tb_outlet.id_outlet
                                                            WHERE tgl_trx BETWEEN '$tgl_awal 00:00:00' AND '$tgl_akhir 23:59:59' AND sts_bayar=1 GROUP BY id_outlet 
                                                           ")OR die(mysqli_error($conn));
                    }else{
                        $query_outlet = mysqli_query($conn, "SELECT tb_outlet.* 
                                                             FROM db_laundry.tb_transaksi
                                                             LEFT JOIN db_laundry.tb_outlet ON tb_transaksi.id_outlet=tb_outlet.id_outlet
                                                             WHERE tgl_trx BETWEEN '$tgl_awal 00:00:00' AND '$tgl_akhir 23:59:59' AND sts_bayar=1 AND tb_transaksi.id_outlet='".$_SESSION['id_outlet']."' GROUP BY id_outlet 
                                                            ")OR die(mysqli_error($conn));
                    }
                    $total_semua = 0;
                    while($fetchOutlet=mysqli_fetch_array($query_outlet)){
                        if($_SESSION['level']=='Admin' OR $_SESSION['level']=='Owner'){
                            $query = mysqli_query($conn,"SELECT * 
                                                         FROM db_laundry.tb_det_trx
                                                         LEFT JOIN db_laundry.tb_transaksi ON tb_det_trx.id_trx=tb_transaksi.id_trx
                                                         LEFT JOIN db_laundry.tb_outlet ON tb_transaksi.id_outlet=tb_outlet.id_outlet
                                                         LEFT JOIN db_laundry.tb_pelanggan ON tb_transaksi.id_pelanggan=tb_pelanggan.id_pelanggan
                                                         WHERE tgl_trx BETWEEN '$tgl_awal 00:00:00' AND '$tgl_akhir 23:59:59' AND sts_bayar=1 AND tb_transaksi.id_outlet='".$fetchOutlet['id_outlet']."' GROUP BY kd_inv 
                                                        ")OR die(mysqli_error($conn));
                        }else{
                            $query = mysqli_query($conn, "SELECT * 
                                                          FROM db_laundry.tb_det_trx
                                                          LEFT JOIN db_laundry.tb_transaksi ON tb_det_trx.id_trx=tb_transaksi.id_trx
                                                          LEFT JOIN db_laundry.tb_outlet ON tb_transaksi.id_outlet=tb_outlet.id_outlet
                                                          LEFT JOIN db_laundry.tb_pelanggan ON tb_transaksi.id_pelanggan=tb_pelanggan.id_pelanggan 
                                                          WHERE tgl_trx BETWEEN '$tgl_awal 00:00:00' AND '$tgl_akhir 23:59:59' AND sts_bayar=1 AND tb_transaksi.id_outlet='".$_SESSION['id_outlet']."' GROUP BY kd_inv 
                                                        ")OR die(mysqli_error($conn));
                        }

                        echo "
                            <tr>
                                <td colspan='4' class='outlet'>
                                    Nama Outlet : <b>".$fetchOutlet['nama_outlet']."</b>
                                </td>
                            </tr>
                            <tr>
                                <td>No</td>
                                <td>Pelanggan</td>
                                <td>Paket</td>
                                <td>Total Harga</td>
                            </tr>
                        ";

                        $i=1;
                        while($fetch=mysqli_fetch_array($query)){
                            $query_paket=mysqli_query($conn,"SELECT * FROM db_laundry.tb_det_trx
                                                             LEFT JOIN db_laundry.tb_produk ON tb_det_trx.id_produk=tb_produk.id_produk
                                                             WHERE id_trx='".$fetch['id_trx']."'
                                                            ")OR die(mysqli_error($conn));
                            echo "
                                <tr>
                                    <td>".$i."</td>
                                    <td>".$fetch['nama_pelanggan']."</td>
                                    <td>
                                    ";
                                    while($fetch_paket=mysqli_fetch_array($query_paket)){
                                      echo $fetch_paket['nama_produk']."<br/>";  
                                    }
                                    echo"
                                    </td>
                                    <td>".formatUang($fetch['total_tagihan'])."</td>
                                </tr>
                            ";
                            $total_semua+=$fetch['total_tagihan'];
                            $pajak_semua+=$fetch['pajak'];
                            $dataCheck=$fetch['kd_inv'];
                            $i++;
                        }
                    }
                ?>
                <tr align="right">
                    <td colspan="3">
                        <b>Total Pendapatan</b>
                        <br/>
                        <?php echo "Tanggal : ".$awal." - ".$akhir ?>
                    </td>
                    <td> 
                        <?php
                            echo "
                                <h4><b>".formatUang($total_semua)."</b></h4>
                                Pajak : ".formatUang($pajak_semua)."
                            ";
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>
    // function CreatePDFfromHTML(domElement) {
    //     var contentWidth = $(domElement).width();
    //     var contentHeight = $(domElement).height();
    //     var topTeftMargin = 10;
    //     var pdfWidth = contentWidth+(topTeftMargin*2);
    //     var pdfHeight = (pdfWidth*1.5)+(topTeftMargin*2);
    //     var canvasImageWidth = contentWidth;
    //     var canvasImageHeight = contentHeight;
    //     var totalPDFPages = Math.ceil(contentHeight/pdfHeight)-1;

    //     html2canvas($(domElement)[0],{allowTaint:true}).then(function(canvas) {
    //         canvas.getContext('2d');
    //         var imgData = canvas.toDataURL("image/jpeg", 1.0);
    //         var pdf = new jsPDF('p', 'pt',  [pdfWidth, pdfHeight]);
    //         pdf.addImage(imgData, 'JPG', topTeftMargin, topTeftMargin,canvasImageWidth,canvasImageHeight);
    //         for (var i = 1; i <= totalPDFPages; i++) {
    //             pdf.addPage(pdfWidth, pdfHeight);
    //             pdf.addImage(imgData, 'JPG', topTeftMargin, -(pdfHeight*i)+(topTeftMargin*4),canvasImageWidth,canvasImageHeight);
    //         }
    //         pdf.save("laporan.pdf");
    //     });
    // }

    // CreatePDFfromHTML("#laporan_wrapper");
    $(function () {
        var dataCheck = <?php echo json_encode($dataCheck); ?>;
        // alert(dataCheck);
        if(dataCheck != null){
            window.addEventListener("load", window.print());
        }else{
            alert("Tidak ada transaksi pada periode <?php echo $awal." - ".$akhir ?>");
            window.location = ('transaksi-list.php');
        }
    });
</script>
</html>