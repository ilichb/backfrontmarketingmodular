CREATE TABLE IF NOT EXISTS `categoria_servicios`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL UNIQUE,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

CREATE TABLE IF NOT EXISTS `servicios`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL UNIQUE,
    `estrategia` varchar(100) NOT NULL,
    `categoria_id` int,
    PRIMARY KEY (`id`),
    FOREIGN KEY (categoria_id) REFERENCES `categoria_servicios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `microservicios`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(300) NOT NULL UNIQUE,
    `valor_impacto` decimal(10, 2) NOT NULL,
    `valor_de_costo` decimal(10, 2) NOT NULL,
    `valor_de_ingreso` decimal(10, 2) NOT NULL,
    `gasto_publicidad` decimal(10, 2) NOT NULL,
    `servicio_id` INT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (servicio_id) REFERENCES `servicios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sector_economico` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(255) NOT NULL UNIQUE,
    `recomendaciones` text NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sector_microservicios` (
    `sector_id` int(11) NOT NULL,
    `microservicio_id` int(11) NOT NULL,
    PRIMARY KEY (`sector_id`, `microservicio_id`),
    FOREIGN KEY (`sector_id`) REFERENCES `sector_economico`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`microservicio_id`) REFERENCES `microservicios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `usuario` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL UNIQUE,
    `telefono`  varchar(100) NOT NULL,
    `pais` varchar(100),
    `ganancias` decimal(10, 2),
    `ventasTrimestr` decimal(10, 2),
    `empresa` varchar(255) NOT NULL UNIQUE,
    `sector` varchar(255) NOT NULL,
    `branding` decimal(10, 2) NOT NULL,
    `organicGrowth` decimal(10, 2) NOT NULL,
    `totalGrowth` decimal(10, 2) NOT NULL,
    `levelSEO` decimal(10, 2) NOT NULL,
    `microservicios` text NOT NULL,
    `estado` varchar(20) DEFAULT 'noAtendido',
    `eliminado` varchar(5) DEFAULT 'no',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `categoria_servicios` (nombre) VALUES ('Diseño'), ('Marketing'), ('Video');

INSERT INTO `servicios` (nombre, estrategia, categoria_id) VALUES ('Digital', 'branding', 1), ('Diseño 3D', 'branding', 1), ('Editorial', 'branding', 1), ('Fotografia', 'branding', 1), ('Identidad Corporativa', 'branding', 1), ('Ilustracion', 'branding', 1), ('Papeleria', 'branding', 1), ('Socialmedia', 'organicGrowth', 2), ('SEO', 'levelSEO', 2), ('SEM', 'levelSEO', 2), ('ADS Socialmedia', 'totalGrowth', 2);
