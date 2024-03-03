-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 03, 2024 at 12:59 PM
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
-- Table structure for table `history_movement_product`
--

CREATE TABLE `history_movement_product` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `from_storage_id` int NOT NULL,
  `to_storage_id` int NOT NULL,
  `past_quantity_from_storage` int NOT NULL,
  `now_quantity_from_storage` int NOT NULL,
  `past_quantity_to_storage` int NOT NULL,
  `now_quantity_to_storage` int NOT NULL,
  `move_quantity` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `history_movement_product`
--

INSERT INTO `history_movement_product` (`id`, `product_id`, `from_storage_id`, `to_storage_id`, `past_quantity_from_storage`, `now_quantity_from_storage`, `past_quantity_to_storage`, `now_quantity_to_storage`, `move_quantity`, `created_at`, `updated_at`) VALUES
(44, 1, 1, 2, 3, 0, 0, 3, 3, '2024-03-03 12:34:13', '2024-03-03 12:34:13'),
(45, 1, 2, 1, 3, 0, 0, 3, 3, '2024-03-03 12:55:08', '2024-03-03 12:55:08'),
(46, 1, 1, 2, 3, 0, 0, 3, 3, '2024-03-03 12:56:09', '2024-03-03 12:56:09'),
(47, 1, 2, 1, 3, 2, 0, 1, 1, '2024-03-03 12:56:13', '2024-03-03 12:56:13');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `price` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 'продукт1', 500, 5, '2024-02-18 17:53:03', '2024-02-29 11:01:20'),
(2, 'продукт2', 500, 5, '2024-02-18 17:53:03', '2024-02-29 11:01:20'),
(3, 'продукт3', 500, 5, '2024-02-18 17:53:03', '2024-02-29 11:01:20'),
(4, 'продукт4', 500, 5, '2024-02-18 17:53:03', '2024-02-29 11:01:20'),
(5, 'продукт5', 500, 5, '2024-02-18 17:53:03', '2024-02-29 11:01:20');

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
(3, 3, 3, 5),
(4, 4, 4, 5),
(8, 5, 5, 5),
(30, 2, 2, 5),
(35, 1, 2, 2),
(36, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `storages`
--

CREATE TABLE `storages` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `storages`
--

INSERT INTO `storages` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'склад1', '2024-02-18 17:52:28', '2024-02-29 11:42:46'),
(2, 'склад2', '2024-02-18 17:52:37', '2024-02-29 11:42:46'),
(3, 'склад3', '2024-02-18 17:52:43', '2024-02-29 11:42:46'),
(4, 'склад4', '2024-02-18 17:52:49', '2024-02-29 11:42:46'),
(5, 'склад5', '2024-02-18 17:52:55', '2024-02-29 11:42:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history_movement_product`
--
ALTER TABLE `history_movement_product`
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
-- AUTO_INCREMENT for table `history_movement_product`
--
ALTER TABLE `history_movement_product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_storage`
--
ALTER TABLE `product_storage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `storages`
--
ALTER TABLE `storages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34124;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
