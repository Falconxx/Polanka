-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 08 Paź 2018, 12:39
-- Wersja serwera: 10.1.36-MariaDB
-- Wersja PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `pracainz`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dormitory`
--

CREATE TABLE `dormitory` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `address` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `phone_number` int(9) NOT NULL,
  `mail` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `dormitory`
--

INSERT INTO `dormitory` (`id`, `name`, `address`, `phone_number`, `mail`) VALUES
(1, 'T-19', 'Wittiga 8', 0, 'T19@mail.com'),
(21, 'Polanka', 'asfa', 123456789, 'asaromaro@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `surname` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `birthdate` date NOT NULL,
  `PESEL` int(11) NOT NULL,
  `phone_number` int(9) NOT NULL,
  `adress` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `number_of_purchases` int(11) NOT NULL,
  `number_of_completed_works` int(11) NOT NULL,
  `employee_status` int(1) NOT NULL,
  `admin_status` tinyint(1) NOT NULL,
  `dormitory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `list_of_order`
--

CREATE TABLE `list_of_order` (
  `id` int(11) NOT NULL,
  `dormitory_id` int(11) NOT NULL,
  `room` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `equipment` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `status` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `priority` int(1) NOT NULL,
  `description` varchar(350) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `storage`
--

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `dormitory_id` int(11) NOT NULL,
  `item_name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `number_of_requests` int(11) NOT NULL,
  `item_weight` int(1) NOT NULL,
  `item_price` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `dormitory_id` int(11) NOT NULL,
  `store_name` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `store_address` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `store_phone_number` int(9) NOT NULL,
  `store_working_hours` varchar(200) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `dormitory_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `surname` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `number_of_problems` int(11) NOT NULL,
  `number_of_erroneous_problems` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `email`, `user_password`, `dormitory_id`, `name`, `surname`, `phone_number`, `number_of_problems`, `number_of_erroneous_problems`) VALUES
(1, 'test@gmail.com', '1', 1, '', '', 0, 0, 0),
(2, 'test2@gmail.com', '1', 1, '', '', 1, 0, 0),
(3, 'test3@gmail.com', '$2y$10$A2MTxuDUPXPTiZUJoFG5Z.bFsc5vGZvxRUdTKU6ZPth5ZyOriIdlW', 1, 'name', 'surname', 11, 0, 0),
(18, 'asaromaro@gmail.com', '$2y$10$cNXeTcAvLVeCi9MGY70Y1esZsLxSQJ5pXPNYaZ7Q9psnwEUt9.41G', 21, 'Arek', 'Sokolowski', 123456789, 0, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dormitory`
--
ALTER TABLE `dormitory`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`PESEL`,`phone_number`),
  ADD KEY `dormitory_id` (`dormitory_id`);

--
-- Indeksy dla tabeli `list_of_order`
--
ALTER TABLE `list_of_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dormitory_id` (`dormitory_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indeksy dla tabeli `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dormitory_id` (`dormitory_id`);

--
-- Indeksy dla tabeli `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_phone_number` (`store_phone_number`),
  ADD KEY `dormitory_id` (`dormitory_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD UNIQUE KEY `phone_number_2` (`phone_number`),
  ADD KEY `dormitory_id` (`dormitory_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `dormitory`
--
ALTER TABLE `dormitory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`dormitory_id`) REFERENCES `dormitory` (`id`);

--
-- Ograniczenia dla tabeli `list_of_order`
--
ALTER TABLE `list_of_order`
  ADD CONSTRAINT `list_of_order_ibfk_1` FOREIGN KEY (`dormitory_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `list_of_order_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `list_of_order_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Ograniczenia dla tabeli `storage`
--
ALTER TABLE `storage`
  ADD CONSTRAINT `storage_ibfk_1` FOREIGN KEY (`dormitory_id`) REFERENCES `employees` (`id`);

--
-- Ograniczenia dla tabeli `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `store_ibfk_1` FOREIGN KEY (`dormitory_id`) REFERENCES `employees` (`id`);

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`dormitory_id`) REFERENCES `dormitory` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
