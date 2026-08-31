-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 31, 2026 at 05:32 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `libas_e_khas`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `status`, `created_at`) VALUES
(1, 'Bridal Wear', '1786874112_bridal wear.webp', 1, '2026-08-10 08:43:35'),
(3, 'Party Wear', '1786875443_IMG-20260812-WA0016.webp', 1, '2026-08-10 09:12:32'),
(4, 'Khuda Baksh Collection', '1786873995_khudabaskh.webp', 1, '2026-08-10 09:13:11');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`) VALUES
(3, 'Anfal Khuram', 'anfalkhuram671@gmail.com', '03177853098', 'hi', 'hello', '2026-08-17 06:19:05');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(50) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_size` varchar(50) DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `variation_id` int DEFAULT NULL,
  `product_color` varchar(255) DEFAULT NULL,
  `product_option` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `sale` tinyint(1) DEFAULT '0',
  `salePrice` decimal(10,2) DEFAULT NULL,
  `shortDescription` text COLLATE utf8mb4_general_ci,
  `description` text COLLATE utf8mb4_general_ci,
  `fabric` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `collection` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sub_category_id` int DEFAULT NULL,
  `availability` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'In Stock',
  `tags` text COLLATE utf8mb4_general_ci,
  `sizes` text COLLATE utf8mb4_general_ci,
  `colors` text COLLATE utf8mb4_general_ci,
  `pieces` varchar(100) COLLATE utf8mb4_general_ci DEFAULT '1 Piece',
  `main_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hover_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `price`, `stock`, `sale`, `salePrice`, `shortDescription`, `description`, `fabric`, `collection`, `sub_category_id`, `availability`, `tags`, `sizes`, `colors`, `pieces`, `main_image`, `hover_image`, `created_at`, `status`) VALUES
(1, 'Mint Elegance Embroidered Lawn Suit', 1, '14000.00', 5, 1, '12000.00', 'A graceful mint green embroidered suit featuring intricate silver embellishments, delicate floral motifs, and a beautifully detailed neckline, borders, and dupatta.', 'Elevate your festive wardrobe with this stunning mint green embroidered ensemble, designed for an elegant and timeless look. The shirt features intricate silver-toned embroidery with delicate floral and traditional motifs, complemented by subtle hints of blush detailing. The heavily embellished neckline, sleeves, front panel, and hem create a luxurious statement while maintaining the soft, graceful appeal of the mint fabric.\r\n\r\nThe matching dupatta is adorned with scattered embellishments and a richly detailed silver border, adding movement and sophistication to the overall ensemble. Its refreshing color and ornate craftsmanship make it an ideal choice for festive gatherings, formal occasions, Eid celebrations, weddings, and evening events.', 'Premium Embroidered Fabric', 'Intricate Floral and Traditional Motifs', 1, 'Out of Stock', 'mint green suit, embroidered suit, Pakistani dress, Pakistani fashion, luxury formal wear, festive collection, Eid dress, wedding wear, embroidered lawn, mint green outfit, silver embroidery, embellished suit, designer Pakistani dress, formal Pakistani wear, ladies suit, traditional wear, festive outfit, ethnic fashion, embroidered dupatta, luxury pret', 'S, M, L', 'Red, Blue', '3', 'assets/images/products/prod_6a81923778d96.webp', 'assets/images/products/prod_6a8192377a970.webp', '2026-08-16 10:34:31', 1),
(2, 'Mint Elegance Embroidered Lawn Suit', 1, '12000.00', 2, 0, NULL, 'A graceful mint green embroidered suit featuring intricate silver embellishments, delicate floral motifs, and a beautifully detailed neckline, borders, and dupatta.', 'Elevate your festive wardrobe with this stunning mint green embroidered ensemble, designed for an elegant and timeless look. The shirt features intricate silver-toned embroidery with delicate floral and traditional motifs, complemented by subtle hints of blush detailing. The heavily embellished neckline, sleeves, front panel, and hem create a luxurious statement while maintaining the soft, graceful appeal of the mint fabric.\r\n\r\nThe matching dupatta is adorned with scattered embellishments and a richly detailed silver border, adding movement and sophistication to the overall ensemble. Its refreshing color and ornate craftsmanship make it an ideal choice for festive gatherings, formal occasions, Eid celebrations, weddings, and evening events.', 'Premium Embroidered Fabric', 'Premium Embroidered Fabric', 2, 'In Stock', 'mint green suit, embroidered suit, Pakistani dress, Pakistani fashion, luxury formal wear, festive collection, Eid dress, wedding wear, embroidered lawn, mint green outfit, silver embroidery, embellished suit, designer Pakistani dress, formal Pakistani wear, ladies suit, traditional wear, festive outfit, ethnic fashion, embroidered dupatta, luxury pret', 'S, M, L, Custom', 'Blue', '2', 'assets/images/products/prod_6a819f23e9289.webp', 'assets/images/products/prod_6a819f23e9ba7.webp', '2026-08-16 11:29:39', 1),
(3, 'LS-2', 1, '12000.00', 10, 0, NULL, 'abcs', 'abcdd', 'abcd', 'abcd', 2, 'In Stock', 'mint green suit, embroidered suit, Pakistani dress, Pakistani fashion, luxury formal wear, festive collection, Eid dress, wedding wear, embroidered lawn, mint green outfit, silver embroidery, embellished suit, designer Pakistani dress, formal Pakistani wear, ladies suit, traditional wear, festive outfit, ethnic fashion, embroidered dupatta, luxury pret', 'S, M, L', 'Red, Blue, As pictured', '3', 'assets/images/products/1788149813_Botanical_skincare_product_adver____2K_202608231317.webp', 'assets/images/products/1788149815_post_0007.webp', '2026-08-31 04:16:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_colors`
--

CREATE TABLE `product_colors` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `color_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `color_code` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_colors`
--

INSERT INTO `product_colors` (`id`, `product_id`, `color_name`, `color_code`, `image`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Red', NULL, 'assets/images/products/1788149815_post_0007.webp', 1, 1, '2026-08-31 04:16:56', '2026-08-31 04:16:56'),
(2, 3, 'Blue', NULL, 'assets/images/products/1788151925_change_th_ebackground_to_clouds_202608231658.webp', 2, 1, '2026-08-31 04:52:06', '2026-08-31 04:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `created_at`) VALUES
(1, 1, 'assets/images/products/gal_6a8192377bbac.webp', '2026-08-16 10:34:31'),
(2, 1, 'assets/images/products/gal_6a8192377d5e2.webp', '2026-08-16 10:34:31'),
(3, 1, 'assets/images/products/gal_6a8192377e367.webp', '2026-08-16 10:34:31'),
(4, 1, 'assets/images/products/gal_6a8192377ef82.webp', '2026-08-16 10:34:31'),
(5, 2, 'assets/images/products/gal_6a819f23ec8de.webp', '2026-08-16 11:29:39'),
(6, 2, 'assets/images/products/gal_6a819f23edb93.webp', '2026-08-16 11:29:39'),
(7, 2, 'assets/images/products/gal_6a819f23eecda.webp', '2026-08-16 11:29:39'),
(8, 2, 'assets/images/products/gal_6a819f23efbc6.webp', '2026-08-16 11:29:39'),
(9, 2, 'assets/images/products/gal_6a819f23f0f4f.webp', '2026-08-16 11:29:39'),
(10, 3, 'assets/images/products/1788149815_PULL_BEAR_STWD_EMBROIDERED_LOGO_-_Sweat____capuche_-_mauve_0.webp', '2026-08-31 04:16:55'),
(11, 3, 'assets/images/products/1788149815_PULL_BEAR_STWD_EMBROIDERED_LOGO_-_Sweat____capuche_-_mauve_1.webp', '2026-08-31 04:16:55'),
(12, 3, 'assets/images/products/1788149815_Front_and_back_views_of_a_purple_men_tshrit_apparel_mockup_isolated_on_white_background___Premium_AI-generated_image_2.webp', '2026-08-31 04:16:55');

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE `product_options` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `option_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sort_order` int DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_options`
--

INSERT INTO `product_options` (`id`, `product_id`, `option_name`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Shirt', 1, 1, '2026-08-31 04:16:56', '2026-08-31 04:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `color_id` int DEFAULT NULL,
  `option_id` int DEFAULT NULL,
  `size_id` int DEFAULT NULL,
  `sku` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `product_id`, `color_id`, `option_id`, `size_id`, `sku`, `price`, `original_price`, `stock_quantity`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 1, '', '11000.00', '11000.00', 1, NULL, 1, '2026-08-31 04:16:56', '2026-08-31 05:00:06'),
(2, 3, 1, 1, 2, '', '12000.00', '12000.00', 1, NULL, 1, '2026-08-31 04:16:56', '2026-08-31 04:16:56'),
(3, 3, 2, 1, 1, '', '8000.00', '8000.00', 0, NULL, 1, '2026-08-31 04:52:06', '2026-08-31 05:00:06'),
(4, 3, 2, 1, 2, '', '7000.00', '7000.00', 0, NULL, 1, '2026-08-31 04:52:06', '2026-08-31 05:00:06');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int NOT NULL,
  `review_text` text NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `name`, `email`, `rating`, `review_text`, `status`, `created_at`) VALUES
(2, 1, 'anfal', 'anfalkhuram671@gmail.com', 5, 'good stuff', 1, '2026-08-17 06:19:45');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `sort_order` int DEFAULT '0',
  `status` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `sort_order`, `status`) VALUES
(1, 'Small', 1, 1),
(2, 'Medium', 2, 1),
(3, 'Large', 3, 1),
(4, 'X-Large', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `name`, `status`, `created_at`) VALUES
(1, 1, 'Walima Maxies', 1, '2026-08-10 09:02:30'),
(2, 1, 'Lehnga', 1, '2026-08-10 09:11:46'),
(3, 1, 'Adda / Dabka', 1, '2026-08-10 09:12:10'),
(4, 3, 'Fancy Shararas', 1, '2026-08-10 09:13:41'),
(5, 3, 'Ghararas', 1, '2026-08-10 09:14:26'),
(6, 3, 'Silk Shirts', 1, '2026-08-10 09:14:44'),
(7, 3, 'Lawn Suits', 1, '2026-08-10 09:15:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'admin@libas.com', '$2y$10$I2mTM4TP3bB.ovQ3RC89feIpOjIrU5gTJwKpapWKbDcqyXv9V0Wq6', '2026-08-16 12:48:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_status_created` (`status`,`created_at`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`),
  ADD KEY `fk_sub_category` (`sub_category_id`),
  ADD KEY `idx_availability` (`availability`);

--
-- Indexes for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `option_id` (`option_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_category_id` (`category_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_options`
--
ALTER TABLE `product_options`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_sub_category` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD CONSTRAINT `product_colors_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_options`
--
ALTER TABLE `product_options`
  ADD CONSTRAINT `product_options_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variations_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `product_colors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_variations_ibfk_3` FOREIGN KEY (`option_id`) REFERENCES `product_options` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_variations_ibfk_4` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
