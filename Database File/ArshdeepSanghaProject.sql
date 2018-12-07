-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 04, 2017 at 04:05 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `WebProject`
--

-- --------------------------------------------------------

--
-- Table structure for table `Cars`
--

CREATE TABLE `Cars` (
  `VehicleId` int(6) NOT NULL,
  `VehicleName` varchar(20) NOT NULL,
  `Year` int(4) NOT NULL,
  `Amount` int(6) NOT NULL,
  `Make` varchar(20) NOT NULL,
  `imageName` varchar(200) NOT NULL,
  `rented` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Cars`
--

INSERT INTO `Cars` (`VehicleId`, `VehicleName`, `Year`, `Amount`, `Make`, `imageName`, `rented`) VALUES
(1, 'RDX', 2011, 194, 'Acura', 'RDX.jpg', 1),
(3, 'Elantra', 2015, 150, 'Hyundai', 'elantra.jpg', 0),
(5, 'E Class ', 2017, 215, 'Mercedez-Benz', 'eclass.jpg', 0),
(7, 'Mustang', 2018, 217, 'Ford', 'mustang.jpeg', 0),
(10, 'X3', 2016, 204, 'BMW', '', 0),
(11, 'Fortuner', 2016, 200, 'Toyota', '', 0),
(12, 'Corrolla', 2017, 123, 'Toyota', '', 0),
(13, 'Highlander', 2016, 200, 'Toyota', '', 0),
(15, 'Etios', 2014, 103, 'Hyundai', '', 0),
(16, 'Jaguar', 2017, 305, 'XF', '', 0),
(26, 'Jeep', 1945, 101, 'Willy', 'willy.jpg', 0),
(27, 'Conntessa', 1981, 100, 'Hindustan Motors', 'contessa.jpg', 0),
(28, 'F340', 2010, 500, 'Ferrari', 'ferrari.jpg', 0),
(29, 'Focus', 2013, 100, 'Ford', '', 0),
(30, 'Phantom', 2018, 500, 'Rolls-Royce', 'rr.jpg', 0),
(31, 'Prado', 2018, 350, 'Land Cruiser', 'landcruiser.jpg', 0),
(32, 'Evoque', 2017, 350, 'Land Rover', 'evoque.jpg', 0),
(33, 'Accord', 2018, 300, 'Honda', 'accord.jpg', 1),
(34, 'X6', 2017, 400, 'BMW', 'x3.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Rent`
--

CREATE TABLE `Rent` (
  `RentID` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `VehicleId` int(11) NOT NULL,
  `VehicleName` varchar(100) NOT NULL,
  `Make` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `dl` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ccnumber` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Rent`
--

INSERT INTO `Rent` (`RentID`, `userId`, `VehicleId`, `VehicleName`, `Make`, `firstName`, `lastName`, `dl`, `email`, `ccnumber`) VALUES
(20, 11, 1, 'RDX', 'Acura', 'Arshdeep', 'Sangha', '6531RR', 'arsh98000@gmail.com', '4878901234561234'),
(21, 10, 33, 'Accord', 'Honda', 'Nirav', 'Chaudhary', '5446FGD56', 'niravc810@gmail.com', '6473467364374637'),
(22, 19, 34, 'X6', 'BMW', 'Anmol', 'Sandhu', '56TY34DD', 'anmolsandhu3096@gmail.com', '7321363672352653');

-- --------------------------------------------------------

--
-- Table structure for table `Suggestion`
--

CREATE TABLE `Suggestion` (
  `SuggestionId` int(255) NOT NULL,
  `VehicleId` int(255) NOT NULL,
  `UserId` int(255) NOT NULL,
  `Comment` varchar(300) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Title` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Suggestion`
--

INSERT INTO `Suggestion` (`SuggestionId`, `VehicleId`, `UserId`, `Comment`, `Date`, `Title`) VALUES
(2, 1, 2, 'Let me know!!								', '2017-11-06 06:59:40', 'How low can you go '),
(4, 5, 2, 'what kind of mercedez\r\n id this?			', '2017-11-06 04:08:27', 'question about merce'),
(6, 7, 2, 'wow nice car									', '2017-11-06 05:42:11', 'nice car'),
(12, 1, 1, 'This car is really awesome!!					\r\n				', '2017-11-06 06:55:58', 'Awesome!!!!'),
(13, 1, 1, 'i love this car!!					\r\n				', '2017-11-06 06:57:29', 'Nice'),
(17, 17, 10, '&lt;p&gt;oefmokemvok&lt;/p&gt;\r\n', '2017-11-26 20:18:07', 'reonvornv'),
(18, 17, 10, 'm,r3l;vm;lrevme,v;lm\r\ne;lv', '2017-11-26 20:18:31', 'ljfior3f'),
(19, 33, 11, 'When is the Rental Expiry?', '2017-12-01 04:44:19', 'Rental Expiry?');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `userId` int(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `admin` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`userId`, `username`, `password`, `admin`) VALUES
(18, 'nirav01', 'ae5e3eba6e92d93ee2c9e6dac858b7785e4f312bb761268137fdff2e44c165479d2d48e2710e2439296114e8e53d4009fc18057163316c67a1a72380527b02ed', 0),
(19, 'arshdeep01', 'acdd63ce1d1ec187672f139c3470bce1029a8e4b4e28ea6ef301f68de11c26912ff3643640cf16fdfaabaf862d18986840b678a8b2867714b5efced6eb5c4927', 1),
(21, 'anmol01', 'b20793f3b43a90e8ef2b8ced08cd7f84b3194457f76741663215874e1e594163b9e58f5c062c573fecb18105b6c585e8c2bdcab75b60182dc530c6612a3015d6', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Cars`
--
ALTER TABLE `Cars`
  ADD PRIMARY KEY (`VehicleId`);

--
-- Indexes for table `Rent`
--
ALTER TABLE `Rent`
  ADD PRIMARY KEY (`RentID`);

--
-- Indexes for table `Suggestion`
--
ALTER TABLE `Suggestion`
  ADD PRIMARY KEY (`SuggestionId`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Cars`
--
ALTER TABLE `Cars`
  MODIFY `VehicleId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `Rent`
--
ALTER TABLE `Rent`
  MODIFY `RentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `Suggestion`
--
ALTER TABLE `Suggestion`
  MODIFY `SuggestionId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `userId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
