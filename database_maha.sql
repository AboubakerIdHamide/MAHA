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
  PRIMARY KEY (`id_admin`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.admin: ~0 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id_admin`, `nom_admin`, `prenom_admin`, `email_admin`, `img_admin`, `mot_de_passe`, `balance`) VALUES
	(1, 'sdknsdf', 'sdfsdfsdf', 'sarouti@gmail.com', 'images/membre.jpg', 'admin123@@@', 80);
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

-- Dumping data for table maha.bookmarks: ~0 rows (approximately)
/*!40000 ALTER TABLE `bookmarks` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookmarks` ENABLE KEYS */;

-- Dumping structure for table maha.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(100) NOT NULL DEFAULT '',
  `nom_categorie` varchar(50) NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.categories: ~12 rows (approximately)
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
	(12, '<i class="fa-solid fa-computer-mouse"></i>', 'Bureautique');
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

-- Dumping data for table maha.commentaires: ~2 rows (approximately)
/*!40000 ALTER TABLE `commentaires` DISABLE KEYS */;
INSERT INTO `commentaires` (`id_commentaire`, `id_video`, `from_user`, `to_user`, `type_user`, `commentaire`, `created_at`) VALUES
	(1, 1, 'ETU1', 'FOR1', 'etudiant', 'salam', '2023-03-27 16:03:57'),
	(2, 1, 'ETU1', 'FOR1', 'etudiant', 'test2', '2023-03-27 16:06:01'),
	(3, 1, 'ETU1', 'FOR1', 'etudiant', 'test 3', '2023-03-27 16:06:29');
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

-- Dumping data for table maha.etudiants: ~0 rows (approximately)
/*!40000 ALTER TABLE `etudiants` DISABLE KEYS */;
INSERT INTO `etudiants` (`id_etudiant`, `nom_etudiant`, `prenom_etudiant`, `email_etudiant`, `tel_etudiant`, `date_creation_etudiant`, `img_etudiant`, `mot_de_passe`) VALUES
	('ETU1', 'Holt', 'Hermanues', 'bicisay813@oniecan.com', '0672819270', '2023-03-27 01:11:50', 'images/userImage/92322.jpg', '$2y$10$2mzmHmq16z8jI1f9sHii6.VdcG2Jorw8hEk4tr/uqr9fSPkLBHxKG');
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

-- Dumping data for table maha.formateurs: ~0 rows (approximately)
/*!40000 ALTER TABLE `formateurs` DISABLE KEYS */;
INSERT INTO `formateurs` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `email_formateur`, `tel_formateur`, `date_creation_formateur`, `img_formateur`, `mot_de_passe`, `paypalMail`, `biography`, `balance`, `specialiteId`) VALUES
	('FOR1', 'John', 'Smith', 'nolepi2119@necktai.com', '0695038290', '2023-03-27 00:56:47', 'images/userImage/26611.jpg', '$2y$10$3wy.h8bMrjIy.kRvN5TyIeGEMkH.vnk307xSnHDWHAFANeS2sYdPC', 'vehenafit@mailinator.com', 'Tenetur qui quia exe Tenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exe', 10, 8);
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
  `id_langue` int(11) DEFAULT NULL,
  `likes` int(11) DEFAULT '0',
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

-- Dumping data for table maha.formations: ~0 rows (approximately)
/*!40000 ALTER TABLE `formations` DISABLE KEYS */;
INSERT INTO `formations` (`id_formation`, `niveau_formation`, `id_formateur`, `categorie`, `nom_formation`, `image_formation`, `mass_horaire`, `date_creation_formation`, `prix_formation`, `description`, `id_langue`, `likes`) VALUES
	(1, 1, 'FOR1', 10, 'Consequatur adipisc', 'images/formations/images/37066.jpg', '00:08:37', '2023-03-27 02:53:36', 12.00, 'Eu non eos pariatur Eu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariatur', 1, 1);
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

-- Dumping data for table maha.inscriptions: ~0 rows (approximately)
/*!40000 ALTER TABLE `inscriptions` DISABLE KEYS */;
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

-- Dumping data for table maha.likes: ~0 rows (approximately)
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
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
	(1, 'débutant'),
	(2, 'intermédiaire'),
	(3, 'avancé');
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

-- Dumping data for table maha.notifications: ~2 rows (approximately)
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` (`id_notification`, `id_commentaire`, `etat_notification`) VALUES
	(1, 1, 1),
	(2, 2, 1),
	(3, 3, 1);
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

-- Dumping data for table maha.previews: ~1 rows (approximately)
/*!40000 ALTER TABLE `previews` DISABLE KEYS */;
INSERT INTO `previews` (`id_formation`, `id_video`) VALUES
	(1, 29);
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
	(1, 'FOR1', 10, '2023-03-27 15:22:55', 'declined');
/*!40000 ALTER TABLE `request_payment` ENABLE KEYS */;

-- Dumping structure for table maha.sous_categories
CREATE TABLE IF NOT EXISTS `sous_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(200) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__categories` (`id_categorie`),
  CONSTRAINT `FK__categories` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.sous_categories: ~2 rows (approximately)
/*!40000 ALTER TABLE `sous_categories` DISABLE KEYS */;
INSERT INTO `sous_categories` (`id`, `nom`, `id_categorie`) VALUES
	(2, 'Vue JS', 10),
	(3, 'JAVA EE', 10);
/*!40000 ALTER TABLE `sous_categories` ENABLE KEYS */;

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

-- Dumping data for table maha.tablefilter: ~1 rows (approximately)
/*!40000 ALTER TABLE `tablefilter` DISABLE KEYS */;
INSERT INTO `tablefilter` (`IdFormation`, `imgFormation`, `duree`, `idCategore`, `categorie`, `nomFormation`, `prix`, `description`, `likes`, `IdFormteur`, `nomFormateur`, `prenomFormateur`, `specialiteId`, `specialite`, `imgFormateur`, `numbAcht`, `dateCreationFormation`, `idLangage`, `langageFormation`, `idNiv`, `niveauFormation`) VALUES
	(1, 'images/formations/images/37066.jpg', '00:08:37', 10, 'Réseaux informatique', 'Consequatur adipisc', 12, 'Eu non eos pariatur Eu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariaturEu non eos pariatur', 1, 0, 'John', 'Smith', 8, 'Vidéo-Compositing', 'images/userImage/26611.jpg', 0, '2023-03-27', 1, 'Français', 1, 'débutant');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.videos: ~47 rows (approximately)
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` (`id_video`, `id_formation`, `nom_video`, `url_video`, `duree_video`, `description_video`, `order_video`, `watched`) VALUES
	(1, 1, 'Title 1', 'images/formations/videos/79148_1.mp4', '00:00:11', 'Title 1Title 1Title 1Title 1Title 1Title 1Title 1Title 1Title 1Title 1Title 1Title 1Title 1Title 1Title 1Title 1Title 1Title 1', 999, 0),
	(2, 1, 'Title 2', 'images/formations/videos/10556_1.mp4', '00:00:11', 'Title 2Title 2Title 2Title 2Title 2Title 2Title 2Title 2Title 2Title 2', 999, 0),
	(3, 1, 'Title 3', 'images/formations/videos/24444_1.mp4', '00:00:11', 'Title 3Title 3Title 3Title 3Title 3Title 3Title 3Title 3Title 3', 999, 0),
	(4, 1, '1', 'images/formations/videos/50833_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(5, 1, '1', 'images/formations/videos/23293_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(6, 1, '1', 'images/formations/videos/22270_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(7, 1, '1', 'images/formations/videos/11710_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(8, 1, '1', 'images/formations/videos/19314_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(9, 1, '1', 'images/formations/videos/34378_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(10, 1, '1', 'images/formations/videos/93737_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(11, 1, '1', 'images/formations/videos/13075_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(12, 1, '1', 'images/formations/videos/34103_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(13, 1, '1', 'images/formations/videos/85274_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(14, 1, '1', 'images/formations/videos/19612_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(15, 1, '1', 'images/formations/videos/20497_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(16, 1, '1', 'images/formations/videos/21652_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(17, 1, '1', 'images/formations/videos/14438_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(18, 1, '1', 'images/formations/videos/77059_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(19, 1, '1', 'images/formations/videos/28673_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(20, 1, '1', 'images/formations/videos/34603_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(21, 1, '1', 'images/formations/videos/21411_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(22, 1, '1', 'images/formations/videos/42497_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(23, 1, '1', 'images/formations/videos/27708_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(24, 1, '1', 'images/formations/videos/28215_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(25, 1, '1', 'images/formations/videos/11387_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(26, 1, '1', 'images/formations/videos/92969_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(27, 1, '1', 'images/formations/videos/12635_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(28, 1, '1', 'images/formations/videos/21002_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(29, 1, '1', 'images/formations/videos/36911_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(30, 1, '1', 'images/formations/videos/16611_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(31, 1, '1', 'images/formations/videos/10245_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(32, 1, '1', 'images/formations/videos/15752_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(33, 1, '1', 'images/formations/videos/25426_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(34, 1, '1', 'images/formations/videos/58461_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(35, 1, '1', 'images/formations/videos/28529_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(36, 1, '1', 'images/formations/videos/99894_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(37, 1, '1', 'images/formations/videos/12706_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(38, 1, '1', 'images/formations/videos/23900_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(39, 1, '1', 'images/formations/videos/34201_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(40, 1, '1', 'images/formations/videos/23821_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(41, 1, '1', 'images/formations/videos/32777_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(42, 1, '1', 'images/formations/videos/30545_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(43, 1, '1', 'images/formations/videos/21262_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(44, 1, '1', 'images/formations/videos/84962_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(45, 1, '1', 'images/formations/videos/14338_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(46, 1, '1', 'images/formations/videos/84976_1.mp4', '00:00:11', 'discribe this video or add a ressources !', 999, 0),
	(48, 1, '1', 'images/formations/videos/17526_79148_1.mp4', '00:00:11', 'décrivez ces vidéos ou ajoutez des ressources !', 999, 0);
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
