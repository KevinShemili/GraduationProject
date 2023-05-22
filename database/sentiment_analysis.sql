-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2023 at 05:16 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sentiment_analysis`
--

-- --------------------------------------------------------

--
-- Table structure for table `analysis`
--

CREATE TABLE `analysis` (
  `id` int(11) NOT NULL,
  `query` varchar(255) NOT NULL,
  `nrTweets` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `dateCreated` date NOT NULL,
  `algorithm` varchar(255) NOT NULL,
  `negative` int(11) NOT NULL,
  `neutral` int(11) NOT NULL,
  `positive` int(11) NOT NULL,
  `weakPositive` int(11) NOT NULL,
  `weakNegative` int(11) NOT NULL,
  `fileName` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `analysis`
--

INSERT INTO `analysis` (`id`, `query`, `nrTweets`, `description`, `dateCreated`, `algorithm`, `negative`, `neutral`, `positive`, `weakPositive`, `weakNegative`, `fileName`, `user_id`) VALUES
(11, 'Trump', 400, 'Sentiment analysis on ex-President Donald Trump', '2023-04-30', 'vader', 103, 77, 68, 78, 74, '', 22),
(12, 'Biden', 500, 'Sentiment analysis on current president Joseph Biden', '2023-04-30', 'vader', 134, 77, 96, 89, 104, '', 22),
(17, 'Trump', 275, 'trump textblob', '2023-04-30', 'textblob', 4, 226, 12, 20, 13, '', 22),
(18, 'Trump', 275, 'trump bert', '2023-04-30', 'bert', 198, 0, 54, 8, 15, '', 22),
(19, 'Champions League', 115, 'test', '2023-05-01', 'vader', 5, 3, 76, 21, 10, 'c48a6d72-8aa7-429b-9b75-07ce04563b88.csv', 22),
(20, 'Champions League', 70, 'test', '2023-05-01', 'textblob', 1, 45, 10, 12, 2, '15e3fc54-fe00-49b0-b900-6649b45cb4f2.csv', 22),
(21, 'Champions League', 75, 'test', '2023-05-01', 'bert', 25, 0, 40, 5, 5, '8e25b1f8-b277-4cf3-918e-73964be98ff3.csv', 22);

-- --------------------------------------------------------

--
-- Table structure for table `twitter_keys`
--

CREATE TABLE `twitter_keys` (
  `id` int(11) NOT NULL,
  `consumer_key` varchar(255) NOT NULL,
  `consumer_secret` varchar(255) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  `access_token_secret` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `twitter_keys`
--

INSERT INTO `twitter_keys` (`id`, `consumer_key`, `consumer_secret`, `access_token`, `access_token_secret`, `user_id`) VALUES
(1, 'X8NQZbw2kuM0oPetx64JCBufo', 'SyPQfdNVJSTcy6pZiPFKNLMF8XKivWcd9aHcOiNPxOpoQeISBp', '1641109096366571523-1Dmb1dhRIbGZqa1P1XScmK9joqS8x3', 'wdGqoT7FKz9Fl4hpcunj6bPxMNTyZyEuJrA8MVoN0XEHN', 22);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilePhoto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `profilePhoto`) VALUES
(1, 'example', 'example@mail.com', '$2y$10$6BX4X4Vj7.BH3zDUuBOy5eqk52UeSv1E8KSIX4Q6AGFrpfuIBv0Aa', ''),
(2, 'example3', 'example3@mail.com', '$2y$10$cq8dMNDLeFwYAGCaMbwqIuIoeUlE5UqWRKRNcnw9Acp6lMuRsSAu2', ''),
(9, 'kev', 'kevinshemili5@gmail.com', '$2y$10$NyVrUgwwgtBMZIANtLz6ouUwrawObqZ9foj5D5YPVxCcf4dqwpFYW', ''),
(10, 'kev', 'kev@mail.com', '$2y$10$CVg1tI0MwKr1svaJmGTPGODle1aSFjvT0cQ3skGiSaLtpfkpCrvZW', ''),
(11, 'kev', 'kevin@mail.com', '$2y$10$9uXPZUlznUj5KwJF7Mwh7.zPGWlUx9dZcRhLj8h3HmAwl4fWDE03m', ''),
(12, 'kev', 'kv@mail.com', '$2y$10$MePr6qo7zVe/VegSV5CjkuiRHbZOfcqkVMPD8VGMcBJDlYIs6hVje', ''),
(13, 'sssg', 'ae@mail.com', '$2y$10$yq582kLoll7HqEMSxqO8QOvqxR3L8wfiOQY.1so3C95WhtQV/KN7u', ''),
(14, 'sssg', 'ab@mail.com', '$2y$10$tY6fNY/96.6MyI8H6.M3j..rN/1wuHlHbl.kdETr7WLSIpbnnwIMq', ''),
(15, 'eag', 'aegaef@mail.com', '$2y$10$JUJ8.WY7zrmI299MR65dButl/Pq14ZaHGtEwnI3X7aL.7WiIn5b/a', ''),
(16, 'eag', 'aeaegaef@mail.com', '$2y$10$UBEi09FOjGzJ8e4JmCEm7ur5.IhbtN/rAQP3JWXaURjbcB4oHrbdO', ''),
(17, 'agage', 'aebbbga@mail.com', '$2y$10$mmu7VbwzfmB4dL9Q4Db5SuPIbHvJb/YSIxcbyIJjt5RGu8H4hDaxK', ''),
(18, 'qeq', 'qeeq@mail.com', '$2y$10$VwL4hsAwBC/v2woVa89CU.Us6CsdNhg/aHT837oJtdhW/i.MtRZtC', ''),
(19, 'srggrs', 'gsrg@mail.com', '$2y$10$q/h60WZaKks6f8ux.b3m..Kgl6AFyffdyoLjOJJ9rrHlkmv3iB.US', ''),
(20, 'kevin', 'kevkev@mail.com', '$2y$10$VuOQPgr.zfQSnTy2y5tZ3.dTxRDDXDIgQCcY.Nz46pxy4ZvZj5ff2', ''),
(21, 'kev', 'kevkev123@mail.com', '$2y$10$I8qkPxu/o8OhOZpnR7BkievF9webS7Rm00Sf8ZKlvcD7/NBrBNLZW', ''),
(22, 'John', 'username@mail.com', '$2y$10$WWhGEww.BQF5u8ekR7ZYY.LQ0I.m7cSTqj6BfTDq1NSlpHL9W5p3m', '643d885ec9d3d.jpg'),
(23, 'bruno', 'bruno@mail.com', '$2y$10$sVQMImqxBfDT2i3Jfc6IzevkN9G.P7FJg0wogP.LRkuFADvCt9mIS', ''),
(24, 'username2', 'username2@mail.com', '$2y$10$9eSM1jIRNz2lvLDTlQh8Duk4tHf1wUmdgFDwi/Q3DzNUryLaxpgwq', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analysis`
--
ALTER TABLE `analysis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `twitter_keys`
--
ALTER TABLE `twitter_keys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analysis`
--
ALTER TABLE `analysis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `twitter_keys`
--
ALTER TABLE `twitter_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `analysis`
--
ALTER TABLE `analysis`
  ADD CONSTRAINT `analysis_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `twitter_keys`
--
ALTER TABLE `twitter_keys`
  ADD CONSTRAINT `twitter_keys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
