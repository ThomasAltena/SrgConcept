-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 11 sep. 2018 à 17:13
-- Version du serveur :  10.1.34-MariaDB
-- Version de PHP :  7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `srgv2`
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
  `Cp_client` int(10) NOT NULL,
  `Ville_client` varchar(55) NOT NULL,
  `Tel_client` varchar(20) NOT NULL,
  `Mail_client` varchar(255) NOT NULL,
  `DateCrea_client` date NOT NULL,
  `Prospect_client` tinyint(1) NOT NULL,
  `Id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `Id_matiere` int(11) NOT NULL,
  `Libelle_matiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pieces`
--

CREATE TABLE `pieces` (
  `Id_piece` int(11) NOT NULL,
  `Libelle_piece` varchar(55) NOT NULL,
  `Id_image` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Déchargement des données de la table `tva`
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
-- Index pour les tables déchargées
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
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `Id_client` int(10) NOT NULL AUTO_INCREMENT;

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
  MODIFY `Id_image` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT pour la table `pieces`
--
ALTER TABLE `pieces`
  MODIFY `Id_piece` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `Id_user` int(10) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
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
-- Contraintes pour la table `pieces`
--
ALTER TABLE `pieces`
  ADD CONSTRAINT `fk_id_image` FOREIGN KEY (`Id_image`) REFERENCES `images` (`Id_image`);

--
-- Contraintes pour la table `ss_familles`
--
ALTER TABLE `ss_familles`
  ADD CONSTRAINT `fk_id_famille` FOREIGN KEY (`Id_famille`) REFERENCES `familles` (`Id_famille`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
