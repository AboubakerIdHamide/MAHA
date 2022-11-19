-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2022 at 08:39 AM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int(11) NOT NULL,
  `nom_categorie` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `id_etudiant` int(11) NOT NULL,
  `id_video` int(11) NOT NULL,
  `commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `etudiants`
--

CREATE TABLE `etudiants` (
  `id_etudiant` int(11) NOT NULL,
  `nom_etudiant` varchar(50) NOT NULL,
  `prenom_etudiant` varchar(50) NOT NULL,
  `email_etudiant` varchar(100) NOT NULL,
  `tel_etudiant` varchar(15) DEFAULT NULL,
  `date_creation_etudiant` datetime DEFAULT current_timestamp(),
  `img_etudiant` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` int(11) NOT NULL,
  `userFolderId` int(11) DEFAULT NULL,
  `imagesId` int(11) DEFAULT NULL,
  `videosId` int(11) DEFAULT NULL,
  `ressourcesId` int(11) DEFAULT NULL,
  `userEmail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `userFolderId`, `imagesId`, `videosId`, `ressourcesId`, `userEmail`) VALUES
(25, 2147483647, 2147483647, 2147483647, 2147483647, 'idhamidea@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `formateurs`
--

CREATE TABLE `formateurs` (
  `id_formateur` int(11) NOT NULL,
  `nom_formateur` varchar(50) NOT NULL,
  `prenom_formateur` varchar(50) NOT NULL,
  `email_formateur` varchar(100) NOT NULL,
  `tel_formateur` varchar(15) DEFAULT NULL,
  `date_creation_formateur` datetime DEFAULT current_timestamp(),
  `img_formateur` varchar(200) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `paypalMail` varchar(250) DEFAULT NULL,
  `biography` text DEFAULT NULL,
  `specialiteId` int(11) DEFAULT NULL,
  `balance` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `formateurs`
--

INSERT INTO `formateurs` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `email_formateur`, `tel_formateur`, `date_creation_formateur`, `img_formateur`, `mot_de_passe`, `paypalMail`, `biography`, `specialiteId`, `balance`) VALUES
(8, 'idhamide', 'aboubaker', 'idhamidea@gmail.com', '0659854779', '2022-11-17 13:10:27', 'images/default.jpg', '$2y$10$EMqBaPplHZ0j29fNT2jse.E/.Spc/P21DigccNnE.D2eIGrAsXSA6', 'idhamidea@gmail.com', 'qzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzoqzjzsozosjzo', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `formations`
--

CREATE TABLE `formations` (
  `id_formation` int(11) NOT NULL,
  `niveau_formation` int(11) NOT NULL,
  `id_formateur` int(11) NOT NULL,
  `categorie` int(11) NOT NULL,
  `nom_formation` varchar(100) NOT NULL,
  `image_formation` varchar(200) NOT NULL,
  `mass_horaire` time NOT NULL,
  `date_creation_formation` datetime DEFAULT current_timestamp(),
  `prix_formation` float(8,2) DEFAULT NULL,
  `description` text NOT NULL,
  `id_langue` int(11) DEFAULT NULL,
  `likes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `id_formation` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `id_formateur` int(11) NOT NULL,
  `date_inscription` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `langues`
--

CREATE TABLE `langues` (
  `id_langue` int(11) NOT NULL,
  `nom_langue` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `langues`
--

INSERT INTO `langues` (`id_langue`, `nom_langue`) VALUES
(1, 'Français'),
(2, 'Anglais'),
(3, 'Espagnol');

-- --------------------------------------------------------

--
-- Table structure for table `niveaux`
--

CREATE TABLE `niveaux` (
  `id_niveau` int(11) NOT NULL,
  `nom_niveau` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `niveaux`
--

INSERT INTO `niveaux` (`id_niveau`, `nom_niveau`) VALUES
(1, 'débutant'),
(2, 'intermédiaire'),
(3, 'avancé');

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
  `miniature_video` varchar(200) DEFAULT NULL,
  `description_video` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD KEY `id_etudiant` (`id_etudiant`),
  ADD KEY `id_video` (`id_video`);

--
-- Indexes for table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id_etudiant`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `formateurs`
--
ALTER TABLE `formateurs`
  ADD PRIMARY KEY (`id_formateur`),
  ADD KEY `specialiteId` (`specialiteId`);

--
-- Indexes for table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id_formation`),
  ADD KEY `niveau_formation` (`niveau_formation`),
  ADD KEY `id_formateur` (`id_formateur`),
  ADD KEY `categorie` (`categorie`),
  ADD KEY `id_langue` (`id_langue`);

--
-- Indexes for table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD KEY `id_formation` (`id_formation`),
  ADD KEY `id_etudiant` (`id_etudiant`),
  ADD KEY `id_formateur` (`id_formateur`);

--
-- Indexes for table `langues`
--
ALTER TABLE `langues`
  ADD PRIMARY KEY (`id_langue`);

--
-- Indexes for table `niveaux`
--
ALTER TABLE `niveaux`
  ADD PRIMARY KEY (`id_niveau`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id_video`),
  ADD KEY `id_formation` (`id_formation`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id_etudiant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `formateurs`
--
ALTER TABLE `formateurs`
  MODIFY `id_formateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `formations`
--
ALTER TABLE `formations`
  MODIFY `id_formation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id_video` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`),
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id_video`);

--
-- Constraints for table `formateurs`
--
ALTER TABLE `formateurs`
  ADD CONSTRAINT `formateurs_ibfk_1` FOREIGN KEY (`specialiteId`) REFERENCES `categories` (`id_categorie`);

--
-- Constraints for table `formations`
--
ALTER TABLE `formations`
  ADD CONSTRAINT `formations_ibfk_1` FOREIGN KEY (`niveau_formation`) REFERENCES `niveaux` (`id_niveau`),
  ADD CONSTRAINT `formations_ibfk_2` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`),
  ADD CONSTRAINT `formations_ibfk_3` FOREIGN KEY (`categorie`) REFERENCES `categories` (`id_categorie`),
  ADD CONSTRAINT `formations_ibfk_4` FOREIGN KEY (`id_langue`) REFERENCES `langues` (`id_langue`);

--
-- Constraints for table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `inscriptions_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`),
  ADD CONSTRAINT `inscriptions_ibfk_2` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`),
  ADD CONSTRAINT `inscriptions_ibfk_3` FOREIGN KEY (`id_formateur`) REFERENCES `formateurs` (`id_formateur`);

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
