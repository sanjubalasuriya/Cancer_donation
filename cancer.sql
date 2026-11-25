-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2022 at 02:28 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cancer`
--

-- --------------------------------------------------------

--
-- Table structure for table `cancers`
--

CREATE TABLE `cancers` (
  `id` int(11) NOT NULL,
  `num` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cancers`
--

INSERT INTO `cancers` (`id`, `num`, `name`) VALUES
(1, 'C1', 'Bladder Cancer'),
(2, 'C2', 'Breast Cancer'),
(3, 'C3', 'Colon and Rectal Cancer'),
(4, 'C4', 'Endometrial Cancer'),
(5, 'C5', 'Kidney Cancer'),
(6, 'C6', 'Leukemia'),
(7, 'C7', 'Liver Cancer'),
(8, 'C8', 'Lung Cancer'),
(9, 'C9', 'Melanoma'),
(10, 'C10', 'Non-Hodgkin Lymphoma'),
(11, 'C11', 'Bone marrow cancer'),
(12, 'C12', 'Brain Cancer'),
(13, 'C13', 'Brain tumor');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(20) NOT NULL,
  `key_id` varchar(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `amount` int(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `key_id`, `status`, `amount`, `date`) VALUES
(1, 'M1', 'member', 1000, '2022-10-16 11:23:40'),
(2, 'M2', 'member', 1000, '2022-10-16 11:24:03'),
(3, 'M3', 'member', 1000, '2022-10-16 11:24:45'),
(4, 'D1', 'New Hospital Building', 40000, '2022-10-16 11:25:37'),
(5, 'D2', 'New Hospital Building', 40000, '2022-10-16 11:27:20'),
(6, 'D3', 'Pet Sacn Machine', 40000, '2022-10-16 11:28:03'),
(7, 'D4', 'patients', 80000, '2022-10-16 11:28:46'),
(8, 'S1', 'sponsor', 40000, '2022-10-16 11:30:49'),
(9, 'M4', 'member', 1000, '2022-10-16 14:17:22'),
(10, 'D5', 'New Hospital Building', 40000, '2022-10-16 14:18:32'),
(11, 'D6', 'patients', 40000, '2022-10-16 14:19:46');

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `id` int(11) NOT NULL,
  `d_id` varchar(20) NOT NULL,
  `f_name` varchar(20) NOT NULL,
  `l_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`id`, `d_id`, `f_name`, `l_name`, `email`, `contact`, `status`, `date`) VALUES
(1, 'D1', 'Pathum', 'Anuradha', 'lakru999@gmail.com', 772014795, 'New Hospital Building', '2022-10-16 11:25:37'),
(2, 'D2', 'Malith', 'Praveen', 'lak96nirma@gmail.com', 772014795, 'New Hospital Building', '2022-10-16 11:27:20'),
(3, 'D3', 'Ranjith', 'Sampath', 'sanjubalasuriya2@gmail.com', 772014795, 'Pet Sacn Machine', '2022-10-16 11:28:03'),
(4, 'D4', 'Ranjith', 'Chamara', 'lakru999@gmail.com', 772014795, 'P1', '2022-10-16 11:28:46'),
(5, 'D5', 'Sanju', 'Balasuriya', 'sanjubalasuriya2@gmail.com', 772014795, 'New Hospital Building', '2022-10-16 14:18:32'),
(6, 'D6', 'Sanju', 'Balasuriya', 'sanjubalasuriya2@gmail.com', 772014795, 'P1', '2022-10-16 14:19:46');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `location` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `title`, `location`, `image`, `description`, `date`) VALUES
(1, 'World Cancer Day', 'World Cancer Day', 'imagee/c7803d870feef221453236be3b14f8acworld-cancer-day-concept-february-vector-23528201.jpg', 'World Cancer Day aims to prevent millions of deaths each year by raising awareness and education about cancer, and pressing governments and individuals across the world to take action against the disease.\r\n\r\nUICC continues to expand on the success and impact of the day and is committed to ensuring that year-on-year the event is seen and heard by more people around the world. UICC does this by developing a campaign that serves the different organizational priorities of its members worldwide. ', '2023-02-04'),
(2, 'Vesak Poya Day', 'Cancer Hospital', 'imagee/98754920b897734b067f3d4294523165image.jpg', 'Vesak festival is considered as a religious and cultural festival in Sri Lanka. It is celebrated on the full moon day of May. This festival marks the birth, enlightenment and nirvana of Lord Buddha. The weekly celebration offers visitors a unique opportunity to discover the religious and cultural traditions of Sri Lanka.', '2022-10-06'),
(3, 'Mothers Day', 'Mothers Day', 'imagee/0e3b84a2f6231f94843bace3fc8706411-33.jpg', 'Mothers Day', '2022-10-22');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `uname` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `uname`, `password`, `role`) VALUES
(1, 'john', 'b5dfda0b18d06f1b6ad26cddd0e475e4', 'admin'),
(2, 'Diamond', 'e10adc3949ba59abbe56e057f20f883e', 'salon'),
(5, 'SL_1', 'e10adc3949ba59abbe56e057f20f883e', 'salon'),
(6, 'SL_2', 'e10adc3949ba59abbe56e057f20f883e', 'salon'),
(7, 'SL_3', 'e10adc3949ba59abbe56e057f20f883e', 'salon'),
(8, 'SL_4', 'e10adc3949ba59abbe56e057f20f883e', 'salon');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(20) NOT NULL,
  `m_id` varchar(20) NOT NULL,
  `f_name` varchar(20) NOT NULL,
  `l_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` int(20) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `m_id`, `f_name`, `l_name`, `email`, `contact`, `nic`, `status`, `date`) VALUES
(1, 'M1', 'Lakshitha', 'Nirmal', 'sanjubalasuriya2@gmail.com', 772014795, '901711671v', 'paid', '2022-07-05 11:23:40'),
(2, 'M2', 'Ranjith', 'Chamara', 'sanjubalasuriya2@gmail.com', 772014795, '881711671v', 'paid', '2022-08-11 11:24:03'),
(3, 'M3', 'Lakruwan', 'Senadheera', 'lakru999@gmail.com', 772014795, '951711671v', 'paid', '2022-10-16 11:24:45'),
(4, 'M4', 'Sanju', 'Balasuriya', 'sanjubalasuriya2@gmail.com', 772014795, '901711675v', 'paid', '2022-10-16 14:17:22');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `image`, `description`, `date`) VALUES
(1, 'Sri Lanka cancer care hit by foreign currency crisis', 'imagen/b5c8352c657a6dade7ffd25f127ec409cancer.jpg', 'The National Cancer Institute (NCI), the country’s premiere cancer centre in Colombo, is running short of many critical medicines, anaesthesia drugs and surgical consumables, Cancer World has found.\r\n\r\n“There have been no surgery cancellations as of yet. There is a shortage of some anaesthesia drugs but we are using their alternatives,” says Kanisha De Silva, consultant oncology surgeon at NCI. Shortages are worse in the other nine regional hospitals, he adds, and routine surgery had been cancel', '2022-10-16 12:18:50'),
(2, 'Ceylinco Healthcare surpasses 12,000 Radiation treatments  for cancer', 'imagen/f390a1f88771312357893090a6c9c054Screenshot_20200927-150445_Chrome.jpg', 'Sri Lanka’s pioneer private sector cancer treatment provider Ceylinco Healthcare Services Ltd. (CHSL) has announced it has crossed the milestone of treating 12,000 cancer patients via a combination of cutting-edge radiation therapy and other forms of treatments.\r\n\r\nThis milestone in care was reached in September 2021; 14 years after CHSL introduced radiation treatment via Linear Accelerator to Sri Lanka, enabling patients to receive the treatment they required without having to travel overseas.\r', '2022-10-16 12:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `organ`
--

CREATE TABLE `organ` (
  `id` int(11) NOT NULL,
  `salon_id` varchar(20) NOT NULL,
  `f_name` varchar(20) NOT NULL,
  `l_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` int(20) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `date` date DEFAULT current_timestamp(),
  `request` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organ`
--

INSERT INTO `organ` (`id`, `salon_id`, `f_name`, `l_name`, `email`, `contact`, `nic`, `dob`, `gender`, `date`, `request`) VALUES
(1, '1', 'Lakshitha', 'Nirmal', 'sanjubalasuriya2@gmail.com', 772014795, '971711671v', '2022-10-21', 'Male', '2022-10-16', 'sent'),
(2, '1', 'Sanju', 'Balasuriya', 'sanjubalasuriya2@gmail.com', 772014795, '971711671v', '2022-09-28', 'Male', '2022-10-16', 'pending'),
(3, '1', 'Saman', 'Perera', 'sanjubalasuriya2@gmail.com', 772014795, '951711671v', '2022-10-04', 'Male', '2022-10-16', 'pending'),
(4, '1', 'Ranjith', 'Chamara', 'sanjubalasuriya2@gmail.com', 772014795, '971711671v', '2022-10-17', 'Male', '2022-10-16', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(100) NOT NULL,
  `p_id` varchar(20) NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `l_name` varchar(100) NOT NULL,
  `nic` varchar(100) NOT NULL,
  `contact` int(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(100) NOT NULL,
  `cancer` varchar(100) NOT NULL,
  `c_step` varchar(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `donate` int(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `p_id`, `f_name`, `l_name`, `nic`, `contact`, `email`, `dob`, `gender`, `cancer`, `c_step`, `amount`, `donate`, `address`, `image`, `date`) VALUES
(1, 'P1', 'Kumarasiri', 'Pathirana', '901711671v', 772014795, 'sanjubalasuriya2@gmail.com', '2022-10-06', 'Male', 'Colon and Rectal Cancer', 'Level 1', 5000000, 120000, '23, Dematagoda', 'image/0c720c58e11ea820309be29248784130172522ec1028ab781d9dfd17eaca4427.jpg', '2022-09-05 11:21:40'),
(2, 'P2', 'Ranjith', 'Chamara', '951711671v', 772014795, 'sanjubalasuriya02@gmail.com', '1997-06-05', 'Male', 'Lung Cancer', 'Level 1', 4000000, 0, '87, Ragama', 'image/cc182fc0bf2825258f0fe6215b0f3a6fimages (2).jpg', '2022-10-16 11:23:03'),
(3, 'P3', 'Ranjith', 'Chamara', '951711671v', 772014795, 'sanjubalasuriya2@gmail.com', '1995-03-02', 'Male', 'Lung Cancer', 'Level 2', 900000, 0, '34 Nawala', 'image/3b7198c7cc053965c378e030b0fe9824mike.jpeg', '2022-10-16 12:49:52'),
(4, 'P4', 'Ishara', 'Perera', '951711671v', 772014795, 'sanjubalasuriya02@gmail.com', '1996-08-16', 'Male', 'Melanoma', 'Level 3', 600000, 0, '45 Kiridiwala', 'image/81cfbb0e4cecf801046c9f383861ab22photo-1570295999919-56ceb5ecca61.jpg', '2022-10-16 12:50:57'),
(5, 'P5', 'Thilina', 'Sadaruwan', '891711671v', 772014795, 'sanjubalasuriya@gmail.com', '1999-03-05', 'Male', 'Non-Hodgkin Lymphoma', 'Level 2', 1300000, 0, '56 Mirigama', 'image/32bfe150fa74e7627ef69d900d91eeeaphoto-1633332755192-727a05c4013d.jpg', '2022-10-16 12:52:08'),
(6, 'P6', 'Amali', 'Perera', '951711671v', 772014795, 'sanjubalasuriya2@gmail.com', '1983-07-14', 'Female', 'Bone marrow cancer', 'Level 1', 1120000, 0, '89, Thabuththegama', 'image/a26bf72df99a2cd0187335f2c933ff09alex-herbert.jpg', '2022-10-16 12:53:59'),
(7, 'P7', 'Sithum', 'Siriwardhana', '911711671v', 772014795, 'sanjubalasuriya02@gmail.com', '1996-08-25', 'Male', 'Non-Hodgkin Lymphoma', 'Level 3', 5000000, 0, '09, Dompe', 'image/62247fa3034aeaa2e62d7ff720a9dd95images (2).jpg', '2022-10-16 12:59:19'),
(8, 'P8', 'Charith', 'Asalanka', '901711671v', 772014795, 'sanjubalasuriya02@gmail.com', '2022-10-15', 'Male', 'Lung Cancer', 'Level 1', 5000000, 0, '45 Gampaha', 'image/ee6a0b60dab74e96f4b0295aac1596eephoto-1570295999919-56ceb5ecca61.jpg', '2022-10-16 13:22:38'),
(9, 'P9', 'Sanju', 'Balasuriya', '901711671v', 772014795, 'sanjubalasuriya2@gmail.com', '2022-10-06', 'Male', 'Breast Cancer', 'Level 1', 5000000, 0, '123 Gampaha', 'image/27eb8206e20a1d9846b6a547d580a732images (2).jpg', '2022-10-16 14:23:10');

-- --------------------------------------------------------

--
-- Table structure for table `salons`
--

CREATE TABLE `salons` (
  `id` int(11) NOT NULL,
  `s_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `lat` varchar(50) NOT NULL,
  `lng` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `lisence` int(20) NOT NULL,
  `contact` int(10) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salons`
--

INSERT INTO `salons` (`id`, `s_id`, `name`, `address`, `lat`, `lng`, `email`, `lisence`, `contact`, `date`) VALUES
(2, 'SL_1', 'Champi Siriwrdana Salon', '123 Nittambuwa', '7.134047', '80.087400', 'sanjubalasuriya2@gmail.com', 767567, 772014795, '2022-10-16'),
(3, 'SL_2', 'Premasiri Hewawasam Salon', '45, Nugegoda', '6.845418', '79.938790', 'sanjubalasuriya2@gmail.com', 345345, 772014795, '2022-10-16'),
(4, 'SL_3', 'Ramzis Hair & Beauty Salons', '56, Dalupotha', '6.871200', '79.885661', 'sanjubalasuriya2@gmail.com', 767567, 772014795, '2022-10-16'),
(5, 'SL_4', 'Diamond', '12 Gampaha', '7.127241', '80.072846', 'sanjubalasuriya2@gmail.com', 767567, 772014795, '2022-10-16');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `id` int(11) NOT NULL,
  `s_id` varchar(11) NOT NULL,
  `f_name` varchar(20) NOT NULL,
  `l_name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` int(20) NOT NULL,
  `company` varchar(50) NOT NULL,
  `image` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`id`, `s_id`, `f_name`, `l_name`, `email`, `contact`, `company`, `image`, `date`) VALUES
(1, 'S1', 'Tharindu', 'Madushan', 'sanjubalasuriya2@gmail.com', 772014795, 'Keells PVT', 'image/95e72090b3d56a19283ae89206da2c97keellslogo.png', '2022-10-16 10:25:09'),
(2, 'S2', 'Chanuka', 'Anuruddha', 'sanjubalasuriya2@gmail.com', 772014795, 'Cargills PVT', 'images/ae906fa1257f078078211047dd067a4cfoodcity-logo.png', '2022-10-16 10:29:49'),
(3, 'S3', 'Lakshitha', 'Nirmal', 'sanjubalasuriya2@gmail.com', 772014795, 'KFC', 'images/8cad92e3758540639bec6d4984a67e47camera-kfc-png-logo-0.png', '2022-10-16 10:30:24'),
(4, 'S4', 'Lakruwan', 'Senadheera', 'sanjubalasuriya2@gmail.com', 772014795, 'Cocacola', 'images/b21064d9bf3df1b1dd29eda734e68fcdcoke-logo.png', '2022-10-16 10:31:30'),
(5, 'S5', 'Shenal', 'Chanuka', 'shenalchanuka@gmail.com', 772014795, 'MD', 'images/9733bb36eaf7e2f10dc4742d0dfa81d2MD-3D-Logo-01.png', '2022-10-16 10:32:24'),
(6, 'S6', 'SIthara', 'Dasun', 'sitharadasun@gmail.com', 772014795, 'ODEL', 'images/af74861fa07882eaf2835970472d83d6odel.webp', '2022-10-16 10:33:47'),
(7, 'S7', 'Ranjith', 'Chamara', 'sanjubalasuriya2@gmail.com', 772014795, 'Keells PVT', 'images/26cb01d3b4287c2bc6452063ee07ca89keellslogo.png', '2022-10-16 14:25:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cancers`
--
ALTER TABLE `cancers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organ`
--
ALTER TABLE `organ`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salons`
--
ALTER TABLE `salons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cancers`
--
ALTER TABLE `cancers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `organ`
--
ALTER TABLE `organ`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `salons`
--
ALTER TABLE `salons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
