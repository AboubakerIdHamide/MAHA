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
CREATE DATABASE IF NOT EXISTS `maha` /*!40100 DEFAULT CHARACTER SET latin1 */;
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
  PRIMARY KEY (`id_admin`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table maha.admin: ~0 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id_admin`, `nom_admin`, `prenom_admin`, `email_admin`, `img_admin`, `mot_de_passe`, `balance`) VALUES
	(1, 'Toumi', 'Anass', 'simo.bahlawi76@gmail.com', '45393256813', 'dimabarca123@@@', 6);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table maha.bookmarks
CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id_etudiant` int(11) DEFAULT NULL,
  `id_video` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table maha.bookmarks: ~0 rows (approximately)
/*!40000 ALTER TABLE `bookmarks` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookmarks` ENABLE KEYS */;

-- Dumping structure for table maha.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int(11) NOT NULL,
  `nom_categorie` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table maha.categories: ~14 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id_categorie`, `nom_categorie`) VALUES
	(1, '3D'),
	(2, 'Architecture & BIM'),
	(3, 'Audio-MAO'),
	(4, 'Business & Efficacité professionnelle'),
	(5, 'Code'),
	(6, 'Infographie'),
	(7, 'Photographie'),
	(8, 'Vidéo-Compositing'),
	(9, 'Webmarketing'),
	(10, 'Réseaux informatique'),
	(11, 'Management'),
	(12, 'Bureautique'),
	(13, 'Développement Web'),
	(14, 'Développement Mobile');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table maha.commentaires
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id_commentaire` int(11) NOT NULL AUTO_INCREMENT,
  `id_video` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_commentaire`) USING BTREE,
  KEY `id_video` (`id_video`) USING BTREE,
  KEY `FK_commentaires_etudiants` (`id_etudiant`) USING BTREE,
  CONSTRAINT `FK_commentaires_etudiants` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE,
  CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table maha.commentaires: ~0 rows (approximately)
/*!40000 ALTER TABLE `commentaires` DISABLE KEYS */;
INSERT INTO `commentaires` (`id_commentaire`, `id_video`, `id_etudiant`, `commentaire`, `created_at`) VALUES
	(31, 2, 5, 'sdfsdfsdsf', '2022-12-18 01:20:58');
/*!40000 ALTER TABLE `commentaires` ENABLE KEYS */;

-- Dumping structure for table maha.etudiants
CREATE TABLE IF NOT EXISTS `etudiants` (
  `id_etudiant` int(11) NOT NULL AUTO_INCREMENT,
  `nom_etudiant` varchar(50) NOT NULL,
  `prenom_etudiant` varchar(50) NOT NULL,
  `email_etudiant` varchar(100) NOT NULL,
  `tel_etudiant` varchar(15) DEFAULT NULL,
  `date_creation_etudiant` datetime DEFAULT CURRENT_TIMESTAMP,
  `img_etudiant` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_etudiant`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table maha.etudiants: ~4 rows (approximately)
/*!40000 ALTER TABLE `etudiants` DISABLE KEYS */;
INSERT INTO `etudiants` (`id_etudiant`, `nom_etudiant`, `prenom_etudiant`, `email_etudiant`, `tel_etudiant`, `date_creation_etudiant`, `img_etudiant`, `mot_de_passe`) VALUES
	(1, 'Hamidox', 'Rwida', 'street.fighter@gmail.col', '0669875369', '2022-11-30 14:07:39', '45393256813', 'dimabarca123'),
	(2, 'Reda', 'Taliani', 'street.fighter@gmail.col', '0669875369', '2022-11-30 14:07:39', '45393256813', 'dimabarca123'),
	(3, 'Anass', 'Toumi', 'street.fighter@gmail.col', '0684395687', '2022-11-30 14:07:39', '45393256813', 'dimabarca123'),
	(4, 'Abdelkadir', 'Hmida', 'street.fighter@gmail.col', '0669875369', '2022-11-30 14:07:39', '45393256813', 'dimabarca123'),
	(5, 'Drake', 'Driss', 'simo.bahlawi76@gmail.com', '0659874365', '2022-12-17 18:54:35', '45393256813', '$2y$10$BAbuylfSebVetlCUWYC9EeGmKNBDwwu582klwsn32H5tqDxarfxr2');
/*!40000 ALTER TABLE `etudiants` ENABLE KEYS */;

-- Dumping structure for table maha.folders
CREATE TABLE IF NOT EXISTS `folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userFolderId` varchar(255) DEFAULT NULL,
  `imagesId` varchar(255) DEFAULT NULL,
  `videosId` varchar(255) DEFAULT NULL,
  `ressourcesId` varchar(255) DEFAULT NULL,
  `userEmail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table maha.folders: ~0 rows (approximately)
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;
INSERT INTO `folders` (`id`, `userFolderId`, `imagesId`, `videosId`, `ressourcesId`, `userEmail`) VALUES
	(1, '15513601151', '15513601258', '15513601572', '15513601414', 'xavi.2012barca@gmail.com'),
	(2, '15667844606', '15667846229', '15667848665', '15667847139', 'simo.bahlawi76@gmail.com');
/*!40000 ALTER TABLE `folders` ENABLE KEYS */;

-- Dumping structure for table maha.formateurs
CREATE TABLE IF NOT EXISTS `formateurs` (
  `id_formateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom_formateur` varchar(50) NOT NULL,
  `prenom_formateur` varchar(50) NOT NULL,
  `email_formateur` varchar(100) NOT NULL,
  `tel_formateur` varchar(15) DEFAULT NULL,
  `date_creation_formateur` datetime DEFAULT CURRENT_TIMESTAMP,
  `img_formateur` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `paypalMail` varchar(250) DEFAULT NULL,
  `biography` text,
  `specialiteId` int(11) DEFAULT NULL,
  `balance` float DEFAULT '0',
  PRIMARY KEY (`id_formateur`),
  KEY `specialiteId` (`specialiteId`),
  CONSTRAINT `formateurs_ibfk_1` FOREIGN KEY (`specialiteId`) REFERENCES `categories` (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table maha.formateurs: ~10 rows (approximately)
/*!40000 ALTER TABLE `formateurs` DISABLE KEYS */;
INSERT INTO `formateurs` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `email_formateur`, `tel_formateur`, `date_creation_formateur`, `img_formateur`, `mot_de_passe`, `paypalMail`, `biography`, `specialiteId`, `balance`) VALUES
	(1, 'ABDELMOUMEN', 'Mustafa', 'xavi.2012barca@gmail.com', '0638123132', '2022-12-03 23:32:09', '45393256813', '$2y$10$k2S49ubSD4tHQguREDXbtO2HnzcQ725QetgzpZoscr9eQu2vgzjPK', 'xavi-2012barca@gmail.com', 'Bio Graphie Mustafa Bio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie Mustafa', 13, 300),
	(3, 'Rkiba', 'Hassan', 'xavi.2012barca@gmail.com', '0638123132', '2022-12-03 23:32:09', '45393256813', '$2y$10$k2S49ubSD4tHQguREDXbtO2HnzcQ725QetgzpZoscr9eQu2vgzjPK', 'xavi-2012barca@gmail.com', 'Bio Graphie Mustafa Bio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie Mustafa', 8, 0),
	(16, 'Nom 1', 'Mustafa', 'xavi.2012barca@gmail.com', '0638123132', '2022-12-03 23:32:09', '45393256813', '$2y$10$k2S49ubSD4tHQguREDXbtO2HnzcQ725QetgzpZoscr9eQu2vgzjPK', 'xavi-2012barca@gmail.com', 'Bio Graphie Mustafa Bio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie Mustafa', 13, 0),
	(17, 'Nom 1', 'Mustafa', 'xavi.2012barca@gmail.com', '0638123132', '2022-12-03 23:32:09', '45393256813', '$2y$10$k2S49ubSD4tHQguREDXbtO2HnzcQ725QetgzpZoscr9eQu2vgzjPK', 'xavi-2012barca@gmail.com', 'Bio Graphie Mustafa Bio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie Mustafa', 13, 0),
	(18, 'Nom 1', 'Mustafa', 'xavi.2012barca@gmail.com', '0638123132', '2022-12-03 23:32:09', '45393256813', '$2y$10$k2S49ubSD4tHQguREDXbtO2HnzcQ725QetgzpZoscr9eQu2vgzjPK', 'xavi-2012barca@gmail.com', 'Bio Graphie Mustafa Bio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie Mustafa', 13, 0),
	(19, 'Nom 1', 'Mustafa', 'xavi.2012barca@gmail.com', '0638123132', '2022-12-03 23:32:09', '45393256813', '$2y$10$k2S49ubSD4tHQguREDXbtO2HnzcQ725QetgzpZoscr9eQu2vgzjPK', 'xavi-2012barca@gmail.com', 'Bio Graphie Mustafa Bio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie Mustafa', 13, 0),
	(20, 'Nom 1', 'Mustafa', 'xavi.2012barca@gmail.com', '0638123132', '2022-12-03 23:32:09', '45393256813', '$2y$10$k2S49ubSD4tHQguREDXbtO2HnzcQ725QetgzpZoscr9eQu2vgzjPK', 'xavi-2012barca@gmail.com', 'Bio Graphie Mustafa Bio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie Mustafa', 13, 0),
	(21, 'Nom 1', 'Mustafa', 'xavi.2012barca@gmail.com', '0638123132', '2022-12-03 23:32:09', '45393256813', '$2y$10$k2S49ubSD4tHQguREDXbtO2HnzcQ725QetgzpZoscr9eQu2vgzjPK', 'xavi-2012barca@gmail.com', 'Bio Graphie Mustafa Bio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie Mustafa', 13, 0),
	(22, 'Nom 1', 'Mustafa', 'xavi.2012barca@gmail.com', '0638123132', '2022-12-03 23:32:09', '45393256813', '$2y$10$k2S49ubSD4tHQguREDXbtO2HnzcQ725QetgzpZoscr9eQu2vgzjPK', 'xavi-2012barca@gmail.com', 'Bio Graphie Mustafa Bio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie Mustafa', 13, 0),
	(23, 'Nom 1', 'Mustafa', 'xavi.2012barca@gmail.com', '0638123132', '2022-12-03 23:32:09', '45393256813', '$2y$10$k2S49ubSD4tHQguREDXbtO2HnzcQ725QetgzpZoscr9eQu2vgzjPK', 'xavi-2012barca@gmail.com', 'Bio Graphie Mustafa Bio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie MustafaBio Graphie Mustafa', 13, 0);
/*!40000 ALTER TABLE `formateurs` ENABLE KEYS */;

-- Dumping structure for table maha.formations
CREATE TABLE IF NOT EXISTS `formations` (
  `id_formation` int(11) NOT NULL AUTO_INCREMENT,
  `niveau_formation` int(11) NOT NULL,
  `id_formateur` int(11) NOT NULL,
  `categorie` int(11) NOT NULL,
  `nom_formation` varchar(100) NOT NULL,
  `image_formation` varchar(200) NOT NULL,
  `mass_horaire` time NOT NULL,
  `date_creation_formation` datetime DEFAULT CURRENT_TIMESTAMP,
  `prix_formation` float(8,2) DEFAULT NULL,
  `description` text NOT NULL,
  `id_langue` int(11) DEFAULT '1',
  `likes` int(11) DEFAULT '0',
  PRIMARY KEY (`id_formation`),
  KEY `niveau_formation` (`niveau_formation`),
  KEY `id_formateur` (`id_formateur`),
  KEY `categorie` (`categorie`),
  KEY `id_langue` (`id_langue`),
  CONSTRAINT `formations_ibfk_1` FOREIGN KEY (`niveau_formation`) REFERENCES `niveaux` (`id_niveau`),
  CONSTRAINT `formations_ibfk_2` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`),
  CONSTRAINT `formations_ibfk_3` FOREIGN KEY (`categorie`) REFERENCES `categories` (`id_categorie`),
  CONSTRAINT `formations_ibfk_4` FOREIGN KEY (`id_langue`) REFERENCES `langues` (`id_langue`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table maha.formations: ~0 rows (approximately)
/*!40000 ALTER TABLE `formations` DISABLE KEYS */;
INSERT INTO `formations` (`id_formation`, `niveau_formation`, `id_formateur`, `categorie`, `nom_formation`, `image_formation`, `mass_horaire`, `date_creation_formation`, `prix_formation`, `description`, `id_langue`, `likes`) VALUES
	(1, 2, 1, 5, 'php for beginners', '45993314962', '00:01:28', '2022-12-13 01:10:11', 90.00, 'PHP is a server scripting language, and a powerful tool for making dynamic and interactive Web pages. PHP is a widely-used, free, and efficient ', 2, 1);
/*!40000 ALTER TABLE `formations` ENABLE KEYS */;

-- Dumping structure for table maha.inscriptions
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id_inscription` int(11) NOT NULL AUTO_INCREMENT,
  `id_formation` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `id_formateur` int(11) NOT NULL,
  `date_inscription` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_inscription`),
  KEY `id_formation` (`id_formation`),
  KEY `id_etudiant` (`id_etudiant`),
  KEY `id_formateur` (`id_formateur`),
  CONSTRAINT `inscriptions_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`),
  CONSTRAINT `inscriptions_ibfk_2` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`),
  CONSTRAINT `inscriptions_ibfk_3` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table maha.inscriptions: ~2 rows (approximately)
/*!40000 ALTER TABLE `inscriptions` DISABLE KEYS */;
INSERT INTO `inscriptions` (`id_inscription`, `id_formation`, `id_etudiant`, `id_formateur`, `date_inscription`) VALUES
	(1, 1, 5, 1, '2022-12-17 18:58:04'),
	(2, 28, 1, 16, '2022-12-10 21:05:29'),
	(3, 24, 1, 23, '2022-12-10 21:05:29');
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
            
            INSERT INTO `tablefilter`(`IdFormation`, `imgFormation`, `duree`, `idCategore`, `categorie`, `nomFormation`, 							`prix`, `description`, `likes`, `IdFormteur`, `nomFormateur`, `prenomFormateur`, `specialiteId`, 							`specialite`, `imgFormateur`, `numbAcht`, `dateCreationFormation`, `idLangage`, `langageFormation`, `idNiv`, `niveauFormation`) 
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
            
            INSERT INTO `tablefilter`(`IdFormation`, `imgFormation`, `duree`, `idCategore`, `categorie`, `nomFormation`, 							`prix`, `description`, `likes`, `IdFormteur`, `nomFormateur`, `prenomFormateur`, `specialiteId`, 							`specialite`, `imgFormateur`, `numbAcht`, `dateCreationFormation`, `idLangage`, `langageFormation`, `idNiv`, `niveauFormation`) 
            VALUES (IdFormation, imgFormation, duree, idCategore, categorie, nomFormation, prix, description, likes, IdFormteur, nomFormateur, prenomFormateur, specialiteId, specialite, imgFormateur, numbAcht, dateCreationFormation, idLangage, langageFormation, idNiv, niveauFormation);
        set i = i+1;
        end while;
    close cur;
end//
DELIMITER ;

-- Dumping structure for table maha.langues
CREATE TABLE IF NOT EXISTS `langues` (
  `id_langue` int(11) NOT NULL,
  `nom_langue` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_langue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `etudiant_id` int(11) DEFAULT NULL,
  `formation_id` int(11) DEFAULT NULL,
  KEY `fkLikes1` (`etudiant_id`),
  KEY `fkLikes2` (`formation_id`),
  CONSTRAINT `fkLikes1` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id_etudiant`),
  CONSTRAINT `fkLikes2` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id_formation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table maha.likes: ~0 rows (approximately)
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` (`etudiant_id`, `formation_id`) VALUES
	(5, 1);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;

-- Dumping structure for table maha.niveaux
CREATE TABLE IF NOT EXISTS `niveaux` (
  `id_niveau` int(11) NOT NULL,
  `nom_niveau` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_niveau`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table maha.niveaux: ~3 rows (approximately)
/*!40000 ALTER TABLE `niveaux` DISABLE KEYS */;
INSERT INTO `niveaux` (`id_niveau`, `nom_niveau`) VALUES
	(1, 'débutant'),
	(2, 'intermédiaire'),
	(3, 'avancé');
/*!40000 ALTER TABLE `niveaux` ENABLE KEYS */;

-- Dumping structure for table maha.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id_notification` int(11) NOT NULL AUTO_INCREMENT,
  `id_commentaire` int(11) NOT NULL,
  `etat_notification` int(11) DEFAULT '1',
  PRIMARY KEY (`id_notification`),
  KEY `FK_notifications_commentaires` (`id_commentaire`),
  CONSTRAINT `FK_notifications_commentaires` FOREIGN KEY (`id_commentaire`) REFERENCES `commentaires` (`id_commentaire`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table maha.notifications: ~0 rows (approximately)
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;

-- Dumping structure for table maha.previews
CREATE TABLE IF NOT EXISTS `previews` (
  `id_formation` int(11) NOT NULL,
  `id_video` int(11) NOT NULL,
  UNIQUE KEY `id_formation` (`id_formation`) USING BTREE,
  UNIQUE KEY `id_video` (`id_video`) USING BTREE,
  CONSTRAINT `previews_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`) ON DELETE CASCADE,
  CONSTRAINT `previews_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table maha.previews: ~1 rows (approximately)
/*!40000 ALTER TABLE `previews` DISABLE KEYS */;
INSERT INTO `previews` (`id_formation`, `id_video`) VALUES
	(1, 3);
/*!40000 ALTER TABLE `previews` ENABLE KEYS */;

-- Dumping structure for table maha.request_payment
CREATE TABLE IF NOT EXISTS `request_payment` (
  `id_payment` int(11) NOT NULL AUTO_INCREMENT,
  `id_formateur` int(11) NOT NULL,
  `request_prix` float NOT NULL,
  `date_request` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `etat_request` varchar(10) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id_payment`) USING BTREE,
  KEY `id_formateur` (`id_formateur`) USING BTREE,
  CONSTRAINT `request_payment_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table maha.request_payment: ~0 rows (approximately)
/*!40000 ALTER TABLE `request_payment` DISABLE KEYS */;
INSERT INTO `request_payment` (`id_payment`, `id_formateur`, `request_prix`, `date_request`, `etat_request`) VALUES
	(6, 1, 20, '2022-12-12 01:04:24', 'pending');
/*!40000 ALTER TABLE `request_payment` ENABLE KEYS */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table maha.tablefilter: ~0 rows (approximately)
/*!40000 ALTER TABLE `tablefilter` DISABLE KEYS */;
/*!40000 ALTER TABLE `tablefilter` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table maha.videos: ~1 rows (approximately)
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` (`id_video`, `id_formation`, `nom_video`, `url_video`, `duree_video`, `description_video`, `order_video`, `watched`) VALUES
	(2, 1, 'Php For Beginners Part 1.mp4', '46160469452', '00:00:44', 'dÃ©crivez ces vidÃ©os ou ajoutez des ressources !', 999, 0),
	(3, 1, 'Php For Beginners Part 2.mp4', '46160892796', '00:00:44', 'dÃ©crivez ces vidÃ©os ou ajoutez des ressources !', 999, 0);
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;

-- Dumping structure for table maha.watched
CREATE TABLE IF NOT EXISTS `watched` (
  `id_etudiant` int(11) DEFAULT NULL,
  `id_video` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table maha.watched: ~0 rows (approximately)
/*!40000 ALTER TABLE `watched` DISABLE KEYS */;
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
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `commentaires_after_insert` AFTER INSERT ON `commentaires` FOR EACH ROW BEGIN
	INSERT INTO notifications(id_commentaire)
	VALUES (NEW.id_commentaire);
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
