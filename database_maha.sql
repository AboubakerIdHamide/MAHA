-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2023 at 04:42 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maha`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nom_admin` varchar(50) NOT NULL,
  `prenom_admin` varchar(50) NOT NULL,
  `email_admin` varchar(100) NOT NULL,
  `img_admin` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `balance` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id_etudiant` varchar(255) NOT NULL,
  `id_video` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int(11) NOT NULL,
  `nom_categorie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `commentaires`
--

CREATE TABLE `commentaires` (
  `id_commentaire` int(11) NOT NULL,
  `id_video` int(11) NOT NULL,
  `from_user` varchar(255) NOT NULL,
  `to_user` varchar(255) NOT NULL,
  `type_user` varchar(20) NOT NULL,
  `commentaire` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `commentaires`
--
DELIMITER $$
CREATE TRIGGER `commentaires_after_insert` AFTER INSERT ON `commentaires` FOR EACH ROW BEGIN
	INSERT INTO notifications(id_commentaire)
	VALUES (NEW.id_commentaire);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `etudiants`
--

CREATE TABLE `etudiants` (
  `id_etudiant` varchar(255) NOT NULL,
  `nom_etudiant` varchar(50) NOT NULL,
  `prenom_etudiant` varchar(50) NOT NULL,
  `email_etudiant` varchar(100) NOT NULL,
  `tel_etudiant` varchar(15) DEFAULT NULL,
  `date_creation_etudiant` datetime NOT NULL DEFAULT current_timestamp(),
  `img_etudiant` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `etudiants`
--
DELIMITER $$
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
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `formateurs`
--

CREATE TABLE `formateurs` (
  `id_formateur` varchar(255) NOT NULL,
  `nom_formateur` varchar(50) NOT NULL,
  `prenom_formateur` varchar(50) NOT NULL,
  `email_formateur` varchar(100) NOT NULL,
  `tel_formateur` varchar(15) DEFAULT NULL,
  `date_creation_formateur` datetime NOT NULL DEFAULT current_timestamp(),
  `img_formateur` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `paypalMail` varchar(250) NOT NULL,
  `biography` text NOT NULL,
  `balance` float NOT NULL DEFAULT 0,
  `specialiteId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `formateurs`
--
DELIMITER $$
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
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `formations`
--

CREATE TABLE `formations` (
  `id_formation` int(11) NOT NULL,
  `niveau_formation` int(11) NOT NULL,
  `id_formateur` varchar(255) NOT NULL,
  `categorie` int(11) NOT NULL,
  `nom_formation` varchar(100) NOT NULL,
  `image_formation` varchar(200) NOT NULL,
  `mass_horaire` time NOT NULL,
  `date_creation_formation` datetime NOT NULL DEFAULT current_timestamp(),
  `prix_formation` float(8,2) NOT NULL,
  `description` text NOT NULL,
  `id_langue` int(11) DEFAULT 1,
  `likes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `id_inscription` int(11) NOT NULL,
  `id_formation` int(11) NOT NULL,
  `id_etudiant` varchar(255) NOT NULL,
  `id_formateur` varchar(255) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `langues`
--

CREATE TABLE `langues` (
  `id_langue` int(11) NOT NULL,
  `nom_langue` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `langues`
--

INSERT INTO `langues` (`id_langue`, `nom_langue`) VALUES
(1, 'Français'),
(2, 'Anglais'),
(3, 'Espagnol'),
(4, '???????');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `etudiant_id` varchar(255) NOT NULL,
  `formation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `likes`
--
DELIMITER $$
CREATE TRIGGER `calcLikeDelete` AFTER DELETE ON `likes` FOR EACH ROW BEGIN
	DECLARE likesCount int DEFAULT 0;
    SET likesCount=(SELECT count(*) FROM likes WHERE formation_id=OLD.formation_id);
	UPDATE formations SET likes=likesCount WHERE id_formation=OLD.formation_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calcLikeInsert` AFTER INSERT ON `likes` FOR EACH ROW BEGIN
	DECLARE likesCount int DEFAULT 0;
    SET likesCount=(SELECT count(*) FROM likes WHERE formation_id=NEW.formation_id);
	UPDATE formations f SET likes=likesCount WHERE id_formation=NEW.formation_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `niveaux`
--

CREATE TABLE `niveaux` (
  `id_niveau` int(11) NOT NULL,
  `nom_niveau` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `niveaux`
--

INSERT INTO `niveaux` (`id_niveau`, `nom_niveau`) VALUES
(1, 'débutant'),
(2, 'intermédiaire'),
(3, 'avancé');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id_notification` int(11) NOT NULL,
  `id_commentaire` int(11) NOT NULL,
  `etat_notification` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `previews`
--

CREATE TABLE `previews` (
  `id_formation` int(11) NOT NULL,
  `id_video` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_payment`
--

CREATE TABLE `request_payment` (
  `id_payment` int(11) NOT NULL,
  `id_formateur` varchar(255) NOT NULL,
  `request_prix` float NOT NULL,
  `date_request` datetime NOT NULL DEFAULT current_timestamp(),
  `etat_request` varchar(10) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `request_payment`
--
DELIMITER $$
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
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tablefilter`
--

CREATE TABLE `tablefilter` (
  `IdFormation` int(11) DEFAULT NULL,
  `imgFormation` varchar(200) DEFAULT NULL,
  `duree` time DEFAULT NULL,
  `idCategore` int(11) DEFAULT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `nomFormation` varchar(100) DEFAULT NULL,
  `prix` float DEFAULT NULL,
  `description` text DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id_video` int(11) NOT NULL,
  `id_formation` int(11) NOT NULL,
  `nom_video` varchar(100) NOT NULL,
  `url_video` varchar(200) NOT NULL,
  `duree_video` time NOT NULL,
  `description_video` text NOT NULL,
  `order_video` int(11) DEFAULT 999,
  `watched` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `videos`
--
DELIMITER $$
CREATE TRIGGER `calcDuree` AFTER INSERT ON `videos` FOR EACH ROW BEGIN
	UPDATE formations f SET mass_horaire=
    (SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(v.duree_video))) 
    FROM videos v WHERE v.id_formation=NEW.id_formation)
    WHERE f.id_formation=NEW.id_formation;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calcDureeOnDelete` AFTER DELETE ON `videos` FOR EACH ROW BEGIN
	UPDATE formations f SET mass_horaire=
    (SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(v.duree_video))) 
    FROM videos v WHERE v.id_formation=OLD.id_formation)
    WHERE f.id_formation=OLD.id_formation;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calcDureeOnUpdate` AFTER UPDATE ON `videos` FOR EACH ROW BEGIN
	UPDATE formations f SET mass_horaire=
    (SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(v.duree_video))) 
    FROM videos v WHERE v.id_formation=NEW.id_formation)
    WHERE f.id_formation=NEW.id_formation;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `watched`
--

CREATE TABLE `watched` (
  `id_etudiant` varchar(255) NOT NULL,
  `id_video` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`) USING BTREE;

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD KEY `FK_bookmarks_etudiants` (`id_etudiant`),
  ADD KEY `FK_bookmarks_videos` (`id_video`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id_commentaire`) USING BTREE,
  ADD KEY `id_video` (`id_video`) USING BTREE;

--
-- Indexes for table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id_etudiant`);

--
-- Indexes for table `formateurs`
--
ALTER TABLE `formateurs`
  ADD PRIMARY KEY (`id_formateur`),
  ADD KEY `FK_formateurs_categories` (`specialiteId`);

--
-- Indexes for table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id_formation`),
  ADD KEY `niveau_formation` (`niveau_formation`),
  ADD KEY `categorie` (`categorie`),
  ADD KEY `id_langue` (`id_langue`),
  ADD KEY `FK_formations_formateurs` (`id_formateur`);

--
-- Indexes for table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`id_inscription`),
  ADD KEY `id_formation` (`id_formation`),
  ADD KEY `FK_inscriptions_formateurs` (`id_formateur`),
  ADD KEY `FK_inscriptions_etudiants` (`id_etudiant`);

--
-- Indexes for table `langues`
--
ALTER TABLE `langues`
  ADD PRIMARY KEY (`id_langue`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD KEY `fkLikes2` (`formation_id`),
  ADD KEY `FK_likes_etudiants` (`etudiant_id`);

--
-- Indexes for table `niveaux`
--
ALTER TABLE `niveaux`
  ADD PRIMARY KEY (`id_niveau`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id_notification`),
  ADD KEY `FK_notifications_commentaires` (`id_commentaire`);

--
-- Indexes for table `previews`
--
ALTER TABLE `previews`
  ADD UNIQUE KEY `id_formation` (`id_formation`) USING BTREE,
  ADD UNIQUE KEY `id_video` (`id_video`) USING BTREE;

--
-- Indexes for table `request_payment`
--
ALTER TABLE `request_payment`
  ADD PRIMARY KEY (`id_payment`),
  ADD KEY `FK_request_payment_formateurs` (`id_formateur`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id_video`),
  ADD KEY `id_formation` (`id_formation`);

--
-- Indexes for table `watched`
--
ALTER TABLE `watched`
  ADD KEY `FK_watched_etudiants` (`id_etudiant`),
  ADD KEY `FK_watched_videos` (`id_video`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id_commentaire` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formations`
--
ALTER TABLE `formations`
  MODIFY `id_formation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inscriptions`
--
ALTER TABLE `inscriptions`
  MODIFY `id_inscription` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_payment`
--
ALTER TABLE `request_payment`
  MODIFY `id_payment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id_video` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `FK_bookmarks_etudiants` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_bookmarks_videos` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE;

--
-- Constraints for table `formateurs`
--
ALTER TABLE `formateurs`
  ADD CONSTRAINT `FK_formateurs_categories` FOREIGN KEY (`specialiteId`) REFERENCES `categories` (`id_categorie`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `formations`
--
ALTER TABLE `formations`
  ADD CONSTRAINT `FK_formations_formateurs` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `formations_ibfk_1` FOREIGN KEY (`niveau_formation`) REFERENCES `niveaux` (`id_niveau`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `formations_ibfk_3` FOREIGN KEY (`categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `formations_ibfk_4` FOREIGN KEY (`id_langue`) REFERENCES `langues` (`id_langue`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `FK_inscriptions_etudiants` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_inscriptions_formateurs` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `inscriptions_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `FK_likes_etudiants` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkLikes2` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id_formation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `FK_notifications_commentaires` FOREIGN KEY (`id_commentaire`) REFERENCES `commentaires` (`id_commentaire`) ON DELETE CASCADE;

--
-- Constraints for table `previews`
--
ALTER TABLE `previews`
  ADD CONSTRAINT `previews_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`) ON DELETE CASCADE,
  ADD CONSTRAINT `previews_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE;

--
-- Constraints for table `request_payment`
--
ALTER TABLE `request_payment`
  ADD CONSTRAINT `FK_request_payment_formateurs` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`);

--
-- Constraints for table `watched`
--
ALTER TABLE `watched`
  ADD CONSTRAINT `FK_watched_etudiants` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_watched_videos` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
