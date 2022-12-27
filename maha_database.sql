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
);

-- Dumping data for table maha.admin: ~0 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table maha.bookmarks
CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id_etudiant` varchar(255) NOT NULL,
  `id_video` int(11) NOT NULL,
  KEY `FK_bookmarks_etudiants` (`id_etudiant`),
  KEY `FK_bookmarks_videos` (`id_video`),
  CONSTRAINT `FK_bookmarks_etudiants` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_bookmarks_videos` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Dumping data for table maha.bookmarks: ~0 rows (approximately)
/*!40000 ALTER TABLE `bookmarks` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookmarks` ENABLE KEYS */;

-- Dumping structure for table maha.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int(11) NOT NULL,
  `nom_categorie` varchar(50) NOT NULL,
  PRIMARY KEY (`id_categorie`)
);

-- Dumping data for table maha.categories: ~0 rows (approximately)
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
	(12, 'Bureautique');
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
);

-- Dumping data for table maha.commentaires: ~0 rows (approximately)
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
);

-- Dumping data for table maha.etudiants: ~1 rows (approximately)
/*!40000 ALTER TABLE `etudiants` DISABLE KEYS */;
INSERT INTO `etudiants` (`id_etudiant`, `nom_etudiant`, `prenom_etudiant`, `email_etudiant`, `tel_etudiant`, `date_creation_etudiant`, `img_etudiant`, `mot_de_passe`) VALUES
	('ETU1', 'Jeffery', 'Davila', 'hegosaf874@miarr.com', '0698753625', '2022-12-26 00:37:45', '46426170488', '$2y$10$HMeh2QbWE6.1yOBiT9er9uB4aJRrQkSmJh9O5l991OvraBmXmiVUO');
/*!40000 ALTER TABLE `etudiants` ENABLE KEYS */;

-- Dumping structure for table maha.folders
CREATE TABLE IF NOT EXISTS `folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userFolderId` varchar(255) NOT NULL,
  `imagesId` varchar(255) NOT NULL,
  `videosId` varchar(255) NOT NULL,
  `ressourcesId` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Dumping data for table maha.folders: ~2 rows (approximately)
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;
INSERT INTO `folders` (`id`, `userFolderId`, `imagesId`, `videosId`, `ressourcesId`, `userEmail`) VALUES
	(1, '15751520365', '15751520480', '15751521180', '15751520899', 'dixoyi3842@miarr.com'),
	(2, '15751915041', '15751915121', '15751915354', '15751915217', 'hegosaf874@miarr.com');
/*!40000 ALTER TABLE `folders` ENABLE KEYS */;

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
);

-- Dumping data for table maha.formateurs: ~1 rows (approximately)
/*!40000 ALTER TABLE `formateurs` DISABLE KEYS */;
INSERT INTO `formateurs` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `email_formateur`, `tel_formateur`, `date_creation_formateur`, `img_formateur`, `mot_de_passe`, `paypalMail`, `biography`, `balance`, `specialiteId`) VALUES
	('FOR1', 'Will', 'Charles', 'dixoyi3842@miarr.com', '0653147965', '2022-12-25 23:32:29', '46424966074', '$2y$10$3KFSN4fybsldjy7Aww9IWOb06QIWBmUKMk.Haym0a/LTkYmP8GgoO', 'dixoyi3842@miarr.com', 'Lorem ipsum dolor sit amet. Non saepe alias id voluptatem sequi cum illo eius qui necessitatibus inventore rem voluptas corporis id aspernatur illo. Ad beatae quaerat aut voluptate accusantium et Quis quasi ut possimus expedita. Qui nostrum ipsam est sunt eligendi ab accusamus illum sit adipisci velit sit explicabo molestiae est maiores totam qui impedit voluptas.', 0, 5);
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
);

-- Dumping data for table maha.formations: ~1 rows (approximately)
/*!40000 ALTER TABLE `formations` DISABLE KEYS */;
INSERT INTO `formations` (`id_formation`, `niveau_formation`, `id_formateur`, `categorie`, `nom_formation`, `image_formation`, `mass_horaire`, `date_creation_formation`, `prix_formation`, `description`, `id_langue`, `likes`) VALUES
	(1, 2, 'FOR1', 5, 'Cours Complet PHP et MYSQL', '46425417951', '11:58:00', '2022-12-25 23:58:33', 45.00, 'Lorem ipsum dolor sit amet. Et internos dolores et inventore cupiditate ex dolorum officia sit facilis deserunt nam voluptas consequatur. Sit vitae similique et tempore eveniet qui minima deleniti. Id repudiandae quia ut ipsam galisum ut corporis autem.', 1, 1);
/*!40000 ALTER TABLE `formations` ENABLE KEYS */;

-- Dumping structure for table maha.inscriptions
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id_inscription` int(11) NOT NULL AUTO_INCREMENT,
  `id_formation` int(11) NOT NULL,
  `id_etudiant` varchar(255) NOT NULL,
  `id_formateur` varchar(255) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_inscription`),
  KEY `id_formation` (`id_formation`),
  KEY `FK_inscriptions_formateurs` (`id_formateur`),
  KEY `FK_inscriptions_etudiants` (`id_etudiant`),
  CONSTRAINT `FK_inscriptions_etudiants` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_inscriptions_formateurs` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `inscriptions_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`) ON DELETE NO ACTION ON UPDATE CASCADE
);

-- Dumping data for table maha.inscriptions: ~1 rows (approximately)
/*!40000 ALTER TABLE `inscriptions` DISABLE KEYS */;
INSERT INTO `inscriptions` (`id_inscription`, `id_formation`, `id_etudiant`, `id_formateur`, `date_inscription`) VALUES
	(1, 1, 'ETU1', 'FOR1', '2022-12-26 00:39:42');
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
  `nom_langue` varchar(30) NOT NULL,
  PRIMARY KEY (`id_langue`)
);

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
);

-- Dumping data for table maha.likes: ~1 rows (approximately)
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` (`etudiant_id`, `formation_id`) VALUES
	('ETU1', 1);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;

-- Dumping structure for table maha.niveaux
CREATE TABLE IF NOT EXISTS `niveaux` (
  `id_niveau` int(11) NOT NULL,
  `nom_niveau` varchar(50) NOT NULL,
  PRIMARY KEY (`id_niveau`)
);

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
);

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
);

-- Dumping data for table maha.previews: ~1 rows (approximately)
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
);

-- Dumping data for table maha.request_payment: ~0 rows (approximately)
/*!40000 ALTER TABLE `request_payment` DISABLE KEYS */;
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
);

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
);

-- Dumping data for table maha.videos: ~27 rows (approximately)
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` (`id_video`, `id_formation`, `nom_video`, `url_video`, `duree_video`, `description_video`, `order_video`, `watched`) VALUES
	(1, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 1_27] - Introduction au PhP', '46425600486', '00:09:46', 'DESC1', 1, 0),
	(2, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 2_27] - Préparer son environnement de travail', '46425600680', '00:05:01', 'DESC2', 2, 0),
	(3, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 3_27] - Les bases du PhP', '46302284000', '00:27:16', 'DESC3', 3, 0),
	(4, 1, 'Tutoriel _ Cours Complet PhP & MySQL  [Chapitre 4_27] - Les variables en PhP', '46425599851', '00:32:36', 'DESC4', 4, 0),
	(5, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 5_27] - Les conditions en PhP', '46302395707', '00:58:42', 'DESC5', 5, 0),
	(6, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 6_27] - Les boucles en PhP', '46302297248', '00:15:39', 'DESC6', 6, 0),
	(7, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 7_27] - Les tableaux en PhP', '46302355089', '00:45:21', 'DESC7', 7, 0),
	(8, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 8_27] - Les fonctions en PhP', '46302293004', '00:19:09', 'DESC8', 8, 0),
	(9, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 9_27] - Les fonctions relatives aux string', '46302275349', '00:33:09', 'DESC9', 9, 0),
	(10, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 10_27] - Les fonctions affectant les array', '46302295460', '01:02:08', 'DESC10', 10, 0),
	(11, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 11_27] - Les fonctions relatives à la date en PhP', '46302279151', '00:29:36', 'DESC11', 11, 0),
	(12, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 12_27] - Les constantes en PhP', '46302264177', '00:17:10', 'DESC12', 12, 0),
	(13, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 13_27] - Les formulaires en PhP', '46302269203', '00:32:58', 'DESC13', 13, 0),
	(14, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 14_27] - Les instructions include et require', '46302302904', '00:06:55', 'DESC14', 14, 0),
	(15, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 15_27] - Opérations sur les fichiers en PhP', '46302317792', '00:21:32', 'DESC15', 15, 0),
	(16, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 16_27] - Variables superglobales en PhP', '46425599585', '00:28:51', 'DESC16', 16, 0),
	(17, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 17_27] - Les bases de la POO en PhP', '46302264928', '00:23:22', 'DESC17', 17, 0),
	(18, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 18_27] - Gestion des erreurs en PhP', '46302271756', '00:14:52', 'DESC18', 18, 0),
	(19, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 19_27] - Découverte de MySQL, phpMyAdmin et des BDD', '46302295006', '00:18:49', 'DESC19', 19, 0),
	(20, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Ch 20_27] - Connexion à MySQL et création de BDD', '46302287432', '00:23:21', 'DESC20', 20, 0),
	(21, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 21_27] - Insérer des données dans une BDD via PhP', '46302266720', '00:22:05', 'DESC21', 21, 0),
	(22, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Chapitre 22_27] - Sélection de données dans une BDD', '46302347337', '00:19:09', 'DESC22', 22, 0),
	(23, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Ch 23_27] - MàJ et suppression de données dans une BDD', '46425600452', '00:11:18', 'DESC23', 23, 0),
	(24, 1, "Tutoriel _ Cours Complet PhP & MySQL [Chapitre 24_27] - Les jointures SQL et l'UNION", '46302352492', '00:45:39', 'DESC24', 24, 0),
	(25, 1, 'Tutoriel _ Cours Complet PhP & MySQL - [Chapitre 25_27] - Les fonctions SQL', '46302355185', '00:19:39', 'DESC25', 25, 0),
	(26, 1, 'Tutoriel _ Cours Complet PhP & MySQL - [Chapitre 26_27] - Les filtres PhP', '46302280631', '00:37:53', 'DESC26', 26, 0),
	(27, 1, 'Tutoriel _ Cours Complet PhP & MySQL [Ch 27_27] - Les expressions régulières', '46302347701', '00:36:04', 'DESC27', 27, 0);
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;

-- Dumping structure for table maha.watched
CREATE TABLE IF NOT EXISTS `watched` (
  `id_etudiant` varchar(255) NOT NULL,
  `id_video` int(11) NOT NULL,
  KEY `FK_watched_etudiants` (`id_etudiant`),
  KEY `FK_watched_videos` (`id_video`),
  CONSTRAINT `FK_watched_etudiants` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_watched_videos` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Dumping data for table maha.watched: ~0 rows (approximately)
/*!40000 ALTER TABLE `watched` DISABLE KEYS */;
/*!40000 ALTER TABLE `watched` ENABLE KEYS */;

-- Dumping structure for trigger maha.calcDuree

DELIMITER //
CREATE TRIGGER `calcDuree` AFTER INSERT ON `videos` FOR EACH ROW BEGIN
	UPDATE formations f SET mass_horaire=
    (SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(v.duree_video))) 
    FROM videos v WHERE v.id_formation=NEW.id_formation)
    WHERE f.id_formation=NEW.id_formation;
END//
DELIMITER ;


-- Dumping structure for trigger maha.calcDureeOnDelete

DELIMITER //
CREATE TRIGGER `calcDureeOnDelete` AFTER DELETE ON `videos` FOR EACH ROW BEGIN
	UPDATE formations f SET mass_horaire=
    (SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(v.duree_video))) 
    FROM videos v WHERE v.id_formation=OLD.id_formation)
    WHERE f.id_formation=OLD.id_formation;
END//
DELIMITER ;


-- Dumping structure for trigger maha.calcDureeOnUpdate

DELIMITER //
CREATE TRIGGER `calcDureeOnUpdate` AFTER UPDATE ON `videos` FOR EACH ROW BEGIN
	UPDATE formations f SET mass_horaire=
    (SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(v.duree_video))) 
    FROM videos v WHERE v.id_formation=NEW.id_formation)
    WHERE f.id_formation=NEW.id_formation;
END//
DELIMITER ;


-- Dumping structure for trigger maha.calcLikeDelete

DELIMITER //
CREATE TRIGGER `calcLikeDelete` AFTER DELETE ON `likes` FOR EACH ROW BEGIN
	DECLARE likesCount int DEFAULT 0;
    SET likesCount=(SELECT count(*) FROM likes WHERE formation_id=OLD.formation_id);
	UPDATE formations SET likes=likesCount WHERE id_formation=OLD.formation_id;
END//
DELIMITER ;


-- Dumping structure for trigger maha.calcLikeInsert

DELIMITER //
CREATE TRIGGER `calcLikeInsert` AFTER INSERT ON `likes` FOR EACH ROW BEGIN
	DECLARE likesCount int DEFAULT 0;
    SET likesCount=(SELECT count(*) FROM likes WHERE formation_id=NEW.formation_id);
	UPDATE formations f SET likes=likesCount WHERE id_formation=NEW.formation_id;
END//
DELIMITER ;


-- Dumping structure for trigger maha.commentaires_after_insert

DELIMITER //
CREATE TRIGGER `commentaires_after_insert` AFTER INSERT ON `commentaires` FOR EACH ROW BEGIN
	INSERT INTO notifications(id_commentaire)
	VALUES (NEW.id_commentaire);
END//
DELIMITER ;


-- Dumping structure for trigger maha.etudiants_before_insert

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


-- Dumping structure for trigger maha.formateurs_before_insert

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


-- Dumping structure for trigger maha.request_payment_after_update

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


/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
