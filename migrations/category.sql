-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 18 2021 г., 08:50
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `yboard`
--

--
-- Очистить таблицу перед добавлением данных `category`
--

TRUNCATE TABLE `category`;
--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `tree`, `lft`, `rgt`, `depth`, `position`, `icon`, `description`, `fields`) VALUES
(1, 'Вещи, электроника и прочее', 1, 1, 398, 0, 0, 'wclothes.png', NULL, NULL),
(2, 'Услуги исполнителей', 2, 1, 254, 0, 0, 'services.png', NULL, NULL),
(3, 'Заявки на услуги', 3, 1, 34, 0, 0, 'application.png', NULL, NULL),
(4, 'Недвижимость', 4, 1, 34, 0, 0, 'realty.png', NULL, NULL),
(5, 'Животные', 5, 1, 20, 0, 0, 'pets.png', NULL, NULL),
(6, 'Легковые автомобили', 6, 1, 6, 0, 0, 'automobiles.png', NULL, NULL),
(7, 'Спецтехника и мотоциклы', 7, 1, 10, 0, 0, 'automoto.png', NULL, NULL),
(8, 'Запчасти и автотовары', 8, 1, 22, 0, 0, NULL, NULL, NULL),
(9, 'Вакансии', 9, 1, 60, 0, 0, NULL, NULL, NULL),
(10, 'Для бизнеса', 10, 1, 6, 0, 0, NULL, NULL, NULL),
(11, 'Женский гардероб', 1, 2, 37, 1, 0, NULL, NULL, NULL),
(12, 'Мужской гардероб', 1, 38, 69, 1, 0, NULL, NULL, NULL),
(13, 'Детский гардероб', 1, 70, 107, 1, 0, NULL, NULL, NULL),
(14, 'Аксессуары', 1, 3, 4, 2, 0, NULL, NULL, NULL),
(15, 'Блузы и рубашки', 1, 5, 6, 2, 0, NULL, NULL, NULL),
(16, 'Кошки', 5, 2, 3, 1, 0, NULL, NULL, NULL),
(17, 'Собаки', 5, 4, 5, 1, 0, NULL, NULL, NULL),
(18, 'Девочки', 1, 71, 72, 2, 0, NULL, NULL, NULL),
(19, 'Мальчики', 1, 73, 74, 2, 0, NULL, NULL, NULL),
(20, 'Детские товары', 1, 108, 109, 1, 0, NULL, NULL, NULL),
(21, 'Хэндмейд', 1, 110, 129, 1, 0, NULL, NULL, NULL),
(22, 'Телефоны и планшеты', 1, 130, 151, 1, 0, NULL, NULL, NULL),
(23, 'Фото- и видеокамеры', 1, 152, 175, 1, 0, NULL, NULL, NULL),
(24, 'Компьютерная техника', 1, 176, 201, 1, 0, NULL, NULL, NULL),
(25, 'ТВ, аудио, видео', 1, 202, 229, 1, 0, NULL, NULL, NULL),
(26, 'Бытовая техника', 1, 230, 259, 1, 0, NULL, NULL, NULL),
(27, 'Для дома и дачи', 1, 260, 293, 1, 0, NULL, NULL, NULL),
(28, 'Стройматериалы и инструменты', 1, 294, 317, 1, 0, NULL, NULL, NULL),
(29, 'Красота и здоровье', 1, 318, 343, 1, 0, NULL, NULL, NULL),
(30, 'Спорт и отдых', 1, 344, 373, 1, 0, NULL, NULL, NULL),
(31, 'Хобби и развлечения', 1, 374, 397, 1, 0, NULL, NULL, NULL),
(32, 'Будущим мамам', 1, 7, 8, 2, 0, NULL, NULL, NULL),
(33, 'Верхняя одежда', 1, 9, 10, 2, 0, NULL, NULL, NULL),
(34, 'Головные уборы', 1, 11, 12, 2, 0, NULL, NULL, NULL),
(35, 'Домашняя одежда', 1, 13, 14, 2, 0, NULL, NULL, NULL),
(36, 'Комбинезоны', 1, 15, 16, 2, 0, NULL, NULL, NULL),
(37, 'Купальники', 1, 17, 18, 2, 0, NULL, NULL, NULL),
(38, 'Нижнее белье', 1, 19, 20, 2, 0, NULL, NULL, NULL),
(39, 'Обувь', 1, 21, 22, 2, 0, NULL, NULL, NULL),
(40, 'Пиджаки и костюмы', 1, 23, 24, 2, 0, NULL, NULL, NULL),
(41, 'Платья и юбки', 1, 25, 26, 2, 0, NULL, NULL, NULL),
(42, 'Свитеры и толстовки', 1, 27, 28, 2, 0, NULL, NULL, NULL),
(43, 'Спортивная одежда', 1, 29, 30, 2, 0, NULL, NULL, NULL),
(44, 'Футболки и топы', 1, 31, 32, 2, 0, NULL, NULL, NULL),
(45, 'Штаны и шорты', 1, 33, 34, 2, 0, NULL, NULL, NULL),
(46, 'Другое', 1, 35, 36, 2, 0, NULL, NULL, NULL),
(47, 'Аксессуары', 1, 39, 40, 2, 0, NULL, NULL, NULL),
(48, 'Верхняя одежда', 1, 41, 42, 2, 0, NULL, NULL, NULL),
(49, 'Головные уборы', 1, 43, 44, 2, 0, NULL, NULL, NULL),
(50, 'Домашняя одежда', 1, 45, 46, 2, 0, NULL, NULL, NULL),
(51, 'Комбинезоны', 1, 47, 48, 2, 0, NULL, NULL, NULL),
(52, 'Нижнее белье', 1, 49, 50, 2, 0, NULL, NULL, NULL),
(53, 'Обувь', 1, 51, 52, 2, 0, NULL, NULL, NULL),
(54, 'Пиджаки и костюмы', 1, 53, 54, 2, 0, NULL, NULL, NULL),
(55, 'Рубашки', 1, 55, 56, 2, 0, NULL, NULL, NULL),
(56, 'Свитеры и толстовки', 1, 57, 58, 2, 0, NULL, NULL, NULL),
(57, 'Спецодежда', 1, 59, 60, 2, 0, NULL, NULL, NULL),
(58, 'Спортивная одежда', 1, 61, 62, 2, 0, NULL, NULL, NULL),
(59, 'Футболки и поло', 1, 63, 64, 2, 0, NULL, NULL, NULL),
(60, 'Штаны и шорты', 1, 65, 66, 2, 0, NULL, NULL, NULL),
(61, 'Другое', 1, 67, 68, 2, 0, NULL, NULL, NULL),
(62, 'Аксессуары', 1, 75, 76, 2, 0, NULL, NULL, NULL),
(63, 'Блузы и рубашки', 1, 77, 78, 2, 0, NULL, NULL, NULL),
(64, 'Верхняя одежда', 1, 79, 80, 2, 0, NULL, NULL, NULL),
(65, 'Домашняя одежда', 1, 81, 82, 2, 0, NULL, NULL, NULL),
(66, 'Комбинезоны и боди', 1, 83, 84, 2, 0, NULL, NULL, NULL),
(67, 'Конверты', 1, 85, 86, 2, 0, NULL, NULL, NULL),
(68, 'Нижнее белье', 1, 87, 88, 2, 0, NULL, NULL, NULL),
(69, 'Обувь', 1, 89, 90, 2, 0, NULL, NULL, NULL),
(70, 'Пиджаки и костюмы', 1, 91, 92, 2, 0, NULL, NULL, NULL),
(71, 'Платья и юбки', 1, 93, 94, 2, 0, NULL, NULL, NULL),
(72, 'Ползунки и распашонки', 1, 95, 96, 2, 0, NULL, NULL, NULL),
(73, 'Свитеры и толстовки', 1, 97, 98, 2, 0, NULL, NULL, NULL),
(74, 'Спортивная одежда', 1, 99, 100, 2, 0, NULL, NULL, NULL),
(75, 'Футболки', 1, 101, 102, 2, 0, NULL, NULL, NULL),
(76, 'Штаны и шорты', 1, 103, 104, 2, 0, NULL, NULL, NULL),
(77, 'Другое', 1, 105, 106, 2, 0, NULL, NULL, NULL),
(78, 'Косметика', 1, 111, 112, 2, 0, NULL, NULL, NULL),
(79, 'Украшения', 1, 113, 114, 2, 0, NULL, NULL, NULL),
(80, 'Куклы и игрушки', 1, 115, 116, 2, 0, NULL, NULL, NULL),
(81, 'Оформление интерьера', 1, 117, 118, 2, 0, NULL, NULL, NULL),
(82, 'Аксессуары', 1, 119, 120, 2, 0, NULL, NULL, NULL),
(83, 'Оформление праздников', 1, 121, 122, 2, 0, NULL, NULL, NULL),
(84, 'Канцелярия', 1, 123, 124, 2, 0, NULL, NULL, NULL),
(85, 'Посуда', 1, 125, 126, 2, 0, NULL, NULL, NULL),
(86, 'Другое', 1, 127, 128, 2, 0, NULL, NULL, NULL),
(87, 'Мобильные телефоны', 1, 131, 132, 2, 0, NULL, NULL, NULL),
(88, 'Планшеты', 1, 133, 134, 2, 0, NULL, NULL, NULL),
(89, 'Умные часы и браслеты', 1, 135, 136, 2, 0, NULL, NULL, NULL),
(90, 'Стационарные телефоны', 1, 137, 138, 2, 0, NULL, NULL, NULL),
(91, 'Рации и спутниковые телефоны', 1, 139, 140, 2, 0, NULL, NULL, NULL),
(92, 'Запчасти', 1, 141, 142, 2, 0, NULL, NULL, NULL),
(93, 'Внешние аккумуляторы', 1, 143, 144, 2, 0, NULL, NULL, NULL),
(94, 'Зарядные устройства', 1, 145, 146, 2, 0, NULL, NULL, NULL),
(95, 'Чехлы', 1, 147, 148, 2, 0, NULL, NULL, NULL),
(96, 'Аксессуары', 1, 149, 150, 2, 0, NULL, NULL, NULL),
(97, 'Фотоаппараты', 1, 153, 154, 2, 0, NULL, NULL, NULL),
(98, 'Видеокамеры', 1, 155, 156, 2, 0, NULL, NULL, NULL),
(99, 'Видеонаблюдение', 1, 157, 158, 2, 0, NULL, NULL, NULL),
(100, 'Объективы', 1, 159, 160, 2, 0, NULL, NULL, NULL),
(101, 'Фотовспышки', 1, 161, 162, 2, 0, NULL, NULL, NULL),
(102, 'Аксессуары', 1, 163, 164, 2, 0, NULL, NULL, NULL),
(103, 'Штативы и стабилизаторы', 1, 165, 166, 2, 0, NULL, NULL, NULL),
(104, 'Студийное оборудование', 1, 167, 168, 2, 0, NULL, NULL, NULL),
(105, 'Цифровые фоторамки', 1, 169, 170, 2, 0, NULL, NULL, NULL),
(106, 'Компактные фотопринтеры', 1, 171, 172, 2, 0, NULL, NULL, NULL),
(107, 'Бинокли и оптические приборы', 1, 173, 174, 2, 0, NULL, NULL, NULL),
(108, 'Ноутбуки', 1, 177, 178, 2, 0, NULL, NULL, NULL),
(109, 'Компьютеры', 1, 179, 180, 2, 0, NULL, NULL, NULL),
(110, 'Мониторы', 1, 181, 182, 2, 0, NULL, NULL, NULL),
(111, 'Клавиатуры и мыши', 1, 183, 184, 2, 0, NULL, NULL, NULL),
(112, 'Оргтехника и расходники', 1, 185, 186, 2, 0, NULL, NULL, NULL),
(113, 'Сетевое оборудование', 1, 187, 188, 2, 0, NULL, NULL, NULL),
(114, 'Мультимедиа', 1, 189, 190, 2, 0, NULL, NULL, NULL),
(115, 'Накопители данных и картридеры', 1, 191, 192, 2, 0, NULL, NULL, NULL),
(116, 'Программное обеспечение', 1, 193, 194, 2, 0, NULL, NULL, NULL),
(117, 'Рули, джойстики, геймпады', 1, 195, 196, 2, 0, NULL, NULL, NULL),
(118, 'Комплектующие и запчасти', 1, 197, 198, 2, 0, NULL, NULL, NULL),
(119, 'Аксессуары', 1, 199, 200, 2, 0, NULL, NULL, NULL),
(120, 'Телевизоры', 1, 203, 204, 2, 0, NULL, NULL, NULL),
(121, 'Проекторы', 1, 205, 206, 2, 0, NULL, NULL, NULL),
(122, 'Акустика, колонки, сабвуферы', 1, 207, 208, 2, 0, NULL, NULL, NULL),
(123, 'Домашние кинотеатры', 1, 209, 210, 2, 0, NULL, NULL, NULL),
(124, 'DVD, Blu-ray и медиаплееры', 1, 211, 212, 2, 0, NULL, NULL, NULL),
(125, 'Музыкальные центры и магнитолы', 1, 213, 214, 2, 0, NULL, NULL, NULL),
(126, 'MP3-плееры и портативное аудио', 1, 215, 216, 2, 0, NULL, NULL, NULL),
(127, 'Электронные книги', 1, 217, 218, 2, 0, NULL, NULL, NULL),
(128, 'Спутниковое и цифровое ТВ', 1, 219, 220, 2, 0, NULL, NULL, NULL),
(129, 'Аудиоусилители и ресиверы', 1, 221, 222, 2, 0, NULL, NULL, NULL),
(130, 'Наушники', 1, 223, 224, 2, 0, NULL, NULL, NULL),
(131, 'Микрофоны', 1, 225, 226, 2, 0, NULL, NULL, NULL),
(132, 'Аксессуары', 1, 227, 228, 2, 0, NULL, NULL, NULL),
(133, 'Весы', 1, 231, 232, 2, 0, NULL, NULL, NULL),
(134, 'Вытяжки', 1, 233, 234, 2, 0, NULL, NULL, NULL),
(135, 'Измельчение и смешивание', 1, 235, 236, 2, 0, NULL, NULL, NULL),
(136, 'Климатическая техника', 1, 237, 238, 2, 0, NULL, NULL, NULL),
(137, 'Кулеры и фильтры для воды', 1, 239, 240, 2, 0, NULL, NULL, NULL),
(138, 'Плиты и духовые шкафы', 1, 241, 242, 2, 0, NULL, NULL, NULL),
(139, 'Посудомоечные машины', 1, 243, 244, 2, 0, NULL, NULL, NULL),
(140, 'Приготовление еды', 1, 245, 246, 2, 0, NULL, NULL, NULL),
(141, 'Приготовление напитков', 1, 247, 248, 2, 0, NULL, NULL, NULL),
(142, 'Пылесосы и пароочистители', 1, 249, 250, 2, 0, NULL, NULL, NULL),
(143, 'Стиральные машины', 1, 251, 252, 2, 0, NULL, NULL, NULL),
(144, 'Утюги и уход за одеждой', 1, 253, 254, 2, 0, NULL, NULL, NULL),
(145, 'Холодильники', 1, 255, 256, 2, 0, NULL, NULL, NULL),
(146, 'Швейное оборудование', 1, 257, 258, 2, 0, NULL, NULL, NULL),
(147, 'Бытовая химия', 1, 261, 262, 2, 0, NULL, NULL, NULL),
(148, 'Диваны и кресла', 1, 263, 264, 2, 0, NULL, NULL, NULL),
(149, 'Кровати и матрасы', 1, 265, 266, 2, 0, NULL, NULL, NULL),
(150, 'Кухонные гарнитуры', 1, 267, 268, 2, 0, NULL, NULL, NULL),
(151, 'Освещение', 1, 269, 270, 2, 0, NULL, NULL, NULL),
(152, 'Оформление интерьера', 1, 271, 272, 2, 0, NULL, NULL, NULL),
(153, 'Охрана и сигнализации', 1, 273, 274, 2, 0, NULL, NULL, NULL),
(154, 'Подставки и тумбы', 1, 275, 276, 2, 0, NULL, NULL, NULL),
(155, 'Посуда', 1, 277, 278, 2, 0, NULL, NULL, NULL),
(156, 'Растения и семена', 1, 279, 280, 2, 0, NULL, NULL, NULL),
(157, 'Сад и огород', 1, 281, 282, 2, 0, NULL, NULL, NULL),
(158, 'Садовая мебель', 1, 283, 284, 2, 0, NULL, NULL, NULL),
(159, 'Столы и стулья', 1, 285, 286, 2, 0, NULL, NULL, NULL),
(160, 'Текстиль и ковры', 1, 287, 288, 2, 0, NULL, NULL, NULL),
(161, 'Шкафы и комоды', 1, 289, 290, 2, 0, NULL, NULL, NULL),
(162, 'Другое', 1, 291, 292, 2, 0, NULL, NULL, NULL),
(163, 'Двери', 1, 295, 296, 2, 0, NULL, NULL, NULL),
(164, 'Измерительные инструменты', 1, 297, 298, 2, 0, NULL, NULL, NULL),
(165, 'Окна', 1, 299, 300, 2, 0, NULL, NULL, NULL),
(166, 'Отопление и вентиляция', 1, 301, 302, 2, 0, NULL, NULL, NULL),
(167, 'Потолки', 1, 303, 304, 2, 0, NULL, NULL, NULL),
(168, 'Ручные инструменты', 1, 305, 306, 2, 0, NULL, NULL, NULL),
(169, 'Сантехника и водоснабжение', 1, 307, 308, 2, 0, NULL, NULL, NULL),
(170, 'Стройматериалы', 1, 309, 310, 2, 0, NULL, NULL, NULL),
(171, 'Электрика', 1, 311, 312, 2, 0, NULL, NULL, NULL),
(172, 'Электроинструменты', 1, 313, 314, 2, 0, NULL, NULL, NULL),
(173, 'Другое', 1, 315, 316, 2, 0, NULL, NULL, NULL),
(174, 'Макияж', 1, 319, 320, 2, 0, NULL, NULL, NULL),
(175, 'Маникюр и педикюр', 1, 321, 322, 2, 0, NULL, NULL, NULL),
(176, 'Товары для здоровья', 1, 323, 324, 2, 0, NULL, NULL, NULL),
(177, 'Парфюмерия', 1, 325, 326, 2, 0, NULL, NULL, NULL),
(178, 'Стрижка и удаление волос', 1, 327, 328, 2, 0, NULL, NULL, NULL),
(179, 'Уход за волосами', 1, 329, 330, 2, 0, NULL, NULL, NULL),
(180, 'Уход за кожей', 1, 331, 332, 2, 0, NULL, NULL, NULL),
(181, 'Фены и укладка', 1, 333, 334, 2, 0, NULL, NULL, NULL),
(182, 'Тату и татуаж', 1, 335, 336, 2, 0, NULL, NULL, NULL),
(183, 'Солярии и загар', 1, 337, 338, 2, 0, NULL, NULL, NULL),
(184, 'Средства для гигиены', 1, 339, 340, 2, 0, NULL, NULL, NULL),
(185, 'Другое', 1, 341, 342, 2, 0, NULL, NULL, NULL),
(186, 'Спортивная защита', 1, 345, 346, 2, 0, NULL, NULL, NULL),
(187, 'Велосипеды', 1, 347, 348, 2, 0, NULL, NULL, NULL),
(188, 'Ролики и скейтбординг', 1, 349, 350, 2, 0, NULL, NULL, NULL),
(189, 'Самокаты и гироскутеры', 189, 1, 2, 0, 0, NULL, NULL, NULL),
(190, 'Бильярд и боулинг', 1, 351, 352, 2, 0, NULL, NULL, NULL),
(191, 'Водные виды спорта', 1, 353, 354, 2, 0, NULL, NULL, NULL),
(192, 'Единоборства', 1, 355, 356, 2, 0, NULL, NULL, NULL),
(193, 'Зимние виды спорта', 1, 357, 358, 2, 0, NULL, NULL, NULL),
(194, 'Игры с мячом', 1, 359, 360, 2, 0, NULL, NULL, NULL),
(195, 'Охота и рыбалка', 1, 361, 362, 2, 0, NULL, NULL, NULL),
(196, 'Туризм и отдых на природе', 1, 363, 364, 2, 0, NULL, NULL, NULL),
(197, 'Теннис, бадминтон, дартс', 1, 365, 366, 2, 0, NULL, NULL, NULL),
(198, 'Тренажеры и фитнес', 1, 367, 368, 2, 0, NULL, NULL, NULL),
(199, 'Спортивное питание', 1, 369, 370, 2, 0, NULL, NULL, NULL),
(200, 'Другое', 1, 371, 372, 2, 0, NULL, NULL, NULL),
(201, 'Билеты', 1, 375, 376, 2, 0, NULL, NULL, NULL),
(202, 'Видеофильмы', 1, 377, 378, 2, 0, NULL, NULL, NULL),
(203, 'Игровые приставки', 1, 379, 380, 2, 0, NULL, NULL, NULL),
(204, 'Игры для приставок и ПК', 1, 381, 382, 2, 0, NULL, NULL, NULL),
(205, 'Книги и журналы', 1, 383, 384, 2, 0, NULL, NULL, NULL),
(206, 'Коллекционирование', 1, 385, 386, 2, 0, NULL, NULL, NULL),
(207, 'Материалы для творчества', 1, 387, 388, 2, 0, NULL, NULL, NULL),
(208, 'Музыка', 1, 389, 390, 2, 0, NULL, NULL, NULL),
(209, 'Музыкальные инструменты', 1, 391, 392, 2, 0, NULL, NULL, NULL),
(210, 'Настольные игры', 1, 393, 394, 2, 0, NULL, NULL, NULL),
(211, 'Другое', 1, 395, 396, 2, 0, NULL, NULL, NULL),
(212, 'Птицы', 5, 6, 7, 1, 0, NULL, NULL, NULL),
(213, 'Грызуны', 5, 8, 9, 1, 0, NULL, NULL, NULL),
(214, 'Рыбки', 5, 10, 11, 1, 0, NULL, NULL, NULL),
(215, 'С/х животные', 5, 12, 13, 1, 0, NULL, NULL, NULL),
(216, 'Другие животные', 5, 14, 15, 1, 0, NULL, NULL, NULL),
(217, 'Товары для животных', 5, 16, 17, 1, 0, NULL, NULL, NULL),
(218, 'Аквариумистика', 5, 18, 19, 1, 0, NULL, NULL, NULL),
(219, 'Обучение', 2, 2, 27, 1, 0, NULL, NULL, NULL),
(220, 'Мастер на час', 2, 28, 41, 1, 0, NULL, NULL, NULL),
(221, 'Красота и здоровье', 2, 42, 65, 1, 0, NULL, NULL, NULL),
(222, 'Перевозки', 2, 66, 83, 1, 0, NULL, NULL, NULL),
(223, 'Ремонт и строительство', 2, 84, 109, 1, 0, NULL, NULL, NULL),
(224, 'Компьютерные услуги', 2, 110, 123, 1, 0, NULL, NULL, NULL),
(225, 'Деловые услуги', 2, 124, 143, 1, 0, NULL, NULL, NULL),
(226, 'Уборка', 2, 144, 153, 1, 0, NULL, NULL, NULL),
(227, 'Автоуслуги', 2, 154, 171, 1, 0, NULL, NULL, NULL),
(228, 'Ремонт техники', 2, 172, 191, 1, 0, NULL, NULL, NULL),
(229, 'Организация праздников', 2, 192, 211, 1, 0, NULL, NULL, NULL),
(230, 'Фото- и видеосъемка', 2, 212, 213, 1, 0, NULL, NULL, NULL),
(231, 'Изготовление на заказ', 2, 214, 231, 1, 0, NULL, NULL, NULL),
(232, 'Продукты питания', 2, 232, 241, 1, 0, NULL, NULL, NULL),
(233, 'Уход за животными', 2, 242, 251, 1, 0, NULL, NULL, NULL),
(234, 'Другое', 2, 252, 253, 1, 0, NULL, NULL, NULL),
(235, 'Детское развитие', 2, 3, 4, 2, 0, NULL, NULL, NULL),
(236, 'Мастер-классы и тренинги', 2, 5, 6, 2, 0, NULL, NULL, NULL),
(237, 'Обучение вождению', 2, 7, 8, 2, 0, NULL, NULL, NULL),
(238, 'Обучение языкам', 2, 9, 10, 2, 0, NULL, NULL, NULL),
(239, 'Подготовка к экзаменам', 2, 11, 12, 2, 0, NULL, NULL, NULL),
(240, 'Профессиональное обучение', 2, 13, 14, 2, 0, NULL, NULL, NULL),
(241, 'Уроки музыки и театрального мастерства', 2, 15, 16, 2, 0, NULL, NULL, NULL),
(242, 'Уроки рисования, дизайна и рукоделия', 2, 17, 18, 2, 0, NULL, NULL, NULL),
(243, 'Логопед и дефектолог', 2, 19, 20, 2, 0, NULL, NULL, NULL),
(244, 'Психологи', 2, 21, 22, 2, 0, NULL, NULL, NULL),
(245, 'Репетиторы', 2, 23, 24, 2, 0, NULL, NULL, NULL),
(246, 'Услуги тренера', 2, 25, 26, 2, 0, NULL, NULL, NULL),
(247, 'Дезинфекция и дезинсекция', 2, 29, 30, 2, 0, NULL, NULL, NULL),
(248, 'Изготовление ключей и вскрытие замков', 2, 31, 32, 2, 0, NULL, NULL, NULL),
(249, 'Муж на час', 2, 33, 34, 2, 0, NULL, NULL, NULL),
(250, 'Сборка и ремонт мебели', 2, 35, 36, 2, 0, NULL, NULL, NULL),
(251, 'Услуги няни и гувернантки', 2, 37, 38, 2, 0, NULL, NULL, NULL),
(252, 'Услуги сиделки', 2, 39, 40, 2, 0, NULL, NULL, NULL),
(253, 'Аренда кабинета красоты', 2, 43, 44, 2, 0, NULL, NULL, NULL),
(254, 'Депиляция и шугаринг', 2, 45, 46, 2, 0, NULL, NULL, NULL),
(255, 'Косметология', 2, 47, 48, 2, 0, NULL, NULL, NULL),
(256, 'Макияж', 2, 49, 50, 2, 0, NULL, NULL, NULL),
(257, 'Маникюр и педикюр', 2, 51, 52, 2, 0, NULL, NULL, NULL),
(258, 'Массаж', 2, 53, 54, 2, 0, NULL, NULL, NULL),
(259, 'Наращивание волос', 2, 55, 56, 2, 0, NULL, NULL, NULL),
(260, 'Наращивание ресниц, услуги бровиста', 2, 57, 58, 2, 0, NULL, NULL, NULL),
(261, 'СПА-услуги', 2, 59, 60, 2, 0, NULL, NULL, NULL),
(262, 'Тату и пирсинг', 2, 61, 62, 2, 0, NULL, NULL, NULL),
(263, 'Услуги парикмахера', 2, 63, 64, 2, 0, NULL, NULL, NULL),
(264, 'Аренда авто', 2, 67, 68, 2, 0, NULL, NULL, NULL),
(265, 'Аренда спецтехники', 2, 69, 70, 2, 0, NULL, NULL, NULL),
(266, 'Вывоз мусора', 2, 71, 72, 2, 0, NULL, NULL, NULL),
(267, 'Грузоперевозки', 2, 73, 74, 2, 0, NULL, NULL, NULL),
(268, 'Грузчики', 2, 75, 76, 2, 0, NULL, NULL, NULL),
(269, 'Пассажирские перевозки', 2, 77, 78, 2, 0, NULL, NULL, NULL),
(270, 'Услуги водителя', 2, 79, 80, 2, 0, NULL, NULL, NULL),
(271, 'Услуги эвакуатора', 2, 81, 82, 2, 0, NULL, NULL, NULL),
(272, 'Дизайн интерьера', 2, 85, 86, 2, 0, NULL, NULL, NULL),
(273, 'Дома и коттеджи', 2, 87, 88, 2, 0, NULL, NULL, NULL),
(274, 'Кровельные работы', 2, 89, 90, 2, 0, NULL, NULL, NULL),
(275, 'Малярные работы', 2, 91, 92, 2, 0, NULL, NULL, NULL),
(276, 'Мелкий ремонт', 2, 93, 94, 2, 0, NULL, NULL, NULL),
(277, 'Натяжные потолки', 2, 95, 96, 2, 0, NULL, NULL, NULL),
(278, 'Остекление окон', 2, 97, 98, 2, 0, NULL, NULL, NULL),
(279, 'Строительные работы', 2, 99, 100, 2, 0, NULL, NULL, NULL),
(280, 'Сантехники', 2, 101, 102, 2, 0, NULL, NULL, NULL),
(281, 'Электрики', 2, 103, 104, 2, 0, NULL, NULL, NULL),
(282, 'Установка и ремонт дверей', 2, 105, 106, 2, 0, NULL, NULL, NULL),
(283, 'Штукатурные работы', 2, 107, 108, 2, 0, NULL, NULL, NULL),
(284, 'Веб-Дизайн', 2, 111, 112, 2, 0, NULL, NULL, NULL),
(285, 'Компьютерная помощь и настройка ПК', 2, 113, 114, 2, 0, NULL, NULL, NULL),
(286, 'Набор текста', 2, 115, 116, 2, 0, NULL, NULL, NULL),
(287, 'Подключение Интернета', 2, 117, 118, 2, 0, NULL, NULL, NULL),
(288, 'Создание и продвижение сайтов', 2, 119, 120, 2, 0, NULL, NULL, NULL),
(289, 'Установка ПО', 2, 121, 122, 2, 0, NULL, NULL, NULL),
(290, 'Бизнес-консультирование', 2, 125, 126, 2, 0, NULL, NULL, NULL),
(291, 'Бухгалтерия и финансы', 2, 127, 128, 2, 0, NULL, NULL, NULL),
(292, 'Изготовление вывесок и рекламы', 2, 129, 130, 2, 0, NULL, NULL, NULL),
(293, 'Маркетинг и реклама', 2, 131, 132, 2, 0, NULL, NULL, NULL),
(294, 'Перевод текстов', 2, 133, 134, 2, 0, NULL, NULL, NULL),
(295, 'Полиграфия', 2, 135, 136, 2, 0, NULL, NULL, NULL),
(296, 'Риэлторские услуги', 2, 137, 138, 2, 0, NULL, NULL, NULL),
(297, 'Документов и сертификации', 2, 139, 140, 2, 0, NULL, NULL, NULL),
(298, 'Юридические услуги', 2, 141, 142, 2, 0, NULL, NULL, NULL),
(299, 'Мойка окон и балконов', 2, 145, 146, 2, 0, NULL, NULL, NULL),
(300, 'Уборка', 2, 147, 148, 2, 0, NULL, NULL, NULL),
(301, 'Услуги домработницы', 2, 149, 150, 2, 0, NULL, NULL, NULL),
(302, 'Химчистка, стирка и глажка', 2, 151, 152, 2, 0, NULL, NULL, NULL),
(303, 'Автоэлектрика', 2, 155, 156, 2, 0, NULL, NULL, NULL),
(304, 'Диагностика авто', 2, 157, 158, 2, 0, NULL, NULL, NULL),
(305, 'Кузовные работы и покраска автомобиля', 2, 159, 160, 2, 0, NULL, NULL, NULL),
(306, 'Ремонт двигателя и ходовой', 2, 161, 162, 2, 0, NULL, NULL, NULL),
(307, 'Ремонт мототехники', 2, 163, 164, 2, 0, NULL, NULL, NULL),
(308, 'Тюнинг и установка доп. оборудования', 2, 165, 166, 2, 0, NULL, NULL, NULL),
(309, 'Химчистка и мойка авто', 2, 167, 168, 2, 0, NULL, NULL, NULL),
(310, 'Шиномонтаж и ремонт дисков', 2, 169, 170, 2, 0, NULL, NULL, NULL),
(311, 'Ремонт газового оборудования', 2, 173, 174, 2, 0, NULL, NULL, NULL),
(312, 'Ремонт компьютеров и ноутбуков', 2, 175, 176, 2, 0, NULL, NULL, NULL),
(313, 'Ремонт смартфонов и телефонов', 2, 177, 178, 2, 0, NULL, NULL, NULL),
(314, 'Ремонт телевизоров, аудио и видеотехники', 2, 179, 180, 2, 0, NULL, NULL, NULL),
(315, 'Ремонт фототехники', 2, 181, 182, 2, 0, NULL, NULL, NULL),
(316, 'Ремонт часов', 2, 183, 184, 2, 0, NULL, NULL, NULL),
(317, 'Установка кондиционеров', 2, 185, 186, 2, 0, NULL, NULL, NULL),
(318, 'Установка систем безопасности', 2, 187, 188, 2, 0, NULL, NULL, NULL),
(319, 'Установка и ремонт бытовой техники', 2, 189, 190, 2, 0, NULL, NULL, NULL),
(320, 'Аренда оборудования и аттракционов', 2, 193, 194, 2, 0, NULL, NULL, NULL),
(321, 'Аренда площадки', 2, 195, 196, 2, 0, NULL, NULL, NULL),
(322, 'Ведущие, музыканты и артисты', 2, 197, 198, 2, 0, NULL, NULL, NULL),
(323, 'Организация мероприятий', 2, 199, 200, 2, 0, NULL, NULL, NULL),
(324, 'Приготовление еды и кейтеринг', 2, 201, 202, 2, 0, NULL, NULL, NULL),
(325, 'Прокат костюмов', 2, 203, 204, 2, 0, NULL, NULL, NULL),
(326, 'Промоутеры и модели', 2, 205, 206, 2, 0, NULL, NULL, NULL),
(327, 'Туризм и отдых', 2, 207, 208, 2, 0, NULL, NULL, NULL),
(328, 'Цветы и декор', 2, 209, 210, 2, 0, NULL, NULL, NULL),
(329, 'Изготовление и ремонт одежды, обуви, аксессуаров', 2, 215, 216, 2, 0, NULL, NULL, NULL),
(330, 'Кованые изделия на заказ', 2, 217, 218, 2, 0, NULL, NULL, NULL),
(331, 'Мебель на заказ', 2, 219, 220, 2, 0, NULL, NULL, NULL),
(332, 'Музыка, стихи и озвучка на заказ', 2, 221, 222, 2, 0, NULL, NULL, NULL),
(333, 'Печати и штампы на заказ', 2, 223, 224, 2, 0, NULL, NULL, NULL),
(334, 'Рисунок, живопись и графика на заказ', 2, 225, 226, 2, 0, NULL, NULL, NULL),
(335, 'Сувенирная продукция и полиграфия', 2, 227, 228, 2, 0, NULL, NULL, NULL),
(336, 'Ювелирные услуги', 2, 229, 230, 2, 0, NULL, NULL, NULL),
(337, 'Выпечка и торты на заказ', 2, 233, 234, 2, 0, NULL, NULL, NULL),
(338, 'Продукты питания', 2, 235, 236, 2, 0, NULL, NULL, NULL),
(339, 'Услуги повара', 2, 237, 238, 2, 0, NULL, NULL, NULL),
(340, 'Чай и кофе', 2, 239, 240, 2, 0, NULL, NULL, NULL),
(341, 'Вязка', 2, 243, 244, 2, 0, NULL, NULL, NULL),
(342, 'Дрессировка и выгул', 2, 245, 246, 2, 0, NULL, NULL, NULL),
(343, 'Передержка', 2, 247, 248, 2, 0, NULL, NULL, NULL),
(344, 'Стрижка и уход за животными', 2, 249, 250, 2, 0, NULL, NULL, NULL),
(345, 'Обучение', 3, 2, 3, 1, 0, NULL, NULL, NULL),
(346, 'Мастер на час', 3, 4, 5, 1, 0, NULL, NULL, NULL),
(347, 'Красота и здоровье', 3, 6, 7, 1, 0, NULL, NULL, NULL),
(348, 'Перевозки', 3, 8, 9, 1, 0, NULL, NULL, NULL),
(349, 'Ремонт и строительство', 3, 10, 11, 1, 0, NULL, NULL, NULL),
(350, 'Компьютерные услуги', 3, 12, 13, 1, 0, NULL, NULL, NULL),
(351, 'Деловые услуги', 3, 14, 15, 1, 0, NULL, NULL, NULL),
(352, 'Уборка', 3, 16, 17, 1, 0, NULL, NULL, NULL),
(353, 'Автоуслуги', 3, 18, 19, 1, 0, NULL, NULL, NULL),
(354, 'Ремонт техники', 3, 20, 21, 1, 0, NULL, NULL, NULL),
(355, 'Организация праздников', 3, 22, 23, 1, 0, NULL, NULL, NULL),
(356, 'Фото- и видеосъемка', 3, 24, 25, 1, 0, NULL, NULL, NULL),
(357, 'Изготовление на заказ', 3, 26, 27, 1, 0, NULL, NULL, NULL),
(358, 'Продукты питания', 3, 28, 29, 1, 0, NULL, NULL, NULL),
(359, 'Уход за животными', 3, 30, 31, 1, 0, NULL, NULL, NULL),
(360, 'Другое', 3, 32, 33, 1, 0, NULL, NULL, NULL),
(361, 'Продажа квартиры', 4, 2, 3, 1, 0, NULL, NULL, NULL),
(362, 'Продажа комнаты', 4, 4, 5, 1, 0, NULL, NULL, NULL),
(363, 'Продажа дома', 4, 6, 7, 1, 0, NULL, NULL, NULL),
(364, 'Продажа участка', 4, 8, 9, 1, 0, NULL, NULL, NULL),
(365, 'Аренда квартиры длительно', 4, 10, 19, 1, 0, NULL, NULL, NULL),
(366, 'Аренда комнаты длительно', 4, 20, 21, 1, 0, NULL, NULL, NULL),
(367, 'Аренда дома длительно', 4, 22, 23, 1, 0, NULL, NULL, NULL),
(368, 'Аренда квартиры посуточно', 4, 24, 25, 1, 0, NULL, NULL, NULL),
(369, 'Аренда комнаты посуточно', 4, 26, 27, 1, 0, NULL, NULL, NULL),
(370, 'Аренда дома посуточно', 4, 28, 29, 1, 0, NULL, NULL, NULL),
(371, 'Коммерческая недвижимость', 4, 30, 31, 1, 0, NULL, NULL, NULL),
(372, 'Прочие строения', 4, 32, 33, 1, 0, NULL, NULL, NULL),
(373, '1 комната', 4, 11, 12, 2, 0, NULL, NULL, NULL),
(374, '2 комнаты', 4, 13, 14, 2, 0, NULL, NULL, NULL),
(375, '3 комнаты', 4, 15, 16, 2, 0, NULL, NULL, NULL),
(376, 'Студия', 4, 17, 18, 2, 0, NULL, NULL, NULL),
(377, 'С пробегом', 6, 2, 3, 1, 0, NULL, NULL, NULL),
(378, 'Новые', 6, 4, 5, 1, 0, NULL, NULL, NULL),
(379, 'Автобусы и грузовики', 7, 2, 3, 1, 0, NULL, NULL, NULL),
(380, 'Водный транспорт', 7, 4, 5, 1, 0, NULL, NULL, NULL),
(381, 'Мототехника', 7, 6, 7, 1, 0, NULL, NULL, NULL),
(382, 'Спецтехника', 7, 8, 9, 1, 0, NULL, NULL, NULL),
(383, 'Запчасти', 8, 2, 3, 1, 0, NULL, NULL, NULL),
(384, 'Шины и диски', 8, 4, 5, 1, 0, NULL, NULL, NULL),
(385, 'Масла и автохимия', 8, 6, 7, 1, 0, NULL, NULL, NULL),
(386, 'Автоэлектроника и GPS', 8, 8, 9, 1, 0, NULL, NULL, NULL),
(387, 'Аксессуары и инструменты', 8, 10, 11, 1, 0, NULL, NULL, NULL),
(388, 'Аудио и видео', 8, 12, 13, 1, 0, NULL, NULL, NULL),
(389, 'Противоугонные устройства', 8, 14, 15, 1, 0, NULL, NULL, NULL),
(390, 'Багажные системы и прицепы', 8, 16, 17, 1, 0, NULL, NULL, NULL),
(391, 'Мотоэкипировка', 8, 18, 19, 1, 0, NULL, NULL, NULL),
(392, 'Другое', 8, 20, 21, 1, 0, NULL, NULL, NULL),
(393, 'Автобизнес', 9, 2, 3, 1, 0, NULL, NULL, NULL),
(394, 'Безопасность', 9, 4, 5, 1, 0, NULL, NULL, NULL),
(395, 'Бытовые услуги и клининг', 9, 6, 7, 1, 0, NULL, NULL, NULL),
(396, 'Высший менеджмент', 9, 8, 9, 1, 0, NULL, NULL, NULL),
(397, 'Госслужба', 9, 10, 11, 1, 0, NULL, NULL, NULL),
(398, 'Добыча сырья, энергетика', 9, 12, 13, 1, 0, NULL, NULL, NULL),
(401, 'Домашний персонал', 9, 14, 15, 1, 0, NULL, NULL, NULL),
(402, 'Издательства и СМИ', 9, 16, 17, 1, 0, NULL, NULL, NULL),
(403, 'Информационные технологии', 9, 18, 19, 1, 0, NULL, NULL, NULL),
(404, 'Искусство и развлечения', 9, 20, 21, 1, 0, NULL, NULL, NULL),
(405, 'Магазины', 9, 22, 23, 1, 0, NULL, NULL, NULL),
(406, 'Маркетинг и реклама', 9, 24, 25, 1, 0, NULL, NULL, NULL),
(407, 'Медицина', 9, 26, 27, 1, 0, NULL, NULL, NULL),
(408, 'Начало карьеры', 9, 28, 29, 1, 0, NULL, NULL, NULL),
(409, 'Образование и наука', 9, 30, 31, 1, 0, NULL, NULL, NULL),
(410, 'Офисный персонал', 9, 32, 33, 1, 0, NULL, NULL, NULL),
(411, 'Перевозки, склад, закупки', 9, 34, 35, 1, 0, NULL, NULL, NULL),
(412, 'Продажи', 9, 36, 37, 1, 0, NULL, NULL, NULL),
(413, 'Производство', 9, 38, 39, 1, 0, NULL, NULL, NULL),
(414, 'Рестораны и общепит', 9, 40, 41, 1, 0, NULL, NULL, NULL),
(415, 'Сельское хозяйство', 9, 42, 43, 1, 0, NULL, NULL, NULL),
(416, 'Спорт и красота', 9, 44, 45, 1, 0, NULL, NULL, NULL),
(417, 'Страхование', 9, 46, 47, 1, 0, NULL, NULL, NULL),
(418, 'Строительство и ремонт', 9, 48, 49, 1, 0, NULL, NULL, NULL),
(419, 'Туризм и гостиницы', 9, 50, 51, 1, 0, NULL, NULL, NULL),
(420, 'Управление недвижимостью', 9, 52, 53, 1, 0, NULL, NULL, NULL),
(421, 'Управление персоналом', 9, 54, 55, 1, 0, NULL, NULL, NULL),
(422, 'Финансы', 9, 56, 57, 1, 0, NULL, NULL, NULL),
(423, 'Юриспруденция', 9, 58, 59, 1, 0, NULL, NULL, NULL),
(424, 'Готовый бизнес', 10, 2, 3, 1, 0, NULL, NULL, NULL),
(425, 'Оборудование', 10, 4, 5, 1, 0, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
