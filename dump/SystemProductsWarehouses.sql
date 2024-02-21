-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 21, 2024 at 10:02 AM
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
-- Database: `SystemProductsWarehouses`
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
(130, 1, 'склад1 продукт1 был 5 стало 2\nсклад2 продукт1 было 0 перемещено 3 стало 3'),
(131, 1, 'склад2 продукт1 был 3 стало 0\nсклад1 продукт1 было 2 перемещено 3 стало 5');

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
-- Table structure for table `product_warehouse`
--

CREATE TABLE `product_warehouse` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_warehouse`
--

INSERT INTO `product_warehouse` (`id`, `product_id`, `warehouse_id`, `quantity`) VALUES
(1, 1, 1, 5),
(2, 2, 2, 5),
(3, 3, 3, 5),
(4, 4, 4, 5),
(5, 5, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `created_at`) VALUES
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
-- Indexes for table `product_warehouse`
--
ALTER TABLE `product_warehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history_product_moving`
--
ALTER TABLE `history_product_moving`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_warehouse`
--
ALTER TABLE `product_warehouse`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34221;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34124;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
