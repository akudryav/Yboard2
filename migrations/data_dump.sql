-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 10 2021 г., 17:42
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `yboard`
--

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `tree`, `lft`, `rgt`, `depth`, `position`, `icon`, `description`, `fields`)
VALUES (1, 'Вещи, электроника и прочее', 1, 1, 16, 0, 0, 'comp.jpg', NULL, NULL),
       (2, 'Услуги исполнителей', 2, 1, 2, 0, 0, 'rabota.jpg', NULL, NULL),
       (3, 'Заявки на услуги', 3, 1, 2, 0, 0, NULL, NULL, NULL),
       (4, 'Недвижимость', 4, 1, 2, 0, 0, 'nedvijimosti.jpg', NULL, NULL),
       (5, 'Животные', 5, 1, 6, 0, 0, NULL, NULL, NULL),
       (6, 'Легковые автомобили', 6, 1, 2, 0, 0, NULL, NULL, NULL),
       (7, 'Спецтехника и мотоциклы', 7, 1, 2, 0, 0, NULL, NULL, NULL),
       (8, 'Запчасти и автотовары', 8, 1, 2, 0, 0, NULL, NULL, NULL),
       (9, 'Вакансии', 9, 1, 2, 0, 0, NULL, NULL, NULL),
       (10, 'Для бизнеса', 10, 1, 2, 0, 0, NULL, NULL, NULL),
       (11, 'Женский гардероб', 1, 2, 7, 1, 0, NULL, NULL, NULL),
       (12, 'Мужской гардероб', 1, 8, 9, 1, 0, NULL, NULL, NULL),
       (13, 'Детский гардероб', 1, 10, 15, 1, 0, NULL, NULL, NULL),
       (14, 'Аксессуары', 1, 3, 4, 2, 0, NULL, NULL, NULL),
       (15, 'Блузы и рубашки', 1, 5, 6, 2, 0, NULL, NULL, NULL),
       (16, 'Кошки', 5, 2, 3, 1, 0, NULL, NULL, NULL),
       (17, 'Собаки', 5, 4, 5, 1, 0, NULL, NULL, NULL),
       (18, 'Девочки', 1, 11, 12, 2, 0, NULL, NULL, NULL),
       (19, 'Мальчики', 1, 13, 14, 2, 0, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
