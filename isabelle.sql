-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 26 avr. 2019 à 13:59
-- Version du serveur :  5.7.24
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `isabelle`
--

-- --------------------------------------------------------

--
-- Structure de la table `biere`
--

DROP TABLE IF EXISTS `biere`;
CREATE TABLE IF NOT EXISTS `biere` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `biere`
--

INSERT INTO `biere` (`id`, `nom`, `description`) VALUES
(2, 'Bière 2', 'deuxième bière'),
(3, 'Bière 3', 'troisième bière'),
(4, 'Bière 4', 'quatrième bière'),
(5, 'Bière 5', 'cinquième bière'),
(6, 'Bière 6', 'sixième bière'),
(7, 'Bière 7', 'septième bière'),
(8, 'Bière 8', 'huitième bière');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idsproduits` text NOT NULL,
  `prixttc` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1 COMMENT='historique des comandes';

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `iduser`, `idsproduits`, `prixttc`) VALUES
(1, 9, 'a:1:{i:0;s:1:\"1\";}', 4.584),
(2, 9, 'a:2:{i:0;s:1:\"4\";i:1;s:1:\"7\";}', 14.64),
(3, 9, 'a:1:{i:0;s:1:\"6\";}', 7.74),
(4, 9, 'a:1:{i:0;s:1:\"6\";}', 7.74),
(5, 9, 'a:1:{i:0;s:1:\"6\";}', 7.74),
(6, 9, 'a:1:{i:0;s:1:\"6\";}', 7.74),
(7, 9, 'a:1:{i:0;s:1:\"6\";}', 7.74),
(8, 9, 'a:1:{i:0;s:1:\"3\";}', 8.064),
(15, 10, 'a:2:{i:0;s:1:\"4\";i:1;s:1:\"5\";}', 20.736),
(12, 9, 'a:1:{i:0;s:1:\"5\";}', 10.752),
(13, 9, 'a:1:{i:0;s:1:\"5\";}', 10.752),
(14, 9, 'a:1:{i:0;s:1:\"5\";}', 10.752),
(16, 10, 'a:0:{}', 0),
(17, 10, 'a:0:{}', 0),
(18, 10, 'a:0:{}', 0),
(19, 10, 'a:1:{i:0;s:1:\"3\";}', 8.064),
(20, 10, 'a:1:{i:0;s:1:\"3\";}', 8.064),
(21, 10, 'a:1:{i:0;s:1:\"3\";}', 8.064),
(22, 10, 'a:1:{i:0;s:1:\"3\";}', 8.064),
(23, 10, 'a:1:{i:0;s:1:\"3\";}', 8.064),
(24, 12, 'a:1:{i:0;s:1:\"2\";}', 7.968),
(25, 12, 'a:1:{i:0;s:1:\"2\";}', 7.968),
(26, 12, 'a:1:{i:0;s:1:\"2\";}', 7.968),
(27, 12, 'a:1:{i:0;s:1:\"2\";}', 7.968),
(28, 12, 'a:1:{i:0;s:1:\"2\";}', 7.968),
(29, 10, 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";i:3;s:1:\"5\";i:4;s:1:\"7\";}', 117.888),
(30, 13, 'a:1:{i:0;s:1:\"1\";}', 2.292),
(31, 13, 'a:1:{i:0;s:1:\"1\";}', 11.46),
(32, 13, 'a:1:{i:0;s:1:\"2\";}', 3.984),
(33, 13, 'a:1:{i:0;s:1:\"1\";}', 4.584),
(34, 13, 'a:1:{i:0;s:1:\"1\";}', 6.876),
(35, 13, 'a:1:{i:0;s:1:\"8\";}', 6.264),
(36, 13, 'a:1:{i:0;s:1:\"1\";}', 16.044),
(37, 13, 'a:1:{i:0;s:1:\"1\";}', 16.044),
(38, 13, 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 15.144),
(39, 13, 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 20.544),
(40, 13, 'a:1:{i:0;s:1:\"2\";}', 15.36),
(41, 13, 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"4\";}', 43.908),
(42, 14, 'a:3:{i:0;s:1:\"2\";i:1;s:1:\"6\";i:2;s:1:\"8\";}', 41.772),
(43, 14, 'a:3:{i:0;s:1:\"2\";i:1;s:1:\"6\";i:2;s:1:\"8\";}', 41.772);

-- --------------------------------------------------------

--
-- Structure de la table `sitebiere`
--

DROP TABLE IF EXISTS `sitebiere`;
CREATE TABLE IF NOT EXISTS `sitebiere` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `prixht` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sitebiere`
--

INSERT INTO `sitebiere` (`id`, `nom`, `image`, `description`, `prixht`) VALUES
(1, 'La Chouffe Blonde D\'ardenne', 'https://www.beerwulf.com/globalassets/catalog/beerwulf/beers/la-chouffe-blonde-d-ardenne_opt.png?h=500&rev=899257661', 'Bière dorée légèrement trouble à mousse dense, avec un parfum épicé aux notes d’agrumes et de coriandre qui ressortent également au goût.', 1.91),
(2, 'Duvel', 'https://www.beerwulf.com/globalassets/catalog/beerwulf/beers/duvel_opt.png?h=500&rev=899257661', 'Robe jaune pâle, légèrement trouble, avec une mousse blanche incroyablement riche. L’arôme associe le citron jaune, le citron vert et les épices. La saveur incorpore des agrumes frais, le sucre de l’alcool et une note épicée due au houblon qui tire sur le poivre. En dépit de son taux d’alcool, c’est une bière fraîche qui se déguste facilement. ', 1.66),
(3, 'Duvel Tripel Hop', 'https://www.beerwulf.com/globalassets/catalog/beerwulf/beers/duvel-tripel-hop-citra.png?h=500&rev=39990364', 'Une variété supplémentaire de houblon est ajoutée à cette Duvel traditionnelle. Le HBC 291 lui procure un caractère légèrement plus épicé et poivré. Cette bière présente un fort taux d’alcool mais reste très facile à déguster grâce à ses arômes d’agrumes frais et acides, entre autres.', 2.24),
(4, 'Delirium Tremens', 'https://www.beerwulf.com/globalassets/catalog/beerwulf/beers/blond/delirium_tremens_2.png?h=500&rev=204392068', 'Bière dorée, claire à la mousse blanche pleine. Bière belge classique fortement gazéifiée et alcoolisée à la levure fruitée, arrière-goût doux.', 2.08),
(5, 'Delirium Nocturnum', 'https://www.beerwulf.com/globalassets/catalog/beerwulf/beers/delirium_nocturnum.png?h=500&rev=1038477262', 'Une bière rouge foncée brassée selon la tradition belge: à la fois forte et accessible. Des saveurs de fruits secs, de caramel et chocolat. Légèrement sucrée avec une touche épicée (réglisse et coriandre). La finale en bouche est chaude et agréable.', 2.24),
(6, 'Cuvée des Trolls', 'https://www.beerwulf.com/globalassets/catalog/beerwulf/beers/cuvee_des_trolls_2.png?h=500&rev=923839745', 'Bière brumeuse jaune paille à la mousse blanche consistante. Full body aux arômes fruités d’agrumes et de fruits jaunes. Grande douceur et petite touche acide rafraîchissante, levure. ', 1.29),
(7, 'Chimay Rouge', 'https://www.beerwulf.com/globalassets/catalog/beerwulf/beers/chimay---rood_v2.png?h=500&rev=420719671', 'Bière brune à la robe cuivrée avec une mousse durable, délicate et généreuse. Elle présente des arômes fruités de banane. D’autres parfums comme le caramel sucré, le pain frais, le pain grillé et même une touche d’amande sont aussi présents. Les mêmes arômes sucrés se retrouvent au goût et conduisent à une fin de bouche douce et légèrement amère. ', 1.49),
(8, 'Chimay Bleue', 'https://www.beerwulf.com/globalassets/catalog/beerwulf/beers/chimay---blauw_v2.png?h=500&rev=420719671', 'La Chimay Blauw, aussi connue sous le nom de Grande Réserve, est une bière trappiste reconnue. Il s’agissait au départ d’une bière de Noël, mais elle est disponible toute l’année depuis 1954. Une bière puissante et chaleureuse aux arômes de caramel et de fruits secs.', 1.74),
(9, 'Chimay Triple', 'https://www.beerwulf.com/globalassets/catalog/beerwulf/beers/chimay---wit_v2.png?h=500&rev=420719671', 'Robe de couleur doré clair, légèrement trouble avec une belle mousse blanche qui fera saliver les amateurs. Le nez et la bouche sont chargés de fruits comme le raisin et de levure. Une amertume ronde se dégage en fin de bouche.', 1.57);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf32 COLLATE utf32_bin DEFAULT NULL,
  `numrue` varchar(10) CHARACTER SET utf32 COLLATE utf32_bin DEFAULT NULL,
  `rue` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `codepostal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `ville` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `pays` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tel` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COMMENT='utilisateurs';

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `prenom`, `numrue`, `rue`, `codepostal`, `ville`, `pays`, `tel`) VALUES
(9, 'isabelle.buferne@laposte.net', 'buferne', '$2y$10$5jOLkUQ1zA4MRDREZlemrO6.qFR1moEzVRve/wHmMnvClaJyDWG9C', 'alain', '47', 'montplaisir', '03630', 'DESERTINES', 'France', '0608861282'),
(10, 'isabu77@gmail.com', 'martinez', '$2y$10$YkMQAID3aVDWyAR7pK9oRuWDGdqBl/tfg9TdWZTX9lX1PzD8B5aia', 'kevin', '25', 'AVENUE SERGE', '77500', 'CHELLES', 'France', '0666666666'),
(12, 'julien@gmail.com', 'dugrais', '$2y$10$2DacM430CoBm7qNqEqJG8OM8ym52PV0pqce90mU9oONFTWawFusWC', 'julien', '25', 'Av république', '03600', 'montluçon', 'france', '07426'),
(14, 'kevin@codev-web.fr', 'pomme', '$2y$10$du3gEqPhE11J.9L6GiP/1usx3ABoNkFc2tDA8y89SHqsdXyKdIFhO', 'kevin', '3', 'rue curie', '03600', 'montluçon', 'France', '015416');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
