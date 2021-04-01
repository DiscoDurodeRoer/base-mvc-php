-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-04-2021 a las 19:54:26
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base-mvc-php`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `description` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `parent_cat` int(11) NOT NULL,
  `icon` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `parent_cat`, `icon`, `num_topics`) VALUES
(1, 'Inicio', '', 1, '', 0),
(2, 'Programación', '', 1, '', 0),
(3, 'Java', '', 2, '', 0),
(4, 'Python', '', 2, '', 0),
(5, 'Javascript', '', 2, '', 0),
(6, 'Sobre el foro', 'Información útil sobre el foro', 1, '', 0),
(7, 'General', 'Topics sobre Java', 3, '', 0),
(8, 'Ficheros', 'Topics sobre ficheros Java', 3, '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories_child`
--

CREATE TABLE `categories_child` (
  `id_cat` int(11) NOT NULL,
  `id_cat_parent` int(11) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categories_child`
--

INSERT INTO `categories_child` (`id_cat`, `id_cat_parent`, `level`) VALUES
(1, 1, 1),
(2, 1, 1),
(2, 2, 2),
(3, 1, 1),
(3, 2, 2),
(3, 3, 3),
(4, 1, 1),
(4, 2, 2),
(4, 4, 3),
(5, 1, 1),
(5, 2, 2),
(5, 5, 3),
(6, 1, 1),
(6, 6, 2),
(7, 1, 1),
(7, 2, 2),
(7, 3, 3),
(7, 7, 4),
(8, 1, 1),
(8, 2, 2),
(8, 3, 3),
(8, 8, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `text` text COLLATE utf8_spanish_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `user_origin` int(11) NOT NULL,
  `show_message` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rol` varchar(40) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `title` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `creator_user` int(11) NOT NULL,
  `open` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `topics`
--
DELIMITER $$
CREATE TRIGGER `update_num_topics_delete` AFTER DELETE ON `topics` FOR EACH ROW BEGIN
    
    declare num_topics_update int(11);
    	
    SELECT count(*) into num_topics_update FROM topics WHERE id_cat = OLD.id_cat;
    
   	UPDATE categories SET num_topics = num_topics_update where id = OLD.id_cat;
    
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_num_topics_insert` AFTER INSERT ON `topics` FOR EACH ROW BEGIN
    
    declare num_topics_update int(11);
    	
    SELECT count(*) into num_topics_update FROM topics WHERE id_cat = NEW.id_cat;
    
   	UPDATE categories SET num_topics = num_topics_update where id = NEW.id_cat;
   
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_num_topics_update` AFTER UPDATE ON `topics` FOR EACH ROW BEGIN
    
    declare num_topics_update int(11);
    
    SELECT count(*) into num_topics_update FROM topics WHERE id_cat = NEW.id_cat;
    
    UPDATE categories SET num_topics = num_topics_update where id = NEW.id_cat;
        
    SELECT count(*) into num_topics_update FROM topics WHERE id_cat = OLD.id_cat;
    
    UPDATE categories SET num_topics = num_topics_update where id = OLD.id_cat;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `surname` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nickname` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `registry_date` date NOT NULL,
  `avatar` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `rol` int(11) NOT NULL,
  `last_connection` datetime NOT NULL,
  `baneado` int(11) NOT NULL,
  `borrado` int(11) NOT NULL,
  `verificado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `nickname`, `email`, `pass`, `registry_date`, `avatar`, `rol`, `last_connection`, `baneado`, `borrado`, `verificado`) VALUES
(1, 'disco', 'duro de roer', 'discoduroderoer', 'administrador@discoduroderoer.es', '6df1a9f518a73b3d978b1b753eba66b8e7c46cd117879faf585f4debe54ddd04467a9ad3a4ddc13dc04e32c852248807b6ac5aea136c11734cfda301411b4084', '2019-10-22', 'http://localhost:8080/base-mvc-php/public/img/default-avatar.jpg', 1, '2019-10-22 00:00:00', 0, 0, 1),
(6, 'fer', 'fer', 'ddr', 'email@email.com', '6df1a9f518a73b3d978b1b753eba66b8e7c46cd117879faf585f4debe54ddd04467a9ad3a4ddc13dc04e32c852248807b6ac5aea136c11734cfda301411b4084', '2019-10-31', 'http://localhost:8080/base-mvc-php/public/img/default-avatar.jpg', 2, '2019-10-31 20:09:00', 0, 1, 1),
(7, 'ddr3', 'ddr3', 'ddr3', 'ddr3@ddr3.com', '6df1a9f518a73b3d978b1b753eba66b8e7c46cd117879faf585f4debe54ddd04467a9ad3a4ddc13dc04e32c852248807b6ac5aea136c11734cfda301411b4084', '2019-11-05', 'http://localhost:8080/base-mvc-php/public/img/default-avatar.jpg', 2, '2019-11-05 19:22:00', 1, 1, 1),
(8, 'ddr4', 'ddr4', 'ddr4', 'ddr4@ddr4.com', 'e10adc3949ba59abbe56e057f20f883e', '2019-11-05', 'http://localhost:8080/base-mvc-php/public/img/default-avatar.jpg', 2, '2019-11-05 19:37:00', 0, 1, 1),
(9, 'ddr5', 'ddr5', 'ddr5', 'ddr5@ddr5.com', '6df1a9f518a73b3d978b1b753eba66b8e7c46cd117879faf585f4debe54ddd04467a9ad3a4ddc13dc04e32c852248807b6ac5aea136c11734cfda301411b4084', '2019-11-05', 'http://localhost:8080/base-mvc-php/public/img/default-avatar.jpg', 2, '2019-11-05 19:39:00', 0, 1, 1),
(10, 'Pepito2', 'Perez2', 'ddr6', 'ddr7@ddr7.com', '68c6932d39d733b092c9b998d0e0571ed2ac008f1ac8b7bc0ef65dd497bc89448d9bd755721dd61468dd151259a6d5ac3b87cef97223b341a48aa72ad4e77d1c', '2019-11-05', 'http://localhost:8080/base-mvc-php/public/img/default-avatar.jpg', 1, '2019-11-05 20:25:00', 0, 0, 1),
(11, 'ddr7', 'ddr7', 'ddr7', 'ddr7@ddr7.es', '6df1a9f518a73b3d978b1b753eba66b8e7c46cd117879faf585f4debe54ddd04467a9ad3a4ddc13dc04e32c852248807b6ac5aea136c11734cfda301411b4084', '2020-03-05', 'http://localhost:8080/base-mvc-php/public/img/default-avatar.jpg', 1, '2020-03-05 18:52:00', 0, 0, 1),
(12, 'ddr8', 'ddr8', 'ddr8', 'ddr8@ddr8.com', '6df1a9f518a73b3d978b1b753eba66b8e7c46cd117879faf585f4debe54ddd04467a9ad3a4ddc13dc04e32c852248807b6ac5aea136c11734cfda301411b4084', '2020-04-01', 'http://localhost:8080/base-mvc-php/public/img/default-avatar.jpg', 2, '2020-04-01 20:11:00', 0, 0, 1),
(13, 'fer', 'er', 'fer', 'fer@fer.es', '6df1a9f518a73b3d978b1b753eba66b8e7c46cd117879faf585f4debe54ddd04467a9ad3a4ddc13dc04e32c852248807b6ac5aea136c11734cfda301411b4084', '2020-05-14', 'http://localhost:8080/base-mvc-php/public/img/default-avatar.jpg', 2, '2020-05-14 19:19:00', 0, 0, 1),
(14, 'fer2', 'fer2', 'fer2', 'fer@fer2.es', '6df1a9f518a73b3d978b1b753eba66b8e7c46cd117879faf585f4debe54ddd04467a9ad3a4ddc13dc04e32c852248807b6ac5aea136c11734cfda301411b4084', '2020-05-14', 'http://localhost:8080/base-mvc-php/public/img/default-avatar.jpg', 2, '2020-05-14 20:37:00', 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_activation`
--

CREATE TABLE `users_activation` (
  `id_user` int(11) NOT NULL,
  `user_key` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_remember`
--

CREATE TABLE `users_remember` (
  `id_user` int(11) NOT NULL,
  `user_key` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users_remember`
--

INSERT INTO `users_remember` (`id_user`, `user_key`) VALUES
(14, 'aWfn01PD68pkuQ322vFY');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categories_parent_cat` (`parent_cat`);

--
-- Indices de la tabla `categories_child`
--
ALTER TABLE `categories_child`
  ADD PRIMARY KEY (`id_cat`,`id_cat_parent`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_messages_user_origin` (`user_origin`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_topics_id_user` (`creator_user`),
  ADD KEY `fk_topics_id_cat` (`id_cat`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_id_rol` (`rol`);

--
-- Indices de la tabla `users_activation`
--
ALTER TABLE `users_activation`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `users_remember`
--
ALTER TABLE `users_remember`
  ADD PRIMARY KEY (`id_user`,`user_key`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_parent_cat` FOREIGN KEY (`parent_cat`) REFERENCES `categories` (`id`);

--
-- Filtros para la tabla `categories_child`
--
ALTER TABLE `categories_child`
  ADD CONSTRAINT `fk_categories_id` FOREIGN KEY (`id_cat`) REFERENCES `categories` (`id`);

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_user_origin` FOREIGN KEY (`user_origin`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `fk_topics_id_cat` FOREIGN KEY (`id_cat`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_topics_id_user` FOREIGN KEY (`creator_user`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_id_rol` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `users_activation`
--
ALTER TABLE `users_activation`
  ADD CONSTRAINT `users_user_activation` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
