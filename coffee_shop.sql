-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 08, 2021 at 12:12 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `description`) VALUES
(1, 'Starbucks', 'Starbucks Corp is a coffee roaster and retailer of specialty coffee with operations in approximately 82 markets around the world. The Company has over 32,000 Company-operated and licensed stores. It operates through three segments: Americas, International, and Channel Development.'),
(2, 'Dunkin\' Donuts', 'Dunkin\' is the world\'s leading baked goods and coffee chain, serving more than 3 million customers each and every day. True to our name, we offer 50+ varieties of donuts, but you can also enjoy dozens of premium beverages, bagels, breakfast sandwiches and other baked goods.'),
(3, 'Caribou Coffee', 'Caribou Coffee provides high quality, handcrafted beverages and food options to fuel life\'s adventures, both big and small. Known for a commitment to sustainability, the Company was the first major U.S. coffeehouse to serve 100% Rainforest Alliance Certified™ coffees and espresso.'),
(4, 'McCafé', 'McCafé is a coffee-house-style food and beverage chain, owned by McDonald\'s. Conceptualized and launched in Melbourne, Australia, in 1993, and introduced to the public with help from McDonald\'s CEO Charlie Bell and then-chairman and future CEO James Skinner, the chain reflects a consumer trend towards espresso coffees.'),
(5, 'Coffee Bean and Tea Leaf', 'Coffee Bean and Tea Leaf is known for its Original Ice Blended coffee and tea drinks, hot coffee drinks, and hot and iced tea drinks. It also sells a variety of whole bean coffees, whole leaf teas, flavored powders, and baked goods.');

-- --------------------------------------------------------

--
-- Table structure for table `coffee`
--

CREATE TABLE `coffee` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` float(5,2) NOT NULL,
  `type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coffee`
--

INSERT INTO `coffee` (`id`, `name`, `brand_id`, `description`, `price`, `type`) VALUES
(1, 'Caffè Americano', 1, 'Espresso shots topped with hot water create a light layer of crema culminating in this wonderfully rich cup with depth and nuance. Pro Tip: For an additional boost, ask your barista to try this with an extra shot.', 4.15, 'hot coffee'),
(2, 'Cappuccino', 5, 'Dark, rich espresso lies in wait under a smoothed and stretched layer of thick milk foam. An alchemy of barista artistry and craft.', 4.50, 'hot coffee'),
(3, 'Caramel Macchiato', 1, 'Freshly steamed milk with vanilla-flavored syrup marked with espresso and topped with a caramel drizzle for an oh-so-sweet finish.', 4.30, 'hot coffee'),
(4, 'White Chocolate Mocha', 2, 'Our signature espresso meets white chocolate sauce and steamed milk, and then is finished off with sweetened whipped cream to create this supreme white chocolate delight.', 4.75, 'hot coffee'),
(5, 'Cinnamon Dolce Latte', 2, 'We add freshly steamed milk and cinnamon dolce-flavored syrup to our classic espresso, topped with sweetened whipped cream and a cinnamon dolce topping to bring you specialness in a treat.', 3.50, 'hot coffee'),
(6, 'Salted Caramel Cold Brew', 2, 'Here\'s a savory-meets-sweet refreshing beverage certain to delight: our signature, super-smooth cold brew, sweetened with a touch of caramel and topped with a salted, rich cold foam.', 3.70, 'iced coffee'),
(7, 'Vanilla Cold Brew', 3, 'Our slow-steeped custom blend of cold brew coffee accented with vanilla and topped with a delicate float of house-made vanilla sweet cream that cascades throughout the cup. It\'s over-the-top and super-smooth.', 4.75, 'iced coffee'),
(8, 'Iced Guava Black Tea', 4, 'Boldly flavored iced tea made with a combination of our guava-flavored fruit juice blend and iced black tea, and hand-shaken with ice. A refreshing lift to any day.\r\n', 4.50, 'iced tea');

-- --------------------------------------------------------

--
-- Table structure for table `snacks`
--

CREATE TABLE `snacks` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` float(5,2) NOT NULL,
  `type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `snacks`
--

INSERT INTO `snacks` (`id`, `name`, `description`, `price`, `type`) VALUES
(1, 'Shortbread Cookies', 'Our two-pack of butter shortbread cookies made with quality ingredients create a melt-in-your-mouth texture in every bite.', 2.15, 'cookie'),
(2, 'Blueberry Scone', 'A traditional scone with blueberries, buttermilk and lemon lovingly handmade to remind you of everything wholesome.', 2.75, 'scone'),
(3, 'Glazed Doughnut', 'A doughnut glazed with delicious, sweet icing—made with old-fashioned scrumptiousness.', 3.25, 'doughnut'),
(4, 'Chocolate Croissant', 'Light, flaky, real butter croissant dough wrapped around two chocolate batons creates a perfect balance that\'ll satisfy your sweet tooth and bring on a moment of bliss.', 3.15, 'pastry'),
(5, 'Cheese Danish', 'Our take on the traditional cheese Danish pairs flaky croissant dough with Neufchâtel cheese—a simple recipe with simple ingredients you’re sure to love.', 2.60, 'pastry'),
(6, 'Madeleines', 'Made with quality ingredients, these rich and buttery French cakes are soft and moist in the center and baked with lightly crisped edges.', 3.15, 'cookie');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `user`, `value`, `created_at`, `updated_at`) VALUES
(8, 1, '2b920683ed485b54fa3a03aa9e9ecaa0fac1a6323b3e41693ff10c8a5cb7568cbe8f81d42c1de4ed17c1a7847ec3ff859ebc8c245cde430566134e9d9ae0b120', '2021-07-26 00:09:44', '2021-08-03 03:14:22');

-- --------------------------------------------------------

--
-- Table structure for table `toppings`
--

CREATE TABLE `toppings` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `price` float(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `toppings`
--

INSERT INTO `toppings` (`id`, `name`, `price`) VALUES
(2, 'Caramel Syrup', 0.75),
(3, '2 Percent Milk', 0.23),
(4, 'Marshmallows', 0.50),
(6, 'Whipped Cream', 0.25),
(9, 'Light Milk Foam', 3.75),
(11, 'Milk Foam', 3.75),
(12, 'Choco Chunks', 3.75),
(13, 'Extra Milk Foam', 1.25),
(14, 'Whole Milk', 0.75),
(15, 'Heavy Cream', 2.25),
(16, 'Almond Milk', 1.00),
(17, 'Coconut Milk', 3.75),
(19, 'Soy Milk', 0.60),
(21, 'Oat Milk', 0.25),
(24, 'Vanilla chips', 3.75),
(25, 'Macadamia Milk', 0.30),
(26, 'Dark Choco Chips', 0.15);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) CHARACTER SET latin1 NOT NULL,
  `email` varchar(30) CHARACTER SET latin1 NOT NULL,
  `username` varchar(20) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `role` smallint(6) DEFAULT 2,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Bert Reynolds', 'abc@email.com', 'username', '$2y$10$5qlCfVpc6u5wx5Om8auyROuiIoruGcvNjLMwnXcyY2KXYDVBTZkwu', 2, '2021-07-25 23:36:52', '2021-07-25 23:36:52'),
(7, 'Andy Griffith', 'email@domain.com', 'admin', '$2y$10$8E2r1GvYas4FiL.nQPv1Z.E9wyJGfbDpjQ6gEu8mW41WyuMlKSPmC', 1, '2021-08-08 03:52:29', '2021-08-08 03:52:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coffee`
--
ALTER TABLE `coffee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `snacks`
--
ALTER TABLE `snacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `toppings`
--
ALTER TABLE `toppings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coffee`
--
ALTER TABLE `coffee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `snacks`
--
ALTER TABLE `snacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `toppings`
--
ALTER TABLE `toppings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coffee`
--
ALTER TABLE `coffee`
  ADD CONSTRAINT `coffee_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
