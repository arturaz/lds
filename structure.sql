-- phpMyAdmin SQL Dump
-- version 3.1.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 24, 2009 at 11:09 PM
-- Server version: 5.0.88
-- PHP Version: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `x11_lds`
--

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE IF NOT EXISTS `entries` (
  `access_id` varchar(255) collate utf8_lithuanian_ci NOT NULL,
  `client_id` varchar(20) collate utf8_lithuanian_ci NOT NULL,
  `key` varchar(255) collate utf8_lithuanian_ci NOT NULL,
  `value` varchar(255) collate utf8_lithuanian_ci NOT NULL,
  PRIMARY KEY  (`access_id`,`key`),
  KEY `sync` (`access_id`,`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

