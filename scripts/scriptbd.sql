CREATE DATABASE  IF NOT EXISTS `tienditaonline` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tienditaonline`;
-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: tienditaonline
-- ------------------------------------------------------
-- Server version	9.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito` (
  `carrito_id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  `fecha_agregado` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`carrito_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`),
  CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito`
--

LOCK TABLES `carrito` WRITE;
/*!40000 ALTER TABLE `carrito` DISABLE KEYS */;
INSERT INTO `carrito` VALUES (9,2,3,1,'2024-11-30 16:51:43'),(13,3,16,3,'2024-12-01 11:35:59');
/*!40000 ALTER TABLE `carrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `categoria_id` int NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `categoria_padre_id` int DEFAULT NULL,
  PRIMARY KEY (`categoria_id`),
  KEY `categoria_padre_id` (`categoria_padre_id`),
  CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`categoria_padre_id`) REFERENCES `categorias` (`categoria_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Ropa',NULL),(2,'Fragancias',NULL),(3,'Zapatos',NULL),(4,'Peluches',NULL),(5,'Joyas',NULL),(7,'Lencería',NULL);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `pedido_id` int NOT NULL AUTO_INCREMENT,
  `venta_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`pedido_id`),
  KEY `venta_id` (`venta_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`venta_id`),
  CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (1,1,1,1,5.99),(2,1,1,1,5.99),(3,2,1,20,119.80),(4,3,1,11,65.89),(5,4,1,7,41.93),(6,5,2,2,7.98),(7,6,3,1,3.99),(8,7,4,3,100.35),(9,8,16,4,139.80),(10,9,16,4,139.80);
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `producto_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad_disponible` int NOT NULL,
  `categoria_id` int DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`producto_id`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Camisa negra','Camiseta negra de algodón para hombre',5.99,20,1,'camisanegra.jpg','activo','2024-11-25 16:00:02'),(2,'Locion hombre','Locion para hombre xd',3.99,30,2,'imagen_2024-11-29_170140041.png','activo','2024-11-29 17:01:43'),(3,'Camisa rosada','Camiseta rosada para hombre',3.99,80,1,'imagen_2024-11-30_132033415.png','activo','2024-11-30 13:20:12'),(4,'Pantalón Gris algodón','Pantalón para hombre color gris hecho en china',33.45,125,1,'pantalonGrisAlgodon.jpg','activo','2024-11-30 18:01:15'),(5,'Loción gabbana','Loción para hombre gabbana olor a purpura de nuez',54.99,30,2,'locionGabbana.jpg','activo','2024-11-30 18:04:34'),(6,'Jordan 1','Zapatos Jordan 1 color moca para hombre',89.99,38,3,'zapatosJordan1.jpg','activo','2024-11-30 18:07:07'),(7,'Oso de peluche zar','Oso de peluche de tamaño normal, algodón sintético color moca',19.99,73,4,'pelucheAlgodon.jpg','activo','2024-11-30 18:09:50'),(8,'Collar triple oro','Collar tipo tiburón esmeraldas, 3 kilates',124.99,20,5,'collarLindo.jpg','activo','2024-11-30 18:12:23'),(9,'Lencería roja','Ropa interior color roja, para piel suave, algodón picante del mar',27.89,45,7,'lence.jpg','activo','2024-11-30 18:14:14'),(10,'Jeans azules','Jeans algodón tipo polo',14.99,90,1,'jeans.jpg','activo','2024-11-30 18:23:06'),(11,'DJ Mario Loción','Loción para hombre de DJ Mario olor a rosas urbanas del siglo',44.55,35,2,'locionDJ.png','activo','2024-11-30 18:24:07'),(12,'Adidas zapatos','Zapatos Adidas color blancos, franjas verdes',45.79,35,3,'adidas.png','activo','2024-11-30 18:25:04'),(13,'Peluche rojo','Peluche rojo de Garfield de algodón',23.45,45,4,'pelucheRojo.png','activo','2024-11-30 18:25:56'),(14,'Pulsera de mano','Pulsera de mano oro puro 5 kilates',78.88,30,5,'joya.png','activo','2024-11-30 18:26:56'),(15,'Lencería negra','Lencería negra algodón piel de azúcar',34.55,34,7,'lence2.png','activo','2024-11-30 18:28:01'),(16,'Zapatos nike','Zapatos nike para hombres',34.95,20,3,'nike.png','activo','2024-12-01 11:35:24');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `usuario_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `rol` enum('cliente','admin') NOT NULL DEFAULT 'cliente',
  `fecha_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (2,'alvin','alvin@gmail.com','Norte, oeste del sur','44447777','$2y$10$Mkrz1AcYFO/ocjq5EriTf.2B6wEFmh6bFA6zQYOyTJKiSH6.QiEwu','cliente','2024-11-25 16:35:15'),(3,'jorge','jorge@gmail.com','por ahi','2323-3434','$2y$10$gs6gyBF7rZfXjE3p0hfRg.hqtAsFgR1G5AMGgBCJ.WQzRM9kfibne','cliente','2024-11-29 16:51:18'),(4,'Witty','witty@tiendita.com','Dirección de ejemplo','123456789','$2y$10$mt/AqOFvwB5kF1lSEoJi7.3mgRENrgmCfeqcgshF0R9HAMrWgV0gW','admin','2024-11-30 11:44:12'),(5,'Juan Pérez','juan@example.com','Av. Principal #123','5551234567','$2y$10$wixZDK52CjZY1is8FugFq.Hhg/MwkFEN/ikGBIGN0QizyyMT.gIWO','cliente','2024-11-30 21:44:49'),(6,'María López','maria@example.com','Calle Falsa #456','5557654321','$2y$10$Pw9AnxD4eIzCsKdISeQgnek8zzC4Xd2ZiBCa/n0oVEEwK7DQNeTde','cliente','2024-11-30 21:44:53'),(7,'Carlos Rivera','carlos@example.com','Calle Luna #789','5559876543','$2y$10$5iE8KWGNTzClo9ikWpJ4CubVqKsaG6f6yioT50FHixvkQiWYhQkUe','cliente','2024-11-30 21:44:57'),(9,'Sandra','sandra@gmail.com','San Miguel','3434-3434','$2y$10$zS8IbJnKvFYVFH08YXDabeM.taBe7I9TInpYFLCQGFeqq5H0OavpC','cliente','2024-12-01 11:37:23');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas` (
  `venta_id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `fecha_venta` datetime DEFAULT CURRENT_TIMESTAMP,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','completada','cancelada') NOT NULL DEFAULT 'pendiente',
  PRIMARY KEY (`venta_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (1,3,'2024-11-29 16:53:32',11.98,'pendiente'),(2,3,'2024-11-29 17:09:26',119.80,'pendiente'),(3,3,'2024-11-29 17:10:09',65.89,'pendiente'),(4,2,'2024-11-30 16:48:59',41.93,'pendiente'),(5,3,'2024-11-30 17:45:08',7.98,'pendiente'),(6,3,'2024-11-30 17:51:22',3.99,'pendiente'),(7,3,'2024-12-01 11:33:42',100.35,'pendiente'),(8,6,'2024-12-01 11:36:34',139.80,'pendiente'),(9,9,'2024-12-01 11:37:53',139.80,'pendiente');
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-03 20:51:50
