-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2016 at 12:24 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) unsigned NOT NULL,
  `address1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `address1`, `address2`, `city`, `postal_code`, `telephone`, `customer_id`) VALUES
(3, 'No 25 Bastian Mawatha Colombo 11', '', 'Colombo', '10001', '0775682369', 3),
(4, 'No 435/1 Kandy Road Kadawatha', '', 'Kadawatha', '110002', '0775868782', 4),
(5, 'No 567/A Weemalasena MW Kandy', '', 'Kandy', '500001', '0745566798', 5),
(6, '58/A Darmapala mawatha ', '', 'Kandy', '10001', '0754851515', 6),
(7, '26 GIAMPILIERI MARINA', '', 'MESSINA', '98141', '0751110235', 7),
(8, '468 GIAMPILIERI MARINA', '', 'MESSINA', '98141', '0772324589', 8),
(10, '45/A Kalagedihena ', 'Kandy Colombo RD', 'Nittabuwa', '155896', '0756048658', 10),
(11, 'VIA NAZIONALE, 163 GIAMPILIERI MARINA', '', 'MESSINA', '98141', '0713343325', 11),
(12, '470 / B New Kandy Road Kadawatha', '', 'Kadawatha', '100025', '0772087820', 12),
(13, 'No 123/5 Nawala Road Koswaththa', '', 'Rajagiriya', '122356', '0718774978', 13),
(15, 'No 130/5 Athurugiriya Road', 'Arangala', 'Malabe', '15002', '0713323556', 16),
(16, '37, Eastfields Road', '', 'Mitcham', 'CR4 2LS', '0775555555', 17),
(17, 'No 25/A Marakkala watta', '', ' Beruwala', '140001', '0112895689', 17),
(18, 'No 56/20 Kakulapana Rd Mawathagama', '', 'Kurunagala', '10001', '0112115588', 1),
(19, 'No 45 Wijayaba mawatha Nawala', '', 'Colombo', '20001', '0775689569', 19);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) unsigned NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `first_name`, `last_name`, `user_id`) VALUES
(2, 'Test Customer', 'Testing123', 2),
(3, 'Indika', 'Madanayaka', 3),
(4, 'Juliya', 'Fernando', 4),
(5, 'Rayan', 'Fernando', 5),
(6, 'Sara', 'Fernando', 6),
(7, 'Gayan', 'Smith', 7),
(8, 'Madu', 'Smith', 8),
(10, 'John', 'Smith', 10),
(11, 'Samdudu ', 'Udantha ', 11),
(12, 'Sithaa', 'Fernando', 12),
(13, 'Isura', 'Nilupul', 13),
(16, 'Thilina', 'Dilshan', 16),
(17, 'Saradu', 'Rajapaksha', 17),
(19, 'Rangana', 'Herath', 19);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) unsigned NOT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` double DEFAULT NULL,
  `address_id` int(11) unsigned DEFAULT NULL,
  `customer_id` int(11) unsigned DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `number`, `total`, `address_id`, `customer_id`, `status`, `created_at`) VALUES
(11, '575248', 2701.5, 10, 11, 'shipped', '2016-11-25 14:36:12'),
(12, '835506', 2701.5, 11, 12, 'pending', '2016-11-25 19:26:02'),
(13, '074499', 2701.5, 12, 13, 'shipped', '2016-11-25 19:31:36'),
(14, '105149', 2701.5, 13, 13, 'canceled', '2016-11-25 19:40:56'),
(16, '398907', 300.3, 15, 16, 'shipped', '2016-11-26 21:32:15'),
(17, '367732', 1501.5, 16, 17, 'canceled', '2016-11-27 00:56:42'),
(18, '109991', 600, 16, 17, 'shipped', '2016-11-27 03:41:42'),
(19, '323531', 150.15, 18, NULL, 'shipped', '2016-10-31 18:29:51'),
(20, '083065', 24000, 19, 19, 'shipped', '2016-12-03 16:38:36');

-- --------------------------------------------------------

--
-- Table structure for table `orderproduct`
--

CREATE TABLE IF NOT EXISTS `orderproduct` (
  `id` int(11) unsigned NOT NULL,
  `order_id` int(11) unsigned DEFAULT NULL,
  `product_id` int(11) unsigned DEFAULT NULL,
  `quantity` int(11) unsigned DEFAULT NULL,
  `unit_price` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orderproduct`
--

INSERT INTO `orderproduct` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(1, 11, 14, 10, 150.15),
(2, 11, 17, 2, 600),
(3, 12, 14, 10, 150.15),
(4, 12, 17, 2, 600),
(5, 13, 14, 10, 150.15),
(6, 13, 17, 2, 600),
(7, 14, 14, 10, 150.15),
(8, 14, 17, 2, 600),
(9, 16, 14, 2, 150.15),
(10, 17, 14, 10, 150.15),
(11, 18, 17, 1, 600),
(12, 19, 14, 1, 150.15),
(13, 20, 18, 1, 24000);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) unsigned NOT NULL,
  `admin` int(11) unsigned DEFAULT NULL,
  `staff` int(11) unsigned DEFAULT NULL,
  `customer` int(11) unsigned DEFAULT NULL,
  `banned` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `admin`, `staff`, `customer`, `banned`, `user_id`) VALUES
(1, 1, 0, 0, 0, 1),
(2, 0, 0, 1, 0, 2),
(3, 0, 0, 1, 0, 3),
(4, 0, 0, 1, 0, 4),
(5, 0, 0, 1, 0, 5),
(6, 0, 0, 1, 0, 6),
(7, 0, 0, 1, 0, 7),
(8, 0, 0, 1, 0, 8),
(10, 0, 0, 1, 0, 10),
(11, 0, 0, 1, 0, 11),
(12, 0, 0, 1, 0, 12),
(13, 0, 0, 1, 0, 13),
(16, 0, 0, 1, 0, 16),
(17, 0, 0, 1, 0, 17),
(18, 0, 1, 0, 0, 18),
(19, NULL, NULL, 1, NULL, 19),
(20, NULL, 1, NULL, NULL, 20);

-- --------------------------------------------------------

--
-- Table structure for table `po`
--

CREATE TABLE IF NOT EXISTS `po` (
  `id` int(11) unsigned NOT NULL,
  `number` int(11) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `total` double DEFAULT NULL,
  `supplier_id` int(11) unsigned DEFAULT NULL,
  `stock` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `po`
--

INSERT INTO `po` (`id`, `number`, `date`, `total`, `supplier_id`, `stock`) VALUES
(1, 136784, '2016-12-05', 22500000, 1, 0),
(2, 839789, '2016-12-03', 1500000, 1, 0),
(3, 949088, '2016-12-08', 12000000, 1, 0),
(4, 364286, '2016-12-03', 3003, 1, 1),
(5, 806105, '2016-12-03', 24000000, 1, 0),
(6, 642359, '2016-12-03', 15000000, 1, 0),
(7, 228516, '2016-12-01', 60000, 1, 0),
(8, 302413, '2016-12-01', 15000000, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `poproduct`
--

CREATE TABLE IF NOT EXISTS `poproduct` (
  `id` int(11) unsigned NOT NULL,
  `po_id` int(11) unsigned DEFAULT NULL,
  `product_id` int(11) unsigned DEFAULT NULL,
  `quantity` int(11) unsigned DEFAULT NULL,
  `unit_price` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `poproduct`
--

INSERT INTO `poproduct` (`id`, `po_id`, `product_id`, `quantity`, `unit_price`) VALUES
(1, 1, 19, 150, 150000),
(2, 2, 19, 10, 150000),
(3, 3, 18, 50, 240000),
(4, 4, 14, 20, 150.15),
(5, 5, 18, 100, 240000),
(6, 6, 19, 100, 150000),
(7, 7, 17, 100, 600),
(8, 8, 19, 100, 150000);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` double DEFAULT NULL,
  `quantity` int(11) unsigned DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reorder` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `title`, `slug`, `code`, `description`, `price`, `quantity`, `image`, `reorder`) VALUES
(14, 'Dell XPS 13" Core i5 4gb Ram 2016 Final Edition', 'Dell-XPS-13-Core-i5-4gb-Ram-2016-Final-Edition-14', '000001', 'Progressively e-enable installed base e-services after inexpensive growth strategies. Continually conceptualize pandemic functionalities vis-a-vis client-focused opportunities. Compellingly engage value-added applications with maintainable supply ', 150.15, 47, '4922b4864c8744f2c3bfe7241ed99887', 20),
(17, 'Samusng Galaxy S7 64GB Original Made in Korea', 'Samusng-Galaxy-S7-64GB-Original-Made-in-Korea-17', '000002', 'Dramatically utilize intuitive experiences and intuitive information. Assertively conceptualize progressive "outside the box" thinking via enabled niche markets. Monotonectally monetize leading-edge manufactured products rather than economically ', 600, 49, '', 100),
(18, 'New Motorola Moto X XT1060 Verizon / GSM Unlocked 16GB White Android Smartphone', 'New-Motorola-Moto-X-XT1060-Verizon-GSM-Unlocked-16GB-White-Android-Smartphone-18', '000004', 'Seamlessly expedite customer directed e-business without leveraged platforms. Credibly pontificate just in time strategic theme areas via interdependent products. Dynamically mesh orthogonal niche markets without just in time e-markets. ', 24000, 99, 'e66b8c2cdf8c513694b33e00eddd4414', 50),
(19, 'Apple MacBook Pro (13-inch, Late 2011) 2.4 GHz i5 16GB 500GB MD314LL/A', 'Apple-MacBook-Pro-13-inch-Late-2011-2-4-GHz-i5-16GB-500GB-MD314LL-A-19', '594444', 'This auction is for (1) used 13-inch MacBook Pro in perfect working condition. It has been reformatted with a clean install of OS X Yosemite. It passed all 97 diagnostic tests on the Apple Hardware Diagnostics CD on 9/25/15 (see screenshot). It is in good physical condition, has some wear with scratches and scuffs. ', 150000, 263, '61250ec9682fbefd6cd1470a4f40d136', 100);

-- --------------------------------------------------------

--
-- Table structure for table `reset`
--

CREATE TABLE IF NOT EXISTS `reset` (
  `id` int(11) unsigned NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reset`
--

INSERT INTO `reset` (`id`, `token`, `user_id`) VALUES
(1, '5257979c8dff8e3b87cba98b6e4adad5452977dd2fd57760ca84cf7cb9dc34f4', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `first_name`, `last_name`, `user_id`) VALUES
(1, 'Manoj', 'Prasanna', 1),
(2, 'Test', 'Staff', 18),
(3, 'Staff', 'Two', 20);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(11) unsigned NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `company_name`, `email`, `address`, `telephone`) VALUES
(1, 'Lucids', 'info@lucids.info', 'No 24/A Lucids INC Lake Road LA, USA', '3294232556');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`) VALUES
(1, 'mpe2010manoj@gmail.com', '$2y$10$NhbqLFzgm6Vkh5oWf2gTfeGKdyiy2y2VG7kv2Y3ty9uAvl6oZPwJi'),
(2, 'test@gmail.com', '$2y$10$vM/vNgosn0gUhDvV.3OSqeVeLuGeJF4mreka0dj/rcAgCn/Jq/SXe'),
(3, 'indka@gmail.com', '$2y$10$Lo38upoXM87BxO6n9TPPTetl.QPIC1hJg.JIJm3ucdRsFtI2CDjnu'),
(4, 'smith1@gmail.com', '$2y$10$q/eL.Do8ulXdiqLWrjk.peMhiN9zF..WsV4t7e.i8irkkZ81NJA0i'),
(5, 'rayank@gmail.com', '$2y$10$/uzXyjJm64u1IdOx.ZyiH.zQW/vL3nBs6936m0lxWgPkkiaDoTVc2'),
(6, 'sara@gmail.com', '$2y$10$LuXb6.ykAisMQVv05ukxcOJEv2nVbrvGSJtFp5upK9ZOhoARWg5RS'),
(7, 'busysmith@gmail.com', '$2y$10$xGq9sMHQiW0EweTHiVj1mOS7AgtVeqVqfJvhs1orPXxgSr3sQcuym'),
(8, 'busymed@gmail.com', '$2y$10$fUspzbQ/BtNpbUAoQEkc0.y21uz/k90hjUDiWh//qvRMWY17f88N6'),
(10, 'seeer@gmail.com', '$2y$10$hAw.Vrj4tDMLPNxqNbWcM.A5dR3PSqAAvNJ51opMn2lzXAlpIXIJC'),
(11, 'samudu96@gmail.com', '$2y$10$ohVrZJHFlr6e2MoXb3Jsy.UHGWD/iNXELPEbrnrAE5DolC7aMQ136'),
(12, 'fernando@gmail.com', '$2y$10$tRfe9irxTxE./79wXRmdWuUH2kabJVWcfI8kdOxz9VU.7FAbgqfma'),
(13, 'isuran@gmail.com', '$2y$10$1JLOzruQi0HVUJmE3F9xKOrtINqE/Oe0HUCK0KaXd1nD.exGCxcB6'),
(16, 'tdilshan@yahoo.com', '$2y$10$gpYH9D/gTVmhJwwbYKRJQeSA1EedcffUbnjc9w5.8wcpeGOBKCVzS'),
(17, 'sadarur@gmail.com', '$2y$10$Nb28QB6ReAuiK9FaA4pTROQmTW649xG6v0XlRwwuwiDS0tb5CjdDq'),
(18, 'testsatf@gmail.com', '$2y$10$nCSAp10DMadn7fRdUr9tr.DEHo.94lhvc/7WPk7odNbmtUC./YUgu'),
(19, 'ranganasl@gmail.com', '$2y$10$VdxNz0OBNRTnSwc0hlsVS.ygVzjk4Gos3fCaNHTBPw8bwUPrOh/zK'),
(20, 'staff@lucids.info', '$2y$10$J/BvxsWWr0jZzrdi1kHKHe5dWYzQil5l/N.LZLCjIcEIPkUAi6j4K');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_customer_user` (`user_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_order_address` (`address_id`),
  ADD KEY `index_foreignkey_order_customer` (`customer_id`);

--
-- Indexes for table `orderproduct`
--
ALTER TABLE `orderproduct`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_orderproduct_order` (`order_id`),
  ADD KEY `index_foreignkey_orderproduct_product` (`product_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_permission_user` (`user_id`);

--
-- Indexes for table `po`
--
ALTER TABLE `po`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_po_supplier` (`supplier_id`);

--
-- Indexes for table `poproduct`
--
ALTER TABLE `poproduct`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_poproduct_po` (`po_id`),
  ADD KEY `index_foreignkey_poproduct_product` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset`
--
ALTER TABLE `reset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_reset_user` (`user_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `orderproduct`
--
ALTER TABLE `orderproduct`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `po`
--
ALTER TABLE `po`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `poproduct`
--
ALTER TABLE `poproduct`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `reset`
--
ALTER TABLE `reset`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `c_fk_customer_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `c_fk_order_address_id` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `c_fk_order_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `orderproduct`
--
ALTER TABLE `orderproduct`
  ADD CONSTRAINT `c_fk_orderproduct_order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `c_fk_orderproduct_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `c_fk_permission_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `po`
--
ALTER TABLE `po`
  ADD CONSTRAINT `c_fk_po_supplier_id` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `poproduct`
--
ALTER TABLE `poproduct`
  ADD CONSTRAINT `c_fk_poproduct_po_id` FOREIGN KEY (`po_id`) REFERENCES `po` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `c_fk_poproduct_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `reset`
--
ALTER TABLE `reset`
  ADD CONSTRAINT `c_fk_reset_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
