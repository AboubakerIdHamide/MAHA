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

-- Dumping data for table maha.admin: ~0 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id_admin`, `nom_admin`, `prenom_admin`, `email_admin`, `img_admin`, `mot_de_passe`, `balance`, `platform_pourcentage`, `username_paypal`, `password_paypal`) VALUES
	(1, 'Likram', 'Soufiane', 'sarouti@gmail.com', 'images/membre.jpg', 'admin123@@@', 0, 10, 'Af173BC6L0TzwyZG3Q1ToevB8qmvCAOI_xmgtNnbKex2QydeYCM335mCsvJwvuupkJmABbUxYnThj9wE', 'ELTMVnjyg1lmDXDnZZTTVJKeLrWBfz5Cgg0GGp-9hPKzKwqY7GwkQEm5upYE4t6y2ip_JutuifOMD_0x');
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

-- Dumping data for table maha.bookmarks: ~18 rows (approximately)
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
	(4, '<i class="fa-sharp fa-solid fa-briefcase"></i>', 'Business & Finance'),
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

-- Dumping data for table maha.commentaires: ~14 rows (approximately)
/*!40000 ALTER TABLE `commentaires` DISABLE KEYS */;
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
	('ETU1', 'Holt', 'Hermanues', 'bicisay813@oniecan.com', '0672819270', '2023-03-27 01:11:50', 'images/default.jpg', '$2y$10$2mzmHmq16z8jI1f9sHii6.VdcG2Jorw8hEk4tr/uqr9fSPkLBHxKG'),
	('ETU2', 'Aliquid', 'Perferendis', 'hiratiw409@djpich.com', '0656987459', '2023-03-29 00:21:55', 'images/default.jpg', '$2y$10$Npk0ZYE35r0Bv9Na9LllB.aUGs1.Cnw1Hh78xfyRmqFLPmTuC4AtS'),
	('ETU3', 'Sunt', 'Facere', 'golahav828@djpich.com', '0656987459', '2023-03-29 03:16:10', 'images/default.jpg', '$2y$10$S6eg372X.wxgHpLHq7IAR.dGw6KrR4ETf4Rq96TvLolx7jSOevUBO'),
	('ETU4', 'Rerum', 'Tenetur', 'vigino1608@djpich.com', '0656987459', '2023-03-29 03:16:57', 'images/default.jpg', '$2y$10$vvjTvK9kMQJBNz5OvWn6e.Xy/fpAnrNtJVet59HrGK7pdLf8B5iuu'),
	('ETU5', 'Cumque', 'Consequuntur', 'diretam167@cyclesat.com', '0659874365', '2023-03-29 03:18:17', 'images/default.jpg', '$2y$10$0T8SO6ZaQCOV4gbgj5AqiO1udnpfcTirg0QLiooPhCJJ.1I/FLige'),
	('ETU6', 'Rem culpa itaque pr', 'In veniam sed venia', 'wadavis226@byorby.com', '0653269856', '2023-06-23 16:38:08', 'images/default.jpg', '$2y$10$HYEIMLCMqvwWuVMH93FVeuMnx5rhiFKIWJTtE83VVl/kTEs9RWuxm');
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
  `code_formateur` varchar(50) DEFAULT NULL,
  `specialiteId` int(11) NOT NULL,
  PRIMARY KEY (`id_formateur`),
  KEY `FK_formateurs_categories` (`specialiteId`),
  CONSTRAINT `FK_formateurs_categories` FOREIGN KEY (`specialiteId`) REFERENCES `categories` (`id_categorie`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.formateurs: ~5 rows (approximately)
/*!40000 ALTER TABLE `formateurs` DISABLE KEYS */;
INSERT INTO `formateurs` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `email_formateur`, `tel_formateur`, `date_creation_formateur`, `img_formateur`, `mot_de_passe`, `paypalMail`, `biography`, `balance`, `code_formateur`, `specialiteId`) VALUES
	('FOR1', 'John', 'Smith', 'nolepi2119@necktai.com', '0695038290', '2023-03-27 00:56:47', 'images/default.jpg', '$2y$10$3wy.h8bMrjIy.kRvN5TyIeGEMkH.vnk307xSnHDWHAFANeS2sYdPC', 'vehenafit@mailinator.com', 'Tenetur qui quia exe Tenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exeTenetur qui quia exe', 0, 'IT31A84971127401268FD18E52Z0', 9),
	('FOR2', 'Mohcine', 'Likram', 'gaweda1412@dogemn.com', '0653147965', '2023-03-29 03:10:57', 'images/default.jpg', '$2y$10$6DC9YjAy3opeYuc4mVBUbuoFdHpvbgHDdu2KvvCHF5SPsC5GuX/sG', 'heqo@mailinator.com', 'Nulla aut iste id om Nulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id omNulla aut iste id om', 0, 'IT31AFRF6Z84G540YZ575DJ28BP4', 4),
	('FOR3', 'Possimus', 'Sed', 'sitoga7418@dogemn.com', '0656987459', '2023-03-29 03:12:22', 'images/default.jpg', '$2y$10$1rxvRyix3pgRGkSKq4s3aux7VGJcbjY2htQe5p.VVBR5Oq/ZpCYoG', 'sitoga7418@dogemn.com', 'Forget about spam, advertising mailings, hacking and attacking robots. Keep your real mailbox clean and secure. Temp Mail provides temporary, secure, anonymous, free, disposable email address.', 0, 'FE125EZ6F7112740YZ575DJ28BP4', 8),
	('FOR4', 'Aspernatur ', 'Labore ', 'mopen22427@djpich.com', '0656987459', '2023-03-29 03:13:29', 'images/default.jpg', '$2y$10$Ko0Qo07qAlfX3cG540XlmO13BwE/itm0Yw97omCnijH2zCk4Dup3a', 'mopen22427@djpich.com', 'Forget about spam, advertising mailings, hacking and attacking robots. Keep your real mailbox clean and secure. Temp Mail provides temporary, secure, anonymous, free, disposable email address.', 0, 'IT31A84971RV1Z8RE1DZR41F5Z88', 10),
	('FOR5', 'Velit', 'Expedita ', 'japeva9885@cyclesat.com', '0653147965', '2023-03-29 03:14:44', 'images/default.jpg', '$2y$10$NEA.INSJj7vH735t4bmamOzh4DiaVdVzytDsRyAy.LIEhQ4/gSC4i', 'japeva9885@cyclesat.com', 'Forget about spam, advertising mailings, hacking and attacking robots. Keep your real mailbox clean and secure. Temp Mail provides temporary, secure, anonymous, free, disposable email address.', 0, '4681ff0ec092a166e25dc20bc6a630fe4d30ba93', 7);
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
  `etat_formation` varchar(255) DEFAULT 'public',
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

-- Dumping data for table maha.inscriptions: ~17 rows (approximately)
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
                    and formations.etat_formation = "public"
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
                    and formations.etat_formation = "public"
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
                    and formations.etat_formation = "public"
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

-- Dumping data for table maha.likes: ~11 rows (approximately)
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

-- Dumping data for table maha.notifications: ~14 rows (approximately)
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table maha.previews: ~11 rows (approximately)
/*!40000 ALTER TABLE `previews` DISABLE KEYS */;
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

-- Dumping data for table maha.tablefilter: ~9 rows (approximately)
/*!40000 ALTER TABLE `tablefilter` DISABLE KEYS */;
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
	(1, 'images/maha.png', 'images/banner_home.jpg');
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

-- Dumping data for table maha.videos: ~81 rows (approximately)
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
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

-- Dumping data for table maha.watched: ~17 rows (approximately)
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
