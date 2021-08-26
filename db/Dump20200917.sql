CREATE DATABASE  IF NOT EXISTS `feriame` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `feriame`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: feriame
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `currencies_name_text_index` (`name`,`text`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1,'ars','Peso Argentino','2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'usd','Dolar Estadounidense','2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_interests`
--

DROP TABLE IF EXISTS `customer_interests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_interests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `product_types_id` bigint(20) unsigned NOT NULL,
  `customers_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_interests_customers_id_foreign` (`customers_id`),
  KEY `customer_interests_product_types_id_customers_id_index` (`product_types_id`,`customers_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_interests`
--

LOCK TABLES `customer_interests` WRITE;
/*!40000 ALTER TABLE `customer_interests` DISABLE KEYS */;
INSERT INTO `customer_interests` VALUES (1,1,1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,1,2,2,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `customer_interests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `area_code` bigint(20) unsigned NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('masculino','femenino') COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` bigint(20) NOT NULL,
  `longitude` bigint(20) NOT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` int(10) unsigned NOT NULL,
  `department_number` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `users_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_users_id_foreign` (`users_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Paul','Phoenix',1234,'+1310196837945','pphoenix@tk.com','masculino',-74,-80,'Senegal','Texas','Vicente Lopez','Lurline Point',12,'12B',1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'Jin','Kazama',4321,'+8883798031104','jkazama@tk.com','masculino',67,-100,'Poland','Utah','Capital Federal','Nyasia Mountains',21,'21B',1,2,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deliveries`
--

DROP TABLE IF EXISTS `deliveries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deliveries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('','aceptado','entregado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `purchases_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deliveries_purchases_id_foreign` (`purchases_id`),
  KEY `deliveries_status_purchases_id_index` (`status`,`purchases_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deliveries`
--

LOCK TABLES `deliveries` WRITE;
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;
INSERT INTO `deliveries` VALUES (1,'',1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'',1,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `deliveries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_schedulers`
--

DROP TABLE IF EXISTS `delivery_schedulers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_schedulers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `purchases_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `delivery_schedulers_purchases_id_foreign` (`purchases_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_schedulers`
--

LOCK TABLES `delivery_schedulers` WRITE;
/*!40000 ALTER TABLE `delivery_schedulers` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery_schedulers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'es',
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `languages_lang_index` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'es','Español','2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'es','Ingles','2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2013_08_12_003001_create_languages_table',1),(2,'2014_10_12_000000_create_users_table',1),(3,'2014_10_12_100000_create_password_resets_table',1),(4,'2016_06_01_000001_create_oauth_auth_codes_table',1),(5,'2016_06_01_000002_create_oauth_access_tokens_table',1),(6,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(7,'2016_06_01_000004_create_oauth_clients_table',1),(8,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(9,'2019_08_19_000000_create_failed_jobs_table',1),(10,'2020_08_12_003001_create_provider_types_table',1),(11,'2020_08_12_003002_create_providers_table',1),(12,'2020_08_12_003003_create_provider_media_table',1),(13,'2020_08_12_003004_create_product_types_table',1),(14,'2020_08_12_003005_create_currencies_table',1),(15,'2020_08_12_003006_create_units_table',1),(16,'2020_08_12_003155_create_subproduct_types_table',1),(17,'2020_08_12_003156_create_subproduct_typifications_table',1),(18,'2020_08_12_004721_create_customers_table',1),(19,'2020_08_12_005747_create_order_headers_table',1),(20,'2020_08_12_010113_create_products_table',1),(21,'2020_08_12_010914_create_order_position_table',1),(22,'2020_08_12_012214_create_order_trackings_table',1),(23,'2020_08_12_014957_create_product_media_table',1),(24,'2020_08_12_022530_create_provider_contacts_table',1),(25,'2020_08_13_031025_create_product_delivery_types_table',1),(26,'2020_08_24_133855_create_product_favorites_table',1),(27,'2020_08_25_131830_create_provider_taxes_table',1),(28,'2020_08_27_044924_create_provider_deliveries_table',1),(29,'2020_09_01_061436_create_provider_statuses_table',1),(30,'2020_09_03_144038_create_customer_interests_table',1),(31,'2020_09_10_031757_create_purchases_table',1),(32,'2020_09_10_035608_create_deliveries_table',1),(33,'2020_09_10_041324_create_delivery_schedulers_table',1),(34,'2020_09_10_051031_create_qualification_providers_table',1),(35,'2020_09_10_052413_create_qualification_products_table',1),(36,'2020_09_10_052901_create_qualification_deliveries_table',1),(37,'2020_09_12_223714_create_shopcart_headers_table',1),(38,'2020_09_12_223715_create_shopcart_positions_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_headers`
--

DROP TABLE IF EXISTS `order_headers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_headers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` double(8,2) NOT NULL,
  `taxes` double(8,2) NOT NULL,
  `total_tax` double(8,2) NOT NULL,
  `customers_id` bigint(20) unsigned NOT NULL,
  `providers_id` bigint(20) unsigned NOT NULL,
  `currencies_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_headers_customers_id_foreign` (`customers_id`),
  KEY `order_headers_providers_id_foreign` (`providers_id`),
  KEY `order_headers_currencies_id_foreign` (`currencies_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_headers`
--

LOCK TABLES `order_headers` WRITE;
/*!40000 ALTER TABLE `order_headers` DISABLE KEYS */;
INSERT INTO `order_headers` VALUES (1,'pagado',30.11,10.10,40.21,1,1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'pagado',50.11,10.10,60.21,1,1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `order_headers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_positions`
--

DROP TABLE IF EXISTS `order_positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_positions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `quantity` bigint(20) unsigned NOT NULL,
  `price` double(8,2) NOT NULL,
  `orders_id` bigint(20) unsigned NOT NULL,
  `products_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_positions_orders_id_foreign` (`orders_id`),
  KEY `order_positions_products_id_foreign` (`products_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_positions`
--

LOCK TABLES `order_positions` WRITE;
/*!40000 ALTER TABLE `order_positions` DISABLE KEYS */;
INSERT INTO `order_positions` VALUES (1,10,30.11,1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,12,30.11,1,2,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `order_positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_trackings`
--

DROP TABLE IF EXISTS `order_trackings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_trackings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orders_id` bigint(20) unsigned NOT NULL,
  `products_id` bigint(20) unsigned NOT NULL,
  `tracking_date` date NOT NULL,
  `new` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_trackings_orders_id_foreign` (`orders_id`),
  KEY `order_trackings_products_id_foreign` (`products_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_trackings`
--

LOCK TABLES `order_trackings` WRITE;
/*!40000 ALTER TABLE `order_trackings` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_trackings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`(250))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_delivery_types`
--

DROP TABLE IF EXISTS `product_delivery_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_delivery_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `languages_lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `products_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_delivery_types_languages_lang_foreign` (`languages_lang`),
  KEY `product_delivery_types_products_id_foreign` (`products_id`),
  KEY `product_delivery_types_text_languages_lang_products_id_index` (`text`,`languages_lang`,`products_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_delivery_types`
--

LOCK TABLES `product_delivery_types` WRITE;
/*!40000 ALTER TABLE `product_delivery_types` DISABLE KEYS */;
INSERT INTO `product_delivery_types` VALUES (1,'domicilio',1,'es',1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'domicilio',1,'es',2,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(3,'nodo',1,'es',2,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(4,'string',1,'es',3,'2020-09-16 01:26:55','2020-09-16 01:26:55'),(5,'domicilio',0,'es',4,'2020-09-16 01:33:49','2020-09-16 01:33:49');
/*!40000 ALTER TABLE `product_delivery_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_favorites`
--

DROP TABLE IF EXISTS `product_favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_favorites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `products_id` bigint(20) unsigned NOT NULL,
  `users_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_favorites_users_id_foreign` (`users_id`),
  KEY `product_favorites_products_id_users_id_index` (`products_id`,`users_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_favorites`
--

LOCK TABLES `product_favorites` WRITE;
/*!40000 ALTER TABLE `product_favorites` DISABLE KEYS */;
INSERT INTO `product_favorites` VALUES (1,1,1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,1,2,1,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `product_favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_media`
--

DROP TABLE IF EXISTS `product_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('image','video') COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `products_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_media_link_type_products_id_index` (`link`,`type`,`products_id`),
  KEY `fk_mediaproduct` (`products_id`),
  CONSTRAINT `fk_mediaproduct` FOREIGN KEY (`products_id`) REFERENCES `product_media` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_media`
--

LOCK TABLES `product_media` WRITE;
/*!40000 ALTER TABLE `product_media` DISABLE KEYS */;
INSERT INTO `product_media` VALUES (1,'www.youtube.com/test','video',1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'www.youtube.com/test-1','video',1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(3,'www.youtube.com/test-2','video',1,2,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `product_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_types`
--

DROP TABLE IF EXISTS `product_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL,
  `languages_lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_types_languages_lang_foreign` (`languages_lang`),
  KEY `product_types_name_alias_languages_lang_index` (`name`,`alias`,`languages_lang`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_types`
--

LOCK TABLES `product_types` WRITE;
/*!40000 ALTER TABLE `product_types` DISABLE KEYS */;
INSERT INTO `product_types` VALUES (1,'alacena','alacena',1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'Bebidas alcohólica','Bebidas alcohólica',1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(3,'Bebidas no alcohólica','Bebidas no alcohólica',1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(4,'lácteos','lácteos',1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(5,'huerta','huerta',1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(6,'hogar','hogar',1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(7,'alimentos frescos','alimentos frescos',1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(8,'string','string',1,'es','2020-09-16 01:26:55','2020-09-16 01:26:55'),(9,'alacena','alacena',1,'es','2020-09-16 01:33:49','2020-09-16 01:33:49');
/*!40000 ALTER TABLE `product_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `presentation` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `volumes_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume_value` double(8,2) NOT NULL,
  `weights_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight_value` double(8,2) NOT NULL,
  `requires_cold` tinyint(1) NOT NULL,
  `clasification` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` bigint(20) unsigned NOT NULL,
  `price` double(8,2) NOT NULL,
  `reposition_point` bigint(20) NOT NULL,
  `favorite` tinyint(1) NOT NULL DEFAULT 0,
  `delivery_time` bigint(20) unsigned NOT NULL DEFAULT 0,
  `expires` bigint(20) unsigned NOT NULL,
  `expires_time` bigint(20) unsigned NOT NULL,
  `status` enum('pendiente','habilitado','rechazado','eliminado') COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `product_types_id` bigint(20) unsigned NOT NULL,
  `subproduct_types_id` bigint(20) unsigned NOT NULL,
  `subproduct_typifications_id` bigint(20) unsigned NOT NULL,
  `providers_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_weights_name_foreign` (`weights_name`),
  KEY `products_volumes_name_foreign` (`volumes_name`),
  KEY `fk_producttype` (`product_types_id`),
  KEY `fk_product_subproducttype` (`subproduct_types_id`),
  KEY `fk_tipifications` (`subproduct_typifications_id`),
  KEY `fk_provider` (`providers_id`),
  CONSTRAINT `fk_product_subproducttype` FOREIGN KEY (`subproduct_types_id`) REFERENCES `subproduct_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producttype` FOREIGN KEY (`product_types_id`) REFERENCES `product_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_provider` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipifications` FOREIGN KEY (`subproduct_typifications_id`) REFERENCES `subproduct_typifications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'BBad','Braking Bad','Kilometro cubico',1000.00,'Kilogramo',0.00,0,0.00,4,244.03,4,1,0,1,3,'pendiente',1,1,1,1,2,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'BBad2','Braking Bad 2','Kilometro cubico',1000.00,'Kilogramo',0.00,0,0.00,3,166.54,9,1,0,0,4,'habilitado',1,1,1,1,2,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(3,'string','string','string',0.00,'Kilogramo',0.00,1,0.00,2,0.00,0,0,0,1,0,'habilitado',1,8,9,20,2,'2020-09-16 01:26:55','2020-09-16 01:26:55'),(4,'BBad','Braking Bad','Kilometro cubico',1000.00,'Kilogramo',0.00,0,0.00,1,244.60,4,0,0,1,3,'habilitado',1,9,10,21,2,'2020-09-16 01:33:49','2020-09-16 01:33:49');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_contacts`
--

DROP TABLE IF EXISTS `provider_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `dni` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday_date` date NOT NULL,
  `responsable` tinyint(1) NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `providers_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provider_contacts_dni_providers_id_index` (`dni`,`providers_id`),
  KEY `fk_providercontact` (`providers_id`),
  CONSTRAINT `fk_providercontact` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_contacts`
--

LOCK TABLES `provider_contacts` WRITE;
/*!40000 ALTER TABLE `provider_contacts` DISABLE KEYS */;
INSERT INTO `provider_contacts` VALUES (1,'Skyler','White','30000111','1990-01-01',1,'rwhite@bb.com','1173625984',1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'Robert','White','20200300','1990-12-12',1,'rwhite@bb.com','1173625567',1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(3,'Andrea','Cantilo','20008881','1990-01-01',1,'acantilo@bb.com','1173625984',1,2,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(4,'Bruce','Pinkman','20200700','1990-12-12',1,'bpinkman@bb.com','1173625567',1,2,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `provider_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_deliveries`
--

DROP TABLE IF EXISTS `provider_deliveries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_deliveries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `day` enum('Lun','Mar','Mie','Jue','Vie','Sab','Dom') COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `active` tinyint(1) NOT NULL,
  `providers_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provider_deliveries_day_providers_id_index` (`day`,`providers_id`),
  KEY `fk_provider_delivery` (`providers_id`),
  CONSTRAINT `fk_provider_delivery` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_deliveries`
--

LOCK TABLES `provider_deliveries` WRITE;
/*!40000 ALTER TABLE `provider_deliveries` DISABLE KEYS */;
INSERT INTO `provider_deliveries` VALUES (1,'Lun','08:00:00','18:00:00',1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'Mar','08:00:00','18:00:00',1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(3,'Mie','08:00:00','18:00:00',1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `provider_deliveries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_media`
--

DROP TABLE IF EXISTS `provider_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('image','video') COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `providers_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provider_media_providers_id_type_link_index` (`providers_id`,`type`,`link`),
  CONSTRAINT `fk_providermedia` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_media`
--

LOCK TABLES `provider_media` WRITE;
/*!40000 ALTER TABLE `provider_media` DISABLE KEYS */;
INSERT INTO `provider_media` VALUES (1,'www.youtube.com/test-0','video',1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'www.youtube.com/test-1','video',1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(3,'www.youtube.com/test-2','video',1,2,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `provider_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_statuses`
--

DROP TABLE IF EXISTS `provider_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('pendiente','habilitado','rechazado','eliminado') COLLATE utf8mb4_unicode_ci NOT NULL,
  `providers_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provider_statuses_status_providers_id_index` (`status`,`providers_id`),
  KEY `fk_providerstatus` (`providers_id`),
  CONSTRAINT `fk_providerstatus` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_statuses`
--

LOCK TABLES `provider_statuses` WRITE;
/*!40000 ALTER TABLE `provider_statuses` DISABLE KEYS */;
INSERT INTO `provider_statuses` VALUES (1,'habilitado',1,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `provider_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_taxes`
--

DROP TABLE IF EXISTS `provider_taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_taxes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cuit` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualification` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `qualification_notes` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL,
  `providers_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provider_taxes_cuit_number_qualification_providers_id_index` (`cuit`,`number`,`qualification`,`providers_id`),
  KEY `fk_providertaxes` (`providers_id`),
  CONSTRAINT `fk_providertaxes` FOREIGN KEY (`providers_id`) REFERENCES `provider_taxes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_taxes`
--

LOCK TABLES `provider_taxes` WRITE;
/*!40000 ALTER TABLE `provider_taxes` DISABLE KEYS */;
INSERT INTO `provider_taxes` VALUES (1,'2033876123','1234567890','12345','texto libre',1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `provider_taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_types`
--

DROP TABLE IF EXISTS `provider_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `languages_lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provider_types_languages_lang_foreign` (`languages_lang`),
  KEY `provider_types_description_index` (`description`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_types`
--

LOCK TABLES `provider_types` WRITE;
/*!40000 ALTER TABLE `provider_types` DISABLE KEYS */;
INSERT INTO `provider_types` VALUES (1,'Nodo',1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'Productor',1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `provider_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `providers`
--

DROP TABLE IF EXISTS `providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `providers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clasification` decimal(10,2) NOT NULL DEFAULT 0.00,
  `link` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ',
  `latitude` bigint(20) NOT NULL,
  `longitude` bigint(20) NOT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` int(10) unsigned NOT NULL,
  `department_number` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `training` tinyint(1) NOT NULL,
  `logo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cbu` varchar(22) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `participate_fairs` tinyint(1) NOT NULL,
  `signature` tinyint(1) NOT NULL,
  `signature_date` date NOT NULL DEFAULT '9999-12-12',
  `feriame_authorizate` tinyint(1) NOT NULL,
  `unsubscribe` tinyint(1) NOT NULL,
  `unsubscribe_reason` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ',
  `active` tinyint(1) NOT NULL,
  `users_id` bigint(20) unsigned NOT NULL,
  `provider_types_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `providers_users_id_foreign` (`users_id`),
  KEY `providers_provider_types_id_foreign` (`provider_types_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `providers`
--

LOCK TABLES `providers` WRITE;
/*!40000 ALTER TABLE `providers` DISABLE KEYS */;
INSERT INTO `providers` VALUES (1,'Jpink','Meta',4.00,'wwww.bb.com',3,142,'Romania','Hawaii','Vicente Lopez','Jamar Pine',12,'12B',1,'','123456789','+5157408497411','tillman.tristin@cartwright.org',1,1,'1997-01-11',1,0,'The Hatter was.',1,1,1,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'Wwhite','Meta',5.00,'wwww.bb.com',-69,-122,'French Polynesia','South Dakota','Ramos Mejia','Powlowski Mountain',100,'100A',0,'','987654321','+4749806093676','prosacco.kristopher@hotmail.com',0,1,'1977-02-09',0,1,'I was, I.',1,2,1,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchases` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
INSERT INTO `purchases` VALUES (1,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qualification_deliveries`
--

DROP TABLE IF EXISTS `qualification_deliveries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qualification_deliveries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `qualification` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '5',
  `expires_date` date NOT NULL DEFAULT '9999-12-12',
  `deliveries_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qualification_deliveries_deliveries_id_foreign` (`deliveries_id`),
  KEY `qualification_deliveries_qualification_deliveries_id_index` (`qualification`,`deliveries_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qualification_deliveries`
--

LOCK TABLES `qualification_deliveries` WRITE;
/*!40000 ALTER TABLE `qualification_deliveries` DISABLE KEYS */;
/*!40000 ALTER TABLE `qualification_deliveries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qualification_products`
--

DROP TABLE IF EXISTS `qualification_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qualification_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `qualification` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '5',
  `expires_date` date NOT NULL DEFAULT '9999-12-12',
  `products_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qualification_products_products_id_foreign` (`products_id`),
  KEY `qualification_products_qualification_products_id_index` (`qualification`,`products_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qualification_products`
--

LOCK TABLES `qualification_products` WRITE;
/*!40000 ALTER TABLE `qualification_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `qualification_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qualification_providers`
--

DROP TABLE IF EXISTS `qualification_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qualification_providers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `qualification` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '5',
  `expires_date` date NOT NULL DEFAULT '9999-12-12',
  `providers_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qualification_providers_providers_id_foreign` (`providers_id`),
  KEY `qualification_providers_qualification_providers_id_index` (`qualification`,`providers_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qualification_providers`
--

LOCK TABLES `qualification_providers` WRITE;
/*!40000 ALTER TABLE `qualification_providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `qualification_providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `searchlog`
--

DROP TABLE IF EXISTS `searchlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `searchlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `text` longtext NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `product_type_id` int(11) DEFAULT NULL,
  `subproduct_types_id` int(11) DEFAULT NULL,
  `subproduct_typifications_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `searchlog`
--

LOCK TABLES `searchlog` WRITE;
/*!40000 ALTER TABLE `searchlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `searchlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_cart_headers`
--

DROP TABLE IF EXISTS `shop_cart_headers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_cart_headers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `users_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_cart_headers_users_id_foreign` (`users_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_cart_headers`
--

LOCK TABLES `shop_cart_headers` WRITE;
/*!40000 ALTER TABLE `shop_cart_headers` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_cart_headers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_cart_positions`
--

DROP TABLE IF EXISTS `shop_cart_positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_cart_positions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `shop_cart_headers_id` bigint(20) unsigned NOT NULL,
  `order_headers_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_cart_positions_shop_cart_headers_id_foreign` (`shop_cart_headers_id`),
  KEY `shop_cart_positions_order_headers_id_foreign` (`order_headers_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_cart_positions`
--

LOCK TABLES `shop_cart_positions` WRITE;
/*!40000 ALTER TABLE `shop_cart_positions` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_cart_positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subproduct_types`
--

DROP TABLE IF EXISTS `subproduct_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subproduct_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `product_types_id` bigint(20) unsigned NOT NULL,
  `languages_lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subproduct_types_product_types_id_foreign` (`product_types_id`),
  KEY `subproduct_types_languages_lang_foreign` (`languages_lang`),
  KEY `name_alias_lang_product_types_id` (`name`,`alias`,`languages_lang`,`product_types_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subproduct_types`
--

LOCK TABLES `subproduct_types` WRITE;
/*!40000 ALTER TABLE `subproduct_types` DISABLE KEYS */;
INSERT INTO `subproduct_types` VALUES (1,'Mermelada','Mermelada',1,1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'Cerveza artesanal','Cerveza artesanal',1,2,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(3,'no alcohólica','no alcohólica',1,3,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(4,'Quesos','Quesos',1,4,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(5,'Frutas','Frutas',1,5,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(6,'Recuerdos Lugareños','Recuerdos Lugareños',1,6,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(7,'Muebles','Muebles',1,6,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(8,'chacinados','chacinados',1,7,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(9,'string','string',1,8,'es','2020-09-16 01:26:55','2020-09-16 01:26:55'),(10,'Mermelada','Mermelada',1,9,'es','2020-09-16 01:33:49','2020-09-16 01:33:49');
/*!40000 ALTER TABLE `subproduct_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subproduct_typifications`
--

DROP TABLE IF EXISTS `subproduct_typifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subproduct_typifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `subproduct_types_id` bigint(20) unsigned NOT NULL,
  `languages_lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subproduct_typifications_subproduct_types_id_foreign` (`subproduct_types_id`),
  KEY `subproduct_typifications_languages_lang_foreign` (`languages_lang`),
  KEY `name_alias_lang_subproduct_types_id` (`name`,`alias`,`languages_lang`,`subproduct_types_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subproduct_typifications`
--

LOCK TABLES `subproduct_typifications` WRITE;
/*!40000 ALTER TABLE `subproduct_typifications` DISABLE KEYS */;
INSERT INTO `subproduct_typifications` VALUES (1,'Dulce de Calafate','Dulce de Calafate',1,1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'Dulce de Rosa Mosqueta','Dulce de Rosa Mosqueta',1,1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(3,'Dulce de Frutilla','Dulce de Frutilla',1,1,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(4,'IPA','IPA',1,2,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(5,'Negra','Negra',1,2,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(6,'Red','Red',1,2,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(7,'Frutilla','Frutilla',1,3,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(8,'Manzana','Manzana',1,3,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(9,'Arándanos','Arándanos',1,3,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(10,'de Cabra','de Cabra',1,4,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(11,'Rallar','Rallar',1,4,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(12,'Arándanos','Arándanos',1,5,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(13,'Frutillas','Frutillas',1,5,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(14,'Cerezas','Cerezas',1,5,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(15,'Cerezas negras','Cerezas negras',1,5,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(16,'salame de ciervo','salame de ciervo',1,6,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(17,'salame de jabalí','salame de jabalí',1,6,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(18,'pate de trucha','pate de trucha',1,6,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(19,'pate de ciervo','pate de ciervo',1,6,'es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(20,'string','string',1,9,'es','2020-09-16 01:26:55','2020-09-16 01:26:55'),(21,'Dulce de Calafate','Dulce de Calafate',1,10,'es','2020-09-16 01:33:49','2020-09-16 01:33:49');
/*!40000 ALTER TABLE `subproduct_typifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `languages_lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `units_type_index` (`type`),
  KEY `units_name_index` (`name`),
  KEY `units_type_name_languages_lang_index` (`type`,`name`,`languages_lang`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'V','Kilómetro cúbico','es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'V','Centímetro cúbico','es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(3,'V','Kilometro cubico','es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(4,'V','Centimetro cubico','es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(5,'W','Kilogramo','es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(6,'W','Gramo','es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(7,'U','Unidad','es','2020-09-15 20:35:22','2020-09-15 20:35:22'),(8,'V','string','es','2020-09-16 01:26:55','2020-09-16 01:26:55'),(9,'W','string','es','2020-09-16 01:26:55','2020-09-16 01:26:55'),(10,'V','Kilómetro cúbico','es','2020-09-16 01:33:49','2020-09-16 01:33:49'),(11,'W','Kilogramo','es','2020-09-16 01:33:49','2020-09-16 01:33:49');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '$2y$10$/yKVhj48VW8V3AjpzQToGeNVhbiwRO5ADllmV3HfSa/IuJbNpCDGa',
  `dni` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` timestamp NOT NULL DEFAULT '2038-01-19 02:00:00',
  `birthday_date` date NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL,
  `languages_lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_languages_lang_foreign` (`languages_lang`),
  KEY `users_dni_index` (`dni`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'jpinkman@bb.com','$2y$10$Mpx5EEWn1Q5E2cZnAdmpD.OdzDK/Ydgw.jkiDDvKNMVCGM5fXgUNC','27877890','2038-01-19 02:00:00','1990-01-01',0,1,'es',NULL,'2020-09-15 20:35:22','2020-09-15 20:35:22'),(2,'wwhite@bb.com','$2y$10$C2PS3P2tz42nSBgSpGUmEeXyf.79HDisUtrmC6uYa4d4e1lhpNcei','27877890','2038-01-19 02:00:00','1990-01-01',1,1,'es',NULL,'2020-09-15 20:35:22','2020-09-15 20:35:22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-09-17 12:44:52
