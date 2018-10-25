-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 25 Octobre 2018 à 14:39
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `srg`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `Id_client` int(10) NOT NULL,
  `Nom_client` varchar(50) NOT NULL,
  `Prenom_client` varchar(50) NOT NULL,
  `Adresse_client` varchar(60) NOT NULL,
  `Cp_client` varchar(10) NOT NULL,
  `Ville_client` varchar(55) NOT NULL,
  `Tel_client` varchar(20) NOT NULL,
  `Mail_client` varchar(255) NOT NULL,
  `DateCrea_client` varchar(50) NOT NULL,
  `Prospect_client` tinyint(1) NOT NULL,
  `Id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`Id_client`, `Nom_client`, `Prenom_client`, `Adresse_client`, `Cp_client`, `Ville_client`, `Tel_client`, `Mail_client`, `DateCrea_client`, `Prospect_client`, `Id_user`) VALUES
(126, 'Test', 'Test', 'Test', '08000', 'Test ', '0200', 'fa', '2018-10-15', 0, 22),
(127, 'Test2', 'Test2', 'Test2', 'Test2', 'Test2', 'Test2', 'Test2', '2018-10-15', 0, 22);

-- --------------------------------------------------------

--
-- Structure de la table `couleurs`
--

CREATE TABLE `couleurs` (
  `Id_couleur` int(11) NOT NULL,
  `Libelle_couleur` int(11) NOT NULL,
  `Hexa_couleur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `croquis`
--

CREATE TABLE `croquis` (
  `id_croquis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE `devis` (
  `Id_devis` int(10) NOT NULL,
  `Code_devis` varchar(55) NOT NULL,
  `Date_devis` date NOT NULL,
  `Id_client` int(10) NOT NULL,
  `Id_user` int(10) NOT NULL,
  `Libelle_devis` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `familles`
--

CREATE TABLE `familles` (
  `Id_famille` int(11) NOT NULL,
  `Libelle_famille` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `Id_image` int(11) NOT NULL,
  `Chemin_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `images`
--

INSERT INTO `images` (`Id_image`, `Chemin_image`) VALUES
(1, '../public/images/test.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `liens_couleurs_matieres`
--

CREATE TABLE `liens_couleurs_matieres` (
  `Id_lien` int(11) NOT NULL,
  `Id_couleur` int(11) NOT NULL,
  `Id_matiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `lignes_devis`
--

CREATE TABLE `lignes_devis` (
  `Id_ligne` int(11) NOT NULL,
  `Code_devis` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

CREATE TABLE `matieres` (
  `Id_matiere` int(10) NOT NULL,
  `Code_matiere` varchar(50) NOT NULL,
  `Libelle_matiere` varchar(50) NOT NULL,
  `Prix_matiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `matieres`
--

INSERT INTO `matieres` (`Id_matiere`, `Code_matiere`, `Libelle_matiere`, `Prix_matiere`) VALUES
(1, 'ACROPO', 'Acropolis', 1000),
(2, 'AKOLLA', 'Akola', 850),
(3, 'AMAZONI', 'Amazonia', 650),
(4, 'AMBIAD', 'Ambiaud adouci', 0),
(5, 'AMBISA', 'Ambiaud sable', 0),
(6, 'AURORA', 'Aurora', 0),
(7, 'AZULNO', 'Azul noche', 0),
(8, 'BALMOG', 'Balmoral G elements', 0),
(9, 'BALMOP', 'Balmoral P elments', 0),
(10, 'BALTBR', 'Baltic brun', 0),
(11, 'BARARP', 'Bararp', 0),
(12, 'BLCPOR', 'Blanc porcelaine', 0),
(13, 'BLCRIS', 'Blanc cristal', 0),
(14, 'BLEUDUL', 'Bleu du lac', 0),
(15, 'BLEUSP', 'Bleu SPA', 0),
(16, 'BOHUS', 'Bohus', 0),
(17, 'BOISDE', 'Bois de rose', 0),
(18, 'BRUNPER', 'Brun perle', 0),
(19, 'CALIGOL', 'California gold', 0),
(20, 'CAPAO', 'Capao', 0),
(21, 'COLOMB', 'Colombo juparan', 0),
(22, 'COMBBO', 'Comblanchien LM', 0),
(23, 'CORCOV', 'Corcovado', 0),
(24, 'DALVA', 'Dalva', 0),
(25, 'FJORD', 'Fjord', 0),
(26, 'FLAMJUP', 'Flamingo jupara', 0),
(27, 'FONTENA', 'Pierre fontenay', 0),
(28, 'GRANVI', 'Grand violet', 0),
(29, 'GRIMON', 'Gris mondariz', 0),
(30, 'GRIMON2', 'Gris mondaris', 0),
(31, 'GRIMON3', 'Gris mon boucha', 0),
(32, 'HIMALA1', 'Himalaya b sre', 0),
(33, 'HIMALA2', 'Himalaya blue', 0),
(34, 'HIMALA3', 'Himalaya bl sre', 0),
(35, 'HIMALAY', 'Himalaya grandie', 0),
(36, 'HIMALA', 'Hymalaya blue', 0),
(37, 'INDJUP', 'Indian juparana', 0),
(38, 'JACARA', 'Jacaranda', 0),
(39, 'KAARGE', 'Karelian rouge', 0),
(40, 'KINAWA', 'Kinawa classico', 0),
(41, 'KINBEAT', 'Kinawa beatrix', 0),
(42, 'KORPI', 'Korpi', 0),
(43, 'KUPPANG', 'Kuppan green', 0),
(44, 'LABLEU.', 'Labbleuhq', 0),
(45, 'LABLEU1', 'Lableusaga', 0),
(46, 'LABLEU2', 'Labbleuhqgd', 0),
(47, 'LABLEU3', 'Lablleusagagd', 0),
(48, 'LABVER', 'Labrador vert', 0),
(49, 'LANHEL', 'Lanhelin flamme', 0),
(50, 'LAVEADO', 'Lave adouci', 0),
(51, 'LIETO', 'Lieto', 0),
(52, 'LILLAGE', 'Lilas gerais', 0),
(53, 'MACAJO', 'Maca jouba', 0),
(54, 'MAHOGA', 'Mahogany', 0),
(55, 'MANGO', 'Mango', 0),
(56, 'MARACA', 'Maracaibo', 0),
(57, 'MARBRE', 'Marbre blanc', 0),
(58, 'MASBLU', 'Mas blue', 0),
(59, 'MOUNT', 'Mountain blue', 0),
(60, 'MULTIC', 'Multicolor inde', 0),
(61, 'NAFRIC', 'Noir d''afrique', 0),
(62, 'NCHINE', 'Noir de chine', 0),
(63, 'NEWMUL', 'New multicolor', 0),
(64, 'NMARLI', 'Noir marlin', 0),
(65, 'NOIRANG', 'Noir angola', 0),
(66, 'NOIRCA', 'Noir canada', 0),
(67, 'NOIRFIN', 'Noir fin indes', 0),
(68, 'NOIRGAL', 'Noir galaxy', 0),
(69, 'NOIRSTA', 'Noir star galaxy', 0),
(70, 'NROYAL', 'Noir royal', 0),
(71, 'NZIMBA', 'Noir zimbabwe', 0),
(72, 'ONLINDA', 'Olinda', 0),
(73, 'OPAL', 'opal', 0),
(74, 'OPALINE', 'Opaline', 0),
(75, 'PARABLA', 'Paradisio black', 0),
(76, 'PARADI', 'Paradisio', 0),
(77, 'PETGRI', 'Petit gris', 0),
(78, 'PREADES', 'Pradesch green', 0),
(79, 'RCACHE', 'Rouge cachemire', 0),
(80, 'RCKART', 'Rose clarte', 0),
(81, 'RCLBRO', 'Rose clarte broche', 0),
(82, 'RCLFL', 'Rose clarte flamme', 0),
(83, 'RESPAG', 'Rose d''espagne', 0),
(84, 'RESPAGF', 'Rose d’espagne flamme', 0),
(85, 'RF', 'Rose fantasia', 0),
(86, 'ROMANT', 'Romantica', 0),
(87, 'ROSABE', 'Rose bella', 0),
(88, 'ROSALU', 'Rosa linda', 0),
(89, 'ROSRAI', 'Rose raisa', 0),
(90, 'RSARDE', 'Rose sardaigne', 0),
(91, 'SAGITAR', 'Sagitarius', 0),
(92, 'SINSTA', 'Saint salvy', 0),
(93, 'SANDY', 'Sandy', 0),
(94, 'SARDEN', 'Sardena crela', 0),
(95, 'SCHIVAC', 'Schivacashi', 0),
(96, 'SSCLAI', 'St salvy clair', 0),
(97, 'SSFONC', 'St salvy fonce', 0),
(98, 'SSMOYE', 'St salvy moyen', 0),
(99, 'STONEY', 'Stoney pink', 0),
(100, 'TADOUCI', 'Tarn adouci', 0),
(101, 'TANBRO', 'Tan brown', 0),
(102, 'TANGO', 'Tango', 0),
(103, 'TARN', 'Tarn', 0),
(104, 'TARNRO', 'Tarn royal', 0),
(105, 'TBOUCH', 'Tarn boucharde', 0),
(106, 'TBROCH', 'Tarn broche', 0),
(107, 'TCLAIR', 'Tarn clair', 0),
(108, 'TFLAME', 'Tarn flamme', 0),
(109, 'TFONCE', 'Tarn fonce', 0),
(110, 'TFROYAL', 'Tarn fonce royal', 0),
(111, 'TIFANY', 'Tifany', 0),
(112, 'TMOYEN', 'Tarn moyen', 0),
(113, 'TPIQUE', 'Tarn pique', 0),
(114, 'TSCIE', 'Tarn scie', 0),
(115, 'VERSAN', 'Vert san francisco', 0),
(116, 'VERSAV', 'Vert savaba', 0),
(117, 'VERTEUC', 'Vert eucalyptus', 0),
(118, 'VERTOL', 'Vert olive', 0),
(119, 'VERTPRI', 'Vert primavera', 0),
(120, 'VERTRO', 'Vert tropical', 0),
(121, 'VEZULI', 'Vezu - lillet', 0),
(122, 'VISCOUN', 'Viscount white', 0),
(123, 'VIZAGW', 'Vizag white', 0),
(124, 'TEST', 'Test', 1400);

-- --------------------------------------------------------

--
-- Structure de la table `pieces`
--

CREATE TABLE `pieces` (
  `Id_piece` int(11) NOT NULL,
  `Libelle_piece` varchar(55) NOT NULL,
  `Code_piece` varchar(10) NOT NULL,
  `Chemin_piece` varchar(200) DEFAULT NULL,
  `Id_image` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pieces`
--

INSERT INTO `pieces` (`Id_piece`, `Libelle_piece`, `Code_piece`, `Chemin_piece`, `Id_image`) VALUES
(84, 'Piece1', 'Code1', '../public/images/Piece1.jpg', NULL),
(85, 'Test2', 'Code2', '../public/images/Test2.jpg', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ss_familles`
--

CREATE TABLE `ss_familles` (
  `Id_ss` int(11) NOT NULL,
  `Libelle_ss` varchar(255) NOT NULL,
  `Id_famille` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tva`
--

CREATE TABLE `tva` (
  `Id_tva` int(5) NOT NULL,
  `Taux_tva` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tva`
--

INSERT INTO `tva` (`Id_tva`, `Taux_tva`) VALUES
(1, '20'),
(2, '10'),
(3, '5.5'),
(4, '2.1'),
(5, '0');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `Id_user` int(10) NOT NULL,
  `Nom_user` varchar(40) NOT NULL,
  `Siret_user` varchar(40) NOT NULL,
  `Adresse_user` varchar(100) NOT NULL,
  `DateCo_user` date DEFAULT NULL,
  `Pseudo_user` varchar(40) NOT NULL,
  `Pass_user` varchar(255) NOT NULL,
  `Role_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`Id_user`, `Nom_user`, `Siret_user`, `Adresse_user`, `DateCo_user`, `Pseudo_user`, `Pass_user`, `Role_user`) VALUES
(1, 'Fay', '141414', '14 rue de perpi', '2018-09-12', 'thomas', '$2y$10$NLSo0qcsTGRptnYQSDknKe2V9aXabt9b8Z4mlQHWLb4zO4wCGnqyu', 0),
(2, 'Totoo', '123456789', 'poum', '2018-09-12', 'toto', '$2y$10$lx30yhhoRfnTdhQgR/kmp.Bfbn9YQY67JQhBVLfdG2KVxltsZH4Hq', 0),
(3, 'Compte ADMIN', '', 'admin rue du dev', '2018-09-14', 'admin', '$2y$10$Yud/DR1AUZIj7KioQuKNc.J9qFUlA8lMUbTwR3jkVJGRjFH19qyDi', 1),
(4, 'Thomas', '14414', 'thomas', '2018-09-14', 'admin', '$2y$10$qgTCVtiuSwDU6B.ApzGCrezBFZuu1tw4/9w29UIsrL1TWdifNGl8G', 0),
(6, 'Fay', '21455555', '14 rue rue', '0000-00-00', 'thomas', '$2y$10$dU1bhErSCeRLNSYxohjBXeRfI5vnhz8f.PxnZjrxkiWjZWwUCzNCu', 0),
(21, 'Jean', '1414', 'jean', '0000-00-00', 'jean', '$2y$10$Z2o/Us7s1SZWn8QAeD3UoOggylQjh6I26wYFa6.IVCxl8EMWuuace', 0),
(22, 'test', '1010', 'test', '0000-00-00', 'admin', '$2y$10$Sc19DlG.LbyV5uDOwzBabO/hTXkf7StShIQFKgRRbPmwUHdxxwNde', 1),
(23, 'Thomas', '12', 'Thomas', '0000-00-00', 'thomas', '$2y$10$r1fuwGFeZjroVgyD12gjJen0uRp/o4XfBKqPau9rrwqd4zpGnG9am', 0),
(24, 'Test', 'test', 'test', '0000-00-00', 'test', '$2y$10$JzAAx9qOmplAdITndnZupuBtqYsp0u0.hv0APze16cHtdxX/JryGe', 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`Id_client`),
  ADD KEY `fk_utilisateur_id` (`Id_user`);

--
-- Index pour la table `couleurs`
--
ALTER TABLE `couleurs`
  ADD PRIMARY KEY (`Id_couleur`);

--
-- Index pour la table `croquis`
--
ALTER TABLE `croquis`
  ADD PRIMARY KEY (`id_croquis`);

--
-- Index pour la table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`Id_devis`),
  ADD KEY `fk_user_Id_devis` (`Id_user`),
  ADD KEY `fk_client_Id_devis` (`Id_client`);

--
-- Index pour la table `familles`
--
ALTER TABLE `familles`
  ADD PRIMARY KEY (`Id_famille`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`Id_image`);

--
-- Index pour la table `liens_couleurs_matieres`
--
ALTER TABLE `liens_couleurs_matieres`
  ADD PRIMARY KEY (`Id_lien`),
  ADD KEY `fk_id_couleur` (`Id_couleur`),
  ADD KEY `fk_id_matiere` (`Id_matiere`);

--
-- Index pour la table `lignes_devis`
--
ALTER TABLE `lignes_devis`
  ADD PRIMARY KEY (`Id_ligne`);

--
-- Index pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`Id_matiere`);

--
-- Index pour la table `pieces`
--
ALTER TABLE `pieces`
  ADD PRIMARY KEY (`Id_piece`),
  ADD KEY `fk_id_image` (`Id_image`);

--
-- Index pour la table `ss_familles`
--
ALTER TABLE `ss_familles`
  ADD PRIMARY KEY (`Id_ss`),
  ADD KEY `fk_id_famille` (`Id_famille`);

--
-- Index pour la table `tva`
--
ALTER TABLE `tva`
  ADD PRIMARY KEY (`Id_tva`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id_user`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `Id_client` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
--
-- AUTO_INCREMENT pour la table `croquis`
--
ALTER TABLE `croquis`
  MODIFY `id_croquis` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `devis`
--
ALTER TABLE `devis`
  MODIFY `Id_devis` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `familles`
--
ALTER TABLE `familles`
  MODIFY `Id_famille` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `Id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `liens_couleurs_matieres`
--
ALTER TABLE `liens_couleurs_matieres`
  MODIFY `Id_lien` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `lignes_devis`
--
ALTER TABLE `lignes_devis`
  MODIFY `Id_ligne` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `Id_matiere` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
--
-- AUTO_INCREMENT pour la table `pieces`
--
ALTER TABLE `pieces`
  MODIFY `Id_piece` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT pour la table `ss_familles`
--
ALTER TABLE `ss_familles`
  MODIFY `Id_ss` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tva`
--
ALTER TABLE `tva`
  MODIFY `Id_tva` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `Id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `fk_utilisateur_id` FOREIGN KEY (`Id_user`) REFERENCES `user` (`Id_user`);

--
-- Contraintes pour la table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `fk_client_Id_devis` FOREIGN KEY (`Id_client`) REFERENCES `clients` (`Id_client`),
  ADD CONSTRAINT `fk_user_Id_devis` FOREIGN KEY (`Id_user`) REFERENCES `user` (`Id_user`);

--
-- Contraintes pour la table `liens_couleurs_matieres`
--
ALTER TABLE `liens_couleurs_matieres`
  ADD CONSTRAINT `fk_id_couleur` FOREIGN KEY (`Id_couleur`) REFERENCES `couleurs` (`Id_couleur`),
  ADD CONSTRAINT `fk_id_matiere` FOREIGN KEY (`Id_matiere`) REFERENCES `matieres` (`Id_matiere`);

--
-- Contraintes pour la table `ss_familles`
--
ALTER TABLE `ss_familles`
  ADD CONSTRAINT `fk_id_famille` FOREIGN KEY (`Id_famille`) REFERENCES `familles` (`Id_famille`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
