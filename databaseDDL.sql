
-- Хост: localhost
-- Время создания: Июн 27 2020 г., 22:33
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cinema`
--
CREATE DATABASE IF NOT EXISTS `cinema` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cinema`;

-- --------------------------------------------------------

--
-- Структура таблицы `actors`
--

CREATE TABLE `actors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `about_text` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `actors`:
--

-- --------------------------------------------------------

--
-- Структура таблицы `actors_in_movies`
--

CREATE TABLE `actors_in_movies` (
  `id` int(11) NOT NULL,
  `actor_id` int(11) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `actors_in_movies`:
--   `actor_id`
--       `actors` -> `id`
--   `movie_id`
--       `movies` -> `id`
--

-- --------------------------------------------------------

--
-- Структура таблицы `actor_types`
--

CREATE TABLE `actor_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `actor_types`:
--

-- --------------------------------------------------------

--
-- Структура таблицы `actor_types_added`
--

CREATE TABLE `actor_types_added` (
  `id` int(11) NOT NULL,
  `actor_type` int(11) DEFAULT NULL,
  `actor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `actor_types_added`:
--   `actor_id`
--       `actors` -> `id`
--   `actor_type`
--       `actor_types` -> `id`
--

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `ru_name` varchar(255) DEFAULT NULL,
  `en_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `countries`:
--

-- --------------------------------------------------------

--
-- Структура таблицы `countries_added`
--

CREATE TABLE `countries_added` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `countries_added`:
--   `movie_id`
--       `movies` -> `id`
--   `country_id`
--       `countries` -> `id`
--

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `genres`:
--

-- --------------------------------------------------------

--
-- Структура таблицы `genres_added`
--

CREATE TABLE `genres_added` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `genres_added`:
--   `movie_id`
--       `movies` -> `id`
--   `genre_id`
--       `genres` -> `id`
--

-- --------------------------------------------------------

--
-- Структура таблицы `halls`
--

CREATE TABLE `halls` (
  `id` int(11) NOT NULL,
  `number` smallint(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `space` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `halls`:
--

-- --------------------------------------------------------

--
-- Структура таблицы `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  `description` text NOT NULL,
  `trailer` varchar(255) NOT NULL,
  `image_folder` varchar(255) NOT NULL,
  `genre` smallint(6) NOT NULL,
  `duration` int(11) NOT NULL,
  `censor` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `movies`:
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `pay_type_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `orders`:
--   `id`
--       `pay_types` -> `id`
--

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `timetable_id` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `tickets_amount` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `price_total` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `order_items`:
--   `id`
--       `timetable` -> `id`
--   `order_id`
--       `orders` -> `id`
--

-- --------------------------------------------------------

--
-- Структура таблицы `order_place`
--

CREATE TABLE `order_place` (
  `id` int(11) NOT NULL,
  `order_item_id` int(11) DEFAULT NULL,
  `place` int(11) DEFAULT NULL,
  `row` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='выбор места в зале';

--
-- ССЫЛКИ ТАБЛИЦЫ `order_place`:
--   `order_item_id`
--       `order_items` -> `id`
--

-- --------------------------------------------------------

--
-- Структура таблицы `pay_types`
--

CREATE TABLE `pay_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `pay_types`:
--

-- --------------------------------------------------------

--
-- Структура таблицы `prices`
--

CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `timetable_id` int(11) DEFAULT NULL,
  `price_category_id` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `prices`:
--   `timetable_id`
--       `timetable` -> `id`
--   `price_category_id`
--       `price_category` -> `id`
--

-- --------------------------------------------------------

--
-- Структура таблицы `price_category`
--

CREATE TABLE `price_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `price_category`:
--

-- --------------------------------------------------------

--
-- Структура таблицы `producers_in_movies`
--

CREATE TABLE `producers_in_movies` (
  `id` int(11) NOT NULL,
  `actor_id` int(11) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `producers_in_movies`:
--   `actor_id`
--       `actors` -> `id`
--   `movie_id`
--       `movies` -> `id`
--

-- --------------------------------------------------------

--
-- Структура таблицы `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `hall_id` int(11) DEFAULT NULL,
  `time_start` time DEFAULT NULL,
  `time_finish` time DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ССЫЛКИ ТАБЛИЦЫ `timetable`:
--   `movie_id`
--       `movies` -> `id`
--   `id`
--       `halls` -> `id`
--

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `actors_in_movies`
--
ALTER TABLE `actors_in_movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actors_in_movies_FK` (`actor_id`),
  ADD KEY `actors_in_movies_FK_1` (`movie_id`);

--
-- Индексы таблицы `actor_types`
--
ALTER TABLE `actor_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `actor_types_added`
--
ALTER TABLE `actor_types_added`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actor_types_added_FK` (`actor_id`),
  ADD KEY `actor_types_added_FK_1` (`actor_type`);

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `countries_added`
--
ALTER TABLE `countries_added`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countries_added_FK` (`movie_id`),
  ADD KEY `countries_added_FK_1` (`country_id`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `genres_added`
--
ALTER TABLE `genres_added`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genres_added_FK` (`movie_id`),
  ADD KEY `genres_added_FK_1` (`genre_id`);

--
-- Индексы таблицы `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_FK_1` (`order_id`);

--
-- Индексы таблицы `order_place`
--
ALTER TABLE `order_place`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_place_FK` (`order_item_id`);

--
-- Индексы таблицы `pay_types`
--
ALTER TABLE `pay_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prices_FK` (`timetable_id`),
  ADD KEY `prices_FK_1` (`price_category_id`);

--
-- Индексы таблицы `price_category`
--
ALTER TABLE `price_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `producers_in_movies`
--
ALTER TABLE `producers_in_movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producers_in_movies_FK` (`actor_id`),
  ADD KEY `producers_in_movies_FK_1` (`movie_id`);

--
-- Индексы таблицы `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timetable_FK` (`movie_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `actors`
--
ALTER TABLE `actors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `actors_in_movies`
--
ALTER TABLE `actors_in_movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `actor_types`
--
ALTER TABLE `actor_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `actor_types_added`
--
ALTER TABLE `actor_types_added`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `countries_added`
--
ALTER TABLE `countries_added`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `genres_added`
--
ALTER TABLE `genres_added`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order_place`
--
ALTER TABLE `order_place`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `pay_types`
--
ALTER TABLE `pay_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `price_category`
--
ALTER TABLE `price_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `producers_in_movies`
--
ALTER TABLE `producers_in_movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `actors_in_movies`
--
ALTER TABLE `actors_in_movies`
  ADD CONSTRAINT `actors_in_movies_FK` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `actors_in_movies_FK_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `actor_types_added`
--
ALTER TABLE `actor_types_added`
  ADD CONSTRAINT `actor_types_added_FK` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`id`),
  ADD CONSTRAINT `actor_types_added_FK_1` FOREIGN KEY (`actor_type`) REFERENCES `actor_types` (`id`);

--
-- Ограничения внешнего ключа таблицы `countries_added`
--
ALTER TABLE `countries_added`
  ADD CONSTRAINT `countries_added_FK` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `countries_added_FK_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `genres_added`
--
ALTER TABLE `genres_added`
  ADD CONSTRAINT `genres_added_FK` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `genres_added_FK_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_FK` FOREIGN KEY (`id`) REFERENCES `pay_types` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_FK` FOREIGN KEY (`id`) REFERENCES `timetable` (`id`),
  ADD CONSTRAINT `order_items_FK_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_place`
--
ALTER TABLE `order_place`
  ADD CONSTRAINT `order_place_FK` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`);

--
-- Ограничения внешнего ключа таблицы `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `prices_FK` FOREIGN KEY (`timetable_id`) REFERENCES `timetable` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prices_FK_1` FOREIGN KEY (`price_category_id`) REFERENCES `price_category` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `producers_in_movies`
--
ALTER TABLE `producers_in_movies`
  ADD CONSTRAINT `producers_in_movies_FK` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `producers_in_movies_FK_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `timetable_FK` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_FK_1` FOREIGN KEY (`id`) REFERENCES `halls` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
