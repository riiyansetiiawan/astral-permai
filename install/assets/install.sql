-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `ci_sessions`
--

TRUNCATE TABLE `ci_sessions`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_advance_gajii`
--

CREATE TABLE `umb_advance_gajii` (
  `advance_gaji_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `month_year` varchar(255) NOT NULL,
  `advance_jumlah` varchar(255) NOT NULL,
  `pengurangan_satu_kali` varchar(50) NOT NULL,
  `angsuran_bulanan` varchar(255) NOT NULL,
  `total_yang_dibayarkan` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `status` int(11) DEFAULT NULL,
  `is_dipotong_dari_gaji` int(11) DEFAULT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_advance_gajii`
--

TRUNCATE TABLE `umb_advance_gajii`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_pengumumans`
--

CREATE TABLE `umb_pengumumans` (
  `pengumuman_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `perusahaan_id` int(111) NOT NULL,
  `location_id` int(11) NOT NULL,
  `department_id` int(111) NOT NULL,
  `diterbitkan_oleh` int(111) NOT NULL,
  `summary` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_notify` int(11) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_pengumumans`
--

TRUNCATE TABLE `umb_pengumumans`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_assets`
--

CREATE TABLE `umb_assets` (
  `assets_id` int(111) NOT NULL,
  `kategori_assets_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `kode_asset_perusahaan` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tanggal_pembelian` varchar(255) NOT NULL,
  `nomor_invoice` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `tanggal_akhir_garansi` varchar(255) NOT NULL,
  `asset_note` text NOT NULL,
  `asset_image` varchar(255) NOT NULL,
  `sedang_bekerja` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_assets`
--

TRUNCATE TABLE `umb_assets`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_kategoris_assets`
--

CREATE TABLE `umb_kategoris_assets` (
  `kategori_assets_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_kategoris_assets`
--

TRUNCATE TABLE `umb_kategoris_assets`;
--
-- Dumping data for table `umb_kategoris_assets`
--

INSERT INTO `umb_kategoris_assets` (`kategori_assets_id`, `perusahaan_id`, `nama_kategori`, `created_at`) VALUES
(1, 1, 'Laptop', '01-01-2021 03:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `umb_kehadiran_waktu`
--

CREATE TABLE `umb_kehadiran_waktu` (
  `waktu_kehadiran_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `tanggal_kehadiran` varchar(255) NOT NULL,
  `clock_in` varchar(255) NOT NULL,
  `clock_in_ip_address` varchar(255) NOT NULL,
  `clock_out` varchar(255) NOT NULL,
  `clock_out_ip_address` varchar(255) NOT NULL,
  `clock_in_out` varchar(255) NOT NULL,
  `clock_in_latitude` varchar(150) NOT NULL,
  `clock_in_longitude` varchar(150) NOT NULL,
  `clock_out_latitude` varchar(150) NOT NULL,
  `clock_out_longitude` varchar(150) NOT NULL,
  `time_late` varchar(255) NOT NULL,
  `early_leaving` varchar(255) NOT NULL,
  `lembur` varchar(255) NOT NULL,
  `total_kerja` varchar(255) NOT NULL,
  `total_istirahat` varchar(255) NOT NULL,
  `status_kehadiran` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_kehadiran_waktu`
--

TRUNCATE TABLE `umb_kehadiran_waktu`;
--
-- Dumping data for table `umb_kehadiran_waktu`
--

INSERT INTO `umb_kehadiran_waktu` (`waktu_kehadiran_id`, `karyawan_id`, `tanggal_kehadiran`, `clock_in`, `clock_in_ip_address`, `clock_out`, `clock_out_ip_address`, `clock_in_out`, `clock_in_latitude`, `clock_in_longitude`, `clock_out_latitude`, `clock_out_longitude`, `time_late`, `early_leaving`, `lembur`, `total_kerja`, `total_istirahat`, `status_kehadiran`) VALUES
(1, 5, '2021-01-17', '2021-01-17 10:36:38', '::1', '2021-01-17 10:37:36', '::1', '0', '31.450726399999997', '74.2940672', '31.450726399999997', '74.2940672', '2019-04-17 10:36:38', '2021-01-17 10:37:36', '2021-01-17 10:37:36', '0:0', '', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `umb_permintaan_waktu_kehadiran`
--

CREATE TABLE `umb_permintaan_waktu_kehadiran` (
  `permintaan_waktu_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `tanggal_permintaan` varchar(255) NOT NULL,
  `tanggal_permintaan_request` varchar(255) NOT NULL,
  `request_clock_in` varchar(200) NOT NULL,
  `request_clock_out` varchar(200) NOT NULL,
  `total_hours` varchar(255) NOT NULL,
  `no_project` varchar(200) NOT NULL,
  `no_pembelian` varchar(200) DEFAULT NULL,
  `nama_tugas` varchar(255) NOT NULL,
  `alasan_permintaan` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_permintaan_waktu_kehadiran`
--

TRUNCATE TABLE `umb_permintaan_waktu_kehadiran`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_awards`
--

CREATE TABLE `umb_awards` (
  `award_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(200) NOT NULL,
  `type_award_id` int(200) NOT NULL,
  `gift_item` varchar(200) NOT NULL,
  `cash_price` varchar(200) NOT NULL,
  `photo_award` varchar(255) NOT NULL,
  `bulan_tahun_award` varchar(200) NOT NULL,
  `informasi_award` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_awards`
--

TRUNCATE TABLE `umb_awards`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_type_award`
--

CREATE TABLE `umb_type_award` (
  `type_award_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `type_award` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_type_award`
--

TRUNCATE TABLE `umb_type_award`;
--
-- Dumping data for table `umb_type_award`
--

INSERT INTO `umb_type_award` (`type_award_id`, `perusahaan_id`, `type_award`, `created_at`) VALUES
(1, 1, 'award Tahun Ini', '22-01-2021 01:33:57');

-- --------------------------------------------------------

--
-- Table structure for table `umb_chat_messages`
--

CREATE TABLE `umb_chat_messages` (
  `message_id` int(11) UNSIGNED NOT NULL,
  `from_id` varchar(40) NOT NULL DEFAULT '',
  `to_id` varchar(50) NOT NULL DEFAULT '',
  `message_frm` varchar(255) NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT 0,
  `message_content` longtext NOT NULL,
  `message_date` varchar(255) DEFAULT NULL,
  `recd` tinyint(1) NOT NULL DEFAULT 0,
  `message_type` varchar(255) NOT NULL DEFAULT '',
  `department_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_chat_messages`
--

TRUNCATE TABLE `umb_chat_messages`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_clients`
--

CREATE TABLE `umb_clients` (
  `client_id` int(111) NOT NULL,
  `type` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `client_username` varchar(255) NOT NULL,
  `password_client` varchar(255) NOT NULL,
  `profile_client` varchar(255) NOT NULL,
  `nomor_kontak` varchar(255) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `is_changed` int(11) NOT NULL,
  `jenis_kelamin` varchar(200) NOT NULL,
  `website_url` varchar(255) NOT NULL,
  `alamat_1` mediumtext NOT NULL,
  `alamat_2` mediumtext NOT NULL,
  `kota` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `kode_pos` varchar(255) NOT NULL,
  `negara` int(111) NOT NULL,
  `is_active` int(11) NOT NULL,
  `terakhir_logout_tanggal` varchar(255) NOT NULL,
  `tanggal_terakhir_login` varchar(255) NOT NULL,
  `terakhir_login_ip` varchar(255) NOT NULL,
  `is_logged_in` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_clients`
--

TRUNCATE TABLE `umb_clients`;
--
-- Dumping data for table `umb_clients`
--

INSERT INTO `umb_clients` (`client_id`, `type`, `name`, `email`, `client_username`, `password_client`, `profile_client`, `nomor_kontak`, `nama_perusahaan`, `is_changed`, `jenis_kelamin`, `website_url`, `alamat_1`, `alamat_2`, `kota`, `provinsi`, `kode_pos`, `negara`, `is_active`, `terakhir_logout_tanggal`, `tanggal_terakhir_login`, `terakhir_login_ip`, `is_logged_in`, `created_at`) VALUES
(1, '', 'Widi Yansyah', 'client1@hrastral.com', '', '$2y$12$wGATpsG6S/IAIwobUZMeDeYyxpirjXVaVLo79ta2PLlRJjBNIsfFa', '', '123456789', 'Shale Inc.', 0, '', '', 'Alamat Line 1', 'Alamat Line 2', 'Kota', 'Provinsi', '11461', 101, 1, '', '20-01-2021 22:05:05', '::1', 1, '2021-01-20 22:05:02');

-- --------------------------------------------------------

--
-- Table structure for table `umb_perusahaans`
--

CREATE TABLE `umb_perusahaans` (
  `perusahaan_id` int(111) NOT NULL,
  `type_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nama_trading` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_no` varchar(255) NOT NULL,
  `pajak_pemerintah` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `nomor_kontak` varchar(255) NOT NULL,
  `website_url` varchar(255) NOT NULL,
  `alamat_1` mediumtext NOT NULL,
  `alamat_2` mediumtext NOT NULL,
  `kota` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `kode_pos` varchar(255) NOT NULL,
  `negara` int(111) NOT NULL,
  `is_active` int(11) NOT NULL,
  `default_currency` varchar(200) DEFAULT NULL,
  `default_timezone` varchar(200) DEFAULT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_perusahaans`
--

TRUNCATE TABLE `umb_perusahaans`;
--
-- Dumping data for table `umb_perusahaans`
--

INSERT INTO `umb_perusahaans` (`perusahaan_id`, `type_id`, `name`, `nama_trading`, `username`, `password`, `registration_no`, `pajak_pemerintah`, `email`, `logo`, `nomor_kontak`, `website_url`, `alamat_1`, `alamat_2`, `kota`, `provinsi`, `kode_pos`, `negara`, `is_active`, `default_currency`, `default_timezone`, `added_by`, `created_at`) VALUES
(1, 1, 'HRASTRAL', 'Test', 'test123', '', '', '', 'mainoffice@hrastral.com', 'logo_1526958729.png', '0123456789', 'hrastral.com', 'Test', 'Test2', 'Jakarta', 'Jakarta', '11461', 101, 0, 'IDR - Rp', 'Asia/Jakarta', 1, '22-01-2021');

-- --------------------------------------------------------

--
-- Table structure for table `umb_documents_perusahaan`
--

CREATE TABLE `umb_documents_perusahaan` (
  `document_id` int(11) NOT NULL,
  `type_document_id` int(11) NOT NULL,
  `nama_license` varchar(255) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `tanggal_kaaluarsa` varchar(255) NOT NULL,
  `nomor_license` varchar(255) NOT NULL,
  `license_notification` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `document` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_documents_perusahaan`
--

TRUNCATE TABLE `umb_documents_perusahaan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_info_perusahaan`
--

CREATE TABLE `umb_info_perusahaan` (
  `info_perusahaan_id` int(111) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `logo_second` varchar(255) NOT NULL,
  `sign_in_logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `website_url` mediumtext NOT NULL,
  `starting_year` varchar(255) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `email_perusahaan` varchar(255) NOT NULL,
  `kontak_perusahaan` varchar(255) NOT NULL,
  `kontak_person` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `alamat_1` mediumtext NOT NULL,
  `alamat_2` mediumtext NOT NULL,
  `kota` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `kode_pos` varchar(255) NOT NULL,
  `negara` int(111) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_info_perusahaan`
--

TRUNCATE TABLE `umb_info_perusahaan`;
--
-- Dumping data for table `umb_info_perusahaan`
--

INSERT INTO `umb_info_perusahaan` (`info_perusahaan_id`, `logo`, `logo_second`, `sign_in_logo`, `favicon`, `website_url`, `starting_year`, `nama_perusahaan`, `email_perusahaan`, `kontak_perusahaan`, `kontak_person`, `email`, `phone`, `alamat_1`, `alamat_2`, `kota`, `provinsi`, `kode_pos`, `negara`, `updated_at`) VALUES
(1, 'logo_1520722747.png', 'logo2_1520609223.png', 'signin_logo_1520612279.png', 'favicon_1520722747.png', '', '', 'hrastral', '', '', 'Riyan Setiawan', 'info@hrastral.com', '123456789', 'Alamat Line 1', 'Alamat Line 2', 'Kota', 'Provinsi', '11461', 101, '2021-01-20 12:05:53');

-- --------------------------------------------------------

--
-- Table structure for table `umb_kebijakan_perusahaan`
--

CREATE TABLE `umb_kebijakan_perusahaan` (
  `kebijakan_id` int(111) NOT NULL,
  `perusahaan_id` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_kebijakan_perusahaan`
--

TRUNCATE TABLE `umb_kebijakan_perusahaan`;
--
-- Dumping data for table `umb_kebijakan_perusahaan`
--

INSERT INTO `umb_kebijakan_perusahaan` (`kebijakan_id`, `perusahaan_id`, `title`, `description`, `attachment`, `added_by`, `created_at`) VALUES
(1, 1, 'Pekerjaan Bebas Asap Rokok', '&lt;p&gt;Kebijakan Lingkungan Kerja Bebas Asap Rokok Tutup&lt;/p&gt;', NULL, 1, '28-02-2021');

-- --------------------------------------------------------

--
-- Table structure for table `umb_type_perusahaan`
--

CREATE TABLE `umb_type_perusahaan` (
  `type_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_type_perusahaan`
--

TRUNCATE TABLE `umb_type_perusahaan`;
--
-- Dumping data for table `umb_type_perusahaan`
--

INSERT INTO `umb_type_perusahaan` (`type_id`, `name`, `created_at`) VALUES
(1, 'Perusahaan', ''),
(2, 'Organisasi yang Dikecualikan', ''),
(3, 'Partnership', ''),
(4, 'Yayasan Swasta', ''),
(5, 'Perseroan Terbatas', '');

-- --------------------------------------------------------

--
-- Table structure for table `umb_type_kontrak`
--

CREATE TABLE `umb_type_kontrak` (
  `type_kontrak_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_type_kontrak`
--

TRUNCATE TABLE `umb_type_kontrak`;
--
-- Dumping data for table `umb_type_kontrak`
--

INSERT INTO `umb_type_kontrak` (`type_kontrak_id`, `perusahaan_id`, `name`, `created_at`) VALUES
(1, 1, 'Permanent', '01-01-2021 06:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `umb_negaraa`
--

CREATE TABLE `umb_negaraa` (
  `negara_id` int(11) NOT NULL,
  `kode_negara` varchar(255) NOT NULL,
  `nama_negara` varchar(255) NOT NULL,
  `negara_flag` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_negaraa`
--

TRUNCATE TABLE `umb_negaraa`;
--
-- Dumping data for table `umb_negaraa`
--

INSERT INTO `umb_negaraa` (`negara_id`, `kode_negara`, `nama_negara`, `negara_flag`) VALUES
(1, '+93', 'Afghanistan', 'flag_1500831780.gif'),
(2, '+355', 'Albania', 'flag_1500831815.gif'),
(3, 'DZ', 'Algeria', ''),
(4, 'DS', 'American Samoa', ''),
(5, 'AD', 'Andorra', ''),
(6, 'AO', 'Angola', ''),
(7, 'AI', 'Anguilla', ''),
(8, 'AQ', 'Antarctica', ''),
(9, 'AG', 'Antigua and Barbuda', ''),
(10, 'AR', 'Argentina', ''),
(11, 'AM', 'Armenia', ''),
(12, 'AW', 'Aruba', ''),
(13, 'AU', 'Australia', ''),
(14, 'AT', 'Austria', ''),
(15, 'AZ', 'Azerbaijan', ''),
(16, 'BS', 'Bahamas', ''),
(17, 'BH', 'Bahrain', ''),
(18, 'BD', 'Bangladesh', ''),
(19, 'BB', 'Barbados', ''),
(20, 'BY', 'Belarus', ''),
(21, 'BE', 'Belgium', ''),
(22, 'BZ', 'Belize', ''),
(23, 'BJ', 'Benin', ''),
(24, 'BM', 'Bermuda', ''),
(25, 'BT', 'Bhutan', ''),
(26, 'BO', 'Bolivia', ''),
(27, 'BA', 'Bosnia and Herzegovina', ''),
(28, 'BW', 'Botswana', ''),
(29, 'BV', 'Bouvet Island', ''),
(30, 'BR', 'Brazil', ''),
(31, 'IO', 'British Indian Ocean Territory', ''),
(32, 'BN', 'Brunei Darussalam', ''),
(33, 'BG', 'Bulgaria', ''),
(34, 'BF', 'Burkina Faso', ''),
(35, 'BI', 'Burundi', ''),
(36, 'KH', 'Cambodia', ''),
(37, 'CM', 'Cameroon', ''),
(38, 'CA', 'Canada', ''),
(39, 'CV', 'Cape Verde', ''),
(40, 'KY', 'Cayman Islands', ''),
(41, 'CF', 'Central African Republic', ''),
(42, 'TD', 'Chad', ''),
(43, 'CL', 'Chile', ''),
(44, 'CN', 'China', ''),
(45, 'CX', 'Christmas Island', ''),
(46, 'CC', 'Cocos (Keeling) Islands', ''),
(47, 'CO', 'Colombia', ''),
(48, 'KM', 'Comoros', ''),
(49, 'CG', 'Congo', ''),
(50, 'CK', 'Cook Islands', ''),
(51, 'CR', 'Costa Rica', ''),
(52, 'HR', 'Croatia (Hrvatska)', ''),
(53, 'CU', 'Cuba', ''),
(54, 'CY', 'Cyprus', ''),
(55, 'CZ', 'Czech Republic', ''),
(56, 'DK', 'Denmark', ''),
(57, 'DJ', 'Djibouti', ''),
(58, 'DM', 'Dominica', ''),
(59, 'DO', 'Dominican Republic', ''),
(60, 'TP', 'East Timor', ''),
(61, 'EC', 'Ecuador', ''),
(62, 'EG', 'Egypt', ''),
(63, 'SV', 'El Salvador', ''),
(64, 'GQ', 'Equatorial Guinea', ''),
(65, 'ER', 'Eritrea', ''),
(66, 'EE', 'Estonia', ''),
(67, 'ET', 'Ethiopia', ''),
(68, 'FK', 'Falkland Islands (Malvinas)', ''),
(69, 'FO', 'Faroe Islands', ''),
(70, 'FJ', 'Fiji', ''),
(71, 'FI', 'Finland', ''),
(72, 'FR', 'France', ''),
(73, 'FX', 'France, Metropolitan', ''),
(74, 'GF', 'French Guiana', ''),
(75, 'PF', 'French Polynesia', ''),
(76, 'TF', 'French Southern Territories', ''),
(77, 'GA', 'Gabon', ''),
(78, 'GM', 'Gambia', ''),
(79, 'GE', 'Georgia', ''),
(80, 'DE', 'Germany', ''),
(81, 'GH', 'Ghana', ''),
(82, 'GI', 'Gibraltar', ''),
(83, 'GK', 'Guernsey', ''),
(84, 'GR', 'Greece', ''),
(85, 'GL', 'Greenland', ''),
(86, 'GD', 'Grenada', ''),
(87, 'GP', 'Guadeloupe', ''),
(88, 'GU', 'Guam', ''),
(89, 'GT', 'Guatemala', ''),
(90, 'GN', 'Guinea', ''),
(91, 'GW', 'Guinea-Bissau', ''),
(92, 'GY', 'Guyana', ''),
(93, 'HT', 'Haiti', ''),
(94, 'HM', 'Heard and Mc Donald Islands', ''),
(95, 'HN', 'Honduras', ''),
(96, 'HK', 'Hong Kong', ''),
(97, 'HU', 'Hungary', ''),
(98, 'IS', 'Iceland', ''),
(99, 'IN', 'India', ''),
(100, 'IM', 'Isle of Man', ''),
(101, 'ID', 'Indonesia', ''),
(102, 'IR', 'Iran (Islamic Republic of)', ''),
(103, 'IQ', 'Iraq', ''),
(104, 'IE', 'Ireland', ''),
(105, 'IL', 'Israel', ''),
(106, 'IT', 'Italy', ''),
(107, 'CI', 'Ivory Coast', ''),
(108, 'JE', 'Jersey', ''),
(109, 'JM', 'Jamaica', ''),
(110, 'JP', 'Japan', ''),
(111, 'JO', 'Jordan', ''),
(112, 'KZ', 'Kazakhstan', ''),
(113, 'KE', 'Kenya', ''),
(114, 'KI', 'Kiribati', ''),
(115, 'KP', 'Korea, Democratic People\'s Republic of', ''),
(116, 'KR', 'Korea, Republic of', ''),
(117, 'XK', 'Kosovo', ''),
(118, 'KW', 'Kuwait', ''),
(119, 'KG', 'Kyrgyzstan', ''),
(120, 'LA', 'Lao People\'s Democratic Republic', ''),
(121, 'LV', 'Latvia', ''),
(122, 'LB', 'Lebanon', ''),
(123, 'LS', 'Lesotho', ''),
(124, 'LR', 'Liberia', ''),
(125, 'LY', 'Libyan Arab Jamahiriya', ''),
(126, 'LI', 'Liechtenstein', ''),
(127, 'LT', 'Lithuania', ''),
(128, 'LU', 'Luxembourg', ''),
(129, 'MO', 'Macau', ''),
(130, 'MK', 'Macedonia', ''),
(131, 'MG', 'Madagascar', ''),
(132, 'MW', 'Malawi', ''),
(133, 'MY', 'Malaysia', ''),
(134, 'MV', 'Maldives', ''),
(135, 'ML', 'Mali', ''),
(136, 'MT', 'Malta', ''),
(137, 'MH', 'Marshall Islands', ''),
(138, 'MQ', 'Martinique', ''),
(139, 'MR', 'Mauritania', ''),
(140, 'MU', 'Mauritius', ''),
(141, 'TY', 'Mayotte', ''),
(142, 'MX', 'Mexico', ''),
(143, 'FM', 'Micronesia, Federated States of', ''),
(144, 'MD', 'Moldova, Republic of', ''),
(145, 'MC', 'Monaco', ''),
(146, 'MN', 'Mongolia', ''),
(147, 'ME', 'Montenegro', ''),
(148, 'MS', 'Montserrat', ''),
(149, 'MA', 'Morocco', ''),
(150, 'MZ', 'Mozambique', ''),
(151, 'MM', 'Myanmar', ''),
(152, 'NA', 'Namibia', ''),
(153, 'NR', 'Nauru', ''),
(154, 'NP', 'Nepal', ''),
(155, 'NL', 'Netherlands', ''),
(156, 'AN', 'Netherlands Antilles', ''),
(157, 'NC', 'New Caledonia', ''),
(158, 'NZ', 'New Zealand', ''),
(159, 'NI', 'Nicaragua', ''),
(160, 'NE', 'Niger', ''),
(161, 'NG', 'Nigeria', ''),
(162, 'NU', 'Niue', ''),
(163, 'NF', 'Norfolk Island', ''),
(164, 'MP', 'Northern Mariana Islands', ''),
(165, 'NO', 'Norway', ''),
(166, 'OM', 'Oman', ''),
(167, 'PK', 'Pakistan', ''),
(168, 'PW', 'Palau', ''),
(169, 'PS', 'Palestine', ''),
(170, 'PA', 'Panama', ''),
(171, 'PG', 'Papua New Guinea', ''),
(172, 'PY', 'Paraguay', ''),
(173, 'PE', 'Peru', ''),
(174, 'PH', 'Philippines', ''),
(175, 'PN', 'Pitcairn', ''),
(176, 'PL', 'Poland', ''),
(177, 'PT', 'Portugal', ''),
(178, 'PR', 'Puerto Rico', ''),
(179, 'QA', 'Qatar', ''),
(180, 'RE', 'Reunion', ''),
(181, 'RO', 'Romania', ''),
(182, 'RU', 'Russian Federation', ''),
(183, 'RW', 'Rwanda', ''),
(184, 'KN', 'Saint Kitts and Nevis', ''),
(185, 'LC', 'Saint Lucia', ''),
(186, 'VC', 'Saint Vincent and the Grenadines', ''),
(187, 'WS', 'Samoa', ''),
(188, 'SM', 'San Marino', ''),
(189, 'ST', 'Sao Tome and Principe', ''),
(190, 'SA', 'Saudi Arabia', ''),
(191, 'SN', 'Senegal', ''),
(192, 'RS', 'Serbia', ''),
(193, 'SC', 'Seychelles', ''),
(194, 'SL', 'Sierra Leone', ''),
(195, 'SG', 'Singapore', ''),
(196, 'SK', 'Slovakia', ''),
(197, 'SI', 'Slovenia', ''),
(198, 'SB', 'Solomon Islands', ''),
(199, 'SO', 'Somalia', ''),
(200, 'ZA', 'South Africa', ''),
(201, 'GS', 'South Georgia South Sandwich Islands', ''),
(202, 'ES', 'Spain', ''),
(203, 'LK', 'Sri Lanka', ''),
(204, 'SH', 'St. Helena', ''),
(205, 'PM', 'St. Pierre and Miquelon', ''),
(206, 'SD', 'Sudan', ''),
(207, 'SR', 'Suriname', ''),
(208, 'SJ', 'Svalbard and Jan Mayen Islands', ''),
(209, 'SZ', 'Swaziland', ''),
(210, 'SE', 'Sweden', ''),
(211, 'CH', 'Switzerland', ''),
(212, 'SY', 'Syrian Arab Republic', ''),
(213, 'TW', 'Taiwan', ''),
(214, 'TJ', 'Tajikistan', ''),
(215, 'TZ', 'Tanzania, United Republic of', ''),
(216, 'TH', 'Thailand', ''),
(217, 'TG', 'Togo', ''),
(218, 'TK', 'Tokelau', ''),
(219, 'TO', 'Tonga', ''),
(220, 'TT', 'Trinidad and Tobago', ''),
(221, 'TN', 'Tunisia', ''),
(222, 'TR', 'Turkey', ''),
(223, 'TM', 'Turkmenistan', ''),
(224, 'TC', 'Turks and Caicos Islands', ''),
(225, 'TV', 'Tuvalu', ''),
(226, 'UG', 'Uganda', ''),
(227, 'UA', 'Ukraine', ''),
(228, 'AE', 'United Arab Emirates', ''),
(229, 'GB', 'United Kingdom', ''),
(230, 'US', 'United States', ''),
(231, 'UM', 'United States minor outlying islands', ''),
(232, 'UY', 'Uruguay', ''),
(233, 'UZ', 'Uzbekistan', ''),
(234, 'VU', 'Vanuatu', ''),
(235, 'VA', 'Vatican City State', ''),
(236, 'VE', 'Venezuela', ''),
(237, 'VN', 'Vietnam', ''),
(238, 'VG', 'Virgin Islands (British)', ''),
(239, 'VI', 'Virgin Islands (U.S.)', ''),
(240, 'WF', 'Wallis and Futuna Islands', ''),
(241, 'EH', 'Western Sahara', ''),
(242, 'YE', 'Yemen', ''),
(243, 'ZR', 'Zaire', ''),
(244, 'ZM', 'Zambia', ''),
(245, 'ZW', 'Zimbabwe', '');

-- --------------------------------------------------------

--
-- Table structure for table `umb_currencies`
--

CREATE TABLE `umb_currencies` (
  `currency_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_currencies`
--

TRUNCATE TABLE `umb_currencies`;
--
-- Dumping data for table `umb_currencies`
--

INSERT INTO `umb_currencies` (`currency_id`, `perusahaan_id`, `name`, `code`, `symbol`) VALUES
(1, 1, 'Rupiah', 'IDR', 'Rp'),
(2, 1, 'Dollars', 'USD', '$');

-- --------------------------------------------------------

--
-- Table structure for table `umb_currency_converter`
--

CREATE TABLE `umb_currency_converter` (
  `currency_converter_id` int(11) NOT NULL,
  `usd_currency` varchar(11) NOT NULL DEFAULT '1',
  `to_currency_title` varchar(200) NOT NULL,
  `to_currency_rate` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_currency_converter`
--

TRUNCATE TABLE `umb_currency_converter`;
--
-- Dumping data for table `umb_currency_converter`
--

INSERT INTO `umb_currency_converter` (`currency_converter_id`, `usd_currency`, `to_currency_title`, `to_currency_rate`, `created_at`) VALUES
(1, '1', 'MYR', '4.11', '17-02-2021 03:29:58');

-- --------------------------------------------------------

--
-- Table structure for table `umb_database_backup`
--

CREATE TABLE `umb_database_backup` (
  `backup_id` int(111) NOT NULL,
  `backup_file` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_database_backup`
--

TRUNCATE TABLE `umb_database_backup`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_departments`
--

CREATE TABLE `umb_departments` (
  `department_id` int(11) NOT NULL,
  `nama_department` varchar(200) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `location_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_departments`
--

TRUNCATE TABLE `umb_departments`;
--
-- Dumping data for table `umb_departments`
--

INSERT INTO `umb_departments` (`department_id`, `nama_department`, `perusahaan_id`, `location_id`, `karyawan_id`, `added_by`, `created_at`, `status`) VALUES
(1, 'MD Office', 1, 1, 5, 0, '06-01-2021', 1),
(2, 'Accounts and  Finances', 1, 1, 5, 1, '17-01-2021', 1);

-- --------------------------------------------------------

--
-- Table structure for table `umb_penunjukans`
--

CREATE TABLE `umb_penunjukans` (
  `penunjukan_id` int(11) NOT NULL,
  `top_penunjukan_id` int(11) NOT NULL DEFAULT 0,
  `department_id` int(200) NOT NULL,
  `sub_department_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `nama_penunjukan` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_penunjukans`
--

TRUNCATE TABLE `umb_penunjukans`;
--
-- Dumping data for table `umb_penunjukans`
--

INSERT INTO `umb_penunjukans` (`penunjukan_id`, `top_penunjukan_id`, `department_id`, `sub_department_id`, `perusahaan_id`, `nama_penunjukan`, `description`, `added_by`, `created_at`, `status`) VALUES
(9, 0, 1, 8, 1, 'Software Developer', '', 1, '01-01-2021', 1),
(10, 0, 2, 10, 1, 'Finance', '', 1, '18-01-2021', 1);

-- --------------------------------------------------------

--
-- Table structure for table `umb_type_document`
--

CREATE TABLE `umb_type_document` (
  `type_document_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `type_document` varchar(255) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_type_document`
--

TRUNCATE TABLE `umb_type_document`;
--
-- Dumping data for table `umb_type_document`
--

INSERT INTO `umb_type_document` (`type_document_id`, `perusahaan_id`, `type_document`, `created_at`) VALUES
(1, 1, 'Surat ijin Mengemudi', '01-01-2021 12:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `umb_email_configuration`
--

CREATE TABLE `umb_email_configuration` (
  `email_config_id` int(11) NOT NULL,
  `email_type` enum('phpmail','smtp','codeigniter') COLLATE utf8_unicode_ci NOT NULL,
  `smtp_host` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_port` int(11) NOT NULL,
  `smtp_secure` enum('tls','ssl') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `umb_email_configuration`
--

TRUNCATE TABLE `umb_email_configuration`;
--
-- Dumping data for table `umb_email_configuration`
--

INSERT INTO `umb_email_configuration` (`email_config_id`, `email_type`, `smtp_host`, `smtp_username`, `smtp_password`, `smtp_port`, `smtp_secure`) VALUES
(1, 'phpmail', 'smtp.gmail.com', 'demo@gmail.com', '123456', 587, 'tls');

-- --------------------------------------------------------

--
-- Table structure for table `umb_email_template`
--

CREATE TABLE `umb_email_template` (
  `template_id` int(111) NOT NULL,
  `template_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_email_template`
--

TRUNCATE TABLE `umb_email_template`;
--
-- Dumping data for table `umb_email_template`
--

INSERT INTO `umb_email_template` (`template_id`, `template_code`, `name`, `subject`, `message`, `status`) VALUES
(2, 'code1', 'Forgot Password', 'Forgot Password', '                            <p><span xss=\"removed\">Hello,</span></p><p><span xss=\"removed\">There was recently a request for password for your {var site_name} account.</span></p><p><span xss=\"removed\">If this was a mistake, just ignore this email and nothing will happen.</span></p><p><span xss=\"removed\">To reset your password, visit the following link <a href=\"{var reset_url}admin/reset_password?change=true&email={var email}\">Reset Password</a></span></p><p><span xss=\"removed\">Regards,</span></p><p><span xss=\"removed\">The {var site_name} Team</span></p>', 1),
(3, 'code2', 'New Project', 'New Project', '                                <p>Hi {var nama_karyawan},</p><p>New project has been assigned to you.</p><p>Project Name: {var nama_project}</p><p>Project Start Date: <span>{var project_start_date}</span></p><p><br><span>You can view the project by logging in to the portal using the link below.</span></p><p><span>{var site_url}admin/</span></p><p><span>Regards</span><br></p><p>The {var site_name} Team</p>', 1),
(5, 'code3', 'Leave Request ', 'A Leave Request from you', '            <p>Dear Admin,</p><p>{var nama_karyawan} wants a leave from you.</p><p>You can view this leave request by logging in to the portal using the link below.</p><p>{var site_url}admin/<br><br>Regards,</p><p>The {var site_name} Team</p>', 1),
(6, 'code4', 'Leave Approve', 'Your leave request has been approved', '                <p>Hello,</p><p>Your leave request has been approved</p><p><span xss=\"removed\">Congratulations! </span>Your leave request from<font face=\"sans-serif, Arial, Verdana, Trebuchet MS\" color=\"#333333\"> </font>{var cuti_start_date} to {var cuti_end_date} has been approved by your perusahaan management.</p><p><span>You can view the leave by logging in to the portal using the link below.</span></p><p>{var site_url}admin/<br></p><p>Regards,<br>The {var site_name} Team</p>', 1),
(7, 'code5', 'Leave Reject', 'Your leave request has been Rejected', '                <p>Hello,</p><p>Your leave request has been Rejected</p><p>Unfortunately! Your leave request from {var cuti_start_date} to {var cuti_end_date} has been Rejected by your perusahaan management.</p><p><span>You can view the leave by logging in to the portal using the link below.</span></p><p>{var site_url}admin/</p><p>Regards,</p><p>The {var site_name} Team</p>', 1),
(8, 'code6', 'Welcome Email ', 'Welcome Email ', '            <p>Hello {var nama_karyawan},</p><p>Welcome to {var site_name} .Thanks for joining {var site_name}. We listed your sign in details below, make sure you keep them safe.</p><p>Your Username: {var username}</p><p>Your karyawan ID: {var karyawan_id}</p><p>Your Email Address: {var email}<br></p><p>Your Password: {var password}</p><p>Your Password: {var pincode}</p><p><span>You can logging in to the portal using the link below</span></p><p>{var site_url}admin/</p><br><p>Thank you,</p><p>The {var site_name} Team</p>', 1),
(9, 'code7', 'Transfer', 'New Transfer', '        <p>Hello {var nama_karyawan},</p><p>You have been transfered to another department and location.</p><p>You can view the transfer details by logging in to the portal using the link below.</p><p>{var site_url}admin/</p><p>Regards,</p><p>The {var site_name} Team</p>', 1),
(10, 'code8', 'award', 'New award Received', '    <p>Hello {var nama_karyawan},</p><p>You have been awarded {var nama_award}.</p><p>You can view this award by logging in to the portal using the link below.</p><p><span xss=\"removed\">{var site_url}admin</span><span xss=\"removed\">/awards/</span><br></p><p>Regards,</p><p>The {var site_name} Team</p>', 1),
(14, 'code9', 'New tugas', 'tugas assigned', '    <p>Hi {nama_karyawan},</p><p>A new tugas <span>{var nama_tugas}</span> has been assigned to [{nama_project}]</p><p>You can view this tugas by logging in to the portal using the link below.</p><p>{var site_url}</p><p>Regards,</p><p>The {var site_name} Team</p>', 1),
(15, 'code10', 'New Inquiry', 'New Inquiry [#{var kode_ticket}]', '    <p xss=\"\\\\\\\\\" rgb(51,=\"\\\" font-family:=\"\\\" sans-serif,=\"\\\" arial,=\"\\\" verdana,=\"\\\\\" trebuchet=\"\\\\\\\\\"><span xss=\"\\\\\\\\\">Hi,</span><br></p><p xss=\"\\\\\\\\\" rgb(51,=\"\\\" font-family:=\"\\\" sans-serif,=\"\\\" arial,=\"\\\" verdana,=\"\\\\\" trebuchet=\"\\\\\\\\\"><span xss=\"\\\\\\\\\">Your received a new inquiry.</span></p><p xss=\"\\\\\\\\\" rgb(51,=\"\\\" font-family:=\"\\\" sans-serif,=\"\\\" arial,=\"\\\" verdana,=\"\\\\\" trebuchet=\"\\\\\\\\\"><span xss=\"\\\\\\\\\">Inquiry Code: #{var kode_ticket}</span></p><p xss=\"\\\\\\\\\" rgb(51,=\"\\\" font-family:=\"\\\" sans-serif,=\"\\\" arial,=\"\\\" verdana,=\"\\\\\" trebuchet=\"\\\\\\\\\">Status : Open<br><br>Click on the below link to see the inquiry details and post additional comments.</p><p xss=\"\\\\\\\\\" rgb(51,=\"\\\" font-family:=\"\\\" sans-serif,=\"\\\" arial,=\"\\\" verdana,=\"\\\\\" trebuchet=\"\\\\\\\\\">{var site_url}admin/<br><br>Regards,</p><p xss=\"\\\\\\\\\" rgb(51,=\"\\\" font-family:=\"\\\" sans-serif,=\"\\\" arial,=\"\\\" verdana,=\"\\\\\" trebuchet=\"\\\\\\\\\">The {var site_name} Team</p>', 1),
(16, 'code11', 'Client Welcome Email', 'Welcome Email', '        <p>Hello {var name_client},</p><p>Welcome to {var site_name}. Thanks for joining {var site_name}. We listed your sign in details below, make sure you keep them safe. You can login to your panel using email and password.</p><p>Your Username: {var username}</p><p><span xss=\"\\\\\\\\\">Your Email Address: {var email}</span></p><p>Your Password: {var password}<br></p><p>{var site_url}client/</p><p>Have fun!</p><p>The {var site_name} Team</p>', 1),
(17, 'code12', 'Password Changed Successfully', 'Password Changed Successfully', '    <p>Hello,</p><p>Congratulations! Your password has been updated successfully.</p><p>Your new password is: {var password}</p><p>Your new pincode: {var pincode}<br></p><p>Thank you,<br>The {var site_name} Team<br></p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `umb_karyawans`
--

CREATE TABLE `umb_karyawans` (
  `user_id` int(11) NOT NULL,
  `karyawan_id` varchar(200) NOT NULL,
  `shift_kantor_id` int(111) NOT NULL,
  `laporans_to` int(11) NOT NULL DEFAULT 0,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `pincode` int(11) NOT NULL,
  `password` varchar(200) NOT NULL,
  `tanggal_lahir` varchar(200) NOT NULL,
  `jenis_kelamin` varchar(200) NOT NULL,
  `e_status` int(11) NOT NULL,
  `user_role_id` int(100) NOT NULL,
  `department_id` int(100) NOT NULL,
  `sub_department_id` int(11) NOT NULL,
  `penunjukan_id` int(100) NOT NULL,
  `perusahaan_id` int(111) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `view_perusahaans_id` varchar(255) NOT NULL,
  `gaji_template` varchar(255) NOT NULL,
  `hourly_grade_id` int(111) NOT NULL,
  `monthly_grade_id` int(111) NOT NULL,
  `tanggal_bergabung` varchar(200) NOT NULL,
  `date_of_leaving` varchar(255) NOT NULL,
  `status_perkawinan` varchar(255) NOT NULL,
  `gaji` varchar(200) NOT NULL,
  `type_upahh` int(11) NOT NULL,
  `gaji_pokok` varchar(200) NOT NULL DEFAULT '0',
  `upahh_harian` varchar(200) NOT NULL DEFAULT '0',
  `gaji_ssempee` varchar(200) NOT NULL DEFAULT '0',
  `gaji_ssempeer` varchar(200) DEFAULT '0',
  `gaji_pajak_pendapatan` varchar(200) NOT NULL DEFAULT '0',
  `gaji_lembur` varchar(200) NOT NULL DEFAULT '0',
  `gaji_komisi` varchar(200) NOT NULL DEFAULT '0',
  `claims_gaji` varchar(200) NOT NULL DEFAULT '0',
  `gaji_bayar_cuti` varchar(200) NOT NULL DEFAULT '0',
  `gaji_director_fees` varchar(200) NOT NULL DEFAULT '0',
  `gaji_bonus` varchar(200) NOT NULL DEFAULT '0',
  `bayar_gaji_advance` varchar(200) NOT NULL DEFAULT '0',
  `alamat` mediumtext NOT NULL,
  `provinsi` varchar(200) NOT NULL,
  `kota` varchar(200) NOT NULL,
  `kode_pos` varchar(200) NOT NULL,
  `profile_picture` mediumtext NOT NULL,
  `profile_background` mediumtext NOT NULL,
  `resume` mediumtext NOT NULL,
  `skype_id` varchar(200) NOT NULL,
  `no_kontak` varchar(200) NOT NULL,
  `facebook_link` mediumtext NOT NULL,
  `twitter_link` mediumtext NOT NULL,
  `blogger_link` mediumtext NOT NULL,
  `linkdedin_link` mediumtext NOT NULL,
  `google_plus_link` mediumtext NOT NULL,
  `instagram_link` varchar(255) NOT NULL,
  `pinterest_link` varchar(255) NOT NULL,
  `youtube_link` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `tanggal_terakhir_login` varchar(255) NOT NULL,
  `terakhir_logout_tanggal` varchar(255) NOT NULL,
  `terakhir_login_ip` varchar(255) NOT NULL,
  `is_logged_in` int(111) NOT NULL,
  `online_status` int(111) NOT NULL,
  `fixed_header` varchar(150) NOT NULL,
  `compact_sidebar` varchar(150) NOT NULL,
  `boxed_wrapper` varchar(150) NOT NULL,
  `kategoris_cuti` varchar(255) NOT NULL DEFAULT '0',
  `type_sukubangsa` int(11) NOT NULL,
  `golongan_darah` varchar(50) DEFAULT NULL,
  `kewarganegaraan_id` int(11) NOT NULL,
  `kebangsaan_id` int(11) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_karyawans`
--

TRUNCATE TABLE `umb_karyawans`;
--
-- Dumping data for table `umb_karyawans`
--

INSERT INTO `umb_karyawans` (`user_id`, `karyawan_id`, `shift_kantor_id`, `laporans_to`, `first_name`, `last_name`, `username`, `email`, `pincode`, `password`, `tanggal_lahir`, `jenis_kelamin`, `e_status`, `user_role_id`, `department_id`, `sub_department_id`, `penunjukan_id`, `perusahaan_id`, `location_id`, `view_perusahaans_id`, `gaji_template`, `hourly_grade_id`, `monthly_grade_id`, `tanggal_bergabung`, `date_of_leaving`, `status_perkawinan`, `gaji`, `type_upahh`, `gaji_pokok`, `upahh_harian`, `gaji_ssempee`, `gaji_ssempeer`, `gaji_pajak_pendapatan`, `gaji_lembur`, `gaji_komisi`, `claims_gaji`, `gaji_bayar_cuti`, `gaji_director_fees`, `gaji_bonus`, `bayar_gaji_advance`, `alamat`, `provinsi`, `kota`, `kode_pos`, `profile_picture`, `profile_background`, `resume`, `skype_id`, `no_kontak`, `facebook_link`, `twitter_link`, `blogger_link`, `linkdedin_link`, `google_plus_link`, `instagram_link`, `pinterest_link`, `youtube_link`, `is_active`, `tanggal_terakhir_login`, `terakhir_logout_tanggal`, `terakhir_login_ip`, `is_logged_in`, `online_status`, `fixed_header`, `compact_sidebar`, `boxed_wrapper`, `kategoris_cuti`, `type_sukubangsa`, `golongan_darah`, `kewarganegaraan_id`, `kebangsaan_id`, `created_at`) VALUES
(1, 'riyansetiawan', 1, 0, 'Riyan', 'Setiawan', 'riyansetiawan', 'riyansetiawan@gmail.com', 0, '$2y$12$shA/jAqdaiuod7JBJSXryOmvmy50gBY8VmvMmu9gVDSQ1ODNa/d6e', '2021-01-01', 'Pria', 0, 1, 2, 0, 10, 1, 1, '0', 'monthly', 0, 0, '2021-01-01', '', 'Single', '', 1, '1000', '0', '8', '17', '10', '0', '1', '2', '3', '0', '0', '0', 'Test Address', '', '', '', 'profile_1546421723.png', 'profile_background_1519924152.jpg', '', '', '12345678900', '', '', '', '', '', '', '', '', 1, '01-01-2021 19:04:50', '09-08-2021 08:25:59', '::1', 1, 1, 'fixed_layout_hrastral', '', '', '0,1,2', 0, NULL, 0, 0, '2021-01-01 05:30:44'),
(5, 'jsmith12', 1, 0, 'Herman', 'Sutrisno', 'hermansutrisno', 'hermansutrisno@hrastral.com', 0, '$2y$12$zjBiQwIQG7vmgGeq935iqOCDiQVREZgA3VsN44YderDI5YoXKkWdi', '2021-01-01', 'Pria', 0, 2, 2, 10, 10, 1, 0, '', 'monthly', 0, 0, '2021-01-02', '', 'Single', '', 1, '1000', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'jsmt12', '', '', '', '', '', '', '', '1232', '', '', '', '', '', '', '', '', 1, '01-01-2021 08:42:32', '01-01-2021 07:31:01', '::1', 1, 1, '', '', '', '0,1,2', 0, NULL, 0, 0, '2021-01-01 01:10:04');

-- --------------------------------------------------------

--
-- Table structure for table `umb_karyawan_bankaccount`
--

CREATE TABLE `umb_karyawan_bankaccount` (
  `bankaccount_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `is_primary` int(11) NOT NULL,
  `account_title` varchar(255) NOT NULL,
  `nomor_account` varchar(255) NOT NULL,
  `nama_bank` varchar(255) NOT NULL,
  `kode_bank` varchar(255) NOT NULL,
  `cabang_bank` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_karyawan_bankaccount`
--

TRUNCATE TABLE `umb_karyawan_bankaccount`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_keluhans_karyawan`
--

CREATE TABLE `umb_keluhans_karyawan` (
  `keluhan_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `keluhan_dari` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `tanggal_keluhan` varchar(255) NOT NULL,
  `keluhan_terhadap` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_keluhans_karyawan`
--

TRUNCATE TABLE `umb_keluhans_karyawan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_kontaks_karyawan`
--

CREATE TABLE `umb_kontaks_karyawan` (
  `kontak_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `relation` varchar(255) NOT NULL,
  `is_primary` int(111) NOT NULL,
  `is_dependent` int(111) NOT NULL,
  `kontak_name` varchar(255) NOT NULL,
  `phone_kerja` varchar(255) NOT NULL,
  `extension_phone_kerja` varchar(255) NOT NULL,
  `mobile_phone` varchar(255) NOT NULL,
  `home_phone` varchar(255) NOT NULL,
  `email_kerja` varchar(255) NOT NULL,
  `email_pribadi` varchar(255) NOT NULL,
  `alamat_1` mediumtext NOT NULL,
  `alamat_2` mediumtext NOT NULL,
  `kota` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `kode_pos` varchar(255) NOT NULL,
  `negara` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_kontaks_karyawan`
--

TRUNCATE TABLE `umb_kontaks_karyawan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_karyawan_kontrak`
--

CREATE TABLE `umb_karyawan_kontrak` (
  `kontrak_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `type_kontrak_id` int(111) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `penunjukan_id` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_karyawan_kontrak`
--

TRUNCATE TABLE `umb_karyawan_kontrak`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_documents_karyawan`
--

CREATE TABLE `umb_documents_karyawan` (
  `document_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `type_document_id` int(111) NOT NULL,
  `tanggal_kadaluarsa` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `notification_email` varchar(255) NOT NULL,
  `is_alert` tinyint(1) NOT NULL,
  `description` mediumtext NOT NULL,
  `document_file` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_documents_karyawan`
--

TRUNCATE TABLE `umb_documents_karyawan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_karyawan_exit`
--

CREATE TABLE `umb_karyawan_exit` (
  `exit_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `exit_tanggal` varchar(255) NOT NULL,
  `type_exit_id` int(111) NOT NULL,
  `exit_interview` int(111) NOT NULL,
  `is_inactivate_account` int(111) NOT NULL,
  `reason` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_karyawan_exit`
--

TRUNCATE TABLE `umb_karyawan_exit`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_karyawan_type_exit`
--

CREATE TABLE `umb_karyawan_type_exit` (
  `type_exit_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_karyawan_type_exit`
--

TRUNCATE TABLE `umb_karyawan_type_exit`;
--
-- Dumping data for table `umb_karyawan_type_exit`
--

INSERT INTO `umb_karyawan_type_exit` (`type_exit_id`, `perusahaan_id`, `type`, `created_at`) VALUES
(1, 1, 'Test', '');

-- --------------------------------------------------------

--
-- Table structure for table `umb_karyawan_immigration`
--

CREATE TABLE `umb_karyawan_immigration` (
  `immigration_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `type_document_id` int(111) NOT NULL,
  `nomor_document` varchar(255) NOT NULL,
  `document_file` varchar(255) NOT NULL,
  `tanggal_terbit` varchar(255) NOT NULL,
  `tanggal_kaaluarsa` varchar(255) NOT NULL,
  `negara_id` varchar(255) NOT NULL,
  `tanggal_tinjauan_yang_memenuhi_syarat` varchar(255) NOT NULL,
  `comments` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_karyawan_immigration`
--

TRUNCATE TABLE `umb_karyawan_immigration`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_karyawan_cuti`
--

CREATE TABLE `umb_karyawan_cuti` (
  `cuti_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `kontrak_id` int(111) NOT NULL,
  `casual_cuti` varchar(255) NOT NULL,
  `medical_cuti` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_karyawan_cuti`
--

TRUNCATE TABLE `umb_karyawan_cuti`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_location_karyawan`
--

CREATE TABLE `umb_location_karyawan` (
  `location_kantor_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `location_id` int(111) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_location_karyawan`
--

TRUNCATE TABLE `umb_location_karyawan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_promotions_karyawan`
--

CREATE TABLE `umb_promotions_karyawan` (
  `promotion_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `tanggal_promotion` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_promotions_karyawan`
--

TRUNCATE TABLE `umb_promotions_karyawan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_karyawan_qualification`
--

CREATE TABLE `umb_karyawan_qualification` (
  `qualification_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tingkat_pendidikan_id` int(111) NOT NULL,
  `from_year` varchar(255) NOT NULL,
  `language_id` int(111) NOT NULL,
  `to_year` varchar(255) NOT NULL,
  `skill_id` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_karyawan_qualification`
--

TRUNCATE TABLE `umb_karyawan_qualification`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_pengundurans_diri_karyawan`
--

CREATE TABLE `umb_pengundurans_diri_karyawan` (
  `pengunduran_diri_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `penunjukan_id` int(11) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `tangggal_pemberitahuan` varchar(255) NOT NULL,
  `tanggal_pengunduran_diri` varchar(255) NOT NULL,
  `reason` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_pengundurans_diri_karyawan`
--

TRUNCATE TABLE `umb_pengundurans_diri_karyawan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_karyawan_security_level`
--

CREATE TABLE `umb_karyawan_security_level` (
  `security_level_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `security_type` int(11) NOT NULL,
  `date_of_clearance` varchar(200) NOT NULL,
  `tanggal_kaaluarsa` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_karyawan_security_level`
--

TRUNCATE TABLE `umb_karyawan_security_level`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_karyawan_shift`
--

CREATE TABLE `umb_karyawan_shift` (
  `emp_shift_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `shift_id` int(111) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_karyawan_shift`
--

TRUNCATE TABLE `umb_karyawan_shift`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_penghentians_karyawan`
--

CREATE TABLE `umb_penghentians_karyawan` (
  `penghentian_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `diberhentikan_oleh` int(111) NOT NULL,
  `type_penghentian_id` int(111) NOT NULL,
  `tanggal_penghentian` varchar(255) NOT NULL,
  `tangggal_pemberitahuan` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_penghentians_karyawan`
--

TRUNCATE TABLE `umb_penghentians_karyawan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_karyawan_transfer`
--

CREATE TABLE `umb_karyawan_transfer` (
  `transfer_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `tanggal_transfer` varchar(255) NOT NULL,
  `transfer_department` int(111) NOT NULL,
  `transfer_location` int(111) NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_karyawan_transfer`
--

TRUNCATE TABLE `umb_karyawan_transfer`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_perjalanans_karyawan`
--

CREATE TABLE `umb_perjalanans_karyawan` (
  `perjalanan_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `visit_purpose` varchar(255) NOT NULL,
  `visit_place` varchar(255) NOT NULL,
  `perjalanan_mode` int(111) DEFAULT NULL,
  `arrangement_type` int(111) DEFAULT NULL,
  `expected_budget` varchar(255) NOT NULL,
  `actual_budget` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_perjalanans_karyawan`
--

TRUNCATE TABLE `umb_perjalanans_karyawan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_peringatans_karyawan`
--

CREATE TABLE `umb_peringatans_karyawan` (
  `peringatan_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `peringatan_ke` int(111) NOT NULL,
  `peringatan_oleh` int(111) NOT NULL,
  `tanggal_peringatan` varchar(255) NOT NULL,
  `type_peringatan_id` int(111) NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_peringatans_karyawan`
--

TRUNCATE TABLE `umb_peringatans_karyawan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_karyawan_pengalaman_kerja`
--

CREATE TABLE `umb_karyawan_pengalaman_kerja` (
  `pengalaman_kerja_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `post` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_karyawan_pengalaman_kerja`
--

TRUNCATE TABLE `umb_karyawan_pengalaman_kerja`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_type_sukubangsa`
--

CREATE TABLE `umb_type_sukubangsa` (
  `type_sukubangsa_id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_type_sukubangsa`
--

TRUNCATE TABLE `umb_type_sukubangsa`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_events`
--

CREATE TABLE `umb_events` (
  `event_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` varchar(255) DEFAULT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_date` varchar(255) NOT NULL,
  `event_time` varchar(255) NOT NULL,
  `event_note` mediumtext NOT NULL,
  `event_color` varchar(200) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_events`
--

TRUNCATE TABLE `umb_events`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_biayaa`
--

CREATE TABLE `umb_biayaa` (
  `biaya_id` int(11) NOT NULL,
  `karyawan_id` int(200) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `type_biaya_id` int(200) NOT NULL,
  `billcopy_file` mediumtext NOT NULL,
  `jumlah` varchar(200) NOT NULL,
  `tanggal_pembelian` varchar(200) NOT NULL,
  `remarks` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `status_remarks` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_biayaa`
--

TRUNCATE TABLE `umb_biayaa`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_type_biaya`
--

CREATE TABLE `umb_type_biaya` (
  `type_biaya_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_type_biaya`
--

TRUNCATE TABLE `umb_type_biaya`;
--
-- Dumping data for table `umb_type_biaya`
--

INSERT INTO `umb_type_biaya` (`type_biaya_id`, `perusahaan_id`, `name`, `status`, `created_at`) VALUES
(1, 1, 'Supplies', 1, '22-02-2021 01:17:42'),
(2, 1, 'Utility', 1, '22-02-2021 01:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `umb_file_manager`
--

CREATE TABLE `umb_file_manager` (
  `file_id` int(111) NOT NULL,
  `user_id` int(111) NOT NULL,
  `department_id` int(111) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_file_manager`
--

TRUNCATE TABLE `umb_file_manager`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_file_manager_settings`
--

CREATE TABLE `umb_file_manager_settings` (
  `setting_id` int(111) NOT NULL,
  `allowed_extensions` mediumtext NOT NULL,
  `maximum_file_size` varchar(255) NOT NULL,
  `is_enable_all_files` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_file_manager_settings`
--

TRUNCATE TABLE `umb_file_manager_settings`;
--
-- Dumping data for table `umb_file_manager_settings`
--

INSERT INTO `umb_file_manager_settings` (`setting_id`, `allowed_extensions`, `maximum_file_size`, `is_enable_all_files`, `updated_at`) VALUES
(1, 'gif,png,pdf,txt,doc,docx', '10', '', '2021-01-01 03:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `umb_keuangan_bankcash`
--

CREATE TABLE `umb_keuangan_bankcash` (
  `bankcash_id` int(111) NOT NULL,
  `nama_account` varchar(255) NOT NULL,
  `saldo_account` varchar(255) NOT NULL,
  `pembukanaan_saldo_account` varchar(200) NOT NULL,
  `nomor_account` varchar(255) NOT NULL,
  `kode_cabang` varchar(255) NOT NULL,
  `cabang_bank` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_keuangan_bankcash`
--

TRUNCATE TABLE `umb_keuangan_bankcash`;
--
-- Dumping data for table `umb_keuangan_bankcash`
--

INSERT INTO `umb_keuangan_bankcash` (`bankcash_id`, `nama_account`, `saldo_account`, `pembukanaan_saldo_account`, `nomor_account`, `kode_cabang`, `cabang_bank`, `created_at`) VALUES
(1, 'Bank BNI', '10000000', '10000000', '123456789', '00966', 'Bank Negara Indonesia', '01-01-2021 01:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `umb_keuangan_deposit`
--

CREATE TABLE `umb_keuangan_deposit` (
  `deposit_id` int(111) NOT NULL,
  `type_account_id` int(111) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `deposit_tanggal` varchar(255) NOT NULL,
  `kategori_id` int(111) NOT NULL,
  `pembayar_id` int(111) NOT NULL,
  `payment_method` int(111) NOT NULL,
  `reference_deposit` varchar(255) NOT NULL,
  `file_deposit` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_keuangan_deposit`
--

TRUNCATE TABLE `umb_keuangan_deposit`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_keuangan_biaya`
--

CREATE TABLE `umb_keuangan_biaya` (
  `biaya_id` int(111) NOT NULL,
  `type_account_id` int(111) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `tanggal_biaya` varchar(255) NOT NULL,
  `kategori_id` int(111) NOT NULL,
  `penerima_pembayaran_id` int(111) NOT NULL,
  `payment_method` int(111) NOT NULL,
  `reference_biaya` varchar(255) NOT NULL,
  `file_biaya` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_keuangan_biaya`
--

TRUNCATE TABLE `umb_keuangan_biaya`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_keuangan_penerima_pembayarans`
--

CREATE TABLE `umb_keuangan_penerima_pembayarans` (
  `penerima_pembayaran_id` int(11) NOT NULL,
  `nama_penerima_pembayaran` varchar(255) NOT NULL,
  `nomor_kontak` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_keuangan_penerima_pembayarans`
--

TRUNCATE TABLE `umb_keuangan_penerima_pembayarans`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_keuangan_pembayars`
--

CREATE TABLE `umb_keuangan_pembayars` (
  `pembayar_id` int(11) NOT NULL,
  `nama_pembayar` varchar(255) NOT NULL,
  `nomor_kontak` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_keuangan_pembayars`
--

TRUNCATE TABLE `umb_keuangan_pembayars`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_keuangan_transaksi`
--

CREATE TABLE `umb_keuangan_transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `tanggal_transaksi` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `jumlah` float NOT NULL,
  `type_transaksi` varchar(100) NOT NULL,
  `dr_cr` enum('dr','cr') NOT NULL,
  `kat_transaksi_id` int(11) NOT NULL,
  `pembayar_penerima_pembayaran_id` int(11) NOT NULL,
  `option_penerima_pembayaran` int(11) DEFAULT NULL,
  `payment_method_id` int(11) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `type_invoice` varchar(100) DEFAULT NULL,
  `attachment_file` varchar(100) DEFAULT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_keuangan_transaksi`
--

TRUNCATE TABLE `umb_keuangan_transaksi`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_keuangan_transaksii`
--

CREATE TABLE `umb_keuangan_transaksii` (
  `transaksi_id` int(111) NOT NULL,
  `type_account_id` int(111) NOT NULL,
  `deposit_id` int(111) NOT NULL,
  `biaya_id` int(111) NOT NULL,
  `transfer_id` int(111) NOT NULL,
  `type_transaksi` varchar(255) NOT NULL,
  `jumlah_total` varchar(255) NOT NULL,
  `transaksi_debit` varchar(255) NOT NULL,
  `transaksi_credit` varchar(255) NOT NULL,
  `tanggal_transaksi` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_keuangan_transaksii`
--

TRUNCATE TABLE `umb_keuangan_transaksii`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_keuangan_transfer`
--

CREATE TABLE `umb_keuangan_transfer` (
  `transfer_id` int(111) NOT NULL,
  `from_account_id` int(111) NOT NULL,
  `to_account_id` int(111) NOT NULL,
  `tanggal_transfer` varchar(255) NOT NULL,
  `jumlah_transfer` varchar(255) NOT NULL,
  `payment_method` varchar(111) NOT NULL,
  `reference_transfer` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_keuangan_transfer`
--

TRUNCATE TABLE `umb_keuangan_transfer`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_tujuan_tracking`
--

CREATE TABLE `umb_tujuan_tracking` (
  `tracking_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `type_tracking_id` int(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `target_achiement` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `tujuan_progress` varchar(200) NOT NULL,
  `tujuan_status` int(11) NOT NULL DEFAULT 0,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_tujuan_tracking`
--

TRUNCATE TABLE `umb_tujuan_tracking`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_type_tujuan_tracking`
--

CREATE TABLE `umb_type_tujuan_tracking` (
  `type_tracking_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_type_tujuan_tracking`
--

TRUNCATE TABLE `umb_type_tujuan_tracking`;
--
-- Dumping data for table `umb_type_tujuan_tracking`
--

INSERT INTO `umb_type_tujuan_tracking` (`type_tracking_id`, `perusahaan_id`, `type_name`, `created_at`) VALUES
(1, 1, 'Invoice Goal', '31-08-2021 01:29:44'),
(4, 1, 'Event Goal', '31-08-2021 01:29:47');

-- --------------------------------------------------------

--
-- Table structure for table `umb_liburan`
--

CREATE TABLE `umb_liburan` (
  `libur_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `event_name` varchar(200) NOT NULL,
  `description` mediumtext NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `is_publish` tinyint(1) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_liburan`
--

TRUNCATE TABLE `umb_liburan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_templates_perjam`
--

CREATE TABLE `umb_templates_perjam` (
  `nilai_perjam_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `hourly_grade` varchar(255) NOT NULL,
  `nilai_perjam` varchar(255) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_templates_perjam`
--

TRUNCATE TABLE `umb_templates_perjam`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_hrastral_invoices`
--

CREATE TABLE `umb_hrastral_invoices` (
  `invoice_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `nomor_invoice` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `project_id` int(111) NOT NULL,
  `tanggal_invoice` varchar(255) NOT NULL,
  `tanggal_jatoh_tempo_invoice` varchar(255) NOT NULL,
  `sub_jumlah_total` varchar(255) NOT NULL,
  `type_discount` varchar(11) NOT NULL,
  `angka_discount` varchar(255) NOT NULL,
  `total_pajak` varchar(255) NOT NULL,
  `type_pajak` varchar(100) NOT NULL,
  `angka_pajak` varchar(255) NOT NULL,
  `type_invoice` varchar(100) NOT NULL,
  `total_discount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `catatan_invoice` mediumtext NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT 'null',
  `nama_perusahaan` varchar(200) NOT NULL DEFAULT 'null',
  `profile_client` varchar(200) NOT NULL DEFAULT 'null',
  `email` varchar(200) NOT NULL DEFAULT 'null',
  `nomor_kontak` varchar(200) NOT NULL DEFAULT 'null',
  `website_url` varchar(200) NOT NULL DEFAULT 'null',
  `alamat_1` text NOT NULL,
  `alamat_2` text NOT NULL,
  `kota` varchar(200) NOT NULL DEFAULT 'null',
  `provinsi` varchar(200) NOT NULL DEFAULT 'null',
  `kode_pos` varchar(200) NOT NULL DEFAULT 'null',
  `negaraid` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_hrastral_invoices`
--

TRUNCATE TABLE `umb_hrastral_invoices`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_hrastral_invoices_items`
--

CREATE TABLE `umb_hrastral_invoices_items` (
  `invoice_item_id` int(111) NOT NULL,
  `invoice_id` int(111) NOT NULL,
  `project_id` int(111) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_type_pajak` varchar(255) NOT NULL,
  `item_nilai_pajak` varchar(255) NOT NULL,
  `item_qty` varchar(255) NOT NULL,
  `item_unit_price` varchar(255) NOT NULL,
  `item_sub_total` varchar(255) NOT NULL,
  `sub_jumlah_total` varchar(255) NOT NULL,
  `total_pajak` varchar(255) NOT NULL,
  `type_discount` int(11) NOT NULL,
  `angka_discount` varchar(255) NOT NULL,
  `total_discount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_hrastral_invoices_items`
--

TRUNCATE TABLE `umb_hrastral_invoices_items`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_hrastral_module_attributes`
--

CREATE TABLE `umb_hrastral_module_attributes` (
  `custom_field_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `attribute` varchar(255) NOT NULL,
  `attribute_label` varchar(255) NOT NULL,
  `attribute_type` varchar(255) NOT NULL,
  `validation` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_hrastral_module_attributes`
--

TRUNCATE TABLE `umb_hrastral_module_attributes`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_hrastral_module_attributes_select_value`
--

CREATE TABLE `umb_hrastral_module_attributes_select_value` (
  `attributes_select_value_id` int(11) NOT NULL,
  `custom_field_id` int(11) NOT NULL,
  `select_label` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_hrastral_module_attributes_select_value`
--

TRUNCATE TABLE `umb_hrastral_module_attributes_select_value`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_hrastral_module_attributes_values`
--

CREATE TABLE `umb_hrastral_module_attributes_values` (
  `attributes_value_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_attributes_id` int(11) NOT NULL,
  `attribute_value` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_hrastral_module_attributes_values`
--

TRUNCATE TABLE `umb_hrastral_module_attributes_values`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_hrastral_notificaions`
--

CREATE TABLE `umb_hrastral_notificaions` (
  `notificaion_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `module_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `is_notify` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `umb_hrastral_notificaions`
--

TRUNCATE TABLE `umb_hrastral_notificaions`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_hrastral_quotes`
--

CREATE TABLE `umb_hrastral_quotes` (
  `quote_id` int(111) NOT NULL,
  `quote_number` varchar(255) NOT NULL,
  `project_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `quote_tanggal` varchar(255) NOT NULL,
  `quote_due_date` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `sub_jumlah_total` varchar(255) NOT NULL,
  `type_discount` varchar(11) NOT NULL,
  `angka_discount` varchar(255) NOT NULL,
  `total_pajak` varchar(255) NOT NULL,
  `type_pajak` varchar(100) NOT NULL,
  `angka_pajak` varchar(255) NOT NULL,
  `total_discount` varchar(255) NOT NULL,
  `quote_type` varchar(100) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `quote_note` mediumtext NOT NULL,
  `name` varchar(200) NOT NULL,
  `nama_perusahaan` varchar(200) NOT NULL,
  `profile_client` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `nomor_kontak` varchar(200) NOT NULL,
  `website_url` varchar(200) NOT NULL,
  `alamat_1` text NOT NULL,
  `alamat_2` text NOT NULL,
  `kota` varchar(200) NOT NULL,
  `provinsi` varchar(200) NOT NULL,
  `kode_pos` varchar(200) NOT NULL,
  `negaraid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_hrastral_quotes`
--

TRUNCATE TABLE `umb_hrastral_quotes`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_hrastral_quotes_items`
--

CREATE TABLE `umb_hrastral_quotes_items` (
  `quote_item_id` int(111) NOT NULL,
  `quote_id` int(111) NOT NULL,
  `project_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_type_pajak` varchar(255) NOT NULL,
  `item_nilai_pajak` varchar(255) NOT NULL,
  `item_qty` varchar(255) NOT NULL,
  `item_unit_price` varchar(255) NOT NULL,
  `item_sub_total` varchar(255) NOT NULL,
  `sub_jumlah_total` varchar(255) NOT NULL,
  `total_pajak` varchar(255) NOT NULL,
  `type_pajak` int(11) NOT NULL,
  `angka_pajak` varchar(200) NOT NULL,
  `type_discount` int(11) NOT NULL,
  `angka_discount` varchar(255) NOT NULL,
  `total_discount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_hrastral_quotes_items`
--

TRUNCATE TABLE `umb_hrastral_quotes_items`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_kategoris_pendapatan`
--

CREATE TABLE `umb_kategoris_pendapatan` (
  `kategori_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_kategoris_pendapatan`
--

TRUNCATE TABLE `umb_kategoris_pendapatan`;
--
-- Dumping data for table `umb_kategoris_pendapatan`
--

INSERT INTO `umb_kategoris_pendapatan` (`kategori_id`, `name`, `status`, `created_at`) VALUES
(1, 'Envato', 1, '25-03-2021 09:36:20'),
(2, 'Gaji', 1, '25-03-2021 09:36:28'),
(3, 'Penghasilan lain', 1, '25-03-2021 09:36:32'),
(4, 'Pendapatan bunga', 1, '25-03-2021 09:36:53'),
(5, 'Part Time Work', 1, '25-03-2021 09:37:13'),
(6, 'Penghasilan Reguler', 1, '25-03-2021 09:37:17');

-- --------------------------------------------------------

--
-- Table structure for table `umb_pekerjaans`
--

CREATE TABLE `umb_pekerjaans` (
  `pekerjaan_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `title_pekerjaan` varchar(255) NOT NULL,
  `penunjukan_id` int(111) NOT NULL,
  `url_pekerjaan` varchar(255) NOT NULL,
  `type_pekerjaan` int(225) NOT NULL,
  `kategori_url` varchar(255) NOT NULL,
  `is_featured` int(11) NOT NULL,
  `type_url` varchar(255) NOT NULL,
  `lowongan_pekerjaan` int(100) NOT NULL,
  `jenis_kelamin` varchar(100) NOT NULL,
  `minimum_pengalaman` varchar(255) NOT NULL,
  `tanggal_penutupan` varchar(200) NOT NULL,
  `short_description` mediumtext NOT NULL,
  `long_description` mediumtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_pekerjaans`
--

TRUNCATE TABLE `umb_pekerjaans`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_applications_pekerjaan`
--

CREATE TABLE `umb_applications_pekerjaan` (
  `application_id` int(111) NOT NULL,
  `pekerjaan_id` int(111) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_id` int(111) NOT NULL,
  `message` mediumtext NOT NULL,
  `pekerjaan_resume` mediumtext NOT NULL,
  `application_status` int(11) NOT NULL DEFAULT 0,
  `application_remarks` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_applications_pekerjaan`
--

TRUNCATE TABLE `umb_applications_pekerjaan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_kategoris_pekerjaan`
--

CREATE TABLE `umb_kategoris_pekerjaan` (
  `kategori_id` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `kategori_url` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_kategoris_pekerjaan`
--

TRUNCATE TABLE `umb_kategoris_pekerjaan`;
--
-- Dumping data for table `umb_kategoris_pekerjaan`
--

INSERT INTO `umb_kategoris_pekerjaan` (`kategori_id`, `nama_kategori`, `kategori_url`, `created_at`) VALUES
(1, 'PHP', 'q7VJh5xWwr56ycN0mAou4266iOY8l1BbMd6H2D3rkFnjU9LgC', '2021-04-15'),
(2, 'Android', 'q7VJh5xWwr56ycN0m34Aou4266iOY8l1BbMd6H2D3rkFnjU9LgC', '2021-04-15'),
(3, 'WordPress', 'q2327VJh5xWwr56ycN0mAou4266iOY8l1BbMd6H2D3rkFnjU9LgC', '2021-04-15'),
(4, 'Design', '0oplfq7VJh5xWwr56ycN0mAou4266iOY8l1BbMd6H2D3rkFnjU9LgC', '2021-04-15'),
(5, 'Developer', '34e6zyr56ycN0mAou4266iOY8l1BbMd6H2D3rkFnjU9LgC', '2021-04-15'),
(6, 'iOS', 'l1BbMd6H2D3rkFnjU9LgCq7VJh5xWwr56ycN0mAou4266iOY8', '2021-04-15'),
(7, 'Mobile', 'l1BbMd6H2D3rkFnjU9LgCH2D3rkFnjU9BbMd6H2D3r', '2021-04-15'),
(8, 'MySQL', '2D3rkFnjU9LgCq7VJh5xWwl1BbMd6H2D3rkFnjU9LgCq7VJh5xWwr56ycN0mAou4266iOY8', '2021-04-15'),
(9, 'JavaScript', 'gCq7VJh5xWwl1BbMd6H2D3rkFnjU9LgCq7VJh5xWwl1BbMd6H2D3rkFnjU9LgCq7VJh5xWwr56ycN0mAou4266iOY8', '2021-04-15'),
(10, 'Software', 'zyr56ycN0mAou42634e6zyr56ycN0mAou4266iOY8l1BbMd6H2D3rkFnjU9LgC', '2021-04-15'),
(11, 'Website Design', '6iOY8l1BbMd6H2D3rkFnjU9LgCzyr56ycN0mAou42634e6zyr56ycN0mAou426', '2021-04-15'),
(12, 'Programming', 'jU9LgCzyr56ycN0mAou4266iOY8l1BbMd6H2D3rkFn34e6zyr56ycN0mAou426', '2021-04-15'),
(13, 'SEO', 'cN0mAou4266iOY8l1Bq2327VJh5xWwr56ybMd6H2D3rkFnjU9LgC', '2021-04-15'),
(14, 'Java', 'VJh5xWwr56ybMd6H2DcN0mAou4266iOY8l1Bq23273rkFnjU9LgC', '2021-04-15'),
(15, 'CSS', 'VJh5xWwr56ybMd6H2Dsdfkkj58234ksklEr6ybMd6H2D', '2021-04-15'),
(16, 'HTML5', '0349324k0434r23ksodfkpsodkfposakfkpww3MsH2Dei30ks', '2021-04-15'),
(17, 'Web Development', 'sdfj0rkskfskdfj329FLE34LFMsH2Dei30ks0349324k0434', '2021-04-15'),
(18, 'Web Design', 'MsH2Deiee30ks0349324k0434klEr6ybMd6234b5ksddif0k33', '2021-04-15'),
(19, 'eCommerce', 'klEr6ybMd6234bMsH2Dei30ks0349324k04345ksddif0k33', '2021-04-15'),
(20, 'Design', '234bMsklEr6ybMd6H2Dssdk5yy98ooVJh5xWwr56y435gghhole93lfkkj58', '2021-04-15'),
(21, 'Logo Design', 'k5yy98ooVJh5xWw45456y435gghhole93lfkkj58234bMsklEr6ybMd6H2D', '2021-04-15'),
(22, 'Graphic Design', 'k5yy98ooVJh5xWwr56y435gghhole93lfkkj58234bMsklEr6ybMd6H2D', '2021-04-15'),
(23, 'Video', 'k98ooVJh5xWwr56y435gghhole93lfkkj58234bMsklEr6ybMd6H2D', '2021-04-15'),
(24, 'Animation', 'ole93lfkkj58234k98ooVJh5xWwr56ybMsklEr6ybMd6H2D', '2021-04-15'),
(25, 'Adobe Photoshop', 'd6H2Dsdfkkj58234k98ooVJh5xWwr56ybMsklEr6ybMd6H2D', '2021-04-15'),
(26, 'Illustration', 'xWwr56ybMd6H2DcN0mA3405kfVJh5ou4266iOY8l1Bq23273rkFnjU9LgC', '2021-04-15'),
(27, 'Art', '3405kfVJh5ou4266iOY8l1Bq23273rk3ok3xWwr56ybMd6H2DcN0mAFnjU9LgC', '2021-04-15'),
(28, '3D', 'Md6H2DcN0mAFnjU9LfVJh5ou4266iOY8l1Bq23273rk3ok3xWwr56ybgC', '2021-04-15'),
(29, 'Adobe Illustrator', '5ou4266iOY8l1Bq23273rkMd6H2DcN0mAFnjU9LfVJh3ok3xWwr56ybgCww', '2021-04-15'),
(30, 'Drawing', '6iOY8l1Bq23273rk0234KILR23492034ksfpd456yslfdsf5ou426', '2021-04-15'),
(31, 'Web Design', '3l34l432fo232l3223DhssdfRKLl5434lsdfl3l3sfs3lllblp23D', '2021-04-15'),
(32, 'Cartoon', 'sdfowerewl567lflsdfl3l3sf3l34l432fo232l3223Dhs3lllblp23D', '2021-04-15'),
(33, 'Graphics', '3232l32hsfo23lllblp23D9LfVJkfo394s5ou42at5sd20cNsolof3llsblp23DcN', '2021-04-15'),
(34, 'Fashion Design', '9LfVJkfo394s5ou42at5sd203232l32hsfo23lllblp23DcNsolof3llsblp23DcN', '2021-04-15'),
(35, 'WordPress', 'hsfo23lllblp23DcNsolof3llsblp23DcN9LfVJkfo394s5ou42', '2021-04-15'),
(36, 'Editing', 'lof3llsblp23DcN9LfVJhsfo23lllblp23DcNsokfo394s5ou42', '2021-04-15'),
(37, 'Writing', 'blp23DcNsokfo394slof3llsblp23DcN9LfVJh5ou42', '2021-04-15'),
(38, 'T-Shirt Design', '9LfVJh5ou42blp23DcNsdf329LfVJh5ou42bsokjfwpoek0mAFnjU', '2021-04-15'),
(39, 'Display Advertising', '9LfVJh5ou42bsokjfwpoek9LfVJh5ou42blp23DcN0mAFnjU', '2021-04-15'),
(40, 'Email Marketing', 'DcN0mAFnjU9LfVJh5ou42bs66iOY8l1Bq23273rk3ok3xWwr56yMd6H2gC', '2021-04-15'),
(41, 'Lead Generation', '66iOY8l1Bq23273rk3ok3xWwr56yMd6H2DcN0mAFnjU9LfVJh5ou42bgC', '2021-04-15'),
(42, 'Market & Customer Research', 'Aou42Eou42iOY800Ke3klAou42066iOY800fklAou42', '2021-04-15'),
(43, 'Marketing Strategy', 'EKe3000fklAou4266iOY8l1kkadwlsdfk20323rlsKh4KadlLL', '2021-04-15'),
(44, 'Public Relations', 'l1kkadwlsdfk20323rlsKh4KadlLLEKe3000fklAou4266iOY8', '2021-04-15'),
(45, 'Telemarketing & Telesales', 'fklAou4266iOY8l1kkadwlsfBf329k3249owe923ksd324odLL2DcN0m', '2021-04-15'),
(46, 'Other - Sales & Marketing', 'Bf329k3249owe923ksd324odfklAou4266iOY8l1kkadwlLL2DcN0m', '2021-04-15'),
(47, 'SEM - Search Engine Marketing', 'Aou4266iOY8l1Bf329k3249owe923ksdkkadwlLL2DcN0m', '2021-04-15'),
(48, 'SEO - Search Engine Optimization', 'rk0234KILR23492034ksfpd456y6iOY8l1Bq23273slfdsf5ou426', '2021-04-15'),
(49, 'SMM - Social Media Marketing', '2DcN0mAou4266iOY8l1BVJh5xWwr56ybMd6Hq23273rkFnjU9LgC', '2021-04-15');

-- --------------------------------------------------------

--
-- Table structure for table `umb_interviews_pekerjaan`
--

CREATE TABLE `umb_interviews_pekerjaan` (
  `pekerjaan_interview_id` int(111) NOT NULL,
  `pekerjaan_id` int(111) NOT NULL,
  `interviewers_id` varchar(255) NOT NULL,
  `tempat_interview` varchar(255) NOT NULL,
  `tanggal_interview` varchar(255) NOT NULL,
  `waktu_interview` varchar(255) NOT NULL,
  `interviewees_id` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_interviews_pekerjaan`
--

TRUNCATE TABLE `umb_interviews_pekerjaan`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_pages_pekerjaan`
--

CREATE TABLE `umb_pages_pekerjaan` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `page_details` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_pages_pekerjaan`
--

TRUNCATE TABLE `umb_pages_pekerjaan`;
--
-- Dumping data for table `umb_pages_pekerjaan`
--

INSERT INTO `umb_pages_pekerjaan` (`page_id`, `page_title`, `page_url`, `page_details`, `created_at`) VALUES
(1, 'About Us', 'xl9wkRy7tqOehBo6YCDjFG2JTucpKI4gMNsn8Zdf', 'About Ussss', '2021-04-15'),
(2, 'Communications', '5uk4EUc3V9FYTbBQz7PWgKM6qCajfAipvhOJnZHl', 'Communications', '2021-04-15'),
(3, 'Lending Licenses', '5r6OCsUoHQFiRwI17W0eT38jbvpxEGuLhzgmt9lZ', 'Lending Licenses', '2021-04-15'),
(4, 'Terms of Service', 'QrfbMOUWpdYNxjLFz8G1m6t3wi0X2RKEZVC9ySka', 'Terms of Service', '2021-04-15'),
(5, 'Privacy Policy', 'rjHKhmsNezT2OJBAoQq0yU1tL5F34MCwgIiZEc7x', 'Privacy Policy', '2021-04-15'),
(6, 'Support', 'gZbBVMxnfzYLlC2AOk609Q7yWpaSjmJHuRXosr58', 'Support', '2021-04-15'),
(7, 'How It Works', 'l1BbMd6H2D3rkFnjU9LgCH2D3rkFnjU9BbMd6H2D3r', 'How It Works', '2021-04-15'),
(8, 'Disclaimers', 'CTbzS9IrWkNU7VM3HGZYjp6iwmfyXDOQgtsP8FEc', 'Disclaimers', '2021-04-15');

-- --------------------------------------------------------

--
-- Table structure for table `umb_type_pekerjaan`
--

CREATE TABLE `umb_type_pekerjaan` (
  `type_pekerjaan_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `type_url` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_type_pekerjaan`
--

TRUNCATE TABLE `umb_type_pekerjaan`;
--
-- Dumping data for table `umb_type_pekerjaan`
--

INSERT INTO `umb_type_pekerjaan` (`type_pekerjaan_id`, `perusahaan_id`, `type`, `type_url`, `created_at`) VALUES
(1, 1, 'Full Time', 'full-time', '22-03-2021 02:18:48'),
(2, 1, 'Part Time', 'part-time', '16-03-2021 06:29:45'),
(3, 1, 'Internship', 'internship', '16-03-2021 06:30:06'),
(4, 1, 'Freelance', 'freelance', '16-03-2021 06:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `umb_kpi_incidental`
--

CREATE TABLE `umb_kpi_incidental` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `incidental_kpi` text NOT NULL,
  `targeted_date` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `quarter` int(11) NOT NULL,
  `result` varchar(200) NOT NULL,
  `feedback` text NOT NULL,
  `year_created` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `updated_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_kpi_incidental`
--

TRUNCATE TABLE `umb_kpi_incidental`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_kpi_maingoals`
--

CREATE TABLE `umb_kpi_maingoals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `main_kpi` varchar(255) NOT NULL,
  `year_created` varchar(200) NOT NULL,
  `status` varchar(100) NOT NULL,
  `approve_status` varchar(100) NOT NULL,
  `q1` varchar(100) NOT NULL,
  `q2` varchar(100) NOT NULL,
  `q3` varchar(100) NOT NULL,
  `q4` varchar(100) NOT NULL,
  `feedback` varchar(255) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `updated_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_kpi_maingoals`
--

TRUNCATE TABLE `umb_kpi_maingoals`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_kpi_variable`
--

CREATE TABLE `umb_kpi_variable` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `variable_kpi` varchar(200) NOT NULL,
  `targeted_date` varchar(200) NOT NULL,
  `result` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `approve_status` varchar(200) NOT NULL,
  `feedback` text NOT NULL,
  `quarter` varchar(200) NOT NULL,
  `year_created` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `updated_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_kpi_variable`
--

TRUNCATE TABLE `umb_kpi_variable`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_languages`
--

CREATE TABLE `umb_languages` (
  `language_id` int(111) NOT NULL,
  `language_name` varchar(255) NOT NULL,
  `language_code` varchar(255) NOT NULL,
  `language_flag` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_languages`
--

TRUNCATE TABLE `umb_languages`;
--
-- Dumping data for table `umb_languages`
--

INSERT INTO `umb_languages` (`language_id`, `language_name`, `language_code`, `language_flag`, `is_active`, `created_at`) VALUES
(1, 'English', 'english', 'language_flag_1520564355.gif', 1, ''),
(4, 'Portuguese', 'portuguese', 'language_flag_1526420518.gif', 1, '16-02-2021 12:41:57'),
(5, 'Vietnamese', 'vietnamese', 'language_flag_1526728529.gif', 1, '19-02-2021 02:15:28'),
(6, 'Spanish', 'spanish', 'language_flag_1563906920.gif', 1, '23-02-2021 11:35:20'),
(7, 'Svenska', 'swedish', 'language_flag_1564007195.gif', 1, '25-02-2021 03:26:35'),
(8, 'Thailand', 'thailand', 'language_flag_1564007402.gif', 1, '25-02-2021 03:30:02'),
(9, 'Indonesian', 'indonesian', 'language_flag_1564054894.gif', 1, '25-02-2021 04:41:33'),
(10, 'Italiano', 'italian', 'language_flag_1564058198.gif', 1, '25-02-2021 05:36:37'),
(11, 'Deutsch', 'dutch', 'language_flag_1564058280.gif', 1, '25-02-2021 05:37:59'),
(12, 'Turkish', 'turkish', 'language_flag_1564058565.gif', 1, '25-02-2021 05:42:44'),
(13, 'French', 'french', 'language_flag_1564058638.gif', 1, '25-02-2021 05:43:58'),
(14, 'Russian', 'russian', 'language_flag_1564058661.gif', 1, '25-02-2021 05:44:20'),
(15, 'Romanian', 'romanian', 'language_flag_1564058689.gif', 1, '25-02-2021 05:44:49'),
(16, 'Irish', 'irish', 'language_flag_1564171301.gif', 1, '27-02-2021 01:01:41'),
(17, 'Chinese', 'chinese', 'language_flag_1592785239.gif', 1, '22-02-2021 03:20:38'),
(18, 'Japanese', 'japanese', 'language_flag_1592785267.gif', 1, '22-02-2021 03:21:06'),
(19, 'Arabic', 'arabic', 'language_flag_1592785279.gif', 1, '22-02-2021 03:21:19');

-- --------------------------------------------------------

--
-- Table structure for table `umb_leads`
--

CREATE TABLE `umb_leads` (
  `client_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `client_username` varchar(255) NOT NULL,
  `password_client` varchar(255) NOT NULL,
  `profile_client` varchar(255) NOT NULL,
  `nomor_kontak` varchar(255) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `is_changed` int(11) NOT NULL,
  `jenis_kelamin` varchar(200) NOT NULL,
  `website_url` varchar(255) NOT NULL,
  `alamat_1` mediumtext NOT NULL,
  `alamat_2` mediumtext NOT NULL,
  `kota` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `kode_pos` varchar(255) NOT NULL,
  `negara` int(111) NOT NULL,
  `is_active` int(11) NOT NULL,
  `terakhir_logout_tanggal` varchar(255) NOT NULL,
  `tanggal_terakhir_login` varchar(255) NOT NULL,
  `terakhir_login_ip` varchar(255) NOT NULL,
  `is_logged_in` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_leads`
--

TRUNCATE TABLE `umb_leads`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_leads_followup`
--

CREATE TABLE `umb_leads_followup` (
  `leads_followup_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `next_followup` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `umb_leads_followup`
--

TRUNCATE TABLE `umb_leads_followup`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_applications_cuti`
--

CREATE TABLE `umb_applications_cuti` (
  `cuti_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(222) NOT NULL,
  `department_id` int(11) NOT NULL,
  `type_cuti_id` int(222) NOT NULL,
  `from_date` varchar(200) NOT NULL,
  `to_date` varchar(200) NOT NULL,
  `applied_on` varchar(200) NOT NULL,
  `reason` mediumtext NOT NULL,
  `remarks` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_half_day` tinyint(1) DEFAULT NULL,
  `is_notify` int(11) NOT NULL,
  `attachment_cuti` varchar(255) DEFAULT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_applications_cuti`
--

TRUNCATE TABLE `umb_applications_cuti`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_type_cuti`
--

CREATE TABLE `umb_type_cuti` (
  `type_cuti_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `type_name` varchar(200) NOT NULL,
  `days_per_year` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_type_cuti`
--

TRUNCATE TABLE `umb_type_cuti`;
--
-- Dumping data for table `umb_type_cuti`
--

INSERT INTO `umb_type_cuti` (`type_cuti_id`, `perusahaan_id`, `type_name`, `days_per_year`, `status`, `created_at`) VALUES
(1, 1, 'Casual Leave', '3', 1, '19-03-2021 07:52:20'),
(2, 1, 'Medical', '2', 1, '19-03-2021 07:52:30');

-- --------------------------------------------------------

--
-- Table structure for table `umb_melakukan_pembayaran`
--

CREATE TABLE `umb_melakukan_pembayaran` (
  `melakukan_pembayaran_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `department_id` int(111) NOT NULL,
  `perusahaan_id` int(111) NOT NULL,
  `location_id` int(111) NOT NULL,
  `penunjukan_id` int(111) NOT NULL,
  `payment_date` varchar(200) NOT NULL,
  `gaji_pokok` varchar(255) NOT NULL,
  `jumlah_pembayaran` varchar(255) NOT NULL,
  `gross_gaji` varchar(255) NOT NULL,
  `total_tunjanagans` varchar(255) NOT NULL,
  `total_potongans` varchar(255) NOT NULL,
  `gaji_bersih` varchar(255) NOT NULL,
  `tunjangan_sewa_rumah` varchar(255) NOT NULL,
  `tunjangan_kesehatan` varchar(255) NOT NULL,
  `tunjangan_perjalanan` varchar(255) NOT NULL,
  `tunjangan_jabatan` varchar(255) NOT NULL,
  `dana_yang_diberikan` varchar(255) NOT NULL,
  `potongan_pajak` varchar(255) NOT NULL,
  `security_deposit` varchar(255) NOT NULL,
  `nilai_lembur` varchar(255) NOT NULL,
  `is_potong_advance_gaji` int(11) NOT NULL,
  `jumlah_advance_gaji` varchar(255) NOT NULL,
  `is_payment` tinyint(1) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `nilai_perjam` varchar(255) NOT NULL,
  `total_jam_kerja` varchar(255) NOT NULL,
  `comments` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_melakukan_pembayaran`
--

TRUNCATE TABLE `umb_melakukan_pembayaran`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_meetings`
--

CREATE TABLE `umb_meetings` (
  `meeting_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` varchar(255) DEFAULT NULL,
  `title_meeting` varchar(255) NOT NULL,
  `tanggal_meeting` varchar(255) NOT NULL,
  `waktu_meeting` varchar(255) NOT NULL,
  `meeting_room` varchar(255) NOT NULL,
  `meeting_note` mediumtext NOT NULL,
  `meeting_color` varchar(200) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_meetings`
--

TRUNCATE TABLE `umb_meetings`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_location_kantor`
--

CREATE TABLE `umb_location_kantor` (
  `location_id` int(11) NOT NULL,
  `perusahaan_id` int(111) NOT NULL,
  `location_head` int(111) NOT NULL,
  `location_manager` int(111) NOT NULL,
  `nama_location` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `alamat_1` mediumtext NOT NULL,
  `alamat_2` mediumtext NOT NULL,
  `kota` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `kode_pos` varchar(255) NOT NULL,
  `negara` int(111) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_location_kantor`
--

TRUNCATE TABLE `umb_location_kantor`;
--
-- Dumping data for table `umb_location_kantor`
--

INSERT INTO `umb_location_kantor` (`location_id`, `perusahaan_id`, `location_head`, `location_manager`, `nama_location`, `email`, `phone`, `fax`, `alamat_1`, `alamat_2`, `kota`, `provinsi`, `kode_pos`, `negara`, `added_by`, `created_at`, `status`) VALUES
(1, 1, 5, 0, 'Jakarta Barat', 'mainoffice@hrastral.com', '1234567890', '1234567890', 'Alamat Line 1', 'Alamat Line 2', 'Kota', 'Provinsi', '12345', 101, 1, '28-02-2021', 1);

-- --------------------------------------------------------

--
-- Table structure for table `umb_shift_kantor`
--

CREATE TABLE `umb_shift_kantor` (
  `shift_kantor_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `nama_shift` varchar(255) NOT NULL,
  `default_shift` int(111) NOT NULL,
  `senen_waktu_masuk` varchar(222) NOT NULL,
  `senen_waktu_pulang` varchar(222) NOT NULL,
  `selasa_waktu_masuk` varchar(222) NOT NULL,
  `selasa_waktu_pulang` varchar(222) NOT NULL,
  `rabu_waktu_masuk` varchar(222) NOT NULL,
  `rabu_waktu_pulang` varchar(222) NOT NULL,
  `kamis_waktu_masuk` varchar(222) NOT NULL,
  `kamis_waktu_pulang` varchar(222) NOT NULL,
  `jumat_waktu_masuk` varchar(222) NOT NULL,
  `jumat_waktu_pulang` varchar(222) NOT NULL,
  `sabtu_waktu_masuk` varchar(222) NOT NULL,
  `sabtu_waktu_pulang` varchar(222) NOT NULL,
  `minggu_waktu_masuk` varchar(222) NOT NULL,
  `minggu_waktu_pulang` varchar(222) NOT NULL,
  `created_at` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_shift_kantor`
--

TRUNCATE TABLE `umb_shift_kantor`;
--
-- Dumping data for table `umb_shift_kantor`
--

INSERT INTO `umb_shift_kantor` (`shift_kantor_id`, `perusahaan_id`, `nama_shift`, `default_shift`, `senen_waktu_masuk`, `senen_waktu_pulang`, `selasa_waktu_masuk`, `selasa_waktu_pulang`, `rabu_waktu_masuk`, `rabu_waktu_pulang`, `kamis_waktu_masuk`, `kamis_waktu_pulang`, `jumat_waktu_masuk`, `jumat_waktu_pulang`, `sabtu_waktu_masuk`, `sabtu_waktu_pulang`, `minggu_waktu_masuk`, `minggu_waktu_pulang`, `created_at`) VALUES
(1, 1, 'Shift Pagi', 1, '08:00', '18:00', '03:00', '18:00', '08:00', '18:00', '08:00', '18:00', '08:00', '18:00', '', '', '', '', '2021-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `umb_payment_method`
--

CREATE TABLE `umb_payment_method` (
  `payment_method_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `method_name` varchar(255) NOT NULL,
  `payment_percentage` varchar(200) DEFAULT NULL,
  `nomor_account` varchar(200) DEFAULT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_payment_method`
--

TRUNCATE TABLE `umb_payment_method`;
--
-- Dumping data for table `umb_payment_method`
--

INSERT INTO `umb_payment_method` (`payment_method_id`, `perusahaan_id`, `method_name`, `payment_percentage`, `nomor_account`, `created_at`) VALUES
(1, 1, 'Cash', '30', '', '23-02-2021 05:13:52'),
(2, 1, 'Paypal', '40', '1', '12-02-2021 02:18:50'),
(3, 1, 'Bank', '30', '1231232', '12-02-2021 02:18:57');

-- --------------------------------------------------------

--
-- Table structure for table `umb_payroll_custom_fields`
--

CREATE TABLE `umb_payroll_custom_fields` (
  `payroll_custom_id` int(11) NOT NULL,
  `allow_custom_1` varchar(255) NOT NULL,
  `is_active_allow_1` int(11) NOT NULL,
  `allow_custom_2` varchar(255) NOT NULL,
  `is_active_allow_2` int(11) NOT NULL,
  `allow_custom_3` varchar(255) NOT NULL,
  `is_active_allow_3` int(11) NOT NULL,
  `allow_custom_4` varchar(255) NOT NULL,
  `is_active_allow_4` int(11) NOT NULL,
  `allow_custom_5` varchar(255) NOT NULL,
  `is_active_allow_5` int(111) NOT NULL,
  `deduct_custom_1` varchar(255) NOT NULL,
  `is_active_deduct_1` int(11) NOT NULL,
  `deduct_custom_2` varchar(255) NOT NULL,
  `is_active_deduct_2` int(11) NOT NULL,
  `deduct_custom_3` varchar(255) NOT NULL,
  `is_active_deduct_3` int(11) NOT NULL,
  `deduct_custom_4` varchar(255) NOT NULL,
  `is_active_deduct_4` int(11) NOT NULL,
  `deduct_custom_5` varchar(255) NOT NULL,
  `is_active_deduct_5` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_payroll_custom_fields`
--

TRUNCATE TABLE `umb_payroll_custom_fields`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_performance_appraisal`
--

CREATE TABLE `umb_performance_appraisal` (
  `performance_appraisal_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `appraisal_year_month` varchar(255) NOT NULL,
  `customer_pengalaman` int(111) NOT NULL,
  `marketing` int(111) NOT NULL,
  `management` int(111) NOT NULL,
  `administration` int(111) NOT NULL,
  `presentation_skill` int(111) NOT NULL,
  `quality_of_work` int(111) NOT NULL,
  `efficiency` int(111) NOT NULL,
  `integrity` int(111) NOT NULL,
  `professionalism` int(111) NOT NULL,
  `team_work` int(111) NOT NULL,
  `critical_thinking` int(111) NOT NULL,
  `conflict_management` int(111) NOT NULL,
  `kehadiran` int(111) NOT NULL,
  `ability_to_meet_deadline` int(111) NOT NULL,
  `remarks` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_performance_appraisal`
--

TRUNCATE TABLE `umb_performance_appraisal`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_performance_appraisal_options`
--

CREATE TABLE `umb_performance_appraisal_options` (
  `performance_appraisal_options_id` int(11) NOT NULL,
  `appraisal_id` int(11) NOT NULL,
  `appraisal_type` varchar(200) NOT NULL,
  `appraisal_option_id` int(11) NOT NULL,
  `appraisal_option_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_performance_appraisal_options`
--

TRUNCATE TABLE `umb_performance_appraisal_options`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_performance_indicator`
--

CREATE TABLE `umb_performance_indicator` (
  `performance_indicator_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `penunjukan_id` int(111) NOT NULL,
  `customer_pengalaman` int(111) NOT NULL,
  `marketing` int(111) NOT NULL,
  `management` int(111) NOT NULL,
  `administration` int(111) NOT NULL,
  `presentation_skill` int(111) NOT NULL,
  `quality_of_work` int(111) NOT NULL,
  `efficiency` int(111) NOT NULL,
  `integrity` int(111) NOT NULL,
  `professionalism` int(111) NOT NULL,
  `team_work` int(111) NOT NULL,
  `critical_thinking` int(111) NOT NULL,
  `conflict_management` int(111) NOT NULL,
  `kehadiran` int(111) NOT NULL,
  `ability_to_meet_deadline` int(111) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_performance_indicator`
--

TRUNCATE TABLE `umb_performance_indicator`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_performance_indicator_options`
--

CREATE TABLE `umb_performance_indicator_options` (
  `performance_indicator_options_id` int(11) NOT NULL,
  `indicator_id` int(11) NOT NULL,
  `indicator_type` varchar(200) NOT NULL,
  `indicator_option_id` int(11) NOT NULL,
  `indicator_option_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_performance_indicator_options`
--

TRUNCATE TABLE `umb_performance_indicator_options`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_projects`
--

CREATE TABLE `umb_projects` (
  `project_id` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `client_id` int(100) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `perusahaan_id` varchar(255) DEFAULT NULL,
  `assigned_to` mediumtext NOT NULL,
  `priority` varchar(255) NOT NULL,
  `no_project` varchar(255) DEFAULT NULL,
  `phase_no` varchar(200) DEFAULT NULL,
  `no_pembelian` varchar(200) DEFAULT NULL,
  `jam_anggaran` varchar(255) DEFAULT NULL,
  `summary` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `progress_project` varchar(255) NOT NULL,
  `catatan_project` longtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `is_notify` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_projects`
--

TRUNCATE TABLE `umb_projects`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_attachment_projects`
--

CREATE TABLE `umb_attachment_projects` (
  `project_attachment_id` int(11) NOT NULL,
  `project_id` int(200) NOT NULL,
  `upload_by` int(255) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_description` mediumtext NOT NULL,
  `attachment_file` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_attachment_projects`
--

TRUNCATE TABLE `umb_attachment_projects`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_projects_bugs`
--

CREATE TABLE `umb_projects_bugs` (
  `bug_id` int(11) NOT NULL,
  `project_id` int(111) NOT NULL,
  `user_id` int(200) NOT NULL,
  `attachment_file` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_projects_bugs`
--

TRUNCATE TABLE `umb_projects_bugs`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_diskusi_project`
--

CREATE TABLE `umb_diskusi_project` (
  `diskusi_id` int(11) NOT NULL,
  `project_id` int(111) NOT NULL,
  `user_id` int(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `attachment_file` varchar(255) NOT NULL,
  `message` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_diskusi_project`
--

TRUNCATE TABLE `umb_diskusi_project`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_projects_timelogs`
--

CREATE TABLE `umb_projects_timelogs` (
  `timelogs_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `total_hours` varchar(255) NOT NULL,
  `timelogs_memo` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_projects_timelogs`
--

TRUNCATE TABLE `umb_projects_timelogs`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_variasii_project`
--

CREATE TABLE `umb_variasii_project` (
  `variasi_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `project_id` int(111) NOT NULL,
  `created_by` int(111) NOT NULL,
  `nama_variasi` varchar(255) NOT NULL,
  `no_variasii` varchar(255) NOT NULL,
  `assigned_to` varchar(255) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `jam_variasi` varchar(200) NOT NULL,
  `description` mediumtext NOT NULL,
  `status_variasi` int(5) NOT NULL,
  `client_approval` int(11) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_variasii_project`
--

TRUNCATE TABLE `umb_variasii_project`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_qualification_tingakat_pendidikan`
--

CREATE TABLE `umb_qualification_tingakat_pendidikan` (
  `tingkat_pendidikan_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_qualification_tingakat_pendidikan`
--

TRUNCATE TABLE `umb_qualification_tingakat_pendidikan`;
--
-- Dumping data for table `umb_qualification_tingakat_pendidikan`
--

INSERT INTO `umb_qualification_tingakat_pendidikan` (`tingkat_pendidikan_id`, `perusahaan_id`, `name`, `created_at`) VALUES
(1, 1, 'High School Diploma / GED', '02-02-2021 03:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `umb_qualification_language`
--

CREATE TABLE `umb_qualification_language` (
  `language_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_qualification_language`
--

TRUNCATE TABLE `umb_qualification_language`;
--
-- Dumping data for table `umb_qualification_language`
--

INSERT INTO `umb_qualification_language` (`language_id`, `perusahaan_id`, `name`, `created_at`) VALUES
(1, 1, 'English', '02-02-2021 03:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `umb_qualification_skill`
--

CREATE TABLE `umb_qualification_skill` (
  `skill_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_qualification_skill`
--

TRUNCATE TABLE `umb_qualification_skill`;
--
-- Dumping data for table `umb_qualification_skill`
--

INSERT INTO `umb_qualification_skill` (`skill_id`, `perusahaan_id`, `name`, `created_at`) VALUES
(1, 1, 'jQuery', '02-02-2021 03:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `umb_quoted_projects`
--

CREATE TABLE `umb_quoted_projects` (
  `project_id` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `client_id` int(100) NOT NULL,
  `estimate_date` varchar(255) NOT NULL,
  `perusahaan_id` varchar(255) DEFAULT NULL,
  `assigned_to` mediumtext NOT NULL,
  `priority` varchar(255) NOT NULL,
  `no_project` varchar(255) DEFAULT NULL,
  `phase_no` varchar(200) DEFAULT NULL,
  `estimate_hrs` varchar(255) DEFAULT NULL,
  `summary` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `progress_project` varchar(255) NOT NULL,
  `catatan_project` longtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `is_notify` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_quoted_projects`
--

TRUNCATE TABLE `umb_quoted_projects`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_quoted_projects_attachment`
--

CREATE TABLE `umb_quoted_projects_attachment` (
  `project_attachment_id` int(11) NOT NULL,
  `project_id` int(200) NOT NULL,
  `upload_by` int(255) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_description` mediumtext NOT NULL,
  `attachment_file` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_quoted_projects_attachment`
--

TRUNCATE TABLE `umb_quoted_projects_attachment`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_diskusi_quoted_projects`
--

CREATE TABLE `umb_diskusi_quoted_projects` (
  `diskusi_id` int(11) NOT NULL,
  `project_id` int(111) NOT NULL,
  `user_id` int(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `attachment_file` varchar(255) NOT NULL,
  `message` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_diskusi_quoted_projects`
--

TRUNCATE TABLE `umb_diskusi_quoted_projects`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_quoted_projects_timelogs`
--

CREATE TABLE `umb_quoted_projects_timelogs` (
  `timelogs_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `total_hours` varchar(255) NOT NULL,
  `timelogs_memo` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_quoted_projects_timelogs`
--

TRUNCATE TABLE `umb_quoted_projects_timelogs`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_recruitment_pages`
--

CREATE TABLE `umb_recruitment_pages` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_details` mediumtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_recruitment_pages`
--

TRUNCATE TABLE `umb_recruitment_pages`;
--
-- Dumping data for table `umb_recruitment_pages`
--

INSERT INTO `umb_recruitment_pages` (`page_id`, `page_title`, `page_details`, `status`, `created_at`) VALUES
(1, 'Pages', 'Nulla dignissim gravida\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \n\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(2, 'About Us', 'Nulla dignissim gravida\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \n\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(3, 'Career Services', 'Career Services', 1, ''),
(4, 'Success Stories', 'Success Stories', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `umb_subpages_recruitment`
--

CREATE TABLE `umb_subpages_recruitment` (
  `subpages_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `sub_page_title` varchar(255) NOT NULL,
  `sub_page_details` mediumtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_subpages_recruitment`
--

TRUNCATE TABLE `umb_subpages_recruitment`;
--
-- Dumping data for table `umb_subpages_recruitment`
--

INSERT INTO `umb_subpages_recruitment` (`subpages_id`, `page_id`, `sub_page_title`, `sub_page_details`, `status`, `created_at`) VALUES
(1, 1, 'Sub Menu 1', 'Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(2, 1, 'Sub Menu 2', 'Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(3, 1, 'Sub Menu 3', 'Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(4, 1, 'Sub Menu 4', 'Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(5, 1, 'Sub Menu 5', 'Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(6, 1, 'Sub Menu 6', 'Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_tunjanagans`
--

CREATE TABLE `umb_gaji_tunjanagans` (
  `tunjanagan_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `is_tunjanagan_kena_pajak` int(11) NOT NULL,
  `jumlah_option` int(11) NOT NULL,
  `title_tunjanagan` varchar(200) DEFAULT NULL,
  `jumlah_tunjanagan` varchar(200) DEFAULT NULL,
  `created_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_tunjanagans`
--

TRUNCATE TABLE `umb_gaji_tunjanagans`;
--
-- Dumping data for table `umb_gaji_tunjanagans`
--

INSERT INTO `umb_gaji_tunjanagans` (`tunjanagan_id`, `karyawan_id`, `is_tunjanagan_kena_pajak`, `jumlah_option`, `title_tunjanagan`, `jumlah_tunjanagan`, `created_at`) VALUES
(1, 1, 0, 0, 'Tunjangan Biaya Hidup', '100', NULL),
(2, 1, 0, 0, 'Tunjangan Perumahan', '200', NULL),
(3, 1, 0, 0, 'Tunjangan Belanja', '200', NULL),
(4, 1, 0, 0, 'Tunjangan Makan', '100', NULL),
(5, 1, 0, 0, 'Tunjanagan Perjalanan', '200', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_bank_allocation`
--

CREATE TABLE `umb_gaji_bank_allocation` (
  `bank_allocation_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `pay_percent` varchar(200) NOT NULL,
  `acc_number` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_bank_allocation`
--

TRUNCATE TABLE `umb_gaji_bank_allocation`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_komissi`
--

CREATE TABLE `umb_gaji_komissi` (
  `gaji_komissi_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `is_komisi_kena_pajak` int(11) NOT NULL,
  `jumlah_option` int(11) NOT NULL,
  `komisi_title` varchar(200) DEFAULT NULL,
  `jumlah_komisi` varchar(200) DEFAULT NULL,
  `created_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_komissi`
--

TRUNCATE TABLE `umb_gaji_komissi`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_pinjaman_potongans`
--

CREATE TABLE `umb_gaji_pinjaman_potongans` (
  `potongan_pinjaman_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `options_pinjaman` int(11) NOT NULL,
  `title_potongan_pinjaman` varchar(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `angsuran_bulanan` varchar(200) NOT NULL,
  `waktu_pinjaman` varchar(200) NOT NULL,
  `pinjaman_jumlah_potongan` varchar(200) NOT NULL,
  `total_yang_dibayarkan` varchar(200) NOT NULL,
  `reason` text NOT NULL,
  `status` int(11) NOT NULL,
  `is_dipotong_dari_gaji` int(11) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_pinjaman_potongans`
--

TRUNCATE TABLE `umb_gaji_pinjaman_potongans`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_pembayarans_lainnya`
--

CREATE TABLE `umb_gaji_pembayarans_lainnya` (
  `pembayarans_lainnya_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `ia_pembayaranlainnya_kena_pajak` int(11) NOT NULL,
  `jumlah_option` int(11) NOT NULL,
  `title_pembayarans` varchar(200) DEFAULT NULL,
  `jumlah_pembayarans` varchar(200) DEFAULT NULL,
  `created_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_pembayarans_lainnya`
--

TRUNCATE TABLE `umb_gaji_pembayarans_lainnya`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_lembur`
--

CREATE TABLE `umb_gaji_lembur` (
  `gaji_lembur_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `type_lembur` varchar(200) NOT NULL,
  `no_of_days` varchar(100) NOT NULL DEFAULT '0',
  `jam_lembur` varchar(100) NOT NULL DEFAULT '0',
  `nilai_lembur` varchar(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_lembur`
--

TRUNCATE TABLE `umb_gaji_lembur`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_slipgajii`
--

CREATE TABLE `umb_gaji_slipgajii` (
  `slipgaji_id` int(11) NOT NULL,
  `slipgaji_key` varchar(200) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `penunjukan_id` int(11) NOT NULL,
  `gaji_bulan` varchar(200) NOT NULL,
  `type_upahh` int(11) NOT NULL,
  `type_slipgaji` varchar(50) NOT NULL,
  `gaji_pokok` varchar(200) NOT NULL,
  `upahh_harian` varchar(200) NOT NULL,
  `is_half_monthly_payroll` tinyint(1) NOT NULL,
  `jam_bekerja` varchar(50) NOT NULL DEFAULT '0',
  `total_tunjanagans` varchar(200) NOT NULL,
  `total_komissi` varchar(200) NOT NULL,
  `total_statutory_potongans` varchar(200) NOT NULL,
  `total_pembayarans_lainnya` varchar(200) NOT NULL,
  `total_pinjaman` varchar(200) NOT NULL,
  `total_lembur` varchar(200) NOT NULL,
  `asuransi_percent` varchar(200) NOT NULL,
  `jumlah_asuransi` varchar(200) NOT NULL,
  `statutory_potongans` varchar(200) NOT NULL,
  `is_potong_advance_gaji` int(11) NOT NULL,
  `jumlah_advance_gaji` varchar(200) NOT NULL,
  `gaji_bersih` varchar(200) NOT NULL,
  `grand_gaji_bersih` varchar(200) NOT NULL,
  `pembayaran_lainnya` varchar(200) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `pay_comments` mediumtext NOT NULL,
  `is_payment` int(11) NOT NULL,
  `year_to_date` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_slipgajii`
--

TRUNCATE TABLE `umb_gaji_slipgajii`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_slipgaji_tunjanagans`
--

CREATE TABLE `umb_gaji_slipgaji_tunjanagans` (
  `slipgaji_tunjanagans_id` int(11) NOT NULL,
  `slipgaji_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `is_tunjanagan_kena_pajak` int(11) NOT NULL,
  `jumlah_option` int(11) NOT NULL,
  `title_tunjanagan` varchar(200) NOT NULL,
  `jumlah_tunjanagan` varchar(200) NOT NULL,
  `gaji_bulan` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_slipgaji_tunjanagans`
--

TRUNCATE TABLE `umb_gaji_slipgaji_tunjanagans`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_slipgaji_komissi`
--

CREATE TABLE `umb_gaji_slipgaji_komissi` (
  `slipgaji_komissi_id` int(11) NOT NULL,
  `slipgaji_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `is_komisi_kena_pajak` int(11) NOT NULL,
  `jumlah_option` int(11) NOT NULL,
  `komisi_title` varchar(200) NOT NULL,
  `jumlah_komisi` varchar(200) NOT NULL,
  `gaji_bulan` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_slipgaji_komissi`
--

TRUNCATE TABLE `umb_gaji_slipgaji_komissi`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_slipgaji_pinjaman`
--

CREATE TABLE `umb_gaji_slipgaji_pinjaman` (
  `slipgaji_pinjaman_id` int(11) NOT NULL,
  `slipgaji_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `pinjaman_title` varchar(200) NOT NULL,
  `pinjaman_jumlah` varchar(200) NOT NULL,
  `gaji_bulan` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_slipgaji_pinjaman`
--

TRUNCATE TABLE `umb_gaji_slipgaji_pinjaman`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_slipgaji_pembayarans_lainnya`
--

CREATE TABLE `umb_gaji_slipgaji_pembayarans_lainnya` (
  `slipgaji_pembayaran_lainnya_id` int(11) NOT NULL,
  `slipgaji_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `ia_pembayaranlainnya_kena_pajak` int(11) NOT NULL,
  `jumlah_option` int(11) NOT NULL,
  `title_pembayarans` varchar(200) NOT NULL,
  `jumlah_pembayarans` varchar(200) NOT NULL,
  `gaji_bulan` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_slipgaji_pembayarans_lainnya`
--

TRUNCATE TABLE `umb_gaji_slipgaji_pembayarans_lainnya`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_slipgaji_lembur`
--

CREATE TABLE `umb_gaji_slipgaji_lembur` (
  `slipgaji_lembur_id` int(11) NOT NULL,
  `slipgaji_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `title_lembur` varchar(200) NOT NULL,
  `lembur_gaji_bulan` varchar(200) NOT NULL,
  `lembur_no_of_days` varchar(200) NOT NULL,
  `jam_lembur` varchar(200) NOT NULL,
  `nilai_lembur` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_slipgaji_lembur`
--

TRUNCATE TABLE `umb_gaji_slipgaji_lembur`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_slipgaji_statutory_potongans`
--

CREATE TABLE `umb_gaji_slipgaji_statutory_potongans` (
  `slipgaji_potongan_id` int(11) NOT NULL,
  `slipgaji_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `statutory_options` int(11) NOT NULL,
  `title_potongan` varchar(200) NOT NULL,
  `jumlah_potongan` varchar(200) NOT NULL,
  `gaji_bulan` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_slipgaji_statutory_potongans`
--

TRUNCATE TABLE `umb_gaji_slipgaji_statutory_potongans`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_statutory_potongans`
--

CREATE TABLE `umb_gaji_statutory_potongans` (
  `statutory_potongans_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `statutory_options` int(11) NOT NULL,
  `title_potongan` varchar(200) DEFAULT NULL,
  `jumlah_potongan` varchar(200) DEFAULT NULL,
  `created_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_statutory_potongans`
--

TRUNCATE TABLE `umb_gaji_statutory_potongans`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_gaji_templates`
--

CREATE TABLE `umb_gaji_templates` (
  `gaji_template_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `gaji_grades` varchar(255) NOT NULL,
  `gaji_pokok` varchar(255) NOT NULL,
  `nilai_lembur` varchar(255) NOT NULL,
  `tunjangan_sewa_rumah` varchar(255) NOT NULL,
  `tunjangan_kesehatan` varchar(255) NOT NULL,
  `tunjangan_perjalanan` varchar(255) NOT NULL,
  `tunjangan_jabatan` varchar(255) NOT NULL,
  `security_deposit` varchar(255) NOT NULL,
  `dana_yang_diberikan` varchar(255) NOT NULL,
  `potongan_pajak` varchar(255) NOT NULL,
  `gross_gaji` varchar(255) NOT NULL,
  `total_tunjanagan` varchar(255) NOT NULL,
  `total_potongan` varchar(255) NOT NULL,
  `gaji_bersih` varchar(255) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_gaji_templates`
--

TRUNCATE TABLE `umb_gaji_templates`;
--
-- Dumping data for table `umb_gaji_templates`
--

INSERT INTO `umb_gaji_templates` (`gaji_template_id`, `perusahaan_id`, `gaji_grades`, `gaji_pokok`, `nilai_lembur`, `tunjangan_sewa_rumah`, `tunjangan_kesehatan`, `tunjangan_perjalanan`, `tunjangan_jabatan`, `security_deposit`, `dana_yang_diberikan`, `potongan_pajak`, `gross_gaji`, `total_tunjanagan`, `total_potongan`, `gaji_bersih`, `added_by`, `created_at`) VALUES
(1, 1, 'Monthly', '2500', '', '50', '60', '70', '80', '40', '20', '30', '2760', '260', '90', '2670', 1, '22-03-2021 01:40:06');

-- --------------------------------------------------------

--
-- Table structure for table `umb_security_level`
--

CREATE TABLE `umb_security_level` (
  `type_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_security_level`
--

TRUNCATE TABLE `umb_security_level`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_sub_departments`
--

CREATE TABLE `umb_sub_departments` (
  `sub_department_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `nama_department` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_sub_departments`
--

TRUNCATE TABLE `umb_sub_departments`;
--
-- Dumping data for table `umb_sub_departments`
--

INSERT INTO `umb_sub_departments` (`sub_department_id`, `department_id`, `nama_department`, `created_at`) VALUES
(8, 1, 'Manager', '2019-02-15 00:22:13'),
(9, 1, 'Lead Manager', '2019-02-15 00:22:21'),
(10, 2, 'Accountant', '2019-02-15 00:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `umb_support_tickets`
--

CREATE TABLE `umb_support_tickets` (
  `ticket_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `kode_ticket` varchar(200) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `ticket_priority` varchar(255) NOT NULL,
  `department_id` int(111) NOT NULL,
  `assigned_to` mediumtext NOT NULL,
  `message` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `ticket_remarks` mediumtext NOT NULL,
  `status_ticket` varchar(200) NOT NULL,
  `ticket_note` mediumtext NOT NULL,
  `is_notify` int(11) NOT NULL,
  `ticket_image` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_support_tickets`
--

TRUNCATE TABLE `umb_support_tickets`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_support_tickets_karyawans`
--

CREATE TABLE `umb_support_tickets_karyawans` (
  `tickets_karyawans_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `is_notify` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_support_tickets_karyawans`
--

TRUNCATE TABLE `umb_support_tickets_karyawans`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_support_ticket_files`
--

CREATE TABLE `umb_support_ticket_files` (
  `ticket_file_id` int(111) NOT NULL,
  `ticket_id` int(111) NOT NULL,
  `karyawan_id` int(111) NOT NULL,
  `ticket_files` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_support_ticket_files`
--

TRUNCATE TABLE `umb_support_ticket_files`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_system_setting`
--

CREATE TABLE `umb_system_setting` (
  `setting_id` int(111) NOT NULL,
  `application_name` varchar(255) NOT NULL,
  `default_currency` varchar(255) NOT NULL,
  `default_currency_id` int(11) NOT NULL,
  `default_currency_symbol` varchar(255) NOT NULL,
  `show_currency` varchar(255) NOT NULL,
  `currency_position` varchar(255) NOT NULL,
  `notification_position` varchar(255) NOT NULL,
  `notification_close_btn` varchar(255) NOT NULL,
  `notification_bar` varchar(255) NOT NULL,
  `enable_registration` varchar(255) NOT NULL,
  `login_with` varchar(255) NOT NULL,
  `date_format_astral` varchar(255) NOT NULL,
  `karyawan_manage_own_kontak` varchar(255) NOT NULL,
  `karyawan_manage_own_profile` varchar(255) NOT NULL,
  `karyawan_manage_own_qualification` varchar(255) NOT NULL,
  `karyawan_manage_own_pengalaman_kerja` varchar(255) NOT NULL,
  `karyawan_manage_own_document` varchar(255) NOT NULL,
  `karyawan_manage_own_picture` varchar(255) NOT NULL,
  `karyawan_manage_own_social` varchar(255) NOT NULL,
  `karyawan_manage_own_bank_account` varchar(255) NOT NULL,
  `enable_kehadiran` varchar(255) NOT NULL,
  `enable_clock_in_btn` varchar(255) NOT NULL,
  `enable_email_notification` varchar(255) NOT NULL,
  `payroll_include_day_summary` varchar(255) NOT NULL,
  `payroll_include_hour_summary` varchar(255) NOT NULL,
  `payroll_include_cuti_summary` varchar(255) NOT NULL,
  `enable_pekerjaan_application_kandidats` varchar(255) NOT NULL,
  `logo_pekerjaan` varchar(255) NOT NULL,
  `logo_payroll` varchar(255) NOT NULL,
  `is_generate_password_slipgaji` int(11) NOT NULL,
  `format_password_slipgaji` varchar(255) NOT NULL,
  `enable_profile_background` varchar(255) NOT NULL,
  `enable_kebijakan_link` varchar(255) NOT NULL,
  `enable_layout` varchar(255) NOT NULL,
  `pekerjaan_application_format` mediumtext NOT NULL,
  `technical_competencies` text DEFAULT NULL,
  `organizational_competencies` text DEFAULT NULL,
  `performance_option` varchar(255) DEFAULT NULL,
  `project_email` varchar(255) NOT NULL,
  `libur_email` varchar(255) NOT NULL,
  `cuti_email` varchar(255) NOT NULL,
  `slipgaji_email` varchar(255) NOT NULL,
  `award_email` varchar(255) NOT NULL,
  `recruitment_email` varchar(255) NOT NULL,
  `pengumuman_email` varchar(255) NOT NULL,
  `training_email` varchar(255) NOT NULL,
  `tugas_email` varchar(255) NOT NULL,
  `compact_sidebar` varchar(255) NOT NULL,
  `fixed_header` varchar(255) NOT NULL,
  `fixed_sidebar` varchar(255) NOT NULL,
  `boxed_wrapper` varchar(255) NOT NULL,
  `layout_static` varchar(255) NOT NULL,
  `system_skin` varchar(255) NOT NULL,
  `animation_effect` varchar(255) NOT NULL,
  `animation_effect_modal` varchar(255) NOT NULL,
  `animation_effect_topmenu` varchar(255) NOT NULL,
  `footer_text` varchar(255) NOT NULL,
  `is_ssl_available` varchar(50) NOT NULL,
  `is_active_sub_departments` varchar(10) NOT NULL,
  `default_language` varchar(200) NOT NULL,
  `statutory_fixed` varchar(100) NOT NULL,
  `system_timezone` varchar(200) NOT NULL,
  `system_ip_address` varchar(255) NOT NULL,
  `system_ip_restriction` varchar(200) NOT NULL,
  `google_maps_api_key` mediumtext NOT NULL,
  `module_recruitment` varchar(100) NOT NULL,
  `module_perjalanan` varchar(100) NOT NULL,
  `module_performance` varchar(100) NOT NULL,
  `module_payroll` varchar(10) NOT NULL,
  `module_files` varchar(100) NOT NULL,
  `module_awards` varchar(100) NOT NULL,
  `module_training` varchar(100) NOT NULL,
  `module_inquiry` varchar(100) NOT NULL,
  `module_language` varchar(100) NOT NULL,
  `module_orgchart` varchar(100) NOT NULL,
  `module_accounting` varchar(111) NOT NULL,
  `module_events` varchar(100) NOT NULL,
  `module_tujuan_tracking` varchar(100) NOT NULL,
  `module_assets` varchar(100) NOT NULL,
  `module_projects_tugass` varchar(100) NOT NULL,
  `module_chat_box` varchar(100) NOT NULL,
  `enable_page_rendered` varchar(255) NOT NULL,
  `enable_current_year` varchar(255) NOT NULL,
  `login_karyawan_id` varchar(200) NOT NULL,
  `paypal_email` varchar(100) NOT NULL,
  `paypal_sandbox` varchar(10) NOT NULL,
  `paypal_active` varchar(10) NOT NULL,
  `stripe_secret_key` varchar(200) NOT NULL,
  `stripe_publishable_key` varchar(200) NOT NULL,
  `stripe_active` varchar(10) NOT NULL,
  `online_payment_account` int(11) NOT NULL,
  `is_half_monthly` tinyint(1) NOT NULL,
  `potong_setengah_bulan` tinyint(1) NOT NULL,
  `invoice_terms_condition` text DEFAULT NULL,
  `estimate_terms_condition` text DEFAULT NULL,
  `show_projects` int(11) NOT NULL DEFAULT 0,
  `show_tugass` int(11) NOT NULL DEFAULT 0,
  `enable_asuransi` int(11) NOT NULL DEFAULT 0,
  `dashboard_staff` int(11) DEFAULT NULL,
  `dashboard_project` int(11) DEFAULT NULL,
  `enable_auth_background` varchar(11) NOT NULL,
  `hrastral_versi` varchar(200) NOT NULL,
  `tanggal_rilis_hrastral` varchar(100) NOT NULL,
  `hr_top_menu` text NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_system_setting`
--

TRUNCATE TABLE `umb_system_setting`;
--
-- Dumping data for table `umb_system_setting`
--

INSERT INTO `umb_system_setting` (`setting_id`, `application_name`, `default_currency`, `default_currency_id`, `default_currency_symbol`, `show_currency`, `currency_position`, `notification_position`, `notification_close_btn`, `notification_bar`, `enable_registration`, `login_with`, `date_format_astral`, `karyawan_manage_own_kontak`, `karyawan_manage_own_profile`, `karyawan_manage_own_qualification`, `karyawan_manage_own_pengalaman_kerja`, `karyawan_manage_own_document`, `karyawan_manage_own_picture`, `karyawan_manage_own_social`, `karyawan_manage_own_bank_account`, `enable_kehadiran`, `enable_clock_in_btn`, `enable_email_notification`, `payroll_include_day_summary`, `payroll_include_hour_summary`, `payroll_include_cuti_summary`, `enable_pekerjaan_application_kandidats`, `logo_pekerjaan`, `logo_payroll`, `is_generate_password_slipgaji`, `format_password_slipgaji`, `enable_profile_background`, `enable_kebijakan_link`, `enable_layout`, `pekerjaan_application_format`, `technical_competencies`, `organizational_competencies`, `performance_option`, `project_email`, `libur_email`, `cuti_email`, `slipgaji_email`, `award_email`, `recruitment_email`, `pengumuman_email`, `training_email`, `tugas_email`, `compact_sidebar`, `fixed_header`, `fixed_sidebar`, `boxed_wrapper`, `layout_static`, `system_skin`, `animation_effect`, `animation_effect_modal`, `animation_effect_topmenu`, `footer_text`, `is_ssl_available`, `is_active_sub_departments`, `default_language`, `statutory_fixed`, `system_timezone`, `system_ip_address`, `system_ip_restriction`, `google_maps_api_key`, `module_recruitment`, `module_perjalanan`, `module_performance`, `module_payroll`, `module_files`, `module_awards`, `module_training`, `module_inquiry`, `module_language`, `module_orgchart`, `module_accounting`, `module_events`, `module_tujuan_tracking`, `module_assets`, `module_projects_tugass`, `module_chat_box`, `enable_page_rendered`, `enable_current_year`, `login_karyawan_id`, `paypal_email`, `paypal_sandbox`, `paypal_active`, `stripe_secret_key`, `stripe_publishable_key`, `stripe_active`, `online_payment_account`, `is_half_monthly`, `potong_setengah_bulan`, `invoice_terms_condition`, `estimate_terms_condition`, `show_projects`, `show_tugass`, `enable_asuransi`, `dashboard_staff`, `dashboard_project`, `enable_auth_background`, `hrastral_versi`, `tanggal_rilis_hrastral`, `hr_top_menu`, `updated_at`) VALUES
(1, 'hrastral', 'IDR - Rp', 1, 'IDR - Rp', 'symbol', 'Prefix', 'toast-top-center', 'true', 'true', 'no', 'username', 'M-d-Y', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', '', 'yes', 'yes', 'yes', 'yes', '1', 'logo_pekerjaan_1520612591.png', 'logo_payroll_1534786335.jpg', 0, 'karyawan_id', 'yes', 'yes', 'yes', 'doc,docx,pdf', 'Pengalaman Customer,Marketing,Administration', 'Professionalism,Integrity,kehadiran', 'both', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'sidebar_layout_hrastral', '', 'fixed-sidebar', 'boxed_layout_hrastral', '', 'skin-default', 'fadeInDown', 'tada', 'tada', 'hrastral', '', '', 'english', '', 'Asia/Jakarta', '::1', '', 'AIzaSyB3gP8H3eypotNeoEtezbRiF_f8Zh_p4ck', 'true', 'true', 'yes', 'yes', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', '', 'yes', 'username', 'hrastralsoft-facilitator@gmail.com', 'yes', 'yes', 'sk_test_2XEyr1hQFGByITfQjSwFqNtm', 'pk_test_zVFISCqeQPnniD0ywHBHikMd', 'yes', 1, 0, 1, NULL, NULL, 0, 0, 0, NULL, NULL, 'yes', '1.0.1', '2021-03-28', '', '2021-03-28 04:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `umb_tugass`
--

CREATE TABLE `umb_tugass` (
  `tugas_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `project_id` int(111) NOT NULL,
  `created_by` int(111) NOT NULL,
  `nama_tugas` varchar(255) NOT NULL,
  `assigned_to` varchar(255) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `jam_tugas` varchar(200) NOT NULL,
  `progress_tugas` varchar(200) NOT NULL,
  `description` mediumtext NOT NULL,
  `status_tugas` int(5) NOT NULL,
  `tugas_note` mediumtext NOT NULL,
  `is_notify` int(11) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_tugass`
--

TRUNCATE TABLE `umb_tugass`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_tugass_attachment`
--

CREATE TABLE `umb_tugass_attachment` (
  `attachment_tugas_id` int(11) NOT NULL,
  `tugas_id` int(200) NOT NULL,
  `upload_by` int(255) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_description` mediumtext NOT NULL,
  `attachment_file` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_tugass_attachment`
--

TRUNCATE TABLE `umb_tugass_attachment`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_tugass_comments`
--

CREATE TABLE `umb_tugass_comments` (
  `comment_id` int(11) NOT NULL,
  `tugas_id` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `comments_tugas` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_tugass_comments`
--

TRUNCATE TABLE `umb_tugass_comments`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_kategoris_tugas`
--

CREATE TABLE `umb_kategoris_tugas` (
  `kategori_tugas_id` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `umb_kategoris_tugas`
--

TRUNCATE TABLE `umb_kategoris_tugas`;
--
-- Dumping data for table `umb_kategoris_tugas`
--

INSERT INTO `umb_kategoris_tugas` (`kategori_tugas_id`, `nama_kategori`, `created_at`) VALUES
(5, 'Modelling', '17-02-2021 10:44:48'),
(6, 'Fabrication drawings', '17-02-2021 10:44:55'),
(7, 'Erection drawings', '17-02-2021 10:45:01'),
(8, 'As built drawings', '17-02-2021 10:45:06'),
(9, 'R & D and RFI Related', '17-02-2021 10:45:12'),
(10, 'Checking', '17-02-2021 10:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `umb_types_pajak`
--

CREATE TABLE `umb_types_pajak` (
  `pajak_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_types_pajak`
--

TRUNCATE TABLE `umb_types_pajak`;
--
-- Dumping data for table `umb_types_pajak`
--

INSERT INTO `umb_types_pajak` (`pajak_id`, `name`, `rate`, `type`, `description`, `created_at`) VALUES
(1, 'No Tax', '0', 'fixed', 'test', '25-02-2021'),
(2, 'IVU', '2', 'fixed', 'test', '25-05-2021'),
(3, 'VAT', '5', 'percentage', 'testttt', '25-02-2021');

-- --------------------------------------------------------

--
-- Table structure for table `umb_type_penghentian`
--

CREATE TABLE `umb_type_penghentian` (
  `type_penghentian_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_type_penghentian`
--

TRUNCATE TABLE `umb_type_penghentian`;
--
-- Dumping data for table `umb_type_penghentian`
--

INSERT INTO `umb_type_penghentian` (`type_penghentian_id`, `perusahaan_id`, `type`, `created_at`) VALUES
(1, 1, 'Penghentian Sukarela', '22-03-2021 01:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `umb_theme_settings`
--

CREATE TABLE `umb_theme_settings` (
  `theme_settings_id` int(11) NOT NULL,
  `fixed_layout` varchar(200) NOT NULL,
  `fixed_footer` varchar(200) NOT NULL,
  `boxed_layout` varchar(200) NOT NULL,
  `page_header` varchar(200) NOT NULL,
  `footer_layout` varchar(200) NOT NULL,
  `statistics_cards` varchar(200) NOT NULL,
  `animation_style` varchar(100) NOT NULL,
  `theme_option` varchar(100) NOT NULL,
  `dashboard_option` varchar(100) NOT NULL,
  `dashboard_calendar` varchar(100) NOT NULL,
  `login_page_options` varchar(100) NOT NULL,
  `sub_menu_icons` varchar(100) NOT NULL,
  `statistics_cards_background` varchar(200) NOT NULL,
  `karyawan_cards` varchar(200) NOT NULL,
  `card_border_color` varchar(200) NOT NULL,
  `compact_menu` varchar(200) NOT NULL,
  `flipped_menu` varchar(200) NOT NULL,
  `right_side_icons` varchar(200) NOT NULL,
  `bordered_menu` varchar(200) NOT NULL,
  `form_design` varchar(200) NOT NULL,
  `is_semi_dark` int(11) NOT NULL,
  `semi_dark_color` varchar(200) NOT NULL,
  `top_nav_dark_color` varchar(200) NOT NULL,
  `menu_color_option` varchar(200) NOT NULL,
  `export_orgchart` varchar(100) NOT NULL,
  `export_file_title` mediumtext NOT NULL,
  `org_chart_layout` varchar(200) NOT NULL,
  `org_chart_zoom` varchar(100) NOT NULL,
  `org_chart_pan` varchar(100) NOT NULL,
  `text_page_login` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_theme_settings`
--

TRUNCATE TABLE `umb_theme_settings`;
--
-- Dumping data for table `umb_theme_settings`
--

INSERT INTO `umb_theme_settings` (`theme_settings_id`, `fixed_layout`, `fixed_footer`, `boxed_layout`, `page_header`, `footer_layout`, `statistics_cards`, `animation_style`, `theme_option`, `dashboard_option`, `dashboard_calendar`, `login_page_options`, `sub_menu_icons`, `statistics_cards_background`, `karyawan_cards`, `card_border_color`, `compact_menu`, `flipped_menu`, `right_side_icons`, `bordered_menu`, `form_design`, `is_semi_dark`, `semi_dark_color`, `top_nav_dark_color`, `menu_color_option`, `export_orgchart`, `export_file_title`, `org_chart_layout`, `org_chart_zoom`, `org_chart_pan`, `text_page_login`) VALUES
(1, 'false', 'true', 'false', 'breadcrumb-transparent', 'footer-light', '4', 'fadeInDown', 'template_1', 'dashboard_1', 'true', 'login_page_1', 'fa-check-circle-o', '', '', '', 'true', 'false', 'false', 'false', 'basic_form', 1, 'bg-primary', 'bg-blue-grey', 'menu-dark', 'true', 'hrastral', 't2b', 'true', 'true', 'HRASTRAL memberi Anda platform SDM yang kuat dan hemat biaya untuk memastikan Anda mendapatkan yang terbaik dari karyawan dan manajer Anda. hrastral adalah solusi tepat waktu untuk meningkatkan dan memodernisasi tim SDM Anda agar lebih efisien dan menggabungkan informasi karyawan Anda ke dalam satu sistem SDM yang intuitif.');

-- --------------------------------------------------------

--
-- Table structure for table `umb_tickets_attachment`
--

CREATE TABLE `umb_tickets_attachment` (
  `ticket_attachment_id` int(11) NOT NULL,
  `ticket_id` int(200) NOT NULL,
  `upload_by` int(255) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_description` mediumtext NOT NULL,
  `attachment_file` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_tickets_attachment`
--

TRUNCATE TABLE `umb_tickets_attachment`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_tickets_comments`
--

CREATE TABLE `umb_tickets_comments` (
  `comment_id` int(11) NOT NULL,
  `ticket_id` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `ticket_comments` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_tickets_comments`
--

TRUNCATE TABLE `umb_tickets_comments`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_trainers`
--

CREATE TABLE `umb_trainers` (
  `trainer_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `nomor_kontak` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `penunjukan_id` int(111) NOT NULL,
  `expertise` mediumtext NOT NULL,
  `alamat` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_trainers`
--

TRUNCATE TABLE `umb_trainers`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_training`
--

CREATE TABLE `umb_training` (
  `training_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `karyawan_id` varchar(200) NOT NULL,
  `type_training_id` int(200) NOT NULL,
  `trainer_option` int(11) NOT NULL,
  `trainer_id` int(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `finish_date` varchar(200) NOT NULL,
  `biaya_training` varchar(200) NOT NULL,
  `status_training` int(200) NOT NULL,
  `description` mediumtext NOT NULL,
  `performance` varchar(200) NOT NULL,
  `remarks` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_training`
--

TRUNCATE TABLE `umb_training`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_types_training`
--

CREATE TABLE `umb_types_training` (
  `type_training_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_types_training`
--

TRUNCATE TABLE `umb_types_training`;
--
-- Dumping data for table `umb_types_training`
--

INSERT INTO `umb_types_training` (`type_training_id`, `perusahaan_id`, `type`, `created_at`, `status`) VALUES
(1, 1, 'Training Pekerjaan', '19-03-2021 06:45:47', 1),
(2, 1, 'Workshop', '19-03-2021 06:45:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `umb_type_pengaturan_perjalanan`
--

CREATE TABLE `umb_type_pengaturan_perjalanan` (
  `type_pengaturan_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_type_pengaturan_perjalanan`
--

TRUNCATE TABLE `umb_type_pengaturan_perjalanan`;
--
-- Dumping data for table `umb_type_pengaturan_perjalanan`
--

INSERT INTO `umb_type_pengaturan_perjalanan` (`type_pengaturan_id`, `perusahaan_id`, `type`, `status`, `created_at`) VALUES
(1, 1, 'Perusahaan', 1, '19-03-2021 08:45:17'),
(2, 1, 'Guest House', 1, '19-03-2021 08:45:27');

-- --------------------------------------------------------

--
-- Table structure for table `umb_users`
--

CREATE TABLE `umb_users` (
  `user_id` int(11) NOT NULL,
  `user_role` varchar(30) NOT NULL DEFAULT 'administrator',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `logo_perusahaan` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo` varchar(255) NOT NULL,
  `profile_background` varchar(255) NOT NULL,
  `nomor_kontak` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `alamat_1` text NOT NULL,
  `alamat_2` text NOT NULL,
  `kota` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `kode_pos` varchar(255) NOT NULL,
  `negara` int(11) NOT NULL,
  `tanggal_terakhir_login` varchar(255) NOT NULL,
  `terakhir_login_ip` varchar(255) NOT NULL,
  `is_logged_in` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_users`
--

TRUNCATE TABLE `umb_users`;
-- --------------------------------------------------------

--
-- Table structure for table `umb_user_roles`
--

CREATE TABLE `umb_user_roles` (
  `role_id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `role_name` varchar(200) NOT NULL,
  `role_access` varchar(200) NOT NULL,
  `role_resources` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_user_roles`
--

TRUNCATE TABLE `umb_user_roles`;
--
-- Dumping data for table `umb_user_roles`
--

INSERT INTO `umb_user_roles` (`role_id`, `perusahaan_id`, `role_name`, `role_access`, `role_resources`, `created_at`) VALUES
(1, 1, 'Super Admin', '1', '0,103,13,13,201,202,203,372,373,393,393,394,395,396,422,351,421,88,23,23,204,205,206,231,400,22,445,465,12,14,14,207,208,209,232,15,15,210,211,212,233,16,16,213,214,215,234,406,407,408,17,17,216,217,218,235,18,18,219,220,221,236,19,19,222,223,224,237,20,20,225,226,227,238,21,21,228,229,230,239,2,3,3,240,241,242,4,4,243,244,245,249,5,5,246,247,248,6,6,250,251,252,11,11,254,255,256,257,9,9,258,259,260,96,442,24,25,25,262,263,264,265,26,26,266,267,268,97,98,98,269,270,271,272,99,99,273,274,275,276,27,28,28,397,423,10,10,253,261,29,29,381,30,30,277,278,279,310,401,401,402,403,31,7,7,280,281,282,2822,311,8,8,283,284,285,46,46,287,288,289,290,48,49,49,291,292,293,50,51,51,294,295,387,52,296,32,36,36,313,314,404,405,467,468,40,41,41,298,299,300,301,42,42,302,303,304,305,43,43,306,307,308,309,104,44,44,315,316,317,318,312,90,91,94,424,425,45,45,319,320,321,322,122,122,331,332,333,106,107,107,334,335,336,108,108,338,339,340,47,53,54,54,341,342,343,344,55,55,345,346,347,56,56,348,349,350,57,60,61,62,63,93,118,297,431,432,433,434,435,436,437,438,439,440,441,466,447,448,449,450,451,452,453,454,455,456,457,458,459,460,461,462,463,464,71,286,72,72,352,353,354,73,74,75,75,355,356,357,76,76,358,359,360,77,77,361,362,363,78,37,37,391,79,80,80,364,365,366,81,81,367,368,369,82,83,84,85,86,87,119,119,323,324,325,326,410,411,412,413,414,420,415,416,417,418,419,121,121,120,328,329,330,426,427,428,429,430,89,89,370,371,95,92,443,444,446,110,111,112,113,114,115,116,117,409', '28-02-2021'),
(2, 1, 'Karyawan', '2', '0,445,465,14,207,208,15,210,211,16,213,214,17,216,217,19,222,223,224,20,225,226,227,11,254,255,9,258,259,25,262,263,97,98,98,269,270,271,272,99,99,273,274,275,276,28,10,261,29,401,402,8,283,46,46,287,288,289,290,50,43,306,307,44,315,316,317,312,90,91,94,424,425,45,319,320,321,106,107,107,334,335,336,108,108,338,339,340,47,54,341,342,343,55,55,345,346,347,75,355,356,76,358,359,37,95,92,446', '21-03-2021');

-- --------------------------------------------------------

--
-- Table structure for table `umb_type_peringatan`
--

CREATE TABLE `umb_type_peringatan` (
  `type_peringatan_id` int(111) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `umb_type_peringatan`
--

TRUNCATE TABLE `umb_type_peringatan`;
--
-- Dumping data for table `umb_type_peringatan`
--

INSERT INTO `umb_type_peringatan` (`type_peringatan_id`, `perusahaan_id`, `type`, `created_at`) VALUES
(1, 1, 'Peringatan Tertulis Pertama', '22-03-2021 01:38:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `umb_advance_gajii`
--
ALTER TABLE `umb_advance_gajii`
ADD PRIMARY KEY (`advance_gaji_id`);

--
-- Indexes for table `umb_pengumumans`
--
ALTER TABLE `umb_pengumumans`
ADD PRIMARY KEY (`pengumuman_id`);

--
-- Indexes for table `umb_assets`
--
ALTER TABLE `umb_assets`
ADD PRIMARY KEY (`assets_id`);

--
-- Indexes for table `umb_kategoris_assets`
--
ALTER TABLE `umb_kategoris_assets`
ADD PRIMARY KEY (`kategori_assets_id`);

--
-- Indexes for table `umb_kehadiran_waktu`
--
ALTER TABLE `umb_kehadiran_waktu`
ADD PRIMARY KEY (`waktu_kehadiran_id`);

--
-- Indexes for table `umb_permintaan_waktu_kehadiran`
--
ALTER TABLE `umb_permintaan_waktu_kehadiran`
ADD PRIMARY KEY (`permintaan_waktu_id`);

--
-- Indexes for table `umb_awards`
--
ALTER TABLE `umb_awards`
ADD PRIMARY KEY (`award_id`);

--
-- Indexes for table `umb_type_award`
--
ALTER TABLE `umb_type_award`
ADD PRIMARY KEY (`type_award_id`);

--
-- Indexes for table `umb_chat_messages`
--
ALTER TABLE `umb_chat_messages`
ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `umb_clients`
--
ALTER TABLE `umb_clients`
ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `umb_perusahaans`
--
ALTER TABLE `umb_perusahaans`
ADD PRIMARY KEY (`perusahaan_id`);

--
-- Indexes for table `umb_documents_perusahaan`
--
ALTER TABLE `umb_documents_perusahaan`
ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `umb_info_perusahaan`
--
ALTER TABLE `umb_info_perusahaan`
ADD PRIMARY KEY (`info_perusahaan_id`);

--
-- Indexes for table `umb_kebijakan_perusahaan`
--
ALTER TABLE `umb_kebijakan_perusahaan`
ADD PRIMARY KEY (`kebijakan_id`);

--
-- Indexes for table `umb_type_perusahaan`
--
ALTER TABLE `umb_type_perusahaan`
ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `umb_type_kontrak`
--
ALTER TABLE `umb_type_kontrak`
ADD PRIMARY KEY (`type_kontrak_id`);

--
-- Indexes for table `umb_negaraa`
--
ALTER TABLE `umb_negaraa`
ADD PRIMARY KEY (`negara_id`);

--
-- Indexes for table `umb_currencies`
--
ALTER TABLE `umb_currencies`
ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `umb_currency_converter`
--
ALTER TABLE `umb_currency_converter`
ADD PRIMARY KEY (`currency_converter_id`);

--
-- Indexes for table `umb_database_backup`
--
ALTER TABLE `umb_database_backup`
ADD PRIMARY KEY (`backup_id`);

--
-- Indexes for table `umb_departments`
--
ALTER TABLE `umb_departments`
ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `umb_penunjukans`
--
ALTER TABLE `umb_penunjukans`
ADD PRIMARY KEY (`penunjukan_id`);

--
-- Indexes for table `umb_type_document`
--
ALTER TABLE `umb_type_document`
ADD PRIMARY KEY (`type_document_id`);

--
-- Indexes for table `umb_email_configuration`
--
ALTER TABLE `umb_email_configuration`
ADD PRIMARY KEY (`email_config_id`);

--
-- Indexes for table `umb_email_template`
--
ALTER TABLE `umb_email_template`
ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `umb_karyawans`
--
ALTER TABLE `umb_karyawans`
ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `umb_karyawan_bankaccount`
--
ALTER TABLE `umb_karyawan_bankaccount`
ADD PRIMARY KEY (`bankaccount_id`);

--
-- Indexes for table `umb_keluhans_karyawan`
--
ALTER TABLE `umb_keluhans_karyawan`
ADD PRIMARY KEY (`keluhan_id`);

--
-- Indexes for table `umb_kontaks_karyawan`
--
ALTER TABLE `umb_kontaks_karyawan`
ADD PRIMARY KEY (`kontak_id`);

--
-- Indexes for table `umb_karyawan_kontrak`
--
ALTER TABLE `umb_karyawan_kontrak`
ADD PRIMARY KEY (`kontrak_id`);

--
-- Indexes for table `umb_documents_karyawan`
--
ALTER TABLE `umb_documents_karyawan`
ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `umb_karyawan_exit`
--
ALTER TABLE `umb_karyawan_exit`
ADD PRIMARY KEY (`exit_id`);

--
-- Indexes for table `umb_karyawan_type_exit`
--
ALTER TABLE `umb_karyawan_type_exit`
ADD PRIMARY KEY (`type_exit_id`);

--
-- Indexes for table `umb_karyawan_immigration`
--
ALTER TABLE `umb_karyawan_immigration`
ADD PRIMARY KEY (`immigration_id`);

--
-- Indexes for table `umb_karyawan_cuti`
--
ALTER TABLE `umb_karyawan_cuti`
ADD PRIMARY KEY (`cuti_id`);

--
-- Indexes for table `umb_location_karyawan`
--
ALTER TABLE `umb_location_karyawan`
ADD PRIMARY KEY (`location_kantor_id`);

--
-- Indexes for table `umb_promotions_karyawan`
--
ALTER TABLE `umb_promotions_karyawan`
ADD PRIMARY KEY (`promotion_id`);

--
-- Indexes for table `umb_karyawan_qualification`
--
ALTER TABLE `umb_karyawan_qualification`
ADD PRIMARY KEY (`qualification_id`);

--
-- Indexes for table `umb_pengundurans_diri_karyawan`
--
ALTER TABLE `umb_pengundurans_diri_karyawan`
ADD PRIMARY KEY (`pengunduran_diri_id`);

--
-- Indexes for table `umb_karyawan_security_level`
--
ALTER TABLE `umb_karyawan_security_level`
ADD PRIMARY KEY (`security_level_id`);

--
-- Indexes for table `umb_karyawan_shift`
--
ALTER TABLE `umb_karyawan_shift`
ADD PRIMARY KEY (`emp_shift_id`);

--
-- Indexes for table `umb_penghentians_karyawan`
--
ALTER TABLE `umb_penghentians_karyawan`
ADD PRIMARY KEY (`penghentian_id`);

--
-- Indexes for table `umb_karyawan_transfer`
--
ALTER TABLE `umb_karyawan_transfer`
ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `umb_perjalanans_karyawan`
--
ALTER TABLE `umb_perjalanans_karyawan`
ADD PRIMARY KEY (`perjalanan_id`);

--
-- Indexes for table `umb_peringatans_karyawan`
--
ALTER TABLE `umb_peringatans_karyawan`
ADD PRIMARY KEY (`peringatan_id`);

--
-- Indexes for table `umb_karyawan_pengalaman_kerja`
--
ALTER TABLE `umb_karyawan_pengalaman_kerja`
ADD PRIMARY KEY (`pengalaman_kerja_id`);

--
-- Indexes for table `umb_type_sukubangsa`
--
ALTER TABLE `umb_type_sukubangsa`
ADD PRIMARY KEY (`type_sukubangsa_id`);

--
-- Indexes for table `umb_events`
--
ALTER TABLE `umb_events`
ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `umb_biayaa`
--
ALTER TABLE `umb_biayaa`
ADD PRIMARY KEY (`biaya_id`);

--
-- Indexes for table `umb_type_biaya`
--
ALTER TABLE `umb_type_biaya`
ADD PRIMARY KEY (`type_biaya_id`);

--
-- Indexes for table `umb_file_manager`
--
ALTER TABLE `umb_file_manager`
ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `umb_file_manager_settings`
--
ALTER TABLE `umb_file_manager_settings`
ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `umb_keuangan_bankcash`
--
ALTER TABLE `umb_keuangan_bankcash`
ADD PRIMARY KEY (`bankcash_id`);

--
-- Indexes for table `umb_keuangan_deposit`
--
ALTER TABLE `umb_keuangan_deposit`
ADD PRIMARY KEY (`deposit_id`);

--
-- Indexes for table `umb_keuangan_biaya`
--
ALTER TABLE `umb_keuangan_biaya`
ADD PRIMARY KEY (`biaya_id`);

--
-- Indexes for table `umb_keuangan_penerima_pembayarans`
--
ALTER TABLE `umb_keuangan_penerima_pembayarans`
ADD PRIMARY KEY (`penerima_pembayaran_id`);

--
-- Indexes for table `umb_keuangan_pembayars`
--
ALTER TABLE `umb_keuangan_pembayars`
ADD PRIMARY KEY (`pembayar_id`);

--
-- Indexes for table `umb_keuangan_transaksi`
--
ALTER TABLE `umb_keuangan_transaksi`
ADD PRIMARY KEY (`transaksi_id`);

--
-- Indexes for table `umb_keuangan_transaksii`
--
ALTER TABLE `umb_keuangan_transaksii`
ADD PRIMARY KEY (`transaksi_id`);

--
-- Indexes for table `umb_keuangan_transfer`
--
ALTER TABLE `umb_keuangan_transfer`
ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `umb_tujuan_tracking`
--
ALTER TABLE `umb_tujuan_tracking`
ADD PRIMARY KEY (`tracking_id`);

--
-- Indexes for table `umb_type_tujuan_tracking`
--
ALTER TABLE `umb_type_tujuan_tracking`
ADD PRIMARY KEY (`type_tracking_id`);

--
-- Indexes for table `umb_liburan`
--
ALTER TABLE `umb_liburan`
ADD PRIMARY KEY (`libur_id`);

--
-- Indexes for table `umb_templates_perjam`
--
ALTER TABLE `umb_templates_perjam`
ADD PRIMARY KEY (`nilai_perjam_id`);

--
-- Indexes for table `umb_hrastral_invoices`
--
ALTER TABLE `umb_hrastral_invoices`
ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `umb_hrastral_invoices_items`
--
ALTER TABLE `umb_hrastral_invoices_items`
ADD PRIMARY KEY (`invoice_item_id`);

--
-- Indexes for table `umb_hrastral_module_attributes`
--
ALTER TABLE `umb_hrastral_module_attributes`
ADD PRIMARY KEY (`custom_field_id`);

--
-- Indexes for table `umb_hrastral_module_attributes_select_value`
--
ALTER TABLE `umb_hrastral_module_attributes_select_value`
ADD PRIMARY KEY (`attributes_select_value_id`);

--
-- Indexes for table `umb_hrastral_module_attributes_values`
--
ALTER TABLE `umb_hrastral_module_attributes_values`
ADD PRIMARY KEY (`attributes_value_id`);

--
-- Indexes for table `umb_hrastral_notificaions`
--
ALTER TABLE `umb_hrastral_notificaions`
ADD PRIMARY KEY (`notificaion_id`);

--
-- Indexes for table `umb_hrastral_quotes`
--
ALTER TABLE `umb_hrastral_quotes`
ADD PRIMARY KEY (`quote_id`);

--
-- Indexes for table `umb_hrastral_quotes_items`
--
ALTER TABLE `umb_hrastral_quotes_items`
ADD PRIMARY KEY (`quote_item_id`);

--
-- Indexes for table `umb_kategoris_pendapatan`
--
ALTER TABLE `umb_kategoris_pendapatan`
ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `umb_pekerjaans`
--
ALTER TABLE `umb_pekerjaans`
ADD PRIMARY KEY (`pekerjaan_id`);

--
-- Indexes for table `umb_applications_pekerjaan`
--
ALTER TABLE `umb_applications_pekerjaan`
ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `umb_kategoris_pekerjaan`
--
ALTER TABLE `umb_kategoris_pekerjaan`
ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `umb_interviews_pekerjaan`
--
ALTER TABLE `umb_interviews_pekerjaan`
ADD PRIMARY KEY (`pekerjaan_interview_id`);

--
-- Indexes for table `umb_pages_pekerjaan`
--
ALTER TABLE `umb_pages_pekerjaan`
ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `umb_type_pekerjaan`
--
ALTER TABLE `umb_type_pekerjaan`
ADD PRIMARY KEY (`type_pekerjaan_id`);

--
-- Indexes for table `umb_kpi_incidental`
--
ALTER TABLE `umb_kpi_incidental`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `umb_kpi_maingoals`
--
ALTER TABLE `umb_kpi_maingoals`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `umb_kpi_variable`
--
ALTER TABLE `umb_kpi_variable`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `umb_languages`
--
ALTER TABLE `umb_languages`
ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `umb_leads`
--
ALTER TABLE `umb_leads`
ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `umb_leads_followup`
--
ALTER TABLE `umb_leads_followup`
ADD PRIMARY KEY (`leads_followup_id`);

--
-- Indexes for table `umb_applications_cuti`
--
ALTER TABLE `umb_applications_cuti`
ADD PRIMARY KEY (`cuti_id`);

--
-- Indexes for table `umb_type_cuti`
--
ALTER TABLE `umb_type_cuti`
ADD PRIMARY KEY (`type_cuti_id`);

--
-- Indexes for table `umb_melakukan_pembayaran`
--
ALTER TABLE `umb_melakukan_pembayaran`
ADD PRIMARY KEY (`melakukan_pembayaran_id`);

--
-- Indexes for table `umb_meetings`
--
ALTER TABLE `umb_meetings`
ADD PRIMARY KEY (`meeting_id`);

--
-- Indexes for table `umb_location_kantor`
--
ALTER TABLE `umb_location_kantor`
ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `umb_shift_kantor`
--
ALTER TABLE `umb_shift_kantor`
ADD PRIMARY KEY (`shift_kantor_id`);

--
-- Indexes for table `umb_payment_method`
--
ALTER TABLE `umb_payment_method`
ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `umb_payroll_custom_fields`
--
ALTER TABLE `umb_payroll_custom_fields`
ADD PRIMARY KEY (`payroll_custom_id`);

--
-- Indexes for table `umb_performance_appraisal`
--
ALTER TABLE `umb_performance_appraisal`
ADD PRIMARY KEY (`performance_appraisal_id`);

--
-- Indexes for table `umb_performance_appraisal_options`
--
ALTER TABLE `umb_performance_appraisal_options`
ADD PRIMARY KEY (`performance_appraisal_options_id`);

--
-- Indexes for table `umb_performance_indicator`
--
ALTER TABLE `umb_performance_indicator`
ADD PRIMARY KEY (`performance_indicator_id`);

--
-- Indexes for table `umb_performance_indicator_options`
--
ALTER TABLE `umb_performance_indicator_options`
ADD PRIMARY KEY (`performance_indicator_options_id`);

--
-- Indexes for table `umb_projects`
--
ALTER TABLE `umb_projects`
ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `umb_attachment_projects`
--
ALTER TABLE `umb_attachment_projects`
ADD PRIMARY KEY (`project_attachment_id`);

--
-- Indexes for table `umb_projects_bugs`
--
ALTER TABLE `umb_projects_bugs`
ADD PRIMARY KEY (`bug_id`);

--
-- Indexes for table `umb_diskusi_project`
--
ALTER TABLE `umb_diskusi_project`
ADD PRIMARY KEY (`diskusi_id`);

--
-- Indexes for table `umb_projects_timelogs`
--
ALTER TABLE `umb_projects_timelogs`
ADD PRIMARY KEY (`timelogs_id`);

--
-- Indexes for table `umb_variasii_project`
--
ALTER TABLE `umb_variasii_project`
ADD PRIMARY KEY (`variasi_id`) USING BTREE;

--
-- Indexes for table `umb_qualification_tingakat_pendidikan`
--
ALTER TABLE `umb_qualification_tingakat_pendidikan`
ADD PRIMARY KEY (`tingkat_pendidikan_id`);

--
-- Indexes for table `umb_qualification_language`
--
ALTER TABLE `umb_qualification_language`
ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `umb_qualification_skill`
--
ALTER TABLE `umb_qualification_skill`
ADD PRIMARY KEY (`skill_id`);

--
-- Indexes for table `umb_quoted_projects`
--
ALTER TABLE `umb_quoted_projects`
ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `umb_quoted_projects_attachment`
--
ALTER TABLE `umb_quoted_projects_attachment`
ADD PRIMARY KEY (`project_attachment_id`);

--
-- Indexes for table `umb_diskusi_quoted_projects`
--
ALTER TABLE `umb_diskusi_quoted_projects`
ADD PRIMARY KEY (`diskusi_id`);

--
-- Indexes for table `umb_quoted_projects_timelogs`
--
ALTER TABLE `umb_quoted_projects_timelogs`
ADD PRIMARY KEY (`timelogs_id`);

--
-- Indexes for table `umb_recruitment_pages`
--
ALTER TABLE `umb_recruitment_pages`
ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `umb_subpages_recruitment`
--
ALTER TABLE `umb_subpages_recruitment`
ADD PRIMARY KEY (`subpages_id`);

--
-- Indexes for table `umb_gaji_tunjanagans`
--
ALTER TABLE `umb_gaji_tunjanagans`
ADD PRIMARY KEY (`tunjanagan_id`);

--
-- Indexes for table `umb_gaji_bank_allocation`
--
ALTER TABLE `umb_gaji_bank_allocation`
ADD PRIMARY KEY (`bank_allocation_id`);

--
-- Indexes for table `umb_gaji_komissi`
--
ALTER TABLE `umb_gaji_komissi`
ADD PRIMARY KEY (`gaji_komissi_id`);

--
-- Indexes for table `umb_gaji_pinjaman_potongans`
--
ALTER TABLE `umb_gaji_pinjaman_potongans`
ADD PRIMARY KEY (`potongan_pinjaman_id`);

--
-- Indexes for table `umb_gaji_pembayarans_lainnya`
--
ALTER TABLE `umb_gaji_pembayarans_lainnya`
ADD PRIMARY KEY (`pembayarans_lainnya_id`);

--
-- Indexes for table `umb_gaji_lembur`
--
ALTER TABLE `umb_gaji_lembur`
ADD PRIMARY KEY (`gaji_lembur_id`);

--
-- Indexes for table `umb_gaji_slipgajii`
--
ALTER TABLE `umb_gaji_slipgajii`
ADD PRIMARY KEY (`slipgaji_id`);

--
-- Indexes for table `umb_gaji_slipgaji_tunjanagans`
--
ALTER TABLE `umb_gaji_slipgaji_tunjanagans`
ADD PRIMARY KEY (`slipgaji_tunjanagans_id`);

--
-- Indexes for table `umb_gaji_slipgaji_komissi`
--
ALTER TABLE `umb_gaji_slipgaji_komissi`
ADD PRIMARY KEY (`slipgaji_komissi_id`);

--
-- Indexes for table `umb_gaji_slipgaji_pinjaman`
--
ALTER TABLE `umb_gaji_slipgaji_pinjaman`
ADD PRIMARY KEY (`slipgaji_pinjaman_id`);

--
-- Indexes for table `umb_gaji_slipgaji_pembayarans_lainnya`
--
ALTER TABLE `umb_gaji_slipgaji_pembayarans_lainnya`
ADD PRIMARY KEY (`slipgaji_pembayaran_lainnya_id`);

--
-- Indexes for table `umb_gaji_slipgaji_lembur`
--
ALTER TABLE `umb_gaji_slipgaji_lembur`
ADD PRIMARY KEY (`slipgaji_lembur_id`);

--
-- Indexes for table `umb_gaji_slipgaji_statutory_potongans`
--
ALTER TABLE `umb_gaji_slipgaji_statutory_potongans`
ADD PRIMARY KEY (`slipgaji_potongan_id`);

--
-- Indexes for table `umb_gaji_statutory_potongans`
--
ALTER TABLE `umb_gaji_statutory_potongans`
ADD PRIMARY KEY (`statutory_potongans_id`);

--
-- Indexes for table `umb_gaji_templates`
--
ALTER TABLE `umb_gaji_templates`
ADD PRIMARY KEY (`gaji_template_id`);

--
-- Indexes for table `umb_security_level`
--
ALTER TABLE `umb_security_level`
ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `umb_sub_departments`
--
ALTER TABLE `umb_sub_departments`
ADD PRIMARY KEY (`sub_department_id`);

--
-- Indexes for table `umb_support_tickets`
--
ALTER TABLE `umb_support_tickets`
ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `umb_support_tickets_karyawans`
--
ALTER TABLE `umb_support_tickets_karyawans`
ADD PRIMARY KEY (`tickets_karyawans_id`);

--
-- Indexes for table `umb_support_ticket_files`
--
ALTER TABLE `umb_support_ticket_files`
ADD PRIMARY KEY (`ticket_file_id`);

--
-- Indexes for table `umb_system_setting`
--
ALTER TABLE `umb_system_setting`
ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `umb_tugass`
--
ALTER TABLE `umb_tugass`
ADD PRIMARY KEY (`tugas_id`);

--
-- Indexes for table `umb_tugass_attachment`
--
ALTER TABLE `umb_tugass_attachment`
ADD PRIMARY KEY (`attachment_tugas_id`);

--
-- Indexes for table `umb_tugass_comments`
--
ALTER TABLE `umb_tugass_comments`
ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `umb_kategoris_tugas`
--
ALTER TABLE `umb_kategoris_tugas`
ADD PRIMARY KEY (`kategori_tugas_id`);

--
-- Indexes for table `umb_types_pajak`
--
ALTER TABLE `umb_types_pajak`
ADD PRIMARY KEY (`pajak_id`);

--
-- Indexes for table `umb_type_penghentian`
--
ALTER TABLE `umb_type_penghentian`
ADD PRIMARY KEY (`type_penghentian_id`);

--
-- Indexes for table `umb_theme_settings`
--
ALTER TABLE `umb_theme_settings`
ADD PRIMARY KEY (`theme_settings_id`);

--
-- Indexes for table `umb_tickets_attachment`
--
ALTER TABLE `umb_tickets_attachment`
ADD PRIMARY KEY (`ticket_attachment_id`);

--
-- Indexes for table `umb_tickets_comments`
--
ALTER TABLE `umb_tickets_comments`
ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `umb_trainers`
--
ALTER TABLE `umb_trainers`
ADD PRIMARY KEY (`trainer_id`);

--
-- Indexes for table `umb_training`
--
ALTER TABLE `umb_training`
ADD PRIMARY KEY (`training_id`);

--
-- Indexes for table `umb_types_training`
--
ALTER TABLE `umb_types_training`
ADD PRIMARY KEY (`type_training_id`);

--
-- Indexes for table `umb_type_pengaturan_perjalanan`
--
ALTER TABLE `umb_type_pengaturan_perjalanan`
ADD PRIMARY KEY (`type_pengaturan_id`);

--
-- Indexes for table `umb_users`
--
ALTER TABLE `umb_users`
ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `umb_user_roles`
--
ALTER TABLE `umb_user_roles`
ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `umb_type_peringatan`
--
ALTER TABLE `umb_type_peringatan`
ADD PRIMARY KEY (`type_peringatan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `umb_advance_gajii`
--
ALTER TABLE `umb_advance_gajii`
MODIFY `advance_gaji_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_pengumumans`
--
ALTER TABLE `umb_pengumumans`
MODIFY `pengumuman_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_assets`
--
ALTER TABLE `umb_assets`
MODIFY `assets_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_kategoris_assets`
--
ALTER TABLE `umb_kategoris_assets`
MODIFY `kategori_assets_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_kehadiran_waktu`
--
ALTER TABLE `umb_kehadiran_waktu`
MODIFY `waktu_kehadiran_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_permintaan_waktu_kehadiran`
--
ALTER TABLE `umb_permintaan_waktu_kehadiran`
MODIFY `permintaan_waktu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_awards`
--
ALTER TABLE `umb_awards`
MODIFY `award_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_type_award`
--
ALTER TABLE `umb_type_award`
MODIFY `type_award_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_chat_messages`
--
ALTER TABLE `umb_chat_messages`
MODIFY `message_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_clients`
--
ALTER TABLE `umb_clients`
MODIFY `client_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_perusahaans`
--
ALTER TABLE `umb_perusahaans`
MODIFY `perusahaan_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_documents_perusahaan`
--
ALTER TABLE `umb_documents_perusahaan`
MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_info_perusahaan`
--
ALTER TABLE `umb_info_perusahaan`
MODIFY `info_perusahaan_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_kebijakan_perusahaan`
--
ALTER TABLE `umb_kebijakan_perusahaan`
MODIFY `kebijakan_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_type_perusahaan`
--
ALTER TABLE `umb_type_perusahaan`
MODIFY `type_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `umb_type_kontrak`
--
ALTER TABLE `umb_type_kontrak`
MODIFY `type_kontrak_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_negaraa`
--
ALTER TABLE `umb_negaraa`
MODIFY `negara_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `umb_currencies`
--
ALTER TABLE `umb_currencies`
MODIFY `currency_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_currency_converter`
--
ALTER TABLE `umb_currency_converter`
MODIFY `currency_converter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_database_backup`
--
ALTER TABLE `umb_database_backup`
MODIFY `backup_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_departments`
--
ALTER TABLE `umb_departments`
MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `umb_penunjukans`
--
ALTER TABLE `umb_penunjukans`
MODIFY `penunjukan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `umb_type_document`
--
ALTER TABLE `umb_type_document`
MODIFY `type_document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_email_configuration`
--
ALTER TABLE `umb_email_configuration`
MODIFY `email_config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_email_template`
--
ALTER TABLE `umb_email_template`
MODIFY `template_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `umb_karyawans`
--
ALTER TABLE `umb_karyawans`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `umb_karyawan_bankaccount`
--
ALTER TABLE `umb_karyawan_bankaccount`
MODIFY `bankaccount_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_keluhans_karyawan`
--
ALTER TABLE `umb_keluhans_karyawan`
MODIFY `keluhan_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_kontaks_karyawan`
--
ALTER TABLE `umb_kontaks_karyawan`
MODIFY `kontak_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_karyawan_kontrak`
--
ALTER TABLE `umb_karyawan_kontrak`
MODIFY `kontrak_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_documents_karyawan`
--
ALTER TABLE `umb_documents_karyawan`
MODIFY `document_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_karyawan_exit`
--
ALTER TABLE `umb_karyawan_exit`
MODIFY `exit_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_karyawan_type_exit`
--
ALTER TABLE `umb_karyawan_type_exit`
MODIFY `type_exit_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_karyawan_immigration`
--
ALTER TABLE `umb_karyawan_immigration`
MODIFY `immigration_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_karyawan_cuti`
--
ALTER TABLE `umb_karyawan_cuti`
MODIFY `cuti_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_location_karyawan`
--
ALTER TABLE `umb_location_karyawan`
MODIFY `location_kantor_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_promotions_karyawan`
--
ALTER TABLE `umb_promotions_karyawan`
MODIFY `promotion_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_karyawan_qualification`
--
ALTER TABLE `umb_karyawan_qualification`
MODIFY `qualification_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_pengundurans_diri_karyawan`
--
ALTER TABLE `umb_pengundurans_diri_karyawan`
MODIFY `pengunduran_diri_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_karyawan_security_level`
--
ALTER TABLE `umb_karyawan_security_level`
MODIFY `security_level_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_karyawan_shift`
--
ALTER TABLE `umb_karyawan_shift`
MODIFY `emp_shift_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_penghentians_karyawan`
--
ALTER TABLE `umb_penghentians_karyawan`
MODIFY `penghentian_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_karyawan_transfer`
--
ALTER TABLE `umb_karyawan_transfer`
MODIFY `transfer_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_perjalanans_karyawan`
--
ALTER TABLE `umb_perjalanans_karyawan`
MODIFY `perjalanan_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_peringatans_karyawan`
--
ALTER TABLE `umb_peringatans_karyawan`
MODIFY `peringatan_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_karyawan_pengalaman_kerja`
--
ALTER TABLE `umb_karyawan_pengalaman_kerja`
MODIFY `pengalaman_kerja_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_type_sukubangsa`
--
ALTER TABLE `umb_type_sukubangsa`
MODIFY `type_sukubangsa_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_events`
--
ALTER TABLE `umb_events`
MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_biayaa`
--
ALTER TABLE `umb_biayaa`
MODIFY `biaya_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_type_biaya`
--
ALTER TABLE `umb_type_biaya`
MODIFY `type_biaya_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `umb_file_manager`
--
ALTER TABLE `umb_file_manager`
MODIFY `file_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_file_manager_settings`
--
ALTER TABLE `umb_file_manager_settings`
MODIFY `setting_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_keuangan_bankcash`
--
ALTER TABLE `umb_keuangan_bankcash`
MODIFY `bankcash_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_keuangan_deposit`
--
ALTER TABLE `umb_keuangan_deposit`
MODIFY `deposit_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_keuangan_biaya`
--
ALTER TABLE `umb_keuangan_biaya`
MODIFY `biaya_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_keuangan_penerima_pembayarans`
--
ALTER TABLE `umb_keuangan_penerima_pembayarans`
MODIFY `penerima_pembayaran_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_keuangan_pembayars`
--
ALTER TABLE `umb_keuangan_pembayars`
MODIFY `pembayar_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_keuangan_transaksi`
--
ALTER TABLE `umb_keuangan_transaksi`
MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_keuangan_transaksii`
--
ALTER TABLE `umb_keuangan_transaksii`
MODIFY `transaksi_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_keuangan_transfer`
--
ALTER TABLE `umb_keuangan_transfer`
MODIFY `transfer_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_tujuan_tracking`
--
ALTER TABLE `umb_tujuan_tracking`
MODIFY `tracking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_type_tujuan_tracking`
--
ALTER TABLE `umb_type_tujuan_tracking`
MODIFY `type_tracking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `umb_liburan`
--
ALTER TABLE `umb_liburan`
MODIFY `libur_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_templates_perjam`
--
ALTER TABLE `umb_templates_perjam`
MODIFY `nilai_perjam_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_hrastral_invoices`
--
ALTER TABLE `umb_hrastral_invoices`
MODIFY `invoice_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_hrastral_invoices_items`
--
ALTER TABLE `umb_hrastral_invoices_items`
MODIFY `invoice_item_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_hrastral_module_attributes`
--
ALTER TABLE `umb_hrastral_module_attributes`
MODIFY `custom_field_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_hrastral_module_attributes_select_value`
--
ALTER TABLE `umb_hrastral_module_attributes_select_value`
MODIFY `attributes_select_value_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_hrastral_module_attributes_values`
--
ALTER TABLE `umb_hrastral_module_attributes_values`
MODIFY `attributes_value_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_hrastral_notificaions`
--
ALTER TABLE `umb_hrastral_notificaions`
MODIFY `notificaion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_hrastral_quotes`
--
ALTER TABLE `umb_hrastral_quotes`
MODIFY `quote_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_hrastral_quotes_items`
--
ALTER TABLE `umb_hrastral_quotes_items`
MODIFY `quote_item_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_kategoris_pendapatan`
--
ALTER TABLE `umb_kategoris_pendapatan`
MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `umb_pekerjaans`
--
ALTER TABLE `umb_pekerjaans`
MODIFY `pekerjaan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_applications_pekerjaan`
--
ALTER TABLE `umb_applications_pekerjaan`
MODIFY `application_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_kategoris_pekerjaan`
--
ALTER TABLE `umb_kategoris_pekerjaan`
MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `umb_interviews_pekerjaan`
--
ALTER TABLE `umb_interviews_pekerjaan`
MODIFY `pekerjaan_interview_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_pages_pekerjaan`
--
ALTER TABLE `umb_pages_pekerjaan`
MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `umb_type_pekerjaan`
--
ALTER TABLE `umb_type_pekerjaan`
MODIFY `type_pekerjaan_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `umb_kpi_incidental`
--
ALTER TABLE `umb_kpi_incidental`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_kpi_maingoals`
--
ALTER TABLE `umb_kpi_maingoals`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_kpi_variable`
--
ALTER TABLE `umb_kpi_variable`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_languages`
--
ALTER TABLE `umb_languages`
MODIFY `language_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `umb_leads`
--
ALTER TABLE `umb_leads`
MODIFY `client_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_leads_followup`
--
ALTER TABLE `umb_leads_followup`
MODIFY `leads_followup_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_applications_cuti`
--
ALTER TABLE `umb_applications_cuti`
MODIFY `cuti_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_type_cuti`
--
ALTER TABLE `umb_type_cuti`
MODIFY `type_cuti_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `umb_melakukan_pembayaran`
--
ALTER TABLE `umb_melakukan_pembayaran`
MODIFY `melakukan_pembayaran_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_meetings`
--
ALTER TABLE `umb_meetings`
MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_location_kantor`
--
ALTER TABLE `umb_location_kantor`
MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_shift_kantor`
--
ALTER TABLE `umb_shift_kantor`
MODIFY `shift_kantor_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_payment_method`
--
ALTER TABLE `umb_payment_method`
MODIFY `payment_method_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `umb_payroll_custom_fields`
--
ALTER TABLE `umb_payroll_custom_fields`
MODIFY `payroll_custom_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_performance_appraisal`
--
ALTER TABLE `umb_performance_appraisal`
MODIFY `performance_appraisal_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_performance_appraisal_options`
--
ALTER TABLE `umb_performance_appraisal_options`
MODIFY `performance_appraisal_options_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_performance_indicator`
--
ALTER TABLE `umb_performance_indicator`
MODIFY `performance_indicator_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_performance_indicator_options`
--
ALTER TABLE `umb_performance_indicator_options`
MODIFY `performance_indicator_options_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_projects`
--
ALTER TABLE `umb_projects`
MODIFY `project_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_attachment_projects`
--
ALTER TABLE `umb_attachment_projects`
MODIFY `project_attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_projects_bugs`
--
ALTER TABLE `umb_projects_bugs`
MODIFY `bug_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_diskusi_project`
--
ALTER TABLE `umb_diskusi_project`
MODIFY `diskusi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_projects_timelogs`
--
ALTER TABLE `umb_projects_timelogs`
MODIFY `timelogs_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_variasii_project`
--
ALTER TABLE `umb_variasii_project`
MODIFY `variasi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_qualification_tingakat_pendidikan`
--
ALTER TABLE `umb_qualification_tingakat_pendidikan`
MODIFY `tingkat_pendidikan_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_qualification_language`
--
ALTER TABLE `umb_qualification_language`
MODIFY `language_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_qualification_skill`
--
ALTER TABLE `umb_qualification_skill`
MODIFY `skill_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_quoted_projects`
--
ALTER TABLE `umb_quoted_projects`
MODIFY `project_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_quoted_projects_attachment`
--
ALTER TABLE `umb_quoted_projects_attachment`
MODIFY `project_attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_diskusi_quoted_projects`
--
ALTER TABLE `umb_diskusi_quoted_projects`
MODIFY `diskusi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_quoted_projects_timelogs`
--
ALTER TABLE `umb_quoted_projects_timelogs`
MODIFY `timelogs_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_recruitment_pages`
--
ALTER TABLE `umb_recruitment_pages`
MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `umb_subpages_recruitment`
--
ALTER TABLE `umb_subpages_recruitment`
MODIFY `subpages_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `umb_gaji_tunjanagans`
--
ALTER TABLE `umb_gaji_tunjanagans`
MODIFY `tunjanagan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `umb_gaji_bank_allocation`
--
ALTER TABLE `umb_gaji_bank_allocation`
MODIFY `bank_allocation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_komissi`
--
ALTER TABLE `umb_gaji_komissi`
MODIFY `gaji_komissi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_pinjaman_potongans`
--
ALTER TABLE `umb_gaji_pinjaman_potongans`
MODIFY `potongan_pinjaman_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_pembayarans_lainnya`
--
ALTER TABLE `umb_gaji_pembayarans_lainnya`
MODIFY `pembayarans_lainnya_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_lembur`
--
ALTER TABLE `umb_gaji_lembur`
MODIFY `gaji_lembur_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_slipgajii`
--
ALTER TABLE `umb_gaji_slipgajii`
MODIFY `slipgaji_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_slipgaji_tunjanagans`
--
ALTER TABLE `umb_gaji_slipgaji_tunjanagans`
MODIFY `slipgaji_tunjanagans_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_slipgaji_komissi`
--
ALTER TABLE `umb_gaji_slipgaji_komissi`
MODIFY `slipgaji_komissi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_slipgaji_pinjaman`
--
ALTER TABLE `umb_gaji_slipgaji_pinjaman`
MODIFY `slipgaji_pinjaman_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_slipgaji_pembayarans_lainnya`
--
ALTER TABLE `umb_gaji_slipgaji_pembayarans_lainnya`
MODIFY `slipgaji_pembayaran_lainnya_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_slipgaji_lembur`
--
ALTER TABLE `umb_gaji_slipgaji_lembur`
MODIFY `slipgaji_lembur_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_slipgaji_statutory_potongans`
--
ALTER TABLE `umb_gaji_slipgaji_statutory_potongans`
MODIFY `slipgaji_potongan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_statutory_potongans`
--
ALTER TABLE `umb_gaji_statutory_potongans`
MODIFY `statutory_potongans_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_gaji_templates`
--
ALTER TABLE `umb_gaji_templates`
MODIFY `gaji_template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_security_level`
--
ALTER TABLE `umb_security_level`
MODIFY `type_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_sub_departments`
--
ALTER TABLE `umb_sub_departments`
MODIFY `sub_department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `umb_support_tickets`
--
ALTER TABLE `umb_support_tickets`
MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_support_tickets_karyawans`
--
ALTER TABLE `umb_support_tickets_karyawans`
MODIFY `tickets_karyawans_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_support_ticket_files`
--
ALTER TABLE `umb_support_ticket_files`
MODIFY `ticket_file_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_system_setting`
--
ALTER TABLE `umb_system_setting`
MODIFY `setting_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_tugass`
--
ALTER TABLE `umb_tugass`
MODIFY `tugas_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_tugass_attachment`
--
ALTER TABLE `umb_tugass_attachment`
MODIFY `attachment_tugas_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_tugass_comments`
--
ALTER TABLE `umb_tugass_comments`
MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_kategoris_tugas`
--
ALTER TABLE `umb_kategoris_tugas`
MODIFY `kategori_tugas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `umb_types_pajak`
--
ALTER TABLE `umb_types_pajak`
MODIFY `pajak_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `umb_type_penghentian`
--
ALTER TABLE `umb_type_penghentian`
MODIFY `type_penghentian_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_theme_settings`
--
ALTER TABLE `umb_theme_settings`
MODIFY `theme_settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `umb_tickets_attachment`
--
ALTER TABLE `umb_tickets_attachment`
MODIFY `ticket_attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_tickets_comments`
--
ALTER TABLE `umb_tickets_comments`
MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_trainers`
--
ALTER TABLE `umb_trainers`
MODIFY `trainer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_training`
--
ALTER TABLE `umb_training`
MODIFY `training_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `umb_types_training`
--
ALTER TABLE `umb_types_training`
MODIFY `type_training_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `umb_type_pengaturan_perjalanan`
--
ALTER TABLE `umb_type_pengaturan_perjalanan`
MODIFY `type_pengaturan_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `umb_users`
--
ALTER TABLE `umb_users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `umb_user_roles`
--
ALTER TABLE `umb_user_roles`
MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `umb_type_peringatan`
--
ALTER TABLE `umb_type_peringatan`
MODIFY `type_peringatan_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
