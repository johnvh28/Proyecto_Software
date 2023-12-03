/**Punto de referencia*/
INSERT INTO puntos_referencia (id,nombre, descripcion, cod_municipio) 
VALUES(1,'FRENTE DE LA CASIMIRO SOTELO', 'UNI-IES', 1);
/**Persona*/
INSERT INTO persona (id,nombre, telefono, id_punto_referencia, correo, foto, fecha_registro) 
VALUES(1,'Administrado Administrador', 123456789, 1, 'admin@SIRCOMD.com', 'admin.png', NOW());

/****Persona Natural*/
INSERT INTO persona_natural (id,id_persona, id_nacionalidad, id_genero, apellido, tipo_identificacion, identificacion, fecha_nacimiento) 
VALUES(1,1, 1, 2, 'Pérez', 'Cedula', '002-191190-1119W', '1990-05-15');

/***Empleado*/
INSERT INTO empleado (id,id_persona, id_estado_civil, cod_trabajador, codigo_inss, fecha_registro, estado)
VALUES(1,1, 1, 'T001', 'INSS123', '2023-01-10', 1);
/**TABLA salario*/
INSERT INTO salarios (id_empleado, salario, fecha_registro, fecha_cambio, estado) 
VALUES(1, 50000.00, '2023-01-01', NULL, 1);

/** INSERTAR CONTRATOS*/
INSERT INTO contratos (id_tipo, id_empleado, codigo, tomo, folio, contrato, fecha_vencimiento, fecha_cambio, estado) 
VALUES(1, 1, 'C001', 'Tomo1', 'Folio1', 'contratoejemplo.pdf', '2023-12-31', NULL, 1);

/**Usuario*/
INSERT INTO usuario (id,id_rol, id_persona, codigo, usuario, estado) 
VALUES(1,1, 1, 'U001', 'admin@SIRCOMD.com', 1);

/**Detalles Usuarios*/
INSERT INTO detalle_usuario(id,id_usuario,contraseña,estado) 
VALUES(1,1,'$2y$10$IVVz0jmn9toMAe0MSvifzexlg87hn0AQ7XrGvI0x28X/4nGBnLvH2',1);

INSERT INTO privilegio_rol (id, id_sub_modulo, id_usuario, autorizacion) VALUES
(1, 1, 1, 1),
(2, 29, 1, 1),
(3, 30, 1, 1),
(4, 26, 1, 1),
(5, 27, 1, 1),
(6, 28, 1, 1),
(7, 22, 1, 1),
(8, 23, 1, 1),
(9, 24, 1, 1),
(10, 25, 1, 1),
(11, 12, 1, 1),
(12, 13, 1, 1),
(13, 14, 1, 1),
(14, 15, 1, 1),
(15, 16, 1, 1),
(16, 17, 1, 1),
(17, 18, 1, 1),
(18, 19, 1, 1),
(19, 20, 1, 1),
(20, 21, 1, 1),
(21, 31, 1, 1),
(22, 32, 1, 1),
(23, 33, 1, 1),
(24, 34, 1, 1),
(25, 35, 1, 1),
(26, 36, 1, 1),
(27, 37, 1, 1),
(28, 38, 1, 1),
(29, 39, 1, 1),
(30, 40, 1, 1),
(31, 41, 1, 1),
(32, 42, 1, 1),
(33, 2, 1, 1),
(34, 3, 1, 1),
(35, 4, 1, 1),
(36, 5, 1, 1),
(37, 6, 1, 1),
(38, 7, 1, 1),
(39, 8, 1, 1),
(40, 9, 1, 1),
(41, 10, 1, 1),
(42, 11, 1, 1),
(43, 43, 1, 1);

INSERT INTO privilegio_permiso_rol (id, id_permiso, id_usuario, autorizacion) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 1, 1, 1),
(5, 2, 1, 1),
(6, 3, 1, 1),
(7, 4, 1, 1),
(8, 1, 1, 1),
(9, 2, 1, 1),
(10, 3, 1, 1),
(11, 5, 1, 1),
(12, 1, 1, 1),
(13, 2, 1, 1),
(14, 3, 1, 1),
(15, 4, 1, 1),
(16, 1, 1, 1),
(17, 2, 1, 1),
(18, 3, 1, 1),
(19, 5, 1, 1),
(20, 2, 1, 1),
(21, 3, 1, 1),
(22, 4, 1, 1),
(23, 10, 1, 1),
(24, 1, 1, 1),
(25, 2, 1, 1),
(26, 3, 1, 1),
(27, 4, 1, 1),
(28, 5, 1, 1),
(29, 1, 1, 1),
(30, 5, 1, 1),
(31, 6, 1, 1),
(32, 7, 1, 1),
(33, 8, 1, 1),
(34, 9, 1, 1);