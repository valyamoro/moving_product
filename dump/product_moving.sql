-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 24, 2024 at 10:05 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `product_moving`
--

-- --------------------------------------------------------

--
-- Table structure for table `history_product_moving`
--

CREATE TABLE `history_product_moving` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `history_product_moving`
--

INSERT INTO `history_product_moving` (`id`, `product_id`, `description`) VALUES
(210, 1, 'склад1 продукт1 был 1\r\n        стало 0 23-02-2024 13:43\n| склад2 продукт1 было 0\r\n        перемещено 1 стало 1 23-02-2024 13:43'),
(211, 4, 'склад5 продукт4 был 5\r\n        стало 1 23-02-2024 13:44\n| склад1 продукт4 было 0\r\n        перемещено 4 стало 4 23-02-2024 13:44'),
(212, 1, 'склад2 продукт1 был 1\r\n        стало 0 23-02-2024 14:07\n| склад1 продукт1 было 0\r\n        перемещено 1 стало 1 23-02-2024 14:07'),
(213, 3, 'склад5 продукт3 был 3\r\n        стало 0 23-02-2024 14:08\n| склад3 продукт3 было 0\r\n        перемещено 3 стало 3 23-02-2024 14:08'),
(214, 5, 'склад4 продукт5 был 2\r\n        стало 0 23-02-2024 15:11\n| склад1 продукт5 было 0\r\n        перемещено 2 стало 2 23-02-2024 15:11'),
(215, 2, 'склад1 продукт2 был 3\r\n        стало 0 23-02-2024 15:11\n| склад2 продукт2 было 0\r\n        перемещено 3 стало 3 23-02-2024 15:11'),
(216, 1, 'склад5 продукт1 был 1\r\n        стало 0 23-02-2024 15:55\n| склад1 продукт1 было 0\r\n        перемещено 1 стало 1 23-02-2024 15:55'),
(217, 1, 'склад1 продукт1 был 1\r\n        стало 1 23-02-2024 16:01\n| склад1 продукт1 было 1\r\n        перемещено 0 стало 1 23-02-2024 16:01'),
(218, 1, 'склад1 продукт1 был 1\r\n        стало 1 23-02-2024 16:02\n| склад1 продукт1 было 1\r\n        перемещено 0 стало 1 23-02-2024 16:02'),
(219, 1, 'склад1 продукт1 был 1\r\n        стало 0 23-02-2024 16:13\n| склад2 продукт1 было 0\r\n        перемещено 1 стало 1 23-02-2024 16:13'),
(220, 1, 'склад2 продукт1 был 1\r\n        стало 1 24-02-2024 09:52\n| склад1 продукт1 было 0\r\n        перемещено 0 стало 0 24-02-2024 09:52'),
(221, 1, 'склад2 продукт1 был 1\r\n        стало 1 24-02-2024 09:52\n| склад1 продукт1 было 0\r\n        перемещено 0 стало 0 24-02-2024 09:52');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `price` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `quantity`, `created_at`) VALUES
(1, 'продукт1', 500, 5, '2024-02-18 17:53:03'),
(2, 'продукт2', 500, 5, '2024-02-18 17:53:03'),
(3, 'продукт3', 500, 5, '2024-02-18 17:53:03'),
(4, 'продукт4', 500, 5, '2024-02-18 17:53:03'),
(5, 'продукт5', 500, 5, '2024-02-18 17:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `product_storage`
--

CREATE TABLE `product_storage` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `storage_id` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_storage`
--

INSERT INTO `product_storage` (`id`, `product_id`, `storage_id`, `quantity`) VALUES
(34273, 4, 5, 1),
(34283, 4, 1, 4),
(34285, 3, 3, 3),
(34289, 5, 1, 2),
(34290, 2, 2, 3),
(34292, 1, 2, 1),
(34293, 1, 1, 0),
(34294, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `storages`
--

CREATE TABLE `storages` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `storages`
--

INSERT INTO `storages` (`id`, `name`, `created_at`) VALUES
(1, 'склад1', '2024-02-18 17:52:28'),
(2, 'склад2', '2024-02-18 17:52:37'),
(3, 'склад3', '2024-02-18 17:52:43'),
(4, 'склад4', '2024-02-18 17:52:49'),
(5, 'склад5', '2024-02-18 17:52:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history_product_moving`
--
ALTER TABLE `history_product_moving`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_storage`
--
ALTER TABLE `product_storage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storages`
--
ALTER TABLE `storages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history_product_moving`
--
ALTER TABLE `history_product_moving`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_storage`
--
ALTER TABLE `product_storage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34295;

--
-- AUTO_INCREMENT for table `storages`
--
ALTER TABLE `storages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34124;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
