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
CREATE DATABASE IF NOT EXISTS `maha` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `maha`;

-- Dumping structure for table maha.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `img` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `balance` float DEFAULT '0',
  `platform_pourcentage` float NOT NULL DEFAULT '0',
  `username_paypal` varchar(255) DEFAULT NULL,
  `password_paypal` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_admin`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table maha.admins: ~0 rows (approximately)
DELETE FROM `admins`;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`id_admin`, `nom`, `prenom`, `email`, `img`, `mot_de_passe`, `balance`, `platform_pourcentage`, `username_paypal`, `password_paypal`) VALUES
  (1, 'MAHA', 'Team', 'mahateam@gmail.com', 'images/membre.jpg', 'admin123@@@', 0, 10, 'Af173BC6L0TzwyZG3Q1ToevB8qmvCAOI_xmgtNnbKex2QydeYCM335mCsvJwvuupkJmABbUxYnThj9wE', 'ELTMVnjyg1lmDXDnZZTTVJKeLrWBfz5Cgg0GGp-9hPKzKwqY7GwkQEm5upYE4t6y2ip_JutuifOMD_0x');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;

-- Dumping structure for table maha.apercus
CREATE TABLE IF NOT EXISTS `apercus` (
  `id_formation` int(11) NOT NULL,
  `id_video` int(11) NOT NULL,
  UNIQUE KEY `id_formation` (`id_formation`),
  UNIQUE KEY `id_video` (`id_video`),
  CONSTRAINT `fk_formations_apercus` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`) ON UPDATE CASCADE,
  CONSTRAINT `fk_videos_apercus` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.apercus: ~0 rows (approximately)
DELETE FROM `apercus`;
/*!40000 ALTER TABLE `apercus` DISABLE KEYS */;
/*!40000 ALTER TABLE `apercus` ENABLE KEYS */;

-- Dumping structure for table maha.bookmarks
CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id_etudiant` varchar(255) NOT NULL,
  `id_video` int(11) NOT NULL,
  KEY `fk_etudiants_bookmarks` (`id_etudiant`),
  KEY `fk_videos_bookmarks` (`id_video`),
  CONSTRAINT `fk_etudiants_bookmarks` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON UPDATE CASCADE,
  CONSTRAINT `fk_videos_bookmarks` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.bookmarks: ~0 rows (approximately)
DELETE FROM `bookmarks`;
/*!40000 ALTER TABLE `bookmarks` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookmarks` ENABLE KEYS */;

-- Dumping structure for table maha.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `icon` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_categorie`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table maha.categories: ~12 rows (approximately)
DELETE FROM `categories`;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id_categorie`, `nom`, `icon`) VALUES
  (1, '3D', '<i class="fa-brands fa-unity"></i>'),
  (2, 'Architecture & BIM', '<i class="fa-solid fa-ruler-combined"></i>'),
  (3, 'Audio-MAO', '<i class="fa-solid fa-sliders"></i>'),
  (4, 'Business & Finance', '<i class="fa-sharp fa-solid fa-briefcase"></i>'),
  (5, 'Code', '<i class="fa-solid fa-code"></i>'),
  (6, 'Infographie', '<i class="fa-sharp fa-solid fa-pen-nib"></i>'),
  (7, 'Photographie', '<i class="fa-solid fa-camera-retro"></i>'),
  (8, 'Vidéo-Compositing', '<i class="fa-solid fa-video"></i>'),
  (9, 'Webmarketing', '<i class="fa-solid fa-chart-simple"></i>'),
  (10, 'Réseaux informatique', '<i class="fa-solid fa-network-wired"></i>'),
  (11, 'Management', '<i class="fa-solid fa-list-check"></i>'),
  (12, 'Bureautique', '<i class="fa-solid fa-computer-mouse"></i>');
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
  KEY `fk_videos_commentaires` (`id_video`),
  CONSTRAINT `fk_videos_commentaires` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.commentaires: ~0 rows (approximately)
DELETE FROM `commentaires`;
/*!40000 ALTER TABLE `commentaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `commentaires` ENABLE KEYS */;

-- Dumping structure for table maha.demande_paiements
CREATE TABLE IF NOT EXISTS `demande_paiements` (
  `id_payment` int(11) NOT NULL AUTO_INCREMENT,
  `id_formateur` varchar(255) NOT NULL,
  `prix_demande` float NOT NULL,
  `date_de_demande` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `etat` varchar(10) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id_payment`),
  KEY `fk_formateurs_paiements` (`id_formateur`),
  CONSTRAINT `fk_formateurs_paiements` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.demande_paiements: ~0 rows (approximately)
DELETE FROM `demande_paiements`;
/*!40000 ALTER TABLE `demande_paiements` DISABLE KEYS */;
/*!40000 ALTER TABLE `demande_paiements` ENABLE KEYS */;

-- Dumping structure for table maha.etudiants
CREATE TABLE IF NOT EXISTS `etudiants` (
  `id_etudiant` varchar(255) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `img` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_etudiant`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.etudiants: ~0 rows (approximately)
DELETE FROM `etudiants`;
/*!40000 ALTER TABLE `etudiants` DISABLE KEYS */;
/*!40000 ALTER TABLE `etudiants` ENABLE KEYS */;

-- Dumping structure for table maha.formateurs
CREATE TABLE IF NOT EXISTS `formateurs` (
  `id_formateur` varchar(255) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `img` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `paypalMail` varchar(250) NOT NULL,
  `biography` text NOT NULL,
  `balance` float NOT NULL DEFAULT '0',
  `code` varchar(50) DEFAULT NULL,
  `id_categorie` int(11) NOT NULL,
  PRIMARY KEY (`id_formateur`) USING BTREE,
  KEY `fk_categories_formateurs` (`id_categorie`),
  CONSTRAINT `fk_categories_formateurs` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.formateurs: ~0 rows (approximately)
DELETE FROM `formateurs`;
/*!40000 ALTER TABLE `formateurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `formateurs` ENABLE KEYS */;

-- Dumping structure for table maha.formations
CREATE TABLE IF NOT EXISTS `formations` (
  `id_formation` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `mass_horaire` time NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prix` float(8,2) NOT NULL,
  `description` text NOT NULL,
  `jaimes` int(11) DEFAULT '0',
  `fichier_attache` varchar(255) DEFAULT NULL,
  `etat` varchar(255) DEFAULT 'public',
  `id_langue` int(11) DEFAULT '1',
  `id_niveau` int(11) DEFAULT NULL,
  `id_formateur` varchar(255) DEFAULT NULL,
  `id_categorie` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_formation`),
  KEY `fk_langues_formations` (`id_langue`),
  KEY `fk_categories_formations` (`id_categorie`),
  KEY `fk_formateurs_formations` (`id_formateur`),
  KEY `fk_niveaux_formations` (`id_niveau`),
  CONSTRAINT `fk_categories_formations` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_formateurs_formations` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_langues_formations` FOREIGN KEY (`id_langue`) REFERENCES `langues` (`id_langue`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_niveaux_formations` FOREIGN KEY (`id_niveau`) REFERENCES `niveaux` (`id_niveau`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.formations: ~0 rows (approximately)
DELETE FROM `formations`;
/*!40000 ALTER TABLE `formations` DISABLE KEYS */;
/*!40000 ALTER TABLE `formations` ENABLE KEYS */;

-- Dumping structure for table maha.inscriptions
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id_inscription` int(11) NOT NULL AUTO_INCREMENT,
  `id_formation` int(11) DEFAULT NULL,
  `id_etudiant` varchar(255) DEFAULT NULL,
  `id_formateur` varchar(255) DEFAULT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prix` float NOT NULL,
  `transaction_info` json NOT NULL,
  `payment_id` varchar(100) NOT NULL,
  `payment_state` varchar(50) NOT NULL,
  `approval_url` varchar(200) NOT NULL,
  PRIMARY KEY (`id_inscription`),
  KEY `fk_formateurs_inscriptions` (`id_formateur`),
  KEY `fk_etudiant_inscriptions` (`id_etudiant`),
  KEY `fk_formations_inscriptions` (`id_formation`),
  CONSTRAINT `fk_etudiant_inscriptions` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_formateurs_inscriptions` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_formations_inscriptions` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.inscriptions: ~0 rows (approximately)
DELETE FROM `inscriptions`;
/*!40000 ALTER TABLE `inscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscriptions` ENABLE KEYS */;

-- Dumping structure for table maha.jaimes
CREATE TABLE IF NOT EXISTS `jaimes` (
  `id_etudiant` varchar(255) NOT NULL,
  `id_formation` int(11) NOT NULL,
  KEY `fk_etudiants_jaimes` (`id_etudiant`),
  KEY `fk_formations_jaimes` (`id_formation`),
  CONSTRAINT `fk_etudiants_jaimes` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON UPDATE CASCADE,
  CONSTRAINT `fk_formations_jaimes` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.jaimes: ~0 rows (approximately)
DELETE FROM `jaimes`;
/*!40000 ALTER TABLE `jaimes` DISABLE KEYS */;
/*!40000 ALTER TABLE `jaimes` ENABLE KEYS */;

-- Dumping structure for table maha.langues
CREATE TABLE IF NOT EXISTS `langues` (
  `id_langue` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  PRIMARY KEY (`id_langue`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table maha.langues: ~4 rows (approximately)
DELETE FROM `langues`;
/*!40000 ALTER TABLE `langues` DISABLE KEYS */;
INSERT INTO `langues` (`id_langue`, `nom`) VALUES
  (1, 'Français'),
  (2, 'Anglais'),
  (3, 'Espagnol'),
  (4, 'العربية');
/*!40000 ALTER TABLE `langues` ENABLE KEYS */;

-- Dumping structure for table maha.niveaux
CREATE TABLE IF NOT EXISTS `niveaux` (
  `id_niveau` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `icon` text,
  PRIMARY KEY (`id_niveau`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.niveaux: ~2 rows (approximately)
DELETE FROM `niveaux`;
/*!40000 ALTER TABLE `niveaux` DISABLE KEYS */;
INSERT INTO `niveaux` (`id_niveau`, `nom`, `icon`) VALUES
  (1, 'Débutant', '<svg width="58" height="30" viewBox="0 0 38 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill="#E5E5E5" d="M9 4h6v2H9zM23 4h6v2h-6z"></path><circle cx="5" cy="5" r="5" fill="#8887FF"></circle><circle fill="#E5E5E5" cx="19" cy="5" r="5"></circle><circle fill="#E5E5E5" cx="33" cy="5" r="5"></circle></svg>'),
  (2, 'Intermédiaire', '<svg width="58" height="30" viewBox="0 0 38 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 4h6v2H9z" fill="#8887FF"></path><path d="M23 4h6v2h-6z" fill="#E5E5E5"></path><circle cx="5" cy="5" r="5" fill="#8887FF"></circle><circle cx="19" cy="5" r="5" fill="#8887FF"></circle><circle fill="#E5E5E5" cx="33" cy="5" r="5"></circle></svg>\r\n'),
  (3, 'Avancé', '<svg width="58" height="30" viewBox="0 0 38 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill="#8887FF" d="M9 4h6v2H9zM23 4h6v2h-6z"></path><circle cx="5" cy="5" r="5" fill="#8887FF"></circle><circle fill="#8887FF" cx="19" cy="5" r="5"></circle><circle fill="#8887FF" cx="33" cy="5" r="5"></circle></svg>');
/*!40000 ALTER TABLE `niveaux` ENABLE KEYS */;

-- Dumping structure for table maha.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id_notification` int(11) NOT NULL AUTO_INCREMENT,
  `id_commentaire` int(11) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_notification`),
  KEY `fk_commentaires_notifications` (`id_commentaire`),
  CONSTRAINT `fk_commentaires_notifications` FOREIGN KEY (`id_commentaire`) REFERENCES `commentaires` (`id_commentaire`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.notifications: ~0 rows (approximately)
DELETE FROM `notifications`;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;

-- Dumping structure for table maha.smtp
CREATE TABLE IF NOT EXISTS `smtp` (
  `id_smtp` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `port` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_smtp`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table maha.smtp: ~0 rows (approximately)
DELETE FROM `smtp`;
/*!40000 ALTER TABLE `smtp` DISABLE KEYS */;
INSERT INTO `smtp` (`id_smtp`, `host`, `username`, `password`, `port`) VALUES
  (1, 'smtp.gmail.com', 'mahateamisgi@gmail.com', 'fcpfxrepelndwpqr', '465');
/*!40000 ALTER TABLE `smtp` ENABLE KEYS */;

-- Dumping structure for table maha.theme
CREATE TABLE IF NOT EXISTS `theme` (
  `id_theme` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(200) NOT NULL,
  `landingImg` varchar(200) NOT NULL,
  PRIMARY KEY (`id_theme`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table maha.theme: ~0 rows (approximately)
DELETE FROM `theme`;
/*!40000 ALTER TABLE `theme` DISABLE KEYS */;
INSERT INTO `theme` (`id_theme`, `logo`, `landingImg`) VALUES
  (1, 'images/maha.png', 'images/banner_home.jpg');
/*!40000 ALTER TABLE `theme` ENABLE KEYS */;

-- Dumping structure for table maha.videos
CREATE TABLE IF NOT EXISTS `videos` (
  `id_video` int(11) NOT NULL AUTO_INCREMENT,
  `id_formation` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  `duree` time NOT NULL,
  `description` text NOT NULL,
  `ordre` int(11) DEFAULT '999',
  `is_vu` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_video`),
  KEY `fk_formations_videos` (`id_formation`),
  CONSTRAINT `fk_formations_videos` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.videos: ~0 rows (approximately)
DELETE FROM `videos`;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;

-- Dumping structure for table maha.vus
CREATE TABLE IF NOT EXISTS `vus` (
  `id_etudiant` varchar(255) NOT NULL,
  `id_video` int(11) NOT NULL,
  KEY `fk_etudiants_vus` (`id_etudiant`),
  KEY `fk_videos_vus` (`id_video`),
  CONSTRAINT `fk_etudiants_vus` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON UPDATE CASCADE,
  CONSTRAINT `fk_videos_vus` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.vus: ~0 rows (approximately)
DELETE FROM `vus`;
/*!40000 ALTER TABLE `vus` DISABLE KEYS */;
/*!40000 ALTER TABLE `vus` ENABLE KEYS */;

-- Dumping structure for trigger maha.commentaires_after_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `commentaires_after_insert` AFTER INSERT ON `commentaires` FOR EACH ROW BEGIN
  INSERT INTO notifications(id_commentaire)
  VALUES (NEW.id_commentaire);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.demande_paiements_after_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `demande_paiements_after_update` AFTER UPDATE ON `demande_paiements` FOR EACH ROW BEGIN
  IF(NEW.etat = 'accepted') THEN 
    -- la table formateurs
    UPDATE formateurs
    SET balance = balance - NEW.prix_demande
    WHERE id_formateur = NEW.id_formateur;
    -- la table admin
    UPDATE admins
    SET balance = balance - NEW.prix_demande;
  END IF;
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
  UPDATE admins
  SET balance = balance + NEW.prix;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.jaimes_after_delete
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `jaimes_after_delete` AFTER DELETE ON `jaimes` FOR EACH ROW BEGIN
  /* calcLikeDelete */
  DECLARE likesCount int DEFAULT 0;
    SET likesCount=(SELECT count(*) FROM jaimes WHERE id_formation=OLD.id_formation);
  UPDATE formations SET jaimes=likesCount WHERE id_formation=OLD.id_formation;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.jaimes_after_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `jaimes_after_insert` AFTER INSERT ON `jaimes` FOR EACH ROW BEGIN
  /* calcLikeInsert */
  DECLARE likesCount int DEFAULT 0;
    SET likesCount=(SELECT count(*) FROM jaimes WHERE id_formation=NEW.id_formation);
  UPDATE formations f SET jaimes=likesCount WHERE id_formation=NEW.id_formation;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.videos_after_delete
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `videos_after_delete` AFTER DELETE ON `videos` FOR EACH ROW BEGIN
  /* calcDureeOnDelete */
  UPDATE formations f SET mass_horaire=
    (SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(v.duree))) 
    FROM videos v WHERE v.id_formation=OLD.id_formation)
    WHERE f.id_formation=OLD.id_formation;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.videos_after_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `videos_after_insert` AFTER INSERT ON `videos` FOR EACH ROW BEGIN
  /* calcDuree */
  UPDATE formations f SET mass_horaire=
    (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(v.duree))) 
    FROM videos v WHERE v.id_formation=NEW.id_formation)
    WHERE f.id_formation=NEW.id_formation;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger maha.videos_after_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `videos_after_update` AFTER UPDATE ON `videos` FOR EACH ROW BEGIN
  /* calcDureeOnUpdate */
  UPDATE formations f SET mass_horaire=
    (SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(v.duree))) 
    FROM videos v WHERE v.id_formation=NEW.id_formation)
    WHERE f.id_formation=NEW.id_formation;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
