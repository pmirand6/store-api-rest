CREATE DATABASE  IF NOT EXISTS `feriame_dev` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `feriame_dev`;
-- MySQL dump 10.13  Distrib 5.7.25, for macos10.14 (x86_64)
--
-- Host: localhost    Database: feriame_dev
-- ------------------------------------------------------
-- Server version	8.0.20

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED='';

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `street` varchar(128) NOT NULL,
  `number` varchar(8) NOT NULL,
  `floor` varchar(60) NOT NULL,
  `apartment` varchar(60) NOT NULL,
  `zip_code` varchar(60) NOT NULL,
  `countries_id` bigint NOT NULL,
  `provinces_id` bigint NOT NULL,
  `localities_id` bigint NOT NULL,
  `geo` point NOT NULL /*!80003 SRID 4326 */,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `clients_id` bigint NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx-addresses-countries_id` (`countries_id`),
  KEY `idx-addresses-provinces_id` (`provinces_id`),
  KEY `idx-addresses-localities_id` (`localities_id`),
  KEY `idx-addresses-clients_id` (`clients_id`),
  SPATIAL KEY `idx_geo_index` (`geo`),
  CONSTRAINT `fk-addresses-clients_id` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-addresses-countries_id` FOREIGN KEY (`countries_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-addresses-localities_id` FOREIGN KEY (`localities_id`) REFERENCES `localities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-addresses-provinces_id` FOREIGN KEY (`provinces_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) DEFAULT '1',
  `users_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-admins-users_id` (`users_id`),
  CONSTRAINT `fk-admins-users_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (2,NULL,NULL,'2020-10-25 20:02:09',1,16),(3,NULL,NULL,'2020-10-25 20:02:09',1,15),(4,NULL,NULL,'2020-10-29 22:38:26',1,9);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth0`
--

DROP TABLE IF EXISTS `auth0`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth0` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `users_id` bigint NOT NULL,
  `sub` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-auth0-users_id` (`users_id`),
  CONSTRAINT `fk-auth0-users_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth0`
--

LOCK TABLES `auth0` WRITE;
/*!40000 ALTER TABLE `auth0` DISABLE KEYS */;
INSERT INTO `auth0` VALUES (1,16,'google-oauth2|113175805943942417566'),(2,34,'google-oauth2|105320020453304306693'),(3,35,'google-oauth2|105608117146170140587'),(5,37,'google-oauth2|114469018844267964459');
/*!40000 ALTER TABLE `auth0` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_signature_history`
--

DROP TABLE IF EXISTS `client_signature_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_signature_history` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `clients_id` bigint NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(100) DEFAULT NULL,
  `user_agent` text,
  PRIMARY KEY (`id`),
  KEY `idx-client_signature_history-clients_id` (`clients_id`),
  CONSTRAINT `fk-client_signature_history-clients_id` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_signature_history`
--

LOCK TABLES `client_signature_history` WRITE;
/*!40000 ALTER TABLE `client_signature_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_signature_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) DEFAULT '1',
  `birth_date` date DEFAULT NULL,
  `dni` float DEFAULT NULL,
  `gender` enum('M','F') DEFAULT NULL,
  `users_id` bigint NOT NULL,
  `signature` tinyint(1) DEFAULT '0',
  `signature_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-clients-users_id` (`users_id`),
  CONSTRAINT `fk-clients-users_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,NULL,NULL,'2020-11-02 12:55:45',1,NULL,NULL,NULL,35,0,NULL),(3,NULL,NULL,'2020-11-02 13:30:07',1,NULL,NULL,NULL,37,0,NULL);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Argentina');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_types`
--

DROP TABLE IF EXISTS `delivery_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_types` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `delivery_type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_types`
--

LOCK TABLES `delivery_types` WRITE;
/*!40000 ALTER TABLE `delivery_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorites` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `clients_id` bigint NOT NULL,
  `products_id` bigint NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx-favorites-clients_id` (`clients_id`),
  KEY `idx-favorites-products_id` (`products_id`),
  CONSTRAINT `fk-favorites-clients_id` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-favorites-products_id` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` VALUES (1,1,1,NULL,NULL,'2020-11-02 12:55:56'),(2,3,1,NULL,'2020-11-02 22:10:31','2020-11-02 13:32:40');
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorites_log`
--

DROP TABLE IF EXISTS `favorites_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorites_log` (
  `log_id` bigint NOT NULL AUTO_INCREMENT,
  `id` bigint NOT NULL,
  `clients_id` bigint NOT NULL,
  `products_id` bigint NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `idx-favorites_log-id` (`id`),
  CONSTRAINT `fk-favorites_log-id` FOREIGN KEY (`id`) REFERENCES `favorites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites_log`
--

LOCK TABLES `favorites_log` WRITE;
/*!40000 ALTER TABLE `favorites_log` DISABLE KEYS */;
INSERT INTO `favorites_log` VALUES (1,1,1,1,NULL,NULL,NULL),(2,2,3,1,NULL,NULL,NULL),(3,2,3,1,NULL,'2020-11-02 22:10:31','2020-11-02 13:32:40');
/*!40000 ALTER TABLE `favorites_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `localities`
--

DROP TABLE IF EXISTS `localities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `localities` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `provinces_id` bigint NOT NULL,
  `locality` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-localities-provinces_id` (`provinces_id`),
  CONSTRAINT `fk-localities-provinces_id` FOREIGN KEY (`provinces_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2383 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `localities`
--

LOCK TABLES `localities` WRITE;
/*!40000 ALTER TABLE `localities` DISABLE KEYS */;
INSERT INTO `localities` VALUES (1,1,'25 de Mayo'),(2,1,'3 de febrero'),(3,1,'A. Alsina'),(4,1,'A. Gonzáles Cháves'),(5,1,'Aguas Verdes'),(6,1,'Alberti'),(7,1,'Arrecifes'),(8,1,'Ayacucho'),(9,1,'Azul'),(10,1,'Bahía Blanca'),(11,1,'Balcarce'),(12,1,'Baradero'),(13,1,'Benito Juárez'),(14,1,'Berisso'),(15,1,'Bolívar'),(16,1,'Bragado'),(17,1,'Brandsen'),(18,1,'Campana'),(19,1,'Cañuelas'),(20,1,'Capilla del Señor'),(21,1,'Capitán Sarmiento'),(22,1,'Carapachay'),(23,1,'Carhue'),(24,1,'Cariló'),(25,1,'Carlos Casares'),(26,1,'Carlos Tejedor'),(27,1,'Carmen de Areco'),(28,1,'Carmen de Patagones'),(29,1,'Castelli'),(30,1,'Chacabuco'),(31,1,'Chascomús'),(32,1,'Chivilcoy'),(33,1,'Colón'),(34,1,'Coronel Dorrego'),(35,1,'Coronel Pringles'),(36,1,'Coronel Rosales'),(37,1,'Coronel Suarez'),(38,1,'Costa Azul'),(39,1,'Costa Chica'),(40,1,'Costa del Este'),(41,1,'Costa Esmeralda'),(42,1,'Daireaux'),(43,1,'Darregueira'),(44,1,'Del Viso'),(45,1,'Dolores'),(46,1,'Don Torcuato'),(47,1,'Ensenada'),(48,1,'Escobar'),(49,1,'Exaltación de la Cruz'),(50,1,'Florentino Ameghino'),(51,1,'Garín'),(52,1,'Gral. Alvarado'),(53,1,'Gral. Alvear'),(54,1,'Gral. Arenales'),(55,1,'Gral. Belgrano'),(56,1,'Gral. Guido'),(57,1,'Gral. Lamadrid'),(58,1,'Gral. Las Heras'),(59,1,'Gral. Lavalle'),(60,1,'Gral. Madariaga'),(61,1,'Gral. Pacheco'),(62,1,'Gral. Paz'),(63,1,'Gral. Pinto'),(64,1,'Gral. Pueyrredón'),(65,1,'Gral. Rodríguez'),(66,1,'Gral. Viamonte'),(67,1,'Gral. Villegas'),(68,1,'Guaminí'),(69,1,'Guernica'),(70,1,'Hipólito Yrigoyen'),(71,1,'Ing. Maschwitz'),(72,1,'Junín'),(73,1,'La Plata'),(74,1,'Laprida'),(75,1,'Las Flores'),(76,1,'Las Toninas'),(77,1,'Leandro N. Alem'),(78,1,'Lincoln'),(79,1,'Loberia'),(80,1,'Lobos'),(81,1,'Los Cardales'),(82,1,'Los Toldos'),(83,1,'Lucila del Mar'),(84,1,'Luján'),(85,1,'Magdalena'),(86,1,'Maipú'),(87,1,'Mar Chiquita'),(88,1,'Mar de Ajó'),(89,1,'Mar de las Pampas'),(90,1,'Mar del Plata'),(91,1,'Mar del Tuyú'),(92,1,'Marcos Paz'),(93,1,'Mercedes'),(94,1,'Miramar'),(95,1,'Monte'),(96,1,'Monte Hermoso'),(97,1,'Munro'),(98,1,'Navarro'),(99,1,'Necochea'),(100,1,'Olavarría'),(101,1,'Partido de la Costa'),(102,1,'Pehuajó'),(103,1,'Pellegrini'),(104,1,'Pergamino'),(105,1,'Pigüé'),(106,1,'Pila'),(107,1,'Pilar'),(108,1,'Pinamar'),(109,1,'Pinar del Sol'),(110,1,'Polvorines'),(111,1,'Pte. Perón'),(112,1,'Puán'),(113,1,'Punta Indio'),(114,1,'Ramallo'),(115,1,'Rauch'),(116,1,'Rivadavia'),(117,1,'Rojas'),(118,1,'Roque Pérez'),(119,1,'Saavedra'),(120,1,'Saladillo'),(121,1,'Salliqueló'),(122,1,'Salto'),(123,1,'San Andrés de Giles'),(124,1,'San Antonio de Areco'),(125,1,'San Antonio de Padua'),(126,1,'San Bernardo'),(127,1,'San Cayetano'),(128,1,'San Clemente del Tuyú'),(129,1,'San Nicolás'),(130,1,'San Pedro'),(131,1,'San Vicente'),(132,1,'Santa Teresita'),(133,1,'Suipacha'),(134,1,'Tandil'),(135,1,'Tapalqué'),(136,1,'Tordillo'),(137,1,'Tornquist'),(138,1,'Trenque Lauquen'),(139,1,'Tres Lomas'),(140,1,'Villa Gesell'),(141,1,'Villarino'),(142,1,'Zárate'),(143,2,'11 de Septiembre'),(144,2,'20 de Junio'),(145,2,'25 de Mayo'),(146,2,'Acassuso'),(147,2,'Adrogué'),(148,2,'Aldo Bonzi'),(149,2,'Área Reserva Cinturón Ecológico'),(150,2,'Avellaneda'),(151,2,'Banfield'),(152,2,'Barrio Parque'),(153,2,'Barrio Santa Teresita'),(154,2,'Beccar'),(155,2,'Bella Vista'),(156,2,'Berazategui'),(157,2,'Bernal Este'),(158,2,'Bernal Oeste'),(159,2,'Billinghurst'),(160,2,'Boulogne'),(161,2,'Burzaco'),(162,2,'Carapachay'),(163,2,'Caseros'),(164,2,'Castelar'),(165,2,'Churruca'),(166,2,'Ciudad Evita'),(167,2,'Ciudad Madero'),(168,2,'Ciudadela'),(169,2,'Claypole'),(170,2,'Crucecita'),(171,2,'Dock Sud'),(172,2,'Don Bosco'),(173,2,'Don Orione'),(174,2,'El Jagüel'),(175,2,'El Libertador'),(176,2,'El Palomar'),(177,2,'El Tala'),(178,2,'El Trébol'),(179,2,'Ezeiza'),(180,2,'Ezpeleta'),(181,2,'Florencio Varela'),(182,2,'Florida'),(183,2,'Francisco Álvarez'),(184,2,'Gerli'),(185,2,'Glew'),(186,2,'González Catán'),(187,2,'Gral. Lamadrid'),(188,2,'Grand Bourg'),(189,2,'Gregorio de Laferrere'),(190,2,'Guillermo Enrique Hudson'),(191,2,'Haedo'),(192,2,'Hurlingham'),(193,2,'Ing. Sourdeaux'),(194,2,'Isidro Casanova'),(195,2,'Ituzaingó'),(196,2,'José C. Paz'),(197,2,'José Ingenieros'),(198,2,'José Marmol'),(199,2,'La Lucila'),(200,2,'La Reja'),(201,2,'La Tablada'),(202,2,'Lanús'),(203,2,'Llavallol'),(204,2,'Loma Hermosa'),(205,2,'Lomas de Zamora'),(206,2,'Lomas del Millón'),(207,2,'Lomas del Mirador'),(208,2,'Longchamps'),(209,2,'Los Polvorines'),(210,2,'Luis Guillón'),(211,2,'Malvinas Argentinas'),(212,2,'Martín Coronado'),(213,2,'Martínez'),(214,2,'Merlo'),(215,2,'Ministro Rivadavia'),(216,2,'Monte Chingolo'),(217,2,'Monte Grande'),(218,2,'Moreno'),(219,2,'Morón'),(220,2,'Muñiz'),(221,2,'Olivos'),(222,2,'Pablo Nogués'),(223,2,'Pablo Podestá'),(224,2,'Paso del Rey'),(225,2,'Pereyra'),(226,2,'Piñeiro'),(227,2,'Plátanos'),(228,2,'Pontevedra'),(229,2,'Quilmes'),(230,2,'Rafael Calzada'),(231,2,'Rafael Castillo'),(232,2,'Ramos Mejía'),(233,2,'Ranelagh'),(234,2,'Remedios de Escalada'),(235,2,'Sáenz Peña'),(236,2,'San Antonio de Padua'),(237,2,'San Fernando'),(238,2,'San Francisco Solano'),(239,2,'San Isidro'),(240,2,'San José'),(241,2,'San Justo'),(242,2,'San Martín'),(243,2,'San Miguel'),(244,2,'Santos Lugares'),(245,2,'Sarandí'),(246,2,'Sourigues'),(247,2,'Tapiales'),(248,2,'Temperley'),(249,2,'Tigre'),(250,2,'Tortuguitas'),(251,2,'Tristán Suárez'),(252,2,'Trujui'),(253,2,'Turdera'),(254,2,'Valentín Alsina'),(255,2,'Vicente López'),(256,2,'Villa Adelina'),(257,2,'Villa Ballester'),(258,2,'Villa Bosch'),(259,2,'Villa Caraza'),(260,2,'Villa Celina'),(261,2,'Villa Centenario'),(262,2,'Villa de Mayo'),(263,2,'Villa Diamante'),(264,2,'Villa Domínico'),(265,2,'Villa España'),(266,2,'Villa Fiorito'),(267,2,'Villa Guillermina'),(268,2,'Villa Insuperable'),(269,2,'Villa José León Suárez'),(270,2,'Villa La Florida'),(271,2,'Villa Luzuriaga'),(272,2,'Villa Martelli'),(273,2,'Villa Obrera'),(274,2,'Villa Progreso'),(275,2,'Villa Raffo'),(276,2,'Villa Sarmiento'),(277,2,'Villa Tesei'),(278,2,'Villa Udaondo'),(279,2,'Virrey del Pino'),(280,2,'Wilde'),(281,2,'William Morris'),(282,3,'Agronomía'),(283,3,'Almagro'),(284,3,'Balvanera'),(285,3,'Barracas'),(286,3,'Belgrano'),(287,3,'Boca'),(288,3,'Boedo'),(289,3,'Caballito'),(290,3,'Chacarita'),(291,3,'Coghlan'),(292,3,'Colegiales'),(293,3,'Constitución'),(294,3,'Flores'),(295,3,'Floresta'),(296,3,'La Paternal'),(297,3,'Liniers'),(298,3,'Mataderos'),(299,3,'Monserrat'),(300,3,'Monte Castro'),(301,3,'Nueva Pompeya'),(302,3,'Núñez'),(303,3,'Palermo'),(304,3,'Parque Avellaneda'),(305,3,'Parque Chacabuco'),(306,3,'Parque Chas'),(307,3,'Parque Patricios'),(308,3,'Puerto Madero'),(309,3,'Recoleta'),(310,3,'Retiro'),(311,3,'Saavedra'),(312,3,'San Cristóbal'),(313,3,'San Nicolás'),(314,3,'San Telmo'),(315,3,'Vélez Sársfield'),(316,3,'Versalles'),(317,3,'Villa Crespo'),(318,3,'Villa del Parque'),(319,3,'Villa Devoto'),(320,3,'Villa Gral. Mitre'),(321,3,'Villa Lugano'),(322,3,'Villa Luro'),(323,3,'Villa Ortúzar'),(324,3,'Villa Pueyrredón'),(325,3,'Villa Real'),(326,3,'Villa Riachuelo'),(327,3,'Villa Santa Rita'),(328,3,'Villa Soldati'),(329,3,'Villa Urquiza'),(330,4,'Aconquija'),(331,4,'Ancasti'),(332,4,'Andalgalá'),(333,4,'Antofagasta'),(334,4,'Belén'),(335,4,'Capayán'),(336,4,'Capital'),(337,4,'4'),(338,4,'Corral Quemado'),(339,4,'El Alto'),(340,4,'El Rodeo'),(341,4,'F.Mamerto Esquiú'),(342,4,'Fiambalá'),(343,4,'Hualfín'),(344,4,'Huillapima'),(345,4,'Icaño'),(346,4,'La Puerta'),(347,4,'Las Juntas'),(348,4,'Londres'),(349,4,'Los Altos'),(350,4,'Los Varela'),(351,4,'Mutquín'),(352,4,'Paclín'),(353,4,'Poman'),(354,4,'Pozo de La Piedra'),(355,4,'Puerta de Corral'),(356,4,'Puerta San José'),(357,4,'Recreo'),(358,4,'S.F.V de 4'),(359,4,'San Fernando'),(360,4,'San Fernando del Valle'),(361,4,'San José'),(362,4,'Santa María'),(363,4,'Santa Rosa'),(364,4,'Saujil'),(365,4,'Tapso'),(366,4,'Tinogasta'),(367,4,'Valle Viejo'),(368,4,'Villa Vil'),(369,5,'Aviá Teraí'),(370,5,'Barranqueras'),(371,5,'Basail'),(372,5,'Campo Largo'),(373,5,'Capital'),(374,5,'Capitán Solari'),(375,5,'Charadai'),(376,5,'Charata'),(377,5,'Chorotis'),(378,5,'Ciervo Petiso'),(379,5,'Cnel. Du Graty'),(380,5,'Col. Benítez'),(381,5,'Col. Elisa'),(382,5,'Col. Popular'),(383,5,'Colonias Unidas'),(384,5,'Concepción'),(385,5,'Corzuela'),(386,5,'Cote Lai'),(387,5,'El Sauzalito'),(388,5,'Enrique Urien'),(389,5,'Fontana'),(390,5,'Fte. Esperanza'),(391,5,'Gancedo'),(392,5,'Gral. Capdevila'),(393,5,'Gral. Pinero'),(394,5,'Gral. San Martín'),(395,5,'Gral. Vedia'),(396,5,'Hermoso Campo'),(397,5,'I. del Cerrito'),(398,5,'J.J. Castelli'),(399,5,'La Clotilde'),(400,5,'La Eduvigis'),(401,5,'La Escondida'),(402,5,'La Leonesa'),(403,5,'La Tigra'),(404,5,'La Verde'),(405,5,'Laguna Blanca'),(406,5,'Laguna Limpia'),(407,5,'Lapachito'),(408,5,'Las Breñas'),(409,5,'Las Garcitas'),(410,5,'Las Palmas'),(411,5,'Los Frentones'),(412,5,'Machagai'),(413,5,'Makallé'),(414,5,'Margarita Belén'),(415,5,'Miraflores'),(416,5,'Misión N. Pompeya'),(417,5,'Napenay'),(418,5,'Pampa Almirón'),(419,5,'Pampa del Indio'),(420,5,'Pampa del Infierno'),(421,5,'Pdcia. de La Plaza'),(422,5,'Pdcia. Roca'),(423,5,'Pdcia. Roque Sáenz Peña'),(424,5,'Pto. Bermejo'),(425,5,'Pto. Eva Perón'),(426,5,'Puero Tirol'),(427,5,'Puerto Vilelas'),(428,5,'Quitilipi'),(429,5,'Resistencia'),(430,5,'Sáenz Peña'),(431,5,'Samuhú'),(432,5,'San Bernardo'),(433,5,'Santa Sylvina'),(434,5,'Taco Pozo'),(435,5,'Tres Isletas'),(436,5,'Villa Ángela'),(437,5,'Villa Berthet'),(438,5,'Villa R. Bermejito'),(439,6,'Aldea Apeleg'),(440,6,'Aldea Beleiro'),(441,6,'Aldea Epulef'),(442,6,'Alto Río Sengerr'),(443,6,'Buen Pasto'),(444,6,'Camarones'),(445,6,'Carrenleufú'),(446,6,'Cholila'),(447,6,'Co. Centinela'),(448,6,'Colan Conhué'),(449,6,'Comodoro Rivadavia'),(450,6,'Corcovado'),(451,6,'Cushamen'),(452,6,'Dique F. Ameghino'),(453,6,'Dolavón'),(454,6,'Dr. R. Rojas'),(455,6,'El Hoyo'),(456,6,'El Maitén'),(457,6,'Epuyén'),(458,6,'Esquel'),(459,6,'Facundo'),(460,6,'Gaimán'),(461,6,'Gan Gan'),(462,6,'Gastre'),(463,6,'Gdor. Costa'),(464,6,'Gualjaina'),(465,6,'J. de San Martín'),(466,6,'Lago Blanco'),(467,6,'Lago Puelo'),(468,6,'Lagunita Salada'),(469,6,'Las Plumas'),(470,6,'Los Altares'),(471,6,'Paso de los Indios'),(472,6,'Paso del Sapo'),(473,6,'Pto. Madryn'),(474,6,'Pto. Pirámides'),(475,6,'Rada Tilly'),(476,6,'Rawson'),(477,6,'Río Mayo'),(478,6,'Río Pico'),(479,6,'Sarmiento'),(480,6,'Tecka'),(481,6,'Telsen'),(482,6,'Trelew'),(483,6,'Trevelin'),(484,6,'Veintiocho de Julio'),(485,7,'Achiras'),(486,7,'Adelia Maria'),(487,7,'Agua de Oro'),(488,7,'Alcira Gigena'),(489,7,'Aldea Santa Maria'),(490,7,'Alejandro Roca'),(491,7,'Alejo Ledesma'),(492,7,'Alicia'),(493,7,'Almafuerte'),(494,7,'Alpa Corral'),(495,7,'Alta Gracia'),(496,7,'Alto Alegre'),(497,7,'Alto de Los Quebrachos'),(498,7,'Altos de Chipion'),(499,7,'Amboy'),(500,7,'Ambul'),(501,7,'Ana Zumaran'),(502,7,'Anisacate'),(503,7,'Arguello'),(504,7,'Arias'),(505,7,'Arroyito'),(506,7,'Arroyo Algodon'),(507,7,'Arroyo Cabral'),(508,7,'Arroyo Los Patos'),(509,7,'Assunta'),(510,7,'Atahona'),(511,7,'Ausonia'),(512,7,'Avellaneda'),(513,7,'Ballesteros'),(514,7,'Ballesteros Sud'),(515,7,'Balnearia'),(516,7,'Bañado de Soto'),(517,7,'Bell Ville'),(518,7,'Bengolea'),(519,7,'Benjamin Gould'),(520,7,'Berrotaran'),(521,7,'Bialet Masse'),(522,7,'Bouwer'),(523,7,'Brinkmann'),(524,7,'Buchardo'),(525,7,'Bulnes'),(526,7,'Cabalango'),(527,7,'Calamuchita'),(528,7,'Calchin'),(529,7,'Calchin Oeste'),(530,7,'Calmayo'),(531,7,'Camilo Aldao'),(532,7,'Caminiaga'),(533,7,'Cañada de Luque'),(534,7,'Cañada de Machado'),(535,7,'Cañada de Rio Pinto'),(536,7,'Cañada del Sauce'),(537,7,'Canals'),(538,7,'Candelaria Sud'),(539,7,'Capilla de Remedios'),(540,7,'Capilla de Siton'),(541,7,'Capilla del Carmen'),(542,7,'Capilla del Monte'),(543,7,'Capital'),(544,7,'Capitan Gral B. O´Higgins'),(545,7,'Carnerillo'),(546,7,'Carrilobo'),(547,7,'Casa Grande'),(548,7,'Cavanagh'),(549,7,'Cerro Colorado'),(550,7,'Chaján'),(551,7,'Chalacea'),(552,7,'Chañar Viejo'),(553,7,'Chancaní'),(554,7,'Charbonier'),(555,7,'Charras'),(556,7,'Chazón'),(557,7,'Chilibroste'),(558,7,'Chucul'),(559,7,'Chuña'),(560,7,'Chuña Huasi'),(561,7,'Churqui Cañada'),(562,7,'Cienaga Del Coro'),(563,7,'Cintra'),(564,7,'Col. Almada'),(565,7,'Col. Anita'),(566,7,'Col. Barge'),(567,7,'Col. Bismark'),(568,7,'Col. Bremen'),(569,7,'Col. Caroya'),(570,7,'Col. Italiana'),(571,7,'Col. Iturraspe'),(572,7,'Col. Las Cuatro Esquinas'),(573,7,'Col. Las Pichanas'),(574,7,'Col. Marina'),(575,7,'Col. Prosperidad'),(576,7,'Col. San Bartolome'),(577,7,'Col. San Pedro'),(578,7,'Col. Tirolesa'),(579,7,'Col. Vicente Aguero'),(580,7,'Col. Videla'),(581,7,'Col. Vignaud'),(582,7,'Col. Waltelina'),(583,7,'Colazo'),(584,7,'Comechingones'),(585,7,'Conlara'),(586,7,'Copacabana'),(587,7,'7'),(588,7,'Coronel Baigorria'),(589,7,'Coronel Moldes'),(590,7,'Corral de Bustos'),(591,7,'Corralito'),(592,7,'Cosquín'),(593,7,'Costa Sacate'),(594,7,'Cruz Alta'),(595,7,'Cruz de Caña'),(596,7,'Cruz del Eje'),(597,7,'Cuesta Blanca'),(598,7,'Dean Funes'),(599,7,'Del Campillo'),(600,7,'Despeñaderos'),(601,7,'Devoto'),(602,7,'Diego de Rojas'),(603,7,'Dique Chico'),(604,7,'El Arañado'),(605,7,'El Brete'),(606,7,'El Chacho'),(607,7,'El Crispín'),(608,7,'El Fortín'),(609,7,'El Manzano'),(610,7,'El Rastreador'),(611,7,'El Rodeo'),(612,7,'El Tío'),(613,7,'Elena'),(614,7,'Embalse'),(615,7,'Esquina'),(616,7,'Estación Gral. Paz'),(617,7,'Estación Juárez Celman'),(618,7,'Estancia de Guadalupe'),(619,7,'Estancia Vieja'),(620,7,'Etruria'),(621,7,'Eufrasio Loza'),(622,7,'Falda del Carmen'),(623,7,'Freyre'),(624,7,'Gral. Baldissera'),(625,7,'Gral. Cabrera'),(626,7,'Gral. Deheza'),(627,7,'Gral. Fotheringham'),(628,7,'Gral. Levalle'),(629,7,'Gral. Roca'),(630,7,'Guanaco Muerto'),(631,7,'Guasapampa'),(632,7,'Guatimozin'),(633,7,'Gutenberg'),(634,7,'Hernando'),(635,7,'Huanchillas'),(636,7,'Huerta Grande'),(637,7,'Huinca Renanco'),(638,7,'Idiazabal'),(639,7,'Impira'),(640,7,'Inriville'),(641,7,'Isla Verde'),(642,7,'Italó'),(643,7,'James Craik'),(644,7,'Jesús María'),(645,7,'Jovita'),(646,7,'Justiniano Posse'),(647,7,'Km 658'),(648,7,'L. V. Mansilla'),(649,7,'La Batea'),(650,7,'La Calera'),(651,7,'La Carlota'),(652,7,'La Carolina'),(653,7,'La Cautiva'),(654,7,'La Cesira'),(655,7,'La Cruz'),(656,7,'La Cumbre'),(657,7,'La Cumbrecita'),(658,7,'La Falda'),(659,7,'La Francia'),(660,7,'La Granja'),(661,7,'La Higuera'),(662,7,'La Laguna'),(663,7,'La Paisanita'),(664,7,'La Palestina'),(665,7,'12'),(666,7,'La Paquita'),(667,7,'La Para'),(668,7,'La Paz'),(669,7,'La Playa'),(670,7,'La Playosa'),(671,7,'La Población'),(672,7,'La Posta'),(673,7,'La Puerta'),(674,7,'La Quinta'),(675,7,'La Rancherita'),(676,7,'La Rinconada'),(677,7,'La Serranita'),(678,7,'La Tordilla'),(679,7,'Laborde'),(680,7,'Laboulaye'),(681,7,'Laguna Larga'),(682,7,'Las Acequias'),(683,7,'Las Albahacas'),(684,7,'Las Arrias'),(685,7,'Las Bajadas'),(686,7,'Las Caleras'),(687,7,'Las Calles'),(688,7,'Las Cañadas'),(689,7,'Las Gramillas'),(690,7,'Las Higueras'),(691,7,'Las Isletillas'),(692,7,'Las Junturas'),(693,7,'Las Palmas'),(694,7,'Las Peñas'),(695,7,'Las Peñas Sud'),(696,7,'Las Perdices'),(697,7,'Las Playas'),(698,7,'Las Rabonas'),(699,7,'Las Saladas'),(700,7,'Las Tapias'),(701,7,'Las Varas'),(702,7,'Las Varillas'),(703,7,'Las Vertientes'),(704,7,'Leguizamón'),(705,7,'Leones'),(706,7,'Los Cedros'),(707,7,'Los Cerrillos'),(708,7,'Los Chañaritos (C.E)'),(709,7,'Los Chanaritos (R.S)'),(710,7,'Los Cisnes'),(711,7,'Los Cocos'),(712,7,'Los Cóndores'),(713,7,'Los Hornillos'),(714,7,'Los Hoyos'),(715,7,'Los Mistoles'),(716,7,'Los Molinos'),(717,7,'Los Pozos'),(718,7,'Los Reartes'),(719,7,'Los Surgentes'),(720,7,'Los Talares'),(721,7,'Los Zorros'),(722,7,'Lozada'),(723,7,'Luca'),(724,7,'Luque'),(725,7,'Luyaba'),(726,7,'Malagueño'),(727,7,'Malena'),(728,7,'Malvinas Argentinas'),(729,7,'Manfredi'),(730,7,'Maquinista Gallini'),(731,7,'Marcos Juárez'),(732,7,'Marull'),(733,7,'Matorrales'),(734,7,'Mattaldi'),(735,7,'Mayu Sumaj'),(736,7,'Media Naranja'),(737,7,'Melo'),(738,7,'Mendiolaza'),(739,7,'Mi Granja'),(740,7,'Mina Clavero'),(741,7,'Miramar'),(742,7,'Morrison'),(743,7,'Morteros'),(744,7,'Mte. Buey'),(745,7,'Mte. Cristo'),(746,7,'Mte. De Los Gauchos'),(747,7,'Mte. Leña'),(748,7,'Mte. Maíz'),(749,7,'Mte. Ralo'),(750,7,'Nicolás Bruzone'),(751,7,'Noetinger'),(752,7,'Nono'),(753,7,'Nueva 7'),(754,7,'Obispo Trejo'),(755,7,'Olaeta'),(756,7,'Oliva'),(757,7,'Olivares San Nicolás'),(758,7,'Onagolty'),(759,7,'Oncativo'),(760,7,'Ordoñez'),(761,7,'Pacheco De Melo'),(762,7,'Pampayasta N.'),(763,7,'Pampayasta S.'),(764,7,'Panaholma'),(765,7,'Pascanas'),(766,7,'Pasco'),(767,7,'Paso del Durazno'),(768,7,'Paso Viejo'),(769,7,'Pilar'),(770,7,'Pincén'),(771,7,'Piquillín'),(772,7,'Plaza de Mercedes'),(773,7,'Plaza Luxardo'),(774,7,'Porteña'),(775,7,'Potrero de Garay'),(776,7,'Pozo del Molle'),(777,7,'Pozo Nuevo'),(778,7,'Pueblo Italiano'),(779,7,'Puesto de Castro'),(780,7,'Punta del Agua'),(781,7,'Quebracho Herrado'),(782,7,'Quilino'),(783,7,'Rafael García'),(784,7,'Ranqueles'),(785,7,'Rayo Cortado'),(786,7,'Reducción'),(787,7,'Rincón'),(788,7,'Río Bamba'),(789,7,'Río Ceballos'),(790,7,'Río Cuarto'),(791,7,'Río de Los Sauces'),(792,7,'Río Primero'),(793,7,'Río Segundo'),(794,7,'Río Tercero'),(795,7,'Rosales'),(796,7,'Rosario del Saladillo'),(797,7,'Sacanta'),(798,7,'Sagrada Familia'),(799,7,'Saira'),(800,7,'Saladillo'),(801,7,'Saldán'),(802,7,'Salsacate'),(803,7,'Salsipuedes'),(804,7,'Sampacho'),(805,7,'San Agustín'),(806,7,'San Antonio de Arredondo'),(807,7,'San Antonio de Litín'),(808,7,'San Basilio'),(809,7,'San Carlos Minas'),(810,7,'San Clemente'),(811,7,'San Esteban'),(812,7,'San Francisco'),(813,7,'San Ignacio'),(814,7,'San Javier'),(815,7,'San Jerónimo'),(816,7,'San Joaquín'),(817,7,'San José de La Dormida'),(818,7,'San José de Las Salinas'),(819,7,'San Lorenzo'),(820,7,'San Marcos Sierras'),(821,7,'San Marcos Sud'),(822,7,'San Pedro'),(823,7,'San Pedro N.'),(824,7,'San Roque'),(825,7,'San Vicente'),(826,7,'Santa Catalina'),(827,7,'Santa Elena'),(828,7,'Santa Eufemia'),(829,7,'Santa Maria'),(830,7,'Sarmiento'),(831,7,'Saturnino M.Laspiur'),(832,7,'Sauce Arriba'),(833,7,'Sebastián Elcano'),(834,7,'Seeber'),(835,7,'Segunda Usina'),(836,7,'Serrano'),(837,7,'Serrezuela'),(838,7,'Sgo. Temple'),(839,7,'Silvio Pellico'),(840,7,'Simbolar'),(841,7,'Sinsacate'),(842,7,'Sta. Rosa de Calamuchita'),(843,7,'Sta. Rosa de Río Primero'),(844,7,'Suco'),(845,7,'Tala Cañada'),(846,7,'Tala Huasi'),(847,7,'Talaini'),(848,7,'Tancacha'),(849,7,'Tanti'),(850,7,'Ticino'),(851,7,'Tinoco'),(852,7,'Tío Pujio'),(853,7,'Toledo'),(854,7,'Toro Pujio'),(855,7,'Tosno'),(856,7,'Tosquita'),(857,7,'Tránsito'),(858,7,'Tuclame'),(859,7,'Tutti'),(860,7,'Ucacha'),(861,7,'Unquillo'),(862,7,'Valle de Anisacate'),(863,7,'Valle Hermoso'),(864,7,'Vélez Sarfield'),(865,7,'Viamonte'),(866,7,'Vicuña Mackenna'),(867,7,'Villa Allende'),(868,7,'Villa Amancay'),(869,7,'Villa Ascasubi'),(870,7,'Villa Candelaria N.'),(871,7,'Villa Carlos Paz'),(872,7,'Villa Cerro Azul'),(873,7,'Villa Ciudad de América'),(874,7,'Villa Ciudad Pque Los Reartes'),(875,7,'Villa Concepción del Tío'),(876,7,'Villa Cura Brochero'),(877,7,'Villa de Las Rosas'),(878,7,'Villa de María'),(879,7,'Villa de Pocho'),(880,7,'Villa de Soto'),(881,7,'Villa del Dique'),(882,7,'Villa del Prado'),(883,7,'Villa del Rosario'),(884,7,'Villa del Totoral'),(885,7,'Villa Dolores'),(886,7,'Villa El Chancay'),(887,7,'Villa Elisa'),(888,7,'Villa Flor Serrana'),(889,7,'Villa Fontana'),(890,7,'Villa Giardino'),(891,7,'Villa Gral. Belgrano'),(892,7,'Villa Gutierrez'),(893,7,'Villa Huidobro'),(894,7,'Villa La Bolsa'),(895,7,'Villa Los Aromos'),(896,7,'Villa Los Patos'),(897,7,'Villa María'),(898,7,'Villa Nueva'),(899,7,'Villa Pque. Santa Ana'),(900,7,'Villa Pque. Siquiman'),(901,7,'Villa Quillinzo'),(902,7,'Villa Rossi'),(903,7,'Villa Rumipal'),(904,7,'Villa San Esteban'),(905,7,'Villa San Isidro'),(906,7,'Villa 21'),(907,7,'Villa Sarmiento (G.R)'),(908,7,'Villa Sarmiento (S.A)'),(909,7,'Villa Tulumba'),(910,7,'Villa Valeria'),(911,7,'Villa Yacanto'),(912,7,'Washington'),(913,7,'Wenceslao Escalante'),(914,7,'Ycho Cruz Sierras'),(915,8,'Alvear'),(916,8,'Bella Vista'),(917,8,'Berón de Astrada'),(918,8,'Bonpland'),(919,8,'Caá Cati'),(920,8,'Capital'),(921,8,'Chavarría'),(922,8,'Col. C. Pellegrini'),(923,8,'Col. Libertad'),(924,8,'Col. Liebig'),(925,8,'Col. Sta Rosa'),(926,8,'Concepción'),(927,8,'Cruz de Los Milagros'),(928,8,'Curuzú-Cuatiá'),(929,8,'Empedrado'),(930,8,'Esquina'),(931,8,'Estación Torrent'),(932,8,'Felipe Yofré'),(933,8,'Garruchos'),(934,8,'Gdor. Agrónomo'),(935,8,'Gdor. Martínez'),(936,8,'Goya'),(937,8,'Guaviravi'),(938,8,'Herlitzka'),(939,8,'Ita-Ibate'),(940,8,'Itatí'),(941,8,'Ituzaingó'),(942,8,'José Rafael Gómez'),(943,8,'Juan Pujol'),(944,8,'La Cruz'),(945,8,'Lavalle'),(946,8,'Lomas de Vallejos'),(947,8,'Loreto'),(948,8,'Mariano I. Loza'),(949,8,'Mburucuyá'),(950,8,'Mercedes'),(951,8,'Mocoretá'),(952,8,'Mte. Caseros'),(953,8,'Nueve de Julio'),(954,8,'Palmar Grande'),(955,8,'Parada Pucheta'),(956,8,'Paso de La Patria'),(957,8,'Paso de Los Libres'),(958,8,'Pedro R. Fernandez'),(959,8,'Perugorría'),(960,8,'Pueblo Libertador'),(961,8,'Ramada Paso'),(962,8,'Riachuelo'),(963,8,'Saladas'),(964,8,'San Antonio'),(965,8,'San Carlos'),(966,8,'San Cosme'),(967,8,'San Lorenzo'),(968,8,'20 del Palmar'),(969,8,'San Miguel'),(970,8,'San Roque'),(971,8,'Santa Ana'),(972,8,'Santa Lucía'),(973,8,'Santo Tomé'),(974,8,'Sauce'),(975,8,'Tabay'),(976,8,'Tapebicuá'),(977,8,'Tatacua'),(978,8,'Virasoro'),(979,8,'Yapeyú'),(980,8,'Yataití Calle'),(981,9,'Alarcón'),(982,9,'Alcaraz'),(983,9,'Alcaraz N.'),(984,9,'Alcaraz S.'),(985,9,'Aldea Asunción'),(986,9,'Aldea Brasilera'),(987,9,'Aldea Elgenfeld'),(988,9,'Aldea Grapschental'),(989,9,'Aldea Ma. Luisa'),(990,9,'Aldea Protestante'),(991,9,'Aldea Salto'),(992,9,'Aldea San Antonio (G)'),(993,9,'Aldea San Antonio (P)'),(994,9,'Aldea 19'),(995,9,'Aldea San Miguel'),(996,9,'Aldea San Rafael'),(997,9,'Aldea Spatzenkutter'),(998,9,'Aldea Sta. María'),(999,9,'Aldea Sta. Rosa'),(1000,9,'Aldea Valle María'),(1001,9,'Altamirano Sur'),(1002,9,'Antelo'),(1003,9,'Antonio Tomás'),(1004,9,'Aranguren'),(1005,9,'Arroyo Barú'),(1006,9,'Arroyo Burgos'),(1007,9,'Arroyo Clé'),(1008,9,'Arroyo Corralito'),(1009,9,'Arroyo del Medio'),(1010,9,'Arroyo Maturrango'),(1011,9,'Arroyo Palo Seco'),(1012,9,'Banderas'),(1013,9,'Basavilbaso'),(1014,9,'Betbeder'),(1015,9,'Bovril'),(1016,9,'Caseros'),(1017,9,'Ceibas'),(1018,9,'Cerrito'),(1019,9,'Chajarí'),(1020,9,'Chilcas'),(1021,9,'Clodomiro Ledesma'),(1022,9,'Col. Alemana'),(1023,9,'Col. Avellaneda'),(1024,9,'Col. Avigdor'),(1025,9,'Col. Ayuí'),(1026,9,'Col. Baylina'),(1027,9,'Col. Carrasco'),(1028,9,'Col. Celina'),(1029,9,'Col. Cerrito'),(1030,9,'Col. Crespo'),(1031,9,'Col. Elia'),(1032,9,'Col. Ensayo'),(1033,9,'Col. Gral. Roca'),(1034,9,'Col. La Argentina'),(1035,9,'Col. Merou'),(1036,9,'Col. Oficial Nª3'),(1037,9,'Col. Oficial Nº13'),(1038,9,'Col. Oficial Nº14'),(1039,9,'Col. Oficial Nº5'),(1040,9,'Col. Reffino'),(1041,9,'Col. Tunas'),(1042,9,'Col. Viraró'),(1043,9,'Colón'),(1044,9,'Concepción del Uruguay'),(1045,9,'Concordia'),(1046,9,'Conscripto Bernardi'),(1047,9,'Costa Grande'),(1048,9,'Costa San Antonio'),(1049,9,'Costa Uruguay N.'),(1050,9,'Costa Uruguay S.'),(1051,9,'Crespo'),(1052,9,'Crucecitas 3ª'),(1053,9,'Crucecitas 7ª'),(1054,9,'Crucecitas 8ª'),(1055,9,'Cuchilla Redonda'),(1056,9,'Curtiembre'),(1057,9,'Diamante'),(1058,9,'Distrito 6º'),(1059,9,'Distrito Chañar'),(1060,9,'Distrito Chiqueros'),(1061,9,'Distrito Cuarto'),(1062,9,'Distrito Diego López'),(1063,9,'Distrito Pajonal'),(1064,9,'Distrito Sauce'),(1065,9,'Distrito Tala'),(1066,9,'Distrito Talitas'),(1067,9,'Don Cristóbal 1ª Sección'),(1068,9,'Don Cristóbal 2ª Sección'),(1069,9,'Durazno'),(1070,9,'El Cimarrón'),(1071,9,'El Gramillal'),(1072,9,'El Palenque'),(1073,9,'El Pingo'),(1074,9,'El Quebracho'),(1075,9,'El Redomón'),(1076,9,'El Solar'),(1077,9,'Enrique Carbo'),(1078,9,'9'),(1079,9,'Espinillo N.'),(1080,9,'Estación Campos'),(1081,9,'Estación Escriña'),(1082,9,'Estación Lazo'),(1083,9,'Estación Raíces'),(1084,9,'Estación Yerúa'),(1085,9,'Estancia Grande'),(1086,9,'Estancia Líbaros'),(1087,9,'Estancia Racedo'),(1088,9,'Estancia Solá'),(1089,9,'Estancia Yuquerí'),(1090,9,'Estaquitas'),(1091,9,'Faustino M. Parera'),(1092,9,'Febre'),(1093,9,'Federación'),(1094,9,'Federal'),(1095,9,'Gdor. Echagüe'),(1096,9,'Gdor. Mansilla'),(1097,9,'Gilbert'),(1098,9,'González Calderón'),(1099,9,'Gral. Almada'),(1100,9,'Gral. Alvear'),(1101,9,'Gral. Campos'),(1102,9,'Gral. Galarza'),(1103,9,'Gral. Ramírez'),(1104,9,'Gualeguay'),(1105,9,'Gualeguaychú'),(1106,9,'Gualeguaycito'),(1107,9,'Guardamonte'),(1108,9,'Hambis'),(1109,9,'Hasenkamp'),(1110,9,'Hernandarias'),(1111,9,'Hernández'),(1112,9,'Herrera'),(1113,9,'Hinojal'),(1114,9,'Hocker'),(1115,9,'Ing. Sajaroff'),(1116,9,'Irazusta'),(1117,9,'Isletas'),(1118,9,'J.J De Urquiza'),(1119,9,'Jubileo'),(1120,9,'La Clarita'),(1121,9,'La Criolla'),(1122,9,'La Esmeralda'),(1123,9,'La Florida'),(1124,9,'La Fraternidad'),(1125,9,'La Hierra'),(1126,9,'La Ollita'),(1127,9,'La Paz'),(1128,9,'La Picada'),(1129,9,'La Providencia'),(1130,9,'La Verbena'),(1131,9,'Laguna Benítez'),(1132,9,'Larroque'),(1133,9,'Las Cuevas'),(1134,9,'Las Garzas'),(1135,9,'Las Guachas'),(1136,9,'Las Mercedes'),(1137,9,'Las Moscas'),(1138,9,'Las Mulitas'),(1139,9,'Las Toscas'),(1140,9,'Laurencena'),(1141,9,'Libertador San Martín'),(1142,9,'Loma Limpia'),(1143,9,'Los Ceibos'),(1144,9,'Los Charruas'),(1145,9,'Los Conquistadores'),(1146,9,'Lucas González'),(1147,9,'Lucas N.'),(1148,9,'Lucas S. 1ª'),(1149,9,'Lucas S. 2ª'),(1150,9,'Maciá'),(1151,9,'María Grande'),(1152,9,'María Grande 2ª'),(1153,9,'Médanos'),(1154,9,'Mojones N.'),(1155,9,'Mojones S.'),(1156,9,'Molino Doll'),(1157,9,'Monte Redondo'),(1158,9,'Montoya'),(1159,9,'Mulas Grandes'),(1160,9,'Ñancay'),(1161,9,'Nogoyá'),(1162,9,'Nueva Escocia'),(1163,9,'Nueva Vizcaya'),(1164,9,'Ombú'),(1165,9,'Oro Verde'),(1166,9,'Paraná'),(1167,9,'Pasaje Guayaquil'),(1168,9,'Pasaje Las Tunas'),(1169,9,'Paso de La Arena'),(1170,9,'Paso de La Laguna'),(1171,9,'Paso de Las Piedras'),(1172,9,'Paso Duarte'),(1173,9,'Pastor Britos'),(1174,9,'Pedernal'),(1175,9,'Perdices'),(1176,9,'Picada Berón'),(1177,9,'Piedras Blancas'),(1178,9,'Primer Distrito Cuchilla'),(1179,9,'Primero de Mayo'),(1180,9,'Pronunciamiento'),(1181,9,'Pto. Algarrobo'),(1182,9,'Pto. Ibicuy'),(1183,9,'Pueblo Brugo'),(1184,9,'Pueblo Cazes'),(1185,9,'Pueblo Gral. Belgrano'),(1186,9,'Pueblo Liebig'),(1187,9,'Puerto Yeruá'),(1188,9,'Punta del Monte'),(1189,9,'Quebracho'),(1190,9,'Quinto Distrito'),(1191,9,'Raices Oeste'),(1192,9,'Rincón de Nogoyá'),(1193,9,'Rincón del Cinto'),(1194,9,'Rincón del Doll'),(1195,9,'Rincón del Gato'),(1196,9,'Rocamora'),(1197,9,'Rosario del Tala'),(1198,9,'San Benito'),(1199,9,'San Cipriano'),(1200,9,'San Ernesto'),(1201,9,'San Gustavo'),(1202,9,'San Jaime'),(1203,9,'San José'),(1204,9,'San José de Feliciano'),(1205,9,'San Justo'),(1206,9,'San Marcial'),(1207,9,'San Pedro'),(1208,9,'San Ramírez'),(1209,9,'San Ramón'),(1210,9,'San Roque'),(1211,9,'San Salvador'),(1212,9,'San Víctor'),(1213,9,'Santa Ana'),(1214,9,'Santa Anita'),(1215,9,'Santa Elena'),(1216,9,'Santa Lucía'),(1217,9,'Santa Luisa'),(1218,9,'Sauce de Luna'),(1219,9,'Sauce Montrull'),(1220,9,'Sauce Pinto'),(1221,9,'Sauce Sur'),(1222,9,'Seguí'),(1223,9,'Sir Leonard'),(1224,9,'Sosa'),(1225,9,'Tabossi'),(1226,9,'Tezanos Pinto'),(1227,9,'Ubajay'),(1228,9,'Urdinarrain'),(1229,9,'Veinte de Septiembre'),(1230,9,'Viale'),(1231,9,'Victoria'),(1232,9,'Villa Clara'),(1233,9,'Villa del Rosario'),(1234,9,'Villa Domínguez'),(1235,9,'Villa Elisa'),(1236,9,'Villa Fontana'),(1237,9,'Villa Gdor. Etchevehere'),(1238,9,'Villa Mantero'),(1239,9,'Villa Paranacito'),(1240,9,'Villa Urquiza'),(1241,9,'Villaguay'),(1242,9,'Walter Moss'),(1243,9,'Yacaré'),(1244,9,'Yeso Oeste'),(1245,10,'Buena Vista'),(1246,10,'Clorinda'),(1247,10,'Col. Pastoril'),(1248,10,'Cte. Fontana'),(1249,10,'El Colorado'),(1250,10,'El Espinillo'),(1251,10,'Estanislao Del Campo'),(1252,10,'10'),(1253,10,'Fortín Lugones'),(1254,10,'Gral. Lucio V. Mansilla'),(1255,10,'Gral. Manuel Belgrano'),(1256,10,'Gral. Mosconi'),(1257,10,'Gran Guardia'),(1258,10,'Herradura'),(1259,10,'Ibarreta'),(1260,10,'Ing. Juárez'),(1261,10,'Laguna Blanca'),(1262,10,'Laguna Naick Neck'),(1263,10,'Laguna Yema'),(1264,10,'Las Lomitas'),(1265,10,'Los Chiriguanos'),(1266,10,'Mayor V. Villafañe'),(1267,10,'Misión San Fco.'),(1268,10,'Palo Santo'),(1269,10,'Pirané'),(1270,10,'Pozo del Maza'),(1271,10,'Riacho He-He'),(1272,10,'San Hilario'),(1273,10,'San Martín II'),(1274,10,'Siete Palmas'),(1275,10,'Subteniente Perín'),(1276,10,'Tres Lagunas'),(1277,10,'Villa Dos Trece'),(1278,10,'Villa Escolar'),(1279,10,'Villa Gral. Güemes'),(1280,11,'Abdon Castro Tolay'),(1281,11,'Abra Pampa'),(1282,11,'Abralaite'),(1283,11,'Aguas Calientes'),(1284,11,'Arrayanal'),(1285,11,'Barrios'),(1286,11,'Caimancito'),(1287,11,'Calilegua'),(1288,11,'Cangrejillos'),(1289,11,'Caspala'),(1290,11,'Catuá'),(1291,11,'Cieneguillas'),(1292,11,'Coranzulli'),(1293,11,'Cusi-Cusi'),(1294,11,'El Aguilar'),(1295,11,'El Carmen'),(1296,11,'El Cóndor'),(1297,11,'El Fuerte'),(1298,11,'El Piquete'),(1299,11,'El Talar'),(1300,11,'Fraile Pintado'),(1301,11,'Hipólito Yrigoyen'),(1302,11,'Huacalera'),(1303,11,'Humahuaca'),(1304,11,'La Esperanza'),(1305,11,'La Mendieta'),(1306,11,'La Quiaca'),(1307,11,'Ledesma'),(1308,11,'Libertador Gral. San Martin'),(1309,11,'Maimara'),(1310,11,'Mina Pirquitas'),(1311,11,'Monterrico'),(1312,11,'Palma Sola'),(1313,11,'Palpalá'),(1314,11,'Pampa Blanca'),(1315,11,'Pampichuela'),(1316,11,'Perico'),(1317,11,'Puesto del Marqués'),(1318,11,'Puesto Viejo'),(1319,11,'Pumahuasi'),(1320,11,'Purmamarca'),(1321,11,'Rinconada'),(1322,11,'Rodeitos'),(1323,11,'Rosario de Río Grande'),(1324,11,'San Antonio'),(1325,11,'San Francisco'),(1326,11,'San Pedro'),(1327,11,'San Rafael'),(1328,11,'San Salvador'),(1329,11,'Santa Ana'),(1330,11,'Santa Catalina'),(1331,11,'Santa Clara'),(1332,11,'Susques'),(1333,11,'Tilcara'),(1334,11,'Tres Cruces'),(1335,11,'Tumbaya'),(1336,11,'Valle Grande'),(1337,11,'Vinalito'),(1338,11,'Volcán'),(1339,11,'Yala'),(1340,11,'Yaví'),(1341,11,'Yuto'),(1342,12,'Abramo'),(1343,12,'Adolfo Van Praet'),(1344,12,'Agustoni'),(1345,12,'Algarrobo del Aguila'),(1346,12,'Alpachiri'),(1347,12,'Alta Italia'),(1348,12,'Anguil'),(1349,12,'Arata'),(1350,12,'Ataliva Roca'),(1351,12,'Bernardo Larroude'),(1352,12,'Bernasconi'),(1353,12,'Caleufú'),(1354,12,'Carro Quemado'),(1355,12,'Catriló'),(1356,12,'Ceballos'),(1357,12,'Chacharramendi'),(1358,12,'Col. Barón'),(1359,12,'Col. Santa María'),(1360,12,'Conhelo'),(1361,12,'Coronel Hilario Lagos'),(1362,12,'Cuchillo-Có'),(1363,12,'Doblas'),(1364,12,'Dorila'),(1365,12,'Eduardo Castex'),(1366,12,'Embajador Martini'),(1367,12,'Falucho'),(1368,12,'Gral. Acha'),(1369,12,'Gral. Manuel Campos'),(1370,12,'Gral. Pico'),(1371,12,'Guatraché'),(1372,12,'Ing. Luiggi'),(1373,12,'Intendente Alvear'),(1374,12,'Jacinto Arauz'),(1375,12,'La Adela'),(1376,12,'La Humada'),(1377,12,'La Maruja'),(1378,12,'12'),(1379,12,'La Reforma'),(1380,12,'Limay Mahuida'),(1381,12,'Lonquimay'),(1382,12,'Loventuel'),(1383,12,'Luan Toro'),(1384,12,'Macachín'),(1385,12,'Maisonnave'),(1386,12,'Mauricio Mayer'),(1387,12,'Metileo'),(1388,12,'Miguel Cané'),(1389,12,'Miguel Riglos'),(1390,12,'Monte Nievas'),(1391,12,'Parera'),(1392,12,'Perú'),(1393,12,'Pichi-Huinca'),(1394,12,'Puelches'),(1395,12,'Puelén'),(1396,12,'Quehue'),(1397,12,'Quemú Quemú'),(1398,12,'Quetrequén'),(1399,12,'Rancul'),(1400,12,'Realicó'),(1401,12,'Relmo'),(1402,12,'Rolón'),(1403,12,'Rucanelo'),(1404,12,'Sarah'),(1405,12,'Speluzzi'),(1406,12,'Sta. Isabel'),(1407,12,'Sta. Rosa'),(1408,12,'Sta. Teresa'),(1409,12,'Telén'),(1410,12,'Toay'),(1411,12,'Tomas M. de Anchorena'),(1412,12,'Trenel'),(1413,12,'Unanue'),(1414,12,'Uriburu'),(1415,12,'Veinticinco de Mayo'),(1416,12,'Vertiz'),(1417,12,'Victorica'),(1418,12,'Villa Mirasol'),(1419,12,'Winifreda'),(1420,13,'Arauco'),(1421,13,'Capital'),(1422,13,'Castro Barros'),(1423,13,'Chamical'),(1424,13,'Chilecito'),(1425,13,'Coronel F. Varela'),(1426,13,'Famatina'),(1427,13,'Gral. A.V.Peñaloza'),(1428,13,'Gral. Belgrano'),(1429,13,'Gral. J.F. Quiroga'),(1430,13,'Gral. Lamadrid'),(1431,13,'Gral. Ocampo'),(1432,13,'Gral. San Martín'),(1433,13,'Independencia'),(1434,13,'Rosario Penaloza'),(1435,13,'San Blas de Los Sauces'),(1436,13,'Sanagasta'),(1437,13,'Vinchina'),(1438,14,'Capital'),(1439,14,'Chacras de Coria'),(1440,14,'Dorrego'),(1441,14,'Gllen'),(1442,14,'Godoy Cruz'),(1443,14,'Gral. Alvear'),(1444,14,'Guaymallén'),(1445,14,'Junín'),(1446,14,'La Paz'),(1447,14,'Las Heras'),(1448,14,'Lavalle'),(1449,14,'Luján'),(1450,14,'Luján De Cuyo'),(1451,14,'Maipú'),(1452,14,'Malargüe'),(1453,14,'Rivadavia'),(1454,14,'San Carlos'),(1455,14,'San Martín'),(1456,14,'San Rafael'),(1457,14,'Sta. Rosa'),(1458,14,'Tunuyán'),(1459,14,'Tupungato'),(1460,14,'Villa Nueva'),(1461,15,'Alba Posse'),(1462,15,'Almafuerte'),(1463,15,'Apóstoles'),(1464,15,'Aristóbulo Del Valle'),(1465,15,'Arroyo Del Medio'),(1466,15,'Azara'),(1467,15,'Bdo. De Irigoyen'),(1468,15,'Bonpland'),(1469,15,'Caá Yari'),(1470,15,'Campo Grande'),(1471,15,'Campo Ramón'),(1472,15,'Campo Viera'),(1473,15,'Candelaria'),(1474,15,'Capioví'),(1475,15,'Caraguatay'),(1476,15,'Cdte. Guacurarí'),(1477,15,'Cerro Azul'),(1478,15,'Cerro Corá'),(1479,15,'Col. Alberdi'),(1480,15,'Col. Aurora'),(1481,15,'Col. Delicia'),(1482,15,'Col. Polana'),(1483,15,'Col. Victoria'),(1484,15,'Col. Wanda'),(1485,15,'Concepción De La Sierra'),(1486,15,'Corpus'),(1487,15,'Dos Arroyos'),(1488,15,'Dos de Mayo'),(1489,15,'El Alcázar'),(1490,15,'El Dorado'),(1491,15,'El Soberbio'),(1492,15,'Esperanza'),(1493,15,'F. Ameghino'),(1494,15,'Fachinal'),(1495,15,'Garuhapé'),(1496,15,'Garupá'),(1497,15,'Gdor. López'),(1498,15,'Gdor. Roca'),(1499,15,'Gral. Alvear'),(1500,15,'Gral. Urquiza'),(1501,15,'Guaraní'),(1502,15,'H. Yrigoyen'),(1503,15,'Iguazú'),(1504,15,'Itacaruaré'),(1505,15,'Jardín América'),(1506,15,'Leandro N. Alem'),(1507,15,'Libertad'),(1508,15,'Loreto'),(1509,15,'Los Helechos'),(1510,15,'Mártires'),(1511,15,'15'),(1512,15,'Mojón Grande'),(1513,15,'Montecarlo'),(1514,15,'Nueve de Julio'),(1515,15,'Oberá'),(1516,15,'Olegario V. Andrade'),(1517,15,'Panambí'),(1518,15,'Posadas'),(1519,15,'Profundidad'),(1520,15,'Pto. Iguazú'),(1521,15,'Pto. Leoni'),(1522,15,'Pto. Piray'),(1523,15,'Pto. Rico'),(1524,15,'Ruiz de Montoya'),(1525,15,'San Antonio'),(1526,15,'San Ignacio'),(1527,15,'San Javier'),(1528,15,'San José'),(1529,15,'San Martín'),(1530,15,'San Pedro'),(1531,15,'San Vicente'),(1532,15,'Santiago De Liniers'),(1533,15,'Santo Pipo'),(1534,15,'Sta. Ana'),(1535,15,'Sta. María'),(1536,15,'Tres Capones'),(1537,15,'Veinticinco de Mayo'),(1538,15,'Wanda'),(1539,16,'Aguada San Roque'),(1540,16,'Aluminé'),(1541,16,'Andacollo'),(1542,16,'Añelo'),(1543,16,'Bajada del Agrio'),(1544,16,'Barrancas'),(1545,16,'Buta Ranquil'),(1546,16,'Capital'),(1547,16,'Caviahué'),(1548,16,'Centenario'),(1549,16,'Chorriaca'),(1550,16,'Chos Malal'),(1551,16,'Cipolletti'),(1552,16,'Covunco Abajo'),(1553,16,'Coyuco Cochico'),(1554,16,'Cutral Có'),(1555,16,'El Cholar'),(1556,16,'El Huecú'),(1557,16,'El Sauce'),(1558,16,'Guañacos'),(1559,16,'Huinganco'),(1560,16,'Las Coloradas'),(1561,16,'Las Lajas'),(1562,16,'Las Ovejas'),(1563,16,'Loncopué'),(1564,16,'Los Catutos'),(1565,16,'Los Chihuidos'),(1566,16,'Los Miches'),(1567,16,'Manzano Amargo'),(1568,16,'16'),(1569,16,'Octavio Pico'),(1570,16,'Paso Aguerre'),(1571,16,'Picún Leufú'),(1572,16,'Piedra del Aguila'),(1573,16,'Pilo Lil'),(1574,16,'Plaza Huincul'),(1575,16,'Plottier'),(1576,16,'Quili Malal'),(1577,16,'Ramón Castro'),(1578,16,'Rincón de Los Sauces'),(1579,16,'San Martín de Los Andes'),(1580,16,'San Patricio del Chañar'),(1581,16,'Santo Tomás'),(1582,16,'Sauzal Bonito'),(1583,16,'Senillosa'),(1584,16,'Taquimilán'),(1585,16,'Tricao Malal'),(1586,16,'Varvarco'),(1587,16,'Villa Curí Leuvu'),(1588,16,'Villa del Nahueve'),(1589,16,'Villa del Puente Picún Leuvú'),(1590,16,'Villa El Chocón'),(1591,16,'Villa La Angostura'),(1592,16,'Villa Pehuenia'),(1593,16,'Villa Traful'),(1594,16,'Vista Alegre'),(1595,16,'Zapala'),(1596,17,'Aguada Cecilio'),(1597,17,'Aguada de Guerra'),(1598,17,'Allén'),(1599,17,'Arroyo de La Ventana'),(1600,17,'Arroyo Los Berros'),(1601,17,'Bariloche'),(1602,17,'Calte. Cordero'),(1603,17,'Campo Grande'),(1604,17,'Catriel'),(1605,17,'Cerro Policía'),(1606,17,'Cervantes'),(1607,17,'Chelforo'),(1608,17,'Chimpay'),(1609,17,'Chinchinales'),(1610,17,'Chipauquil'),(1611,17,'Choele Choel'),(1612,17,'Cinco Saltos'),(1613,17,'Cipolletti'),(1614,17,'Clemente Onelli'),(1615,17,'Colán Conhue'),(1616,17,'Comallo'),(1617,17,'Comicó'),(1618,17,'Cona Niyeu'),(1619,17,'Coronel Belisle'),(1620,17,'Cubanea'),(1621,17,'Darwin'),(1622,17,'Dina Huapi'),(1623,17,'El Bolsón'),(1624,17,'El Caín'),(1625,17,'El Manso'),(1626,17,'Gral. Conesa'),(1627,17,'Gral. Enrique Godoy'),(1628,17,'Gral. Fernandez Oro'),(1629,17,'Gral. Roca'),(1630,17,'Guardia Mitre'),(1631,17,'Ing. Huergo'),(1632,17,'Ing. Jacobacci'),(1633,17,'Laguna Blanca'),(1634,17,'Lamarque'),(1635,17,'Las Grutas'),(1636,17,'Los Menucos'),(1637,17,'Luis Beltrán'),(1638,17,'Mainqué'),(1639,17,'Mamuel Choique'),(1640,17,'Maquinchao'),(1641,17,'Mencué'),(1642,17,'Mtro. Ramos Mexia'),(1643,17,'Nahuel Niyeu'),(1644,17,'Naupa Huen'),(1645,17,'Ñorquinco'),(1646,17,'Ojos de Agua'),(1647,17,'Paso de Agua'),(1648,17,'Paso Flores'),(1649,17,'Peñas Blancas'),(1650,17,'Pichi Mahuida'),(1651,17,'Pilcaniyeu'),(1652,17,'Pomona'),(1653,17,'Prahuaniyeu'),(1654,17,'Rincón Treneta'),(1655,17,'Río Chico'),(1656,17,'Río Colorado'),(1657,17,'Roca'),(1658,17,'San Antonio Oeste'),(1659,17,'San Javier'),(1660,17,'Sierra Colorada'),(1661,17,'Sierra Grande'),(1662,17,'Sierra Pailemán'),(1663,17,'Valcheta'),(1664,17,'Valle Azul'),(1665,17,'Viedma'),(1666,17,'Villa Llanquín'),(1667,17,'Villa Mascardi'),(1668,17,'Villa Regina'),(1669,17,'Yaminué'),(1670,18,'A. Saravia'),(1671,18,'Aguaray'),(1672,18,'Angastaco'),(1673,18,'Animaná'),(1674,18,'Cachi'),(1675,18,'Cafayate'),(1676,18,'Campo Quijano'),(1677,18,'Campo Santo'),(1678,18,'Capital'),(1679,18,'Cerrillos'),(1680,18,'Chicoana'),(1681,18,'Col. Sta. Rosa'),(1682,18,'Coronel Moldes'),(1683,18,'El Bordo'),(1684,18,'El Carril'),(1685,18,'El Galpón'),(1686,18,'El Jardín'),(1687,18,'El Potrero'),(1688,18,'El Quebrachal'),(1689,18,'El Tala'),(1690,18,'Embarcación'),(1691,18,'Gral. Ballivian'),(1692,18,'Gral. Güemes'),(1693,18,'Gral. Mosconi'),(1694,18,'Gral. Pizarro'),(1695,18,'Guachipas'),(1696,18,'Hipólito Yrigoyen'),(1697,18,'Iruyá'),(1698,18,'Isla De Cañas'),(1699,18,'J. V. Gonzalez'),(1700,18,'La Caldera'),(1701,18,'La Candelaria'),(1702,18,'La Merced'),(1703,18,'La Poma'),(1704,18,'La Viña'),(1705,18,'Las Lajitas'),(1706,18,'Los Toldos'),(1707,18,'Metán'),(1708,18,'Molinos'),(1709,18,'Nazareno'),(1710,18,'Orán'),(1711,18,'Payogasta'),(1712,18,'Pichanal'),(1713,18,'Prof. S. Mazza'),(1714,18,'Río Piedras'),(1715,18,'Rivadavia Banda Norte'),(1716,18,'Rivadavia Banda Sur'),(1717,18,'Rosario de La Frontera'),(1718,18,'Rosario de Lerma'),(1719,18,'Saclantás'),(1720,18,'18'),(1721,18,'San Antonio'),(1722,18,'San Carlos'),(1723,18,'San José De Metán'),(1724,18,'San Ramón'),(1725,18,'Santa Victoria E.'),(1726,18,'Santa Victoria O.'),(1727,18,'Tartagal'),(1728,18,'Tolar Grande'),(1729,18,'Urundel'),(1730,18,'Vaqueros'),(1731,18,'Villa San Lorenzo'),(1732,19,'Albardón'),(1733,19,'Angaco'),(1734,19,'Calingasta'),(1735,19,'Capital'),(1736,19,'Caucete'),(1737,19,'Chimbas'),(1738,19,'Iglesia'),(1739,19,'Jachal'),(1740,19,'Nueve de Julio'),(1741,19,'Pocito'),(1742,19,'Rawson'),(1743,19,'Rivadavia'),(1744,19,'19'),(1745,19,'San Martín'),(1746,19,'Santa Lucía'),(1747,19,'Sarmiento'),(1748,19,'Ullum'),(1749,19,'Valle Fértil'),(1750,19,'Veinticinco de Mayo'),(1751,19,'Zonda'),(1752,20,'Alto Pelado'),(1753,20,'Alto Pencoso'),(1754,20,'Anchorena'),(1755,20,'Arizona'),(1756,20,'Bagual'),(1757,20,'Balde'),(1758,20,'Batavia'),(1759,20,'Beazley'),(1760,20,'Buena Esperanza'),(1761,20,'Candelaria'),(1762,20,'Capital'),(1763,20,'Carolina'),(1764,20,'Carpintería'),(1765,20,'Concarán'),(1766,20,'Cortaderas'),(1767,20,'El Morro'),(1768,20,'El Trapiche'),(1769,20,'El Volcán'),(1770,20,'Fortín El Patria'),(1771,20,'Fortuna'),(1772,20,'Fraga'),(1773,20,'Juan Jorba'),(1774,20,'Juan Llerena'),(1775,20,'Juana Koslay'),(1776,20,'Justo Daract'),(1777,20,'La Calera'),(1778,20,'La Florida'),(1779,20,'La Punilla'),(1780,20,'La Toma'),(1781,20,'Lafinur'),(1782,20,'Las Aguadas'),(1783,20,'Las Chacras'),(1784,20,'Las Lagunas'),(1785,20,'Las Vertientes'),(1786,20,'Lavaisse'),(1787,20,'Leandro N. Alem'),(1788,20,'Los Molles'),(1789,20,'Luján'),(1790,20,'Mercedes'),(1791,20,'Merlo'),(1792,20,'Naschel'),(1793,20,'Navia'),(1794,20,'Nogolí'),(1795,20,'Nueva Galia'),(1796,20,'Papagayos'),(1797,20,'Paso Grande'),(1798,20,'Potrero de Los Funes'),(1799,20,'Quines'),(1800,20,'Renca'),(1801,20,'Saladillo'),(1802,20,'San Francisco'),(1803,20,'San Gerónimo'),(1804,20,'San Martín'),(1805,20,'San Pablo'),(1806,20,'Santa Rosa de Conlara'),(1807,20,'Talita'),(1808,20,'Tilisarao'),(1809,20,'Unión'),(1810,20,'Villa de La Quebrada'),(1811,20,'Villa de Praga'),(1812,20,'Villa del Carmen'),(1813,20,'Villa Gral. Roca'),(1814,20,'Villa Larca'),(1815,20,'Villa Mercedes'),(1816,20,'Zanjitas'),(1817,21,'Calafate'),(1818,21,'Caleta Olivia'),(1819,21,'Cañadón Seco'),(1820,21,'Comandante Piedrabuena'),(1821,21,'El Calafate'),(1822,21,'El Chaltén'),(1823,21,'Gdor. Gregores'),(1824,21,'Hipólito Yrigoyen'),(1825,21,'Jaramillo'),(1826,21,'Koluel Kaike'),(1827,21,'Las Heras'),(1828,21,'Los Antiguos'),(1829,21,'Perito Moreno'),(1830,21,'Pico Truncado'),(1831,21,'Pto. Deseado'),(1832,21,'Pto. San Julián'),(1833,21,'Pto. 21'),(1834,21,'Río Cuarto'),(1835,21,'Río Gallegos'),(1836,21,'Río Turbio'),(1837,21,'Tres Lagos'),(1838,21,'Veintiocho De Noviembre'),(1839,22,'Aarón Castellanos'),(1840,22,'Acebal'),(1841,22,'Aguará Grande'),(1842,22,'Albarellos'),(1843,22,'Alcorta'),(1844,22,'Aldao'),(1845,22,'Alejandra'),(1846,22,'Álvarez'),(1847,22,'Ambrosetti'),(1848,22,'Amenábar'),(1849,22,'Angélica'),(1850,22,'Angeloni'),(1851,22,'Arequito'),(1852,22,'Arminda'),(1853,22,'Armstrong'),(1854,22,'Arocena'),(1855,22,'Arroyo Aguiar'),(1856,22,'Arroyo Ceibal'),(1857,22,'Arroyo Leyes'),(1858,22,'Arroyo Seco'),(1859,22,'Arrufó'),(1860,22,'Arteaga'),(1861,22,'Ataliva'),(1862,22,'Aurelia'),(1863,22,'Avellaneda'),(1864,22,'Barrancas'),(1865,22,'Bauer Y Sigel'),(1866,22,'Bella Italia'),(1867,22,'Berabevú'),(1868,22,'Berna'),(1869,22,'Bernardo de Irigoyen'),(1870,22,'Bigand'),(1871,22,'Bombal'),(1872,22,'Bouquet'),(1873,22,'Bustinza'),(1874,22,'Cabal'),(1875,22,'Cacique Ariacaiquin'),(1876,22,'Cafferata'),(1877,22,'Calchaquí'),(1878,22,'Campo Andino'),(1879,22,'Campo Piaggio'),(1880,22,'Cañada de Gómez'),(1881,22,'Cañada del Ucle'),(1882,22,'Cañada Rica'),(1883,22,'Cañada Rosquín'),(1884,22,'Candioti'),(1885,22,'Capital'),(1886,22,'Capitán Bermúdez'),(1887,22,'Capivara'),(1888,22,'Carcarañá'),(1889,22,'Carlos Pellegrini'),(1890,22,'Carmen'),(1891,22,'Carmen Del Sauce'),(1892,22,'Carreras'),(1893,22,'Carrizales'),(1894,22,'Casalegno'),(1895,22,'Casas'),(1896,22,'Casilda'),(1897,22,'Castelar'),(1898,22,'Castellanos'),(1899,22,'Cayastá'),(1900,22,'Cayastacito'),(1901,22,'Centeno'),(1902,22,'Cepeda'),(1903,22,'Ceres'),(1904,22,'Chabás'),(1905,22,'Chañar Ladeado'),(1906,22,'Chapuy'),(1907,22,'Chovet'),(1908,22,'Christophersen'),(1909,22,'Classon'),(1910,22,'Cnel. Arnold'),(1911,22,'Cnel. Bogado'),(1912,22,'Cnel. Dominguez'),(1913,22,'Cnel. Fraga'),(1914,22,'Col. Aldao'),(1915,22,'Col. Ana'),(1916,22,'Col. Belgrano'),(1917,22,'Col. Bicha'),(1918,22,'Col. Bigand'),(1919,22,'Col. Bossi'),(1920,22,'Col. Cavour'),(1921,22,'Col. Cello'),(1922,22,'Col. Dolores'),(1923,22,'Col. Dos Rosas'),(1924,22,'Col. Durán'),(1925,22,'Col. Iturraspe'),(1926,22,'Col. Margarita'),(1927,22,'Col. Mascias'),(1928,22,'Col. Raquel'),(1929,22,'Col. Rosa'),(1930,22,'Col. San José'),(1931,22,'Constanza'),(1932,22,'Coronda'),(1933,22,'Correa'),(1934,22,'Crispi'),(1935,22,'Cululú'),(1936,22,'Curupayti'),(1937,22,'Desvio Arijón'),(1938,22,'Diaz'),(1939,22,'Diego de Alvear'),(1940,22,'Egusquiza'),(1941,22,'El Arazá'),(1942,22,'El Rabón'),(1943,22,'El Sombrerito'),(1944,22,'El Trébol'),(1945,22,'Elisa'),(1946,22,'Elortondo'),(1947,22,'Emilia'),(1948,22,'Empalme San Carlos'),(1949,22,'Empalme Villa Constitucion'),(1950,22,'Esmeralda'),(1951,22,'Esperanza'),(1952,22,'Estación Alvear'),(1953,22,'Estacion Clucellas'),(1954,22,'Esteban Rams'),(1955,22,'Esther'),(1956,22,'Esustolia'),(1957,22,'Eusebia'),(1958,22,'Felicia'),(1959,22,'Fidela'),(1960,22,'Fighiera'),(1961,22,'Firmat'),(1962,22,'Florencia'),(1963,22,'Fortín Olmos'),(1964,22,'Franck'),(1965,22,'Fray Luis Beltrán'),(1966,22,'Frontera'),(1967,22,'Fuentes'),(1968,22,'Funes'),(1969,22,'Gaboto'),(1970,22,'Galisteo'),(1971,22,'Gálvez'),(1972,22,'Garabalto'),(1973,22,'Garibaldi'),(1974,22,'Gato Colorado'),(1975,22,'Gdor. Crespo'),(1976,22,'Gessler'),(1977,22,'Godoy'),(1978,22,'Golondrina'),(1979,22,'Gral. Gelly'),(1980,22,'Gral. Lagos'),(1981,22,'Granadero Baigorria'),(1982,22,'Gregoria Perez De Denis'),(1983,22,'Grutly'),(1984,22,'Guadalupe N.'),(1985,22,'Gödeken'),(1986,22,'Helvecia'),(1987,22,'Hersilia'),(1988,22,'Hipatía'),(1989,22,'Huanqueros'),(1990,22,'Hugentobler'),(1991,22,'Hughes'),(1992,22,'Humberto 1º'),(1993,22,'Humboldt'),(1994,22,'Ibarlucea'),(1995,22,'Ing. Chanourdie'),(1996,22,'Intiyaco'),(1997,22,'Ituzaingó'),(1998,22,'Jacinto L. Aráuz'),(1999,22,'Josefina'),(2000,22,'Juan B. Molina'),(2001,22,'Juan de Garay'),(2002,22,'Juncal'),(2003,22,'La Brava'),(2004,22,'La Cabral'),(2005,22,'La Camila'),(2006,22,'La Chispa'),(2007,22,'La Clara'),(2008,22,'La Criolla'),(2009,22,'La Gallareta'),(2010,22,'La Lucila'),(2011,22,'La Pelada'),(2012,22,'La Penca'),(2013,22,'La Rubia'),(2014,22,'La Sarita'),(2015,22,'La Vanguardia'),(2016,22,'Labordeboy'),(2017,22,'Laguna Paiva'),(2018,22,'Landeta'),(2019,22,'Lanteri'),(2020,22,'Larrechea'),(2021,22,'Las Avispas'),(2022,22,'Las Bandurrias'),(2023,22,'Las Garzas'),(2024,22,'Las Palmeras'),(2025,22,'Las Parejas'),(2026,22,'Las Petacas'),(2027,22,'Las Rosas'),(2028,22,'Las Toscas'),(2029,22,'Las Tunas'),(2030,22,'Lazzarino'),(2031,22,'Lehmann'),(2032,22,'Llambi Campbell'),(2033,22,'Logroño'),(2034,22,'Loma Alta'),(2035,22,'López'),(2036,22,'Los Amores'),(2037,22,'Los Cardos'),(2038,22,'Los Laureles'),(2039,22,'Los Molinos'),(2040,22,'Los Quirquinchos'),(2041,22,'Lucio V. Lopez'),(2042,22,'Luis Palacios'),(2043,22,'Ma. Juana'),(2044,22,'Ma. Luisa'),(2045,22,'Ma. Susana'),(2046,22,'Ma. Teresa'),(2047,22,'Maciel'),(2048,22,'Maggiolo'),(2049,22,'Malabrigo'),(2050,22,'Marcelino Escalada'),(2051,22,'Margarita'),(2052,22,'Matilde'),(2053,22,'Mauá'),(2054,22,'Máximo Paz'),(2055,22,'Melincué'),(2056,22,'Miguel Torres'),(2057,22,'Moisés Ville'),(2058,22,'Monigotes'),(2059,22,'Monje'),(2060,22,'Monte Obscuridad'),(2061,22,'Monte Vera'),(2062,22,'Montefiore'),(2063,22,'Montes de Oca'),(2064,22,'Murphy'),(2065,22,'Ñanducita'),(2066,22,'Naré'),(2067,22,'Nelson'),(2068,22,'Nicanor E. Molinas'),(2069,22,'Nuevo Torino'),(2070,22,'Oliveros'),(2071,22,'Palacios'),(2072,22,'Pavón'),(2073,22,'Pavón Arriba'),(2074,22,'Pedro Gómez Cello'),(2075,22,'Pérez'),(2076,22,'Peyrano'),(2077,22,'Piamonte'),(2078,22,'Pilar'),(2079,22,'Piñero'),(2080,22,'Plaza Clucellas'),(2081,22,'Portugalete'),(2082,22,'Pozo Borrado'),(2083,22,'Progreso'),(2084,22,'Providencia'),(2085,22,'Pte. Roca'),(2086,22,'Pueblo Andino'),(2087,22,'Pueblo Esther'),(2088,22,'Pueblo Gral. San Martín'),(2089,22,'Pueblo Irigoyen'),(2090,22,'Pueblo Marini'),(2091,22,'Pueblo Muñoz'),(2092,22,'Pueblo Uranga'),(2093,22,'Pujato'),(2094,22,'Pujato N.'),(2095,22,'Rafaela'),(2096,22,'Ramayón'),(2097,22,'Ramona'),(2098,22,'Reconquista'),(2099,22,'Recreo'),(2100,22,'Ricardone'),(2101,22,'Rivadavia'),(2102,22,'Roldán'),(2103,22,'Romang'),(2104,22,'Rosario'),(2105,22,'Rueda'),(2106,22,'Rufino'),(2107,22,'Sa Pereira'),(2108,22,'Saguier'),(2109,22,'Saladero M. Cabal'),(2110,22,'Salto Grande'),(2111,22,'San Agustín'),(2112,22,'San Antonio de Obligado'),(2113,22,'San Bernardo (N.J.)'),(2114,22,'San Bernardo (S.J.)'),(2115,22,'San Carlos Centro'),(2116,22,'San Carlos N.'),(2117,22,'San Carlos S.'),(2118,22,'San Cristóbal'),(2119,22,'San Eduardo'),(2120,22,'San Eugenio'),(2121,22,'San Fabián'),(2122,22,'San Fco. de Santa Fé'),(2123,22,'San Genaro'),(2124,22,'San Genaro N.'),(2125,22,'San Gregorio'),(2126,22,'San Guillermo'),(2127,22,'San Javier'),(2128,22,'San Jerónimo del Sauce'),(2129,22,'San Jerónimo N.'),(2130,22,'San Jerónimo S.'),(2131,22,'San Jorge'),(2132,22,'San José de La Esquina'),(2133,22,'San José del Rincón'),(2134,22,'San Justo'),(2135,22,'San Lorenzo'),(2136,22,'San Mariano'),(2137,22,'San Martín de Las Escobas'),(2138,22,'San Martín N.'),(2139,22,'San Vicente'),(2140,22,'Sancti Spititu'),(2141,22,'Sanford'),(2142,22,'Santo Domingo'),(2143,22,'Santo Tomé'),(2144,22,'Santurce'),(2145,22,'Sargento Cabral'),(2146,22,'Sarmiento'),(2147,22,'Sastre'),(2148,22,'Sauce Viejo'),(2149,22,'Serodino'),(2150,22,'Silva'),(2151,22,'Soldini'),(2152,22,'Soledad'),(2153,22,'Soutomayor'),(2154,22,'Sta. Clara de Buena Vista'),(2155,22,'Sta. Clara de Saguier'),(2156,22,'Sta. Isabel'),(2157,22,'Sta. Margarita'),(2158,22,'Sta. Maria Centro'),(2159,22,'Sta. María N.'),(2160,22,'Sta. Rosa'),(2161,22,'Sta. Teresa'),(2162,22,'Suardi'),(2163,22,'Sunchales'),(2164,22,'Susana'),(2165,22,'Tacuarendí'),(2166,22,'Tacural'),(2167,22,'Tartagal'),(2168,22,'Teodelina'),(2169,22,'Theobald'),(2170,22,'Timbúes'),(2171,22,'Toba'),(2172,22,'Tortugas'),(2173,22,'Tostado'),(2174,22,'Totoras'),(2175,22,'Traill'),(2176,22,'Venado Tuerto'),(2177,22,'Vera'),(2178,22,'Vera y Pintado'),(2179,22,'Videla'),(2180,22,'Vila'),(2181,22,'Villa Amelia'),(2182,22,'Villa Ana'),(2183,22,'Villa Cañas'),(2184,22,'Villa Constitución'),(2185,22,'Villa Eloísa'),(2186,22,'Villa Gdor. Gálvez'),(2187,22,'Villa Guillermina'),(2188,22,'Villa Minetti'),(2189,22,'Villa Mugueta'),(2190,22,'Villa Ocampo'),(2191,22,'Villa San José'),(2192,22,'Villa Saralegui'),(2193,22,'Villa Trinidad'),(2194,22,'Villada'),(2195,22,'Virginia'),(2196,22,'Wheelwright'),(2197,22,'Zavalla'),(2198,22,'Zenón Pereira'),(2199,23,'Añatuya'),(2200,23,'Árraga'),(2201,23,'Bandera'),(2202,23,'Bandera Bajada'),(2203,23,'Beltrán'),(2204,23,'Brea Pozo'),(2205,23,'Campo Gallo'),(2206,23,'Capital'),(2207,23,'Chilca Juliana'),(2208,23,'Choya'),(2209,23,'Clodomira'),(2210,23,'Col. Alpina'),(2211,23,'Col. Dora'),(2212,23,'Col. El Simbolar Robles'),(2213,23,'El Bobadal'),(2214,23,'El Charco'),(2215,23,'El Mojón'),(2216,23,'Estación Atamisqui'),(2217,23,'Estación Simbolar'),(2218,23,'Fernández'),(2219,23,'Fortín Inca'),(2220,23,'Frías'),(2221,23,'Garza'),(2222,23,'Gramilla'),(2223,23,'Guardia Escolta'),(2224,23,'Herrera'),(2225,23,'Icaño'),(2226,23,'Ing. Forres'),(2227,23,'La Banda'),(2228,23,'La Cañada'),(2229,23,'Laprida'),(2230,23,'Lavalle'),(2231,23,'Loreto'),(2232,23,'Los Juríes'),(2233,23,'Los Núñez'),(2234,23,'Los Pirpintos'),(2235,23,'Los Quiroga'),(2236,23,'Los Telares'),(2237,23,'Lugones'),(2238,23,'Malbrán'),(2239,23,'Matara'),(2240,23,'Medellín'),(2241,23,'Monte Quemado'),(2242,23,'Nueva Esperanza'),(2243,23,'Nueva Francia'),(2244,23,'Palo Negro'),(2245,23,'Pampa de Los Guanacos'),(2246,23,'Pinto'),(2247,23,'Pozo Hondo'),(2248,23,'Quimilí'),(2249,23,'Real Sayana'),(2250,23,'Sachayoj'),(2251,23,'San Pedro de Guasayán'),(2252,23,'Selva'),(2253,23,'Sol de Julio'),(2254,23,'Sumampa'),(2255,23,'Suncho Corral'),(2256,23,'Taboada'),(2257,23,'Tapso'),(2258,23,'Termas de Rio Hondo'),(2259,23,'Tintina'),(2260,23,'Tomas Young'),(2261,23,'Vilelas'),(2262,23,'Villa Atamisqui'),(2263,23,'Villa La Punta'),(2264,23,'Villa Ojo de Agua'),(2265,23,'Villa Río Hondo'),(2266,23,'Villa Salavina'),(2267,23,'Villa Unión'),(2268,23,'Vilmer'),(2269,23,'Weisburd'),(2270,24,'Río Grande'),(2271,24,'Tolhuin'),(2272,24,'Ushuaia'),(2273,25,'Acheral'),(2274,25,'Agua Dulce'),(2275,25,'Aguilares'),(2276,25,'Alderetes'),(2277,25,'Alpachiri'),(2278,25,'Alto Verde'),(2279,25,'Amaicha del Valle'),(2280,25,'Amberes'),(2281,25,'Ancajuli'),(2282,25,'Arcadia'),(2283,25,'Atahona'),(2284,25,'Banda del Río Sali'),(2285,25,'Bella Vista'),(2286,25,'Buena Vista'),(2287,25,'Burruyacú'),(2288,25,'Capitán Cáceres'),(2289,25,'Cevil Redondo'),(2290,25,'Choromoro'),(2291,25,'Ciudacita'),(2292,25,'Colalao del Valle'),(2293,25,'Colombres'),(2294,25,'Concepción'),(2295,25,'Delfín Gallo'),(2296,25,'El Bracho'),(2297,25,'El Cadillal'),(2298,25,'El Cercado'),(2299,25,'El Chañar'),(2300,25,'El Manantial'),(2301,25,'El Mojón'),(2302,25,'El Mollar'),(2303,25,'El Naranjito'),(2304,25,'El Naranjo'),(2305,25,'El Polear'),(2306,25,'El Puestito'),(2307,25,'El Sacrificio'),(2308,25,'El Timbó'),(2309,25,'Escaba'),(2310,25,'Esquina'),(2311,25,'Estación Aráoz'),(2312,25,'Famaillá'),(2313,25,'Gastone'),(2314,25,'Gdor. Garmendia'),(2315,25,'Gdor. Piedrabuena'),(2316,25,'Graneros'),(2317,25,'Huasa Pampa'),(2318,25,'J. B. Alberdi'),(2319,25,'La Cocha'),(2320,25,'La Esperanza'),(2321,25,'La Florida'),(2322,25,'La Ramada'),(2323,25,'La Trinidad'),(2324,25,'Lamadrid'),(2325,25,'Las Cejas'),(2326,25,'Las Talas'),(2327,25,'Las Talitas'),(2328,25,'Los Bulacio'),(2329,25,'Los Gómez'),(2330,25,'Los Nogales'),(2331,25,'Los Pereyra'),(2332,25,'Los Pérez'),(2333,25,'Los Puestos'),(2334,25,'Los Ralos'),(2335,25,'Los Sarmientos'),(2336,25,'Los Sosa'),(2337,25,'Lules'),(2338,25,'M. García Fernández'),(2339,25,'Manuela Pedraza'),(2340,25,'Medinas'),(2341,25,'Monte Bello'),(2342,25,'Monteagudo'),(2343,25,'Monteros'),(2344,25,'Padre Monti'),(2345,25,'Pampa Mayo'),(2346,25,'Quilmes'),(2347,25,'Raco'),(2348,25,'Ranchillos'),(2349,25,'Río Chico'),(2350,25,'Río Colorado'),(2351,25,'Río Seco'),(2352,25,'Rumi Punco'),(2353,25,'San Andrés'),(2354,25,'San Felipe'),(2355,25,'San Ignacio'),(2356,25,'San Javier'),(2357,25,'San José'),(2358,25,'San Miguel de 25'),(2359,25,'San Pedro'),(2360,25,'San Pedro de Colalao'),(2361,25,'Santa Rosa de Leales'),(2362,25,'Sgto. Moya'),(2363,25,'Siete de Abril'),(2364,25,'Simoca'),(2365,25,'Soldado Maldonado'),(2366,25,'Sta. Ana'),(2367,25,'Sta. Cruz'),(2368,25,'Sta. Lucía'),(2369,25,'Taco Ralo'),(2370,25,'Tafí del Valle'),(2371,25,'Tafí Viejo'),(2372,25,'Tapia'),(2373,25,'Teniente Berdina'),(2374,25,'Trancas'),(2375,25,'Villa Belgrano'),(2376,25,'Villa Benjamín Araoz'),(2377,25,'Villa Chiligasta'),(2378,25,'Villa de Leales'),(2379,25,'Villa Quinteros'),(2380,25,'Yánima'),(2381,25,'Yerba Buena'),(2382,25,'Yerba Buena (S)');
/*!40000 ALTER TABLE `localities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1604158105),('m200930_024736_create_product_types_table',1604158111),('m200930_025920_create_users_table',1604158111),('m200930_030226_create_units_table',1604158111),('m200930_032041_create_products_table',1604158111),('m200930_114413_create_provider_taxes_table',1604158111),('m200930_114907_create_product_images_table',1604158111),('m200930_121705_create_providers_table',1604158111),('m200930_122640_create_provider_contacts_table',1604158111),('m200930_123012_create_provider_deliveries_table',1604158111),('m200930_124307_add_users_id_column_to_providers_table',1604158111),('m200930_124310_create_provider_types_table',1604158111),('m200930_124401_add_provider_types_id_column_to_providers_table',1604158111),('m200930_124405_create_subproduct_types_table',1604158111),('m200930_124410_create_subproduct_typifications_table',1604158111),('m200930_124641_add_subproduct_typifications_id_column_to_products_table',1604158112),('m200930_124746_add_providers_id_column_to_products_table',1604158112),('m200930_125012_add_subproduct_types_id_column_to_products_table',1604158112),('m200930_125120_add_providers_id_column_to_provider_taxes_table',1604158112),('m200930_125231_add_product_types_id_column_to_products_table',1604158112),('m201003_173520_create_provider_images_table',1604158112),('m201005_000656_create_search_logs_table',1604158112),('m201008_230624_create_clients_table',1604158112),('m201010_000218_create_favorites_table',1604158112),('m201010_000424_create_favorites_log_table',1604158113),('m201010_155002_create_views_history_table',1604158113),('m201021_005836_create_countries_table',1604158113),('m201021_010003_create_provinces_table',1604158113),('m201021_010019_create_localities_table',1604158113),('m201021_010152_add_localities_id_providers_table',1604158113),('m201024_043858_create_addresses_table',1604158113),('m201025_194605_create_admins_table',1604158114),('m201025_204730_create_provider_signature_history_table',1604158114),('m201026_210933_add_signature_columns_to_table_clients',1604158114),('m201026_210951_create_client_signature_history_table',1604158114),('m201028_002018_create_delivery_types_table',1604158114),('m201028_002046_create_purchases_table',1604158114),('m201028_222215_create_auth0_table',1604158114),('m201028_225203_add_videos_providers_table',1604158114),('m201030_012254_create_products_has_delivery_types_table',1604158114);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_images` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `image` text NOT NULL,
  `products_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-product_images-products_id` (`products_id`),
  CONSTRAINT `fk-product_images-products_id` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (1,'../web/uploads/product/1/imagen.jpg1847938021',1);
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_types`
--

DROP TABLE IF EXISTS `product_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_types` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_types`
--

LOCK TABLES `product_types` WRITE;
/*!40000 ALTER TABLE `product_types` DISABLE KEYS */;
INSERT INTO `product_types` VALUES (1,'Alacena',1),(2,'Bebidas alcohólicas',1),(3,'Bebidas no alcohólicas',1),(4,'Lácteos',1),(5,'Huerta',1),(6,'Hogar',1),(7,'Alimentos frescos',1);
/*!40000 ALTER TABLE `product_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `presentation` text,
  `volumes_name` varchar(30) NOT NULL,
  `volume_value` double NOT NULL,
  `weights_name` varchar(30) NOT NULL,
  `weight_value` double NOT NULL,
  `requires_cold` tinyint(1) NOT NULL DEFAULT '0',
  `clasification` decimal(2,0) NOT NULL DEFAULT '0',
  `stock` bigint NOT NULL,
  `price` double NOT NULL,
  `reposition_point` bigint NOT NULL,
  `delivery_time` bigint NOT NULL DEFAULT '0',
  `expires` bigint NOT NULL,
  `expires_time` bigint NOT NULL,
  `status` enum('pendiente','habilitado','rechazado','eliminado') NOT NULL DEFAULT 'pendiente',
  `active` tinyint(1) NOT NULL,
  `delivery_types` text NOT NULL,
  `videos` text,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `subproduct_typifications_id` bigint NOT NULL,
  `providers_id` bigint NOT NULL,
  `subproduct_types_id` bigint NOT NULL,
  `product_types_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-products-subproduct_typifications_id` (`subproduct_typifications_id`),
  KEY `idx-products-providers_id` (`providers_id`),
  KEY `idx-products-subproduct_types_id` (`subproduct_types_id`),
  KEY `idx-products-product_types_id` (`product_types_id`),
  CONSTRAINT `fk-products-product_types_id` FOREIGN KEY (`product_types_id`) REFERENCES `product_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-products-providers_id` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-products-subproduct_types_id` FOREIGN KEY (`subproduct_types_id`) REFERENCES `subproduct_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-products-subproduct_typifications_id` FOREIGN KEY (`subproduct_typifications_id`) REFERENCES `subproduct_typifications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Dulce de Calafate','Dulce de Calafate','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',1,1,1,1),(2,'Dulce de Rosa Mosqueta','Dulce de Rosa Mosqueta','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',2,1,1,1),(3,'Dulce de Frutilla','Dulce de Frutilla','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',3,1,1,1),(4,'Cerveza IPA','Cerveza IPA','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',4,1,2,2),(5,'Cerveza Negra','Cerveza Negra','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',5,1,2,2),(6,'Cerveza Red','Cerveza Red','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',6,1,2,2),(7,'Juego de Frutillas','Juego de Frutillas','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',7,1,3,3),(8,'Juego de Mazana','Juego de Mazana','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',8,1,3,3),(9,'Juego de Arándanos','Juego de Arándanos','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',9,1,4,3),(10,'Queso de cabra','Queso de cabra','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',10,1,4,4),(11,'Quedo para rallar','Quedo para rallar','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',11,1,4,4),(12,'Arándanos','Arándanos','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',12,1,4,5),(13,'Frutillas','Frutillas','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',13,1,5,5),(14,'Cerezas','Cerezas','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',15,1,5,5),(15,'Cerezas Negras','Cerezas Negras','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',16,1,6,5),(16,'Recuerdos Lugareños','Recuerdos Lugareños','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',17,1,6,6),(17,'Artesanías','Artesanías','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',18,1,7,6),(18,'Cocina','Cocina','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',19,1,7,6),(19,'Sofá','Sofá','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',20,1,8,6),(20,'Salame de ciervo','Salame de ciervo','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',21,1,8,7),(21,'Salame de jabalí','Salame de jabalí','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',22,1,8,7),(22,'Pate de trucha','Pate de trucha','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',23,1,8,7),(23,'Pate de ciervo','Pate de ciervo','1',10,'2',10,1,0,10,1234,5,10,1,180,'habilitado',1,'[\"takeaway\"]','[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]',NULL,NULL,'2020-11-02 12:20:13',1,1,1,7);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_has_delivery_types`
--

DROP TABLE IF EXISTS `products_has_delivery_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_has_delivery_types` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `products_id` bigint NOT NULL,
  `delivery_types_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-products_has_delivery_types-products_id` (`products_id`),
  KEY `idx-products_has_delivery_types-delivery_types_id` (`delivery_types_id`),
  CONSTRAINT `fk-products_has_delivery_types-delivery_types_id` FOREIGN KEY (`delivery_types_id`) REFERENCES `delivery_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-products_has_delivery_types-products_id` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_has_delivery_types`
--

LOCK TABLES `products_has_delivery_types` WRITE;
/*!40000 ALTER TABLE `products_has_delivery_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_has_delivery_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_contacts`
--

DROP TABLE IF EXISTS `provider_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_contacts` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `birthday_date` date NOT NULL,
  `responsable` tinyint(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` double NOT NULL,
  `providers_id` bigint NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx-provider_contacts-providers_id` (`providers_id`),
  CONSTRAINT `fk-provider_contacts-providers_id` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_contacts`
--

LOCK TABLES `provider_contacts` WRITE;
/*!40000 ALTER TABLE `provider_contacts` DISABLE KEYS */;
INSERT INTO `provider_contacts` VALUES (1,'Santiago','Mena','11111111','2002-11-02',1,'santiagomenape@gmail.com',111555998972,1,NULL,NULL,'2020-11-02 11:49:04');
/*!40000 ALTER TABLE `provider_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_deliveries`
--

DROP TABLE IF EXISTS `provider_deliveries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_deliveries` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `day` enum('Lun','Mar','Mie','Jue','Vie','Sab','Dom') NOT NULL,
  `providers_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-provider_deliveries-providers_id` (`providers_id`),
  CONSTRAINT `fk-provider_deliveries-providers_id` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_deliveries`
--

LOCK TABLES `provider_deliveries` WRITE;
/*!40000 ALTER TABLE `provider_deliveries` DISABLE KEYS */;
INSERT INTO `provider_deliveries` VALUES (7,'07:00:00','20:00:00','Mar',1),(8,'07:00:00','20:00:00','Lun',1),(9,'07:00:00','20:00:00','Mie',1),(10,'07:00:00','20:00:00','Vie',1),(11,'07:00:00','20:00:00','Jue',1),(12,'07:00:00','20:00:00','Sab',1);
/*!40000 ALTER TABLE `provider_deliveries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_images`
--

DROP TABLE IF EXISTS `provider_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_images` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `image` text NOT NULL,
  `providers_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-provider_images-providers_id` (`providers_id`),
  CONSTRAINT `fk-provider_images-providers_id` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_images`
--

LOCK TABLES `provider_images` WRITE;
/*!40000 ALTER TABLE `provider_images` DISABLE KEYS */;
INSERT INTO `provider_images` VALUES (1,'../web/uploads/provider/1/imagen.jpg1451650233',1);
/*!40000 ALTER TABLE `provider_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_signature_history`
--

DROP TABLE IF EXISTS `provider_signature_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_signature_history` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `providers_id` bigint NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(100) DEFAULT NULL,
  `user_agent` text,
  PRIMARY KEY (`id`),
  KEY `idx-provider_signature_history-providers_id` (`providers_id`),
  CONSTRAINT `fk-provider_signature_history-providers_id` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_signature_history`
--

LOCK TABLES `provider_signature_history` WRITE;
/*!40000 ALTER TABLE `provider_signature_history` DISABLE KEYS */;
INSERT INTO `provider_signature_history` VALUES (1,1,'2020-11-02 12:18:12','181.44.60.129','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36');
/*!40000 ALTER TABLE `provider_signature_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_taxes`
--

DROP TABLE IF EXISTS `provider_taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_taxes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cuit` varchar(20) NOT NULL,
  `number` varchar(30) NOT NULL,
  `qualification` varchar(30) NOT NULL DEFAULT '0',
  `qualification_notes` varchar(100) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL,
  `providers_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-provider_taxes-providers_id` (`providers_id`),
  CONSTRAINT `fk-provider_taxes-providers_id` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_taxes`
--

LOCK TABLES `provider_taxes` WRITE;
/*!40000 ALTER TABLE `provider_taxes` DISABLE KEYS */;
INSERT INTO `provider_taxes` VALUES (1,'20-11111111-1','123','habs','Notas',1,1);
/*!40000 ALTER TABLE `provider_taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_types`
--

DROP TABLE IF EXISTS `provider_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_types` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_types`
--

LOCK TABLES `provider_types` WRITE;
/*!40000 ALTER TABLE `provider_types` DISABLE KEYS */;
INSERT INTO `provider_types` VALUES (1,'Nodo'),(2,'Productor');
/*!40000 ALTER TABLE `provider_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `providers`
--

DROP TABLE IF EXISTS `providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `providers` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `business_name` varchar(100) NOT NULL,
  `clasification` decimal(2,0) NOT NULL DEFAULT '0',
  `geo` point NOT NULL /*!80003 SRID 4326 */,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `street_name` varchar(30) NOT NULL,
  `floor` varchar(10) DEFAULT NULL,
  `department_number` varchar(6) DEFAULT NULL,
  `training` tinyint(1) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `cbu` varchar(22) NOT NULL,
  `phone_number` double NOT NULL,
  `email` varchar(150) NOT NULL,
  `participate_fairs` tinyint(1) NOT NULL,
  `signature` tinyint(1) DEFAULT '0',
  `signature_date` date DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `users_id` bigint NOT NULL,
  `provider_types_id` bigint NOT NULL,
  `localities_id` bigint NOT NULL,
  `videos` text,
  PRIMARY KEY (`id`),
  SPATIAL KEY `idx_geo_index` (`geo`),
  KEY `idx-providers-users_id` (`users_id`),
  KEY `idx-providers-provider_types_id` (`provider_types_id`),
  KEY `idx-providers-localities_id` (`localities_id`),
  CONSTRAINT `fk-providers-localities_id` FOREIGN KEY (`localities_id`) REFERENCES `localities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-providers-provider_types_id` FOREIGN KEY (`provider_types_id`) REFERENCES `provider_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-providers-users_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `providers`
--

LOCK TABLES `providers` WRITE;
/*!40000 ALTER TABLE `providers` DISABLE KEYS */;
INSERT INTO `providers` VALUES (1,'Provider Xampler','Feriame',0,_binary '\�\0\0\0\0\0\�W�f,zC�R\'���Q�',-38.95448,-68.05765,'Humboldt 1877','23','a',1,'../web/uploads/providerlogo//logo.jpg183801001','1234567890123451234553',1163236842,'provider@xampler.com',1,1,'2020-11-02',1,NULL,NULL,'2020-11-02 11:49:00',34,2,18,'[\"www.youtube.com/watch?v=PbvTzpxE7Rs\"]');
/*!40000 ALTER TABLE `providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provinces` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `countries_id` bigint NOT NULL,
  `province` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-provinces-countries_id` (`countries_id`),
  CONSTRAINT `fk-provinces-countries_id` FOREIGN KEY (`countries_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provinces`
--

LOCK TABLES `provinces` WRITE;
/*!40000 ALTER TABLE `provinces` DISABLE KEYS */;
INSERT INTO `provinces` VALUES (1,1,'Buenos Aires'),(2,1,'Buenos Aires-GBA'),(3,1,'Capital Federal'),(4,1,'Catamarca'),(5,1,'Chaco'),(6,1,'Chubut'),(7,1,'Córdoba'),(8,1,'Corrientes'),(9,1,'Entre Ríos'),(10,1,'Formosa'),(11,1,'Jujuy'),(12,1,'La Pampa'),(13,1,'La Rioja'),(14,1,'Mendoza'),(15,1,'Misiones'),(16,1,'Neuquén'),(17,1,'Río Negro'),(18,1,'Salta'),(19,1,'San Juan'),(20,1,'San Luis'),(21,1,'Santa Cruz'),(22,1,'Santa Fe'),(23,1,'Santiago del Estero'),(24,1,'Tierra del Fuego'),(25,1,'Tucumán');
/*!40000 ALTER TABLE `provinces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchases` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `clients_id` bigint NOT NULL,
  `products_id` bigint NOT NULL,
  `delivery_types_id` bigint NOT NULL,
  `addresses_id` bigint NOT NULL,
  `quantity` int NOT NULL,
  `delivery_cost` double DEFAULT '0',
  `service_cost` double DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx-purchases-clients_id` (`clients_id`),
  KEY `idx-purchases-products_id` (`products_id`),
  KEY `idx-purchases-delivery_types_id` (`delivery_types_id`),
  KEY `idx-purchases-addresses_id` (`addresses_id`),
  CONSTRAINT `fk-purchases-addresses_id` FOREIGN KEY (`addresses_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-purchases-clients_id` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-purchases-delivery_types_id` FOREIGN KEY (`delivery_types_id`) REFERENCES `delivery_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-purchases-products_id` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `search_logs`
--

DROP TABLE IF EXISTS `search_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_logs` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `query` text,
  `users_id` bigint DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx-search_logs-users_id` (`users_id`),
  CONSTRAINT `fk-search_logs-users_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `search_logs`
--

LOCK TABLES `search_logs` WRITE;
/*!40000 ALTER TABLE `search_logs` DISABLE KEYS */;
INSERT INTO `search_logs` VALUES (1,'',NULL,'2020-10-31 15:35:10'),(2,'',NULL,'2020-11-01 14:04:53'),(3,'',NULL,'2020-11-01 14:05:02'),(4,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-01 14:05:03'),(5,'',NULL,'2020-11-02 11:39:20'),(6,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 11:44:21'),(7,'pageSize=6&page=1&filter%5Bproducts.name%5D%5Blike%5D=-&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 11:44:21'),(8,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 11:44:21'),(9,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 11:44:21'),(10,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 11:45:30'),(11,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 11:45:30'),(12,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 11:45:30'),(13,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 11:46:34'),(14,'pageSize=6&page=1&filter%5Bproducts.name%5D%5Blike%5D=-&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 11:46:35'),(15,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 11:46:35'),(16,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 11:46:35'),(17,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:13:17'),(18,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:13:17'),(19,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:13:17'),(20,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:13:20'),(21,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:13:20'),(22,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:13:20'),(23,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:13:46'),(24,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:13:46'),(25,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:13:46'),(26,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:15:29'),(27,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:15:29'),(28,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:15:29'),(29,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:16:42'),(30,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:16:42'),(31,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:16:42'),(32,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:16:58'),(33,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:16:58'),(34,'pageSize=6&page=1&filter%5Bproducts.name%5D%5Blike%5D=-&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:16:59'),(35,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:16:59'),(36,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:17:28'),(37,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:17:28'),(38,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:17:28'),(39,'pageSize=6&page=1&filter%5Bproducts.name%5D%5Blike%5D=-&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:17:28'),(40,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:20'),(41,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:20'),(42,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:20'),(43,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:22'),(44,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:22'),(45,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:22'),(46,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:46'),(47,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:46'),(48,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:46'),(49,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:56'),(50,'pageSize=6&page=1&filter%5Bproducts.name%5D%5Blike%5D=-&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:56'),(51,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:56'),(52,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:18:57'),(53,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:20:19'),(54,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:20:19'),(55,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:20:19'),(56,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:20:21'),(57,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:20:21'),(58,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:20:21'),(59,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:20:50'),(60,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:20:51'),(61,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:20:51'),(62,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:21:02'),(63,'pageSize=6&page=1&filter%5Bproducts.name%5D%5Blike%5D=-&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:21:02'),(64,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:21:02'),(65,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:21:03'),(66,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:26:01'),(67,'pageSize=6&page=1&filter%5Bproducts.name%5D%5Blike%5D=m&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:26:01'),(68,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:26:01'),(69,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:26:02'),(70,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:38:10'),(71,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:38:10'),(72,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:38:10'),(73,'pageSize=6&page=1&filter%5Bproducts.name%5D%5Blike%5D=m+&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:40:16'),(74,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:40:16'),(75,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:40:16'),(76,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:40:16'),(77,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:46:41'),(78,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:46:42'),(79,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:46:42'),(80,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:53:15'),(81,'pageSize=6&page=1&filter%5Bproducts.name%5D%5Blike%5D=-&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:53:15'),(82,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:53:16'),(83,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:55:48'),(84,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:55:49'),(85,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:55:49'),(86,'pageSize=6&page=1&filter%5Bfavorites%5D=true&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:56:08'),(87,'pageSize=6&page=1&filter%5Bfavorites%5D=true&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:56:08'),(88,'pageSize=6&page=1&filter%5Bfavorites%5D=true&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 12:56:09'),(89,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:15:21'),(90,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:15:21'),(91,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:15:21'),(92,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:22:10'),(93,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:22:11'),(94,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:22:11'),(95,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:24:59'),(96,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:25:00'),(97,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:25:00'),(98,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:26:57'),(99,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:26:57'),(100,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:26:57'),(101,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:30:10'),(102,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:30:10'),(103,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:30:10'),(104,'pageSize=6&page=1&filter%5Bfavorites%5D=true&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:32:44'),(105,'pageSize=6&page=1&filter%5Bfavorites%5D=true&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:32:45'),(106,'pageSize=6&page=1&filter%5Bfavorites%5D=true&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:32:45'),(107,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:59:41'),(108,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:59:41'),(109,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 13:59:41'),(110,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:00:08'),(111,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:00:08'),(112,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:00:08'),(113,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:01:37'),(114,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:01:37'),(115,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:01:37'),(116,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:02:04'),(117,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:02:04'),(118,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:02:04'),(119,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:02:40'),(120,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:02:41'),(121,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:02:41'),(122,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:04:47'),(123,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:04:47'),(124,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:04:47'),(125,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:05:24'),(126,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:05:25'),(127,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:05:25'),(128,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:08:29'),(129,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:08:30'),(130,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:08:30'),(131,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:08:58'),(132,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:08:58'),(133,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:08:58'),(134,'pageSize=6&page=1&filter%5Bfavorites%5D=true&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:40:14'),(135,'pageSize=6&page=1&filter%5Bfavorites%5D=true&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:40:14'),(136,'pageSize=6&page=1&filter%5Bfavorites%5D=true&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 14:40:14'),(137,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:54:37'),(138,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:54:37'),(139,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:54:37'),(140,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:55:06'),(141,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:55:06'),(142,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:55:06'),(143,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:55:26'),(144,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:55:26'),(145,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:55:26'),(146,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:57:15'),(147,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:57:15'),(148,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:57:15'),(149,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:58:09'),(150,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:58:09'),(151,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:58:09'),(152,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:58:44'),(153,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:58:44'),(154,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:58:44'),(155,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:58:46'),(156,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:58:46'),(157,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:58:46'),(158,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:59:07'),(159,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:59:07'),(160,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 15:59:07'),(161,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:06:23'),(162,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:06:23'),(163,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:06:24'),(164,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:06:32'),(165,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:06:32'),(166,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:06:32'),(167,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:06:56'),(168,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:06:56'),(169,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:06:56'),(170,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:08:16'),(171,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:08:16'),(172,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:08:16'),(173,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:18:28'),(174,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:18:28'),(175,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:18:28'),(176,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:18:51'),(177,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:18:51'),(178,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:18:51'),(179,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:19:28'),(180,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:19:29'),(181,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:19:29'),(182,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:19:51'),(183,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:19:51'),(184,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:19:51'),(185,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:20:12'),(186,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:20:12'),(187,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:20:12'),(188,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:20:44'),(189,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:20:44'),(190,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:20:44'),(191,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:26:25'),(192,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:26:25'),(193,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 16:26:25'),(194,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 17:58:11'),(195,'pageSize=6&page=1&filter%5Bproducts.name%5D%5Blike%5D=me&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 17:58:11'),(196,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 17:58:11'),(197,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 17:58:11'),(198,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 22:06:58'),(199,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 22:06:58'),(200,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 22:06:58'),(201,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 22:07:52'),(202,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 22:07:52'),(203,'pageSize=6&page=1&expand=productTypes%2CsubproductTypes%2Cproviders%2CsubproductTypifications%2CproductImages%2Cfavorites',NULL,'2020-11-02 22:07:52');
/*!40000 ALTER TABLE `search_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subproduct_types`
--

DROP TABLE IF EXISTS `subproduct_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subproduct_types` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `product_types_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-subproduct_types-product_types_id` (`product_types_id`),
  CONSTRAINT `fk-subproduct_types-product_types_id` FOREIGN KEY (`product_types_id`) REFERENCES `product_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subproduct_types`
--

LOCK TABLES `subproduct_types` WRITE;
/*!40000 ALTER TABLE `subproduct_types` DISABLE KEYS */;
INSERT INTO `subproduct_types` VALUES (1,'Mermelada',1,1),(2,'Cerveza artesanal',1,2),(3,'No alcohólica',1,3),(4,'Quesos',1,4),(5,'Frutas',1,5),(6,'Recuerdos',1,6),(7,'Muebles',1,6),(8,'Chacinados',1,7);
/*!40000 ALTER TABLE `subproduct_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subproduct_typifications`
--

DROP TABLE IF EXISTS `subproduct_typifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subproduct_typifications` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `subproduct_types_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-subproduct_typifications-subproduct_types_id` (`subproduct_types_id`),
  CONSTRAINT `fk-subproduct_typifications-subproduct_types_id` FOREIGN KEY (`subproduct_types_id`) REFERENCES `subproduct_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subproduct_typifications`
--

LOCK TABLES `subproduct_typifications` WRITE;
/*!40000 ALTER TABLE `subproduct_typifications` DISABLE KEYS */;
INSERT INTO `subproduct_typifications` VALUES (1,'Dulce de Calafate',1,1),(2,'Dulce de Rosa Mosqueta',1,1),(3,'Dulce de Frutilla',1,1),(4,'IPA',1,2),(5,'Negra',1,2),(6,'Roja',1,2),(7,'Frutilla',1,3),(8,'Manzana',1,3),(9,'Arándanos',1,3),(10,'De Cabra',1,4),(11,'Rallar',1,4),(12,'Arándanos',1,5),(13,'Frutillas',1,5),(14,'Cerezas',1,5),(15,'Cerezas negras',1,5),(16,'Lugareños',1,6),(17,'Artesanías',1,6),(18,'Cocina',1,7),(19,'Living',1,7),(20,'Salame de ciervo',1,8),(21,'Salame de jabalí',1,8),(22,'Pate de trucha',1,8),(23,'Pate de ciervo',1,8);
/*!40000 ALTER TABLE `subproduct_typifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` enum('V','W') DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'V','CM3'),(2,'W','KG');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (9,'guille.gabriel.ojeda@gmail.com',NULL,NULL,'2020-10-25 00:18:25'),(15,'ramirodutto@gmail.com',NULL,NULL,'2020-10-25 17:04:17'),(16,'santiagomenape@gmail.com',NULL,NULL,'2020-10-25 20:04:02'),(34,'santiago@contenidos-digitales.com',NULL,NULL,'2020-11-02 11:49:00'),(35,'quiero@desligar.me',NULL,NULL,'2020-11-02 12:55:44'),(37,'reymonddolz@gmail.com',NULL,NULL,'2020-11-02 13:30:06'),(38,'provider@xampler.com',NULL,NULL,'2020-11-02 23:37:38');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `views_history`
--

DROP TABLE IF EXISTS `views_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `views_history` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `products_id` bigint NOT NULL,
  `clients_id` bigint NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx-views_history-clients_id` (`clients_id`),
  KEY `idx-views_history-products_id` (`products_id`),
  CONSTRAINT `fk-views_history-clients_id` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-views_history-products_id` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `views_history`
--

LOCK TABLES `views_history` WRITE;
/*!40000 ALTER TABLE `views_history` DISABLE KEYS */;
INSERT INTO `views_history` VALUES (1,1,1,'2020-11-02 12:57:13'),(2,1,1,'2020-11-02 13:01:09'),(3,1,1,'2020-11-02 13:22:02'),(4,1,3,'2020-11-02 13:31:22'),(5,1,3,'2020-11-02 13:32:00'),(6,1,3,'2020-11-02 14:00:18'),(7,1,3,'2020-11-02 14:09:09'),(8,1,3,'2020-11-02 14:09:43'),(9,1,3,'2020-11-02 14:41:01'),(10,1,3,'2020-11-02 15:07:59'),(11,1,3,'2020-11-02 15:22:23'),(12,1,3,'2020-11-02 15:55:36'),(13,1,3,'2020-11-02 15:58:19'),(14,1,3,'2020-11-02 15:59:15'),(15,1,3,'2020-11-02 16:07:05'),(16,1,3,'2020-11-02 16:08:25'),(17,1,3,'2020-11-02 16:20:54'),(18,1,3,'2020-11-02 22:09:30');
/*!40000 ALTER TABLE `views_history` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-02 20:53:34
