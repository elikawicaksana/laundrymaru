/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 8.0.30 : Database - db_laundry
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_laundry` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_laundry`;

/*Table structure for table `tb_det_trx` */

DROP TABLE IF EXISTS `tb_det_trx`;

CREATE TABLE `tb_det_trx` (
  `id_det_trx` int NOT NULL AUTO_INCREMENT,
  `id_trx` int DEFAULT NULL,
  `id_produk` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `biaya_tambahan` double DEFAULT NULL,
  `ket` text,
  PRIMARY KEY (`id_det_trx`),
  KEY `id_trx` (`id_trx`),
  KEY `id_produk` (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_det_trx` */

insert  into `tb_det_trx`(`id_det_trx`,`id_trx`,`id_produk`,`jumlah`,`biaya_tambahan`,`ket`) values 
(26,10,5,5,15000,'Parfum oliver'),
(27,10,7,2,10000,'Parfum oliver'),
(29,11,7,5,10000,'Parfum Rose'),
(30,12,7,3,5000,'Parfum Rose'),
(31,12,5,1,15000,'Parfum Lavender'),
(33,15,6,1,5000,'Parfum Lavender'),
(34,16,6,1,0,'');

/*Table structure for table `tb_outlet` */

DROP TABLE IF EXISTS `tb_outlet`;

CREATE TABLE `tb_outlet` (
  `id_outlet` int NOT NULL AUTO_INCREMENT,
  `nama_outlet` varchar(50) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`id_outlet`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_outlet` */

insert  into `tb_outlet`(`id_outlet`,`nama_outlet`,`alamat`,`telp`) values 
(1,'Laundry Maru Bali','Jl. Tukad Badung No.777, Renon, Denpasar Selatan, Kota Denpasar, Bali 80226','083884759274'),
(8,'Laundry Maru Jakarta','Jl. Keamanan No.47, RT.1/RW.7, Keagungan, Kec. Taman Sari, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11130','083774893749'),
(10,'Laundry Maru Malang','Jl. Candi Agung I No.8, Mojolangu, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142','083759572748');

/*Table structure for table `tb_pelanggan` */

DROP TABLE IF EXISTS `tb_pelanggan`;

CREATE TABLE `tb_pelanggan` (
  `id_pelanggan` int NOT NULL AUTO_INCREMENT,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(18) DEFAULT NULL,
  `jenis_kelamin` enum('Perempuan','Laki-laki') DEFAULT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_pelanggan` */

insert  into `tb_pelanggan`(`id_pelanggan`,`nama_pelanggan`,`alamat`,`telp`,`jenis_kelamin`) values 
(1,'Rei Enryudhawan','Jl. Tukad Citarum No.11\r\n\r\n','085776091830','Laki-laki'),
(2,'Nadine Priscilla','Jl. Tukad Citarum No.11\r\n\r\n','081483071142','Perempuan'),
(4,'Andra Pradipta','Jl. Tukad Citarum No.11\r\n\r\n','085776091830','Laki-laki'),
(5,'Reva Fidela','Jl. Tukad Batanghari No.11','085847284610','Perempuan'),
(6,'Ten Pradipta','Jl. Tukad Citarum No.11','084883742817','Laki-laki');

/*Table structure for table `tb_produk` */

DROP TABLE IF EXISTS `tb_produk`;

CREATE TABLE `tb_produk` (
  `id_produk` int NOT NULL AUTO_INCREMENT,
  `id_outlet` int DEFAULT NULL,
  `nama_produk` varchar(50) DEFAULT NULL,
  `jenis_produk` enum('Kiloan','Selimut','Bedcover','Kaos','Lainnya') DEFAULT NULL,
  `harga` double DEFAULT NULL,
  PRIMARY KEY (`id_produk`),
  KEY `id_outlet` (`id_outlet`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_produk` */

insert  into `tb_produk`(`id_produk`,`id_outlet`,`nama_produk`,`jenis_produk`,`harga`) values 
(1,1,'Paket Cuci Kilat','Kiloan',5000),
(5,1,'Paket Setrika Kilat','Kiloan',5000),
(6,1,'Paket Komplit Kilat','Kiloan',7000),
(7,1,'Paket Komplit Bedcover ','Bedcover',10000),
(8,10,'Boneka/Sepatu/Guling','Lainnya',10000);

/*Table structure for table `tb_transaksi` */

DROP TABLE IF EXISTS `tb_transaksi`;

CREATE TABLE `tb_transaksi` (
  `id_trx` int NOT NULL AUTO_INCREMENT,
  `id_outlet` int DEFAULT NULL,
  `tgl_trx` datetime DEFAULT NULL,
  `kd_inv` varchar(100) DEFAULT NULL,
  `id_pelanggan` int DEFAULT NULL,
  `total_tagihan` double DEFAULT '0',
  `deadline_date` datetime DEFAULT NULL,
  `tgl_bayar` datetime DEFAULT NULL,
  `diskon` double DEFAULT '0',
  `pajak` double DEFAULT NULL,
  `total_tambahan` double DEFAULT '0',
  `sts_proses` enum('Baru','Proses','Selesai','Diambil') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Baru',
  `sts_bayar` tinyint DEFAULT '2',
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id_trx`),
  KEY `id_user` (`id_user`),
  KEY `id_pelanggan` (`id_pelanggan`),
  KEY `id_outlet` (`id_outlet`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_transaksi` */

insert  into `tb_transaksi`(`id_trx`,`id_outlet`,`tgl_trx`,`kd_inv`,`id_pelanggan`,`total_tagihan`,`deadline_date`,`tgl_bayar`,`diskon`,`pajak`,`total_tambahan`,`sts_proses`,`sts_bayar`,`id_user`) values 
(10,1,'2024-02-28 19:41:27','INV2240228074127',2,284366.875,'2024-03-02 16:29:59','2024-03-01 16:29:59',0,2116.875,25000,'Diambil',1,1),
(11,8,'2024-03-03 21:09:27','INV1240303090927',1,211575,'2024-03-04 21:10:00',NULL,0,1575,10000,'Diambil',1,1),
(12,1,'2024-03-11 16:17:46','INV1240311041746',1,176312.5,'2024-03-14 17:18:54',NULL,0,1312.5,20000,'Diambil',1,1),
(15,1,'2024-03-28 20:35:03','INV4240328083503',4,17127.5,'2024-03-31 21:13:39','2024-03-28 21:13:39',0,127.5,5000,'Proses',2,1),
(16,1,'2024-03-28 21:15:48','INV2240328091548',2,12090,'2024-03-31 21:16:01',NULL,0,90,0,'Proses',2,1);

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(50) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `passwd` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_outlet` int DEFAULT NULL,
  `level` enum('Admin','Kasir','Owner') DEFAULT NULL,
  `foto` text,
  PRIMARY KEY (`id_user`),
  KEY `id_outlet` (`id_outlet`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id_user`,`nama_user`,`username`,`passwd`,`id_outlet`,`level`,`foto`) values 
(1,'John Doe','doejohn123','$2y$10$3EvatdBCIyO6R0NCtZv3L.Yz8tAms2YWjbRI3jr/5j/N7Sr26ZL06',10,'Admin','dist/img/Foto/20240308-192841USER-user8-128x128.jpg'),
(5,'Jane Doe','doejane123','$2y$10$F.lffzLiU7wKsANpL.9yu.BmGydESs2HT/qiDhdgScf13u.aoWLry',1,'Kasir','dist/img/Foto/20240308-192841USER-user8-128x128.jpg'),
(6,'Dony Doe ','doedony123','$2y$10$e/NXujBACOxolYzHNZcSWOH7yuU518PyAgiIvNUbLNSDjzoHuzJzK',1,'Owner','dist/img/Foto/20240308-192841USER-user8-128x128.jpg');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
