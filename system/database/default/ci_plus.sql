-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2016 at 06:23 AM
-- Server version: 5.5.38
-- PHP Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ci_plus`
--

-- --------------------------------------------------------

--
-- Table structure for table `mst_akses`
--

CREATE TABLE `mst_akses` (
`mst_akses_id` int(11) NOT NULL,
  `mst_akses_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mst_biofisik`
--

CREATE TABLE `mst_biofisik` (
`mst_biofisik_id` int(11) NOT NULL,
  `mst_biofisik_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='misal : mangrove, terumbu karang, ikon, benthos' AUTO_INCREMENT=17 ;

--
-- Dumping data for table `mst_biofisik`
--

INSERT INTO `mst_biofisik` (`mst_biofisik_id`, `mst_biofisik_name`) VALUES
(1, 'Biofisik 1'),
(13, 'Biofisik 1'),
(14, 'Biofisik 2'),
(15, 'Biofisik 3'),
(16, 'Biofisik 4');

-- --------------------------------------------------------

--
-- Table structure for table `mst_desa`
--

CREATE TABLE `mst_desa` (
`mst_desa_id` int(11) NOT NULL,
  `mst_desa_name` varchar(255) DEFAULT NULL,
  `mst_kecamatan_id` int(11) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mst_desa`
--

INSERT INTO `mst_desa` (`mst_desa_id`, `mst_desa_name`, `mst_kecamatan_id`) VALUES
(1, 'Sukaresmi', 1),
(2, 'Semplak', 3);

-- --------------------------------------------------------

--
-- Table structure for table `mst_jenis_bantuan`
--

CREATE TABLE `mst_jenis_bantuan` (
`mst_jenis_bantuan_id` int(11) NOT NULL,
  `mst_jenis_bantuan_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mst_jenis_bantuan`
--

INSERT INTO `mst_jenis_bantuan` (`mst_jenis_bantuan_id`, `mst_jenis_bantuan_name`) VALUES
(3, 'Bantuan Pertama');

-- --------------------------------------------------------

--
-- Table structure for table `mst_jenis_biofisik`
--

CREATE TABLE `mst_jenis_biofisik` (
`mst_jenis_biofisik_id` int(11) NOT NULL,
  `mst_biofisik_id` int(11) DEFAULT NULL,
  `mst_biofisik_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mst_jenis_biofisik`
--

INSERT INTO `mst_jenis_biofisik` (`mst_jenis_biofisik_id`, `mst_biofisik_id`, `mst_biofisik_name`) VALUES
(1, 1, 'Jenis Biofisik 1');

-- --------------------------------------------------------

--
-- Table structure for table `mst_jenis_kapal`
--

CREATE TABLE `mst_jenis_kapal` (
`mst_jenis_kapal_id` int(11) NOT NULL,
  `mst_jenis_kapal_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mst_jenis_pelanggaran`
--

CREATE TABLE `mst_jenis_pelanggaran` (
`mst_jenis_pelanggaran_id` int(11) NOT NULL,
  `mst_jenis_pelanggaran_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mst_jenis_produk`
--

CREATE TABLE `mst_jenis_produk` (
`mst_jenis_produk_id` int(11) NOT NULL,
  `mst_jenis_produk_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mst_jenis_produk`
--

INSERT INTO `mst_jenis_produk` (`mst_jenis_produk_id`, `mst_jenis_produk_name`) VALUES
(1, 'Jenis Produk 1');

-- --------------------------------------------------------

--
-- Table structure for table `mst_kecamatan`
--

CREATE TABLE `mst_kecamatan` (
`mst_kecamatan_id` int(11) NOT NULL,
  `mst_kecamatan_name` varchar(255) DEFAULT NULL,
  `mst_kota_id` int(11) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mst_kecamatan`
--

INSERT INTO `mst_kecamatan` (`mst_kecamatan_id`, `mst_kecamatan_name`, `mst_kota_id`) VALUES
(1, 'Tanah Sareal', 1),
(3, 'Bogor Barat', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_ket_kondisi`
--

CREATE TABLE `mst_ket_kondisi` (
`mst_ket_kondisi_id` int(11) NOT NULL,
  `mst_ket_kondisi_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='misal : mangrove, terumbu karang, ikon, benthos' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mst_kondisi`
--

CREATE TABLE `mst_kondisi` (
`mst_kondisi_id` int(11) NOT NULL,
  `mst_kondisi_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mst_kota`
--

CREATE TABLE `mst_kota` (
`mst_kota_id` int(11) NOT NULL,
  `mst_kota_name` varchar(255) DEFAULT NULL,
  `mst_propisi_id` int(11) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mst_kota`
--

INSERT INTO `mst_kota` (`mst_kota_id`, `mst_kota_name`, `mst_propisi_id`) VALUES
(1, 'Bogor', 1),
(4, 'Bandung', 1),
(3, 'Jakarta', 3);

-- --------------------------------------------------------

--
-- Table structure for table `mst_propinsi`
--

CREATE TABLE `mst_propinsi` (
`mst_propinsi_id` int(11) NOT NULL,
  `mst_propinsi_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mst_propinsi`
--

INSERT INTO `mst_propinsi` (`mst_propinsi_id`, `mst_propinsi_name`) VALUES
(1, 'Jawa Barat'),
(3, 'DKI Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `mst_satker`
--

CREATE TABLE `mst_satker` (
`mst_satker_id` int(11) NOT NULL,
  `mst_satket_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mst_status_lahan`
--

CREATE TABLE `mst_status_lahan` (
`mst_status_lahan_id` int(11) NOT NULL,
  `mst_status_lahan_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='misal : mangrove, terumbu karang, ikon, benthos' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mst_sumber_verifikasi`
--

CREATE TABLE `mst_sumber_verifikasi` (
`mst_sumber_verifikasi_id` int(11) NOT NULL,
  `mst_sumber_verifikasi_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mst_sumber_verifikasi`
--

INSERT INTO `mst_sumber_verifikasi` (`mst_sumber_verifikasi_id`, `mst_sumber_verifikasi_name`) VALUES
(1, 'Verifikasi 1');

-- --------------------------------------------------------

--
-- Table structure for table `trs_beasiswa-form4`
--

CREATE TABLE `trs_beasiswa-form4` (
`trs_beasiswa_id` int(11) NOT NULL,
  `trs_beasiswa_akses` int(11) DEFAULT NULL,
  `trs_beasiswa_kota` int(11) DEFAULT NULL,
  `trs_beasiswa_tahun` int(11) DEFAULT NULL,
  `trs_beasiswa_mhs` varchar(255) DEFAULT NULL,
  `trs_beasiswa_asal_mhs` int(11) DEFAULT NULL,
  `trs_beasiswa_pt_id` int(11) DEFAULT NULL,
  `trs_beasiswa_tingkat` int(2) DEFAULT NULL,
  `trs_beasiswa_penelitian` varchar(255) DEFAULT NULL,
  `trs_beasiswa_lokasi_penelitian` varchar(255) DEFAULT NULL,
  `trs_beasiswa_penerima_laki` int(11) DEFAULT NULL,
  `trs_beasiswa_penerima_wanita` int(11) DEFAULT NULL,
  `trs_beasiswa_strart_date` date DEFAULT NULL,
  `trs_beasiswa_end_date` date DEFAULT NULL,
  `trs_beasiswa_masa` int(11) DEFAULT NULL,
  `trs_beasiswa_sumber_id` int(11) DEFAULT NULL,
  `trs_beasiswa_keterangan` varchar(255) DEFAULT NULL,
  `trs_beasiswa_created_by` int(11) DEFAULT NULL,
  `trs_beasiswa_created_date` date DEFAULT NULL,
  `trs_beasiswa_update_by` int(11) DEFAULT NULL,
  `trs_beasiswa_update_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `trs_biofisik_kawasan-form3-1`
--

CREATE TABLE `trs_biofisik_kawasan-form3-1` (
  `trs_biofisik_kawasan_id` int(11) NOT NULL DEFAULT '0',
  `trs_biofisik_kawasan_akses` int(11) DEFAULT NULL,
  `trs_biofisik_kawasan_satker_id` int(11) DEFAULT NULL,
  `trs_biofisik_kawasan_desa` int(11) DEFAULT NULL,
  `trs_biofisik_kawasan_biofisik_id` int(11) DEFAULT NULL,
  `trs_biofisik_kawasan_name` varchar(255) DEFAULT NULL,
  `trs_biofisik_kawasan_lat` float(11,0) DEFAULT NULL,
  `trs_biofisik_kawasan_long` float(11,0) DEFAULT NULL,
  `trs_biofisik_kawasan_luas` decimal(11,0) DEFAULT NULL,
  `trs_biofisik_kawasan_kondisi_id` int(11) DEFAULT NULL,
  `trs_biofisik_kawasan_tutupan` decimal(11,0) DEFAULT NULL,
  `trs_biofisik_kawasan_jenis_biofisik_id` int(11) DEFAULT NULL,
  `trs_biofisik_kawasan_jenis_biofisik_jumlah` decimal(11,0) DEFAULT NULL,
  `trs_biofisik_kawasan_pelaksanan` varchar(255) DEFAULT NULL,
  `trs_biofisik_kawasan_start_date` date DEFAULT NULL,
  `trs_biofisik_kawasan_end_date` date DEFAULT NULL,
  `trs_biofisik_kawasan_verfikasi_id` varchar(255) DEFAULT NULL,
  `trs_biofisik_kawasan_created_by` int(11) DEFAULT NULL,
  `trs_biofisik_kawasan_created_date` date DEFAULT NULL,
  `trs_biofisik_kawasan_update_by` int(11) DEFAULT NULL,
  `trs_biofisik_kawasan_update_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trs_data_desa-form10`
--

CREATE TABLE `trs_data_desa-form10` (
  `trs_data_desa_id` int(11) NOT NULL DEFAULT '0',
  `trs_data_desa_akses` int(11) DEFAULT NULL,
  `trs_data_desa_satker` int(11) DEFAULT NULL,
  `trs_data_desa_desa` int(11) DEFAULT NULL,
  `trs_data_desa_tahun_coremap` int(11) DEFAULT NULL,
  `trs_data_desa_luas` decimal(11,0) DEFAULT NULL,
  `trs_data_desa_type_hukum_adat` int(2) DEFAULT NULL,
  `trs_data_desa_hukum_adat_nama` varchar(255) DEFAULT NULL,
  `trs_data_desa_penduduk_laki` int(11) DEFAULT NULL,
  `trs_data_desa_penduduk_wanita` int(11) DEFAULT NULL,
  `trs_data_desa_jumlah_nelayan` int(11) DEFAULT NULL,
  `trs_data_desa_jumlah_non_nelayan` int(11) DEFAULT NULL,
  `trs_data_desa_sumber_id` int(2) DEFAULT NULL,
  `trs_data_desa_created_by` int(11) DEFAULT NULL,
  `trs_data_desa_created_date` date DEFAULT NULL,
  `trs_data_desa_update_by` int(11) DEFAULT NULL,
  `trs_data_desa_update_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trs_info_desa-form9`
--

CREATE TABLE `trs_info_desa-form9` (
  `trs_info_desa_id` int(11) NOT NULL DEFAULT '0',
  `trs_info_desa_akses` int(11) DEFAULT NULL,
  `trs_info_desa_satker` int(11) DEFAULT NULL,
  `trs_info_desa_desa` int(11) DEFAULT NULL,
  `trs_info_desa_luas` decimal(11,0) DEFAULT NULL,
  `trs_info_status_lahan_id` int(11) DEFAULT NULL,
  `trs_info_desa_fasilitas` varchar(255) DEFAULT NULL,
  `trs_info_desa_jenis_informasi` varchar(255) DEFAULT NULL,
  `trs_info_desa_kegiatan` varchar(255) DEFAULT NULL,
  `trs_info_desa_tgl_peresmian` date DEFAULT NULL,
  `trs_info_desa_sumber_id` int(11) DEFAULT NULL,
  `trs_info_desa_ket_kondisi_id` int(11) DEFAULT NULL,
  `trs_info_desa_created_by` int(11) DEFAULT NULL,
  `trs_info_desa_created_date` date DEFAULT NULL,
  `trs_info_desa_update_by` int(11) DEFAULT NULL,
  `trs_info_desa_update_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trs_kkpd-form7-A`
--

CREATE TABLE `trs_kkpd-form7-A` (
  `trs_kkpd_id` int(11) NOT NULL DEFAULT '0',
  `trs_kkpd_akses` int(11) DEFAULT NULL,
  `trs_kkpd_kota` int(11) DEFAULT NULL,
  `trs_kkpd_sk_walkot` varchar(255) DEFAULT NULL,
  `trs_kkpd_sk_mkp` varchar(255) DEFAULT NULL,
  `trs_kkpd_rencana_pengelolaan` int(2) DEFAULT NULL,
  `trs_kkpd_penataan_batas` int(2) DEFAULT NULL,
  `trs_kkpd_luas` decimal(11,0) DEFAULT NULL,
  `trs_kkpd_lamun` int(1) DEFAULT NULL,
  `trs_kkpd_lamun_luas` decimal(11,0) DEFAULT NULL,
  `trs_kkpd_mangrove` int(1) DEFAULT NULL,
  `trs_kkpd_mangrove_luas` decimal(11,0) DEFAULT NULL,
  `trs_kkpd_tk` int(1) DEFAULT NULL,
  `trs_kkpd_tk_luas` decimal(11,0) DEFAULT NULL,
  `trs_kkpd_keterangan` varchar(255) DEFAULT NULL,
  `trs_kkpd_created_by` int(11) DEFAULT NULL,
  `trs_kkpd_created_date` date DEFAULT NULL,
  `trs_kkpd_update_by` int(11) DEFAULT NULL,
  `trs_kkpd_update_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trs_kkpn-form7-B`
--

CREATE TABLE `trs_kkpn-form7-B` (
  `trs_kkpn_id` int(11) NOT NULL DEFAULT '0',
  `trs_kkpn_akses` int(11) DEFAULT NULL,
  `trs_kkpn_name` varchar(255) DEFAULT NULL,
  `trs_kkpn_sk_mkp` varchar(255) DEFAULT NULL,
  `trs_kkpn_rencana_pengelolaan` int(2) DEFAULT NULL,
  `trs_kkpn_penataan_batas` int(2) DEFAULT NULL,
  `trs_kkpn_luas_kkpd` decimal(11,0) DEFAULT NULL,
  `trs_kkpn_lamun` int(1) DEFAULT NULL,
  `trs_kkpn_lamun_luas` decimal(11,0) DEFAULT NULL,
  `trs_kkpn_mangrove` int(1) DEFAULT NULL,
  `trs_kkpn_mangrove_luas` decimal(11,0) DEFAULT NULL,
  `trs_kkpn_tk` int(1) DEFAULT NULL,
  `trs_kkpn_tk_luas` decimal(11,0) DEFAULT NULL,
  `trs_kkpn_keterangan` varchar(255) DEFAULT NULL,
  `trs_kkpn_created_by` int(11) DEFAULT NULL,
  `trs_kkpn_created_date` date DEFAULT NULL,
  `trs_kkpn_update_by` int(11) DEFAULT NULL,
  `trs_kkpn_update_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trs_lpstk-form6`
--

CREATE TABLE `trs_lpstk-form6` (
  `trs_lpstk_id` int(11) NOT NULL DEFAULT '0',
  `trs_lpstk_akses` int(11) DEFAULT NULL,
  `trs_lpstk_satker_id` int(11) DEFAULT NULL,
  `trs_lpstk_name` varchar(255) DEFAULT NULL,
  `trs_lpstk_desa` int(11) DEFAULT NULL,
  `trs_lpstk_tgl` date DEFAULT NULL,
  `trs_lpstk_kegiatan` varchar(255) DEFAULT NULL,
  `trs_lpstk_ketua` varchar(255) DEFAULT NULL,
  `trs_lpstk_pria` int(11) DEFAULT NULL,
  `trs_lpstk_wanita` int(11) DEFAULT NULL,
  `trs_lpstk_sumber_id` int(11) DEFAULT NULL,
  `trs_lpstk_created_by` int(11) DEFAULT NULL,
  `trs_lpstk_created_date` date DEFAULT NULL,
  `trs_lpstk_update_by` int(11) DEFAULT NULL,
  `trs_lpstk_update_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trs_patroli-form8`
--

CREATE TABLE `trs_patroli-form8` (
  `trs_potroli_id` int(11) NOT NULL DEFAULT '0',
  `trs_potroli_akses` int(11) DEFAULT NULL,
  `trs_potroli_satker` int(11) DEFAULT NULL,
  `trs_potroli_start_date` date DEFAULT NULL,
  `trs_potroli_end_date` date DEFAULT NULL,
  `trs_potroli_lokasi` varchar(255) DEFAULT NULL,
  `trs_potroli_jml_anggota` int(11) DEFAULT NULL,
  `trs_potroli_start_time` time DEFAULT NULL,
  `trs_potroli_end_time` time DEFAULT NULL,
  `trs_potroli_jenis_kapal_id` int(2) DEFAULT NULL,
  `trs_potroli_pemilik_kapal` varchar(255) DEFAULT NULL,
  `trs_potroli_jml_pelanggaran` int(11) DEFAULT NULL,
  `trs_potroli_jenis_pelanggaran_id` int(11) DEFAULT NULL,
  `trs_potroli_sumber_id` int(2) DEFAULT NULL,
  `trs_potrol_created_by` int(11) DEFAULT NULL,
  `trs_potrol_created_date` date DEFAULT NULL,
  `trs_potrol_update_by` int(11) DEFAULT NULL,
  `trs_potrol_update_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trs_pelatihan_sdm-form2`
--

CREATE TABLE `trs_pelatihan_sdm-form2` (
`trs_pelatihan_sdm_id` int(11) NOT NULL,
  `trs_pelatihan_sdm_akses` int(11) DEFAULT NULL,
  `trs_pelatihan_sdm_kota` int(11) DEFAULT NULL,
  `trs_pelatihan_sdm_nama_pelatihan` varchar(255) DEFAULT NULL,
  `trs_pelatihan_sdm_tujuan` varchar(255) DEFAULT NULL,
  `trs_pelatihan_sdm_output` varchar(255) DEFAULT NULL,
  `trs_pelatihan_sdm_outcome` varchar(255) DEFAULT NULL,
  `trs_pelatihan_sdm_lokasi` varchar(255) DEFAULT NULL,
  `trs_pelatihan_sdm_pelaksana` varchar(255) DEFAULT NULL,
  `trs_pelatihan_sdm_tgl` date DEFAULT NULL,
  `trs_pelatihan_sdm_peserta_l` int(11) DEFAULT NULL,
  `trs_pelatihan_sdm_peserta_w` int(11) DEFAULT NULL,
  `trs_pelatihan_sdm_created_by` int(11) DEFAULT NULL,
  `trs_pelatihan_sdm_created_date` date DEFAULT NULL,
  `trs_pelatihan_sdm_update_by` int(11) DEFAULT NULL,
  `trs_pelatihan_sdm_update_date` date DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `trs_pelatihan_sdm-form2`
--

INSERT INTO `trs_pelatihan_sdm-form2` (`trs_pelatihan_sdm_id`, `trs_pelatihan_sdm_akses`, `trs_pelatihan_sdm_kota`, `trs_pelatihan_sdm_nama_pelatihan`, `trs_pelatihan_sdm_tujuan`, `trs_pelatihan_sdm_output`, `trs_pelatihan_sdm_outcome`, `trs_pelatihan_sdm_lokasi`, `trs_pelatihan_sdm_pelaksana`, `trs_pelatihan_sdm_tgl`, `trs_pelatihan_sdm_peserta_l`, `trs_pelatihan_sdm_peserta_w`, `trs_pelatihan_sdm_created_by`, `trs_pelatihan_sdm_created_date`, `trs_pelatihan_sdm_update_by`, `trs_pelatihan_sdm_update_date`) VALUES
(1, NULL, NULL, 'Nama Pelatihnya', 'Tujuan Pelatihan', 'Output Pelatihan', 'Outcome pelatihan', '', 'Pelaksana Pelatihan', '2016-09-30', 4000, 2300, 0, '2016-09-05', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trs_pencetakan-form1`
--

CREATE TABLE `trs_pencetakan-form1` (
`trs_pencetakan_id` int(11) NOT NULL,
  `trs_pencetakan_akses` int(11) DEFAULT NULL,
  `trs_pencetakan_kota` int(11) DEFAULT NULL,
  `trs_pencetakan_jenis_produk_id` varchar(255) DEFAULT NULL,
  `trs_pencetakan_tujuan` varchar(255) DEFAULT NULL,
  `trs_pencetakan_sasaran` varchar(255) DEFAULT NULL,
  `trs_pencetakan_penyusun` varchar(255) DEFAULT NULL,
  `trs_pencetakan_tgl_produksi` date DEFAULT NULL,
  `trs_pencetakan_jumlah_produksi` int(11) DEFAULT NULL,
  `trs_pencetakan_tgl_distribusi` date DEFAULT NULL,
  `trs_pencetakan_jumlah_terdistribusi` int(11) DEFAULT NULL,
  `trs_pencetakan_penerima` varchar(255) DEFAULT NULL,
  `trs_pencetakan_sumber_verifikasi_id` int(11) DEFAULT NULL,
  `trs_pencetakan_created_by` int(11) DEFAULT NULL,
  `trs_pencetakan_created_date` date DEFAULT NULL,
  `trs_pencetakan_update_by` int(11) DEFAULT NULL,
  `trs_pencetakan_update_date` date DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `trs_pencetakan-form1`
--

INSERT INTO `trs_pencetakan-form1` (`trs_pencetakan_id`, `trs_pencetakan_akses`, `trs_pencetakan_kota`, `trs_pencetakan_jenis_produk_id`, `trs_pencetakan_tujuan`, `trs_pencetakan_sasaran`, `trs_pencetakan_penyusun`, `trs_pencetakan_tgl_produksi`, `trs_pencetakan_jumlah_produksi`, `trs_pencetakan_tgl_distribusi`, `trs_pencetakan_jumlah_terdistribusi`, `trs_pencetakan_penerima`, `trs_pencetakan_sumber_verifikasi_id`, `trs_pencetakan_created_by`, `trs_pencetakan_created_date`, `trs_pencetakan_update_by`, `trs_pencetakan_update_date`) VALUES
(1, NULL, NULL, '1', 'Lokasi Tujuan', 'Sasaran Kegiatan', 'Tim Penyusun', '1970-01-01', 1000, '1970-01-01', 800, 'Penerima', 1, 0, '2016-09-05', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trs_penerima_bantuan-form3-3`
--

CREATE TABLE `trs_penerima_bantuan-form3-3` (
  `trs_penerima_bantuan_id` int(11) NOT NULL DEFAULT '0',
  `trs_penerima_bantuan_akses` int(11) DEFAULT NULL,
  `trs_penerima_bantuan_satker_id` int(11) DEFAULT NULL,
  `trs_penerima_bantuan_kota` int(11) DEFAULT NULL,
  `trs_penerima_bantuan_desa` int(11) DEFAULT NULL,
  `trs_penerima_bantuan_laki` int(11) DEFAULT NULL,
  `trs_penerima_bantuan_wanita` int(11) DEFAULT NULL,
  `trs_penerima_bantuan_jenis_bantuan_id` int(11) DEFAULT NULL,
  `trs_penerima_bantuan_manfaat` float(11,0) DEFAULT NULL,
  `trs_penerima_bantuan_tahun` int(5) DEFAULT NULL,
  `trs_penerima_bantuan_metode` varchar(255) DEFAULT NULL,
  `trs_penerima_bantuan_created_by` int(11) DEFAULT NULL,
  `trs_penerima_bantuan_created_date` date DEFAULT NULL,
  `trs_penerima_bantuan_update_by` int(11) DEFAULT NULL,
  `trs_penerima_bantuan_update_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trs_rpsp-form5`
--

CREATE TABLE `trs_rpsp-form5` (
  `trs_rpsp_id` int(11) NOT NULL DEFAULT '0',
  `trs_rpsp_akses` int(11) DEFAULT NULL,
  `trs_rpsp_satker_id` int(11) DEFAULT NULL,
  `trs_rpsp_name` varchar(255) DEFAULT NULL,
  `trs_rpsp_desa` int(11) DEFAULT NULL,
  `trs_rpsp_no_sk` varchar(255) DEFAULT NULL,
  `trs_rpsp_tgl_penetapan` date DEFAULT NULL,
  `trs_rpsp_musrenbang` varchar(255) DEFAULT NULL,
  `trs_rpsp_usulan` varchar(255) DEFAULT NULL,
  `trs_rpsp_zonasi` varchar(255) DEFAULT NULL,
  `trs_rpsp_sumber_id` int(11) DEFAULT NULL,
  `trs_rpsp_created_by` int(11) DEFAULT NULL,
  `trs_rpsp_created_date` date DEFAULT NULL,
  `trs_rpsp_update_by` int(11) DEFAULT NULL,
  `trs_rpsp_update_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trs_sosek_kawasan-form3-2`
--

CREATE TABLE `trs_sosek_kawasan-form3-2` (
  `trs_sosek_kawasan_id` int(11) NOT NULL DEFAULT '0',
  `trs_sosek_kawasan_akses` int(11) DEFAULT NULL,
  `trs_sosek_kawasan_satker_id` int(11) DEFAULT NULL,
  `trs_sosek_kawasan_kota` int(11) DEFAULT NULL,
  `trs_sosek_kawasan_desa` int(11) DEFAULT NULL,
  `trs_sosek_kawasan_pendapatan_perkapita` float(11,0) DEFAULT NULL,
  `trs_sosek_kawasan_pengeluaran_perkapita` float(11,0) DEFAULT NULL,
  `trs_sosek_kawasan_inflasi` float(11,0) DEFAULT NULL,
  `trs_sosek_kawasan_peningkatan_perkapita` float(11,0) DEFAULT NULL,
  `trs_sosek_kawasan_tahun` int(5) DEFAULT NULL,
  `trs_sosek_kawasan_jenis_bantuan_id` int(11) DEFAULT NULL,
  `trs_sosek_kawasan_metode` varchar(255) DEFAULT NULL,
  `trs_sosek_kawasan_created_by` int(11) DEFAULT NULL,
  `trs_sosek_kawasan_created_date` date DEFAULT NULL,
  `trs_sosek_kawasan_update_by` int(11) DEFAULT NULL,
  `trs_sosek_kawasan_update_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_akses`
--
ALTER TABLE `mst_akses`
 ADD PRIMARY KEY (`mst_akses_id`);

--
-- Indexes for table `mst_biofisik`
--
ALTER TABLE `mst_biofisik`
 ADD PRIMARY KEY (`mst_biofisik_id`);

--
-- Indexes for table `mst_desa`
--
ALTER TABLE `mst_desa`
 ADD PRIMARY KEY (`mst_desa_id`), ADD KEY `fk_mst_desa_mst_kecamatan_1` (`mst_kecamatan_id`);

--
-- Indexes for table `mst_jenis_bantuan`
--
ALTER TABLE `mst_jenis_bantuan`
 ADD PRIMARY KEY (`mst_jenis_bantuan_id`);

--
-- Indexes for table `mst_jenis_biofisik`
--
ALTER TABLE `mst_jenis_biofisik`
 ADD PRIMARY KEY (`mst_jenis_biofisik_id`);

--
-- Indexes for table `mst_jenis_kapal`
--
ALTER TABLE `mst_jenis_kapal`
 ADD PRIMARY KEY (`mst_jenis_kapal_id`);

--
-- Indexes for table `mst_jenis_pelanggaran`
--
ALTER TABLE `mst_jenis_pelanggaran`
 ADD PRIMARY KEY (`mst_jenis_pelanggaran_id`);

--
-- Indexes for table `mst_jenis_produk`
--
ALTER TABLE `mst_jenis_produk`
 ADD PRIMARY KEY (`mst_jenis_produk_id`);

--
-- Indexes for table `mst_kecamatan`
--
ALTER TABLE `mst_kecamatan`
 ADD PRIMARY KEY (`mst_kecamatan_id`), ADD KEY `fk_mst_kecamatan_mst_kota_1` (`mst_kota_id`);

--
-- Indexes for table `mst_ket_kondisi`
--
ALTER TABLE `mst_ket_kondisi`
 ADD PRIMARY KEY (`mst_ket_kondisi_id`);

--
-- Indexes for table `mst_kondisi`
--
ALTER TABLE `mst_kondisi`
 ADD PRIMARY KEY (`mst_kondisi_id`);

--
-- Indexes for table `mst_kota`
--
ALTER TABLE `mst_kota`
 ADD PRIMARY KEY (`mst_kota_id`), ADD KEY `fk_mst_kota_mst_propinsi_1` (`mst_propisi_id`);

--
-- Indexes for table `mst_propinsi`
--
ALTER TABLE `mst_propinsi`
 ADD PRIMARY KEY (`mst_propinsi_id`);

--
-- Indexes for table `mst_satker`
--
ALTER TABLE `mst_satker`
 ADD PRIMARY KEY (`mst_satker_id`);

--
-- Indexes for table `mst_status_lahan`
--
ALTER TABLE `mst_status_lahan`
 ADD PRIMARY KEY (`mst_status_lahan_id`);

--
-- Indexes for table `mst_sumber_verifikasi`
--
ALTER TABLE `mst_sumber_verifikasi`
 ADD PRIMARY KEY (`mst_sumber_verifikasi_id`);

--
-- Indexes for table `trs_beasiswa-form4`
--
ALTER TABLE `trs_beasiswa-form4`
 ADD PRIMARY KEY (`trs_beasiswa_id`);

--
-- Indexes for table `trs_biofisik_kawasan-form3-1`
--
ALTER TABLE `trs_biofisik_kawasan-form3-1`
 ADD PRIMARY KEY (`trs_biofisik_kawasan_id`);

--
-- Indexes for table `trs_data_desa-form10`
--
ALTER TABLE `trs_data_desa-form10`
 ADD PRIMARY KEY (`trs_data_desa_id`);

--
-- Indexes for table `trs_info_desa-form9`
--
ALTER TABLE `trs_info_desa-form9`
 ADD PRIMARY KEY (`trs_info_desa_id`);

--
-- Indexes for table `trs_kkpd-form7-A`
--
ALTER TABLE `trs_kkpd-form7-A`
 ADD PRIMARY KEY (`trs_kkpd_id`);

--
-- Indexes for table `trs_kkpn-form7-B`
--
ALTER TABLE `trs_kkpn-form7-B`
 ADD PRIMARY KEY (`trs_kkpn_id`);

--
-- Indexes for table `trs_lpstk-form6`
--
ALTER TABLE `trs_lpstk-form6`
 ADD PRIMARY KEY (`trs_lpstk_id`);

--
-- Indexes for table `trs_patroli-form8`
--
ALTER TABLE `trs_patroli-form8`
 ADD PRIMARY KEY (`trs_potroli_id`);

--
-- Indexes for table `trs_pelatihan_sdm-form2`
--
ALTER TABLE `trs_pelatihan_sdm-form2`
 ADD PRIMARY KEY (`trs_pelatihan_sdm_id`);

--
-- Indexes for table `trs_pencetakan-form1`
--
ALTER TABLE `trs_pencetakan-form1`
 ADD PRIMARY KEY (`trs_pencetakan_id`);

--
-- Indexes for table `trs_penerima_bantuan-form3-3`
--
ALTER TABLE `trs_penerima_bantuan-form3-3`
 ADD PRIMARY KEY (`trs_penerima_bantuan_id`);

--
-- Indexes for table `trs_rpsp-form5`
--
ALTER TABLE `trs_rpsp-form5`
 ADD PRIMARY KEY (`trs_rpsp_id`);

--
-- Indexes for table `trs_sosek_kawasan-form3-2`
--
ALTER TABLE `trs_sosek_kawasan-form3-2`
 ADD PRIMARY KEY (`trs_sosek_kawasan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_akses`
--
ALTER TABLE `mst_akses`
MODIFY `mst_akses_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_biofisik`
--
ALTER TABLE `mst_biofisik`
MODIFY `mst_biofisik_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `mst_desa`
--
ALTER TABLE `mst_desa`
MODIFY `mst_desa_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mst_jenis_bantuan`
--
ALTER TABLE `mst_jenis_bantuan`
MODIFY `mst_jenis_bantuan_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mst_jenis_biofisik`
--
ALTER TABLE `mst_jenis_biofisik`
MODIFY `mst_jenis_biofisik_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mst_jenis_kapal`
--
ALTER TABLE `mst_jenis_kapal`
MODIFY `mst_jenis_kapal_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_jenis_pelanggaran`
--
ALTER TABLE `mst_jenis_pelanggaran`
MODIFY `mst_jenis_pelanggaran_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_jenis_produk`
--
ALTER TABLE `mst_jenis_produk`
MODIFY `mst_jenis_produk_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mst_kecamatan`
--
ALTER TABLE `mst_kecamatan`
MODIFY `mst_kecamatan_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mst_ket_kondisi`
--
ALTER TABLE `mst_ket_kondisi`
MODIFY `mst_ket_kondisi_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_kondisi`
--
ALTER TABLE `mst_kondisi`
MODIFY `mst_kondisi_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_kota`
--
ALTER TABLE `mst_kota`
MODIFY `mst_kota_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mst_propinsi`
--
ALTER TABLE `mst_propinsi`
MODIFY `mst_propinsi_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mst_satker`
--
ALTER TABLE `mst_satker`
MODIFY `mst_satker_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_status_lahan`
--
ALTER TABLE `mst_status_lahan`
MODIFY `mst_status_lahan_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_sumber_verifikasi`
--
ALTER TABLE `mst_sumber_verifikasi`
MODIFY `mst_sumber_verifikasi_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `trs_beasiswa-form4`
--
ALTER TABLE `trs_beasiswa-form4`
MODIFY `trs_beasiswa_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trs_pelatihan_sdm-form2`
--
ALTER TABLE `trs_pelatihan_sdm-form2`
MODIFY `trs_pelatihan_sdm_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `trs_pencetakan-form1`
--
ALTER TABLE `trs_pencetakan-form1`
MODIFY `trs_pencetakan_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
