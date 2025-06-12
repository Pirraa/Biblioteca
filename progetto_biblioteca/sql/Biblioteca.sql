-- MySQL dump 10.13  Distrib 8.0.42, for Linux (x86_64)
--
-- Host: localhost    Database: Biblioteca
-- ------------------------------------------------------
-- Server version	8.0.42-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Autore`
--

DROP TABLE IF EXISTS `Autore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Autore` (
  `id_autore` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `data_nascita` date DEFAULT NULL,
  `luogo_nascita` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_autore`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Autore`
--

LOCK TABLES `Autore` WRITE;
/*!40000 ALTER TABLE `Autore` DISABLE KEYS */;
INSERT INTO `Autore` VALUES (1,'Mario','Rossi','1970-05-12','Ferrara'),(2,'Lucia','Bianchi','1985-09-20','Bologna'),(3,'Giorgio','Verdi','1968-02-10','Modena');
/*!40000 ALTER TABLE `Autore` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AutoreLibro`
--

DROP TABLE IF EXISTS `AutoreLibro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `AutoreLibro` (
  `id_autore` int NOT NULL,
  `ISBN` varchar(20) NOT NULL,
  PRIMARY KEY (`id_autore`,`ISBN`),
  KEY `ISBN` (`ISBN`),
  CONSTRAINT `AutoreLibro_ibfk_1` FOREIGN KEY (`id_autore`) REFERENCES `Autore` (`id_autore`) ON DELETE CASCADE,
  CONSTRAINT `AutoreLibro_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `Libro` (`ISBN`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AutoreLibro`
--

LOCK TABLES `AutoreLibro` WRITE;
/*!40000 ALTER TABLE `AutoreLibro` DISABLE KEYS */;
INSERT INTO `AutoreLibro` VALUES (1,'9788812345601'),(3,'9788812345601'),(1,'9788812345602'),(2,'9788812345602'),(2,'9788812345603'),(3,'9788812345603'),(1,'9788812345604'),(2,'9788812345605');
/*!40000 ALTER TABLE `AutoreLibro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CopiaLibro`
--

DROP TABLE IF EXISTS `CopiaLibro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `CopiaLibro` (
  `id_copia` int NOT NULL AUTO_INCREMENT,
  `ISBN` varchar(20) NOT NULL,
  `succursale` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_copia`),
  KEY `ISBN` (`ISBN`),
  KEY `succursale` (`succursale`),
  CONSTRAINT `CopiaLibro_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `Libro` (`ISBN`) ON DELETE CASCADE,
  CONSTRAINT `CopiaLibro_ibfk_2` FOREIGN KEY (`succursale`) REFERENCES `Succursale` (`nome`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CopiaLibro`
--

LOCK TABLES `CopiaLibro` WRITE;
/*!40000 ALTER TABLE `CopiaLibro` DISABLE KEYS */;
INSERT INTO `CopiaLibro` VALUES (1,'9788812345601','Architettura'),(2,'9788812345601','Architettura'),(3,'9788812345601','Architettura'),(4,'9788812345602','Economia e Management'),(5,'9788812345602','Economia e Management'),(6,'9788812345602','Economia e Management'),(7,'9788812345603','Fisica e Scienze della Terra'),(8,'9788812345603','Fisica e Scienze della Terra'),(9,'9788812345603','Fisica e Scienze della Terra'),(10,'9788812345604','Giurisprudenza'),(11,'9788812345604','Giurisprudenza'),(12,'9788812345604','Giurisprudenza'),(13,'9788812345605','Ingegneria'),(14,'9788812345605','Ingegneria'),(15,'9788812345605','Ingegneria');
/*!40000 ALTER TABLE `CopiaLibro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Libro`
--

DROP TABLE IF EXISTS `Libro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Libro` (
  `ISBN` varchar(20) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `anno_pubblicazione` int DEFAULT NULL,
  `lingua` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ISBN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Libro`
--

LOCK TABLES `Libro` WRITE;
/*!40000 ALTER TABLE `Libro` DISABLE KEYS */;
INSERT INTO `Libro` VALUES ('9788812345601','Introduzione all\'Architettura Moderna',2015,'Italiano'),('9788812345602','Fondamenti di Economia Aziendale',2018,'Italiano'),('9788812345603','Fisica Quantistica: Teoria e Applicazioni',2020,'Italiano'),('9788812345604','Diritto Civile: Principi e Casi',2017,'Italiano'),('9788812345605','Ingegneria dei Materiali Avanzati',2019,'Italiano');
/*!40000 ALTER TABLE `Libro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Prestito`
--

DROP TABLE IF EXISTS `Prestito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Prestito` (
  `id_copia` int NOT NULL,
  `matricola` varchar(6) NOT NULL,
  `data_uscita` date NOT NULL,
  `data_restituzione_prevista` date DEFAULT NULL,
  PRIMARY KEY (`id_copia`,`matricola`,`data_uscita`),
  KEY `matricola` (`matricola`),
  CONSTRAINT `Prestito_ibfk_1` FOREIGN KEY (`id_copia`) REFERENCES `CopiaLibro` (`id_copia`) ON DELETE CASCADE,
  CONSTRAINT `Prestito_ibfk_2` FOREIGN KEY (`matricola`) REFERENCES `Utente` (`matricola`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Prestito`
--

LOCK TABLES `Prestito` WRITE;
/*!40000 ALTER TABLE `Prestito` DISABLE KEYS */;
INSERT INTO `Prestito` VALUES (1,'000001','2025-06-01','2025-07-01'),(4,'000002','2025-06-05','2025-07-05'),(7,'000003','2025-06-10','2025-07-10');
/*!40000 ALTER TABLE `Prestito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Succursale`
--

DROP TABLE IF EXISTS `Succursale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Succursale` (
  `nome` varchar(100) NOT NULL,
  `indirizzo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Succursale`
--

LOCK TABLES `Succursale` WRITE;
/*!40000 ALTER TABLE `Succursale` DISABLE KEYS */;
INSERT INTO `Succursale` VALUES ('Architettura','Via Ghiara, 36 - 44121 Ferrara'),('Economia e Management','Via Voltapaletto n. 11 - 44121 Ferrara'),('Fisica e Scienze della Terra','Via Saragat, 1 - 44122 Ferrara'),('Giurisprudenza','Corso Ercole I d\'Este n. 37 - 44121 Ferrara'),('Ingegneria','Via Saragat, 1 - 44122 Ferrara'),('Matematica e Informatica','Via Machiavelli, 30 - 44121 Ferrara'),('Medicina Traslazionale e per la Romagna','Via Luigi Borsari, 46 - 44121 Ferrara'),('Neuroscienze e Riabilitazione','Via Luigi Borsari, 46 - 44121 Ferrara'),('Scienze Chimiche, Farmaceutiche ed Agrarie','Via Luigi Borsari, 46 - 44121 Ferrara'),('Scienze dell\'Ambiente e della Prevenzione','Via Luigi Borsari, 46 - 44121 Ferrara'),('Scienze della Vita e Biotecnologie','Via Luigi Borsari, 46 - 44121 Ferrara'),('Scienze Mediche','Via Fossato di Mortara, 64/B - 44121 Ferrara'),('Studi Umanistici','Via Paradiso, 12 - 44121 Ferrara');
/*!40000 ALTER TABLE `Succursale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Utente`
--

DROP TABLE IF EXISTS `Utente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Utente` (
  `matricola` varchar(6) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `indirizzo` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`matricola`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Utente`
--

LOCK TABLES `Utente` WRITE;
/*!40000 ALTER TABLE `Utente` DISABLE KEYS */;
INSERT INTO `Utente` VALUES ('000001','Elena','Neri','Via Roma 10, Ferrara','0532-111111'),('000002','Carlo','Blu','Via Bologna 15, Ferrara','0532-222222'),('000003','Anna','Verdi','Via Modena 20, Ferrara','0532-333333');
/*!40000 ALTER TABLE `Utente` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-12 16:00:46
