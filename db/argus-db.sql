-- MariaDB dump 10.19  Distrib 10.5.9-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: argusing_argus
-- ------------------------------------------------------
-- Server version	10.5.9-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `capacidades`
--

DROP TABLE IF EXISTS `capacidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `capacidades` (
  `id_dispositivo` int(11) DEFAULT NULL,
  `id_variable` int(11) DEFAULT NULL,
  `habilitada` tinyint(1) DEFAULT NULL,
  KEY `id_dispositivo` (`id_dispositivo`),
  KEY `id_variable` (`id_variable`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capacidades`
--

LOCK TABLES `capacidades` WRITE;
/*!40000 ALTER TABLE `capacidades` DISABLE KEYS */;
/*!40000 ALTER TABLE `capacidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `apellidos` varchar(30) DEFAULT NULL,
  `nombres` varchar(30) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `razon_social` varchar(60) NOT NULL,
  `tipo_persona` varchar(1) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL COMMENT 'Ruta para el archivo de imágen de perfil',
  `estado` varchar(1) NOT NULL COMMENT 'Esatdo del usuario (A = Activo, I = Inactivo',
  PRIMARY KEY (`id_cliente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (98387688,'Castillo Eraso','Juan Carlos','Calle 13 #39-30','3014290590','jjcastilloj@gmail.com','906860ce1d24fee7f0474211666fb9ef041d19e6','Argus Ingeniería','J','../img/people/juan.jpeg','A'),(98397457,'Ortiz M.','Silvio Andrés','Cra 27#12-16 San Felipe','3176689458','friotecniacomercial@gmail.com','6825b3c46b36eddb521fc4dfd219939030bfde3a','Friotecnia Refrigeración','J','../img/people/andres.jpg','A'),(7215558,'Andrade Guerrero','Nathalie','Cra. 21a #192','7215558','texcol@texcol.com','f7c3bc1d808e04732adf679965ccc34ca7ae3441','TEXCOL','J','./img/organization/LogoTexcol.jpg','A'),(800118954,'Centro de','Informática','Edificio Tecnológico oficina 205','7310586','ci@udenar.edu.co','906860ce1d24fee7f0474211666fb9ef041d19e6','Universidad de Nariño','J','./img/organization/udenar.png','A'),(800118951,'Informática','Aula de','Edificio Tecnológico oficina 305','7310586','aulainfo@udenar.edu.co','a453dfc04f0cbbbee926b353762d9cd1170308c7','Universidad de Nariño','J','../img/organization/udenar.jpg','A');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrato`
--

DROP TABLE IF EXISTS `contrato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrato` (
  `id_contrato` varchar(10) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_dispositivo` int(11) DEFAULT NULL,
  `id_variable` int(11) DEFAULT NULL,
  KEY `id_cliente` (`id_cliente`),
  KEY `id_dispositivo` (`id_dispositivo`),
  KEY `id_variable` (`id_variable`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrato`
--

LOCK TABLES `contrato` WRITE;
/*!40000 ALTER TABLE `contrato` DISABLE KEYS */;
INSERT INTO `contrato` VALUES ('FRT070217',98397457,17020701,1),('FRT070217',98397457,17020701,4),('FRT070217',98397457,17020701,5),('FRT070217',98397457,17020701,6),('JCE240217',98387688,17020701,1),('JCE240217',98387688,18050901,1),('CI24012017',7310586,17020701,1),('CI24012017',7310586,17020701,1),(NULL,NULL,NULL,NULL),('AI10122019',800118951,17020701,1),('AI10122019',800118951,17020701,1);
/*!40000 ALTER TABLE `contrato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dispositivo`
--

DROP TABLE IF EXISTS `dispositivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dispositivo` (
  `id_dispositivo` int(11) NOT NULL,
  `descripcion` varchar(40) DEFAULT NULL,
  `numero_telefono` varchar(20) DEFAULT NULL COMMENT 'Número telefónico',
  `imei` varchar(50) DEFAULT NULL COMMENT 'IMEI',
  `hardware` text DEFAULT NULL,
  `direccion` varchar(50) NOT NULL,
  PRIMARY KEY (`id_dispositivo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispositivo`
--

LOCK TABLES `dispositivo` WRITE;
/*!40000 ALTER TABLE `dispositivo` DISABLE KEYS */;
INSERT INTO `dispositivo` VALUES (17020701,'QLM7095','3175013250','1234567890','Arduino UNO ATMMega 328\r\nGPS Quectel L70\r\nGSM Quectel M95\r\nBoster DC-DC\r\nBatería LiPo 3.7V 1000mAh\r\n\r\nSensor de temperatura LM35\r\nSensor de Fuente de alimentación interno vía suministro de potencia micro USB.\r\nSensor de funcionamiento del compresor vía sensor de corriente efecto Hall','Datacenter Centro de Informática'),(17020702,'SIM908','3014290590','9334215','Arduino UNO ATMMega 328 SIM 908','Calle 13 # 39-30 Balcones de Pubenza'),(18050901,'DUEMILANOVE','3014290590','1234567890','Arduino Duemilanove\r\nSensor de temperatura DS18B20\r\n\r\nSensor de temperatura conectado directamente a un servidor via USB','Datacenter Centro de Informática');
/*!40000 ALTER TABLE `dispositivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro`
--

DROP TABLE IF EXISTS `registro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro` (
  `id_dispositivo` int(11) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `altitude` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_variable` int(11) DEFAULT NULL,
  `valor` varchar(16) DEFAULT NULL,
  KEY `id_dispositivo` (`id_dispositivo`),
  KEY `id_variable` (`id_variable`),
  KEY `fecha` (`fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro`
--

LOCK TABLES `registro` WRITE;
/*!40000 ALTER TABLE `registro` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variable`
--

DROP TABLE IF EXISTS `variable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variable` (
  `id_variable` int(11) NOT NULL,
  `descripcion` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id_variable`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variable`
--

LOCK TABLES `variable` WRITE;
/*!40000 ALTER TABLE `variable` DISABLE KEYS */;
INSERT INTO `variable` VALUES (1,'Temperatura'),(2,'Humedad Relativa'),(3,'Velocidad'),(4,'Alimentación (Red Eléctrica / Batería)'),(5,'Compresor (Encendido / Apagado)'),(6,'Posición ( Fijo / En movimiento)'),(7,'ICMP Round Trip Time'),(8,'ICMP Min Round Trip Time'),(9,'ICMP Max Round Trip Time'),(10,'ICMP Average Round Trip Time'),(11,'ICMP Lost Packets'),(12,'R Voltage'),(13,'S Voltage'),(14,'T Voltage');
/*!40000 ALTER TABLE `variable` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-07 17:55:17
