-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Sam 02 Septembre 2017 à 16:17
-- Version du serveur :  5.6.35
-- Version de PHP :  7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `puppy_commerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vider la table avant d'insérer `categories`
--

TRUNCATE TABLE `categories`;
--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
  (1, 'Cool'),
  (2, 'Meh'),
  (3, 'Ok'),
  (4, 'Nice'),
  (5, 'Indecently great');

-- --------------------------------------------------------

--
-- Structure de la table `pictures`
--

CREATE TABLE `pictures` (
  `id` int(11) UNSIGNED NOT NULL,
  `productId` int(11) NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `alt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vider la table avant d'insérer `pictures`
--

TRUNCATE TABLE `pictures`;
--
-- Contenu de la table `pictures`
--

INSERT INTO `pictures` (`id`, `productId`, `url`, `alt`) VALUES
  (1, 1, 'dumbledore.jpg', 'Picture of Dumbledore'),
  (2, 2, 'kanye.jpg', 'Picture of kany, currently on sale'),
  (3, 3, 'taylor-swift.jpg', 'Picture of TSwift'),
  (4, 2, 'taylor-swift.jpg', 'Picture of TSwift');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `pictures` text NOT NULL,
  `categories` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vider la table avant d'insérer `products`
--

TRUNCATE TABLE `products`;
--
-- Contenu de la table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `pictures`, `categories`) VALUES
  (1, 'Dumbledore', 'Some old wierd wizzard with a long ass beard', 99, '\'{}\'', '\'{}\''),
  (2, 'Kanye West', 'Very self concious raper', 10, '\'{}\'', '\'{}\''),
  (3, 'Taylor Swift', 'Nice pop singer that likes blank spaces very much', 120, '\'{}\'', '\'{}\''),
  (4, 'Karris', 'Tchoin tchoin', 1, '\'{}\'', '\'{}\'');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vider la table avant d'insérer `users`
--

TRUNCATE TABLE `users`;
--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `admin`) VALUES
  (1, 'Kanye West', 'fishstick', 0),
  (2, 'Taylor Swift', 'fspotify', 0),
  (3, 'Booba', 'lepetitourson', 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;