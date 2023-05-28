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
    FOREIGN KEY (categoria_id) REFERENCES `categoria_servicios`(`id`)
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
    FOREIGN KEY (servicio_id) REFERENCES `servicios`(`id`)
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
    `empresa` varchar(255) NOT NULL UNIQUE,
    `sector` varchar(255) NOT NULL,
    `respuesta_algoritmo` text,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `categoria_servicios` (nombre) VALUES ('Diseño'), ('Marketing'), ('Video');

INSERT INTO `servicios` (nombre, estrategia, categoria_id) VALUES ('Digital', 'branding', 1), ('Diseño 3D', 'branding', 1), ('Editorial', 'branding', 1), ('Fotografia', 'branding', 1), ('Identidad Corporativa', 'branding', 1), ('Ilustracion', 'branding', 1), ('Papeleria', 'branding', 1), ('Socialmedia', 'organicGrowth', 2), ('SEO', 'levelSEO', 2), ('SEM', 'levelSEO', 2), ('Estrategia', 2), ('ADS Socialmedia', 'totalGrowth', 2);

INSERT INTO `microservicios` (nombre, valor_impacto, valor_de_costo, valor_de_ingreso, gasto_publicidad, servicio_id) VALUES ('Banner estático', 5.00, 25.00, 30.01, 15.01, 1), ('Banner animado gif', 5.00, 62.00, 20.01, 15.01, 1), ('Infografia', 5.00, 62.00, 20.01, 10.01, 1), ('Afiche - Poster', 5.00, 108.00, 20.01, 30.01, 3), ('Folleto: manual', 5.00, 75.00, 10.01, 30.01, 3), ('Flyer - volante', 5.00, 50.00, 30.01, 40.01, 3), ('Papelería comercial Editorial', 5.00, 112.00, 30.01, 60.01, 3), ('Flyer - volante (2 caras)', 5.00, 75.00, 120.01, 90.01, 3),('Sesión Fotográfica estudio por día', 5.00, 560.00, 88.01, 80.01, 4), ('Sesión Fotográfica locación por día ', 5.00, 502.00, 27.01, 15.01, 4), ('Foto de producto', 5.00, 126.00, 26.01, 10.01, 4), ('Pago por foto seleccionada', 5.00, 126.00, 20.01, 14.01, 4), ('Nuevo logotipo, Isotipo o Isologotipo + Manual de Uso y hasta 5 aplicaciones', 5.00, 385.00, 20.01, 10.01, 5), ('Rediseño identidad corporativa', 5.00, 314.00, 29.01, 18.01, 5), ('Manual de normal', 5.00, 490.00, 20.01, 19.01, 5), ('Logotipo', 5.00, 84.00, 20.01, 10.01, 5), ('Diseño de página simple', 5.00, 8.00, 20.01, 10.01, 8), ('Diseño de pagina compuesta', 5.00, 15.00, 10.01, 20.01, 8), ('Papelería básica', 5.00, 126.00, 20.01, 10.01, 8), ('Papelería comercial', 5.00, 112.00, 10.01, 20.01, 8);