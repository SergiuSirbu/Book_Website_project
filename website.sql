-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: May 08, 2024 at 01:05 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website`
--

/*The steps described below will allow for installation of this database on a local machine:
1. Ensure that MySQL is installed on the machine. It can be downloaded on their official website.
2. Open MySQL Command Line Client from the Start menu.
3. Create a new database.
4. Select the database.
5. Import the .sql file */

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `summary` text,
  `uploader_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `genre`, `published_date`, `summary`, `uploader_id`) VALUES
(1, 'To Kill a Mockingbird', 'Harper Lee', 'Novel', '1960-07-11', 'The story of a young girl and her father fighting racial injustice in a small Southern town.', NULL),
(2, '1984', 'George Orwell', 'Dystopian', '1949-06-08', 'A dystopian novel about the dangers of totalitarianism.', NULL),
(3, 'Pride and Prejudice', 'Jane Austen', 'Romance', '1813-01-28', 'A romantic novel about manners, upbringing, morality, education, and marriage in early 19th century England.', NULL),
(4, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Novel', '1925-04-10', 'A story of the jazz age and the pursuit of the American Dream.', NULL),
(5, 'The Hobbit', 'J.R.R. Tolkien', 'Fantasy', '1937-09-21', 'The adventure of Bilbo Baggins as he attempts to help a group of dwarves regain their wealth and dignity.', NULL),
(6, 'Title_try', 'Author_try', 'Whatever', '2000-01-01', 'This is just to check if it works!!!!', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int NOT NULL,
  `book_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`user_id`, `book_id`) VALUES
(4, 1),
(4, 4),
(4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `book_id` int NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `rating` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `book_id`, `user_name`, `comment`, `rating`, `created_at`) VALUES
(1, 1, 'jnijhi', 'huihihuih', 5, '2024-04-14 06:44:48'),
(2, 1, 'jnijhi', 'huihihuih', 5, '2024-04-14 06:44:52'),
(3, 1, '1234ty', ';lws,dfl,sdl;f,s', 5, '2024-05-06 15:30:36'),
(4, 6, '1234ty', 'let\'s see if everything works', 2, '2024-05-06 16:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'pop', '$2y$10$U/9f7psQqHsBlQCNhd8unOSKHnFErConPwgbJzmtFXSDKHKTN01dS'),
(2, 'pop259', '$2y$10$k0tMFPIRjTpjQbycOsjgJ.oGP2vGm9mXw4fdsISJyS7ydD40U.VtS'),
(3, 'bob', '$2y$10$GPgAnwB63RS.y8IYDlTh6urJUGEdYh1/94vzomXhViCkSpbKLJQrO'),
(4, '1234ty', '$2y$10$1BZXUry6J2TJVsdBgFnSDeniNqtXZH58JSyGSQs3brxBj92YYpMgi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
