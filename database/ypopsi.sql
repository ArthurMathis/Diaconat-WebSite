-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 01 août 2024 à 15:01
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ypopsi`
--

-- --------------------------------------------------------

--
-- Structure de la table `actions`
--

CREATE TABLE `actions` (
  `Description_Actions` text DEFAULT NULL,
  `Cle_Utilisateurs` int(11) NOT NULL,
  `Cle_Types` int(11) NOT NULL,
  `CLe_Instants` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `aides_au_recrutement`
--

CREATE TABLE `aides_au_recrutement` (
  `Id_Aides_au_recrutement` int(11) NOT NULL,
  `Intitule_Aides_au_recrutement` varchar(64) NOT NULL,
  `Description_Aides_au_recrutement` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `appliquer_a`
--

CREATE TABLE `appliquer_a` (
  `Cle_Candidatures` int(11) NOT NULL,
  `Cle_Services` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avoir_droit_a`
--

CREATE TABLE `avoir_droit_a` (
  `Cle_Candidats` int(11) NOT NULL,
  `Cle_Aides_au_recrutement` int(11) NOT NULL,
  `Cle_Coopteur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avoir_rendez_vous_avec`
--

CREATE TABLE `avoir_rendez_vous_avec` (
  `Compte_rendu_Avoir_rendez_vous_avec` text DEFAULT NULL,
  `Cle_Candidats` int(11) NOT NULL,
  `Cle_Utilisateurs` int(11) NOT NULL,
  `Cle_Instants` int(11) NOT NULL,
  `Cle_Etablissements` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `candidats`
--

CREATE TABLE `candidats` (
  `Id_Candidats` int(11) NOT NULL,
  `Nom_Candidats` varchar(64) NOT NULL,
  `Prenom_Candidats` varchar(64) NOT NULL,
  `Telephone_Candidats` varchar(14) NOT NULL,
  `Email_Candidats` varchar(64) NOT NULL,
  `Adresse_Candidats` varchar(256) DEFAULT NULL,
  `Ville_Candidats` varchar(64) DEFAULT NULL,
  `CodePostal_Candidats` varchar(5) DEFAULT NULL,
  `Disponibilite_Candidats` date NOT NULL,
  `VisiteMedicale_Candidats` date DEFAULT NULL,
  `Notations_Candidats` int(11) DEFAULT NULL,
  `Descriptions_Candidats` text DEFAULT NULL,
  `A_Candidats` tinyint(1) DEFAULT 0,
  `B_Candidats` tinyint(1) DEFAULT 0,
  `C_Candidats` tinyint(1) DEFAULT 0
) ;

-- --------------------------------------------------------

--
-- Structure de la table `candidatures`
--

CREATE TABLE `candidatures` (
  `Id_Candidatures` int(11) NOT NULL,
  `Statut_Candidatures` varchar(15) NOT NULL,
  `Cle_Candidats` int(11) NOT NULL,
  `Cle_Instants` int(11) NOT NULL,
  `Cle_Sources` int(11) NOT NULL,
  `Cle_Postes` int(11) DEFAULT NULL,
  `Cle_Types_de_contrats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contrats`
--

CREATE TABLE `contrats` (
  `Id_Contrats` int(11) NOT NULL,
  `Date_debut_Contrats` date NOT NULL,
  `Date_fin_Contrats` date DEFAULT NULL,
  `Salaires_Contrats` decimal(10,2) DEFAULT NULL,
  `Date_demission_Contrats` date DEFAULT NULL,
  `Travail_de_nuit_Contrats` tinyint(1) DEFAULT 0,
  `Travail_week_end_Contrats` tinyint(1) DEFAULT 0,
  `Nombre_heures_hebdomadaires_Contrats` int(11) DEFAULT NULL,
  `Statut_Proposition` tinyint(1) DEFAULT 0,
  `Date_signature_Contrats` date DEFAULT NULL,
  `Cle_Candidats` int(11) NOT NULL,
  `Cle_Instants` int(11) NOT NULL,
  `Cle_Services` int(11) NOT NULL,
  `Cle_Postes` int(11) NOT NULL,
  `Cle_Types_de_contrats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `diplomes`
--

CREATE TABLE `diplomes` (
  `Id_Diplomes` int(11) NOT NULL,
  `Intitule_Diplomes` varchar(128) NOT NULL,
  `Description_Diplomes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etablissements`
--

CREATE TABLE `etablissements` (
  `Id_Etablissements` int(11) NOT NULL,
  `Intitule_Etablissements` varchar(64) NOT NULL,
  `Adresse_Etablissements` varchar(256) DEFAULT NULL,
  `Ville_Etablissements` varchar(64) DEFAULT NULL,
  `CodePostal_Etablissements` int(11) DEFAULT NULL,
  `Description_Etablissements` text DEFAULT NULL,
  `Cle_Poles` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `instants`
--

CREATE TABLE `instants` (
  `Id_Instants` int(11) NOT NULL,
  `Jour_Instants` date NOT NULL,
  `Heure_Instants` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `missions`
--

CREATE TABLE `missions` (
  `Cle_Services` int(11) NOT NULL,
  `Cle_Postes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `obtenir`
--

CREATE TABLE `obtenir` (
  `Cle_Candidats` int(11) NOT NULL,
  `Cle_Diplomes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `poles`
--

CREATE TABLE `poles` (
  `Id_Poles` int(11) NOT NULL,
  `Intitule_Poles` varchar(8) NOT NULL,
  `Description_Poles` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `postes`
--

CREATE TABLE `postes` (
  `Id_Postes` int(11) NOT NULL,
  `Intitule_Postes` varchar(64) NOT NULL,
  `Intitule_Feminin_Postes` varchar(64), 
  `Description_Postes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ------------------------------------1--------------------

--
-- Structure de la table `postuler_a`
--

CREATE TABLE `postuler_a` (
  `Cle_Candidats` int(11) NOT NULL,
  `Cle_Instants` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `proposer_a`
--

CREATE TABLE `proposer_a` (
  `Cle_Candidats` int(11) NOT NULL,
  `Cle_Instants` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `Id_Role` int(11) NOT NULL,
  `Intitule_Role` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `Id_Services` int(11) NOT NULL,
  `Intitule_Services` varchar(64) NOT NULL,
  `Cle_Etablissements` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sources`
--

CREATE TABLE `sources` (
  `Id_Sources` int(11) NOT NULL,
  `Intitule_Sources` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `travail_dans`
--

CREATE TABLE `travail_dans` (
  `Cle_Utilisateurs` int(11) NOT NULL,
  `Cle_Etablissements` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

CREATE TABLE `types` (
  `Id_Types` int(11) NOT NULL,
  `Intitule_Types` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types_de_contrats`
--

CREATE TABLE `types_de_contrats` (
  `Id_Types_de_contrats` int(11) NOT NULL,
  `Intitule_Types_de_contrats` varchar(64) NOT NULL,
  `Description_Types_de_contrats` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `Id_Utilisateurs` int(11) NOT NULL,
  `Identifiant_Utilisateurs` varchar(64) NOT NULL,
  `Nom_Utilisateurs` varchar(64) NOT NULL,
  `Prenom_Utilisateurs` varchar(64) NOT NULL,
  `MotDePasse_Utilisateurs` varchar(256) NOT NULL,
  `Email_Utilisateurs` varchar(64) DEFAULT NULL,
  `MotDePasseTemp_Utilisateurs` tinyint(1) DEFAULT 1,
  `Cle_Roles` int(11) NOT NULL,
  `Cle_Etablissements` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`Cle_Utilisateurs`,`Cle_Types`,`CLe_Instants`),
  ADD KEY `Cle_Types` (`Cle_Types`),
  ADD KEY `CLe_Instants` (`CLe_Instants`);

--
-- Index pour la table `aides_au_recrutement`
--
ALTER TABLE `aides_au_recrutement`
  ADD PRIMARY KEY (`Id_Aides_au_recrutement`),
  ADD UNIQUE KEY `Intitule_Aides_au_recrutement` (`Intitule_Aides_au_recrutement`);

--
-- Index pour la table `appliquer_a`
--
ALTER TABLE `appliquer_a`
  ADD PRIMARY KEY (`Cle_Candidatures`,`Cle_Services`),
  ADD KEY `Cle_Services` (`Cle_Services`);

--
-- Index pour la table `avoir_droit_a`
--
ALTER TABLE `avoir_droit_a`
  ADD PRIMARY KEY (`Cle_Candidats`,`Cle_Aides_au_recrutement`),
  ADD UNIQUE KEY `Cle_Candidats` (`Cle_Candidats`),
  ADD KEY `Cle_Aides_au_recrutement` (`Cle_Aides_au_recrutement`);

--
-- Index pour la table `avoir_rendez_vous_avec`
--
ALTER TABLE `avoir_rendez_vous_avec`
  ADD PRIMARY KEY (`Cle_Candidats`,`Cle_Utilisateurs`,`Cle_Instants`),
  ADD KEY `Cle_Utilisateurs` (`Cle_Utilisateurs`),
  ADD KEY `Cle_Instants` (`Cle_Instants`),
  ADD KEY `Cle_Etablissements` (`Cle_Etablissements`);

--
-- Index pour la table `candidats`
--
ALTER TABLE `candidats`
  ADD PRIMARY KEY (`Id_Candidats`),
  ADD UNIQUE KEY `Telephone_Candidats` (`Telephone_Candidats`),
  ADD UNIQUE KEY `Email_Candidats` (`Email_Candidats`);

--
-- Index pour la table `candidatures`
--
ALTER TABLE `candidatures`
  ADD PRIMARY KEY (`Id_Candidatures`),
  ADD KEY `Cle_Candidats` (`Cle_Candidats`,`Cle_Instants`),
  ADD KEY `Cle_Sources` (`Cle_Sources`),
  ADD KEY `Cle_Postes` (`Cle_Postes`),
  ADD KEY `Cle_Types_de_contrats` (`Cle_Types_de_contrats`);

--
-- Index pour la table `contrats`
--
ALTER TABLE `contrats`
  ADD PRIMARY KEY (`Id_Contrats`),
  ADD KEY `Cle_Candidats` (`Cle_Candidats`,`Cle_Instants`),
  ADD KEY `Cle_Services` (`Cle_Services`,`Cle_Postes`),
  ADD KEY `Cle_Types_de_contrats` (`Cle_Types_de_contrats`);

--
-- Index pour la table `diplomes`
--
ALTER TABLE `diplomes`
  ADD PRIMARY KEY (`Id_Diplomes`),
  ADD UNIQUE KEY `Intitule_Diplomes` (`Intitule_Diplomes`);

--
-- Index pour la table `etablissements`
--
ALTER TABLE `etablissements`
  ADD PRIMARY KEY (`Id_Etablissements`),
  ADD UNIQUE KEY `Intitule_Etablissements` (`Intitule_Etablissements`),
  ADD KEY `Cle_Poles` (`Cle_Poles`);

--
-- Index pour la table `instants`
--
ALTER TABLE `instants`
  ADD PRIMARY KEY (`Id_Instants`);

--
-- Index pour la table `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`Cle_Services`,`Cle_Postes`),
  ADD KEY `Cle_Postes` (`Cle_Postes`);

--
-- Index pour la table `obtenir`
--
ALTER TABLE `obtenir`
  ADD PRIMARY KEY (`Cle_Candidats`,`Cle_Diplomes`),
  ADD KEY `Cle_Diplomes` (`Cle_Diplomes`);

--
-- Index pour la table `poles`
--
ALTER TABLE `poles`
  ADD PRIMARY KEY (`Id_Poles`),
  ADD UNIQUE KEY `Intitule_Poles` (`Intitule_Poles`);

--
-- Index pour la table `postes`
--
ALTER TABLE `postes`
  ADD PRIMARY KEY (`Id_Postes`),
  ADD UNIQUE KEY `Intitule_Postes` (`Intitule_Postes`);

--
-- Index pour la table `postuler_a`
--
ALTER TABLE `postuler_a`
  ADD PRIMARY KEY (`Cle_Candidats`,`Cle_Instants`),
  ADD KEY `Cle_Instants` (`Cle_Instants`);

--
-- Index pour la table `proposer_a`
--
ALTER TABLE `proposer_a`
  ADD PRIMARY KEY (`Cle_Candidats`,`Cle_Instants`),
  ADD KEY `Cle_Instants` (`Cle_Instants`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Id_Role`),
  ADD UNIQUE KEY `Intitule_Role` (`Intitule_Role`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`Id_Services`),
  ADD KEY `Cle_Etablissements` (`Cle_Etablissements`);

--
-- Index pour la table `sources`
--
ALTER TABLE `sources`
  ADD PRIMARY KEY (`Id_Sources`),
  ADD UNIQUE KEY `Intitule_Sources` (`Intitule_Sources`);

--
-- Index pour la table `travail_dans`
--
ALTER TABLE `travail_dans`
  ADD PRIMARY KEY (`Cle_Utilisateurs`,`Cle_Etablissements`),
  ADD KEY `Cle_Etablissements` (`Cle_Etablissements`);

--
-- Index pour la table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`Id_Types`),
  ADD UNIQUE KEY `Intitule_Types` (`Intitule_Types`);

--
-- Index pour la table `types_de_contrats`
--
ALTER TABLE `types_de_contrats`
  ADD PRIMARY KEY (`Id_Types_de_contrats`),
  ADD UNIQUE KEY `Intitule_Types_de_contrats` (`Intitule_Types_de_contrats`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`Id_Utilisateurs`),
  ADD UNIQUE KEY `Email_Utilisateurs` (`Email_Utilisateurs`),
  ADD KEY `Cle_Roles` (`Cle_Roles`),
  ADD KEY `Cle_Etablissements` (`Cle_Etablissements`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `aides_au_recrutement`
--
ALTER TABLE `aides_au_recrutement`
  MODIFY `Id_Aides_au_recrutement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `candidats`
--
ALTER TABLE `candidats`
  MODIFY `Id_Candidats` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `candidatures`
--
ALTER TABLE `candidatures`
  MODIFY `Id_Candidatures` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `contrats`
--
ALTER TABLE `contrats`
  MODIFY `Id_Contrats` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `diplomes`
--
ALTER TABLE `diplomes`
  MODIFY `Id_Diplomes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `etablissements`
--
ALTER TABLE `etablissements`
  MODIFY `Id_Etablissements` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `instants`
--
ALTER TABLE `instants`
  MODIFY `Id_Instants` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `poles`
--
ALTER TABLE `poles`
  MODIFY `Id_Poles` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `postes`
--
ALTER TABLE `postes`
  MODIFY `Id_Postes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `Id_Role` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `Id_Services` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sources`
--
ALTER TABLE `sources`
  MODIFY `Id_Sources` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `types`
--
ALTER TABLE `types`
  MODIFY `Id_Types` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `types_de_contrats`
--
ALTER TABLE `types_de_contrats`
  MODIFY `Id_Types_de_contrats` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `Id_Utilisateurs` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `actions_ibfk_1` FOREIGN KEY (`Cle_Utilisateurs`) REFERENCES `utilisateurs` (`Id_Utilisateurs`),
  ADD CONSTRAINT `actions_ibfk_2` FOREIGN KEY (`Cle_Types`) REFERENCES `types` (`Id_Types`),
  ADD CONSTRAINT `actions_ibfk_3` FOREIGN KEY (`CLe_Instants`) REFERENCES `instants` (`Id_Instants`);

--
-- Contraintes pour la table `appliquer_a`
--
ALTER TABLE `appliquer_a`
  ADD CONSTRAINT `appliquer_a_ibfk_1` FOREIGN KEY (`Cle_Candidatures`) REFERENCES `candidatures` (`Id_Candidatures`),
  ADD CONSTRAINT `appliquer_a_ibfk_2` FOREIGN KEY (`Cle_Services`) REFERENCES `services` (`Id_Services`);

--
-- Contraintes pour la table `avoir_droit_a`
--
ALTER TABLE `avoir_droit_a`
  ADD CONSTRAINT `avoir_droit_a_ibfk_1` FOREIGN KEY (`Cle_Candidats`) REFERENCES `candidats` (`Id_Candidats`),
  ADD CONSTRAINT `avoir_droit_a_ibfk_2` FOREIGN KEY (`Cle_Aides_au_recrutement`) REFERENCES `aides_au_recrutement` (`Id_Aides_au_recrutement`);

--
-- Contraintes pour la table `avoir_rendez_vous_avec`
--
ALTER TABLE `avoir_rendez_vous_avec`
  ADD CONSTRAINT `avoir_rendez_vous_avec_ibfk_1` FOREIGN KEY (`Cle_Candidats`) REFERENCES `candidats` (`Id_Candidats`),
  ADD CONSTRAINT `avoir_rendez_vous_avec_ibfk_2` FOREIGN KEY (`Cle_Utilisateurs`) REFERENCES `utilisateurs` (`Id_Utilisateurs`),
  ADD CONSTRAINT `avoir_rendez_vous_avec_ibfk_3` FOREIGN KEY (`Cle_Instants`) REFERENCES `instants` (`Id_Instants`),
  ADD CONSTRAINT `avoir_rendez_vous_avec_ibfk_4` FOREIGN KEY (`Cle_Etablissements`) REFERENCES `etablissements` (`Id_Etablissements`);

--
-- Contraintes pour la table `candidatures`
--
ALTER TABLE `candidatures`
  ADD CONSTRAINT `candidatures_ibfk_1` FOREIGN KEY (`Cle_Candidats`,`Cle_Instants`) REFERENCES `postuler_a` (`Cle_Candidats`, `Cle_Instants`),
  ADD CONSTRAINT `candidatures_ibfk_2` FOREIGN KEY (`Cle_Sources`) REFERENCES `sources` (`Id_Sources`),
  ADD CONSTRAINT `candidatures_ibfk_3` FOREIGN KEY (`Cle_Postes`) REFERENCES `postes` (`Id_Postes`),
  ADD CONSTRAINT `candidatures_ibfk_4` FOREIGN KEY (`Cle_Types_de_contrats`) REFERENCES `types_de_contrats` (`Id_Types_de_contrats`);

--
-- Contraintes pour la table `contrats`
--
ALTER TABLE `contrats`
  ADD CONSTRAINT `contrats_ibfk_1` FOREIGN KEY (`Cle_Candidats`,`Cle_Instants`) REFERENCES `proposer_a` (`Cle_Candidats`, `Cle_Instants`),
  ADD CONSTRAINT `contrats_ibfk_2` FOREIGN KEY (`Cle_Services`,`Cle_Postes`) REFERENCES `missions` (`Cle_Services`, `Cle_Postes`),
  ADD CONSTRAINT `contrats_ibfk_3` FOREIGN KEY (`Cle_Types_de_contrats`) REFERENCES `types_de_contrats` (`Id_Types_de_contrats`);

--
-- Contraintes pour la table `etablissements`
--
ALTER TABLE `etablissements`
  ADD CONSTRAINT `etablissements_ibfk_1` FOREIGN KEY (`Cle_Poles`) REFERENCES `poles` (`Id_Poles`);

--
-- Contraintes pour la table `missions`
--
ALTER TABLE `missions`
  ADD CONSTRAINT `missions_ibfk_1` FOREIGN KEY (`Cle_Services`) REFERENCES `services` (`Id_Services`),
  ADD CONSTRAINT `missions_ibfk_2` FOREIGN KEY (`Cle_Postes`) REFERENCES `postes` (`Id_Postes`);

--
-- Contraintes pour la table `obtenir`
--
ALTER TABLE `obtenir`
  ADD CONSTRAINT `obtenir_ibfk_1` FOREIGN KEY (`Cle_Candidats`) REFERENCES `candidats` (`Id_Candidats`),
  ADD CONSTRAINT `obtenir_ibfk_2` FOREIGN KEY (`Cle_Diplomes`) REFERENCES `diplomes` (`Id_Diplomes`);

--
-- Contraintes pour la table `postuler_a`
--
ALTER TABLE `postuler_a`
  ADD CONSTRAINT `postuler_a_ibfk_1` FOREIGN KEY (`Cle_Candidats`) REFERENCES `candidats` (`Id_Candidats`),
  ADD CONSTRAINT `postuler_a_ibfk_2` FOREIGN KEY (`Cle_Instants`) REFERENCES `instants` (`Id_Instants`);

--
-- Contraintes pour la table `proposer_a`
--
ALTER TABLE `proposer_a`
  ADD CONSTRAINT `proposer_a_ibfk_1` FOREIGN KEY (`Cle_Candidats`) REFERENCES `candidats` (`Id_Candidats`),
  ADD CONSTRAINT `proposer_a_ibfk_2` FOREIGN KEY (`Cle_Instants`) REFERENCES `instants` (`Id_Instants`);

--
-- Contraintes pour la table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`Cle_Etablissements`) REFERENCES `etablissements` (`Id_Etablissements`);

--
-- Contraintes pour la table `travail_dans`
--
ALTER TABLE `travail_dans`
  ADD CONSTRAINT `travail_dans_ibfk_1` FOREIGN KEY (`Cle_Utilisateurs`) REFERENCES `utilisateurs` (`Id_Utilisateurs`),
  ADD CONSTRAINT `travail_dans_ibfk_2` FOREIGN KEY (`Cle_Etablissements`) REFERENCES `etablissements` (`Id_Etablissements`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`Cle_Roles`) REFERENCES `roles` (`Id_Role`),
  ADD CONSTRAINT `utilisateurs_ibfk_2` FOREIGN KEY (`Cle_Etablissements`) REFERENCES `etablissements` (`Id_Etablissements`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
