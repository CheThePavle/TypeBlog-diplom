-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 11 2022 г., 21:49
-- Версия сервера: 8.0.24
-- Версия PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `maslov`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ad`
--

CREATE TABLE `ad` (
  `id_ad` bigint UNSIGNED NOT NULL,
  `id_status_ad` bigint UNSIGNED NOT NULL,
  `id_mark_ad` bigint UNSIGNED NOT NULL,
  `id_img_ad` bigint UNSIGNED NOT NULL,
  `title_ad` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description_ad` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `body_ad` json DEFAULT NULL,
  `created_at_ad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at_ad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ad_status`
--

CREATE TABLE `ad_status` (
  `id_status_ad` bigint UNSIGNED NOT NULL,
  `code_status_ad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name_status_ad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `img`
--

CREATE TABLE `img` (
  `id_img` bigint UNSIGNED NOT NULL,
  `url_img` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `img_ad`
--

CREATE TABLE `img_ad` (
  `id_img` bigint UNSIGNED NOT NULL,
  `id_ad` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mark`
--

CREATE TABLE `mark` (
  `id_mark` bigint UNSIGNED NOT NULL,
  `name_mark` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `model`
--

CREATE TABLE `model` (
  `id_model` bigint UNSIGNED NOT NULL,
  `name_model` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `model_mark`
--

CREATE TABLE `model_mark` (
  `id_model` bigint UNSIGNED NOT NULL,
  `id_mark` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id_user` bigint UNSIGNED NOT NULL,
  `id_role` bigint UNSIGNED NOT NULL,
  `id_avatar` bigint UNSIGNED DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_role`
--

CREATE TABLE `user_role` (
  `id_role` bigint UNSIGNED NOT NULL,
  `code_role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name_role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ad`
--
ALTER TABLE `ad`
  ADD PRIMARY KEY (`id_ad`),
  ADD KEY `id_status_ad` (`id_status_ad`,`id_mark_ad`,`id_img_ad`),
  ADD KEY `id_mark_ad` (`id_mark_ad`),
  ADD KEY `id_img_ad` (`id_img_ad`);

--
-- Индексы таблицы `ad_status`
--
ALTER TABLE `ad_status`
  ADD PRIMARY KEY (`id_status_ad`);

--
-- Индексы таблицы `img`
--
ALTER TABLE `img`
  ADD PRIMARY KEY (`id_img`);

--
-- Индексы таблицы `img_ad`
--
ALTER TABLE `img_ad`
  ADD KEY `id_img` (`id_img`,`id_ad`),
  ADD KEY `id_ad` (`id_ad`);

--
-- Индексы таблицы `mark`
--
ALTER TABLE `mark`
  ADD PRIMARY KEY (`id_mark`);

--
-- Индексы таблицы `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id_model`),
  ADD KEY `id_model` (`id_model`,`name_model`);

--
-- Индексы таблицы `model_mark`
--
ALTER TABLE `model_mark`
  ADD KEY `id_model` (`id_model`,`id_mark`),
  ADD KEY `id_mark` (`id_mark`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`,`id_avatar`),
  ADD KEY `id_avatar` (`id_avatar`);

--
-- Индексы таблицы `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_role`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `ad`
--
ALTER TABLE `ad`
  MODIFY `id_ad` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ad_status`
--
ALTER TABLE `ad_status`
  MODIFY `id_status_ad` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `img`
--
ALTER TABLE `img`
  MODIFY `id_img` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mark`
--
ALTER TABLE `mark`
  MODIFY `id_mark` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `model`
--
ALTER TABLE `model`
  MODIFY `id_model` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_role` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ad`
--
ALTER TABLE `ad`
  ADD CONSTRAINT `ad_ibfk_1` FOREIGN KEY (`id_status_ad`) REFERENCES `ad_status` (`id_status_ad`),
  ADD CONSTRAINT `ad_ibfk_2` FOREIGN KEY (`id_mark_ad`) REFERENCES `mark` (`id_mark`),
  ADD CONSTRAINT `ad_ibfk_3` FOREIGN KEY (`id_img_ad`) REFERENCES `img` (`id_img`);

--
-- Ограничения внешнего ключа таблицы `img_ad`
--
ALTER TABLE `img_ad`
  ADD CONSTRAINT `img_ad_ibfk_1` FOREIGN KEY (`id_img`) REFERENCES `img` (`id_img`),
  ADD CONSTRAINT `img_ad_ibfk_2` FOREIGN KEY (`id_ad`) REFERENCES `ad` (`id_ad`);

--
-- Ограничения внешнего ключа таблицы `model_mark`
--
ALTER TABLE `model_mark`
  ADD CONSTRAINT `model_mark_ibfk_1` FOREIGN KEY (`id_mark`) REFERENCES `mark` (`id_mark`),
  ADD CONSTRAINT `model_mark_ibfk_2` FOREIGN KEY (`id_model`) REFERENCES `model` (`id_model`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`id_avatar`) REFERENCES `img` (`id_img`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
