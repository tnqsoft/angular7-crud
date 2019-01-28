/*
MySQL - 5.7.25-0ubuntu0.18.10.2 : Database - transfer_money
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`transfer_money` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `transfer_money`;

/*Table structure for table `tbl_summary` */

DROP TABLE IF EXISTS `tbl_summary`;

CREATE TABLE `tbl_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_money` float DEFAULT '0',
  `transfer_money` float DEFAULT '0',
  `collect_money` float DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_summary` */

insert  into `tbl_summary`(`id`,`start_money`,`transfer_money`,`collect_money`) values (1,0,0,0);

/*Table structure for table `tbl_transfer` */

DROP TABLE IF EXISTS `tbl_transfer`;

CREATE TABLE `tbl_transfer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer` varchar(100) DEFAULT NULL,
  `amount` float DEFAULT '0',
  `transferDate` date DEFAULT NULL,
  `transferType` varchar(255) DEFAULT NULL,
  `note` mediumtext,
  `customerBankName` varchar(255) DEFAULT NULL,
  `customerBankAcount` varchar(100) DEFAULT NULL,
  `customerBankId` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tbl_user` */

DROP TABLE IF EXISTS `tbl_user`;

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_user` */

insert  into `tbl_user`(`id`,`username`,`pass`,`email`,`fullname`,`is_active`,`last_login`) values (1,'admin','e10adc3949ba59abbe56e057f20f883e','your@domain.com',NULL,1,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
