CREATE TABLE IF NOT EXISTS `categoria_servicios`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL UNIQUE,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

CREATE TABLE IF NOT EXISTS `servicios`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL UNIQUE,
    `categoria_id` int,
    PRIMARY KEY (`id`),
    FOREIGN KEY (categoria_id) REFERENCES `categoria_servicios`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `microservicios`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(300) NOT NULL UNIQUE,
    `valor_impacto` int(4) NOT NULL,
    `valor_de_costo` decimal(10, 2),
    `valor_de_ingreso` decimal(10, 2),
    `gasto_publicidad` decimal(10, 2),
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

INSERT INTO `servicios` (nombre, categoria_id) VALUES ('Digital', 1), ('Diseño 3D', 1), ('Editorial', 1), ('Fotografia', 1), ('Identidad Corporativa', 1), ('Ilustracion', 1), ('Packing', 1), ('Papeleria', 1), ('Socialmedia', 2), ('SEO', 2), ('SEM', 2), ('Estrategia', 2), ('ADS Socialmedia', 2), ('Edicion', 3);

INSERT INTO `microservicios` (nombre, valor_impacto, valor_de_costo, servicio_id) VALUES ('Banner estático', 0, 25.00, 0.01, 0.01, 1), ('Banner animado gif', 0, 62.00, 0.01, 0.01, 1), ('Infografia', 0, 62.00, 0.01, 0.01, 1), ('Desarrollo de presentacion digital (20 diapositivas)', 0, 100.00, 0.01, 0.01, 1), ('Diseño de pie de firma (Firma o encabezado de e-mail)', 0, 34.00, 0.01, 0.01, 1), ('Diseño de icono', 0, 34.00, 0.01, 0.01, 1), ('Diseño de plantilla para mailing', 0, 34.00, 0.01, 0.01, 1), ('Diseño de e-mailing', 0, 42.00, 0.01, 0.01, 1), ('Diseño responsive', 2, 126.00, 0.01, 0.01, 1), ('Diseño UX/UI para web', 0, 234.00, 0.01, 0.01, 1), ('Diseño UX/UI para APP', 0, 234.00, 0.01, 0.01, 1), ('Desarrolllo de presentacion digital Portfolios, brochure, etc', 0, 126.00, 0.01, 0.01, 1), ('Afiche - Poster', 0, 108.00, 0.01, 0.01, 3), ('Folleto: manual', 0, 75.00, 0.01, 0.01, 3), ('Flyer - volante', 0, 50.00, 0.01, 0.01, 3), ('Papelería comercial Editorial', 0, 112.00, 0.01, 0.01, 3), ('Flyer - volante (2 caras)', 0, 75.00, 0.01, 0.01, 3), ('Portada y contraportada folleto', 0, 67.00, 0.01, 0.01, 3), ('Diseño de 1 pagina para catálogo', 0, 8.00, 0.01, 0.01, 3), ('Folleto díptico', 0, 84.00, 0.01, 0.01, 3), ('Folleto tríptico', 0, 150.00, 0.01, 0.01, 3), ('Brochure 10 páginas', 0, 188.00, 0.01, 0.01, 3), ('Brochure 20 páginas', 0, 276.00, 0.01, 0.01, 3), ('Diseño de portada', 0, 84.00, 0.01, 0.01, 3), ('Maquetacion de texto corrido, novela, poemario, etc (por página)', 0, 0.00, 0.01, 0.01, 3), ('Maquetacion de texto con imagenes, tablas (Por página)', 0, 0.00, 0.01, 0.01, 3), ('Maquetacion y diseño interior de libros infantiles (Por página)', 0, 0.00, 0.01, 0.01, 3), ('Maquetacion y diseño de revistas (Por página)', 0, 0.00, 0.01, 0.01, 3), ('Corrección ortotipográfica', 0, 0.00, 0.01, 0.01, 3), ('Corrección de estilo', 0, 0.00, 0.01, 0.01, 3), ('Sesión Fotográfica estudio por día', 0, 560.00, 0.01, 0.01, 4), ('Sesión Fotográfica locación por día ', 0, 502.00, 0.01, 0.01, 4), ('Foto de producto', 0, 126.00, 0.01, 0.01, 4), ('Pago por foto seleccionada', 0, 126.00, 0.01, 0.01, 4), ('Nuevo logotipo, Isotipo o Isologotipo + Manual de Uso y hasta 5 aplicaciones', 0, 385.00, 0.01, 0.01, 5), ('Rediseño identidad corporativa', 0, 314.00, 0.01, 0.01, 5), ('Manual de normal', 0, 490.00, 0.01, 0.01, 5), ('Logotipo', 0, 84.00, 0.01, 0.01, 5), ('Vectorización de logo', 0, 16.00, 0.01, 0.01, 5), ('Ilustración a mano alzada I.C.', 0, 126.00, 0.01, 0.01, 5), ('Refrescamiento logo', 0, 251.00, 0.01, 0.01, 5), ('Manual de normas de uso', 0, 126.00, 0.01, 0.01, 5), ('Naming corporativo / institucional', 0, 126.00, 0.01, 0.01, 5), ('Slogan/Lema', 0, 92.00, 0.01, 0.01, 5), ('Digitalización (Vectorizar)', 0, 12.55, 0.01, 0.01, 6), ('Caricatura', 0, 8.00, 0.01, 0.01, 6), ('Boceto a lápiz', 0, 10.00, 0.01, 0.01, 6), ('Ilustración Vectorial', 0, 25.00, 0.01, 0.01, 6), ('Ilustración a mano alzada', 0, 34.00, 0.01, 0.01, 6), ('Etiqueta de vino', 0, 251.00, 0.01, 0.01, 7), ('Diseño de envase de baja complejidad', 0, 34.00, 0.01, 0.01, 7), ('Diseño de envase de mediana complejidad', 0, 75.00, 0.01, 0.01, 7), ('Diseño de envase alta complejidad', 0, 112.00, 0.01, 0.01, 7), ('Diseño de página simple', 0, 8.00, 0.01, 0.01, 8), ('Diseño de pagina compuesta', 0, 15.00, 0.01, 0.01, 8), ('Papelería básica', 0, 126.00, 0.01, 0.01, 8), ('Papelería comercial', 0, 112.00, 0.01, 0.01, 8), ('Diseño de carpeta institucional', 0, 29.00, 0.01, 0.01, 8), ('Diseño de hojas membretadas', 0, 16.00, 0.01, 0.01, 8), ('Diseño de sobres', 0, 25.00, 0.01, 0.01, 8), ('Tarjetas para eventos', 0, 25.00, 0.01, 0.01, 8), ('Tarjetas de Presentación', 0, 12.55, 0.01, 0.01, 8), ('Social Media Plan', 0, 292.00, 0.01, 0.01, 9), ('Gráfica para red social', 0, 16.00, 0.01, 0.01, 9), ('Informe social media', 0, 150.00,0.01, 0.01, 9), ('Creacion de perfil, fan page, cuenta, canal, etc', 0, 50.00, 0.01, 0.01, 9), ('Posteo/publicacion de enlace (noticia o similar)', 0, 8.00, 0.01, 0.01, 9), ('Diseño de avatar para red social', 0, 8.00, 0.01, 0.01, 9), ('Redes sociales: gif animado para posteo', 0, 59.00, 0.01, 0.01, 9), ('Concurso en Muro (1 pieza original + 2 adaptaciones, redacción de bases y condiciones, sorteo, informe final)', 0, 126.00, 0.01, 0.01, 9), ('10 publicaciones para redes sociales', 0, 188.00, 0.01, 0.01, 9), ('10 imagenes para redes sociales', 0, 188.00, 0.01, 0.01, 9), ('Plan SEO', 0, 84.00, 0.01, 0.01, 10), ('Investigacion Keywords', 0, 193.00, 0.01, 0.01, 10), ('4 articulos SEO', 0, 16.00, 0.01, 0.01, 10), ('SEO Técnico', 0, 0.00, 0.01, 0.01, 10), ('Construcción de Backlinks', 0, 0.00, 0.01, 0.01, 10), ('Auditoria General', 0, 0.00, 0.01, 0.01, 10), ('Reestructuracion de Artículos', 0, 0.00, 0.01, 0.01, 10), ('Video corporativo 60 segundos', 0, 670.00, 0.01, 0.01, 14), ('Video Corporativo 60 segundos, material entregado por cliente', 0, 502.00, 0.01, 0.01, 14), ('Video con croma', 0, 502.00, 0.01, 0.01, 14), ('Video Redes Sociales Tipo infografia', 0, 210.00, 0.01, 0.01, 14), ('Video YouTube', 0, 210.00, 0.01, 0.01, 14), ('Video Rells', 0, 0.00, 0.01, 0.01, 14), ('Video Square', 0, 0.00, 0.01, 0.01, 14);