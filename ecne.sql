-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2024 at 06:50 PM
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
-- Database: `e_pets`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
(1, 'admin1', '$2y$10$K7/eIogCY.OvkYHJBCurx.yGzQ5fE9yU.Ogf8Lw1zDcxOfg0pZ1S.'),
(2, 'admin2', '$2y$10$K7/eIogCY.OvkYHJBCurx.yGzQ5fE9yU.Ogf8Lw1zDcxOfg0pZ1S.'),
(3, 'admin3', '$2y$10$K7/eIogCY.OvkYHJBCurx.yGzQ5fE9yU.Ogf8Lw1zDcxOfg0pZ1S.');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `is_available` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `vet_id`, `title`, `date`, `is_available`) VALUES
(1, 3, 'General control', '2024-08-23 08:00:00', 1),
(2, 3, 'General control', '2024-08-23 08:30:00', 0),
(3, 3, 'General control', '2024-08-23 09:00:00', 1),
(4, 3, 'General control', '2024-08-23 09:30:00', 1),
(5, 3, 'General control', '2024-08-23 10:00:00', 1),
(6, 3, 'General control', '2024-08-23 10:30:00', 1),
(7, 3, 'General control', '2024-08-23 11:00:00', 1),
(8, 3, 'General control', '2024-08-23 11:30:00', 1),
(9, 3, 'General control', '2024-08-23 12:00:00', 1),
(10, 3, 'General control', '2024-08-23 12:30:00', 1),
(11, 3, 'General control', '2024-08-23 13:00:00', 1),
(12, 3, 'General control', '2024-08-23 13:30:00', 1),
(13, 3, 'General control', '2024-08-23 14:00:00', 1),
(14, 3, 'General control', '2024-08-26 08:00:00', 1),
(15, 3, 'General control', '2024-08-26 08:30:00', 1),
(16, 3, 'General control', '2024-08-26 09:00:00', 1),
(17, 3, 'General control', '2024-08-26 09:30:00', 1),
(18, 3, 'General control', '2024-08-26 10:00:00', 1),
(19, 3, 'General control', '2024-08-26 10:30:00', 1),
(20, 3, 'General control', '2024-08-26 11:00:00', 1),
(21, 3, 'General control', '2024-08-26 11:30:00', 1),
(22, 3, 'General control', '2024-08-26 12:00:00', 1),
(23, 3, 'General control', '2024-08-26 12:30:00', 1),
(24, 3, 'General control', '2024-08-26 13:00:00', 1),
(25, 3, 'General control', '2024-08-26 13:30:00', 1),
(26, 3, 'General control', '2024-08-26 14:00:00', 1),
(27, 1, 'General control', '2024-08-23 08:00:00', 0),
(28, 1, 'General control', '2024-08-23 08:30:00', 1),
(29, 1, 'General control', '2024-08-23 09:00:00', 1),
(30, 1, 'General control', '2024-08-23 09:30:00', 1),
(31, 1, 'General control', '2024-08-23 10:00:00', 1),
(32, 1, 'General control', '2024-08-23 10:30:00', 1),
(33, 1, 'General control', '2024-08-23 11:00:00', 0),
(34, 1, 'General control', '2024-08-23 11:30:00', 1),
(35, 1, 'General control', '2024-08-23 12:00:00', 1),
(36, 1, 'General control', '2024-08-23 12:30:00', 1),
(37, 1, 'General control', '2024-08-23 13:00:00', 1),
(38, 1, 'General control', '2024-08-23 13:30:00', 1),
(39, 1, 'General control', '2024-08-23 14:00:00', 1),
(40, 3, 'Control', '2024-08-24 08:00:00', 0),
(41, 3, 'Control', '2024-08-24 08:30:00', 1),
(42, 3, 'Control', '2024-08-24 09:00:00', 1),
(43, 3, 'Control', '2024-08-24 09:30:00', 0),
(44, 3, 'Control', '2024-08-24 10:00:00', 1),
(45, 3, 'Control', '2024-08-24 10:30:00', 1),
(46, 3, 'Control', '2024-08-24 11:00:00', 1),
(47, 3, 'Control', '2024-08-24 11:30:00', 1),
(48, 3, 'Control', '2024-08-24 12:00:00', 1),
(49, 3, 'Control', '2024-08-24 12:30:00', 1),
(50, 3, 'Control', '2024-08-24 13:00:00', 1),
(51, 3, 'Control', '2024-08-24 13:30:00', 1),
(52, 3, 'Control', '2024-08-24 14:00:00', 1),
(53, 2, 'Basic control', '2024-08-29 08:00:00', 1),
(54, 2, 'Basic control', '2024-08-29 08:30:00', 1),
(55, 2, 'Basic control', '2024-08-29 09:00:00', 1),
(56, 2, 'Basic control', '2024-08-29 09:30:00', 1),
(57, 2, 'Basic control', '2024-08-29 10:00:00', 1),
(58, 2, 'Basic control', '2024-08-29 10:30:00', 1),
(59, 2, 'Basic control', '2024-08-29 11:00:00', 1),
(60, 2, 'Basic control', '2024-08-29 11:30:00', 1),
(61, 2, 'Basic control', '2024-08-29 12:00:00', 1),
(62, 2, 'Basic control', '2024-08-29 12:30:00', 1),
(63, 2, 'Basic control', '2024-08-29 13:00:00', 1),
(64, 2, 'Basic control', '2024-08-29 13:30:00', 1),
(65, 2, 'Basic control', '2024-08-29 14:00:00', 1),
(66, 2, 'Control', '2024-09-04 08:00:00', 1),
(67, 2, 'Control', '2024-09-04 08:30:00', 1),
(68, 2, 'Control', '2024-09-04 09:00:00', 1),
(69, 2, 'Control', '2024-09-04 09:30:00', 1),
(70, 2, 'Control', '2024-09-04 10:00:00', 1),
(71, 2, 'Control', '2024-09-04 10:30:00', 1),
(72, 2, 'Control', '2024-09-04 11:00:00', 1),
(73, 2, 'Control', '2024-09-04 11:30:00', 1),
(74, 2, 'Control', '2024-09-04 12:00:00', 1),
(75, 2, 'Control', '2024-09-04 12:30:00', 1),
(76, 2, 'Control', '2024-09-04 13:00:00', 1),
(77, 2, 'Control', '2024-09-04 13:30:00', 1),
(78, 2, 'Control', '2024-09-04 14:00:00', 1),
(79, 3, 'Test', '2024-09-09 08:00:00', 1),
(80, 3, 'Test', '2024-09-09 08:30:00', 1),
(81, 3, 'Test', '2024-09-09 09:00:00', 1),
(82, 3, 'Test', '2024-09-09 09:30:00', 1),
(83, 3, 'Test', '2024-09-09 10:00:00', 1),
(84, 3, 'Test', '2024-09-09 10:30:00', 1),
(85, 3, 'Test', '2024-09-09 11:00:00', 1),
(86, 3, 'Test', '2024-09-09 11:30:00', 1),
(87, 3, 'Test', '2024-09-09 12:00:00', 1),
(88, 3, 'Test', '2024-09-09 12:30:00', 1),
(89, 3, 'Test', '2024-09-09 13:00:00', 1),
(90, 3, 'Test', '2024-09-09 13:30:00', 1),
(91, 3, 'Test', '2024-09-09 14:00:00', 1),
(92, 1, 'Control', '2024-08-26 08:00:00', 0),
(93, 1, 'Control', '2024-08-26 08:30:00', 0),
(94, 1, 'Control', '2024-08-26 09:00:00', 1),
(95, 1, 'Control', '2024-08-26 09:30:00', 1),
(96, 1, 'Control', '2024-08-26 10:00:00', 1),
(97, 1, 'Control', '2024-08-26 10:30:00', 1),
(98, 1, 'Control', '2024-08-26 11:00:00', 1),
(99, 1, 'Control', '2024-08-26 11:30:00', 1),
(100, 1, 'Control', '2024-08-26 12:00:00', 0),
(101, 1, 'Control', '2024-08-26 12:30:00', 1),
(102, 1, 'Control', '2024-08-26 13:00:00', 1),
(103, 1, 'Control', '2024-08-26 13:30:00', 1),
(104, 1, 'Control', '2024-08-26 14:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `breeds`
--

CREATE TABLE `breeds` (
  `breed_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `breeds`
--

INSERT INTO `breeds` (`breed_id`, `name`) VALUES
(1, 'Dog'),
(2, 'Cat'),
(3, 'Cow'),
(4, 'Sheep'),
(5, 'Goat'),
(6, 'Horse'),
(7, 'Pig'),
(8, 'Chicken'),
(9, 'Duck'),
(10, 'Turkey'),
(11, 'Rabbit'),
(12, 'Donkey'),
(13, 'Camel'),
(14, 'Llama'),
(15, 'Alpaca'),
(16, 'Guinea Pig'),
(17, 'Hamster'),
(18, 'Parrot'),
(19, 'Pigeon'),
(20, 'Goldfish'),
(21, 'Koi Fish'),
(22, 'Ferret'),
(23, 'Chinchilla'),
(24, 'Rat'),
(25, 'Mouse'),
(26, 'Goose'),
(27, 'Quail'),
(28, 'Ostrich'),
(29, 'Bee'),
(30, 'Silkworm'),
(31, 'Budgerigar'),
(32, 'Lovebird'),
(33, 'Canary'),
(34, 'Cockatiel'),
(35, 'Mule'),
(36, 'Zebu'),
(37, 'Yak'),
(38, 'Buffalo'),
(39, 'Emu'),
(40, 'Hedgehog'),
(41, 'Tortoise'),
(42, 'Iguana'),
(43, 'Sugar Glider'),
(44, 'Gerbil'),
(45, 'Peacock'),
(46, 'Bantam Chicken'),
(47, 'Peking Duck'),
(48, 'Dwarf Goat'),
(49, 'Zebra Finch'),
(50, 'Pomeranian');

-- --------------------------------------------------------

--
-- Table structure for table `found_pets`
--

CREATE TABLE `found_pets` (
  `found_pet_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `lat` varchar(10) NOT NULL,
  `lon` varchar(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `pet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `breed_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `age` tinyint(4) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `other` varchar(500) DEFAULT NULL,
  `lost` tinyint(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`pet_id`, `user_id`, `name`, `breed_id`, `vet_id`, `age`, `gender`, `other`, `lost`, `updated_at`, `deleted_at`) VALUES
(8, 1, 'Bundás', 1, 6, 11, 'Male', 'okos', 0, '2024-08-21 19:12:28', NULL),
(9, 1, 'Cirmi', 2, 9, 4, 'Male', '', 0, '2024-08-25 16:47:01', NULL),
(10, 1, 'Jack', 18, 2, 2, 'Male', '', 0, '2024-08-23 13:22:35', NULL),
(11, 1, 'Shrek', 12, 3, 15, 'Male', '', 0, NULL, '2024-08-21 19:13:41'),
(12, 1, 'Bell', 2, 1, 3, 'Female', '', 0, '2024-08-21 19:33:20', NULL),
(13, 1, 'Deigo', 17, 3, 6, 'Male', '', 0, '2024-08-22 11:33:23', NULL),
(14, 2, 'Malna', 1, 3, 9, 'Female', '', 0, '2024-08-23 15:11:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reserved_appointments`
--

CREATE TABLE `reserved_appointments` (
  `reserved_appointment_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `is_finished` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reserved_appointments`
--

INSERT INTO `reserved_appointments` (`reserved_appointment_id`, `appointment_id`, `pet_id`, `is_finished`) VALUES
(23, 47, 14, 1),
(40, 41, 13, 1),
(43, 95, 9, 0),
(44, 70, 10, 0),
(48, 21, 14, 0),
(60, 17, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `scanned`
--

CREATE TABLE `scanned` (
  `scanned_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `coordinates` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scanned`
--

INSERT INTO `scanned` (`scanned_id`, `pet_id`, `ip_address`, `coordinates`, `country`, `city`, `date`) VALUES
(1, 8, '::1', ' ', '', '', '0000-00-00 00:00:00'),
(2, 9, '::1', ' ', '', '', '2024-08-22 08:16:11'),
(3, 12, '::1', ' ', '', '', '2024-08-22 08:20:16'),
(4, 12, '::1', ' ', '', '', '2024-08-22 08:25:27'),
(5, 9, '::1', ' ', '', '', '2024-08-22 08:30:41');

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `specialization_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`specialization_id`, `name`) VALUES
(1, 'Small Animal Medicine'),
(2, 'Large Animal Medicine'),
(3, 'Exotic Animal Medicine'),
(4, 'Avian Medicine'),
(5, 'Equine Medicine'),
(6, 'Veterinary Surgery'),
(7, 'Veterinary Dermatology'),
(8, 'Veterinary Oncology'),
(9, 'Veterinary Ophthalmology'),
(10, 'Veterinary Dentistry'),
(11, 'Veterinary Neurology'),
(12, 'Veterinary Anesthesiology'),
(13, 'Veterinary Radiology'),
(14, 'Veterinary Cardiology'),
(15, 'Veterinary Emergency and Critical Care'),
(16, 'Veterinary Internal Medicine'),
(17, 'Veterinary Pathology'),
(18, 'Veterinary Nutrition'),
(19, 'Veterinary Behavior'),
(20, 'Aquatic Animal Medicine');

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `treatment_id` int(11) NOT NULL,
  `reserved_appointment_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `medicine` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatments`
--

INSERT INTO `treatments` (`treatment_id`, `reserved_appointment_id`, `title`, `description`, `medicine`, `date`) VALUES
(1, 23, 'Success control', 'Everything was fine with the pet.', 'no need', '2024-08-25 16:21:38'),
(3, 40, 'Control', 'The pet had fever. Need to take meds for FIVE days.', 'Amoxicillin ', '2024-08-25 16:36:22'),
(4, 60, 'Control', 'Fine', 'no need', '2024-08-25 16:45:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_password` varchar(60) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `is_banned` smallint(1) NOT NULL,
  `active` smallint(1) NOT NULL,
  `registration_token` char(40) DEFAULT NULL,
  `registration_token_expiry` datetime DEFAULT NULL,
  `forgotten_password_token` char(40) DEFAULT NULL,
  `forgotten_password_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `user_password`, `firstname`, `lastname`, `phone`, `is_banned`, `active`, `registration_token`, `registration_token_expiry`, `forgotten_password_token`, `forgotten_password_expires`) VALUES
(1, 'nahezjooooo@gmail.com', '$2y$10$MfkooCpHjMOJCOBQjjf.K.rQ/yAK/2u/5s.h5GFpI9lK8Ik7sMA5O', 'Balazs', 'Nagy', '0647894977', 0, 1, '', NULL, '', NULL),
(2, 'matkovityasd69@gmail.com', '$2y$10$U.8Dk86.x16WItbSWVhcYugbIZ0hA3e2b/xNHP0uZNjmbpytT4B2G', 'Armando', 'Kiss', '0601578799', 0, 1, '', NULL, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_detected_data`
--

CREATE TABLE `users_detected_data` (
  `user_detected_data_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `device_type` enum('computer','phone','tablet') NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `proxy` tinyint(4) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_email_failures`
--

CREATE TABLE `user_email_failures` (
  `id_user_email_failure` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date_time_added` datetime NOT NULL,
  `date_time_tried` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `veterinarians`
--

CREATE TABLE `veterinarians` (
  `vet_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `vet_password` varchar(60) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `biography` varchar(500) DEFAULT NULL,
  `specialization_id` int(11) NOT NULL,
  `vet_office_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `is_banned` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `veterinarians`
--

INSERT INTO `veterinarians` (`vet_id`, `email`, `vet_password`, `firstname`, `lastname`, `phone`, `biography`, `specialization_id`, `vet_office_id`, `added_by`, `is_banned`) VALUES
(1, 'josh@gmail.com', '$2y$10$K7/eIogCY.OvkYHJBCurx.yGzQ5fE9yU.Ogf8Lw1zDcxOfg0pZ1S.', 'Josh', 'Clark', '78777799977', 'With over 15 years of experience, Dr. Clark has developed expertise in diagnosing and treating complex medical conditions in cats and dogs, including gastroenterology, endocrinology, infectious diseases, and nephrology. His commitment to continuous learning and staying updated with the latest advancements in veterinary medicine ensures that his patients receive the best possible care.', 1, 3, 2, 0),
(2, 'zuri@gmail.com', '$2y$10$x2xYvPqkNOl9YykrbDqut.jnDmKL9l4q8wB3l1hAt/IOKv9aNYfv.', 'Darcy', 'Zuri', '78777799665', 'With over a decade of experience, Dr. Zuri has become a leading figure in avian health, focusing on the diagnosis and treatment of a wide range of avian species, from parrots and canaries to raptors and exotic birds. His dedication to advancing avian medicine is evident through his continuous involvement in research and his contributions to veterinary journals and conferences.', 4, 4, 2, 0),
(3, 'smith@gmail.com', '$2y$10$EJWm9CZvuKzyckgwtVUX.OnHxIY3m2hJ8S2995g1atyuKB79QycOC', 'Benjamin', 'Smith', '06077799665', 'With over 12 years of experience, Dr. Smith has become a leading expert in diagnosing and treating dental diseases, oral injuries, and other conditions affecting the mouths of dogs and cats. His areas of expertise include endodontics, periodontics, oral and maxillofacial surgery, and restorative dentistry. Dr. Smith’s commitment to staying at the forefront of veterinary dental care ensures that his patients receive the most advanced treatments available.', 10, 1, 2, 0),
(4, 'brown@gmail.com', '$2y$10$T2jYj1W3EGtU/ghahyZ9Iegl4Ct/3H/Bx3zZPkREQR/u7zIzukC.K', 'Amanda', 'Brown', '44477799665', 'Known for her gentle and compassionate approach, Dr. Brown takes the time to educate pet owners about the importance of dental care and preventive measures. In her free time, she enjoys volunteering at local animal shelters and spending time with her family, including her two rescue dogs, Bella and Max.', 10, 8, 2, 0),
(5, 'kiss@gmail.com', '$2y$10$A1ec6TXy.fC6RMsFUBr6Iea3qpoqF9IEjtsXkglKTMBEgwugIo6LC', 'Erzsébet', 'Kiss', '06277799665', 'With over 15 years of experience, Dr. Kiss has become a leading figure in the field, focusing on the microscopic examination of tissues to diagnose diseases and guide treatment plans. Her areas of expertise include histopathology, cytology, and molecular pathology. Dr. Kiss’s dedication to advancing veterinary pathology is evident through her continuous involvement in research and her contributions to numerous veterinary journals and conferences.', 17, 1, 2, 0),
(6, 'nagy@gmail.com', '$2y$10$KtysrvBpOP3/FHIwz2G3ieZS9M8c9m2xWYpamSvk1QTQ1CkydPfgG', 'Anna', 'Nagy', '06277799999', 'Dr. Anna Nagy is a renowned veterinarian specializing in veterinary dentistry. With a passion for animal health and a keen interest in dental care, Dr. Nagy has dedicated her career to improving the oral health of pets and livestock. She completed her veterinary degree at the University of Veterinary Medicine in Budapest, where she developed a strong foundation in general veterinary medicine.', 10, 1, 2, 0),
(7, 'white@gmail.com', '$2y$10$LtDie7huuDODLgNEtnTtMej4bqCfauUx6nanu407vimO2b68a4eZC', 'Steven', 'White', '65677799999', 'Dr. Steven White is a distinguished veterinarian specializing in veterinary nutrition. With a deep commitment to animal health and well-being, Dr. White has dedicated his career to understanding and improving the dietary needs of pets and livestock. He earned his veterinary degree from the University of California, Davis, where he also completed his advanced training in veterinary nutrition.', 18, 5, 2, 0),
(8, 'miller@gmail.com', '$2y$10$ASc41BPhtE55v3UFAKMy2uRYzZq5uQSm3myJPZro2n3mnV/omYoIu', 'Ashley', 'Miller', '65677799999', 'Dr. Miller’s expertise spans a wide range of nutritional areas, including formulating balanced diets, managing dietary-related health issues, and developing specialized nutrition plans for animals with specific medical conditions. Her approach is rooted in evidence-based practices, ensuring that every animal receives the best possible nutritional care.', 18, 2, 2, 0),
(9, 'novak@gmail.com', '$2y$10$4eVwOik0mGePJsfACCxUF.OKzrPZRQUj.QFJCFnC4CEuYuUBE4nfK', 'Rick', 'Novak', '024555777', 'Dr. Rick Novak is a highly esteemed veterinarian specializing in small animal medicine. With a deep passion for animal care and a commitment to advancing veterinary practices, Dr. Novak has dedicated his career to the health and well-being of pets. He earned his veterinary degree from the University of Pennsylvania, where he also completed his residency in small animal internal medicine.', 1, 1, 2, 0),
(10, 'barr@gmail.com', '$2y$10$dE1eKEQvZJ.AgqWFkCPqrO2FuECF5uVHbKX6r65ZWt6rIs66Kf.Ka', 'Ronald', 'Barr', '024111222', 'Dr. Ronald Barr is a distinguished veterinarian specializing in avian medicine. With a lifelong passion for birds and a commitment to advancing avian health, Dr. Barr has become a leading expert in his field. He earned his veterinary degree from the University of Georgia, where he also completed his advanced training in avian medicine.', 4, 2, 2, 0),
(16, 'andras12@gmail.com', '$2y$10$/AWBCnrdhWjeylwUprU0FOYemkTgWcZKgeirEBQCQKHz.rYQ1sqcq', 'András', 'János', '894498', '', 19, 4, 1, 0),
(17, 'jacint@freemail.com', '$2y$10$3b9SHvXJSO5Lq2H435Vv2unI9bZNDqsSkqskpnKlj86TsBYbZneFa', 'Jácint', 'Kovács', '6045589977', '', 14, 3, 1, 0),
(18, 'test@gmail.com', '$2y$10$MJiUjmTpc5TQj5F6./GdNOWQhHkqyoTRc6UUrGY/a8Wo77PgYvyJO', 'Bernadett', 'Kiss', '06478949', '', 9, 1, 2, 0),
(19, 'idk@gmail.com', '$2y$10$KMsyUE0I4Bs.BX51LUdWV.WrXrTeFp8utxqJ2vHTvKDUBmdQJkxIy', 'Tamas', 'Pesti', '98787', '', 16, 5, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vet_offices`
--

CREATE TABLE `vet_offices` (
  `vet_office_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vet_offices`
--

INSERT INTO `vet_offices` (`vet_office_id`, `name`, `city`, `address`, `phone`) VALUES
(1, 'Pine Grove Veterinary Clinic', 'Subotica', '789 Pine St, Cedarville, TX 75101', '(972) 555-7283'),
(2, 'Lakeside Animal Hospital', 'Belgrade', '245 Harbor Rd, Lakeshore, FL 32801', '(407) 555-1267'),
(3, 'Evergreen Pet Care', 'Budapest', '1500 Summit Ave, Mountainview, CO 80401', '(303) 555-8393'),
(4, 'Riverbend Veterinary Services', 'Novi Sad', '2020 Elm St, Riverton, OH 45011', '(513) 555-9042'),
(5, 'Sunrise Veterinary Center', 'Clearwater', '330 Ocean Blvd, Clearwater, CA 90277', '(310) 555-3429'),
(6, 'Willow Brook Animal Clinic', 'Willowbrook', '980 Maple Dr, Willowbrook, IL 60527', '(630) 555-6417'),
(7, 'Maplewood Veterinary Care', 'Maplewood', '458 Cedar Ave, Maplewood, VT 05601', '(802) 555-1147'),
(8, 'Oak Ridge Animal Hospital', 'Oak Ridge', '741 Forest Ln, Oak Ridge, TN 37830', '(865) 555-2934'),
(9, 'Summit View Pet Clinic', 'Summitville', '612 Mountain Rd, Summitville, AZ 85001', '(602) 555-8194'),
(10, 'Bayside Veterinary Care', 'Bayside', '123 Marina Dr, Bayside, NY 11361', '(718) 555-2783');

-- --------------------------------------------------------

--
-- Table structure for table `vet_popularity`
--

CREATE TABLE `vet_popularity` (
  `vet_popularity_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `patient_count` smallint(6) DEFAULT NULL,
  `treatment_count` smallint(6) DEFAULT NULL,
  `number_of_visits` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vet_popularity`
--

INSERT INTO `vet_popularity` (`vet_popularity_id`, `vet_id`, `patient_count`, `treatment_count`, `number_of_visits`) VALUES
(1, 1, 1, 0, 7),
(2, 2, 1, 0, 20),
(3, 3, 3, 3, 12),
(4, 4, 0, 0, NULL),
(5, 5, 0, 0, NULL),
(6, 6, 1, 0, NULL),
(7, 7, 0, 0, NULL),
(8, 8, 0, 0, 10),
(9, 9, 1, 0, 18),
(10, 10, 0, 0, NULL),
(11, 16, 0, 0, 5),
(12, 17, 0, 0, NULL),
(13, 18, 0, 0, NULL),
(15, 19, 0, 0, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `vet_id` (`vet_id`);

--
-- Indexes for table `breeds`
--
ALTER TABLE `breeds`
  ADD PRIMARY KEY (`breed_id`);

--
-- Indexes for table `found_pets`
--
ALTER TABLE `found_pets`
  ADD PRIMARY KEY (`found_pet_id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `breed_id` (`breed_id`),
  ADD KEY `vet_id` (`vet_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reserved_appointments`
--
ALTER TABLE `reserved_appointments`
  ADD PRIMARY KEY (`reserved_appointment_id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `scanned`
--
ALTER TABLE `scanned`
  ADD PRIMARY KEY (`scanned_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`specialization_id`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`treatment_id`),
  ADD KEY `reserved_appointment_id` (`reserved_appointment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_detected_data`
--
ALTER TABLE `users_detected_data`
  ADD PRIMARY KEY (`user_detected_data_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_email_failures`
--
ALTER TABLE `user_email_failures`
  ADD PRIMARY KEY (`id_user_email_failure`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `veterinarians`
--
ALTER TABLE `veterinarians`
  ADD PRIMARY KEY (`vet_id`),
  ADD KEY `vet_office_id` (`vet_office_id`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `specialization_id` (`specialization_id`);

--
-- Indexes for table `vet_offices`
--
ALTER TABLE `vet_offices`
  ADD PRIMARY KEY (`vet_office_id`);

--
-- Indexes for table `vet_popularity`
--
ALTER TABLE `vet_popularity`
  ADD PRIMARY KEY (`vet_popularity_id`),
  ADD KEY `vet_id` (`vet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `breeds`
--
ALTER TABLE `breeds`
  MODIFY `breed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `found_pets`
--
ALTER TABLE `found_pets`
  MODIFY `found_pet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reserved_appointments`
--
ALTER TABLE `reserved_appointments`
  MODIFY `reserved_appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `scanned`
--
ALTER TABLE `scanned`
  MODIFY `scanned_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `specialization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `treatment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_detected_data`
--
ALTER TABLE `users_detected_data`
  MODIFY `user_detected_data_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_email_failures`
--
ALTER TABLE `user_email_failures`
  MODIFY `id_user_email_failure` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `veterinarians`
--
ALTER TABLE `veterinarians`
  MODIFY `vet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `vet_offices`
--
ALTER TABLE `vet_offices`
  MODIFY `vet_office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vet_popularity`
--
ALTER TABLE `vet_popularity`
  MODIFY `vet_popularity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`vet_id`) REFERENCES `veterinarians` (`vet_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`breed_id`) REFERENCES `breeds` (`breed_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pets_ibfk_2` FOREIGN KEY (`vet_id`) REFERENCES `veterinarians` (`vet_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pets_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reserved_appointments`
--
ALTER TABLE `reserved_appointments`
  ADD CONSTRAINT `reserved_appointments_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reserved_appointments_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `scanned`
--
ALTER TABLE `scanned`
  ADD CONSTRAINT `scanned_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `treatments`
--
ALTER TABLE `treatments`
  ADD CONSTRAINT `treatments_ibfk_1` FOREIGN KEY (`reserved_appointment_id`) REFERENCES `reserved_appointments` (`reserved_appointment_id`);

--
-- Constraints for table `user_email_failures`
--
ALTER TABLE `user_email_failures`
  ADD CONSTRAINT `user_email_failures_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `veterinarians`
--
ALTER TABLE `veterinarians`
  ADD CONSTRAINT `veterinarians_ibfk_2` FOREIGN KEY (`vet_office_id`) REFERENCES `vet_offices` (`vet_office_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `veterinarians_ibfk_3` FOREIGN KEY (`added_by`) REFERENCES `admins` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `veterinarians_ibfk_4` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`specialization_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vet_popularity`
--
ALTER TABLE `vet_popularity`
  ADD CONSTRAINT `vet_popularity_ibfk_1` FOREIGN KEY (`vet_id`) REFERENCES `veterinarians` (`vet_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
