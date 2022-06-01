-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 26 2022 г., 14:01
-- Версия сервера: 8.0.19
-- Версия PHP: 8.0.1

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
  `id_creator_ad` bigint UNSIGNED NOT NULL,
  `id_status_ad` bigint UNSIGNED NOT NULL,
  `id_mark_ad` bigint UNSIGNED NOT NULL,
  `id_img_ad` bigint UNSIGNED NOT NULL,
  `title_ad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description_ad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `body_ad` json DEFAULT NULL,
  `created_at_ad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at_ad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ad_favorite`
--

CREATE TABLE `ad_favorite` (
  `id_ad` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `created_at_favorite` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ad_status`
--

CREATE TABLE `ad_status` (
  `id_status` bigint UNSIGNED NOT NULL,
  `code_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `ad_status`
--

INSERT INTO `ad_status` (`id_status`, `code_status`, `name_status`) VALUES
(1, 'send', 'Отправлен'),
(2, 'published', 'Опубликован'),
(3, 'rejected', 'Отклонен'),
(4, 'completed', 'Завершен');

-- --------------------------------------------------------

--
-- Структура таблицы `img`
--

CREATE TABLE `img` (
  `id_img` bigint UNSIGNED NOT NULL,
  `url_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `img`
--

INSERT INTO `img` (`id_img`, `url_img`) VALUES
(1, '/public/img/marks/bmw.png'),
(2, '/public/img/marks/audi.png'),
(3, '/public/img/marks/hyundai.png'),
(4, '/public/img/marks/kia.png'),
(5, '/public/img/marks/mitsubishi.png'),
(6, '/public/img/marks/volkswagen.png'),
(7, '/public/img/marks/honda.png'),
(8, '/public/img/marks/toyota.png');

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
-- Структура таблицы `object`
--

CREATE TABLE `object` (
  `id_object` bigint UNSIGNED NOT NULL,
  `name_object` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_type_object` bigint UNSIGNED NOT NULL,
  `id_img_object` bigint UNSIGNED DEFAULT NULL,
  `parent_id_object` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `object`
--

INSERT INTO `object` (`id_object`, `name_object`, `id_type_object`, `id_img_object`, `parent_id_object`) VALUES
(1, 'BMW', 1, 1, NULL),
(2, 'Hyundai', 1, 3, NULL),
(3, 'Mitsubishi', 1, 5, NULL),
(4, 'Honda', 1, 7, NULL),
(5, 'AUDI', 1, 2, NULL),
(6, 'Kia', 1, 4, NULL),
(7, 'Volkswagen', 1, 6, NULL),
(8, 'Toyota', 1, 8, NULL),
(9, '116', 2, NULL, 1),
(10, '116i', 2, NULL, 1),
(11, '120i', 2, NULL, 1),
(12, 'Accent', 2, NULL, 2),
(13, 'Aero', 2, NULL, 2),
(14, 'Amica', 2, NULL, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `object_type`
--

CREATE TABLE `object_type` (
  `id_type` bigint UNSIGNED NOT NULL,
  `name_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `object_type`
--

INSERT INTO `object_type` (`id_type`, `name_type`) VALUES
(1, 'Марка'),
(2, 'Модель');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id_user` bigint UNSIGNED NOT NULL,
  `id_role` bigint UNSIGNED NOT NULL,
  `id_avatar` bigint UNSIGNED DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id_user`, `id_role`, `id_avatar`, `last_name`, `first_name`, `phone`, `email`, `password`) VALUES
(1, 1, NULL, 'Иванов', 'Иван', '73444563465', 'user@mail.ru', '$2y$10$JrWwTdPCvOSyKY2lIy6x5O8f9gbSsNzn.WZFVEC28Km2Zl3osgo5.'),
(2, 2, NULL, 'Мосолов', 'Игорь', '77777777777', 'admin@mail.ru', '$2y$10$o6yr8TvdRr/mIwycW4x.jedBvPPn3SXSefGY0a1PMsm3Xg0IMGPQ6');

-- --------------------------------------------------------

--
-- Структура таблицы `user_role`
--

CREATE TABLE `user_role` (
  `id_role` bigint UNSIGNED NOT NULL,
  `code_role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name_role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user_role`
--

INSERT INTO `user_role` (`id_role`, `code_role`, `name_role`) VALUES
(1, 'user', 'Пользователь'),
(2, 'admin', 'Администратор');

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
  ADD KEY `id_img_ad` (`id_img_ad`),
  ADD KEY `id_creator_ad` (`id_creator_ad`);

--
-- Индексы таблицы `ad_favorite`
--
ALTER TABLE `ad_favorite`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_ad` (`id_ad`);

--
-- Индексы таблицы `ad_status`
--
ALTER TABLE `ad_status`
  ADD PRIMARY KEY (`id_status`);

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
-- Индексы таблицы `object`
--
ALTER TABLE `object`
  ADD PRIMARY KEY (`id_object`),
  ADD KEY `id_type_object` (`id_type_object`),
  ADD KEY `id_img_object` (`id_img_object`),
  ADD KEY `parent_id_object` (`parent_id_object`);

--
-- Индексы таблицы `object_type`
--
ALTER TABLE `object_type`
  ADD PRIMARY KEY (`id_type`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`),
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
  MODIFY `id_ad` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT для таблицы `ad_status`
--
ALTER TABLE `ad_status`
  MODIFY `id_status` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `img`
--
ALTER TABLE `img`
  MODIFY `id_img` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `object`
--
ALTER TABLE `object`
  MODIFY `id_object` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `object_type`
--
ALTER TABLE `object_type`
  MODIFY `id_type` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_role` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ad`
--
ALTER TABLE `ad`
  ADD CONSTRAINT `ad_ibfk_1` FOREIGN KEY (`id_status_ad`) REFERENCES `ad_status` (`id_status`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ad_ibfk_3` FOREIGN KEY (`id_img_ad`) REFERENCES `img` (`id_img`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ad_ibfk_4` FOREIGN KEY (`id_mark_ad`) REFERENCES `object` (`id_object`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ad_ibfk_5` FOREIGN KEY (`id_creator_ad`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `ad_favorite`
--
ALTER TABLE `ad_favorite`
  ADD CONSTRAINT `ad_favorite_ibfk_1` FOREIGN KEY (`id_ad`) REFERENCES `ad` (`id_ad`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `ad_favorite_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `img_ad`
--
ALTER TABLE `img_ad`
  ADD CONSTRAINT `img_ad_ibfk_1` FOREIGN KEY (`id_img`) REFERENCES `img` (`id_img`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `img_ad_ibfk_2` FOREIGN KEY (`id_ad`) REFERENCES `ad` (`id_ad`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `object`
--
ALTER TABLE `object`
  ADD CONSTRAINT `object_ibfk_1` FOREIGN KEY (`id_type_object`) REFERENCES `object_type` (`id_type`),
  ADD CONSTRAINT `object_ibfk_2` FOREIGN KEY (`id_img_object`) REFERENCES `img` (`id_img`),
  ADD CONSTRAINT `object_ibfk_3` FOREIGN KEY (`parent_id_object`) REFERENCES `object` (`id_object`);

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
