
-- База данных: `cinema`

-- Структура таблицы `clients`

CREATE TABLE `clients` (
  `id` int(133) NOT NULL AUTO_INCREMENT,
  `surname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

-- Дамп данных таблицы `clients`

INSERT INTO `clients` (`id`, `surname`, `name`, `patronymic`, `birthday`, `phone`) VALUES
(1, 'Сидоров', 'Иван', 'Петрович', '1995-10-06', '8-922-111-11-11'),
(2, 'Черняева', 'Елена', 'Васильевна', '1990-05-18', '8-922-111-11-12'),
(3, 'Фамилия', 'Имя', 'Отчество', '1990-03-17', '8-922-111-11-14'),
(4, 'Фамилия1', 'Имя1', 'Отчество1', '1990-03-17', '8-922-111-11-15'),
(5, 'Фамилия2', 'Имя2', 'Отчество2', '1990-03-17', '8-922-111-11-16'),
(6, 'Фамилия3', 'Имя3', 'Отчество3', '1990-03-17', '8-922-111-11-17');

-- Структура таблицы `films`

CREATE TABLE `films` (
  `id` int(133) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

-- Дамп данных таблицы `films`

INSERT INTO `films` (`id`, `name`, `price`) VALUES
(1, 'Простоквашино', 100),
(2, 'Серый волк', 150),
(3, 'Три богатыря', 200),
(4, 'Мадагаскар', 200);

-- Структура таблицы `halls`

CREATE TABLE `halls` (
  `id` int(133) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `capacity` int(133) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы `halls`

INSERT INTO `halls` (`id`, `name`, `capacity`) VALUES
(1, 'Зал 1', 5),
(2, 'Зал 2', 10);

ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`);

-- Структура таблицы `orders`

CREATE TABLE `orders` (
  `id` int(133) NOT NULL AUTO_INCREMENT,
  `id_client` int(133) NOT NULL,
  `id_session` int(133) NOT NULL,
  `count` int(133) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

-- Дамп данных таблицы `orders`

INSERT INTO `orders` (`id`, `id_client`, `id_session`, `count`) VALUES
(1, 1, 2, 1),
(2, 3, 3, 3),
(3, 4, 5, 2),
(4, 5, 5, 4),
(5, 2, 4, 4),
(6, 5, 6, 5),
(7, 6, 7, 2),
(8, 1, 10, 5),
(9, 3, 4, 1),
(10, 5, 6, 4);

-- Структура таблицы `sessions`

CREATE TABLE `sessions` (
  `id` int(133) NOT NULL AUTO_INCREMENT,
  `id_hall` int(133) NOT NULL,
  `id_film` int(133) NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

-- Дамп данных таблицы `sessions`

INSERT INTO `sessions` (`id`, `id_hall`, `id_film`, `time`) VALUES
(1, 1, 4, '08:00:00'),
(2, 1, 1, '10:00:00'),
(3, 1, 2, '12:00:00'),
(4, 1, 4, '14:00:00'),
(5, 2, 1, '14:00:00'),
(6, 1, 2, '16:00:00'),
(7, 2, 3, '16:00:00'),
(8, 1, 2, '18:00:00'),
(9, 2, 1, '18:00:00'),
(10, 2, 3, '20:00:00');

