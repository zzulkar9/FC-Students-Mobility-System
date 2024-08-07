-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 06, 2024 at 03:56 AM
-- Server version: 8.0.37-0ubuntu0.24.04.1
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobility_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `advisor_and_approval_details`
--

CREATE TABLE `advisor_and_approval_details` (
  `id` bigint UNSIGNED NOT NULL,
  `application_form_id` bigint UNSIGNED NOT NULL,
  `advisor_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `advisor_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `advisor_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `advisor_remarks` text COLLATE utf8mb4_unicode_ci,
  `approval` enum('approved','disapproved','pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `faculty_remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advisor_and_approval_details`
--

INSERT INTO `advisor_and_approval_details` (`id`, `application_form_id`, `advisor_name`, `advisor_email`, `advisor_phone`, `advisor_remarks`, `approval`, `faculty_remarks`, `created_at`, `updated_at`) VALUES
(50, 128, 'Dr Razib', 'drrazib@gmail.com', '0136784929', 'Not Approved', 'pending', NULL, '2024-07-03 06:22:30', '2024-07-06 02:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_details`
--

CREATE TABLE `applicant_details` (
  `id` bigint UNSIGNED NOT NULL,
  `application_form_id` bigint UNSIGNED NOT NULL,
  `program_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upcoming_semester` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `citizenship` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ic_passport_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `race` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_address` text COLLATE utf8mb4_unicode_ci,
  `next_of_kin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parents_occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parents_monthly_income` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicant_details`
--

INSERT INTO `applicant_details` (`id`, `application_form_id`, `program_type`, `upcoming_semester`, `religion`, `citizenship`, `ic_passport_number`, `contact_number`, `race`, `home_address`, `next_of_kin`, `emergency_contact`, `parents_occupation`, `parents_monthly_income`, `created_at`, `updated_at`) VALUES
(62, 128, 'study_abroad', '3', 'Islam', 'Malaysia', '001018-10-0339', '0136784929', 'Melayu', 'Hulu Langat, Selangor', 'Zul', '0136784929', 'Retire', '00', '2024-07-03 06:22:30', '2024-07-03 06:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `application_forms`
--

CREATE TABLE `application_forms` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `intake_period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_draft` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_forms`
--

INSERT INTO `application_forms` (`id`, `user_id`, `intake_period`, `is_draft`, `created_at`, `updated_at`, `link`, `approval_status`) VALUES
(128, 19, 'March/April', 0, '2024-07-03 06:19:40', '2024-07-03 06:35:56', 'https://www.handbook.uts.edu.au/how_to_use.html', 1);

-- --------------------------------------------------------

--
-- Table structure for table `application_form_subjects`
--

CREATE TABLE `application_form_subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `application_form_id` bigint UNSIGNED NOT NULL,
  `utm_course_id` bigint UNSIGNED NOT NULL,
  `utm_course_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `utm_course_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `utm_course_credit` decimal(5,2) DEFAULT NULL,
  `utm_course_description` text COLLATE utf8mb4_unicode_ci,
  `target_course` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_course_credit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_course_description` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_form_subjects`
--

INSERT INTO `application_form_subjects` (`id`, `application_form_id`, `utm_course_id`, `utm_course_code`, `utm_course_name`, `utm_course_credit`, `utm_course_description`, `target_course`, `target_course_credit`, `target_course_description`, `notes`, `created_at`, `updated_at`) VALUES
(207, 128, 193, 'SCSR2213', 'Network Communications', 3.00, 'This course will discuss the basic topics of computer network and data communications. Based on TCP/IP Internet protocol stack, the course will apply top down approach. Starts with the important and usage of computer network in commonly applications, the approach will go further detail in the technical aspect in data communication. At the end of this course, students will have an understanding and appreciation of how the network works.', 'Machine Learning (31005)', '7.5', 'Machine learning is an exciting field studying of how intelligent agents can learn from and adapt to experience and how to realise such capacity on digital computers. It is applied in many fields of business, industry and science to discover new information and knowledge. At the heart of machine learning are the knowledge discovery algorithms. This subject builds on previous data analytics subjects to give an understanding of how both basic and more powerful algorithms work. It consists of both hands-on practice and fundamental theories. Students learn important techniques in the field by implementation and theoretical analysis. The subject also introduces practical applications of machine learning, especially in the field of artificial intelligence.', 'not Good', '2024-07-03 06:22:30', '2024-07-06 02:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('0716d9708d321ffb6a00818614779e779925365c', 'i:1;', 1719986571),
('0716d9708d321ffb6a00818614779e779925365c:timer', 'i:1719986571;', 1719986571),
('1574bddb75c78a6fd2251d61e2993b5146201319', 'i:1;', 1719986291),
('1574bddb75c78a6fd2251d61e2993b5146201319:timer', 'i:1719986291;', 1719986291),
('17ba0791499db908433b80f37c5fbc89b870084b', 'i:1;', 1719737301),
('17ba0791499db908433b80f37c5fbc89b870084b:timer', 'i:1719737301;', 1719737301),
('7b52009b64fd0a2a49e6d8a939753077792b0554', 'i:1;', 1719979201),
('7b52009b64fd0a2a49e6d8a939753077792b0554:timer', 'i:1719979201;', 1719979201),
('9e6a55b6b4563e652a23be9d623ca5055c356940', 'i:1;', 1719986834),
('9e6a55b6b4563e652a23be9d623ca5055c356940:timer', 'i:1719986834;', 1719986834),
('b1d5781111d84f7b3fe45a0852e59758cd7a87e5', 'i:1;', 1719735452),
('b1d5781111d84f7b3fe45a0852e59758cd7a87e5:timer', 'i:1719735452;', 1719735452),
('b3f0c7f6bb763af1be91d9e74eabfeb199dc1f1f', 'i:1;', 1719987610),
('b3f0c7f6bb763af1be91d9e74eabfeb199dc1f1f:timer', 'i:1719987610;', 1719987610),
('bd307a3ec329e10a2cff8fb87480823da114f8f4', 'i:1;', 1719979554),
('bd307a3ec329e10a2cff8fb87480823da114f8f4:timer', 'i:1719979554;', 1719979554),
('fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b', 'i:1;', 1719979757),
('fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b:timer', 'i:1719979757;', 1719979757);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `application_form_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `application_form_id`, `user_id`, `comment`, `created_at`, `updated_at`) VALUES
(8, 128, 1, 'Please Finish it by today', '2024-07-03 06:27:43', '2024-07-03 06:27:43');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint UNSIGNED NOT NULL,
  `course_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_semester` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_credit` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `intake_year` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intake_semester` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prerequisites` text COLLATE utf8mb4_unicode_ci,
  `day_and_timeslot` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `year_semester`, `course_credit`, `description`, `intake_year`, `intake_semester`, `prerequisites`, `day_and_timeslot`, `created_at`, `updated_at`) VALUES
(183, 'SCSE1013', 'Fundamental Programming Concept', 'Year 1: Semester 1', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 05:37:52', '2024-06-30 05:37:52'),
(184, 'SCST1123', 'Mathematics for Software Engineer', 'Year 1: Semester 1', 3, 'This course introduces students to the mathematical, computing and linguistic metaphors of software engineering. The mathematical topics that are covered in this course are set theory, proof techniques, relations, functions, recurrence relations, counting methods, graph theory, trees. This course also discusses on how formal language and computing theories may improve the understanding of programming languages and their work products – software. This part will emphasize on languages, grammars and abstract machines i.e. regular language, context free language, regular grammar, context free grammar, finite automata, push down automata, and turing machine. At the end of the course, the students should be able to use set theory, relations and functions to solve computer science problems, analyze and solve problems using recurrence relations and counting methods, apply graph theory and trees in real world problems and use abstract machines to model electronic devices and problems.', '2023', 'March/April', NULL, NULL, '2024-06-30 05:37:52', '2024-06-30 08:12:13'),
(185, 'SCSR1013', 'Digital Logic', 'Year 1: Semester 1', 3, 'Digital electronics is the foundation of all microprocessor-based systems found in computers, robots, automobiles, and industrial control systems. This course introduces the students to digital electronics and provides a broad overview of many important concepts, components, and tools. Students will get up-to-date coverage of digital fundamentals-from basic concepts to programmable logic devices. Laboratory experiments provide hands-on experience with the simulator software, actual devices and circuits studied in the classroom.', '2023', 'March/April', NULL, NULL, '2024-06-30 05:37:52', '2024-06-30 08:11:23'),
(186, 'SCST1143', 'Database Engineering', 'Year 1: Semester 1', 3, 'This course introduces students to the concept of database system and how it is used in daily human life and profession. The focus of the course is to equip students with the knowledge and skills on important steps and techniques used in developing a database, especially in the conceptual and logical database design phase. Among topics covered are database environment, database design, entity relationship diagram, normalization, and structured query language (SQL). Students will be taught to use a database management system (DBMS). Students are required to design and develop the database component of an information system using the learned techniques, DBMS and a development tool. At the end of the course, students should be able to apply the knowledge of designing and developing a good database system', '2023', 'March/April', NULL, NULL, '2024-06-30 05:37:52', '2024-06-30 08:12:36'),
(187, 'ULRS1012', 'Value and Identity', 'Year 1: Semester 1', 2, NULL, '2023', 'March/April', '', NULL, '2024-06-30 05:37:52', '2024-06-30 05:37:52'),
(188, 'Sxxxxxx3', 'Free Elective I*', 'Year 1: Semester 1', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 05:37:52', '2024-06-30 05:37:52'),
(189, 'SCSE1203', 'Software Engineering Principles', 'Year 1: Semester 2', 3, 'This course is designed to give students an introduction to an engineering approach in the development of high-quality software systems. It will discuss the important software engineering concepts in the various types of the common software process models. The students will also learn the concepts and techniques used in each software development phase including requirements engineering, software design and software testing. This course will also expose the students to utilizing object-oriented method (e.g. UML) and tools in analyzing and designing the software. In terms of generic skills, this course will also focus on critical thinking and communication skills of the students.', '2023', 'March/April', 'SCSE1013', NULL, '2024-06-30 06:01:14', '2024-06-30 08:13:24'),
(190, 'SCSR1033', 'Computer Organisation and Architecture', 'Year 1: Semester 2', 3, 'This course was designed to give the understanding of basic concept of computer organization and architecture. Topics covered in this subject will be on computer performance, types of data and the representative, arithmetic manipulation, instruction execution, micro programmable control memory, pipelining, memory, input/output and instruction format. At the end of this course, the student should be able to understand the concept of overall computer component and realize the current technology in computer hardware.', '2023', 'March/April', 'SCSR1013', NULL, '2024-06-30 06:01:14', '2024-06-30 08:16:14'),
(191, 'SCST1223', 'Probability and Statistical Data Analysis', 'Year 1: Semester 2', 3, 'This course is designed to introduce some statistical techniques as tools to analyse the data. In the beginning the students will be exposed with various forms of data. The data represented by the different types of variables are derived from different sources; daily and industrial activities. The analysis begins with the data representation visually. The course will also explore some methods of parameter estimation from different distributions. Further data analysis is conducted by introducing the hypothesis testing. Some models are employed to fit groups of data. At the end of course the students should be able to apply some statistical models in analysing data using available software.', '2023', 'March/April', NULL, NULL, '2024-06-30 06:01:14', '2024-06-30 08:17:13'),
(192, 'SCSE1224', 'Advanced Programming', 'Year 1: Semester 2', 4, 'This course presents the advanced programming techniques and features. The course will cover concepts in Object-Oriented Programming and introduce functional programming paradigm. Basic understanding on control structures, objects and classes are required to enrol in this course. The course will also cover some advanced programming techniques including asynchronous programming. The course will equip the students with the theory and practice on problem solving using such techniques. The course will also provide the students with written and oral communication skills. At the end of this course, students should be able to use appropriate programming techniques and tools to develop programs to solve problem', '2023', 'March/April', 'SCSE1013', NULL, '2024-06-30 06:01:14', '2024-06-30 08:17:55'),
(193, 'SCSR2213', 'Network Communications', 'Year 1: Semester 2', 3, 'This course will discuss the basic topics of computer network and data communications. Based on TCP/IP Internet protocol stack, the course will apply top down approach. Starts with the important and usage of computer network in commonly applications, the approach will go further detail in the technical aspect in data communication. At the end of this course, students will have an understanding and appreciation of how the network works.', '2023', 'March/April', NULL, NULL, '2024-06-30 06:01:14', '2024-06-30 08:19:45'),
(194, 'Uxxxxxx2', 'University Elective II', 'Year 1: Semester 2', 2, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:01:14', '2024-06-30 06:01:14'),
(195, 'SCSE2133', 'Software Process and Project Management', 'Year 2: Semester 1', 3, 'This course is designed to provide students within depth knowledge on software project planning, cost estimation and scheduling, project management tools, factors influencing productivity and success, productivity metrics, analysis of options and risks, software process improvement, software contracts and intellectual property and approaches to maintenance and long term software development. This course will incorporate a work-based learning approach where students will have some sessions with the industrial partners. At the end of this course, students should be able to know how to manage a software development lifecycle.', '2023', 'March/April', 'SCSE1203', NULL, '2024-06-30 06:01:46', '2024-06-30 08:22:43'),
(196, 'SCSE2123', 'Software Requirements Engineering', 'Year 2: Semester 1', 3, 'This course provides an introduction to requirement engineering and a thorough look at the software modeling. It will include requirements engineering topics include types of requirements, requirements elicitation techniques, requirements specification: text-based and model-based, requirements validation and negotiation, as well as requirements management. At the end of this course, the students shall have the skills necessary to conduct requirements engineering process with appropriate principles and methods.', '2023', 'March/April', 'SCSE1203', NULL, '2024-06-30 06:01:46', '2024-06-30 08:21:58'),
(197, 'SCSE2103', 'Data Structure and Algorithm', 'Year 2: Semester 1', 3, 'This course emphasis on data structure concepts theoretically and practically with detail algorithms for each of data structure. Students will learn abstract data type concepts using class and apply the concept in the implementation of data structures. Apart from it, student will learn recursive concept as a programming style and algorithm efficiency analysis with Big O notation. Various sorting and searching techniques will be discussed as data structure operations. Analysis of each algorithm will also be explained. Further, students will be exposed to linear data structures such as linked lists, stack and queue. Non-linear data structures such as tree and binary search tree will be discussed. Along the course, students should be able to implement and apply the theory and concepts of data structure in the assignments and mini project which are conducted in group.', '2023', 'March/April', 'SCSE1013', NULL, '2024-06-30 06:01:46', '2024-06-30 08:21:09'),
(198, 'SCSR2043', 'Operating System', 'Year 2: Semester 1', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:01:46', '2024-06-30 06:01:46'),
(199, 'SCSM2113', 'Human Computer Interaction', 'Year 2: Semester 1', 3, 'This course will introduce students to human-computer interaction theories and design processes. The emphasis will be on applied user experience (UX) design. The course will present an iterative evaluation-centered UX lifecycle and will introduce a broader notion of user experience, including usability, usefulness, and emotional impact. The lifecycle should be viewed as template intended to be instantiated in many different ways to match the constraints of a particular development project. The UX lifecycle activities we will cover include contextual inquiry and analysis, requirements extraction, design-informing models, design thinking, ideation, sketching, conceptual design, and formative evaluation.', '2023', 'March/April', 'SCSE1203', NULL, '2024-06-30 06:01:46', '2024-06-30 08:21:33'),
(200, 'UKQF2xx2', 'Service Learning and Community Engagement', 'Year 2: Semester 1', 2, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:01:46', '2024-06-30 06:01:46'),
(201, 'SCSM2213', 'Cross-Platform Application Development', 'Year 2: Semester 2', 3, 'This course will provide students with a foundation on the development of modern applications. It will cover the workflows, tools and frameworks required to develop applications for current and emerging computing devices including mobile, web and desktop platforms. The course will adopt current technologies as a basis for teaching the process of the application development. This course will also expose the students to composing user interfaces, integrating with backends and the application architecture. This course will incorporate a work-based learning approach where students will have some sessions with the industrial partners. At the end of course, the students will be equipped with the competency of the appropriate skills for the development of modern applications as well as personal and entrepreneurial skills.', '2023', 'March/April', 'SCST1143', NULL, '2024-06-30 06:04:09', '2024-06-30 08:23:30'),
(202, 'SCSE2233', 'Software Design & Architecture', 'Year 2: Semester 2', 3, 'This course provides the students with an in-depth look at the theory and practice of software architecture and design. It introduces the important concepts related to software architecture and design. It emphasizes on the design and (faithful) implementation of a large scale software using the widely accepted architecture styles and design patterns. It will also expose students to the use of the industrial strength design notations (e.g. UML) and CASE tools (e.g. Ent Arch, Visual Studio). In addition, it provides other aspects of a large and complex software design such as user interface design, management, leadership, and ethics. At the end of this course, the students should be able to use the techniques, architectural styles, and design patterns in software design.', '2023', 'March/April', 'SCSE1203', NULL, '2024-06-30 06:04:09', '2024-06-30 08:24:08'),
(203, 'SCSE2243', 'Application Development Project I', 'Year 2: Semester 2', 3, NULL, '2023', 'March/April', 'SCSE1203,SCSE2123', NULL, '2024-06-30 06:04:09', '2024-06-30 06:04:09'),
(204, 'UHLB2122', 'Professional Communication Skills I', 'Year 2: Semester 2', 2, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:04:09', '2024-06-30 06:04:09'),
(205, 'UHIS1022', 'Philosophy and Current Issues', 'Year 2: Semester 2', 2, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:05:16', '2024-06-30 06:05:16'),
(206, 'Sxxxxxx3', 'Free Elective II*', 'Year 2: Semester 2', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:06:45', '2024-06-30 06:06:45'),
(207, 'UHLB3132', 'Professional Communication Skills 2', 'Year 3: Semester 1', 2, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:08:23', '2024-06-30 06:08:23'),
(208, 'UHLx1122', 'Foreign Language Elective', 'Year 3: Semester 1', 2, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:08:23', '2024-06-30 06:08:23'),
(209, 'Sxxxxxx3', 'Free Elective III*', 'Year 3: Semester 1', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:08:23', '2024-06-30 06:08:23'),
(210, 'SCST3223', 'Data Analytic Programming', 'Year 3: Semester 1', 3, NULL, '2023', 'March/April', 'SECJ2013', NULL, '2024-06-30 06:08:23', '2024-06-30 06:08:23'),
(211, 'SCSE3143', 'Ubiquitous Computing', 'Year 3: Semester 1', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:08:23', '2024-06-30 06:08:23'),
(212, 'SCSR3113', 'Cloud Computing', 'Year 3: Semester 1', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:08:23', '2024-06-30 06:08:23'),
(213, 'SCSE3103', 'Cognitive Computing', 'Year 3: Semester 1', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:08:23', '2024-06-30 06:08:23'),
(214, 'SCSE3203', 'Special Topics', 'Year 3: Semester 1', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:08:23', '2024-06-30 06:08:23'),
(215, 'SCSM3113', 'Virtual and Augmented Reality Application', 'Year 3: Semester 1', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:08:23', '2024-06-30 06:08:23'),
(216, 'SCSE3242', 'Software Engineering Project I', 'Year 3: Semester 2', 2, NULL, '2023', 'March/April', 'SCSE2243,80 credits,', NULL, '2024-06-30 06:10:52', '2024-06-30 06:10:52'),
(217, 'SCSR3133', 'Secure Software Programming', 'Year 3: Semester 2', 3, 'This course aims to prepare students with knowledge to develop secure application. This is done by exposing common programming errors, ways to locate, and fix them. Besides that, students will learn how to properly use libraries for applying cryptographic functions. At the end of this course student should be able to design and develop secure application based on current security technologies.', '2023', 'March/April', 'SCSM2213', NULL, '2024-06-30 06:10:52', '2024-06-30 08:25:35'),
(218, 'SCSE3213', 'Software Quality & Testing', 'Year 3: Semester 2', 3, 'The content of the course discusses the Software Quality issues much beyond the classic boundaries of custom-made software development by large established software houses. It dedicates significant attention to the other software development and maintenance environment that reflect the current state of industry. This course is designed to provide students with in depth knowledge on software quality assurance components, software testing and its test process. The course covers the basic principles of software quality assurance, software testing and test activities that include the test plan, test design, monitoring, implementation and test closure. The students will also learn various categories of test design techniques and methods used in both black-box and white-box testing. At the end of this course, students should be able to recognize various types and levels of testing as well as categorizing and applying software testing process and techniques. The students should also be able to do work effectively in a team and lead the team in the test activities throughout the software testing life cycle.', '2023', 'March/April', 'SCSE2123,SCSE2233', NULL, '2024-06-30 06:10:52', '2024-06-30 08:26:01'),
(219, 'SCSE3223', 'Application Development Project II', 'Year 3: Semester 2', 3, NULL, '2023', 'March/April', 'SCSE2243', NULL, '2024-06-30 06:10:52', '2024-06-30 06:10:52'),
(220, 'SCSE3233', 'Professional Practice in Software Engineering', 'Year 3: Semester 2', 3, NULL, '2023', 'March/April', 'SCSE1203', NULL, '2024-06-30 06:10:52', '2024-06-30 06:10:52'),
(221, 'UBSS1032', 'Entrepreneurship and Innovation', 'Year 3: Semester 2', 2, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:10:52', '2024-06-30 06:10:52'),
(222, 'SCSE4108', 'Industrial Training (HW)', 'Year 4: Semester 1', 8, NULL, '2023', 'March/April', 'CGPA >=2.0,92 credits', NULL, '2024-06-30 06:11:52', '2024-06-30 06:12:35'),
(223, 'SCSE4114', 'Industrial Training Report', 'Year 4: Semester 1', 4, NULL, '2023', 'March/April', 'CGPA >=2.0, 92 credits', NULL, '2024-06-30 06:11:52', '2024-06-30 06:13:04'),
(224, 'SCSE4214', 'Software Engineering Project II', 'Year 4: Semester 2', 4, NULL, '2023', 'March/April', 'SCSE3242', NULL, '2024-06-30 06:15:07', '2024-06-30 06:15:07'),
(225, 'Sxxxxxx3', 'Free Elective III', 'Year 4: Semester 2', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:15:07', '2024-06-30 06:15:07'),
(226, 'SECx5xx3*', 'Free Elective IV', 'Year 4: Semester 2', 3, NULL, '2023', 'March/April', NULL, NULL, '2024-06-30 06:15:07', '2024-06-30 06:16:11'),
(227, 'SCSR4453', 'Network Security', 'Year 4: Semester 2', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:15:07', '2024-06-30 06:15:07'),
(228, 'SCSR4973', 'Computer Network & Security Special Topics', 'Year 4: Semester 2', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:15:07', '2024-06-30 06:15:07'),
(229, 'SECB3133', 'Computational Biology I', 'Year 4: Semester 2', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:15:07', '2024-06-30 06:15:07'),
(230, 'SECB3203', 'Programming for Bioinformatics', 'Year 4: Semester 2', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:15:07', '2024-06-30 06:15:07'),
(231, 'PRISM', 'PRISM elective I', 'Year 4: Semester 2', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:15:07', '2024-06-30 06:15:07'),
(232, 'PRISM2', 'PRISM elective II', 'Year 4: Semester 2', 3, NULL, '2023', 'March/April', '', NULL, '2024-06-30 06:17:21', '2024-06-30 06:17:21'),
(233, 'SCSE1013', 'Fundamental Programming Concept', 'Year 1: Semester 1', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:38', '2024-06-30 08:44:38'),
(234, 'SCST1123', 'Mathematics for Software Engineer', 'Year 1: Semester 1', 3, 'This course introduces students to the mathematical, computing and linguistic metaphors of software engineering. The mathematical topics that are covered in this course are set theory, proof techniques, relations, functions, recurrence relations, counting methods, graph theory, trees. This course also discusses on how formal language and computing theories may improve the understanding of programming languages and their work products – software. This part will emphasize on languages, grammars and abstract machines i.e. regular language, context free language, regular grammar, context free grammar, finite automata, push down automata, and turing machine. At the end of the course, the students should be able to use set theory, relations and functions to solve computer science problems, analyze and solve problems using recurrence relations and counting methods, apply graph theory and trees in real world problems and use abstract machines to model electronic devices and problems.', '2023', 'September', NULL, NULL, '2024-06-30 08:44:38', '2024-06-30 08:44:38'),
(235, 'SCSR1013', 'Digital Logic', 'Year 1: Semester 1', 3, 'Digital electronics is the foundation of all microprocessor-based systems found in computers, robots, automobiles, and industrial control systems. This course introduces the students to digital electronics and provides a broad overview of many important concepts, components, and tools. Students will get up-to-date coverage of digital fundamentals-from basic concepts to programmable logic devices. Laboratory experiments provide hands-on experience with the simulator software, actual devices and circuits studied in the classroom.', '2023', 'September', NULL, NULL, '2024-06-30 08:44:38', '2024-06-30 08:44:38'),
(236, 'SCST1143', 'Database Engineering', 'Year 1: Semester 1', 3, 'This course introduces students to the concept of database system and how it is used in daily human life and profession. The focus of the course is to equip students with the knowledge and skills on important steps and techniques used in developing a database, especially in the conceptual and logical database design phase. Among topics covered are database environment, database design, entity relationship diagram, normalization, and structured query language (SQL). Students will be taught to use a database management system (DBMS). Students are required to design and develop the database component of an information system using the learned techniques, DBMS and a development tool. At the end of the course, students should be able to apply the knowledge of designing and developing a good database system', '2023', 'September', NULL, NULL, '2024-06-30 08:44:38', '2024-06-30 08:44:38'),
(237, 'ULRS1012', 'Value and Identity', 'Year 1: Semester 1', 2, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:38', '2024-06-30 08:44:38'),
(238, 'Sxxxxxx3', 'Free Elective I*', 'Year 1: Semester 1', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:38', '2024-06-30 08:44:38'),
(239, 'SCSE1203', 'Software Engineering Principles', 'Year 1: Semester 2', 3, 'This course is designed to give students an introduction to an engineering approach in the development of high-quality software systems. It will discuss the important software engineering concepts in the various types of the common software process models. The students will also learn the concepts and techniques used in each software development phase including requirements engineering, software design and software testing. This course will also expose the students to utilizing object-oriented method (e.g. UML) and tools in analyzing and designing the software. In terms of generic skills, this course will also focus on critical thinking and communication skills of the students.', '2023', 'September', 'SCSE1013', NULL, '2024-06-30 08:44:38', '2024-06-30 08:44:38'),
(240, 'SCSR1033', 'Computer Organisation and Architecture', 'Year 1: Semester 2', 3, 'This course was designed to give the understanding of basic concept of computer organization and architecture. Topics covered in this subject will be on computer performance, types of data and the representative, arithmetic manipulation, instruction execution, micro programmable control memory, pipelining, memory, input/output and instruction format. At the end of this course, the student should be able to understand the concept of overall computer component and realize the current technology in computer hardware.', '2023', 'September', 'SCSR1013', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(241, 'SCST1223', 'Probability and Statistical Data Analysis', 'Year 1: Semester 2', 3, 'This course is designed to introduce some statistical techniques as tools to analyse the data. In the beginning the students will be exposed with various forms of data. The data represented by the different types of variables are derived from different sources; daily and industrial activities. The analysis begins with the data representation visually. The course will also explore some methods of parameter estimation from different distributions. Further data analysis is conducted by introducing the hypothesis testing. Some models are employed to fit groups of data. At the end of course the students should be able to apply some statistical models in analysing data using available software.', '2023', 'September', NULL, NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(242, 'SCSE1224', 'Advanced Programming', 'Year 1: Semester 2', 4, 'This course presents the advanced programming techniques and features. The course will cover concepts in Object-Oriented Programming and introduce functional programming paradigm. Basic understanding on control structures, objects and classes are required to enrol in this course. The course will also cover some advanced programming techniques including asynchronous programming. The course will equip the students with the theory and practice on problem solving using such techniques. The course will also provide the students with written and oral communication skills. At the end of this course, students should be able to use appropriate programming techniques and tools to develop programs to solve problem', '2023', 'September', 'SCSE1013', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(243, 'SCSR2213', 'Network Communications', 'Year 1: Semester 2', 3, 'This course will discuss the basic topics of computer network and data communications. Based on TCP/IP Internet protocol stack, the course will apply top down approach. Starts with the important and usage of computer network in commonly applications, the approach will go further detail in the technical aspect in data communication. At the end of this course, students will have an understanding and appreciation of how the network works.', '2023', 'September', NULL, NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(244, 'Uxxxxxx2', 'University Elective II', 'Year 1: Semester 2', 2, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(245, 'SCSE2133', 'Software Process and Project Management', 'Year 2: Semester 1', 3, 'This course is designed to provide students within depth knowledge on software project planning, cost estimation and scheduling, project management tools, factors influencing productivity and success, productivity metrics, analysis of options and risks, software process improvement, software contracts and intellectual property and approaches to maintenance and long term software development. This course will incorporate a work-based learning approach where students will have some sessions with the industrial partners. At the end of this course, students should be able to know how to manage a software development lifecycle.', '2023', 'September', 'SCSE1203', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(246, 'SCSE2123', 'Software Requirements Engineering', 'Year 2: Semester 1', 3, 'This course provides an introduction to requirement engineering and a thorough look at the software modeling. It will include requirements engineering topics include types of requirements, requirements elicitation techniques, requirements specification: text-based and model-based, requirements validation and negotiation, as well as requirements management. At the end of this course, the students shall have the skills necessary to conduct requirements engineering process with appropriate principles and methods.', '2023', 'September', 'SCSE1203', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(247, 'SCSE2103', 'Data Structure and Algorithm', 'Year 2: Semester 1', 3, 'This course emphasis on data structure concepts theoretically and practically with detail algorithms for each of data structure. Students will learn abstract data type concepts using class and apply the concept in the implementation of data structures. Apart from it, student will learn recursive concept as a programming style and algorithm efficiency analysis with Big O notation. Various sorting and searching techniques will be discussed as data structure operations. Analysis of each algorithm will also be explained. Further, students will be exposed to linear data structures such as linked lists, stack and queue. Non-linear data structures such as tree and binary search tree will be discussed. Along the course, students should be able to implement and apply the theory and concepts of data structure in the assignments and mini project which are conducted in group.', '2023', 'September', 'SCSE1013', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(248, 'SCSR2043', 'Operating System', 'Year 2: Semester 1', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(249, 'SCSM2113', 'Human Computer Interaction', 'Year 2: Semester 1', 3, 'This course will introduce students to human-computer interaction theories and design processes. The emphasis will be on applied user experience (UX) design. The course will present an iterative evaluation-centered UX lifecycle and will introduce a broader notion of user experience, including usability, usefulness, and emotional impact. The lifecycle should be viewed as template intended to be instantiated in many different ways to match the constraints of a particular development project. The UX lifecycle activities we will cover include contextual inquiry and analysis, requirements extraction, design-informing models, design thinking, ideation, sketching, conceptual design, and formative evaluation.', '2023', 'September', 'SCSE1203', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(250, 'UKQF2xx2', 'Service Learning and Community Engagement', 'Year 2: Semester 1', 2, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(251, 'SCSM2213', 'Cross-Platform Application Development', 'Year 2: Semester 2', 3, 'This course will provide students with a foundation on the development of modern applications. It will cover the workflows, tools and frameworks required to develop applications for current and emerging computing devices including mobile, web and desktop platforms. The course will adopt current technologies as a basis for teaching the process of the application development. This course will also expose the students to composing user interfaces, integrating with backends and the application architecture. This course will incorporate a work-based learning approach where students will have some sessions with the industrial partners. At the end of course, the students will be equipped with the competency of the appropriate skills for the development of modern applications as well as personal and entrepreneurial skills.', '2023', 'September', 'SCST1143', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(252, 'SCSE2233', 'Software Design & Architecture', 'Year 2: Semester 2', 3, 'This course provides the students with an in-depth look at the theory and practice of software architecture and design. It introduces the important concepts related to software architecture and design. It emphasizes on the design and (faithful) implementation of a large scale software using the widely accepted architecture styles and design patterns. It will also expose students to the use of the industrial strength design notations (e.g. UML) and CASE tools (e.g. Ent Arch, Visual Studio). In addition, it provides other aspects of a large and complex software design such as user interface design, management, leadership, and ethics. At the end of this course, the students should be able to use the techniques, architectural styles, and design patterns in software design.', '2023', 'September', 'SCSE1203', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(253, 'SCSE2243', 'Application Development Project I', 'Year 2: Semester 2', 3, NULL, '2023', 'September', 'SCSE1203,SCSE2123', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(254, 'UHLB2122', 'Professional Communication Skills I', 'Year 2: Semester 2', 2, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(255, 'UHIS1022', 'Philosophy and Current Issues', 'Year 2: Semester 2', 2, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(256, 'Sxxxxxx3', 'Free Elective II*', 'Year 2: Semester 2', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(257, 'UHLB3132', 'Professional Communication Skills 2', 'Year 3: Semester 1', 2, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(258, 'UHLx1122', 'Foreign Language Elective', 'Year 3: Semester 1', 2, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(259, 'Sxxxxxx3', 'Free Elective III*', 'Year 3: Semester 1', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(260, 'SCST3223', 'Data Analytic Programming', 'Year 3: Semester 1', 3, NULL, '2023', 'September', 'SECJ2013', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(261, 'SCSE3143', 'Ubiquitous Computing', 'Year 3: Semester 1', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(262, 'SCSR3113', 'Cloud Computing', 'Year 3: Semester 1', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(263, 'SCSE3103', 'Cognitive Computing', 'Year 3: Semester 1', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(264, 'SCSE3203', 'Special Topics', 'Year 3: Semester 1', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(265, 'SCSM3113', 'Virtual and Augmented Reality Application', 'Year 3: Semester 1', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(266, 'SCSE3242', 'Software Engineering Project I', 'Year 3: Semester 2', 2, NULL, '2023', 'September', 'SCSE2243,80 credits,', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(267, 'SCSR3133', 'Secure Software Programming', 'Year 3: Semester 2', 3, 'This course aims to prepare students with knowledge to develop secure application. This is done by exposing common programming errors, ways to locate, and fix them. Besides that, students will learn how to properly use libraries for applying cryptographic functions. At the end of this course student should be able to design and develop secure application based on current security technologies.', '2023', 'September', 'SCSM2213', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(268, 'SCSE3213', 'Software Quality & Testing', 'Year 3: Semester 2', 3, 'The content of the course discusses the Software Quality issues much beyond the classic boundaries of custom-made software development by large established software houses. It dedicates significant attention to the other software development and maintenance environment that reflect the current state of industry. This course is designed to provide students with in depth knowledge on software quality assurance components, software testing and its test process. The course covers the basic principles of software quality assurance, software testing and test activities that include the test plan, test design, monitoring, implementation and test closure. The students will also learn various categories of test design techniques and methods used in both black-box and white-box testing. At the end of this course, students should be able to recognize various types and levels of testing as well as categorizing and applying software testing process and techniques. The students should also be able to do work effectively in a team and lead the team in the test activities throughout the software testing life cycle.', '2023', 'September', 'SCSE2123,SCSE2233', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(269, 'SCSE3223', 'Application Development Project II', 'Year 3: Semester 2', 3, NULL, '2023', 'September', 'SCSE2243', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(270, 'SCSE3233', 'Professional Practice in Software Engineering', 'Year 3: Semester 2', 3, NULL, '2023', 'September', 'SCSE1203', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(271, 'UBSS1032', 'Entrepreneurship and Innovation', 'Year 3: Semester 2', 2, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(272, 'SCSE4108', 'Industrial Training (HW)', 'Year 4: Semester 1', 8, NULL, '2023', 'September', 'CGPA >=2.0,92 credits', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(273, 'SCSE4114', 'Industrial Training Report', 'Year 4: Semester 1', 4, NULL, '2023', 'September', 'CGPA >=2.0, 92 credits', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(274, 'SCSE4214', 'Software Engineering Project II', 'Year 4: Semester 2', 4, NULL, '2023', 'September', 'SCSE3242', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(275, 'Sxxxxxx3', 'Free Elective III', 'Year 4: Semester 2', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(276, 'SECx5xx3*', 'Free Elective IV', 'Year 4: Semester 2', 3, NULL, '2023', 'September', NULL, NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(277, 'SCSR4453', 'Network Security', 'Year 4: Semester 2', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(278, 'SCSR4973', 'Computer Network & Security Special Topics', 'Year 4: Semester 2', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(279, 'SECB3133', 'Computational Biology I', 'Year 4: Semester 2', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(280, 'SECB3203', 'Programming for Bioinformatics', 'Year 4: Semester 2', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(281, 'PRISM', 'PRISM elective I', 'Year 4: Semester 2', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39'),
(282, 'PRISM2', 'PRISM elective II', 'Year 4: Semester 2', 3, NULL, '2023', 'September', '', NULL, '2024-06-30 08:44:39', '2024-06-30 08:44:39');

-- --------------------------------------------------------

--
-- Table structure for table `course_offerings`
--

CREATE TABLE `course_offerings` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `intake_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intake_semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `credit_calculations`
--

CREATE TABLE `credit_calculations` (
  `id` bigint UNSIGNED NOT NULL,
  `application_form_id` bigint UNSIGNED NOT NULL,
  `application_form_subject_id` bigint UNSIGNED NOT NULL,
  `equivalent_utm_credits` decimal(8,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `approved` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `credit_calculations`
--

INSERT INTO `credit_calculations` (`id`, `application_form_id`, `application_form_subject_id`, `equivalent_utm_credits`, `created_at`, `updated_at`, `remarks`, `approved`) VALUES
(60, 128, 207, 4.094, '2024-07-03 06:22:30', '2024-07-03 06:22:30', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `education_details`
--

CREATE TABLE `education_details` (
  `id` bigint UNSIGNED NOT NULL,
  `application_form_id` bigint UNSIGNED NOT NULL,
  `faculty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_semester` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field_of_study` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_graduation` text COLLATE utf8mb4_unicode_ci,
  `program` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cgpa` decimal(3,2) DEFAULT NULL,
  `co_curriculum` text COLLATE utf8mb4_unicode_ci,
  `achievements` text COLLATE utf8mb4_unicode_ci,
  `special_skills` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `education_details`
--

INSERT INTO `education_details` (`id`, `application_form_id`, `faculty`, `current_semester`, `field_of_study`, `expected_graduation`, `program`, `cgpa`, `co_curriculum`, `achievements`, `special_skills`, `created_at`, `updated_at`) VALUES
(50, 120, 'Faculty of Computing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-30 08:47:58', '2024-06-30 08:47:58'),
(51, 122, 'Faculty of Computing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-02 07:54:55', '2024-07-02 07:54:55'),
(52, 124, 'Faculty of Computing', NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, '2024-07-03 04:12:31', '2024-07-03 04:13:32'),
(53, 127, 'Faculty of Computing', NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, '2024-07-03 06:09:38', '2024-07-03 06:11:02'),
(54, 128, 'Faculty of Computing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-03 06:22:30', '2024-07-03 06:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_approval_details`
--

CREATE TABLE `faculty_approval_details` (
  `id` bigint UNSIGNED NOT NULL,
  `application_form_id` bigint UNSIGNED NOT NULL,
  `approval` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `faculty_remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_details`
--

CREATE TABLE `financial_details` (
  `id` bigint UNSIGNED NOT NULL,
  `application_form_id` bigint UNSIGNED NOT NULL,
  `finance_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sponsorship_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `financial_details`
--

INSERT INTO `financial_details` (`id`, `application_form_id`, `finance_method`, `sponsorship_details`, `budget_details`, `created_at`, `updated_at`) VALUES
(50, 120, NULL, NULL, NULL, '2024-06-30 08:47:58', '2024-06-30 08:47:58'),
(51, 122, NULL, NULL, NULL, '2024-07-02 07:54:55', '2024-07-02 07:54:55'),
(52, 124, NULL, 'N/A', 'N/A', '2024-07-03 04:12:32', '2024-07-03 04:13:32'),
(53, 127, 'self_sponsored', 'None', 'College = RM100\r\nFood = RM150', '2024-07-03 06:09:38', '2024-07-03 06:11:02'),
(54, 128, NULL, NULL, NULL, '2024-07-03 06:22:30', '2024-07-03 06:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `inbound_students`
--

CREATE TABLE `inbound_students` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` enum('March/April','September') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inbound_student_timetables`
--

CREATE TABLE `inbound_student_timetables` (
  `id` bigint UNSIGNED NOT NULL,
  `inbound_student_id` bigint UNSIGNED NOT NULL,
  `course_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_slot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` year NOT NULL,
  `semester` enum('March/April','September') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `timetables_course_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intakes`
--

CREATE TABLE `intakes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mobility_programs`
--

CREATE TABLE `mobility_programs` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `extra_info` text COLLATE utf8mb4_general_ci,
  `link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobility_programs`
--

INSERT INTO `mobility_programs` (`id`, `title`, `description`, `image`, `due_date`, `extra_info`, `link`, `created_at`, `updated_at`) VALUES
(38, '❤️Summer School Program 💙', 'Greetings to all UTM students !\r\nUniversitas Negeri Malang (UM), Indonesia is calling for the application of UM iCamp 2024 :\r\n\r\n- Commencing date : 4 - 10 August 2024\r\n- Eligibility : All UTM Students\r\n- Deadline : 25 May 2024', 'mobility_program_images/BqsjMkaltHb5PEorhXrxJnovqwfVc5iHsXyLcnt7.jpg', '2024-07-06', 'Any questions regarding the program could be directed to umicamp@um.ac.id or to the following contact persons by WhatsApp +62 821-3413-4620', 'https://www.instagram.com/p/C7BWjIWS8EK/', '2024-06-30 07:27:16', '2024-06-30 07:27:16'),
(40, 'CALL FOR PAPERS FOR GEOCHITRA 2024 (4-5 SEPTEMBER 2024', '🌐 GEOCHITRA 2024 - Disaster Resiliency for Future Development in Geotechnical and Transportation Engineering\r\n📅 Save the Date: 4 - 5 SEPTEMBER 2024\r\n📍 Venue: SERI PACIFIC HOTEL, KUALA LUMPUR', 'mobility_program_images/ozzhOr7z3r838w9r1QYhO8v5BTXw6RTj8r0Q13Pz.jpg', '2024-07-20', '🌍 Theme: Disaster Resiliency for Future Development in Geotechnical and Transportation Engineering', 'https://www.instagram.com/p/C7BUwrpSS_1/', '2024-07-03 06:37:38', '2024-07-03 06:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` bigint UNSIGNED NOT NULL,
  `intake_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intake_semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_semester` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `intake_year`, `intake_semester`, `year_semester`, `note`, `created_at`, `updated_at`) VALUES
(9, '2023', 'March/April', 'Year 1: Semester 1', 'Test', '2024-06-30 05:38:13', '2024-06-30 05:38:13'),
(10, '2023', 'March/April', 'Year 3: Semester 1', 'Elective (* Students must choose University Free Electives subjects offered by faculties other than Faculty of Computing.)\r\nSCST3223, SCSE3143, SCSR3113, SCSE3103, SCSE3203, SCSM3113', '2024-06-30 06:09:55', '2024-06-30 06:09:55'),
(11, '2023', 'March/April', 'Year 4: Semester 2', '*PRISM elective courses are for PRISM students only. Information on PRISM can be found here: https://engineering.utm.my/prism/\r\nElective (SCSR4453, SCSR4453,SCSR4973, SECB3133, SECB3203)', '2024-06-30 06:19:17', '2024-06-30 06:19:17'),
(12, '2023', 'March/April', NULL, 'Currently on Year 2: Semester 1', '2024-06-30 08:10:24', '2024-07-06 02:54:22');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` year NOT NULL,
  `term` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_credits` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('e7o9M78ogfzreThfOJHfnHj3wNk4rQiHs4Ow1mxu', NULL, '161.139.102.162', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 OPR/109.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0JTZEJITlRjMUxCQ29oMDF6cnUxTXFmZ0ZLYVJWMVlsODVHTkNIZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMy4yNTAuMjkuNzMvbW9iaWxpdHlzeXN0ZW0vcHVibGljIjt9fQ==', 1720236636);

-- --------------------------------------------------------

--
-- Table structure for table `study_plans`
--

CREATE TABLE `study_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `target_university_course_id` bigint UNSIGNED DEFAULT NULL,
  `year_semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `study_plans`
--

INSERT INTO `study_plans` (`id`, `user_id`, `course_id`, `target_university_course_id`, `year_semester`, `remark`, `reviewed_by`, `created_at`, `updated_at`, `status`) VALUES
(3021, 19, 184, NULL, 'Year 1: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:25:08', 'custom'),
(3022, 19, 185, NULL, 'Year 1: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:25:08', 'custom'),
(3023, 19, 186, NULL, 'Year 1: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:25:08', 'custom'),
(3024, 19, 187, NULL, 'Year 1: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:25:08', 'custom'),
(3025, 19, 188, NULL, 'Year 1: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:25:08', 'custom'),
(3026, 19, 183, NULL, 'Year 1: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:25:08', 'custom'),
(3027, 19, 189, NULL, 'Year 1: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:25:08', 'custom'),
(3028, 19, 190, NULL, 'Year 1: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:25:08', 'custom'),
(3029, 19, 191, NULL, 'Year 1: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:25:08', 'custom'),
(3030, 19, 192, NULL, 'Year 1: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:25:08', 'custom'),
(3031, 19, 193, NULL, 'None', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:35:56', 'custom'),
(3032, 19, 194, NULL, 'Year 1: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:25:08', 'custom'),
(3033, 19, 197, NULL, 'Year 2: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3034, 19, 200, NULL, 'Year 2: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3035, 19, 199, NULL, 'Year 2: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3036, 19, 198, NULL, 'Year 2: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3037, 19, 196, NULL, 'Year 2: Semester 2', 'Exceed credit, please remove', NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3038, 19, 195, NULL, 'Year 2: Semester 2', 'Exceed credit, please remove', NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3039, 19, 201, NULL, 'Year 2: Semester 2', 'Exceed credit, please remove', NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3040, 19, 202, NULL, 'Year 2: Semester 2', 'Exceed credit, please remove', NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3041, 19, 203, NULL, 'Year 2: Semester 2', 'Exceed credit, please remove', NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3042, 19, 204, NULL, 'Year 2: Semester 2', 'Exceed credit, please remove', NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3043, 19, 205, NULL, 'Year 2: Semester 2', 'Exceed credit, please remove', NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3044, 19, 206, NULL, 'Year 2: Semester 2', 'Exceed credit, please remove', NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3045, 19, 208, NULL, 'Year 3: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3046, 19, 215, NULL, 'Year 3: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3047, 19, 214, NULL, 'Year 3: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3048, 19, 213, NULL, 'Year 3: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3049, 19, 212, NULL, 'Year 3: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3050, 19, 210, NULL, 'Year 3: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3051, 19, 209, NULL, 'Year 3: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3052, 19, 207, NULL, 'Year 3: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3053, 19, 211, NULL, 'Year 3: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3054, 19, 216, NULL, 'Year 3: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3055, 19, 217, NULL, 'Year 3: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3056, 19, 218, NULL, 'Year 3: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3057, 19, 219, NULL, 'Year 3: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3058, 19, 220, NULL, 'Year 3: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3059, 19, 221, NULL, 'Year 3: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3060, 19, 222, NULL, 'Year 4: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3061, 19, 223, NULL, 'Year 4: Semester 1', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3062, 19, 224, NULL, 'Year 4: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3063, 19, 225, NULL, 'Year 4: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3064, 19, 226, NULL, 'Year 4: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3065, 19, 227, NULL, 'Year 4: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3066, 19, 228, NULL, 'Year 4: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3067, 19, 229, NULL, 'Year 4: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3068, 19, 230, NULL, 'Year 4: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3069, 19, 231, NULL, 'Year 4: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3070, 19, 232, NULL, 'Year 4: Semester 2', NULL, NULL, '2024-07-03 06:25:08', '2024-07-03 06:31:09', 'custom'),
(3071, 19, 193, 51, 'None', 'Approved BY Program Coordinator', NULL, '2024-07-03 06:35:56', '2024-07-03 06:35:56', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `target_credits`
--

CREATE TABLE `target_credits` (
  `id` bigint UNSIGNED NOT NULL,
  `intake_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intake_semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_credits` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `target_credits`
--

INSERT INTO `target_credits` (`id`, `intake_year`, `intake_semester`, `year_semester`, `target_credits`, `created_at`, `updated_at`) VALUES
(4, '2023', 'March/April', 'Year 1: Semester 2', 20, '2024-07-06 02:54:49', '2024-07-06 02:54:49');

-- --------------------------------------------------------

--
-- Table structure for table `target_university_courses`
--

CREATE TABLE `target_university_courses` (
  `id` bigint UNSIGNED NOT NULL,
  `application_form_subject_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_credit` decimal(5,2) DEFAULT NULL,
  `course_code_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `target_university_courses`
--

INSERT INTO `target_university_courses` (`id`, `application_form_subject_id`, `user_id`, `course_code`, `course_name`, `course_credit`, `course_code_name`, `created_at`, `updated_at`) VALUES
(51, 207, 19, 'Machine Learning (31005)', 'Machine Learning (31005)', 7.50, 'Machine Learning (31005)', '2024-07-03 06:35:56', '2024-07-03 06:35:56');

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `id` bigint UNSIGNED NOT NULL,
  `course_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_slot` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` year NOT NULL,
  `semester` enum('March/April','September') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `student_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `matric_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intake_period` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `user_type`, `matric_number`, `intake_period`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Shahliza binti Abd Halim', 'pc@gmail.com', '2024-04-22 18:49:20', '$2y$12$JjOuzCMFL.reQpscqzAWJ.iCo8IYnpSOHY.usMpX4vSiHJJc2HvR2', 'program_coordinator', NULL, NULL, NULL, '2024-04-22 18:48:56', '2024-06-05 02:35:43'),
(4, 'Admin', 'admin@gmail.com', '2024-04-22 21:11:54', '$2y$12$WB1K1DAHS.M.ge7f8vNrqOXOuNzFp9bGtD3iJTGLP6RbdbwL/19P2', 'Admin', NULL, NULL, NULL, '2024-04-26 04:29:16', '2024-04-26 04:29:16'),
(6, 'Alif', 'staff@gmail.com', '2024-04-22 21:11:54', '$2y$12$gW1Or5Y9dN2GinK8o.5odOYvwc84NP.CrPc78MQ4LTw.t80.4QAA2', 'UTM Staff', NULL, NULL, NULL, '2024-06-12 17:45:37', '2024-06-12 17:45:37'),
(7, 'Prof. Ts. Dr. Dayang Norhayati', 'tda@gmail.com', '2024-04-22 21:11:54', '$2y$12$DNkKGvyutz8ANCCnq8XoDuvBJ8hfnT/NTGlcbjusJBLVqaumhpLqO', 'TDA', NULL, NULL, NULL, '2024-06-12 18:40:44', '2024-06-12 18:40:44'),
(8, 'DR Razib', 'aa@gmail.com', '2024-04-22 21:11:54', '$2y$12$6mhgrSkkXZlCHcPWO3pAg.KhjRTg1GbrgSwGTcXNik4cXTW8njl2y', 'Academic Advisor', NULL, NULL, NULL, '2024-06-12 19:02:28', '2024-06-12 19:02:28'),
(9, 'Alif', 'zulampardxx@gmail.com', NULL, '$2y$12$QBDDNmDPF4uqXmYD11TeVuMRz4q4BAunb1PXQ9qoU5Dt5wIDS0PTq', 'UTM Staff', NULL, NULL, NULL, '2024-06-16 04:21:35', '2024-06-16 04:21:35'),
(19, 'Muhd Zulkarnain Bin Hamidi', 'muhdzzulkar9@gmail.com', '2024-07-03 06:19:10', '$2y$12$vwyMZZ2yoOzTrXCdBzEmcuYRZpjASa9qOnhBsgd/DGTXzVg6iif6G', 'utm_student', 'A23EC0056', 'March/April', NULL, '2024-07-03 06:18:54', '2024-07-03 06:39:07'),
(20, 'Jay', 'jay@gmail.com', NULL, '$2y$12$gSQ0XtIx4szyegMc4vqaZe6wSlQtote6UKb8W9HqhCzkXO6i.Vg2i', 'UTM Staff', NULL, NULL, NULL, '2024-07-03 06:39:53', '2024-07-03 06:39:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advisor_and_approval_details`
--
ALTER TABLE `advisor_and_approval_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advisor_and_approval_details_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `applicant_details`
--
ALTER TABLE `applicant_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicant_details_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `application_forms`
--
ALTER TABLE `application_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_forms_user_id_foreign` (`user_id`);

--
-- Indexes for table `application_form_subjects`
--
ALTER TABLE `application_form_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_form_subjects_application_form_id_foreign` (`application_form_id`),
  ADD KEY `application_form_subjects_utm_course_id_foreign` (`utm_course_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_application_form_id_foreign` (`application_form_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_intake_unique` (`course_code`,`intake_year`,`intake_semester`,`year_semester`);

--
-- Indexes for table `course_offerings`
--
ALTER TABLE `course_offerings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_offerings_course_id_foreign` (`course_id`);

--
-- Indexes for table `credit_calculations`
--
ALTER TABLE `credit_calculations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `credit_calculations_application_form_id_foreign` (`application_form_id`),
  ADD KEY `credit_calculations_application_form_subject_id_foreign` (`application_form_subject_id`);

--
-- Indexes for table `education_details`
--
ALTER TABLE `education_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `education_details_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `faculty_approval_details`
--
ALTER TABLE `faculty_approval_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_approval_details_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `financial_details`
--
ALTER TABLE `financial_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_details_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `inbound_students`
--
ALTER TABLE `inbound_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inbound_student_timetables`
--
ALTER TABLE `inbound_student_timetables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inbound_student_timetables_inbound_student_id_foreign` (`inbound_student_id`),
  ADD KEY `inbound_student_timetables_timetables_course_id_foreign` (`timetables_course_id`);

--
-- Indexes for table `intakes`
--
ALTER TABLE `intakes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobility_programs`
--
ALTER TABLE `mobility_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `semesters_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `study_plans`
--
ALTER TABLE `study_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `study_plans_user_id_foreign` (`user_id`),
  ADD KEY `study_plans_course_id_foreign` (`course_id`),
  ADD KEY `study_plans_reviewed_by_foreign` (`reviewed_by`),
  ADD KEY `study_plans_target_university_course_id_foreign` (`target_university_course_id`);

--
-- Indexes for table `target_credits`
--
ALTER TABLE `target_credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `target_university_courses`
--
ALTER TABLE `target_university_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `target_university_courses_application_form_subject_id_foreign` (`application_form_subject_id`),
  ADD KEY `target_university_courses_user_id_foreign` (`user_id`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advisor_and_approval_details`
--
ALTER TABLE `advisor_and_approval_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `applicant_details`
--
ALTER TABLE `applicant_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `application_forms`
--
ALTER TABLE `application_forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `application_form_subjects`
--
ALTER TABLE `application_form_subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=393;

--
-- AUTO_INCREMENT for table `course_offerings`
--
ALTER TABLE `course_offerings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credit_calculations`
--
ALTER TABLE `credit_calculations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `education_details`
--
ALTER TABLE `education_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `faculty_approval_details`
--
ALTER TABLE `faculty_approval_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_details`
--
ALTER TABLE `financial_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `inbound_students`
--
ALTER TABLE `inbound_students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `inbound_student_timetables`
--
ALTER TABLE `inbound_student_timetables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `intakes`
--
ALTER TABLE `intakes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `mobility_programs`
--
ALTER TABLE `mobility_programs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `study_plans`
--
ALTER TABLE `study_plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3072;

--
-- AUTO_INCREMENT for table `target_credits`
--
ALTER TABLE `target_credits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `target_university_courses`
--
ALTER TABLE `target_university_courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=589;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advisor_and_approval_details`
--
ALTER TABLE `advisor_and_approval_details`
  ADD CONSTRAINT `advisor_and_approval_details_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `applicant_details`
--
ALTER TABLE `applicant_details`
  ADD CONSTRAINT `applicant_details_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `application_forms`
--
ALTER TABLE `application_forms`
  ADD CONSTRAINT `application_forms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
