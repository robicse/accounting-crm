-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 13, 2021 at 03:45 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clean_tech_engineering`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `party_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HeadCode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HeadName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PHeadName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BankUserAccount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HeadLevel` int(11) DEFAULT NULL,
  `IsActive` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsTransaction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsGL` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HeadType` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreateBy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `UpdateBy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `party_id`, `HeadCode`, `HeadName`, `PHeadName`, `BankUserAccount`, `HeadLevel`, `IsActive`, `IsTransaction`, `IsGL`, `HeadType`, `CreateBy`, `UpdateBy`, `created_at`, `updated_at`) VALUES
(10, NULL, '1', 'Assets', 'COA', '', 0, '1', '1', '1', 'A', '', '', '2019-08-19 09:42:14', '2020-11-19 11:16:06'),
(58, NULL, '2', 'Equity', 'COA', '', 0, '1', '0', '0', 'L', '', '', '2019-08-19 09:42:14', '2019-08-19 09:42:14'),
(59, NULL, '4', 'Expense', 'COA', '', 0, '1', '0', '1', 'E', '', '', '2019-10-25 23:48:28', '2020-11-19 13:27:06'),
(80, NULL, '3', 'Income', 'COA', '', 0, '1', '1', '1', 'I', '', '', '2019-10-17 21:05:53', '2021-03-03 23:50:12'),
(90, NULL, '5', 'Liabilities', 'COA', '', 0, '1', '0', '1', 'L', 'admin', 'admin', '2019-08-19 09:42:14', '2020-11-19 15:44:53'),
(325, NULL, '101', 'Non-Current Assets', 'Assets', '', 1, '1', '0', '1', 'A', '1', '1', '2020-11-18 04:33:00', '2020-12-24 16:28:41'),
(326, NULL, '102', 'Current Asset', 'Assets', NULL, 1, '1', '0', '1', 'A', '1', '1', '2020-11-18 15:47:16', '2020-11-18 15:47:16'),
(327, NULL, '10201', 'Cash in Hand', 'Current Asset', '', 2, '1', '1', '1', 'A', '1', '1', '2020-11-18 15:53:48', '2021-03-04 00:21:35'),
(328, NULL, '10202', 'Cash at Bank', 'Current Asset', NULL, 2, '1', '0', '1', 'A', '1', '1', '2020-11-18 15:54:59', '2020-11-18 15:54:59'),
(329, NULL, '10203', 'Account Receivable', 'Current Asset', NULL, 2, '1', '0', '1', 'A', '1', '1', '2020-11-18 15:55:26', '2020-11-18 15:55:26'),
(330, NULL, '501', 'Current Liabilities', 'Liabilities', NULL, 1, '1', '0', '1', 'L', '1', '1', '2020-11-18 15:56:26', '2020-11-18 15:56:26'),
(331, NULL, '6', 'Drawings', 'COA', '', 0, '1', '0', '0', 'L', 'admin', 'admin', '2019-08-19 09:42:14', '2019-08-19 09:42:14'),
(332, NULL, '50101', 'Accounts Payable', 'Current Liabilities', NULL, 2, '1', '0', '1', 'L', '1', '1', '2020-11-18 15:56:54', '2020-11-18 15:56:54'),
(333, NULL, '502', 'Non-Current Liabilities', 'Liabilities', NULL, 1, '1', '0', '1', 'L', '1', '1', '2020-11-18 15:57:21', '2020-11-18 15:57:21'),
(334, NULL, '401', 'Office Expenses', 'Expense', '', 1, '1', '1', '1', 'E', '1', '1', '2020-11-18 16:15:50', '2021-03-04 00:26:07'),
(338, NULL, '301', 'Revenue From Operation', 'Income', NULL, 1, '1', '0', '1', 'I', '1', '1', '2020-11-18 16:46:57', '2020-11-18 16:46:57'),
(347, NULL, '302', 'Other Income', 'Income', NULL, 1, '1', '1', '1', 'I', '1', '1', '2020-11-18 16:52:36', '2020-11-18 16:52:36'),
(364, NULL, '10206', 'Inventories', 'Current Asset', NULL, 2, '1', '0', '1', 'A', '1', '1', '2020-12-24 15:04:38', '2020-12-24 15:04:38'),
(395, '1', '1010301', 'Ashique-01703500587', 'Account Receivable', NULL, 3, '1', '1', '1', 'A', '1', '1', '2021-03-02 23:12:22', '2021-03-02 23:12:22'),
(396, '2', '1010302', 'momin-01703500588', 'Account Receivable', NULL, 3, '1', '1', '1', 'A', '1', '1', '2021-03-02 23:12:55', '2021-03-02 23:12:55'),
(397, '3', '1010302', 'Papon-01911866693', 'Account Receivable', NULL, 3, '1', '1', '1', 'A', '1', '1', '2021-03-27 16:23:19', '2021-03-27 16:23:19'),
(398, '4', '1010302', 'Toptech-01674888000', 'Account Receivable', NULL, 3, '1', '1', '1', 'A', '1', '1', '2021-03-27 16:24:48', '2021-03-27 16:24:48'),
(399, '5', '1010302', 'Sakib', 'Account Receivable', NULL, 3, '1', '1', '1', 'A', '1', '1', '2021-03-27 16:29:17', '2021-03-27 16:29:17'),
(400, '6', '1010302', 'Ayyat water-01819061204', 'Account Receivable', NULL, 3, '1', '1', '1', 'A', '1', '1', '2021-03-27 16:38:43', '2021-03-27 16:38:43'),
(401, '7', '1010302', 'Farazi tech-01916825410', 'Account Receivable', NULL, 3, '1', '1', '1', 'A', '1', '1', '2021-03-27 16:43:38', '2021-03-27 16:43:38'),
(402, '8', '1010302', 'Sharif', 'Account Receivable', NULL, 3, '1', '1', '1', 'A', '1', '1', '2021-03-28 23:51:02', '2021-03-28 23:51:02'),
(403, NULL, '1010302', 'pinky', 'Account Receivable', NULL, 3, '1', '1', '1', 'A', '1', '1', '2021-04-07 03:10:32', '2021-04-07 03:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_accounts`
--

CREATE TABLE `chart_of_accounts` (
  `id` bigint(191) UNSIGNED NOT NULL,
  `group_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chart_of_accounts`
--

INSERT INTO `chart_of_accounts` (`id`, `group_1`, `group_2`, `group_3`, `group_4`, `status`, `head_type`, `created_at`, `updated_at`) VALUES
(1, 'Assets', 'Current Assets', 'Cash in Hand', NULL, '1', 'A', '2021-03-14 11:25:24.000000', '2021-03-14 11:25:24.000000'),
(2, 'Assets', 'Current Assets', 'Cash at Bank', 'Savings & Current A/C', '1', 'A', '2021-03-14 11:27:41.000000', '2021-03-14 11:27:41.000000'),
(3, 'Assets', 'Current Assets', 'Cash at Bank(FDR)', 'FDR', '1', 'A', '2021-03-14 11:31:57.000000', '2021-03-14 11:31:57.000000'),
(4, 'Assets', 'Current Assets', 'Loans & Advances(AOR)', 'Advanced office rent', '1', 'A', '2021-03-14 11:32:30.000000', '2021-03-14 11:37:34.000000'),
(5, 'Assets', 'Current Assets', 'Loans & Advances(AAP)', 'Advanced Againts Purchase', '1', 'A', '2021-03-14 11:38:18.000000', '2021-03-14 11:38:18.000000'),
(6, 'Assets', 'Current Assets', 'Loans & Advances(AAS)', 'Advanced Againts Salary', '1', 'A', '2021-03-14 11:39:02.000000', '2021-03-14 11:39:02.000000'),
(7, 'Assets', 'Current Assets', 'Loans & Advances', 'Loan To Owner', '1', 'A', '2021-03-14 11:39:27.000000', '2021-03-14 11:39:27.000000'),
(8, 'Equity', 'Capital & Equity', 'Capital Account', NULL, '1', 'E', '2021-03-14 11:40:51.000000', '2021-03-14 11:40:51.000000'),
(9, 'Current Liabilities', 'Current Liabilities', 'Loan From Owners', NULL, '1', 'L', '2021-03-14 11:42:04.000000', '2021-03-14 11:42:04.000000'),
(10, 'Current Liabilities', 'Current Liabilities', 'Loan From Other', 'Short Term Loan', '1', 'L', '2021-03-14 11:43:25.000000', '2021-03-14 11:43:25.000000'),
(11, 'Current Liabilities', 'Current Liabilities', 'Advanced Received Against Sales', NULL, '1', 'L', '2021-03-14 11:44:23.000000', '2021-03-14 11:44:23.000000'),
(12, 'Income', 'Revenue Account', 'Received againts Sales', NULL, '1', 'I', '2021-03-22 10:18:25.725818', '2021-03-14 11:45:42.000000'),
(13, 'Income', 'Revenue Account', 'Received againts Services', NULL, '1', 'I', '2021-03-22 10:17:48.422297', '2021-03-14 11:46:14.000000'),
(14, 'Expense', 'Direct Expenses', 'Purchase Account', NULL, '1', 'Ex', '2021-03-14 11:48:09.000000', '2021-03-14 11:48:09.000000'),
(15, 'Expense', 'Direct Expenses', 'Product Installation', NULL, '1', 'Ex', '2021-03-14 11:48:51.000000', '2021-03-14 11:48:51.000000'),
(16, 'Expense', 'Direct Expenses', 'Service Expenses', NULL, '1', 'Ex', '2021-03-14 11:49:17.000000', '2021-03-14 11:49:17.000000'),
(17, 'Expense', 'Direct Expenses', 'Carrying Expenses', NULL, '1', 'Ex', '2021-03-14 11:50:03.000000', '2021-03-14 11:50:03.000000'),
(18, 'Expense', 'Direct Expenses', 'Godwon & Storage', NULL, '1', 'Ex', '2021-03-23 19:11:25.816446', '2021-03-14 11:50:37.000000'),
(19, 'Expense', 'Indirect Expenses', 'Admin Expense', NULL, '1', 'Ex', '2021-03-14 11:51:07.000000', '2021-03-14 11:51:07.000000'),
(20, 'Expense', 'Indirect Expenses', 'Selling & MKT Expense(Com/Ins)', 'Sales Commission / incentive Expenses', '1', 'Ex', '2021-03-23 19:18:20.706057', '2021-03-14 11:58:26.000000'),
(21, 'Expense', 'Indirect Expenses', 'Selling & MKT Expense', NULL, '1', 'Ex', '2021-03-22 10:19:42.885352', '2021-03-14 11:59:19.000000'),
(22, 'Expense', 'Indirect Expenses', 'Finance Charges', NULL, '1', 'Ex', '2021-03-14 11:59:45.000000', '2021-03-14 11:59:45.000000'),
(23, 'Expense', 'Indirect Expenses', 'Finance Expenses', NULL, '1', 'Ex', '2021-03-14 12:00:31.000000', '2021-03-14 12:00:31.000000'),
(24, 'Assets', 'Fixed Asset', 'Tangible Assets(Plant & Machinery)', 'Plant & Machinery', '1', 'A', '2021-03-14 12:01:43.000000', '2021-03-14 12:01:43.000000'),
(25, 'Assets', 'Fixed Asset', 'Tangible Assets(Furniture & Fixture)', 'Furniture & Fixture', '1', 'A', '2021-03-14 12:02:33.000000', '2021-03-14 12:02:33.000000'),
(26, 'Assets', 'Fixed Asset', 'Tangible Assets(Vehicle)', 'Vehicle', '1', 'A', '2021-03-14 12:03:01.000000', '2021-03-14 12:03:01.000000'),
(27, 'Assets', 'Fixed Asset', 'Tangible Assets', NULL, '1', 'A', '2021-03-14 12:03:26.000000', '2021-03-14 12:03:26.000000'),
(28, 'Assets', 'Fixed Asset', 'Intangible Assets', NULL, '1', 'A', '2021-03-14 12:04:01.000000', '2021-03-14 12:04:01.000000'),
(29, 'Assets', 'Current Assets', 'Inventory', NULL, '1', 'A', '2021-04-01 15:02:35.715452', '2021-04-01 15:02:35.715452'),
(30, 'Expense', 'Direct Expense', 'Miscellaneous Expense', NULL, '1', 'Ex', '2021-04-01 15:04:15.087244', '2021-04-01 15:04:15.087244'),
(31, 'Assets', 'Current Assets', 'Account Receivable', NULL, '1', 'A', '2021-04-01 15:04:48.176323', '2021-04-01 15:04:48.176323'),
(32, 'Current Liabilities', 'Current Liabilities', 'Accounts Payables', NULL, '1', 'L', '2021-04-01 15:14:41.314099', '2021-04-01 15:14:41.314099'),
(33, 'Equity', 'Capital & Equity', 'Drawings', NULL, '1', 'E', '2021-04-01 15:16:55.567289', '2021-04-01 15:16:55.567289');

-- --------------------------------------------------------

--
-- Table structure for table `customer_complains`
--

CREATE TABLE `customer_complains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_complains`
--

INSERT INTO `customer_complains` (`id`, `date`, `name`, `phone`, `address`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, '2021-02-18', 'Md.Monirul Islam', '01711991851', 'Mirpur', 'Panite gondho ase', 'complete', '2021-02-19 00:52:33', '2021-03-31 18:55:50');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_services`
--

CREATE TABLE `delivery_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_services`
--

INSERT INTO `delivery_services` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Sundorban Curiar Services', 'sundorban-curiar-services', '2020-11-09 00:55:43', '2020-12-18 17:14:56'),
(2, 'Redx', 'redx', '2021-04-05 05:36:18', '2021-04-05 05:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `dues`
--

CREATE TABLE `dues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `party_id` bigint(20) UNSIGNED NOT NULL,
  `payment_type` enum('cash','check') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` double(8,2) NOT NULL,
  `paid_amount` double(8,2) NOT NULL,
  `due_amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dues`
--

INSERT INTO `dues` (`id`, `invoice_no`, `ref_id`, `user_id`, `store_id`, `party_id`, `payment_type`, `check_number`, `total_amount`, `paid_amount`, `due_amount`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, 1, 5, NULL, NULL, 2000.00, 1000.00, 1000.00, '2021-04-06 03:14:24', '2021-04-06 09:54:19'),
(2, '1000', 1, 1, 1, 5, NULL, NULL, 2000.00, 2000.00, 0.00, '2021-04-06 03:21:46', '2021-04-06 03:21:46'),
(3, '1001', 2, 1, 1, 3, NULL, NULL, 1000.00, 1000.00, 0.00, '2021-04-07 11:26:48', '2021-04-07 11:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `office_costing_category_id` bigint(20) UNSIGNED NOT NULL,
  `payment_type` enum('Cash','Check') COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(8,2) NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `free_products`
--

CREATE TABLE `free_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'product.jpg',
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `free_product_sale_details`
--

CREATE TABLE `free_product_sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `free_product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `free_product_sale_details`
--

INSERT INTO `free_product_sale_details` (`id`, `product_sale_id`, `free_product_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2021-03-02 23:13:51', '2021-03-02 23:13:51'),
(2, 2, NULL, '2021-03-02 23:14:25', '2021-03-02 23:14:25'),
(3, 3, NULL, '2021-03-03 22:40:42', '2021-03-03 22:40:42'),
(4, 4, NULL, '2021-03-23 19:12:59', '2021-03-23 19:12:59'),
(5, 5, NULL, '2021-03-23 19:16:27', '2021-03-23 19:16:27'),
(6, 6, NULL, '2021-03-28 17:28:43', '2021-03-28 17:28:43'),
(7, 7, NULL, '2021-03-28 17:30:16', '2021-03-28 17:30:16'),
(8, 8, NULL, '2021-03-28 17:53:43', '2021-03-28 17:53:43'),
(9, 1, NULL, '2021-03-31 20:16:14', '2021-03-31 20:16:14'),
(10, 2, NULL, '2021-04-05 08:25:54', '2021-04-05 08:25:54'),
(11, 3, NULL, '2021-04-05 08:45:34', '2021-04-05 08:45:34'),
(12, 1, NULL, '2021-04-06 03:21:46', '2021-04-06 03:21:46'),
(13, 2, NULL, '2021-04-07 11:26:48', '2021-04-07 11:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `ledgers`
--

CREATE TABLE `ledgers` (
  `id` bigint(191) UNSIGNED NOT NULL,
  `chart_of_account_id` bigint(191) UNSIGNED DEFAULT NULL,
  `name` varchar(194) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ledgers`
--

INSERT INTO `ledgers` (`id`, `chart_of_account_id`, `name`, `created_at`, `updated_at`) VALUES
(10, 1, 'petty cash', '2021-03-15 14:31:10.000000', '2021-03-15 14:31:10.000000'),
(11, 2, 'name of bank', '2021-03-15 14:31:10.000000', '2021-03-16 09:16:09.000000'),
(12, 3, 'dbbl', '2021-03-15 14:31:10.000000', '2021-03-15 14:31:10.000000'),
(13, 4, 'advanced office rent', '2021-03-15 14:31:10.000000', '2021-03-15 14:31:10.000000'),
(14, 5, 'suppliers name', '2021-03-15 14:31:10.000000', '2021-03-15 14:31:10.000000'),
(15, 6, 'employee name', '2021-03-15 14:31:10.000000', '2021-03-15 14:31:10.000000'),
(16, 7, 'owners name', '2021-03-15 14:31:58.000000', '2021-03-15 14:31:58.000000'),
(17, 8, 'owners name rafel', '2021-03-15 14:31:58.000000', '2021-03-15 14:31:58.000000'),
(18, 24, 'machinery', '2021-03-21 18:55:29.000000', '2021-03-21 18:55:29.000000'),
(19, 25, 'furniture', '2021-03-21 18:55:29.000000', '2021-03-21 18:55:29.000000'),
(20, 26, 'Car', '2021-03-21 18:55:29.000000', '2021-03-21 18:55:29.000000'),
(21, 27, 'buying  food', '2021-03-21 18:55:29.000000', '2021-03-21 18:55:29.000000'),
(22, 9, 'loan for purchase purpose', '2021-03-22 16:58:02.702285', '2021-03-22 16:58:02.702285'),
(23, 10, 'loan for purchase goods', '2021-03-22 16:58:02.706353', '2021-03-22 16:58:02.706353'),
(24, 11, 'receice from hasan fashion', '2021-03-22 16:58:02.708632', '2021-03-22 16:58:02.708632'),
(25, 14, 'Supplier', '2021-03-22 19:43:29.105692', '2021-03-22 19:43:29.105692'),
(26, 12, 'Retail Sales', '2021-03-22 19:45:07.823052', '2021-03-22 19:45:07.823052'),
(27, 19, 'Salary Expenses', '2021-03-22 20:11:15.149104', '2021-03-22 20:11:15.149104'),
(28, 20, 'Commission', '2021-03-22 20:22:18.361771', '2021-03-22 20:22:18.361771'),
(29, 13, 'Hasan & Co.', '2021-03-24 20:17:33.961559', '2021-03-24 20:17:33.961559'),
(30, 5, 'Zakir & Sons', '2021-03-24 21:08:30.753187', '2021-03-24 21:08:30.753187'),
(31, 15, 'Mridul & Co.', '2021-03-24 21:08:30.776911', '2021-03-24 21:08:30.776911'),
(32, 16, 'Jakaria & Co.', '2021-03-24 21:08:30.811996', '2021-03-24 21:08:30.811996'),
(33, 17, 'Product Delivery Charge', '2021-03-24 21:08:30.820298', '2021-03-24 21:08:30.820298'),
(34, 17, 'Carrying Expenses', '2021-03-24 21:08:30.844257', '2021-03-24 21:08:30.844257'),
(35, 18, 'Ware House Rent', '2021-03-24 21:08:30.855602', '2021-03-24 21:08:30.855602'),
(36, 21, 'Promotional Exp', '2021-03-24 21:33:22.805925', '2021-03-24 21:33:22.805925'),
(37, 21, 'Website Renewals', '2021-03-24 21:33:22.808972', '2021-03-24 21:33:22.808972'),
(38, 27, 'AC', '2021-03-24 21:45:50.945961', '2021-03-24 21:45:50.945961'),
(39, 26, 'Motor Car', '2021-03-24 21:45:50.948926', '2021-03-24 21:45:50.948926'),
(40, 24, 'Plant & Machinery-FA', '2021-03-24 22:33:07.449940', '2021-03-24 22:33:07.449940'),
(41, 22, 'Bank Charge', '2021-03-24 22:33:07.456632', '2021-03-24 22:33:07.456632'),
(42, 23, 'Interest Expense', '2021-03-24 22:33:07.463228', '2021-03-24 22:33:07.463228'),
(43, 10, 'Zakir & Sons', '2021-03-24 22:33:41.356410', '2021-03-24 22:33:41.356410'),
(44, 8, 'MR.x', '2021-03-29 20:44:28.851967', '2021-03-29 20:44:28.851967'),
(45, 2, 'City Bank', '2021-03-31 06:25:35.890730', '2021-03-31 06:25:35.890730');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_17_064316_create_permission_tables', 1),
(4, '2020_08_23_175830_create_stores_table', 2),
(5, '2020_09_08_072444_create_product_categories_table', 3),
(6, '2020_09_08_072634_create_product_sub_categories_table', 4),
(7, '2020_09_08_072804_create_product_brands_table', 5),
(8, '2020_09_08_072952_create_products_table', 6),
(9, '2020_09_08_073143_create_parties_table', 7),
(10, '2020_09_08_073313_create_product_purchases_table', 8),
(11, '2020_09_08_073602_create_product_purchase_details_table', 9),
(12, '2020_09_08_073736_create_transactions_table', 10),
(13, '2020_09_08_074003_create_stocks_table', 11),
(14, '2020_09_08_074332_create_product_sales_table', 12),
(15, '2020_09_08_074534_create_product_sale_details_table', 13),
(16, '2020_09_08_074822_create_product_sale_returns_table', 14),
(17, '2020_09_08_075008_create_product_sale_return_details_table', 15),
(18, '2020_09_12_151457_create_dues_table', 16),
(19, '2020_09_30_100308_create_office_costing_categories_table', 17),
(20, '2020_10_06_053604_create_expenses_table', 18),
(21, '2020_10_13_085434_create_product_productions_table', 19),
(22, '2020_10_13_090352_create_product_production_details_table', 19),
(23, '2020_11_29_212548_create_product_units_table', 19),
(26, '2020_12_07_155501_create_product_sale_replacements_table', 20),
(27, '2020_12_08_102504_create_product_sale_replacement_details_table', 20);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 5),
(2, 'App\\User', 7),
(2, 'App\\User', 8),
(2, 'App\\User', 9),
(2, 'App\\User', 10),
(2, 'App\\User', 11),
(3, 'App\\User', 4),
(4, 'App\\User', 3),
(3, 'App\\User', 17),
(2, 'App\\User', 18),
(2, 'App\\User', 19),
(2, 'App\\User', 29),
(2, 'App\\User', 30),
(2, 'App\\User', 31),
(2, 'App\\User', 32),
(2, 'App\\User', 33),
(2, 'App\\User', 34),
(2, 'App\\User', 35),
(2, 'App\\User', 36),
(2, 'App\\User', 37),
(2, 'App\\User', 38),
(2, 'App\\User', 39),
(1, 'App\\User', 1),
(2, 'App\\User', 5),
(2, 'App\\User', 7),
(2, 'App\\User', 8),
(2, 'App\\User', 9),
(2, 'App\\User', 10),
(2, 'App\\User', 11),
(3, 'App\\User', 4),
(4, 'App\\User', 3),
(3, 'App\\User', 17),
(2, 'App\\User', 18),
(2, 'App\\User', 19),
(2, 'App\\User', 29),
(2, 'App\\User', 30),
(2, 'App\\User', 31),
(2, 'App\\User', 32),
(2, 'App\\User', 33),
(2, 'App\\User', 34),
(2, 'App\\User', 35),
(2, 'App\\User', 36),
(2, 'App\\User', 37),
(2, 'App\\User', 38),
(2, 'App\\User', 39),
(2, 'App\\User', 40),
(2, 'App\\User', 41),
(3, 'App\\User', 42),
(4, 'App\\User', 43),
(2, 'App\\User', 44);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'offer.jpg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, '10% Offer', '2021-02-18-602e1742b3a2b.png', '2021-02-18 18:29:06', '2021-02-18 18:29:06');

-- --------------------------------------------------------

--
-- Table structure for table `office_costing_categories`
--

CREATE TABLE `office_costing_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `office_costing_categories`
--

INSERT INTO `office_costing_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Salary', 'salary', '2021-02-20 00:38:11', '2021-02-20 00:38:11');

-- --------------------------------------------------------

--
-- Table structure for table `online_platforms`
--

CREATE TABLE `online_platforms` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `online_platforms`
--

INSERT INTO `online_platforms` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Daraz', '2021-02-17 00:35:30', '2021-02-17 00:35:30'),
(2, 'Evaly', '2021-02-17 00:35:41', '2021-02-17 00:35:41'),
(3, 'Othoba.com', '2021-02-17 00:36:07', '2021-02-17 00:36:07'),
(4, 'Dhamaka Shopping', '2021-02-17 00:37:01', '2021-02-17 00:37:01');

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('supplier','customer','own') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `type`, `name`, `phone`, `email`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 'customer', 'Ashique', '01703500587', 'ashiq.starit@gmail.com', 'kallyanpur', 1, '2021-03-02 23:12:22', '2021-03-02 23:12:22'),
(2, 'supplier', 'momin', '01703500588', 'momin@gmail.com', 'kallyanpur,dhaka', 1, '2021-03-02 23:12:55', '2021-03-02 23:12:55'),
(3, 'customer', 'Papon', '01911866693', NULL, NULL, 1, '2021-03-27 16:23:19', '2021-03-27 16:23:19'),
(4, 'supplier', 'Toptech', '01674888000', NULL, NULL, 1, '2021-03-27 16:24:48', '2021-03-27 16:24:48'),
(5, 'customer', 'Sakib', '01911265470', NULL, NULL, 1, '2021-03-27 16:29:17', '2021-03-27 16:29:17'),
(6, 'own', 'Ayyat water', '01819061204', NULL, NULL, 1, '2021-03-27 16:38:43', '2021-03-27 16:38:43'),
(7, 'own', 'Farazi Tech Wh', '01916825410', NULL, NULL, 1, '2021-03-27 16:43:38', '2021-03-29 18:33:51'),
(8, 'customer', 'Sharif', '01701666602', NULL, NULL, 1, '2021-03-28 23:51:02', '2021-03-28 23:51:02'),
(13, 'customer', 'pinky', '1703500587', 'ashiq.starit@gmail.com', 'kallyanpur', 1, '2021-04-07 03:10:32', '2021-04-07 03:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `controller_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `controller_name`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'RoleController', 'role-list', 'web', '2019-08-17 08:33:07', '2019-08-17 08:33:07'),
(2, 'RoleController', 'role-create', 'web', '2019-08-17 08:33:07', '2019-08-17 08:33:07'),
(3, 'RoleController', 'role-edit', 'web', '2019-08-17 08:33:07', '2019-08-17 08:33:07'),
(4, 'RoleController', 'role-delete', 'web', '2019-08-17 08:33:07', '2019-08-17 08:33:07'),
(5, 'UserController', 'user-list', 'web', '2019-08-17 08:33:07', '2019-08-17 08:33:07'),
(6, 'UserController', 'user-create', 'web', '2019-08-17 08:33:07', '2019-08-17 08:33:07'),
(7, 'UserController', 'user-edit', 'web', '2019-08-17 08:33:07', '2019-08-17 08:33:07'),
(8, 'UserController', 'user-delete', 'web', '2019-08-17 08:33:07', '2019-08-17 08:33:07'),
(9, 'StoreController', 'store-list', 'web', '2020-08-25 06:13:47', '2020-08-25 06:13:47'),
(10, 'StoreController', 'store-create', 'web', '2020-08-25 06:33:46', '2020-08-25 06:33:46'),
(11, 'StoreController', 'store-edit', 'web', '2020-08-25 06:34:38', '2020-08-25 06:34:38'),
(12, 'StoreController', 'store-delete', 'web', '2020-08-25 06:34:55', '2020-08-25 06:34:55'),
(13, 'ProductController', 'product-category-list', 'web', '2020-08-25 06:35:57', '2020-08-25 06:35:57'),
(14, 'ProductController', 'product-category-create', 'web', '2020-08-25 06:36:11', '2020-08-25 06:36:11'),
(15, 'ProductController', 'product-category-edit', 'web', '2020-08-25 06:36:38', '2020-08-25 06:36:38'),
(16, 'ProductController', 'product-category-delete', 'web', '2020-08-25 06:36:53', '2020-08-25 06:36:53'),
(17, 'ProductSubCategoryController', 'product-sub-category-list', 'web', '2020-08-25 06:37:25', '2020-08-25 06:37:25'),
(18, 'ProductSubCategoryController', 'product-sub-category-create', 'web', '2020-08-25 06:38:30', '2020-08-25 06:38:30'),
(19, 'ProductSubCategoryController', 'product-sub-category-edit', 'web', '2020-08-25 06:38:41', '2020-08-25 06:38:41'),
(20, 'ProductSubCategoryController', 'product-sub-category-delete', 'web', '2020-08-25 06:38:53', '2020-08-25 06:38:53'),
(21, 'ProductBrandController', 'product-brand-list', 'web', '2020-08-25 07:22:37', '2020-08-25 07:22:37'),
(22, 'ProductBrandController', 'product-brand-create', 'web', '2020-08-25 07:22:49', '2020-08-25 07:22:49'),
(23, 'ProductBrandController', 'product-brand-edit', 'web', '2020-08-25 07:23:00', '2020-08-25 07:23:00'),
(24, 'ProductBrandController', 'product-brand-delete', 'web', '2020-08-25 07:23:11', '2020-08-25 07:23:11'),
(25, 'ProductController', 'product-list', 'web', '2020-08-25 09:30:52', '2020-08-25 09:30:52'),
(26, 'ProductController', 'product-create', 'web', '2020-08-25 09:31:05', '2020-08-25 09:31:05'),
(27, 'ProductController', 'product-edit', 'web', '2020-08-25 09:31:17', '2020-08-25 09:31:17'),
(28, 'ProductController', 'product-delete', 'web', '2020-08-25 09:31:32', '2020-08-25 09:31:32'),
(29, 'PartyController', 'party-list', 'web', '2020-09-10 02:15:23', '2020-09-10 02:15:23'),
(30, 'PartyController', 'party-create', 'web', '2020-09-10 02:15:49', '2020-09-10 02:15:49'),
(31, 'PartyController', 'party-edit', 'web', '2020-09-10 02:16:09', '2020-09-10 02:16:09'),
(32, 'PartyController', 'party-delete', 'web', '2020-09-10 02:16:30', '2020-09-10 02:16:30'),
(33, 'ProductPurchaseController', 'product-purchase-list', 'web', '2020-09-10 02:17:24', '2020-09-10 02:17:24'),
(34, 'ProductPurchaseController', 'product-purchase-create', 'web', '2020-09-10 02:17:52', '2020-09-10 02:17:52'),
(35, 'ProductPurchaseController', 'product-purchase-edit', 'web', '2020-09-10 02:18:15', '2020-09-10 02:18:15'),
(36, 'ProductPurchaseController', 'product-purchase-delete', 'web', '2020-09-10 02:18:36', '2020-09-10 02:18:36'),
(37, 'ProductSaleController', 'product-sale-list', 'web', '2020-09-10 02:19:33', '2020-09-10 02:19:33'),
(38, 'ProductSaleController', 'product-sale-create', 'web', '2020-09-10 02:19:57', '2020-09-10 02:19:57'),
(39, 'ProductSaleController', 'product-sale-edit', 'web', '2020-09-10 02:20:16', '2020-09-10 02:20:16'),
(40, 'ProductSaleController', 'product-sale-delete', 'web', '2020-09-10 02:20:34', '2020-09-10 02:20:34'),
(41, 'ProductSaleReturnController', 'product-sale-return-list', 'web', '2020-09-10 02:21:15', '2020-09-10 02:21:15'),
(42, 'ProductSaleReturnController', 'product-sale-return-create', 'web', '2020-09-10 02:21:29', '2020-09-10 02:21:29'),
(43, 'ProductSaleReturnController', 'product-sale-return-edit', 'web', '2020-09-10 02:21:41', '2020-09-10 02:21:41'),
(44, 'ProductSaleReturnController', 'product-sale-return-delete', 'web', '2020-09-10 02:21:53', '2020-09-10 02:21:53'),
(45, 'StockController', 'stock-list', 'web', '2020-09-10 02:22:28', '2020-09-10 02:22:28'),
(46, 'StockController', 'stock-create', 'web', '2020-09-10 02:22:43', '2020-09-10 02:22:43'),
(47, 'StockController', 'stock-edit', 'web', '2020-09-10 02:22:54', '2020-09-10 02:22:54'),
(48, 'StockController', 'stock-delete', 'web', '2020-09-10 02:23:06', '2020-09-10 02:23:06'),
(49, 'TransactionController', 'transaction-list', 'web', '2020-09-10 02:23:38', '2020-09-10 02:23:38'),
(50, 'TransactionController', 'transaction-create', 'web', '2020-09-10 02:23:52', '2020-09-10 02:23:52'),
(51, 'TransactionController', 'transaction-edit', 'web', '2020-09-10 02:24:09', '2020-09-10 02:24:09'),
(52, 'TransactionController', 'transaction-delete', 'web', '2020-09-10 02:24:20', '2020-09-10 02:24:20'),
(53, 'HomeController', 'home-list', 'web', '2020-09-10 02:26:52', '2020-09-10 02:26:52'),
(54, 'ProductPurchaseRawMaterialsController', 'product-purchase-raw-materials-list', 'web', '2020-10-14 11:33:48', '2020-10-14 11:33:48'),
(55, 'ProductPurchaseRawMaterialsController', 'product-purchase-raw-materials-create', 'web', '2020-10-14 11:34:05', '2020-10-14 11:34:05'),
(56, 'ProductPurchaseRawMaterialsController', 'product-purchase-raw-materials-edit', 'web', '2020-10-14 11:34:18', '2020-10-14 11:34:18'),
(57, 'ProductPurchaseRawMaterialsController', 'product-purchase-raw-materials-delete', 'web', '2020-10-14 11:34:33', '2020-10-14 11:34:33'),
(58, 'ProductProductionController', 'product-production-list', 'web', '2020-10-14 11:37:32', '2020-10-14 11:37:32'),
(59, 'ProductProductionController', 'product-production-create', 'web', '2020-10-14 11:37:49', '2020-10-14 11:37:49'),
(60, 'ProductProductionController', 'product-production-edit', 'web', '2020-10-14 11:38:05', '2020-10-14 11:38:05'),
(61, 'ProductProductionController', 'product-production-delete', 'web', '2020-10-14 11:38:19', '2020-10-14 11:38:19'),
(62, 'ProductUnitController', 'product-unit-list', 'web', '2020-11-30 02:53:00', '2020-11-30 02:53:00'),
(63, 'ProductUnitController', 'product-unit-create', 'web', '2020-11-30 02:53:16', '2020-11-30 02:53:16'),
(64, 'ProductUnitController', 'product-unit-edit', 'web', '2020-11-30 02:53:34', '2020-11-30 02:53:34'),
(65, 'ProductUnitController', 'product-unit-delete', 'web', '2020-11-30 02:53:58', '2020-11-30 02:53:58'),
(66, 'ServiceController', 'service-list', 'web', '2021-01-23 06:55:42', '2021-01-23 06:55:42'),
(67, 'ServiceController', 'service-create', 'web', '2021-01-23 06:55:57', '2021-01-23 06:55:57'),
(68, 'ServiceController', 'service-edit', 'web', '2021-01-23 06:56:14', '2021-01-23 06:56:14'),
(69, 'ServiceController', 'service-delete', 'web', '2021-01-23 06:56:34', '2021-01-23 06:56:34'),
(70, 'FreeProductController', 'freeProduct-list', 'web', '2021-01-23 06:56:50', '2021-01-23 06:56:50'),
(71, 'FreeProductController', 'freeProduct-create', 'web', '2021-01-23 06:57:03', '2021-01-23 06:57:03'),
(72, 'FreeProductController', 'freeProduct-edit', 'web', '2021-01-23 06:57:17', '2021-01-23 06:57:17'),
(73, 'FreeProductController', 'freeProduct-delete', 'web', '2021-01-23 06:57:32', '2021-01-23 06:57:32'),
(74, 'AccountController', 'coa-print', 'web', '2021-01-23 06:59:50', '2021-01-23 06:59:50'),
(75, 'AccountController', 'cash-book-list', 'web', '2021-01-23 07:00:04', '2021-01-23 07:00:04'),
(76, 'AccountController', 'debit-voucher-list', 'web', '2021-01-23 07:00:18', '2021-01-23 07:00:18'),
(77, 'AccountController', 'credit-voucher-list', 'web', '2021-01-23 07:00:32', '2021-01-23 07:00:32'),
(78, 'VoucherTypeController', 'voucher-type-list', 'web', '2021-01-23 07:01:26', '2021-01-23 07:01:26'),
(79, 'VoucherTypeController', 'voucher-type-create', 'web', '2021-01-23 07:01:40', '2021-01-23 07:01:40'),
(80, 'VoucherTypeController', 'voucher-type-edit', 'web', '2021-01-23 07:01:52', '2021-01-23 07:01:52'),
(81, 'VoucherTypeController', 'voucher-type-delete', 'web', '2021-01-23 07:02:06', '2021-01-23 07:02:06'),
(82, 'PostingController', 'posting-list', 'web', '2021-01-24 20:25:03', '2021-01-24 20:25:03'),
(83, 'PostingController', 'posting-create', 'web', '2021-01-24 20:25:45', '2021-01-24 20:25:45'),
(84, 'PostingController', 'posting-edit', 'web', '2021-01-24 20:25:58', '2021-01-24 20:25:58'),
(85, 'PostingController', 'posting-delete', 'web', '2021-01-24 20:26:15', '2021-01-24 20:26:15'),
(86, 'PostingController', 'general-ledger-list', 'web', '2021-01-24 20:26:31', '2021-01-24 20:26:31'),
(87, 'PostingController', 'trial-balance-list', 'web', '2021-01-24 20:26:46', '2021-01-24 20:26:46'),
(88, 'PostingController', 'balance-sheet-list', 'web', '2021-01-24 20:26:57', '2021-01-24 20:26:57'),
(89, 'ServiceController', 'monthly-service', 'web', '2021-02-02 11:43:32', '2021-02-02 11:43:32'),
(90, 'ServiceController', 'monthly-service-sms', 'web', '2021-02-02 11:43:47', '2021-02-02 11:43:47'),
(91, 'PartyController', 'supplier-list', 'web', '2021-02-02 11:45:01', '2021-02-02 11:45:01'),
(92, 'OfferController', 'offer-list', 'web', '2021-02-02 12:21:57', '2021-02-02 12:21:57'),
(93, 'OfferController', 'offer-create', 'web', '2021-02-02 12:22:15', '2021-02-02 12:22:15'),
(94, 'OfferController', 'offer-edit', 'web', '2021-02-02 12:22:30', '2021-02-02 12:22:30'),
(95, 'OfferController', 'offer-delete', 'web', '2021-02-02 12:23:16', '2021-02-02 12:23:16'),
(96, 'StockController', 'stock-summary-list', 'web', '2021-02-02 12:23:32', '2021-02-02 12:23:32'),
(97, 'StockController', 'stock-low-list', 'web', '2021-02-02 12:23:46', '2021-02-02 12:23:46'),
(98, 'OnlinePlatFormController', 'online-platform-list', 'web', '2021-02-10 06:51:23', '2021-02-10 06:51:23'),
(99, 'OnlinePlatFormController', 'online-platform-create', 'web', '2021-02-10 06:51:35', '2021-02-10 06:51:35'),
(100, 'OnlinePlatFormController', 'online-platform-edit', 'web', '2021-02-10 06:51:53', '2021-02-10 06:51:53'),
(101, 'OnlinePlatFormController', 'online-platform-delete', 'web', '2021-02-10 06:52:14', '2021-02-10 06:52:14'),
(102, 'CustomerComplainController', 'customer-complain-list', 'web', '2021-02-10 06:53:28', '2021-02-10 06:53:28'),
(103, 'CustomerComplainController', 'customer-complain-create', 'web', '2021-02-10 06:53:39', '2021-02-10 06:53:39'),
(104, 'CustomerComplainController', 'customer-complain-edit', 'web', '2021-02-10 06:53:51', '2021-02-10 06:53:51'),
(105, 'CustomerComplainController', 'customer-complain-delete', 'web', '2021-02-10 06:53:59', '2021-02-10 06:53:59'),
(106, 'ExpenseController', 'expense-list', 'web', '2021-02-10 08:38:52', '2021-02-10 08:38:52'),
(107, 'ExpenseController', 'expense-create', 'web', '2021-02-10 08:39:06', '2021-02-10 08:39:06'),
(108, 'ExpenseController', 'expense-edit', 'web', '2021-02-10 08:39:26', '2021-02-10 08:39:26'),
(109, 'ExpenseController', 'expense-delete', 'web', '2021-02-10 08:39:39', '2021-02-10 08:39:39'),
(110, 'OfficeCostingCategoryController', 'officeCostingCategories-list', 'web', '2021-02-10 08:40:11', '2021-02-10 08:40:11'),
(111, 'OfficeCostingCategoryController', 'officeCostingCategories-create', 'web', '2021-02-10 08:40:22', '2021-02-10 08:40:22'),
(112, 'OfficeCostingCategoryController', 'officeCostingCategories-edit', 'web', '2021-02-10 08:40:33', '2021-02-10 08:40:33'),
(113, 'OfficeCostingCategoryController', 'officeCostingCategories-delete', 'web', '2021-02-10 08:40:49', '2021-02-10 08:40:49');

-- --------------------------------------------------------

--
-- Table structure for table `postings`
--

CREATE TABLE `postings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_type_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit` double(32,2) DEFAULT NULL,
  `credit` double(32,2) DEFAULT NULL,
  `transaction_description` text COLLATE utf8mb4_unicode_ci,
  `bank_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_date_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_approved` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posting_forms`
--

CREATE TABLE `posting_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `voucher_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `voucher_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posting_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posting_form_details`
--

CREATE TABLE `posting_form_details` (
  `id` bigint(20) NOT NULL,
  `posting_form_id` bigint(20) DEFAULT NULL,
  `chart_of_account_id` bigint(20) DEFAULT NULL,
  `group_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ledger_id` bigint(20) DEFAULT NULL,
  `ledger_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit` int(191) DEFAULT NULL,
  `credit` int(191) DEFAULT NULL,
  `year` int(191) DEFAULT NULL,
  `month` int(191) DEFAULT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warranty` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_category_id` bigint(20) UNSIGNED NOT NULL,
  `product_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_brand_id` bigint(20) UNSIGNED NOT NULL,
  `product_unit_id` int(191) DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'product.jpg',
  `price` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mrp_price` double(8,2) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `warranty`, `name`, `slug`, `product_category_id`, `product_sub_category_id`, `product_brand_id`, `product_unit_id`, `description`, `model`, `image`, `price`, `mrp_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'One year electrical parts warranty including three complementary service', '7 Stage Ro Water Purifier.BLU-201 BW', '7-stage-ro-water-purifierblu-201-bw', 1, NULL, 2, 1, NULL, 'BLU-201 BW', 'default.png', NULL, NULL, 1, '2021-02-16 18:38:50', '2021-02-16 18:40:52'),
(2, NULL, 'Hot & Normal RO Water Purifier.Heron Max', 'hot-normal-ro-water-purifierheron-max', 1, NULL, 1, 1, NULL, 'Heron Max', 'default.png', NULL, NULL, 1, '2021-02-17 00:43:22', '2021-02-17 00:43:22'),
(3, NULL, '5 Stage RO Water Purifier.ECO-501 (Plastic)', '5-stage-ro-water-purifiereco-501-plastic', 1, NULL, 4, 1, NULL, 'ECO-501 (Plastic)', 'default.png', NULL, NULL, 1, '2021-02-17 01:03:20', '2021-02-17 01:03:20'),
(4, 'on warentty', 'Cartidge.Cd000', 'cartidgecd000', 3, NULL, 1, 1, 'Free Goods', 'Cd000', 'default.png', NULL, NULL, 1, '2021-02-17 22:53:56', '2021-02-17 22:53:56'),
(5, NULL, 'RO Water Purifier.Heron Unique', 'ro-water-purifierheron-unique', 1, NULL, 1, 1, NULL, 'Heron Unique', 'default.png', NULL, NULL, 1, '2021-03-27 16:21:05', '2021-03-27 16:21:05'),
(6, '1 Year', 'RO Water Purifier Heron Unique WSP.Purifier 2021', 'ro-water-purifier-heron-unique-wsppurifier-2021', 1, NULL, 2, 1, NULL, 'Purifier 2021', '2021-03-29-606195987c370.jpg', NULL, NULL, 1, '2021-03-29 18:53:44', '2021-03-29 18:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `product_brands`
--

CREATE TABLE `product_brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_brands`
--

INSERT INTO `product_brands` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Heron', 'heron', '2021-02-16 18:30:05', '2021-02-16 18:30:05'),
(2, 'BLU', 'blu', '2021-02-16 18:30:15', '2021-02-16 18:30:15'),
(3, 'Lanshan', 'lanshan', '2021-02-16 18:30:26', '2021-02-16 18:30:26'),
(4, 'Ecofresh', 'ecofresh', '2021-02-16 18:30:52', '2021-02-16 18:30:52'),
(5, 'Aqua Pro', 'aqua-pro', '2021-02-16 18:31:08', '2021-02-16 18:31:08'),
(6, 'Easy Pure', 'easy-pure', '2021-02-16 18:31:35', '2021-02-16 18:31:35'),
(7, 'Top Klean', 'top-klean', '2021-02-16 18:31:57', '2021-02-16 18:31:57'),
(8, 'Sanaky', 'sanaky', '2021-02-16 18:32:17', '2021-02-16 18:32:17'),
(9, 'Fluxtek', 'fluxtek', '2021-02-16 18:32:29', '2021-02-16 18:32:29');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'RO Water Purifier', 'ro-water-purifier', '2021-02-16 18:28:53', '2021-02-16 18:28:53'),
(2, 'UV Water Purifier', 'uv-water-purifier', '2021-02-16 18:29:24', '2021-02-16 18:29:24'),
(3, 'Accessories', 'accessories', '2021-02-16 18:29:50', '2021-02-16 18:29:50');

-- --------------------------------------------------------

--
-- Table structure for table `product_productions`
--

CREATE TABLE `product_productions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` double(8,2) NOT NULL,
  `paid_amount` double(8,2) NOT NULL,
  `due_amount` double(8,2) NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_production_details`
--

CREATE TABLE `product_production_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_production_id` bigint(20) UNSIGNED NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_sub_category_id` int(11) DEFAULT NULL,
  `product_brand_id` int(11) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `production` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `sub_total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_purchases`
--

CREATE TABLE `product_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `party_id` bigint(20) UNSIGNED NOT NULL,
  `discount_type` enum('flat','percentage') COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_amount` double(8,2) DEFAULT NULL,
  `payment_type` enum('cash','check') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_date` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` double(8,2) NOT NULL,
  `paid_amount` double(8,2) DEFAULT NULL,
  `due_amount` double(8,2) DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_purchases`
--

INSERT INTO `product_purchases` (`id`, `invoice_no`, `user_id`, `store_id`, `party_id`, `discount_type`, `discount_amount`, `payment_type`, `check_number`, `check_date`, `total_amount`, `paid_amount`, `due_amount`, `date`, `note`, `created_at`, `updated_at`) VALUES
(1, '1000', 1, 1, 2, 'flat', 0.00, 'cash', '', NULL, 32000.00, 16000.00, 0.00, '2021-04-06', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', '2021-04-06 03:14:24', '2021-04-06 09:47:16');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase_details`
--

CREATE TABLE `product_purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_category_id` bigint(20) UNSIGNED NOT NULL,
  `product_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_brand_id` bigint(20) UNSIGNED NOT NULL,
  `product_unit_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `warranty` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `mrp_price` double(8,2) DEFAULT NULL,
  `sub_total` double(8,2) NOT NULL,
  `expired_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_purchase_details`
--

INSERT INTO `product_purchase_details` (`id`, `product_purchase_id`, `product_category_id`, `product_sub_category_id`, `product_brand_id`, `product_unit_id`, `product_id`, `warranty`, `qty`, `price`, `mrp_price`, `sub_total`, `expired_date`, `ref_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 2, '1', 6, '1 Year', 20, 800.00, 1000.00, 16000.00, NULL, NULL, '2021-04-06 03:14:24', '2021-04-06 03:14:24');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase_returns`
--

CREATE TABLE `product_purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_purchase_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `party_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_type` enum('cash','online') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` enum('flat','percentage') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` double(8,2) DEFAULT NULL,
  `total_amount` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_purchase_returns`
--

INSERT INTO `product_purchase_returns` (`id`, `invoice_no`, `purchase_invoice_no`, `product_purchase_id`, `user_id`, `store_id`, `party_id`, `payment_type`, `discount_type`, `discount_amount`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 'return-1000', '1000', 1, 1, 1, 2, NULL, 'flat', 0.00, 800.00, '2021-04-06 03:53:21', '2021-04-06 03:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase_return_details`
--

CREATE TABLE `product_purchase_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_purchase_return_id` bigint(20) UNSIGNED NOT NULL,
  `product_purchase_detail_id` bigint(20) UNSIGNED NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_sub_category_id` int(11) DEFAULT NULL,
  `product_brand_id` int(11) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `reason` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_purchase_return_details`
--

INSERT INTO `product_purchase_return_details` (`id`, `product_purchase_return_id`, `product_purchase_detail_id`, `product_category_id`, `product_sub_category_id`, `product_brand_id`, `product_id`, `qty`, `price`, `reason`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, 2, 6, 1, 800.00, NULL, '2021-04-06 03:53:21', '2021-04-06 03:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_sales`
--

CREATE TABLE `product_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `party_id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` int(191) DEFAULT NULL,
  `payment_type` enum('cash','check') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `online_platform_id` bigint(255) DEFAULT NULL,
  `online_platform_invoice_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_amount` float(8,2) DEFAULT NULL,
  `discount_type` enum('flat','percentage') COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_amount` double(8,2) NOT NULL,
  `total_amount` double(8,2) NOT NULL,
  `paid_amount` double(8,2) NOT NULL,
  `due_amount` double(8,2) NOT NULL,
  `transport_cost` double(8,2) DEFAULT NULL,
  `transport_area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `print_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=default, 1=print now, 2=print latter',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sales`
--

INSERT INTO `product_sales` (`id`, `invoice_no`, `user_id`, `store_id`, `party_id`, `provider_id`, `payment_type`, `check_number`, `online_platform_id`, `online_platform_invoice_no`, `vat_type`, `vat_amount`, `discount_type`, `discount_amount`, `total_amount`, `paid_amount`, `due_amount`, `transport_cost`, `transport_area`, `date`, `note`, `print_status`, `created_at`, `updated_at`) VALUES
(1, '1000', 1, 1, 5, 3, NULL, NULL, NULL, '', NULL, NULL, 'flat', 0.00, 2000.00, 1000.00, 1000.00, NULL, NULL, '2021-04-07', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to', 0, '2021-04-06 03:21:46', '2021-04-07 11:26:25'),
(2, '1001', 1, 1, 3, 43, NULL, NULL, NULL, '', NULL, NULL, 'flat', 0.00, 1000.00, 1000.00, 0.00, NULL, NULL, '2021-04-07', NULL, 0, '2021-04-07 11:26:48', '2021-04-07 11:27:01');

-- --------------------------------------------------------

--
-- Table structure for table `product_sale_details`
--

CREATE TABLE `product_sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_sale_id` bigint(20) UNSIGNED NOT NULL,
  `return_type` enum('returnable','not returnable') COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_sub_category_id` int(11) DEFAULT NULL,
  `product_brand_id` int(11) NOT NULL,
  `product_unit_id` int(191) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `sub_total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sale_details`
--

INSERT INTO `product_sale_details` (`id`, `product_sale_id`, `return_type`, `product_category_id`, `product_sub_category_id`, `product_brand_id`, `product_unit_id`, `product_id`, `qty`, `price`, `sub_total`, `created_at`, `updated_at`) VALUES
(1, 1, 'returnable', 1, NULL, 2, 1, 6, 2, 1000.00, 2000.00, '2021-04-06 03:21:46', '2021-04-06 03:21:46'),
(2, 2, 'returnable', 1, NULL, 2, 1, 6, 1, 1000.00, 1000.00, '2021-04-07 11:26:48', '2021-04-07 11:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `product_sale_replacements`
--

CREATE TABLE `product_sale_replacements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_sale_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `party_id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_sale_replacement_details`
--

CREATE TABLE `product_sale_replacement_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `p_s_replacement_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `replace_qty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `reason` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_sale_returns`
--

CREATE TABLE `product_sale_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_sale_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `party_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_type` enum('cash','online') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` enum('flat','percentage') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` double(8,2) DEFAULT NULL,
  `total_amount` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sale_returns`
--

INSERT INTO `product_sale_returns` (`id`, `invoice_no`, `sale_invoice_no`, `product_sale_id`, `user_id`, `store_id`, `party_id`, `payment_type`, `discount_type`, `discount_amount`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 'return-1000', '1000', 1, 1, 1, 5, NULL, 'flat', 0.00, 1000.00, '2021-04-06 03:52:51', '2021-04-06 03:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `product_sale_return_details`
--

CREATE TABLE `product_sale_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_sale_return_id` bigint(20) UNSIGNED NOT NULL,
  `product_sale_detail_id` bigint(20) UNSIGNED NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_sub_category_id` int(11) DEFAULT NULL,
  `product_brand_id` int(11) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `reason` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sale_return_details`
--

INSERT INTO `product_sale_return_details` (`id`, `product_sale_return_id`, `product_sale_detail_id`, `product_category_id`, `product_sub_category_id`, `product_brand_id`, `product_id`, `qty`, `price`, `reason`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, 2, 6, 1, 1000.00, NULL, '2021-04-06 03:52:51', '2021-04-06 03:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `product_sub_categories`
--

CREATE TABLE `product_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_units`
--

CREATE TABLE `product_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_units`
--

INSERT INTO `product_units` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'pcs', 'pcs', '2021-02-16 18:33:04', '2021-02-16 18:33:40'),
(2, 'ft', 'ft', '2021-02-16 18:33:17', '2021-02-16 18:33:31');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2019-08-17 01:35:43', '2019-08-17 01:35:43'),
(2, 'Customer', 'web', '2019-08-17 01:41:49', '2019-08-17 01:41:49'),
(3, 'Service Executive', 'web', '2021-01-23 04:50:39', '2021-01-23 04:50:39'),
(4, 'Service Provider', 'web', '2021-01-23 04:51:31', '2021-01-23 04:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(37, 3),
(37, 2),
(38, 2),
(39, 2),
(9, 4),
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale_services`
--

CREATE TABLE `sale_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_sale_detail_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_user_id` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_services`
--

INSERT INTO `sale_services` (`id`, `product_sale_detail_id`, `service_id`, `provider_id`, `created_user_id`, `status`, `duration`, `date`, `created_at`, `updated_at`) VALUES
(2, 2, 9, NULL, 1, '0', NULL, '2021-03-02', '2021-03-02 23:16:16', '2021-03-02 23:16:16'),
(3, 5, 10, '43', 1, '1', NULL, '2021-03-27', '2021-03-27 16:57:18', '2021-03-31 22:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(9, 'PP Change', '1', '2021-02-17 00:55:02', '2021-02-17 00:55:02'),
(10, 'Membrane change', '1', '2021-03-27 16:17:57', '2021-03-27 16:17:57');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `stock_type` enum('purchase','sale','sale return','production','replace','purchase return','from stock out','to stock in') COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_stock` int(11) NOT NULL,
  `stock_in` int(11) NOT NULL,
  `stock_out` int(11) NOT NULL,
  `current_stock` int(11) NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `ref_id`, `user_id`, `store_id`, `product_id`, `stock_type`, `previous_stock`, `stock_in`, `stock_out`, `current_stock`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 6, 'purchase', 0, 20, 0, 20, '2021-04-06', '2021-04-06 03:14:24', '2021-04-06 03:14:24'),
(2, 1, 1, 1, 6, 'from stock out', 20, 0, 2, 18, '2021-04-06', '2021-04-06 03:20:56', '2021-04-06 03:20:56'),
(3, 1, 1, 2, 6, 'to stock in', 0, 2, 0, 2, '2021-04-06', '2021-04-06 03:20:56', '2021-04-06 03:20:56'),
(4, 1, 1, 1, 6, 'sale', 16, 0, 2, 14, '2021-04-07', '2021-04-06 03:21:46', '2021-04-07 11:26:25'),
(5, 1, 1, 1, 6, 'sale return', 16, 1, 0, 17, '2021-04-06', '2021-04-06 03:52:51', '2021-04-06 03:52:51'),
(6, 1, 1, 1, 6, 'purchase return', 17, 1, 0, 16, '2021-04-06', '2021-04-06 03:53:21', '2021-04-06 03:53:21'),
(7, 2, 1, 1, 6, 'sale', 15, 0, 1, 14, '2021-04-07', '2021-04-07 11:26:48', '2021-04-07 11:27:01');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfers`
--

CREATE TABLE `stock_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_user_id` int(11) NOT NULL,
  `send_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_remarks` text COLLATE utf8mb4_unicode_ci,
  `from_store_id` bigint(20) UNSIGNED NOT NULL,
  `to_store_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_service_charge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` enum('flat','percentage') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` double(8,2) DEFAULT NULL,
  `total_amount` double(8,2) NOT NULL,
  `paid_amount` double(8,2) NOT NULL,
  `due_amount` double(8,2) NOT NULL,
  `receive_user_id` int(11) NOT NULL,
  `receive_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receive_remarks` text COLLATE utf8mb4_unicode_ci,
  `receive_status` enum('pending','canceled','received') COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transfers`
--

INSERT INTO `stock_transfers` (`id`, `invoice_no`, `send_user_id`, `send_date`, `send_remarks`, `from_store_id`, `to_store_id`, `delivery_service_id`, `delivery_service_charge`, `discount_type`, `discount_amount`, `total_amount`, `paid_amount`, `due_amount`, `receive_user_id`, `receive_date`, `receive_remarks`, `receive_status`, `note`, `created_at`, `updated_at`) VALUES
(1, 'stock-transfer-5000', 1, '2021-04-06', NULL, 1, 2, 1, NULL, 'flat', 0.00, 2000.00, 0.00, 2000.00, 1, '2021-04-06', NULL, 'received', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate', '2021-04-06 03:20:56', '2021-04-06 03:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_details`
--

CREATE TABLE `stock_transfer_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_transfer_id` bigint(20) UNSIGNED NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_sub_category_id` int(11) DEFAULT NULL,
  `product_brand_id` int(11) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `sub_total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transfer_details`
--

INSERT INTO `stock_transfer_details` (`id`, `stock_transfer_id`, `product_category_id`, `product_sub_category_id`, `product_brand_id`, `product_id`, `qty`, `price`, `sub_total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 2, 6, 2, 1000.00, 2000.00, '2021-04-06 03:20:56', '2021-04-06 03:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `slug`, `phone`, `email`, `address`, `website`, `page`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Clean Tech Engineering', 'clean-tech-engineering', '01701-666 606', NULL, 'Corporate Office : House-1, Road-16, Section-10, Block-C, Mirpur, Dhaka-1216', NULL, NULL, '2021-01-23-600bd09e51122.jpg', '2020-09-08 03:31:37', '2021-01-23 07:30:38'),
(2, 'Clean Tech Engineering (Dhanmondi Branch)', 'clean-tech-engineering-dhanmondi-branch', '02-58052342, 01701-666 606, 01701-666 601, 01711-991 851.', NULL, 'Corporate Office : House-1, Road-16, Section-10, Block-C, Mirpur, Dhaka-1216', NULL, NULL, '2021-01-23-600bd0bf0d735.jpg', '2021-01-23 07:31:11', '2021-01-23 07:31:11'),
(3, 'Clean Tech Engineering (Mirpur Branch)', 'clean-tech-engineering-mirpur-branch', '01701-666 606, 01701-666 601, 01711-991 851.', NULL, 'Corporate Office : House-1, Road-16, Section-10, Block-C, Mirpur, Dhaka-1216', NULL, NULL, '2021-01-23-600bd0dde98a6.jpg', '2021-01-23 07:31:42', '2021-01-23 07:31:42'),
(4, 'Evaly CleanTech Engineering Official Store', 'evaly-cleantech-engineering-official-store', '01701666601', NULL, 'Road-16,House-1,Section-10,Block-C,Mirpur,Dhaka', NULL, NULL, '2021-02-16-602b66168a628.jpg', '2021-02-16 17:28:38', '2021-02-16 17:28:38');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `party_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ref_id` int(11) NOT NULL,
  `transaction_type` enum('purchase','sale','delivery charge','sale return','due','expense','production','purchase return') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` enum('Cash','Check') COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_date` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(8,2) NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `invoice_no`, `user_id`, `store_id`, `party_id`, `ref_id`, `transaction_type`, `payment_type`, `check_number`, `check_date`, `amount`, `date`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, 2, 1, 'purchase', 'Cash', '', '', 32000.00, '2021-04-06', '2021-04-05 07:23:03', '2021-04-06 09:38:57'),
(2, '1000', 1, 1, 3, 2, 'sale', 'Cash', '', '', 1000.00, '2021-04-07', '2021-04-05 08:25:54', '2021-04-07 11:27:01'),
(3, '1001', 1, 2, 1, 3, 'sale', 'Cash', '', '', 1700.00, '2021-04-05', '2021-04-05 08:45:34', '2021-04-05 08:45:34'),
(4, '1000', 1, 1, 2, 1, 'purchase', 'Cash', '', '', 16000.00, '2021-04-06', '2021-04-06 03:14:24', '2021-04-06 03:14:24'),
(5, '1000', 1, 1, 5, 1, 'sale', 'Cash', '', '', 2000.00, '2021-04-07', '2021-04-06 03:21:46', '2021-04-07 11:26:25'),
(6, 'return-1000', 1, 1, 5, 1, 'sale return', 'Cash', NULL, NULL, 1000.00, '2021-04-06', '2021-04-06 03:52:51', '2021-04-06 03:52:51'),
(7, 'return-return-1000', 1, 1, 2, 1, 'purchase return', 'Cash', NULL, NULL, 800.00, '2021-04-06', '2021-04-06 03:53:21', '2021-04-06 03:53:21'),
(8, '1001', 1, 1, 3, 2, 'sale', 'Cash', '', '', 1000.00, '2021-04-07', '2021-04-07 11:26:48', '2021-04-07 11:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(191) DEFAULT NULL,
  `party_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `store_id`, `party_id`, `name`, `email`, `phone`, `type`, `email_verified_at`, `password`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Admin', 'robeul.starit@gmail.com', NULL, NULL, NULL, '$2y$10$HsmJ5tcnE/0FxLWRfU0FpuHmp8F1RsHOJPe02OU25.YsE8T/0DNIm', NULL, 1, '2019-08-17 01:35:43', '2021-02-04 04:44:26'),
(3, NULL, NULL, 'Service Provider', 'serviceprovider1@gmail.com', '01703500588', 'provider', NULL, '$2y$10$rXEQ/QmyiNs7/H6uCHPDmeAI8V1uFJvUAYRLCkCLD0.GuhgyAm74a', NULL, 1, '2021-01-23 04:55:35', '2021-02-02 11:35:24'),
(4, 1, NULL, 'service executive', 'serviceexecutive1@gmail.com', '01557393119', 'executive', NULL, '$2y$10$2qTcCxczgX8wgBjBMnDdPOF2WbcbclFswQpSx/6JfG4B7c7HU75QK', NULL, 1, '2021-01-23 05:04:10', '2021-02-02 11:33:24'),
(17, 2, NULL, 'service executive dhanmondi', 'serviceexecutivedhanmondi@gmail.com', '01703500589', 'executive', NULL, '$2y$10$B6CbOTtUIgFwXmzid7SjlufH9K19/gVQLO7sgdtqINIns9DNIvnfK', NULL, 1, '2021-02-02 11:38:02', '2021-02-02 11:38:57'),
(39, NULL, 1, 'Ashique', 'ashiq.starit@gmail.com', '01703500587', NULL, NULL, '$2y$10$rS9QL4gEWMRLatbsisu9KOu3ECo9n27wwJveF1rVMG3.JgNfjceyi', NULL, 1, '2021-03-02 23:12:22', '2021-03-02 23:12:22'),
(40, NULL, 3, 'Papon', NULL, '01911866693', NULL, NULL, '$2y$10$qMqceRXKVzozqX0JV61TD.6x91ku2OkP8e3T8iqT/hxfstGZoipf2', NULL, 1, '2021-03-27 16:23:19', '2021-03-27 16:23:19'),
(41, NULL, 5, 'Sakib', NULL, '01911265470', NULL, NULL, '$2y$10$Q19bWDndDFhiqPvuEf.FGumZJ627mhFUMEXM8xnJjjarLaIdGQMqy', NULL, 1, '2021-03-27 16:29:17', '2021-03-27 16:29:17'),
(42, 1, NULL, 'Mohammad Yeakub', 'yeakub@gmail.com', NULL, 'executive', NULL, '$2y$10$DT1b99P7CxtubusF6KZvQubBcJCuFpwJjuOOJktx9WGkTXtLkUhbW', NULL, 1, '2021-03-27 17:08:35', '2021-03-27 17:08:35'),
(43, 1, NULL, 'Tamjid Rahman', 'tamjid@gmail.com', NULL, 'provider', NULL, '$2y$10$N9qntKRg5GYjDVHSGEZPhegKzLalbFrNWwPwLxUJZZ6K4nFPv9bDq', NULL, 1, '2021-03-28 20:13:50', '2021-03-28 20:13:50'),
(44, NULL, 8, 'Sharif', NULL, '01701666602', NULL, NULL, '$2y$10$qFP6hS2lGlm43tI2jYYDRemSPI0v/5uj.Yfzw8JXVNOlJKtPs0bgG', NULL, 1, '2021-03-28 23:51:02', '2021-03-28 23:51:02'),
(45, NULL, 13, 'pinky', 'ashiq.starit@gmail.com', '1703500587', NULL, NULL, '$2y$10$.fKck4guRgcFV66VxncK6.mQf9KJYQJuWEGNkNj5m5qpv6noV8tGq', NULL, 1, '2021-04-07 03:10:32', '2021-04-07 03:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `voucher_types`
--

CREATE TABLE `voucher_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voucher_types`
--

INSERT INTO `voucher_types` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Debit', 'debit', '2021-01-07 12:19:30', '2021-01-11 05:29:16'),
(2, 'Credit', 'credit', '2021-02-03 11:32:21', '2021-02-03 11:32:21'),
(3, 'Journal', 'journal', '2021-02-03 11:32:31', '2021-02-03 11:32:31'),
(5, 'Transfer', 'transfer', '2021-03-29 21:22:16', '2021-03-29 21:22:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_complains`
--
ALTER TABLE `customer_complains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_services`
--
ALTER TABLE `delivery_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dues`
--
ALTER TABLE `dues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dues_store_id_foreign` (`store_id`),
  ADD KEY `dues_party_id_foreign` (`party_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_store_id_foreign` (`store_id`),
  ADD KEY `expenses_office_costing_category_id_foreign` (`office_costing_category_id`);

--
-- Indexes for table `free_products`
--
ALTER TABLE `free_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `free_product_sale_details`
--
ALTER TABLE `free_product_sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `free_product_sale_details_product_sale_id_foreign` (`product_sale_id`),
  ADD KEY `free_product_sale_details_free_product_id_foreign` (`free_product_id`);

--
-- Indexes for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office_costing_categories`
--
ALTER TABLE `office_costing_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_platforms`
--
ALTER TABLE `online_platforms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postings`
--
ALTER TABLE `postings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posting_forms`
--
ALTER TABLE `posting_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posting_form_details`
--
ALTER TABLE `posting_form_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_product_category_id_foreign` (`product_category_id`),
  ADD KEY `products_product_sub_category_id_foreign` (`product_sub_category_id`),
  ADD KEY `products_product_brand_id_foreign` (`product_brand_id`);

--
-- Indexes for table `product_brands`
--
ALTER TABLE `product_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_productions`
--
ALTER TABLE `product_productions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_productions_store_id_foreign` (`store_id`);

--
-- Indexes for table `product_production_details`
--
ALTER TABLE `product_production_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_production_details_product_production_id_foreign` (`product_production_id`),
  ADD KEY `product_production_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_purchases`
--
ALTER TABLE `product_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_purchases_store_id_foreign` (`store_id`),
  ADD KEY `product_purchases_party_id_foreign` (`party_id`);

--
-- Indexes for table `product_purchase_details`
--
ALTER TABLE `product_purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_purchase_details_product_purchase_id_foreign` (`product_purchase_id`),
  ADD KEY `product_purchase_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_purchase_returns`
--
ALTER TABLE `product_purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_purchase_returns_product_purchase_id_foreign` (`product_purchase_id`),
  ADD KEY `product_purchase_returns_store_id_foreign` (`store_id`),
  ADD KEY `product_purchase_returns_party_id_foreign` (`party_id`);

--
-- Indexes for table `product_purchase_return_details`
--
ALTER TABLE `product_purchase_return_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sales`
--
ALTER TABLE `product_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sales_store_id_foreign` (`store_id`),
  ADD KEY `product_sales_party_id_foreign` (`party_id`);

--
-- Indexes for table `product_sale_details`
--
ALTER TABLE `product_sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sale_details_product_sale_id_foreign` (`product_sale_id`),
  ADD KEY `product_sale_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_sale_replacements`
--
ALTER TABLE `product_sale_replacements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sale_replacements_store_id_foreign` (`store_id`),
  ADD KEY `product_sale_replacements_party_id_foreign` (`party_id`),
  ADD KEY `product_sale_replacements_product_sale_id_foreign` (`product_sale_id`);

--
-- Indexes for table `product_sale_replacement_details`
--
ALTER TABLE `product_sale_replacement_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sale_replacement_details_p_s_replacement_id_foreign` (`p_s_replacement_id`),
  ADD KEY `product_sale_replacement_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_sale_returns`
--
ALTER TABLE `product_sale_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sale_returns_product_sale_id_foreign` (`product_sale_id`),
  ADD KEY `product_sale_returns_store_id_foreign` (`store_id`),
  ADD KEY `product_sale_returns_party_id_foreign` (`party_id`);

--
-- Indexes for table `product_sale_return_details`
--
ALTER TABLE `product_sale_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sale_return_details_product_sale_return_id_foreign` (`product_sale_return_id`),
  ADD KEY `product_sale_return_details_product_sale_detail_id_foreign` (`product_sale_detail_id`),
  ADD KEY `product_sale_return_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_sub_categories`
--
ALTER TABLE `product_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sub_categories_product_category_id_foreign` (`product_category_id`);

--
-- Indexes for table `product_units`
--
ALTER TABLE `product_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `sale_services`
--
ALTER TABLE `sale_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_services_product_sale_detail_id_foreign` (`product_sale_detail_id`),
  ADD KEY `sale_services_service_id_foreign` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_name_unique` (`name`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_store_id_foreign` (`store_id`),
  ADD KEY `stocks_product_id_foreign` (`product_id`);

--
-- Indexes for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transfers_from_store_id_foreign` (`from_store_id`),
  ADD KEY `stock_transfers_to_store_id_foreign` (`to_store_id`),
  ADD KEY `stock_transfers_delivery_service_id_foreign` (`delivery_service_id`);

--
-- Indexes for table `stock_transfer_details`
--
ALTER TABLE `stock_transfer_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transfer_details_stock_transfer_id_foreign` (`stock_transfer_id`),
  ADD KEY `stock_transfer_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_store_id_foreign` (`store_id`),
  ADD KEY `transactions_party_id_foreign` (`party_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher_types`
--
ALTER TABLE `voucher_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404;

--
-- AUTO_INCREMENT for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  MODIFY `id` bigint(191) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `customer_complains`
--
ALTER TABLE `customer_complains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `delivery_services`
--
ALTER TABLE `delivery_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dues`
--
ALTER TABLE `dues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `free_products`
--
ALTER TABLE `free_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `free_product_sale_details`
--
ALTER TABLE `free_product_sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ledgers`
--
ALTER TABLE `ledgers`
  MODIFY `id` bigint(191) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `office_costing_categories`
--
ALTER TABLE `office_costing_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `online_platforms`
--
ALTER TABLE `online_platforms`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `postings`
--
ALTER TABLE `postings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posting_forms`
--
ALTER TABLE `posting_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posting_form_details`
--
ALTER TABLE `posting_form_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_brands`
--
ALTER TABLE `product_brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_productions`
--
ALTER TABLE `product_productions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_production_details`
--
ALTER TABLE `product_production_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_purchases`
--
ALTER TABLE `product_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_purchase_details`
--
ALTER TABLE `product_purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_purchase_returns`
--
ALTER TABLE `product_purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_purchase_return_details`
--
ALTER TABLE `product_purchase_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_sales`
--
ALTER TABLE `product_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_sale_details`
--
ALTER TABLE `product_sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_sale_replacements`
--
ALTER TABLE `product_sale_replacements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_sale_replacement_details`
--
ALTER TABLE `product_sale_replacement_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_sale_returns`
--
ALTER TABLE `product_sale_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_sale_return_details`
--
ALTER TABLE `product_sale_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_sub_categories`
--
ALTER TABLE `product_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_units`
--
ALTER TABLE `product_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sale_services`
--
ALTER TABLE `sale_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_transfer_details`
--
ALTER TABLE `stock_transfer_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `voucher_types`
--
ALTER TABLE `voucher_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dues`
--
ALTER TABLE `dues`
  ADD CONSTRAINT `dues_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dues_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_product_brand_id_foreign` FOREIGN KEY (`product_brand_id`) REFERENCES `product_brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_product_sub_category_id_foreign` FOREIGN KEY (`product_sub_category_id`) REFERENCES `product_sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_productions`
--
ALTER TABLE `product_productions`
  ADD CONSTRAINT `product_productions_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_purchases`
--
ALTER TABLE `product_purchases`
  ADD CONSTRAINT `product_purchases_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_purchases_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_purchase_returns`
--
ALTER TABLE `product_purchase_returns`
  ADD CONSTRAINT `product_purchase_returns_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_purchase_returns_product_purchase_id_foreign` FOREIGN KEY (`product_purchase_id`) REFERENCES `product_purchases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_purchase_returns_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
