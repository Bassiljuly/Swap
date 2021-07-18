-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 17, 2021 at 01:43 PM
-- Server version: 8.0.15
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swap`
--

-- --------------------------------------------------------

--
-- Table structure for table `annonce`
--

CREATE TABLE `annonce` (
  `id_annonce` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description_courte` varchar(255) NOT NULL,
  `description_longue` text NOT NULL,
  `prix` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `membre_id` int(3) NOT NULL,
  `photo_id` int(3) NOT NULL,
  `categorie_id` int(3) NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titre`, `description_courte`, `description_longue`, `prix`, `photo`, `pays`, `ville`, `adresse`, `cp`, `membre_id`, `photo_id`, `categorie_id`, `date_enregistrement`) VALUES
(29, 'location appartement', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 1550, '798-appart1.1.webp', 'france', 'creteil', 'rue picabia', 94000, 3, 130, 17, '2021-06-13 14:38:57'),
(39, 'iphone 12', 'apple iphone 12 164 giga', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 800, '821-Ipohne12.jpeg', 'france', 'Grenoble', 'rue du puit', 38000, 4, 140, 22, '2021-06-19 13:18:06'),
(40, 'toyota chr', '160000 km essence', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 21000, '149-toyota1.jpeg', 'france', 'Créteil', 'rue du moulin', 94000, 4, 141, 20, '2021-06-19 13:24:30'),
(41, 'samsung s9', 'Telephone samsung S9 ancien modèle neuf', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 700, '263-samsungs9-1.webp', 'France', 'Créteil', 'rue du moulin', 94000, 3, 142, 22, '2021-07-04 23:21:39'),
(42, 'ipad', 'ipad nouvelle generation', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 450, '244-ipad2.png', 'france', 'Boisemont', '14 rue des pij', 95000, 12, 143, 22, '2021-07-04 23:33:25'),
(44, 'ford puma', 'ford puma 110000km', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 19500, '992-fordpuma.jpeg', 'france', 'Baudre', '6 rue des champs', 50000, 3, 145, 20, '2021-07-11 17:20:50'),
(46, 'basket nike', 'basket nike taille 37 neuves', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 110, '826-nikereact.jpg', 'france', 'paris', '24 Rue des vignoles', 75020, 3, 147, 26, '2021-07-17 14:05:05');

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `motcles` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `titre`, `motcles`) VALUES
(17, 'immobilier', 'ventes locations colocations bureaux logement'),
(19, 'emploi', 'offres d\'emploi'),
(20, 'vehicule', 'voitures motos bateaux vélos équipement'),
(21, 'vacances', 'camping hotels hôte'),
(22, 'multimedia', 'Jeu vidéo Informatique Images son Téléphone'),
(23, 'Loisirs', 'Films Musique Livre'),
(24, 'Services', 'Prestations de services Evènements'),
(25, 'Maison', 'Ameublement Electroménager Bricolage Jardinage'),
(26, 'Vetements', 'Jean Chemise Robe Chaussure'),
(27, 'Autres', '');

-- --------------------------------------------------------

--
-- Table structure for table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(3) NOT NULL,
  `membre_id` int(3) NOT NULL,
  `annonce_id` int(3) NOT NULL,
  `commentaire` text NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  `reponse` text CHARACTER SET utf8mb4 ,
  `membre_id_2` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `membre_id`, `annonce_id`, `commentaire`, `date_enregistrement`, `reponse`, `membre_id_2`) VALUES
(3, 3, 29, 'super vente', '2021-06-24 20:08:00', '', 2),
(4, 12, 40, 'Plus d\'infos?', '2021-07-14 22:36:52', 'Oui contactez moi au 0609098909', 4),
(5, 4, 44, 'Pourrais-je avoir plus d\'info? ', '2021-07-14 22:48:53', NULL, 3),
(6, 3, 42, 'Le prix est-il négociable?', '2021-07-17 14:11:21', NULL, 12),
(7, 3, 39, 'Bonjour je souhaite des infos supplementaires', '2021-07-17 15:07:44', NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `statut` int(1) NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `telephone`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(2, 'sarah', '$2y$10$6j1MEgDgBc4IRTjT6zDK/uRwOaB5ugIXzhV2RAcD9wW68LI7CcmI.', 'bass', 'sarah', '0606070809', 'sarah@gmail.com', 'f', 1, '2021-06-03 19:18:23'),
(3, 'creaswap', '$2y$10$BFYwt9pcK0ulV2QKrvVj9.kT9GwwBETOQLAiWelZcUWEM5n5G88Tm', 'administrateur', 'crea', '0620098070', 'admin@gmail.com', 'f', 2, '2021-06-03 19:29:18'),
(4, 'swapeur', '$2y$10$z2d5kunsuceUKi9mKIWQ8.ZfR0vachAzI57uX.XwzerTC8KwwAoIO', 'dupont', 'justine', '0600908787', 'dupont@gmail.com', 'm', 1, '2021-06-03 19:31:51'),
(12, 'sergio', '$2y$10$3ADFw7oVWMq2aE3uhKu8jeowqk8MIkMczuv.eCRCAONTBdYxrIMr.', 'sacramento', 'sergio', '0629720039', 'test@mail.fr', 'm', 1, '2021-06-07 16:41:42');

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `id_note` int(3) NOT NULL,
  `membre_id1` int(3) NOT NULL,
  `membre_id2` int(3) NOT NULL,
  `note` int(3) NOT NULL,
  `avis` text NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`id_note`, `membre_id1`, `membre_id2`, `note`, `avis`, `date_enregistrement`) VALUES
(1, 2, 4, 3, 'Très bon service', '2021-05-18 00:00:00'),
(2, 3, 3, 3, 'je valide totalement le vendeur', '2021-06-24 18:32:15'),
(3, 4, 3, 4, 'Tres bon vendeur !!', '2021-06-24 18:38:26'),
(4, 4, 3, 3, 'vendeur agréable', '2021-06-24 18:56:21'),
(6, 3, 12, 4, 'Vendeur serieux, je recommande !', '2021-07-11 16:48:01'),
(7, 12, 4, 3, 'sympatique vendeur', '2021-07-14 22:30:49'),
(8, 3, 12, 5, 'Excellent, je recommande !', '2021-07-17 14:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(3) NOT NULL,
  `photo1` varchar(255) NOT NULL,
  `photo2` varchar(255) NOT NULL,
  `photo3` varchar(255) NOT NULL,
  `photo4` varchar(255) NOT NULL,
  `photo5` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`id_photo`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`) VALUES
(130, '798-appart1.1.webp', '166-appart1.2.webp', '109-appart1.3.webp', '', ''),
(138, '802-jordan1jaune.jpeg', '', '', '', ''),
(139, '864-airforce1blanche.jpeg', '', '', '', ''),
(140, '821-Ipohne12.jpeg', '217-iphone12.jpeg', '', '', ''),
(141, '149-toyota1.jpeg', '656-toyota2.jpeg', '102-toyota3.jpeg', '', ''),
(142, '263-samsungs9-1.webp', '650-samsungs9-2.webp', '', '', ''),
(143, '244-ipad2.png', '885-ipad3.png', '', '', ''),
(145, '992-fordpuma.jpeg', '', '', '', ''),
(147, '826-nikereact.jpg', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id_annonce`),
  ADD KEY `membre_id` (`membre_id`),
  ADD KEY `photo_id` (`photo_id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `membre_id` (`membre_id`),
  ADD KEY `annonce_id` (`annonce_id`),
  ADD KEY `membre_id_2` (`membre_id_2`);

--
-- Indexes for table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `membre_id1` (`membre_id1`),
  ADD KEY `membre_id2` (`membre_id2`);

--
-- Indexes for table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `id_note` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_ibfk_3` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id_photo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id_annonce`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `commentaire_ibfk_3` FOREIGN KEY (`membre_id_2`) REFERENCES `membre` (`id_membre`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`membre_id1`) REFERENCES `membre` (`id_membre`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`membre_id2`) REFERENCES `membre` (`id_membre`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
