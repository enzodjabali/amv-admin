-- phpMyAdmin SQL Dump
-- version 4.6.6deb4+deb9u2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 06 Avril 2021 à 17:04
-- Version du serveur :  10.1.47-MariaDB-0+deb9u1
-- Version de PHP :  7.0.33-0+deb9u10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `avm`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `admins`
--

INSERT INTO `admins` (`id`, `nom`, `prenom`, `email`, `password`) VALUES
(1, 'root', 'root', 'root@root.me', '8cb2237d0679ca88db6464eac60da96345513964'),
(2, 'Fouré', 'Frédéricette', 'fredo@fred.me', '8cb2237d0679ca88db6464eac60da96345513964'),
(11, 'jackotito', 'jackos', 'j@j.cm', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(12, 'szz', 'ss', 'sss@q.cddd', '388ad1c312a488ee9e12998fe097f2258fa8d5ee'),
(13, 'dgbcfhh', 'jkb', 'ss@s.d', '8eff122bd434b4b3641b6f41d64956af2106169b'),
(14, 'nckdn', 'zdqdq', 'dqz@qzd.fr', 'f700a1b048840b444e9425422e7b1b2bbc61152c');

-- --------------------------------------------------------

--
-- Structure de la table `admins_perms`
--

CREATE TABLE `admins_perms` (
  `id` int(11) NOT NULL,
  `idAdmin` int(11) NOT NULL,
  `p_write` tinyint(1) NOT NULL,
  `p_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `admins_perms`
--

INSERT INTO `admins_perms` (`id`, `idAdmin`, `p_write`, `p_admin`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 0),
(3, 6, 0, 0),
(4, 7, 1, 1),
(6, 8, 0, 0),
(7, 9, 0, 0),
(8, 10, 0, 0),
(9, 11, 1, 0),
(10, 12, 0, 1),
(11, 13, 1, 1),
(12, 14, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `cde` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`cde`, `nom`, `prenom`) VALUES
(84, 'test', 'test'),
(93, 'test', 'test'),
(94, 'azerty', 'azerty2'),
(96, 'Tes', 'Ds');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `cde` int(11) NOT NULL,
  `cdeClient` int(11) NOT NULL,
  `montant_ht` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `commandes`
--

INSERT INTO `commandes` (`cde`, `cdeClient`, `montant_ht`) VALUES
(80, 3, 31999);

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `cde` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `dep` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`cde`, `nom`, `dep`) VALUES
(4, 'Oknoplast', 'Pologne');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `id` int(11) NOT NULL,
  `idAdmin` int(11) NOT NULL,
  `type_action` int(11) NOT NULL,
  `date_action` varchar(50) NOT NULL,
  `heure_action` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `historique`
--

INSERT INTO `historique` (`id`, `idAdmin`, `type_action`, `date_action`, `heure_action`) VALUES
(17, 1, 1, '10/02/21', '01:25'),
(18, 1, 1, '10/02/21', '01:28'),
(19, 1, 2, '10/02/21', '01:37'),
(20, 1, 2, '10/02/21', '15:14'),
(21, 1, 2, '10/02/21', '15:23'),
(22, 1, 2, '10/02/21', '17:27'),
(23, 1, 2, '10/02/21', '17:51'),
(24, 1, 2, '10/02/21', '20:44'),
(25, 1, 2, '10/02/21', '20:46'),
(26, 1, 2, '10/02/21', '22:10'),
(27, 1, 2, '12/02/21', '19:48'),
(28, 1, 2, '12/02/21', '21:19'),
(29, 1, 2, '14/02/21', '13:31'),
(30, 1, 2, '14/02/21', '13:33'),
(31, 1, 2, '16/02/21', '15:38'),
(32, 2, 2, '17/02/21', '10:52'),
(33, 1, 2, '20/02/21', '21:19'),
(34, 1, 2, '23/02/21', '18:40'),
(35, 1, 2, '24/02/21', '18:17'),
(36, 1, 2, '24/02/21', '18:34'),
(37, 1, 2, '24/02/21', '19:13'),
(38, 1, 2, '26/02/21', '18:45'),
(39, 1, 2, '11/03/21', '21:27'),
(40, 1, 2, '16/03/21', '08:47'),
(41, 1, 2, '16/03/21', '08:47'),
(42, 1, 1, '16/03/21', '08:47'),
(43, 1, 2, '16/03/21', '08:54'),
(44, 1, 2, '16/03/21', '09:00'),
(45, 1, 2, '21/03/21', '15:18'),
(46, 1, 2, '29/03/21', '16:31'),
(47, 1, 2, '29/03/21', '17:23'),
(48, 1, 2, '31/03/21', '14:55'),
(49, 1, 2, '02/04/21', '08:52');

-- --------------------------------------------------------

--
-- Structure de la table `logs_type1`
--

CREATE TABLE `logs_type1` (
  `id` int(11) NOT NULL,
  `idHistorique` int(11) NOT NULL,
  `last_page` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `logs_type1`
--

INSERT INTO `logs_type1` (`id`, `idHistorique`, `last_page`) VALUES
(1, 17, 'Commandes'),
(2, 18, 'Comptes'),
(3, 42, 'Clients');

-- --------------------------------------------------------

--
-- Structure de la table `logs_type2`
--

CREATE TABLE `logs_type2` (
  `id` int(11) NOT NULL,
  `idHistorique` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `logs_type2`
--

INSERT INTO `logs_type2` (`id`, `idHistorique`, `ip`) VALUES
(1, 19, '176.164.224.156'),
(2, 20, '176.164.209.201'),
(3, 21, '176.164.209.201'),
(4, 22, '176.164.209.201'),
(5, 23, '86.237.197.107'),
(6, 24, '176.164.209.201'),
(7, 25, '176.164.209.201'),
(8, 26, '176.164.227.93'),
(9, 27, '193.57.124.88'),
(10, 28, '193.57.124.88'),
(11, 29, '37.171.15.239'),
(12, 30, '193.56.242.85'),
(13, 31, '37.173.36.47'),
(14, 32, '37.172.194.29'),
(15, 33, '176.177.123.8'),
(16, 34, '176.177.124.49'),
(17, 35, '176.167.124.58'),
(18, 36, '176.167.124.58'),
(19, 37, '176.167.124.58'),
(20, 38, '92.184.104.228'),
(21, 39, '212.195.28.78'),
(22, 40, '193.48.117.169'),
(23, 41, '193.48.117.169'),
(24, 43, '193.48.117.169'),
(25, 44, '193.48.117.169'),
(26, 45, '92.184.116.176'),
(27, 46, '193.48.117.169'),
(28, 47, '193.48.117.169'),
(29, 48, '86.237.197.107'),
(30, 49, '193.48.117.169');

-- --------------------------------------------------------

--
-- Structure de la table `logs_type3`
--

CREATE TABLE `logs_type3` (
  `id` int(11) NOT NULL,
  `idHistorique` int(11) NOT NULL,
  `new_client_cde` int(11) NOT NULL,
  `new_client_name` varchar(101) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `logs_type4`
--

CREATE TABLE `logs_type4` (
  `id` int(11) NOT NULL,
  `idHistorique` int(11) NOT NULL,
  `idAdmin` int(11) NOT NULL,
  `older_client_cde` int(11) NOT NULL,
  `older_client_name` varchar(101) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `logs_type5`
--

CREATE TABLE `logs_type5` (
  `id` int(11) NOT NULL,
  `idHistorique` int(11) NOT NULL,
  `client_cde` int(11) NOT NULL,
  `client_name` varchar(101) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `marge_brute`
--

CREATE TABLE `marge_brute` (
  `cde` int(11) NOT NULL,
  `cdeClient` int(11) NOT NULL,
  `montantht_vente` decimal(10,0) NOT NULL,
  `montantht_achat` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `marge_brute`
--

INSERT INTO `marge_brute` (`cde`, `cdeClient`, `montantht_vente`, `montantht_achat`) VALUES
(5, 80, '1324', '541'),
(6, 84, '1500', '999999'),
(7, 84, '45154', '1000');

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `nom` varchar(33) NOT NULL,
  `prenom` varchar(33) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `admins_perms`
--
ALTER TABLE `admins_perms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`cde`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`cde`),
  ADD KEY `cdeClient` (`cdeClient`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`cde`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAdmin` (`idAdmin`);

--
-- Index pour la table `logs_type1`
--
ALTER TABLE `logs_type1`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logs_type2`
--
ALTER TABLE `logs_type2`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logs_type3`
--
ALTER TABLE `logs_type3`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logs_type4`
--
ALTER TABLE `logs_type4`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logs_type5`
--
ALTER TABLE `logs_type5`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `marge_brute`
--
ALTER TABLE `marge_brute`
  ADD PRIMARY KEY (`cde`),
  ADD KEY `cdeClient2` (`cdeClient`);

--
-- Index pour la table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `admins_perms`
--
ALTER TABLE `admins_perms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `cde` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `cde` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT pour la table `logs_type1`
--
ALTER TABLE `logs_type1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `logs_type2`
--
ALTER TABLE `logs_type2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `logs_type3`
--
ALTER TABLE `logs_type3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `logs_type4`
--
ALTER TABLE `logs_type4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `logs_type5`
--
ALTER TABLE `logs_type5`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `marge_brute`
--
ALTER TABLE `marge_brute`
  MODIFY `cde` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `idAdmin` FOREIGN KEY (`idAdmin`) REFERENCES `admins` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
