-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 07, 2018 at 08:14 AM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `putriwardrobe`
--

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `level_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`level_id`, `name`, `description`) VALUES
(1, 'owner', 'owner adalah ....'),
(2, 'supervisor', 'adlaah'),
(3, 'cashier', 'adalah');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `product_category_id` int(11) NOT NULL,
  `name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_wardrobes`
--

CREATE TABLE `product_wardrobes` (
  `product_wardrobe_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `wardrobe_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_opname`
--

CREATE TABLE `stock_opname` (
  `stock_opname_id` int(11) NOT NULL,
  `product_wardrobe_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `real_stock` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `store_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `cashier_id` int(11) DEFAULT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_detail`
--

CREATE TABLE `transaction_detail` (
  `transaction_detail_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `product_wardrobe_id` int(11) NOT NULL,
  `cashier_id` int(11) DEFAULT NULL,
  `type` enum('sold','restock','request','approved') NOT NULL DEFAULT 'sold',
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `level_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` text,
  `password` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wardrobes`
--

CREATE TABLE `wardrobes` (
  `wardrobe_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`product_category_id`);

--
-- Indexes for table `product_wardrobes`
--
ALTER TABLE `product_wardrobes`
  ADD PRIMARY KEY (`product_wardrobe_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `wardrobe_id` (`wardrobe_id`);

--
-- Indexes for table `stock_opname`
--
ALTER TABLE `stock_opname`
  ADD PRIMARY KEY (`stock_opname_id`),
  ADD KEY `product_wardrobe_id` (`product_wardrobe_id`),
  ADD KEY `supervisor_id` (`supervisor_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  ADD PRIMARY KEY (`transaction_detail_id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD UNIQUE KEY `product_wardrobe_id` (`product_wardrobe_id`),
  ADD KEY `cashier_id` (`cashier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `wardrobes`
--
ALTER TABLE `wardrobes`
  ADD PRIMARY KEY (`wardrobe_id`),
  ADD KEY `store_id` (`store_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `product_category_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_wardrobes`
--
ALTER TABLE `product_wardrobes`
  MODIFY `product_wardrobe_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_opname`
--
ALTER TABLE `stock_opname`
  MODIFY `stock_opname_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  MODIFY `transaction_detail_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wardrobes`
--
ALTER TABLE `wardrobes`
  MODIFY `wardrobe_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_category_fk` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`product_category_id`) ON UPDATE CASCADE;

--
-- Constraints for table `product_wardrobes`
--
ALTER TABLE `product_wardrobes`
  ADD CONSTRAINT `product_wardrobes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `product_wardrobes_ibfk_2` FOREIGN KEY (`wardrobe_id`) REFERENCES `wardrobes` (`wardrobe_id`);

--
-- Constraints for table `stock_opname`
--
ALTER TABLE `stock_opname`
  ADD CONSTRAINT `stock_opname_ibfk_1` FOREIGN KEY (`product_wardrobe_id`) REFERENCES `product_wardrobes` (`product_wardrobe_id`),
  ADD CONSTRAINT `stock_opname_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  ADD CONSTRAINT `transaction_detail_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`),
  ADD CONSTRAINT `transaction_detail_ibfk_2` FOREIGN KEY (`product_wardrobe_id`) REFERENCES `product_wardrobes` (`product_wardrobe_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`store_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`level_id`) REFERENCES `levels` (`level_id`);

--
-- Constraints for table `wardrobes`
--
ALTER TABLE `wardrobes`
  ADD CONSTRAINT `wardrobes_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`store_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
