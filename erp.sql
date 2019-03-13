-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.19 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para erp
DROP DATABASE IF EXISTS `erp`;
CREATE DATABASE IF NOT EXISTS `erp` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `erp`;

-- Volcando estructura para tabla erp.cliente
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `rut` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.cliente: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;

-- Volcando estructura para tabla erp.compra
DROP TABLE IF EXISTS `compra`;
CREATE TABLE IF NOT EXISTS `compra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proveedor_id` int(11) NOT NULL,
  `valor_neto` int(11) DEFAULT NULL,
  `valor_iva` int(11) DEFAULT NULL,
  `valot_total` int(11) DEFAULT NULL,
  `is_recepcionado` int(11) DEFAULT NULL,
  `is_pagado` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `doc_tipo_compra_id` int(11) NOT NULL,
  `ingreso_id` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_compra_proveedor1_idx` (`proveedor_id`),
  KEY `fk_compra_doc_tipo_compra1_idx` (`doc_tipo_compra_id`),
  KEY `fk_compra_ingreso1_idx` (`ingreso_id`),
  CONSTRAINT `fk_compra_doc_tipo_compra1` FOREIGN KEY (`doc_tipo_compra_id`) REFERENCES `doc_tipo_compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_compra_ingreso1` FOREIGN KEY (`ingreso_id`) REFERENCES `movimiento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_compra_proveedor1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.compra: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `compra` ENABLE KEYS */;

-- Volcando estructura para tabla erp.compra_detalle
DROP TABLE IF EXISTS `compra_detalle`;
CREATE TABLE IF NOT EXISTS `compra_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `valor_neto` varchar(100) DEFAULT NULL,
  `valor_iva` varchar(100) DEFAULT NULL,
  `valot_total` varchar(100) DEFAULT NULL,
  `cantidad_comprada` varchar(100) DEFAULT NULL,
  `cantidad_disponible` varchar(100) DEFAULT NULL,
  `is_recepcionado` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_compra_detalle_producto1_idx` (`producto_id`),
  KEY `fk_compra_detalle_compra1_idx` (`compra_id`),
  CONSTRAINT `fk_compra_detalle_compra1` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_compra_detalle_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.compra_detalle: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `compra_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `compra_detalle` ENABLE KEYS */;

-- Volcando estructura para tabla erp.doc_tipo_compra
DROP TABLE IF EXISTS `doc_tipo_compra`;
CREATE TABLE IF NOT EXISTS `doc_tipo_compra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.doc_tipo_compra: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `doc_tipo_compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `doc_tipo_compra` ENABLE KEYS */;

-- Volcando estructura para tabla erp.familia
DROP TABLE IF EXISTS `familia`;
CREATE TABLE IF NOT EXISTS `familia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `linea_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_familia_linea1_idx` (`linea_id`),
  CONSTRAINT `fk_familia_linea1` FOREIGN KEY (`linea_id`) REFERENCES `linea` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.familia: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `familia` DISABLE KEYS */;
/*!40000 ALTER TABLE `familia` ENABLE KEYS */;

-- Volcando estructura para tabla erp.inventario
DROP TABLE IF EXISTS `inventario`;
CREATE TABLE IF NOT EXISTS `inventario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) DEFAULT NULL,
  `fecha` varchar(100) DEFAULT NULL,
  `ubicacion_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `familia_id` int(11) NOT NULL,
  `linea_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_inventario_ubicacion1_idx` (`ubicacion_id`),
  KEY `fk_inventario_producto1_idx` (`producto_id`),
  KEY `fk_inventario_familia1_idx` (`familia_id`),
  KEY `fk_inventario_linea1_idx` (`linea_id`),
  CONSTRAINT `fk_inventario_familia1` FOREIGN KEY (`familia_id`) REFERENCES `familia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inventario_linea1` FOREIGN KEY (`linea_id`) REFERENCES `linea` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inventario_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inventario_ubicacion1` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.inventario: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `inventario` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventario` ENABLE KEYS */;

-- Volcando estructura para tabla erp.inventario_unidad
DROP TABLE IF EXISTS `inventario_unidad`;
CREATE TABLE IF NOT EXISTS `inventario_unidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventario_id` int(11) NOT NULL,
  `unidad_id` int(11) NOT NULL,
  `existente` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_inventario_unidad_inventario1_idx` (`inventario_id`),
  KEY `fk_inventario_unidad_unidad1_idx` (`unidad_id`),
  CONSTRAINT `fk_inventario_unidad_inventario1` FOREIGN KEY (`inventario_id`) REFERENCES `inventario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inventario_unidad_unidad1` FOREIGN KEY (`unidad_id`) REFERENCES `unidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.inventario_unidad: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `inventario_unidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventario_unidad` ENABLE KEYS */;

-- Volcando estructura para tabla erp.linea
DROP TABLE IF EXISTS `linea`;
CREATE TABLE IF NOT EXISTS `linea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.linea: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `linea` DISABLE KEYS */;
/*!40000 ALTER TABLE `linea` ENABLE KEYS */;

-- Volcando estructura para tabla erp.marca
DROP TABLE IF EXISTS `marca`;
CREATE TABLE IF NOT EXISTS `marca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.marca: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;

-- Volcando estructura para tabla erp.movimiento
DROP TABLE IF EXISTS `movimiento`;
CREATE TABLE IF NOT EXISTS `movimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` varchar(100) DEFAULT NULL,
  `cantidad` varchar(100) DEFAULT NULL,
  `movimiento_tipo_id` int(11) NOT NULL,
  `ubicacion_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ingreso_ingreso_tipo1_idx` (`movimiento_tipo_id`),
  KEY `fk_ingreso_ubicacion1_idx` (`ubicacion_id`),
  CONSTRAINT `fk_ingreso_ingreso_tipo1` FOREIGN KEY (`movimiento_tipo_id`) REFERENCES `movimiento_tipo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingreso_ubicacion1` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.movimiento: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `movimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `movimiento` ENABLE KEYS */;

-- Volcando estructura para tabla erp.movimiento_tipo
DROP TABLE IF EXISTS `movimiento_tipo`;
CREATE TABLE IF NOT EXISTS `movimiento_tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `is_ingreso` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.movimiento_tipo: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `movimiento_tipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `movimiento_tipo` ENABLE KEYS */;

-- Volcando estructura para tabla erp.parametros
DROP TABLE IF EXISTS `parametros`;
CREATE TABLE IF NOT EXISTS `parametros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `valor` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.parametros: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;

-- Volcando estructura para tabla erp.periodo_contable
DROP TABLE IF EXISTS `periodo_contable`;
CREATE TABLE IF NOT EXISTS `periodo_contable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mes` varchar(100) DEFAULT NULL,
  `anio` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.periodo_contable: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `periodo_contable` DISABLE KEYS */;
/*!40000 ALTER TABLE `periodo_contable` ENABLE KEYS */;

-- Volcando estructura para tabla erp.producto
DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `codigo_ean13` varchar(100) DEFAULT NULL,
  `codigo_erp` varchar(100) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `unidad_medida_id` int(11) NOT NULL,
  `familia_id` int(11) NOT NULL,
  `marca_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_producto_unidad_medida1_idx` (`unidad_medida_id`),
  KEY `fk_producto_familia1_idx` (`familia_id`),
  KEY `fk_producto_marca1_idx` (`marca_id`),
  CONSTRAINT `fk_producto_familia1` FOREIGN KEY (`familia_id`) REFERENCES `familia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_marca1` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_unidad_medida1` FOREIGN KEY (`unidad_medida_id`) REFERENCES `unidad_medida` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.producto: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;

-- Volcando estructura para tabla erp.proveedor
DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE IF NOT EXISTS `proveedor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `rut` varchar(100) DEFAULT NULL,
  `giro` varchar(100) DEFAULT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.proveedor: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;

-- Volcando estructura para tabla erp.ubicacion
DROP TABLE IF EXISTS `ubicacion`;
CREATE TABLE IF NOT EXISTS `ubicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL COMMENT 'Nombre de la sucursal',
  `direccion` varchar(100) DEFAULT NULL COMMENT 'Direccion de la sucursal',
  `is_venta` int(11) DEFAULT NULL COMMENT 'Determina si en esta sucursal se permite vender',
  `is_bodega` int(11) DEFAULT NULL COMMENT 'Determina si en esta sucursal se almacenan los productos',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.ubicacion: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `ubicacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `ubicacion` ENABLE KEYS */;

-- Volcando estructura para tabla erp.unidad
DROP TABLE IF EXISTS `unidad`;
CREATE TABLE IF NOT EXISTS `unidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ubicacion_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `valor_venta` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_producto_ubicacion_ubicacion1_idx` (`ubicacion_id`),
  KEY `fk_unidad_producto1_idx` (`producto_id`),
  CONSTRAINT `fk_producto_ubicacion_ubicacion1` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_unidad_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.unidad: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `unidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `unidad` ENABLE KEYS */;

-- Volcando estructura para tabla erp.unidad_medida
DROP TABLE IF EXISTS `unidad_medida`;
CREATE TABLE IF NOT EXISTS `unidad_medida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.unidad_medida: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `unidad_medida` DISABLE KEYS */;
/*!40000 ALTER TABLE `unidad_medida` ENABLE KEYS */;

-- Volcando estructura para tabla erp.unidad_movimiento
DROP TABLE IF EXISTS `unidad_movimiento`;
CREATE TABLE IF NOT EXISTS `unidad_movimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movimiento_id` int(11) NOT NULL,
  `unidad_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_unidad_ingreso_ingreso1_idx` (`movimiento_id`),
  KEY `fk_unidad_ingreso_unidad1_idx` (`unidad_id`),
  CONSTRAINT `fk_unidad_ingreso_ingreso1` FOREIGN KEY (`movimiento_id`) REFERENCES `movimiento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_unidad_ingreso_unidad1` FOREIGN KEY (`unidad_id`) REFERENCES `unidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.unidad_movimiento: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `unidad_movimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `unidad_movimiento` ENABLE KEYS */;

-- Volcando estructura para tabla erp.venta
DROP TABLE IF EXISTS `venta`;
CREATE TABLE IF NOT EXISTS `venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ventacol` varchar(100) DEFAULT NULL,
  `venta_estado_id` int(11) NOT NULL,
  `movimiento_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_venta_venta_estado1_idx` (`venta_estado_id`),
  KEY `fk_venta_movimiento1_idx` (`movimiento_id`),
  KEY `fk_venta_cliente1_idx` (`cliente_id`),
  CONSTRAINT `fk_venta_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_venta_movimiento1` FOREIGN KEY (`movimiento_id`) REFERENCES `movimiento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_venta_venta_estado1` FOREIGN KEY (`venta_estado_id`) REFERENCES `venta_estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.venta: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;

-- Volcando estructura para tabla erp.venta_detalle
DROP TABLE IF EXISTS `venta_detalle`;
CREATE TABLE IF NOT EXISTS `venta_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor_unitario` varchar(100) DEFAULT NULL,
  `cantidad_vendida` varchar(100) DEFAULT NULL,
  `valor_neto` varchar(100) DEFAULT NULL,
  `valor_iva` varchar(100) DEFAULT NULL,
  `valot_total` varchar(100) DEFAULT NULL,
  `venta_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_venta_detalle_venta1_idx` (`venta_id`),
  KEY `fk_venta_detalle_producto1_idx` (`producto_id`),
  CONSTRAINT `fk_venta_detalle_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_venta_detalle_venta1` FOREIGN KEY (`venta_id`) REFERENCES `venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.venta_detalle: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `venta_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta_detalle` ENABLE KEYS */;

-- Volcando estructura para tabla erp.venta_estado
DROP TABLE IF EXISTS `venta_estado`;
CREATE TABLE IF NOT EXISTS `venta_estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `habilitado` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp.venta_estado: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `venta_estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta_estado` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
