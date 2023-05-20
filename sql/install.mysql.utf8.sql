CREATE TABLE IF NOT EXISTS `categoria_servicios`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

CREATE TABLE IF NOT EXISTS `servicios`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL,
    `categoria_id` int,
    PRIMARY KEY (`id`),
    FOREIGN KEY (categoria_id) REFERENCES `categoria_servicios`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `microservicios`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL,
    `valor_impacto` int(4) NOT NULL,
    `valor_de_costo` int(50) NOT NULL,
    `servicio_id` INT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (servicio_id) REFERENCES `servicios`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sector_economico` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(255) NOT NULL,
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
    `empresa` varchar(255) NOT NULL UNIQUE,
    `sector` varchar(255) NOT NULL,
    `respuesta_algoritmo` text,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
