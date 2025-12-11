-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 04:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `railway`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `city` varchar(80) NOT NULL,
  `street` varchar(200) NOT NULL,
  `details` varchar(250) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `city`, `street`, `details`, `phone`, `is_default`, `created_at`) VALUES
(1, 4, 'الرياض', 'شارع العليا', 'شقة 12', '0500000000', 1, '2025-12-09 12:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'نساء', '2025-12-08 12:45:18'),
(2, 'رجالي', '2025-12-08 12:45:18'),
(3, 'اثاث', '2025-12-08 12:45:18'),
(4, 'هدايا', '2025-12-08 12:45:18'),
(5, 'أعمال خشبية', '2025-12-08 12:45:18');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `buyer_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('PENDING','PAID','SHIPPED','DELIVERED','CANCELLED') NOT NULL DEFAULT 'PENDING',
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `buyer_id`, `shipping_address_id`, `status`, `total_amount`, `created_at`) VALUES
(1, 4, 1, 'PAID', 500.00, '2025-12-09 12:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL CHECK (`qty` > 0),
  `unit_price` decimal(10,2) NOT NULL CHECK (`unit_price` >= 0),
  `line_total` decimal(10,2) GENERATED ALWAYS AS (`qty` * `unit_price`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `seller_id`, `qty`, `unit_price`) VALUES
(1, 1, 7, 2, 1, 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(160) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL CHECK (`price` >= 0),
  `stock_qty` int(11) NOT NULL DEFAULT 0 CHECK (`stock_qty` >= 0),
  `status` enum('DRAFT','PUBLISHED','ARCHIVED') NOT NULL DEFAULT 'DRAFT',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `category_id`, `title`, `description`, `price`, `stock_qty`, `status`, `created_at`, `updated_at`) VALUES
(7, 2, 5, 'بببببببب', 'ببببببببببب', 500.00, 0, 'PUBLISHED', '2025-12-08 13:36:04', '2025-12-08 13:39:40'),
(9, 3, 1, 'fffff', 'gggggggggg', 50.00, 0, 'PUBLISHED', '2025-12-08 13:52:58', '2025-12-08 13:52:58'),
(10, 2, 3, 'حقيبة', 'بببببببببب', 250.00, 2, 'PUBLISHED', '2025-12-09 13:08:26', '2025-12-09 13:08:26'),
(11, 2, 3, 'بببببب', 'ببببببببب', 500.00, 8, 'PUBLISHED', '2025-12-09 13:09:54', '2025-12-10 16:24:07'),
(12, 2, 3, 'dddddd', 'ddddddddddd', 200.00, 8, 'PUBLISHED', '2025-12-10 16:27:06', '2025-12-10 16:27:06'),
(13, 2, 4, 'kkkkkkk', 'hhhhhhhhhhh', 522.00, 4, 'PUBLISHED', '2025-12-10 16:28:21', '2025-12-10 16:28:21'),
(14, 2, 5, 'ccccccccc', 'ffffffffff', 522.00, 3, 'PUBLISHED', '2025-12-10 16:30:35', '2025-12-10 16:30:35'),
(15, 2, 1, 'بببببب', 'للللللللللل', 500.00, 9, 'PUBLISHED', '2025-12-10 16:38:57', '2025-12-10 16:38:57'),
(16, 2, 3, 'للللللل', 'لللللللل', 600.00, 44, 'PUBLISHED', '2025-12-10 16:43:09', '2025-12-10 16:43:09'),
(17, 2, 2, 'بببببببببب', 'بببببببببببببب', 800.00, 6, 'PUBLISHED', '2025-12-10 16:44:15', '2025-12-10 16:44:15'),
(18, 2, 1, 'ييييييييييي', 'ييييييييييييي', 5222.00, 10, 'PUBLISHED', '2025-12-10 16:47:57', '2025-12-10 16:47:57'),
(19, 2, 3, 'بببببببببب', 'بببببببببببب', 600.00, 22, 'PUBLISHED', '2025-12-10 16:53:39', '2025-12-10 16:53:39');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `is_primary`, `created_at`) VALUES
(1, 7, 'uploads/products/p7_45de320310b8cb75.jpg', 1, '2025-12-08 13:36:04'),
(3, 9, 'uploads/products/p9_04b9bbdfb9db3f32.png', 1, '2025-12-08 13:52:58'),
(4, 10, 'uploads/products/p10_672eb0c1124bedb8.jpg', 1, '2025-12-09 13:08:26'),
(5, 11, 'uploads/products/p11_84d946e4a7939447.jpg', 0, '2025-12-09 13:09:54'),
(6, 11, 'uploads/products/p11_cee47ac1e21fe840.png', 1, '2025-12-10 16:24:07'),
(7, 12, 'uploads/products/p12_37fe699933dff73c.png', 1, '2025-12-10 16:27:06'),
(8, 13, 'uploads/products/p13_6ac94e26b3016578.png', 1, '2025-12-10 16:28:21'),
(9, 14, 'uploads/products/p14_1b7b565c88d641a5.png', 1, '2025-12-10 16:30:35'),
(10, 15, 'seller/uploads/products/p15_16a261e13907a419.jpg', 1, '2025-12-10 16:38:57'),
(11, 16, 'uploads/products/p16_d7828ddf4dfe9e93.png', 1, '2025-12-10 16:43:09'),
(12, 17, 'uploads/products/p17_b749ba76161ebf09.png', 1, '2025-12-10 16:44:15'),
(13, 18, 'uploads/products/p18_576c3c5aeb3d15e9.jpg', 1, '2025-12-10 16:47:57'),
(14, 19, 'uploads/products/p19_266c47732b1629c6.jpg', 1, '2025-12-10 16:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shop_name` varchar(120) NOT NULL,
  `shop_bio` text DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `rating_avg` decimal(3,2) NOT NULL DEFAULT 0.00,
  `rating_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`user_id`, `shop_name`, `shop_bio`, `phone`, `rating_avg`, `rating_count`, `created_at`) VALUES
(2, 'متجر فيصل', NULL, NULL, 0.00, 0, '2025-12-08 12:51:21'),
(3, 'متجر محمد', NULL, NULL, 0.00, 0, '2025-12-08 13:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `seller_order_tracking`
--

CREATE TABLE `seller_order_tracking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('PENDING','PAID','SHIPPED','DELIVERED','CANCELLED') NOT NULL DEFAULT 'PENDING',
  `expected_delivery_date` date DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seller_order_tracking`
--

INSERT INTO `seller_order_tracking` (`id`, `order_id`, `seller_id`, `status`, `expected_delivery_date`, `delivered_at`, `updated_at`) VALUES
(1, 1, 2, 'PAID', '2025-12-12', '2025-12-09 16:35:59', '2025-12-09 13:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('BUYER','SELLER','ADMIN') NOT NULL DEFAULT 'BUYER',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password_hash`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'سارة أحمد', 'sara@example.com', '$2y$10$EXAMPLE_HASH_HERE', 'SELLER', 1, '2025-12-08 12:46:36', '2025-12-08 12:46:36'),
(2, 'فيصل', 'admin@gmail.com', '$2y$10$Wj9xCIeBHIGAzbzjcBcRpOp/QLIlEWBmGyAIcHNlZV/HgE76/YdLG', 'SELLER', 1, '2025-12-08 12:51:21', '2025-12-08 12:51:21'),
(3, 'محمد', 'm@gmail.com', '$2y$10$YNWYsfqW3TvFZS.pJkiZGOVXHlnJ8RQgJkOgOSiMu1xVHUWGVruty', 'SELLER', 1, '2025-12-08 13:51:17', '2025-12-08 13:51:17'),
(4, 'مشتري تجريبي', 'buyer_test@example.com', '$2y$10$EXAMPLE_HASH_HERE', 'BUYER', 1, '2025-12-09 12:48:46', '2025-12-09 12:48:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_address_user` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orders_buyer` (`buyer_id`),
  ADD KEY `idx_orders_status` (`status`),
  ADD KEY `fk_orders_address` (`shipping_address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_items_order` (`order_id`),
  ADD KEY `idx_items_seller` (`seller_id`),
  ADD KEY `fk_items_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_products_seller` (`seller_id`),
  ADD KEY `idx_products_category` (`category_id`),
  ADD KEY `idx_products_status` (`status`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_images_product` (`product_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `seller_order_tracking`
--
ALTER TABLE `seller_order_tracking`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_order_seller` (`order_id`,`seller_id`),
  ADD KEY `idx_sot_order` (`order_id`),
  ADD KEY `idx_sot_seller` (`seller_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `seller_order_tracking`
--
ALTER TABLE `seller_order_tracking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `fk_addresses_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_address` FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_orders_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_items_seller` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`user_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_products_seller` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `fk_images_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sellers`
--
ALTER TABLE `sellers`
  ADD CONSTRAINT `fk_sellers_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seller_order_tracking`
--
ALTER TABLE `seller_order_tracking`
  ADD CONSTRAINT `fk_sot_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sot_seller` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
