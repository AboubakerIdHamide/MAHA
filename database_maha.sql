-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for maha
CREATE DATABASE IF NOT EXISTS `maha` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `maha`;

-- Dumping structure for table maha.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nom_admin` varchar(50) NOT NULL,
  `prenom_admin` varchar(50) NOT NULL,
  `email_admin` varchar(100) NOT NULL,
  `img_admin` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `balance` float DEFAULT '0',
  `platform_pourcentage` float NOT NULL DEFAULT '0',
  `username_paypal` varchar(255) DEFAULT NULL,
  `password_paypal` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_admin`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.admin: ~1 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id_admin`, `nom_admin`, `prenom_admin`, `email_admin`, `img_admin`, `mot_de_passe`, `balance`, `platform_pourcentage`, `username_paypal`, `password_paypal`) VALUES
	(1, 'sdknsdf', 'sdfsdfsdf', 'sarouti@gmail.com', 'images/membre.jpg', 'admin123@@@', 431, 10, 'Af173BC6L0TzwyZG3Q1ToevB8qmvCAOI_xmgtNnbKex2QydeYCM335mCsvJwvuupkJmABbUxYnThj9wE', 'ELTMVnjyg1lmDXDnZZTTVJKeLrWBfz5Cgg0GGp-9hPKzKwqY7GwkQEm5upYE4t6y2ip_JutuifOMD_0x');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table maha.bookmarks
CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id_etudiant` varchar(255) NOT NULL,
  `id_video` int(11) NOT NULL,
  KEY `FK_bookmarks_etudiants` (`id_etudiant`),
  KEY `FK_bookmarks_videos` (`id_video`),
  CONSTRAINT `FK_bookmarks_etudiants` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_bookmarks_videos` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.bookmarks: ~5 rows (approximately)
/*!40000 ALTER TABLE `bookmarks` DISABLE KEYS */;
INSERT INTO `bookmarks` (`id_etudiant`, `id_video`) VALUES
	('ETU1', 1),
	('ETU3', 11),
	('ETU4', 12),
	('ETU5', 3),
	('ETU5', 8);
/*!40000 ALTER TABLE `bookmarks` ENABLE KEYS */;

-- Dumping structure for table maha.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(100) NOT NULL DEFAULT '',
  `nom_categorie` varchar(50) NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.categories: ~13 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id_categorie`, `icon`, `nom_categorie`) VALUES
	(1, '<i class="fa-brands fa-unity"></i>', '3D'),
	(2, '<i class="fa-solid fa-ruler-combined"></i>', 'Architecture & BIM'),
	(3, '<i class="fa-solid fa-sliders"></i>', 'Audio-MAO'),
	(4, '<i class="fa-sharp fa-solid fa-briefcase"></i>', 'Business & Efficacité professionnelle'),
	(5, '<i class="fa-solid fa-code"></i>', 'Code'),
	(6, '<i class="fa-sharp fa-solid fa-pen-nib"></i>', 'Infographie'),
	(7, '<i class="fa-solid fa-camera-retro"></i>', 'Photographie'),
	(8, '<i class="fa-solid fa-video"></i>', 'Vidéo-Compositing'),
	(9, '<i class="fa-solid fa-chart-simple"></i>', 'Webmarketing'),
	(10, '<i class="fa-solid fa-network-wired"></i>', 'Réseaux informatique'),
	(11, '<i class="fa-solid fa-list-check"></i>', 'Management'),
	(12, '<i class="fa-solid fa-computer-mouse"></i>', 'Bureautique'),
	(13, 'sdfsd', 'Somf');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table maha.commentaires
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id_commentaire` int(11) NOT NULL AUTO_INCREMENT,
  `id_video` int(11) NOT NULL,
  `from_user` varchar(255) NOT NULL,
  `to_user` varchar(255) NOT NULL,
  `type_user` varchar(20) NOT NULL,
  `commentaire` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_commentaire`) USING BTREE,
  KEY `id_video` (`id_video`) USING BTREE,
  CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.commentaires: ~7 rows (approximately)
/*!40000 ALTER TABLE `commentaires` DISABLE KEYS */;
INSERT INTO `commentaires` (`id_commentaire`, `id_video`, `from_user`, `to_user`, `type_user`, `commentaire`, `created_at`) VALUES
	(1, 4, 'ETU2', 'FOR2', 'etudiant', 'Bonjour, Mohcine', '2023-03-29 03:45:14'),
	(2, 11, 'ETU3', 'FOR4', 'etudiant', 'Bonjour', '2023-03-29 03:47:03'),
	(3, 1, 'ETU3', 'FOR1', 'etudiant', 'Hello John', '2023-03-29 03:47:16'),
	(4, 1, 'ETU4', 'FOR1', 'etudiant', 'Sunt ?', '2023-03-29 03:49:00'),
	(5, 12, 'ETU4', 'FOR5', 'etudiant', 'Hi, Prof', '2023-03-29 03:49:57'),
	(6, 3, 'ETU5', 'FOR1', 'etudiant', 'Hi, John', '2023-03-29 03:51:26'),
	(7, 1, 'FOR1', 'ETU4', 'formateur', 'Hello Guys', '2023-03-29 03:52:19'),
	(8, 8, 'ETU1', 'FOR3', 'etudiant', 'Bonjour', '2023-06-01 23:25:08'),
	(9, 8, 'FOR3', 'ETU1', 'formateur', 'Bonsoir', '2023-06-01 23:25:42');
/*!40000 ALTER TABLE `commentaires` ENABLE KEYS */;

-- Dumping structure for table maha.etudiants
CREATE TABLE IF NOT EXISTS `etudiants` (
  `id_etudiant` varchar(255) NOT NULL,
  `nom_etudiant` varchar(50) NOT NULL,
  `prenom_etudiant` varchar(50) NOT NULL,
  `email_etudiant` varchar(100) NOT NULL,
  `tel_etudiant` varchar(15) DEFAULT NULL,
  `date_creation_etudiant` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `img_etudiant` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_etudiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.etudiants: ~5 rows (approximately)
/*!40000 ALTER TABLE `etudiants` DISABLE KEYS */;
INSERT INTO `etudiants` (`id_etudiant`, `nom_etudiant`, `prenom_etudiant`, `email_etudiant`, `tel_etudiant`, `date_creation_etudiant`, `img_etudiant`, `mot_de_passe`) VALUES
	('ETU1', 'Holt', 'Hermanues', 'bicisay813@oniecan.com', '0672819270', '2023-03-27 01:11:50', 'images/userImage/92322.jpg', '$2y$10$2mzmHmq16z8jI1f9sHii6.VdcG2Jorw8hEk4tr/uqr9fSPkLBHxKG'),
	('ETU2', 'Aliquid', 'Perferendis', 'hiratiw409@djpich.com', '0656987459', '2023-03-29 00:21:55', 'images/default.jpg', '$2y$10$Npk0ZYE35r0Bv9Na9LllB.aUGs1.Cnw1Hh78xfyRmqFLPmTuC4AtS'),
	('ETU3', 'Sunt', 'Facere', 'golahav828@djpich.com', '0656987459', '2023-03-29 03:16:10', 'images/userImage/14848.jpg', '$2y$10$S6eg372X.wxgHpLHq7IAR.dGw6KrR4ETf4Rq96TvLolx7jSOevUBO'),
	('ETU4', 'Rerum', 'Tenetur', 'vigino1608@djpich.com', '0656987459', '2023-03-29 03:16:57', 'images/userImage/19260.jpg', '$2y$10$vvjTvK9kMQJBNz5OvWn6e.Xy/fpAnrNtJVet59HrGK7pdLf8B5iuu'),
	('ETU5', 'Cumque', 'Consequuntur', 'diretam167@cyclesat.com', '0659874365', '2023-03-29 03:18:17', 'images/userImage/32016.jpg', '$2y$10$0T8SO6ZaQCOV4gbgj5AqiO1udnpfcTirg0QLiooPhCJJ.1I/FLige');
/*!40000 ALTER TABLE `etudiants` ENABLE KEYS */;

-- Dumping structure for table maha.formateurs
CREATE TABLE IF NOT EXISTS `formateurs` (
  `id_formateur` varchar(255) NOT NULL,
  `nom_formateur` varchar(50) NOT NULL,
  `prenom_formateur` varchar(50) NOT NULL,
  `email_formateur` varchar(100) NOT NULL,
  `tel_formateur` varchar(15) DEFAULT NULL,
  `date_creation_formateur` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `img_formateur` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `paypalMail` varchar(250) NOT NULL,
  `biography` text NOT NULL,
  `balance` float NOT NULL DEFAULT '0',
  `specialiteId` int(11) NOT NULL,
  PRIMARY KEY (`id_formateur`),
  KEY `FK_formateurs_categories` (`specialiteId`),
  CONSTRAINT `FK_formateurs_categories` FOREIGN KEY (`specialiteId`) REFERENCES `categories` (`id_categorie`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.formateurs: ~5 rows (approximately)
/*!40000 ALTER TABLE `formateurs` DISABLE KEYS */;
INSERT INTO `formateurs` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `email_formateur`, `tel_formateur`, `date_creation_formateur`, `img_formateur`, `mot_de_passe`, `paypalMail`, `biography`, `balance`, `specialiteId`) VALUES
	('FOR1', 'John', 'Smith', 'nolepi2119@necktai.com', '0695038290', '2023-03-27 00:56:47', 'images/userImage/26611.jpg', '$2y$10$3wy.h8bMrjIy.kRvN5TyIeGEMkH.vnk307xSnHDWHAFANeS2sYdPC', 'vehenafit@mailinator.com', 'Tenetur qui quia exe Tenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exe', 138, 8),
	('FOR2', 'Mohcine', 'Likram', 'gaweda1412@dogemn.com', '0653147965', '2023-03-29 03:10:57', 'images/userImage/17429.jpg', '$2y$10$6DC9YjAy3opeYuc4mVBUbuoFdHpvbgHDdu2KvvCHF5SPsC5GuX/sG', 'heqo@mailinator.com', 'Nulla aut iste id om Nulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id om', 72, 4),
	('FOR3', 'Possimus', 'Sed', 'sitoga7418@dogemn.com', '0656987459', '2023-03-29 03:12:22', 'images/userImage/20268.jpg', '$2y$10$1rxvRyix3pgRGkSKq4s3aux7VGJcbjY2htQe5p.VVBR5Oq/ZpCYoG', 'sitoga7418@dogemn.com', 'Forget about spam, advertising mailings, hacking and attacking robots. Keep your real mailbox clean and secure. Temp Mail provides temporary, secure, anonymous, free, disposable email address.', 22.8, 8),
	('FOR4', 'Aspernatur ', 'Labore ', 'mopen22427@djpich.com', '0656987459', '2023-03-29 03:13:29', 'images/userImage/12984.jpg', '$2y$10$Ko0Qo07qAlfX3cG540XlmO13BwE/itm0Yw97omCnijH2zCk4Dup3a', 'mopen22427@djpich.com', 'Forget about spam, advertising mailings, hacking and attacking robots. Keep your real mailbox clean and secure. Temp Mail provides temporary, secure, anonymous, free, disposable email address.', 96, 10),
	('FOR5', 'Velit', 'Expedita ', 'japeva9885@cyclesat.com', '0653147965', '2023-03-29 03:14:44', 'images/userImage/13911.jpg', '$2y$10$NEA.INSJj7vH735t4bmamOzh4DiaVdVzytDsRyAy.LIEhQ4/gSC4i', 'japeva9885@cyclesat.com', 'Forget about spam, advertising mailings, hacking and attacking robots. Keep your real mailbox clean and secure. Temp Mail provides temporary, secure, anonymous, free, disposable email address.', 21, 7);
/*!40000 ALTER TABLE `formateurs` ENABLE KEYS */;

-- Dumping structure for table maha.formations
CREATE TABLE IF NOT EXISTS `formations` (
  `id_formation` int(11) NOT NULL AUTO_INCREMENT,
  `niveau_formation` int(11) NOT NULL,
  `id_formateur` varchar(255) NOT NULL,
  `categorie` int(11) NOT NULL,
  `nom_formation` varchar(100) NOT NULL,
  `image_formation` varchar(200) NOT NULL,
  `mass_horaire` time NOT NULL,
  `date_creation_formation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prix_formation` float(8,2) NOT NULL,
  `description` text NOT NULL,
  `id_langue` int(11) NOT NULL DEFAULT '1',
  `likes` int(11) DEFAULT '0',
  `fichier_attache` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_formation`),
  KEY `niveau_formation` (`niveau_formation`),
  KEY `categorie` (`categorie`),
  KEY `id_langue` (`id_langue`),
  KEY `FK_formations_formateurs` (`id_formateur`),
  CONSTRAINT `FK_formations_formateurs` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `formations_ibfk_1` FOREIGN KEY (`niveau_formation`) REFERENCES `niveaux` (`id_niveau`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `formations_ibfk_3` FOREIGN KEY (`categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `formations_ibfk_4` FOREIGN KEY (`id_langue`) REFERENCES `langues` (`id_langue`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.formations: ~11 rows (approximately)
/*!40000 ALTER TABLE `formations` DISABLE KEYS */;
INSERT INTO `formations` (`id_formation`, `niveau_formation`, `id_formateur`, `categorie`, `nom_formation`, `image_formation`, `mass_horaire`, `date_creation_formation`, `prix_formation`, `description`, `id_langue`, `likes`, `fichier_attache`) VALUES
	(1, 1, 'FOR1', 1, 'Sunt fugit velit ', 'images/formations/images/23419.jpg', '00:00:22', '2023-03-29 03:03:19', 65.00, 'Quae ipsum voluptat Quae ipsum voluptatQuae ipsum voluptatQuae ipsum voluptatQuae ipsum voluptatQuae ipsum voluptatQuae ipsum voluptatQuae ipsum voluptatQuae ipsum voluptat Per consequat adolescens ex, cu nibh commune temporibus vim, ad sumo viris\r\n                                    eloquentiam sed. Mea appareat omittantur eloquentiam ad, nam ei quas oportere\r\n                                    democritum. Prima causae admodum id est, ei timeam inimicus sed. Sit an meis\r\n                                    aliquam, cetero inermis vel ut. An sit illum euismod facilisis, tamquam vulputate\r\n                                    pertinacia eum at.', 3, 3, 'images/formations/files/27198_file.zip'),
	(2, 2, 'FOR1', 3, 'Ad in provident est', 'images/formations/images/62427.jpg', '00:00:11', '2023-03-29 03:03:34', 87.00, 'Fuga Perferendis il Fuga Perferendis ilFuga Perferendis ilFuga Perferendis ilFuga Perferendis il', 2, 1, NULL),
	(3, 2, 'FOR1', 5, 'Sed neque aliquid fu', 'images/formations/images/20322.jpg', '00:00:11', '2023-03-29 03:05:57', 56.00, ' Ex commodo voluptateEx commodo voluptateEx commodo voluptateEx commodo voluptateEx commodo voluptateEx commodo voluptateEx commodo voluptateEx commodo voluptateEx commodo voluptate', 4, 1, NULL),
	(4, 1, 'FOR2', 10, 'Voluptatum ut in mol', 'images/formations/images/32336.jpg', '00:00:11', '2023-03-29 03:19:38', 72.00, 'Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo ', 2, 1, NULL),
	(5, 3, 'FOR2', 5, 'Dolorem in et ullamc', 'images/formations/images/17069.jpg', '00:00:33', '2023-03-29 03:19:55', 24.00, 'Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev ', 1, 0, NULL),
	(6, 3, 'FOR3', 9, 'Qui ipsum amet asp', 'images/formations/images/99822.jpg', '00:00:11', '2023-03-29 03:21:47', 12.00, 'Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc ', 2, 1, NULL),
	(7, 1, 'FOR3', 1, 'Sint et et qui dolor', 'images/formations/images/54892.jpg', '00:00:11', '2023-03-29 03:22:03', 5.00, 'Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque ', 1, 0, NULL),
	(8, 1, 'FOR4', 2, 'Dolores quos nisi pl', 'images/formations/images/16798.jpg', '00:00:11', '2023-03-29 03:23:03', 86.00, 'Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet ', 2, 0, NULL),
	(9, 2, 'FOR4', 1, 'Molestiae aute paria', 'images/formations/images/22679.jpg', '00:00:11', '2023-03-29 03:23:20', 96.00, 'Optio amet et ab o Optio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab o', 4, 1, NULL),
	(10, 2, 'FOR5', 12, 'Magnam et labore hic', 'images/formations/images/30011.jpg', '00:00:11', '2023-03-29 03:24:24', 21.00, 'Nihil aspernatur und Nihil aspernatur und Nihil aspernatur und Nihil aspernatur und Nihil aspernatur und Nihil aspernatur und Nihil aspernatur und Nihil aspernatur und ', 3, 1, NULL),
	(11, 3, 'FOR5', 11, 'Porro earum pariatur', 'images/formations/images/27600.jpg', '00:00:11', '2023-03-29 03:24:36', 14.00, 'Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do ', 4, 0, NULL);
/*!40000 ALTER TABLE `formations` ENABLE KEYS */;

-- Dumping structure for table maha.inscriptions
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id_inscription` int(11) NOT NULL AUTO_INCREMENT,
  `id_formation` int(11) NOT NULL,
  `id_etudiant` varchar(255) NOT NULL,
  `id_formateur` varchar(255) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prix` float NOT NULL,
  `transaction_info` json NOT NULL,
  `payment_id` varchar(100) NOT NULL,
  `payment_state` varchar(50) NOT NULL,
  `approval_url` varchar(200) NOT NULL,
  PRIMARY KEY (`id_inscription`),
  KEY `id_formation` (`id_formation`),
  KEY `FK_inscriptions_formateurs` (`id_formateur`),
  KEY `FK_inscriptions_etudiants` (`id_etudiant`),
  CONSTRAINT `FK_inscriptions_etudiants` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_inscriptions_formateurs` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `inscriptions_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.inscriptions: ~9 rows (approximately)
/*!40000 ALTER TABLE `inscriptions` DISABLE KEYS */;
INSERT INTO `inscriptions` (`id_inscription`, `id_formation`, `id_etudiant`, `id_formateur`, `date_inscription`, `prix`, `transaction_info`, `payment_id`, `payment_state`, `approval_url`) VALUES
	(1, 1, 'ETU1', 'FOR1', '2023-03-29 03:33:10', 65, '{"id": "PAYID-MQR3C5Q4009369763573034U", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3C5Q4009369763573034U", "method": "GET"}, {"rel": "approval_url", "href": "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-19A56657UW632534E", "method": "REDIRECT"}, {"rel": "execute", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3C5Q4009369763573034U/execute", "method": "POST"}], "payer": {"payment_method": "paypal"}, "state": "created", "intent": "sale", "create_time": "2023-03-29T03:33:10Z", "transactions": [{"amount": {"total": "65.00", "details": {"tax": "0.00", "shipping": "0.00", "subtotal": "65.00", "insurance": "0.00", "handling_fee": "0.00", "shipping_discount": "0.00"}, "currency": "USD"}, "item_list": {"items": [{"sku": "1", "tax": "0.00", "name": "Sunt fugit velit ", "price": "65.00", "currency": "USD", "quantity": 1, "description": "Online Course"}]}, "description": "Sunt fugit velit ", "payment_options": {"skip_fmf": false, "recurring_flag": false, "allowed_payment_method": "INSTANT_FUNDING_SOURCE"}, "related_resources": []}], "note_to_payer": "Contact us for any questions on your order."}', 'PAYID-MQR3C5Q4009369763573034U', 'approved', 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-19A56657UW632534E'),
	(2, 2, 'ETU1', 'FOR1', '2023-03-29 03:34:51', 87, '{"id": "PAYID-MQR3DWY46170238EE497154F", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3DWY46170238EE497154F", "method": "GET"}, {"rel": "approval_url", "href": "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-2W334148DC8298546", "method": "REDIRECT"}, {"rel": "execute", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3DWY46170238EE497154F/execute", "method": "POST"}], "payer": {"payment_method": "paypal"}, "state": "created", "intent": "sale", "create_time": "2023-03-29T03:34:51Z", "transactions": [{"amount": {"total": "87.00", "details": {"tax": "0.00", "shipping": "0.00", "subtotal": "87.00", "insurance": "0.00", "handling_fee": "0.00", "shipping_discount": "0.00"}, "currency": "USD"}, "item_list": {"items": [{"sku": "1", "tax": "0.00", "name": "Ad in provident est", "price": "87.00", "currency": "USD", "quantity": 1, "description": "Online Course"}]}, "description": "Ad in provident est", "payment_options": {"skip_fmf": false, "recurring_flag": false, "allowed_payment_method": "INSTANT_FUNDING_SOURCE"}, "related_resources": []}], "note_to_payer": "Contact us for any questions on your order."}', 'PAYID-MQR3DWY46170238EE497154F', 'approved', 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-2W334148DC8298546'),
	(3, 4, 'ETU2', 'FOR2', '2023-03-29 03:37:02', 72, '{"id": "PAYID-MQR3EXQ9V0306729U340153B", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3EXQ9V0306729U340153B", "method": "GET"}, {"rel": "approval_url", "href": "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-1WB7831178862452S", "method": "REDIRECT"}, {"rel": "execute", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3EXQ9V0306729U340153B/execute", "method": "POST"}], "payer": {"payment_method": "paypal"}, "state": "created", "intent": "sale", "create_time": "2023-03-29T03:37:02Z", "transactions": [{"amount": {"total": "72.00", "details": {"tax": "0.00", "shipping": "0.00", "subtotal": "72.00", "insurance": "0.00", "handling_fee": "0.00", "shipping_discount": "0.00"}, "currency": "USD"}, "item_list": {"items": [{"sku": "1", "tax": "0.00", "name": "Voluptatum ut in mol", "price": "72.00", "currency": "USD", "quantity": 1, "description": "Online Course"}]}, "description": "Voluptatum ut in mol", "payment_options": {"skip_fmf": false, "recurring_flag": false, "allowed_payment_method": "INSTANT_FUNDING_SOURCE"}, "related_resources": []}], "note_to_payer": "Contact us for any questions on your order."}', 'PAYID-MQR3EXQ9V0306729U340153B', 'approved', 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-1WB7831178862452S'),
	(4, 1, 'ETU3', 'FOR1', '2023-03-29 03:45:52', 65, '{"id": "PAYID-MQR3I4I0FP51207856595415", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3I4I0FP51207856595415", "method": "GET"}, {"rel": "approval_url", "href": "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-68K95755BJ235334G", "method": "REDIRECT"}, {"rel": "execute", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3I4I0FP51207856595415/execute", "method": "POST"}], "payer": {"payment_method": "paypal"}, "state": "created", "intent": "sale", "create_time": "2023-03-29T03:45:52Z", "transactions": [{"amount": {"total": "65.00", "details": {"tax": "0.00", "shipping": "0.00", "subtotal": "65.00", "insurance": "0.00", "handling_fee": "0.00", "shipping_discount": "0.00"}, "currency": "USD"}, "item_list": {"items": [{"sku": "1", "tax": "0.00", "name": "Sunt fugit velit ", "price": "65.00", "currency": "USD", "quantity": 1, "description": "Online Course"}]}, "description": "Sunt fugit velit ", "payment_options": {"skip_fmf": false, "recurring_flag": false, "allowed_payment_method": "INSTANT_FUNDING_SOURCE"}, "related_resources": []}], "note_to_payer": "Contact us for any questions on your order."}', 'PAYID-MQR3I4I0FP51207856595415', 'approved', 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-68K95755BJ235334G'),
	(5, 9, 'ETU3', 'FOR4', '2023-03-29 03:46:35', 96, '{"id": "PAYID-MQR3JHA3V687027FF495983Y", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3JHA3V687027FF495983Y", "method": "GET"}, {"rel": "approval_url", "href": "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-3CJ64057AJ770161M", "method": "REDIRECT"}, {"rel": "execute", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3JHA3V687027FF495983Y/execute", "method": "POST"}], "payer": {"payment_method": "paypal"}, "state": "created", "intent": "sale", "create_time": "2023-03-29T03:46:35Z", "transactions": [{"amount": {"total": "96.00", "details": {"tax": "0.00", "shipping": "0.00", "subtotal": "96.00", "insurance": "0.00", "handling_fee": "0.00", "shipping_discount": "0.00"}, "currency": "USD"}, "item_list": {"items": [{"sku": "1", "tax": "0.00", "name": "Molestiae aute paria", "price": "96.00", "currency": "USD", "quantity": 1, "description": "Online Course"}]}, "description": "Molestiae aute paria", "payment_options": {"skip_fmf": false, "recurring_flag": false, "allowed_payment_method": "INSTANT_FUNDING_SOURCE"}, "related_resources": []}], "note_to_payer": "Contact us for any questions on your order."}', 'PAYID-MQR3JHA3V687027FF495983Y', 'approved', 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-3CJ64057AJ770161M'),
	(6, 1, 'ETU4', 'FOR1', '2023-03-29 03:47:57', 65, '{"id": "PAYID-MQR3J3I2B150527966155319", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3J3I2B150527966155319", "method": "GET"}, {"rel": "approval_url", "href": "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-01W13016M7735071D", "method": "REDIRECT"}, {"rel": "execute", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3J3I2B150527966155319/execute", "method": "POST"}], "payer": {"payment_method": "paypal"}, "state": "created", "intent": "sale", "create_time": "2023-03-29T03:47:57Z", "transactions": [{"amount": {"total": "65.00", "details": {"tax": "0.00", "shipping": "0.00", "subtotal": "65.00", "insurance": "0.00", "handling_fee": "0.00", "shipping_discount": "0.00"}, "currency": "USD"}, "item_list": {"items": [{"sku": "1", "tax": "0.00", "name": "Sunt fugit velit ", "price": "65.00", "currency": "USD", "quantity": 1, "description": "Online Course"}]}, "description": "Sunt fugit velit ", "payment_options": {"skip_fmf": false, "recurring_flag": false, "allowed_payment_method": "INSTANT_FUNDING_SOURCE"}, "related_resources": []}], "note_to_payer": "Contact us for any questions on your order."}', 'PAYID-MQR3J3I2B150527966155319', 'approved', 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-01W13016M7735071D'),
	(7, 10, 'ETU4', 'FOR5', '2023-03-29 03:49:21', 21, '{"id": "PAYID-MQR3KQI4RS359312T555062F", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3KQI4RS359312T555062F", "method": "GET"}, {"rel": "approval_url", "href": "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-62R612756D381201S", "method": "REDIRECT"}, {"rel": "execute", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3KQI4RS359312T555062F/execute", "method": "POST"}], "payer": {"payment_method": "paypal"}, "state": "created", "intent": "sale", "create_time": "2023-03-29T03:49:21Z", "transactions": [{"amount": {"total": "21.00", "details": {"tax": "0.00", "shipping": "0.00", "subtotal": "21.00", "insurance": "0.00", "handling_fee": "0.00", "shipping_discount": "0.00"}, "currency": "USD"}, "item_list": {"items": [{"sku": "1", "tax": "0.00", "name": "Magnam et labore hic", "price": "21.00", "currency": "USD", "quantity": 1, "description": "Online Course"}]}, "description": "Magnam et labore hic", "payment_options": {"skip_fmf": false, "recurring_flag": false, "allowed_payment_method": "INSTANT_FUNDING_SOURCE"}, "related_resources": []}], "note_to_payer": "Contact us for any questions on your order."}', 'PAYID-MQR3KQI4RS359312T555062F', 'approved', 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-62R612756D381201S'),
	(8, 6, 'ETU5', 'FOR3', '2023-03-29 03:50:28', 12, '{"id": "PAYID-MQR3LBA6W200349GC655382D", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3LBA6W200349GC655382D", "method": "GET"}, {"rel": "approval_url", "href": "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-4BU36476YF380601V", "method": "REDIRECT"}, {"rel": "execute", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3LBA6W200349GC655382D/execute", "method": "POST"}], "payer": {"payment_method": "paypal"}, "state": "created", "intent": "sale", "create_time": "2023-03-29T03:50:28Z", "transactions": [{"amount": {"total": "12.00", "details": {"tax": "0.00", "shipping": "0.00", "subtotal": "12.00", "insurance": "0.00", "handling_fee": "0.00", "shipping_discount": "0.00"}, "currency": "USD"}, "item_list": {"items": [{"sku": "1", "tax": "0.00", "name": "Qui ipsum amet asp", "price": "12.00", "currency": "USD", "quantity": 1, "description": "Online Course"}]}, "description": "Qui ipsum amet asp", "payment_options": {"skip_fmf": false, "recurring_flag": false, "allowed_payment_method": "INSTANT_FUNDING_SOURCE"}, "related_resources": []}], "note_to_payer": "Contact us for any questions on your order."}', 'PAYID-MQR3LBA6W200349GC655382D', 'approved', 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-4BU36476YF380601V'),
	(9, 3, 'ETU5', 'FOR1', '2023-03-29 03:51:00', 56, '{"id": "PAYID-MQR3LJA62C25861N8425413H", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3LJA62C25861N8425413H", "method": "GET"}, {"rel": "approval_url", "href": "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-65W01276CP343520E", "method": "REDIRECT"}, {"rel": "execute", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MQR3LJA62C25861N8425413H/execute", "method": "POST"}], "payer": {"payment_method": "paypal"}, "state": "created", "intent": "sale", "create_time": "2023-03-29T03:51:00Z", "transactions": [{"amount": {"total": "56.00", "details": {"tax": "0.00", "shipping": "0.00", "subtotal": "56.00", "insurance": "0.00", "handling_fee": "0.00", "shipping_discount": "0.00"}, "currency": "USD"}, "item_list": {"items": [{"sku": "1", "tax": "0.00", "name": "Sed neque aliquid fu", "price": "56.00", "currency": "USD", "quantity": 1, "description": "Online Course"}]}, "description": "Sed neque aliquid fu", "payment_options": {"skip_fmf": false, "recurring_flag": false, "allowed_payment_method": "INSTANT_FUNDING_SOURCE"}, "related_resources": []}], "note_to_payer": "Contact us for any questions on your order."}', 'PAYID-MQR3LJA62C25861N8425413H', 'approved', 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-65W01276CP343520E'),
	(10, 6, 'ETU1', 'FOR3', '2023-06-01 22:23:28', 12, '{"id": "PAYID-MR4RUYA7LD46919FP297371C", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MR4RUYA7LD46919FP297371C", "method": "GET"}, {"rel": "approval_url", "href": "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-5EF68149LM586323V", "method": "REDIRECT"}, {"rel": "execute", "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MR4RUYA7LD46919FP297371C/execute", "method": "POST"}], "payer": {"payment_method": "paypal"}, "state": "created", "intent": "sale", "create_time": "2023-06-01T22:23:28Z", "transactions": [{"amount": {"total": "12.00", "details": {"tax": "0.00", "shipping": "0.00", "subtotal": "12.00", "insurance": "0.00", "handling_fee": "0.00", "shipping_discount": "0.00"}, "currency": "USD"}, "item_list": {"items": [{"sku": "1", "tax": "0.00", "name": "Qui ipsum amet asp", "price": "12.00", "currency": "USD", "quantity": 1, "description": "Online Course"}]}, "description": "Qui ipsum amet asp", "payment_options": {"skip_fmf": false, "recurring_flag": false, "allowed_payment_method": "INSTANT_FUNDING_SOURCE"}, "related_resources": []}], "note_to_payer": "Contact us for any questions on your order."}', 'PAYID-MR4RUYA7LD46919FP297371C', 'approved', 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-5EF68149LM586323V');
/*!40000 ALTER TABLE `inscriptions` ENABLE KEYS */;

-- Dumping structure for procedure maha.insertItoTableFilterAll
DELIMITER //
CREATE PROCEDURE `insertItoTableFilterAll`(nb int)
begin 
  declare i int default 1;
    declare IdFormation, idCategore, likes, IdFormteur, specialiteId, numbAcht, idLangage, idNiv int default 0;
    declare prix float default 0;
    declare imgFormation, categorie, nomFormation, nomFormateur, prenomFormateur, specialite, imgFormateur, langageFormation , niveauFormation varchar(300) default '';
    declare description text default '';
    declare dateCreationFormation date;
    declare duree time;
    declare cur cursor for (select formations.id_formation as 'IdFormation',
                                    formations.image_formation as 'imgFormation',
                                    formations.mass_horaire as 'duree',
                                formations.categorie as 'idCategore',
                                    categories.nom_categorie as 'categorie',
                                    formations.nom_formation as 'nomFormation',
                                    formations.prix_formation as 'prix',
                                    formations.description as 'description',
                                    formations.likes as 'likes',
                                    formateurs.id_formateur as 'IdFormteur',
                                    formateurs.nom_formateur as 'nomFormateur',
                                    formateurs.prenom_formateur as 'prenomFormateur',
                                    formateurs.specialiteId as 'specialiteId',
                                    formateurs.img_formateur as 'imgFormateur',
                                    date(formations.date_creation_formation) as 'dateCreationFormation',
                                    formations.id_langue as 'idLangageFormation',
                                    formations.niveau_formation as 'idNiv'
                    from formations, formateurs,categories
                    where formations.id_formateur = formateurs.id_formateur
                    and categories.id_categorie = formations.categorie
    );
  open cur;
      while (i<=nb) do 
          fetch cur into IdFormation, imgFormation, duree, idCategore, categorie, nomFormation, prix, description, likes, IdFormteur, nomFormateur, prenomFormateur, specialiteId, imgFormateur, dateCreationFormation, idLangage, idNiv;
            
            set specialite = (select categories.nom_categorie from categories where categories.id_categorie = specialiteId);
            set langageFormation = (select langues.nom_langue from langues where langues.id_langue = idLangage);
            set niveauFormation = (select niveaux.nom_niveau from niveaux where niveaux.id_niveau = idNiv);
            set numbAcht = (select count(*) from inscriptions where inscriptions.id_formation = IdFormation and inscriptions.id_formateur = IdFormteur);
           
            INSERT INTO `tablefilter`(`IdFormation`, `imgFormation`, `duree`, `idCategore`, `categorie`, `nomFormation`, `prix`, `description`, `likes`, `IdFormteur`, `nomFormateur`, `prenomFormateur`, `specialiteId`, `specialite`, `imgFormateur`, `numbAcht`, `dateCreationFormation`, `idLangage`, `langageFormation`, `idNiv`, `niveauFormation`) 
            VALUES (IdFormation, imgFormation, duree, idCategore, categorie, nomFormation, prix, description, likes, IdFormteur, nomFormateur, prenomFormateur, specialiteId, specialite, imgFormateur, numbAcht, dateCreationFormation, idLangage, langageFormation, idNiv, niveauFormation);
        set i = i+1;
        end while;
    close cur;
end//
DELIMITER ;

-- Dumping structure for procedure maha.insertItoTableFilterFilter
DELIMITER //
CREATE PROCEDURE `insertItoTableFilterFilter`(nb int, arg1  varchar(200), arg2 varchar(200))
begin 
  declare i int default 1;
    declare IdFormation, idCategore, likes, IdFormteur, specialiteId, numbAcht, idLangage, idNiv int default 0;
    declare prix float default 0;
    declare imgFormation, categorie, nomFormation, nomFormateur, prenomFormateur, specialite, imgFormateur, langageFormation , niveauFormation varchar(300) default '';
    declare description text default '';
    declare dateCreationFormation date;
    declare duree time;
    declare cur cursor for (select formations.id_formation as 'IdFormation',
                                    formations.image_formation as 'imgFormation',
                                    formations.mass_horaire as 'duree',
                                formations.categorie as 'idCategore',
                                    categories.nom_categorie as 'categorie',
                                    formations.nom_formation as 'nomFormation',
                                    formations.prix_formation as 'prix',
                                    formations.description as 'description',
                                    formations.likes as 'likes',
                                    formateurs.id_formateur as 'IdFormteur',
                                    formateurs.nom_formateur as 'nomFormateur',
                                    formateurs.prenom_formateur as 'prenomFormateur',
                                    formateurs.specialiteId as 'specialiteId',
                                    formateurs.img_formateur as 'imgFormateur',
                                    date(formations.date_creation_formation) as 'dateCreationFormation',
                                    formations.id_langue as 'idLangageFormation',
                                    formations.niveau_formation as 'idNiv'
                    from formations, formateurs,categories
                    where formations.id_formateur = formateurs.id_formateur
                    and categories.id_categorie = formations.categorie
                    and categories.nom_categorie = arg1
                    and (
                    formations.nom_formation like concat('%',arg2,'%') 
                      or formations.description like concat('%',arg2,'%')
                  )
    );
  open cur;
      while (i<=nb) do 
          fetch cur into IdFormation, imgFormation, duree, idCategore, categorie, nomFormation, prix, description, likes, IdFormteur, nomFormateur, prenomFormateur, specialiteId, imgFormateur, dateCreationFormation, idLangage, idNiv;
            
            set specialite = (select categories.nom_categorie from categories where categories.id_categorie = specialiteId);
            set langageFormation = (select langues.nom_langue from langues where langues.id_langue = idLangage);
            set niveauFormation = (select niveaux.nom_niveau from niveaux where niveaux.id_niveau = idNiv);
            set numbAcht = (select count(*) from inscriptions where inscriptions.id_formation = IdFormation and inscriptions.id_formateur = IdFormteur);
            
            INSERT INTO `tablefilter`(`IdFormation`, `imgFormation`, `duree`, `idCategore`, `categorie`, `nomFormation`,              `prix`, `description`, `likes`, `IdFormteur`, `nomFormateur`, `prenomFormateur`, `specialiteId`,              `specialite`, `imgFormateur`, `numbAcht`, `dateCreationFormation`, `idLangage`, `langageFormation`, `idNiv`, `niveauFormation`) 
            VALUES (IdFormation, imgFormation, duree, idCategore, categorie, nomFormation, prix, description, likes, IdFormteur, nomFormateur, prenomFormateur, specialiteId, specialite, imgFormateur, numbAcht, dateCreationFormation, idLangage, langageFormation, idNiv, niveauFormation);
        set i = i+1;
        end while;
    close cur;
end//
DELIMITER ;

-- Dumping structure for procedure maha.insertItoTableFilterRech
DELIMITER //
CREATE PROCEDURE `insertItoTableFilterRech`(nb int, arg varchar(200))
begin 
  declare i int default 1;
    declare IdFormation, idCategore, likes, IdFormteur, specialiteId, numbAcht, idLangage, idNiv int default 0;
    declare prix float default 0;
    declare imgFormation, categorie, nomFormation, nomFormateur, prenomFormateur, specialite, imgFormateur, langageFormation , niveauFormation varchar(300) default '';
    declare description text default '';
    declare dateCreationFormation date;
    declare duree time;
    declare cur cursor for (select formations.id_formation as 'IdFormation',
                                    formations.image_formation as 'imgFormation',
                                    formations.mass_horaire as 'duree',
                                formations.categorie as 'idCategore',
                                    categories.nom_categorie as 'categorie',
                                    formations.nom_formation as 'nomFormation',
                                    formations.prix_formation as 'prix',
                                    formations.description as 'description',
                                    formations.likes as 'likes',
                                    formateurs.id_formateur as 'IdFormteur',
                                    formateurs.nom_formateur as 'nomFormateur',
                                    formateurs.prenom_formateur as 'prenomFormateur',
                                    formateurs.specialiteId as 'specialiteId',
                                    formateurs.img_formateur as 'imgFormateur',
                                    date(formations.date_creation_formation) as 'dateCreationFormation',
                                    formations.id_langue as 'idLangageFormation',
                                    formations.niveau_formation as 'idNiv'
                    from formations, formateurs,categories
                    where formations.id_formateur = formateurs.id_formateur
                    and categories.id_categorie = formations.categorie
                    and (
                      categories.nom_categorie like concat('%',arg,'%')
                      or formateurs.nom_formateur like concat('%',arg,'%')
                      or formations.description like concat('%',arg,'%')
                      or formations.nom_formation like concat('%',arg,'%')
                      or formateurs.prenom_formateur like concat('%',arg,'%')
                  )
    );
  open cur;
      while (i<=nb) do 
          fetch cur into IdFormation, imgFormation, duree, idCategore, categorie, nomFormation, prix, description, likes, IdFormteur, nomFormateur, prenomFormateur, specialiteId, imgFormateur, dateCreationFormation, idLangage, idNiv;
            
            set specialite = (select categories.nom_categorie from categories where categories.id_categorie = specialiteId);
            set langageFormation = (select langues.nom_langue from langues where langues.id_langue = idLangage);
            set niveauFormation = (select niveaux.nom_niveau from niveaux where niveaux.id_niveau = idNiv);
            set numbAcht = (select count(*) from inscriptions where inscriptions.id_formation = IdFormation and inscriptions.id_formateur = IdFormteur);
            
            INSERT INTO `tablefilter`(`IdFormation`, `imgFormation`, `duree`, `idCategore`, `categorie`, `nomFormation`,              `prix`, `description`, `likes`, `IdFormteur`, `nomFormateur`, `prenomFormateur`, `specialiteId`,              `specialite`, `imgFormateur`, `numbAcht`, `dateCreationFormation`, `idLangage`, `langageFormation`, `idNiv`, `niveauFormation`) 
            VALUES (IdFormation, imgFormation, duree, idCategore, categorie, nomFormation, prix, description, likes, IdFormteur, nomFormateur, prenomFormateur, specialiteId, specialite, imgFormateur, numbAcht, dateCreationFormation, idLangage, langageFormation, idNiv, niveauFormation);
        set i = i+1;
        end while;
    close cur;
end//
DELIMITER ;

-- Dumping structure for table maha.langues
CREATE TABLE IF NOT EXISTS `langues` (
  `id_langue` int(11) NOT NULL AUTO_INCREMENT,
  `nom_langue` varchar(30) NOT NULL,
  PRIMARY KEY (`id_langue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.langues: ~4 rows (approximately)
/*!40000 ALTER TABLE `langues` DISABLE KEYS */;
INSERT INTO `langues` (`id_langue`, `nom_langue`) VALUES
	(1, 'Français'),
	(2, 'Anglais'),
	(3, 'Espagnol'),
	(4, 'العربية');
/*!40000 ALTER TABLE `langues` ENABLE KEYS */;

-- Dumping structure for table maha.likes
CREATE TABLE IF NOT EXISTS `likes` (
  `etudiant_id` varchar(255) NOT NULL,
  `formation_id` int(11) NOT NULL,
  KEY `fkLikes2` (`formation_id`),
  KEY `FK_likes_etudiants` (`etudiant_id`),
  CONSTRAINT `FK_likes_etudiants` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fkLikes2` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id_formation`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.likes: ~9 rows (approximately)
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` (`etudiant_id`, `formation_id`) VALUES
	('ETU1', 1),
	('ETU1', 2),
	('ETU2', 4),
	('ETU3', 1),
	('ETU3', 9),
	('ETU4', 1),
	('ETU4', 10),
	('ETU5', 3),
	('ETU5', 6);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;

-- Dumping structure for table maha.niveaux
CREATE TABLE IF NOT EXISTS `niveaux` (
  `id_niveau` int(11) NOT NULL,
  `nom_niveau` varchar(50) NOT NULL,
  PRIMARY KEY (`id_niveau`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.niveaux: ~3 rows (approximately)
/*!40000 ALTER TABLE `niveaux` DISABLE KEYS */;
INSERT INTO `niveaux` (`id_niveau`, `nom_niveau`) VALUES
	(1, 'Débutant'),
	(2, 'Intermédiaire'),
	(3, 'Avancé');
/*!40000 ALTER TABLE `niveaux` ENABLE KEYS */;

-- Dumping structure for table maha.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id_notification` int(11) NOT NULL AUTO_INCREMENT,
  `id_commentaire` int(11) NOT NULL,
  `etat_notification` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_notification`),
  KEY `FK_notifications_commentaires` (`id_commentaire`),
  CONSTRAINT `FK_notifications_commentaires` FOREIGN KEY (`id_commentaire`) REFERENCES `commentaires` (`id_commentaire`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.notifications: ~10 rows (approximately)
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` (`id_notification`, `id_commentaire`, `etat_notification`) VALUES
	(1, 1, 1),
	(2, 2, 1),
	(3, 3, 1),
	(5, 1, 1),
	(6, 2, 1),
	(7, 3, 1),
	(8, 4, 1),
	(9, 5, 1),
	(10, 6, 1),
	(11, 7, 1),
	(12, 8, 0),
	(13, 9, 1);
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;

-- Dumping structure for table maha.previews
CREATE TABLE IF NOT EXISTS `previews` (
  `id_formation` int(11) NOT NULL,
  `id_video` int(11) NOT NULL,
  UNIQUE KEY `id_formation` (`id_formation`) USING BTREE,
  UNIQUE KEY `id_video` (`id_video`) USING BTREE,
  CONSTRAINT `previews_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`) ON DELETE CASCADE,
  CONSTRAINT `previews_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.previews: ~0 rows (approximately)
/*!40000 ALTER TABLE `previews` DISABLE KEYS */;
INSERT INTO `previews` (`id_formation`, `id_video`) VALUES
	(1, 1);
/*!40000 ALTER TABLE `previews` ENABLE KEYS */;

-- Dumping structure for table maha.request_payment
CREATE TABLE IF NOT EXISTS `request_payment` (
  `id_payment` int(11) NOT NULL AUTO_INCREMENT,
  `id_formateur` varchar(255) NOT NULL,
  `request_prix` float NOT NULL,
  `date_request` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `etat_request` varchar(10) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id_payment`),
  KEY `FK_request_payment_formateurs` (`id_formateur`),
  CONSTRAINT `FK_request_payment_formateurs` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.request_payment: ~0 rows (approximately)
/*!40000 ALTER TABLE `request_payment` DISABLE KEYS */;
INSERT INTO `request_payment` (`id_payment`, `id_formateur`, `request_prix`, `date_request`, `etat_request`) VALUES
	(2, 'FOR1', 200, '2023-03-29 03:53:51', 'accepted');
/*!40000 ALTER TABLE `request_payment` ENABLE KEYS */;

-- Dumping structure for table maha.smtp
CREATE TABLE IF NOT EXISTS `smtp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `port` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.smtp: ~0 rows (approximately)
/*!40000 ALTER TABLE `smtp` DISABLE KEYS */;
INSERT INTO `smtp` (`id`, `host`, `username`, `password`, `port`) VALUES
	(1, 'smtp.gmail.com', 'mahateamisgi@gmail.com', 'nlazavosyxsxztqf', '465');
/*!40000 ALTER TABLE `smtp` ENABLE KEYS */;

-- Dumping structure for table maha.tablefilter
CREATE TABLE IF NOT EXISTS `tablefilter` (
  `IdFormation` int(11) DEFAULT NULL,
  `imgFormation` varchar(200) DEFAULT NULL,
  `duree` time DEFAULT NULL,
  `idCategore` int(11) DEFAULT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `nomFormation` varchar(100) DEFAULT NULL,
  `prix` float DEFAULT NULL,
  `description` text,
  `likes` int(11) DEFAULT NULL,
  `IdFormteur` int(11) DEFAULT NULL,
  `nomFormateur` varchar(50) DEFAULT NULL,
  `prenomFormateur` varchar(50) DEFAULT NULL,
  `specialiteId` int(11) DEFAULT NULL,
  `specialite` varchar(50) DEFAULT NULL,
  `imgFormateur` varchar(200) DEFAULT NULL,
  `numbAcht` int(11) DEFAULT NULL,
  `dateCreationFormation` date DEFAULT NULL,
  `idLangage` int(11) DEFAULT NULL,
  `langageFormation` varchar(50) DEFAULT NULL,
  `idNiv` int(11) DEFAULT NULL,
  `niveauFormation` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.tablefilter: ~11 rows (approximately)
/*!40000 ALTER TABLE `tablefilter` DISABLE KEYS */;
INSERT INTO `tablefilter` (`IdFormation`, `imgFormation`, `duree`, `idCategore`, `categorie`, `nomFormation`, `prix`, `description`, `likes`, `IdFormteur`, `nomFormateur`, `prenomFormateur`, `specialiteId`, `specialite`, `imgFormateur`, `numbAcht`, `dateCreationFormation`, `idLangage`, `langageFormation`, `idNiv`, `niveauFormation`) VALUES
	(1, 'images/formations/images/23419.jpg', '00:00:22', 1, '3D', 'Sunt fugit velit ', 65, 'Quae ipsum voluptat Quae ipsum voluptatQuae ipsum voluptatQuae ipsum voluptatQuae ipsum voluptatQuae ipsum voluptatQuae ipsum voluptatQuae ipsum voluptatQuae ipsum voluptat Per consequat adolescens ex, cu nibh commune temporibus vim, ad sumo viris\r\n                                    eloquentiam sed. Mea appareat omittantur eloquentiam ad, nam ei quas oportere\r\n                                    democritum. Prima causae admodum id est, ei timeam inimicus sed. Sit an meis\r\n                                    aliquam, cetero inermis vel ut. An sit illum euismod facilisis, tamquam vulputate\r\n                                    pertinacia eum at.', 3, 0, 'John', 'Smith', 8, 'Vidéo-Compositing', 'images/userImage/26611.jpg', 3, '2023-03-29', 3, 'Espagnol', 1, 'Débutant'),
	(2, 'images/formations/images/62427.jpg', '00:00:11', 3, 'Audio-MAO', 'Ad in provident est', 87, 'Fuga Perferendis il Fuga Perferendis ilFuga Perferendis ilFuga Perferendis ilFuga Perferendis il', 1, 0, 'John', 'Smith', 8, 'Vidéo-Compositing', 'images/userImage/26611.jpg', 1, '2023-03-29', 2, 'Anglais', 2, 'Intermédiaire'),
	(3, 'images/formations/images/20322.jpg', '00:00:11', 5, 'Code', 'Sed neque aliquid fu', 56, ' Ex commodo voluptateEx commodo voluptateEx commodo voluptateEx commodo voluptateEx commodo voluptateEx commodo voluptateEx commodo voluptateEx commodo voluptateEx commodo voluptate', 1, 0, 'John', 'Smith', 8, 'Vidéo-Compositing', 'images/userImage/26611.jpg', 1, '2023-03-29', 4, 'العربية', 2, 'Intermédiaire'),
	(4, 'images/formations/images/32336.jpg', '00:00:11', 10, 'Réseaux informatique', 'Voluptatum ut in mol', 72, 'Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo Est repudiandae dolo ', 1, 0, 'Mohcine', 'Likram', 4, 'Business & Efficacité professionnelle', 'images/userImage/17429.jpg', 1, '2023-03-29', 2, 'Anglais', 1, 'Débutant'),
	(5, 'images/formations/images/17069.jpg', '00:00:33', 5, 'Code', 'Dolorem in et ullamc', 24, 'Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev Dolore consequat Ev ', 0, 0, 'Mohcine', 'Likram', 4, 'Business & Efficacité professionnelle', 'images/userImage/17429.jpg', 0, '2023-03-29', 1, 'Français', 3, 'Avancé'),
	(6, 'images/formations/images/99822.jpg', '00:00:11', 9, 'Webmarketing', 'Qui ipsum amet asp', 12, 'Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc Consequatur distinc ', 1, 0, 'Possimus', 'Sed', 8, 'Vidéo-Compositing', 'images/userImage/20268.jpg', 1, '2023-03-29', 2, 'Anglais', 3, 'Avancé'),
	(7, 'images/formations/images/54892.jpg', '00:00:11', 1, '3D', 'Sint et et qui dolor', 5, 'Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque Molestiae doloremque ', 0, 0, 'Possimus', 'Sed', 8, 'Vidéo-Compositing', 'images/userImage/20268.jpg', 0, '2023-03-29', 1, 'Français', 1, 'Débutant'),
	(8, 'images/formations/images/16798.jpg', '00:00:11', 2, 'Architecture & BIM', 'Dolores quos nisi pl', 86, 'Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet earum et ve Eveniet ', 0, 0, 'Aspernatur ', 'Labore ', 10, 'Réseaux informatique', 'images/userImage/12984.jpg', 0, '2023-03-29', 2, 'Anglais', 1, 'Débutant'),
	(9, 'images/formations/images/22679.jpg', '00:00:11', 1, '3D', 'Molestiae aute paria', 96, 'Optio amet et ab o Optio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab oOptio amet et ab o', 1, 0, 'Aspernatur ', 'Labore ', 10, 'Réseaux informatique', 'images/userImage/12984.jpg', 1, '2023-03-29', 4, 'العربية', 2, 'Intermédiaire'),
	(10, 'images/formations/images/30011.jpg', '00:00:11', 12, 'Bureautique', 'Magnam et labore hic', 21, 'Nihil aspernatur und Nihil aspernatur und Nihil aspernatur und Nihil aspernatur und Nihil aspernatur und Nihil aspernatur und Nihil aspernatur und Nihil aspernatur und ', 1, 0, 'Velit', 'Expedita ', 7, 'Photographie', 'images/userImage/13911.jpg', 1, '2023-03-29', 3, 'Espagnol', 2, 'Intermédiaire'),
	(11, 'images/formations/images/27600.jpg', '00:00:11', 11, 'Management', 'Porro earum pariatur', 14, 'Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do Ducimus suscipit do ', 0, 0, 'Velit', 'Expedita ', 7, 'Photographie', 'images/userImage/13911.jpg', 0, '2023-03-29', 4, 'العربية', 3, 'Avancé');
/*!40000 ALTER TABLE `tablefilter` ENABLE KEYS */;

-- Dumping structure for table maha.theme
CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(200) NOT NULL,
  `landingImg` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.theme: ~0 rows (approximately)
/*!40000 ALTER TABLE `theme` DISABLE KEYS */;
INSERT INTO `theme` (`id`, `logo`, `landingImg`) VALUES
	(1, 'images/maha.png', 'images/online_learning.svg');
/*!40000 ALTER TABLE `theme` ENABLE KEYS */;

-- Dumping structure for table maha.videos
CREATE TABLE IF NOT EXISTS `videos` (
  `id_video` int(11) NOT NULL AUTO_INCREMENT,
  `id_formation` int(11) NOT NULL,
  `nom_video` varchar(100) NOT NULL,
  `url_video` varchar(200) NOT NULL,
  `duree_video` time NOT NULL,
  `description_video` text NOT NULL,
  `order_video` int(11) DEFAULT '999',
  `watched` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_video`),
  KEY `id_formation` (`id_formation`),
  CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.videos: ~13 rows (approximately)
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` (`id_video`, `id_formation`, `nom_video`, `url_video`, `duree_video`, `description_video`, `order_video`, `watched`) VALUES
	(1, 1, 'Introduction', 'images/formations/videos/18734_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(2, 2, '1', 'images/formations/videos/16120_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(3, 3, '1', 'images/formations/videos/18967_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(4, 4, '1', 'images/formations/videos/33920_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(5, 5, '1', 'images/formations/videos/22547_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(6, 5, '1', 'images/formations/videos/15182_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(7, 5, '1', 'images/formations/videos/32475_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(8, 6, 'Numquam qui esse ac', 'images/formations/videos/23695_1.mp4', '00:00:11', 'Fugiat consectetur ', 999, 0),
	(9, 7, 'Ducimus esse liber', 'images/formations/videos/20676_1.mp4', '00:00:11', 'Asperiores aspernatu', 999, 0),
	(10, 8, '1', 'images/formations/videos/27719_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(11, 9, '1', 'images/formations/videos/19887_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(12, 10, '1', 'images/formations/videos/28036_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(13, 11, '1', 'images/formations/videos/27826_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(14, 1, 'Les Variables Locaux', 'images/formations/videos/18734_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0);
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;

-- Dumping structure for table maha.watched
CREATE TABLE IF NOT EXISTS `watched` (
  `id_etudiant` varchar(255) NOT NULL,
  `id_video` int(11) NOT NULL,
  KEY `FK_watched_etudiants` (`id_etudiant`),
  KEY `FK_watched_videos` (`id_video`),
  CONSTRAINT `FK_watched_etudiants` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_watched_videos` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.watched: ~5 rows (approximately)
/*!40000 ALTER TABLE `watched` DISABLE KEYS */;
INSERT INTO `watched` (`id_etudiant`, `id_video`) VALUES
	('ETU1', 1),
	('ETU3', 11),
	('ETU4', 12),
	('ETU5', 3),
	('ETU5', 8);
/*!40000 ALTER TABLE `watched` ENABLE KEYS */;

-- Dumping structure for trigger maha.calcDuree
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `calcDuree` AFTER INSERT ON `videos` FOR EACH ROW BEGIN
  UPDATE formations f SET mass_horaire=
    (SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(v.duree_video))) 
    FROM videos v WHERE v.id_formation=NEW.id_formation)
    WHERE f.id_formation=NEW.id_formation;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.calcDureeOnDelete
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `calcDureeOnDelete` AFTER DELETE ON `videos` FOR EACH ROW BEGIN
  UPDATE formations f SET mass_horaire=
    (SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(v.duree_video))) 
    FROM videos v WHERE v.id_formation=OLD.id_formation)
    WHERE f.id_formation=OLD.id_formation;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.calcDureeOnUpdate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `calcDureeOnUpdate` AFTER UPDATE ON `videos` FOR EACH ROW BEGIN
  UPDATE formations f SET mass_horaire=
    (SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(v.duree_video))) 
    FROM videos v WHERE v.id_formation=NEW.id_formation)
    WHERE f.id_formation=NEW.id_formation;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.calcLikeDelete
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `calcLikeDelete` AFTER DELETE ON `likes` FOR EACH ROW BEGIN
  DECLARE likesCount int DEFAULT 0;
    SET likesCount=(SELECT count(*) FROM likes WHERE formation_id=OLD.formation_id);
  UPDATE formations SET likes=likesCount WHERE id_formation=OLD.formation_id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.calcLikeInsert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `calcLikeInsert` AFTER INSERT ON `likes` FOR EACH ROW BEGIN
  DECLARE likesCount int DEFAULT 0;
    SET likesCount=(SELECT count(*) FROM likes WHERE formation_id=NEW.formation_id);
  UPDATE formations f SET likes=likesCount WHERE id_formation=NEW.formation_id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.commentaires_after_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `commentaires_after_insert` AFTER INSERT ON `commentaires` FOR EACH ROW BEGIN
  INSERT INTO notifications(id_commentaire)
  VALUES (NEW.id_commentaire);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.etudiants_before_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `etudiants_before_insert` BEFORE INSERT ON `etudiants` FOR EACH ROW BEGIN
  DECLARE numero INT;
  DECLARE v_id_etudiant VARCHAR(100);
  DECLARE is_exist BOOLEAN DEFAULT FALSE;
  DECLARE cpt INT;
  
  SET numero = (SELECT COUNT(*) FROM etudiants) + 1;
  SET v_id_etudiant = CONCAT("ETU", numero);
  check_exist : LOOP
    SET cpt = (SELECT COUNT(*) FROM etudiants WHERE id_etudiant = v_id_etudiant);
    IF(cpt = 0) THEN
      LEAVE check_exist;
    ELSE
      SET numero = numero + 1;
      SET v_id_etudiant = CONCAT("ETU", numero);
    END IF;
  END LOOP check_exist;
  
  SET NEW.id_etudiant = v_id_etudiant;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.formateurs_before_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `formateurs_before_insert` BEFORE INSERT ON `formateurs` FOR EACH ROW BEGIN
  DECLARE numero INT;
  DECLARE v_id_formateur VARCHAR(100);
  DECLARE is_exist BOOLEAN DEFAULT FALSE;
  DECLARE cpt INT;
  
  SET numero = (SELECT COUNT(*) FROM formateurs) + 1;
  SET v_id_formateur = CONCAT("FOR", numero);
  check_exist : LOOP
    SET cpt = (SELECT COUNT(*) FROM formateurs WHERE id_formateur = v_id_formateur);
    IF(cpt = 0) THEN
      LEAVE check_exist;
    ELSE
      SET numero = numero + 1;
      SET v_id_formateur = CONCAT("FOR", numero);
    END IF;
  END LOOP check_exist;
  
  SET NEW.id_formateur = v_id_formateur;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.inscriptions_after_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `inscriptions_after_update` AFTER UPDATE ON `inscriptions` FOR EACH ROW BEGIN
  UPDATE admin
  SET balance = balance + NEW.prix;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.request_payment_after_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `request_payment_after_update` AFTER UPDATE ON `request_payment` FOR EACH ROW BEGIN
  IF(NEW.etat_request = 'accepted') THEN 
    -- la table formateurs
    UPDATE formateurs
    SET balance = balance - NEW.request_prix
    WHERE id_formateur = NEW.id_formateur;
    -- la table admin
    UPDATE admin
    SET balance = balance - NEW.request_prix;
  END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
