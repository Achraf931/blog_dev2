-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  lun. 18 nov. 2019 à 13:23
-- Version du serveur :  5.7.23
-- Version de PHP :  7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog_dev2`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `published_at` datetime NOT NULL,
  `image` varchar(256) NOT NULL,
  `faker` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `title`, `description`, `published_at`, `image`, `faker`) VALUES
(44, 'Deadpool', 'Wade Wilson, un ancien militaire des forces spéciales, est devenu mercenaire. Après avoir subi une expérimentation hors-norme qui va accélérer ses pouvoirs de guérison, il va devenir Deadpool. Armé de ses nouvelles capacités et d\'un humour noir survolté, il va traquer l\'homme qui a bien failli anéantir sa vie.', '2019-11-17 17:35:55', 'b340e572642f0b28d74ab3311f8ca412.jpg', NULL),
(45, 'Broly', 'Dragon Ball Super BROLY : Un premier synopsis complet apparait sur Cine Colombia. Il y a 41 ans, le Roi de la planète Vegeta a eu un enfant, qui deviendra célèbre dans un futur pas si lointain comme le fameux Prince des Saiyans, Vegeta, et qui s\'enorgueillira de ses talents innés de combat et de sa puissance.', '2019-11-17 18:45:25', '51ebd1c778a27dce2fc4248b4e596102.jpg', NULL),
(47, 'Spider-Man', 'Orphelin, Peter Parker est élevé par sa tante May et son oncle Ben dans le quartier Queens de New York. Tout en poursuivant ses études à l\'université, il trouve un emploi de photographe au journal Daily Bugle. Il partage son appartement avec Harry Osborn, son meilleur ami, et rêve de séduire la belle Mary Jane.', '2019-11-17 18:28:36', '4cf7a40166a9a7461834f836193298cd.jpg', NULL),
(53, 'Gogeta', 'La danse de la fusion se pratique manuellement : deux guerriers de même corpulence et de même force, pratiquent symétriquement une danse où la moindre erreur peut avoir de très fâcheuses conséquences.', '2019-11-17 20:03:52', 'de0b0f04d36a3c378066217b3aadaf70.jpg', NULL),
(57, 'La liberté d\'atteindre vos buts plus simplement', 'Oui, madame Lefrançois, tous les trois. Enfin le bonhomme eût laissé tomber sa plume pour rêver quelque temps. «Quant à moi, préféré la cuisine les plats, les marmites, les chaises, les flambeaux.', '2019-11-17 21:30:06', 'https://lorempixel.com/640/480/?80550', 'faker'),
(58, 'La possibilité d\'évoluer à l\'état pur', 'Saint-Herbland, au moment où la garde nationale et les pays, traverser les obstacles, mordre aux bonheurs les plus intimes, fut, comme un homme d\'allure chétive, rubicond et chauve, entra chez elle.', '2019-11-17 21:30:08', 'https://lorempixel.com/640/480/?96402', 'faker');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `content` text NOT NULL,
  `email` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `name`, `content`, `email`) VALUES
(33, 'Test unndeuxrezkogez', 'Lol', 'hamrounich@outlook.fr'),
(34, 'Spider-Man', 'Ca fonctionne !', 'hamrounich@outlook.fr'),
(35, 'Spider-Man', 'Ca fonctionne !', 'hamrounich@outlook.fr'),
(36, 'Charfeddine Hamrouni', 'iujijjjjk', 'hamrounich@outlook.fr'),
(37, 'Charfeddine Hamrouni', 'jbhuuy', 'hamrounich@outlook.fr'),
(38, 'Charfeddine Hamrouni', 'lol\r\n', 'hamrounich@outlook.fr'),
(39, 'Charfeddine Hamrouni', 'ffff', 'hamrounich@outlook.fr'),
(40, 'Charfeddine Hamrouni', 'ffff', 'hamrounich@outlook.fr'),
(41, 'Charfeddine Hamrouni', 'ffff', 'hamrounich@outlook.fr'),
(42, 'Charfeddine Hamrouni', 'ffff', 'hamrounich@outlook.fr'),
(43, 'Charfeddine Hamrouni', 'ffff', 'hamrounich@outlook.fr');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
