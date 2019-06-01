-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: mysql
-- Время создания: Июн 01 2019 г., 08:36
-- Версия сервера: 5.7.26
-- Версия PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cinema`
--

-- --------------------------------------------------------

--
-- Структура таблицы `hall`
--

CREATE TABLE `hall` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `size` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `hall_price`
--

CREATE TABLE `hall_price` (
  `id` int(11) NOT NULL,
  `hall_type` int(11) DEFAULT NULL,
  `rows` varchar(255) DEFAULT NULL,
  `seats` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `hall_type`
--

CREATE TABLE `hall_type` (
  `id` int(11) NOT NULL,
  `rows` int(2) DEFAULT NULL,
  `row_seats` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `movie`
--

INSERT INTO `movie` (`id`, `name`) VALUES
(1, 'Sit Institute'),
(2, 'Libero Dui Nec Consulting'),
(3, 'Quis Accumsan Convallis PC'),
(4, 'Lorem Institute');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `movies_attributes`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `movies_attributes` (
`name` varchar(45)
,`attributeName` varchar(45)
,`attributeValue` mediumtext
);

-- --------------------------------------------------------

--
-- Структура таблицы `movie_attribute`
--

CREATE TABLE `movie_attribute` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `movie_attribute`
--

INSERT INTO `movie_attribute` (`id`, `name`, `type`) VALUES
(1, 'Рецензия от критика', 4),
(2, 'Премия на оскар', 3),
(3, 'Мировая премьера', 1),
(4, 'Начало рекламной компании в СМИ', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `movie_attribute_type`
--

CREATE TABLE `movie_attribute_type` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `movie_attribute_type`
--

INSERT INTO `movie_attribute_type` (`id`, `name`) VALUES
(1, 'Тип важная дата'),
(2, 'Тип служебная дата'),
(3, 'Тип премия'),
(4, 'Тип рецензия');

-- --------------------------------------------------------

--
-- Структура таблицы `movie_attribute_value_boolean`
--

CREATE TABLE `movie_attribute_value_boolean` (
  `id` int(11) NOT NULL,
  `attribute` int(11) DEFAULT NULL,
  `movie` int(11) DEFAULT NULL,
  `value` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `movie_attribute_value_boolean`
--

INSERT INTO `movie_attribute_value_boolean` (`id`, `attribute`, `movie`, `value`) VALUES
(1, 2, 1, 1),
(2, 2, 2, 2),
(3, 2, 3, 3),
(4, 2, 4, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `movie_attribute_value_datetime`
--

CREATE TABLE `movie_attribute_value_datetime` (
  `id` int(11) NOT NULL,
  `attribute` int(11) DEFAULT NULL,
  `movie` int(11) DEFAULT NULL,
  `value` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `movie_attribute_value_datetime`
--

INSERT INTO `movie_attribute_value_datetime` (`id`, `attribute`, `movie`, `value`) VALUES
(1, 3, 1, '2019-05-31 00:00:00'),
(2, 3, 2, '2019-06-21 00:00:00'),
(3, 3, 3, '2019-06-03 00:00:00'),
(4, 3, 4, '2019-06-04 00:00:00'),
(5, 4, 1, '2019-06-01 00:00:00'),
(6, 4, 2, '2019-06-21 00:00:00'),
(7, 4, 3, '2019-06-03 00:00:00'),
(8, 4, 4, '2019-05-04 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `movie_attribute_value_text`
--

CREATE TABLE `movie_attribute_value_text` (
  `id` int(11) NOT NULL,
  `attribute` int(11) DEFAULT NULL,
  `movie` int(11) DEFAULT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `movie_attribute_value_text`
--

INSERT INTO `movie_attribute_value_text` (`id`, `attribute`, `movie`, `value`) VALUES
(1, 1, 1, 'Рецензия о фильме #1'),
(2, 1, 2, 'Рецензия о фильме #2'),
(3, 1, 3, 'Рецензия о фильме #3'),
(4, 1, 4, 'Рецензия о фильме #4');

-- --------------------------------------------------------

--
-- Структура таблицы `movie_rewards`
--

CREATE TABLE `movie_rewards` (
  `id` int(11) NOT NULL,
  `movie` int(11) DEFAULT NULL,
  `print` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `hall` int(11) DEFAULT NULL,
  `show` int(11) DEFAULT NULL,
  `datetime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `session` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `row` int(2) DEFAULT NULL,
  `seat` int(2) DEFAULT NULL,
  `user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `pass` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура для представления `movies_attributes`
--
DROP TABLE IF EXISTS `movies_attributes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `movies_attributes`  AS  select `m`.`name` AS `name`,`a`.`attributeName` AS `attributeName`,`a`.`attributeValue` AS `attributeValue` from (`movie` `m` left join (select `movie_attribute`.`name` AS `attributeName`,`avd`.`value` AS `attributeValue`,`avd`.`movie` AS `movie` from (`movie_attribute_value_datetime` `avd` left join `movie_attribute` on((`avd`.`attribute` = `movie_attribute`.`id`))) union select `movie_attribute`.`name` AS `attributeName`,`avb`.`value` AS `attributeValue`,`avb`.`movie` AS `movie` from (`movie_attribute_value_boolean` `avb` left join `movie_attribute` on((`avb`.`attribute` = `movie_attribute`.`id`))) union select `movie_attribute`.`name` AS `attributeName`,`avt`.`value` AS `attributeValue`,`avt`.`movie` AS `movie` from (`movie_attribute_value_text` `avt` left join `movie_attribute` on((`avt`.`attribute` = `movie_attribute`.`id`)))) `a` on((`m`.`id` = `a`.`movie`))) ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `hall`
--
ALTER TABLE `hall`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hall_size_idx` (`size`);

--
-- Индексы таблицы `hall_price`
--
ALTER TABLE `hall_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hall_price_type_idx` (`hall_type`);

--
-- Индексы таблицы `hall_type`
--
ALTER TABLE `hall_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `movie_attribute`
--
ALTER TABLE `movie_attribute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_movie_attribute_1_idx` (`type`);

--
-- Индексы таблицы `movie_attribute_type`
--
ALTER TABLE `movie_attribute_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `movie_attribute_value_boolean`
--
ALTER TABLE `movie_attribute_value_boolean`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_movie_attribute_value_datetime_1_idx` (`movie`),
  ADD KEY `fk_movie_attribute_value_datetime_2_idx` (`attribute`);

--
-- Индексы таблицы `movie_attribute_value_datetime`
--
ALTER TABLE `movie_attribute_value_datetime`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_movie_attribute_value_datetime_1_idx` (`movie`),
  ADD KEY `fk_movie_attribute_value_datetime_2_idx` (`attribute`);

--
-- Индексы таблицы `movie_attribute_value_text`
--
ALTER TABLE `movie_attribute_value_text`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_movie_attribute_value_datetime_1_idx` (`movie`),
  ADD KEY `fk_movie_attribute_value_datetime_2_idx` (`attribute`);

--
-- Индексы таблицы `movie_rewards`
--
ALTER TABLE `movie_rewards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_movie_rewards_1_idx` (`movie`);

--
-- Индексы таблицы `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_session_show_idx` (`show`),
  ADD KEY `fk_session_hall_idx` (`hall`);

--
-- Индексы таблицы `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ticket_session_idx` (`session`),
  ADD KEY `fk_ticket_price_idx` (`price`),
  ADD KEY `fk_ticket_user_idx` (`user`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_1_idx` (`type`);

--
-- Индексы таблицы `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `hall`
--
ALTER TABLE `hall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `hall_price`
--
ALTER TABLE `hall_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `hall_type`
--
ALTER TABLE `hall_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `movie_attribute`
--
ALTER TABLE `movie_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `movie_attribute_type`
--
ALTER TABLE `movie_attribute_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `movie_attribute_value_boolean`
--
ALTER TABLE `movie_attribute_value_boolean`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `movie_attribute_value_datetime`
--
ALTER TABLE `movie_attribute_value_datetime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `movie_attribute_value_text`
--
ALTER TABLE `movie_attribute_value_text`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `movie_rewards`
--
ALTER TABLE `movie_rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `hall`
--
ALTER TABLE `hall`
  ADD CONSTRAINT `fk_hall_size` FOREIGN KEY (`size`) REFERENCES `hall_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `hall_price`
--
ALTER TABLE `hall_price`
  ADD CONSTRAINT `fk_hall_price_type` FOREIGN KEY (`hall_type`) REFERENCES `hall_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `movie_attribute`
--
ALTER TABLE `movie_attribute`
  ADD CONSTRAINT `fk_movie_attribute_1` FOREIGN KEY (`type`) REFERENCES `movie_attribute_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `movie_attribute_value_boolean`
--
ALTER TABLE `movie_attribute_value_boolean`
  ADD CONSTRAINT `fk_movie_attribute_value_datetime_100` FOREIGN KEY (`movie`) REFERENCES `movie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_movie_attribute_value_datetime_200` FOREIGN KEY (`attribute`) REFERENCES `movie_attribute` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `movie_attribute_value_datetime`
--
ALTER TABLE `movie_attribute_value_datetime`
  ADD CONSTRAINT `fk_movie_attribute_value_datetime_1` FOREIGN KEY (`movie`) REFERENCES `movie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_movie_attribute_value_datetime_2` FOREIGN KEY (`attribute`) REFERENCES `movie_attribute` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `movie_attribute_value_text`
--
ALTER TABLE `movie_attribute_value_text`
  ADD CONSTRAINT `fk_movie_attribute_value_datetime_10` FOREIGN KEY (`movie`) REFERENCES `movie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_movie_attribute_value_datetime_20` FOREIGN KEY (`attribute`) REFERENCES `movie_attribute` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `movie_rewards`
--
ALTER TABLE `movie_rewards`
  ADD CONSTRAINT `fk_movie_rewards_1` FOREIGN KEY (`movie`) REFERENCES `movie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `fk_session_hall` FOREIGN KEY (`hall`) REFERENCES `hall` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_session_movie` FOREIGN KEY (`show`) REFERENCES `movie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `fk_ticket_price` FOREIGN KEY (`price`) REFERENCES `hall_price` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ticket_session` FOREIGN KEY (`session`) REFERENCES `session` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ticket_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_1` FOREIGN KEY (`type`) REFERENCES `user_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
