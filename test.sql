-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 16 2020 г., 21:07
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tree`
--

CREATE TABLE `tree` (
  `I_ID` int(11) NOT NULL,
  `S_NAME` varchar(255) CHARACTER SET utf8 NOT NULL,
  `S_DETAILS` varchar(255) CHARACTER SET utf8 NOT NULL,
  `I_PARENT_ID` int(11) DEFAULT NULL,
  `I_USER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `tree`
--

INSERT INTO `tree` (`I_ID`, `S_NAME`, `S_DETAILS`, `I_PARENT_ID`, `I_USER`) VALUES
(1, 'testname', 'testname', 0, 1),
(2, 'TestName2', 'TestDetails2', 0, 1),
(3, 'SmallName', 'SmallDetails', 2, 1),
(6, 'Test34', 'Test34', 2, 1),
(7, 'KrutoiMel', 'KrutoiMel', 2, 1),
(8, 'Test134', 'Test134', 6, 1),
(9, 'LastTestOf136', 'LastTestOf136', 8, 1),
(10, 'Наименование русское с пробелами', 'Наименование русское с пробелами', 1, 1),
(11, 'Name english with spaces', 'Name english with spaces', 1, 1),
(12, 'Test Jup', 'Jup Test', 9, 1),
(13, 'Yo Yo', 'NeiOpisanie', 10, 1),
(14, 'tree1', 'descr 1', 0, 5),
(15, 'Eleme3', 'Eleme4', 0, 1),
(16, 'Elem', 'Eleme2', 1, 1),
(17, 'ElemeKid', 'ElemekIdoBo', 16, 1),
(21, 'Test1123', 'Test23123', 0, 1),
(22, 'Test112', 'Test221', 0, 1),
(25, 'qwet', 'qwet', 0, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `I_ID` int(11) NOT NULL,
  `S_USERNAME` varchar(20) NOT NULL,
  `S_PASSWORD` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`I_ID`, `S_USERNAME`, `S_PASSWORD`) VALUES
(1, 'admin', '$2y$10$YlY.WBHs4KOP0W4l2QJmXu5XuD/5SsYIRfuMbwIn2nYdkni0ncU9S'),
(3, '', '$2y$10$IV1dbsDvN/mSVM0SI4MpOuyo.sBw8Hu8vmaFUROI9A3AJMAkuqxLi'),
(5, 'dp', '$2y$10$EKTSNpcqaFX.CLrfAH5SEOxW44.Jt3jD3Tl4wVfWAn.JOC7eCy/J6');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tree`
--
ALTER TABLE `tree`
  ADD PRIMARY KEY (`I_ID`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`I_ID`),
  ADD UNIQUE KEY `S_USERNAME` (`S_USERNAME`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tree`
--
ALTER TABLE `tree`
  MODIFY `I_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `I_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
