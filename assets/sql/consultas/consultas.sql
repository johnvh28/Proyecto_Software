-- Active: 1701499476261@@127.0.0.1@3306@voguenook
SELECT m.COD_MODULO, m.NOMBRE AS modulo_nombre, m.ICONO AS modulo_icono, 
        sm.COD_SUB_MODULO, sm.NOMBRE AS submodulo_nombre, sm.ENLACES AS submodulo_enlaces
        FROM TB_ROL_PRIVILEGIO pr
        JOIN CAT_ROL r ON r.COD_ROL = pr.COD_ROL
        JOIN DETALLE_USUARIO du ON du.COD_ROL = r.COD_ROL
        JOIN MODULO m ON m.COD_MODULO = pr.COD_MODULO
        JOIN SUB_MODULO sm ON sm.COD_MODULO = m.COD_MODULO AND sm.COD_SUB_MODULO = pr.COD_SUB_MODULO
        WHERE du.COD_USER =1;
SELECT pr.id_sub_modulo,m.id AS id_modulo, m.nombre AS modulo, m.icono, sm.nombre AS submodulo, sm.enlace FROM privilegio_rol pr 
INNER JOIN rol r ON r.id =pr.id_usuario
INNER JOIN sub_modulo sm ON  sm.id = pr.id_sub_modulo
INNER JOIN modulo m ON m.id = sm.id_modulo
LEFT JOIN usuario U ON r.id = U.id_rol
LEFT JOIN usuario US ON pr.autorizacion = US.id
WHERE u.id = 1;     

SELECT pm.id AS id_permiso_modulo, m.id AS id_modulo, m.nombre AS nombre_modulo, p.id AS id_permiso, p.nombre AS nombre_permiso, p.descripcion AS descripcion_permiso
              FROM modulo m
              INNER JOIN permiso_modulo pm ON m.id = pm.id_modulo
              INNER JOIN permiso p ON pm.id_permiso = p.id
              WHERE m.estado = 1

SELECT * FROM detalle_usuario;


SELECT * FROM privilegio_permiso_rol



SELECT c.*,u.usuario,r.nombre AS rol FROM conexion c
         INNER JOIN usuario u ON u.id = c.id_usuario
         INNER JOIN rol  r ON r.id =u.id_rol
         INNER JOIN perfil p On p.id=r.id_perfil
         WHERE c.estado = 1 AND r.id_perfil != 2

SELECT r.*,p.nombre FROM rol r
INNER JOIN perfil p ON p.id = r.id_perfil



SELECT r.id, r.nombre
FROM rol r
LEFT JOIN privilegio_rol pr ON r.id = pr.id_usuario
WHERE pr.id_usuario IS NULL;


SELECT us.usuario AS autorizado, u.nombre AS grupo, u.id AS id_usuario,u.nombre,GROUP_CONCAT(CONCAT(m.nombre, ' - ', sm.nombre) ORDER BY m.nombre SEPARATOR ', ') AS usuario_modulos_submodulos, u.estado AS rol_estado,   
        COUNT(DISTINCT sm.id_modulo) AS cantidad_modulos_asignados
        FROM privilegio_rol pu 
        JOIN sub_modulo sm ON sm.id = pu.id_sub_modulo 
        LEFT JOIN modulo m ON sm.id_modulo = m.id 
        JOIN rol u ON u.id = pu.id_usuario
        LEFT JOIN usuario us ON us.id=pu.autorizacion
        GROUP BY u.nombre


SELECT c.id AS categoria_id, c.nombre AS categoria, sc.id AS subcategoria_id, sc.nombre AS subcategoria
FROM (
    SELECT id, nombre
    FROM categorias
    LIMIT 3
) c
LEFT JOIN subcategorias sc ON c.id = sc.categoria_id;

SELECT u.usuario, e.cod_trabajador, p.nombre,pn.apellido FROM usuario u
LEFT JOIN empleado e ON u.id_persona =e.id_persona
LEFT JOIN persona p ON e.id_persona = p.id
LEFT JOIN persona_natural pn ON p.id = pn.id_persona
WHERE u.id = 1



SELECT rt.*, us.usuario AS autorizado FROM roles_temporales rt  
JOIN rol r ON rt.id_rol = r.id
 JOIN usuario e ON e.id = rt.id_usuario
 JOIN usuario us ON rt.autorizado =us.id
WHERE e.id = 2

SELECT * FROM roles_temporales WHERE id_usuario = 2;

SELECT r.id, r.nombre
FROM rol r
LEFT JOIN roles_temporales rt ON r.id = rt.id_rol
LEFT JOIN usuario u ON r.id = u.id_rol
WHERE rt.id_rol IS NULL AND u.id_rol IS NULL


SELECT pr.id_sub_modulo, m.id AS id_modulo, m.nombre AS modulo, m.icono, sm.nombre AS submodulo, sm.enlace, rt.id_rol AS id_rol_temporal
        FROM privilegio_rol pr 
        INNER JOIN sub_modulo sm ON sm.id = pr.id_sub_modulo
        INNER JOIN modulo m ON m.id = sm.id_modulo
        LEFT JOIN roles_temporales rt ON rt.id_rol = pr.id_usuario
        LEFT JOIN usuario u ON rt.id = u.id_rol
        WHERE rt.id_usuario = 2 AND rt.estado = 1

SELECT * FROM rol;
SELECT id, nombre
FROM rol
WHERE NOT EXISTS (
    SELECT id_rol
    FROM roles_temporales
    WHERE roles_temporales.id_rol = rol.id
    UNION
    SELECT id_rol
    FROM usuario
    WHERE usuario.id = 1 AND usuario.id_rol = rol.id
);

SELECT p.*, sc.nombre,c.nombre FROM productos p
INNER JOIN subcategorias sc ON sc.id = p.subcategoria_id
INNER JOIN categorias c ON  c.id = sc.categoria_id

SELECT * from color c
 WHERE c.id NOT IN (SELECT id_color FROM producto_color pc WHERE 
                    pc.id_color = c.id)

SELECT * FROM productos p
LEFT JOIN subcategorias sc ON p.subcategoria_id =p.id
LEFT JOIN producto_color pc ON p.id =pc.id_producto
LEFT JOIN producto_manga pm ON p.id = pm.id_producto
LEFT JOIN producto_talla pt ON p.id = pt.id_producto
LEFT JOIN color c ON pc.id_color = pc.id_color

SELECT * FROM permiso;

SELECT * FROM modulo;


INSERT INTO permiso_modulo (id,id_modulo, id_permiso)
VALUES
(1,2, 1), (2,2, 2), (3,2, 3), (4,2, 4),
(5,3, 1), (6,3, 2), (7,3, 3),(8,3, 5),
(9,4, 1), (10,4, 2), (11,4, 3),(12,4, 4),
(13,5, 1), (14,5, 2), (15,5, 3),(16,5, 5),
(17,6, 1), (18,6, 2), (19,6, 3),
(20,7, 1), (21,7, 2), (22,7, 3),(23,7, 4),(24,7,5),
(25,8, 1), (26,8, 5), (27,8, 6), (28,8, 7),
(29,8, 8), (30,8, 9), (31,9, 2), (32,9, 3),(33,9,4),(34,9,10);


SELECT * FROM permiso_modulo



SELECT u.usuario AS autorizado, r.id AS id_usuario,r.nombre,GROUP_CONCAT(CONCAT(m.nombre, ' - ', per.nombre) ORDER BY m.nombre SEPARATOR ', ') AS usuario_modulos_submodulos, r.estado AS rol_estado,   
        COUNT(DISTINCT pu.id_permiso) AS cantidad_permisos
        FROM privilegio_permiso_rol pu 
        JOIN permiso_modulo sm ON sm.id = pu.id_permiso
        JOIN permiso per ON per.id = sm.id_permiso
        JOIN modulo m ON m.id = sm.id_modulo 
        JOIN usuario u ON u.id = pu.autorizacion
        JOIN rol r ON r.id = pu.id_usuario
        GROUP BY r.nombre


SELECT pm.id AS id_permiso_modulo, m.id AS id_modulo, m.nombre AS nombre_modulo, p.id AS id_permiso, p.nombre AS nombre_permiso, p.descripcion AS descripcion_permiso
              FROM modulo m
              INNER JOIN permiso_modulo pm ON m.id = pm.id_modulo
              INNER JOIN permiso p ON pm.id_permiso = p.id
              WHERE m.estado = 1  NOT IN (SELECT pp.id_permiso FROM privilegio_permiso_rol pp WHERE 
                    pp.id_usuario =1)


SELECT m.id AS modulo_id, m.nombre AS modulo_nombre, 
                        sm.id AS submodulo_id, sm.nombre AS submodulo_nombre
            FROM modulo m 
            LEFT JOIN sub_modulo sm ON m.id = sm.id_modulo
            WHERE sm.id NOT IN (SELECT pu.id_sub_modulo FROM privilegio_rol pu WHERE 
                    pu.id_usuario = 1)


SELECT pm.id AS id_permiso_modulo, m.id AS id_modulo, m.nombre AS nombre_modulo, p.id AS id_permiso, p.nombre AS nombre_permiso, p.descripcion AS descripcion_permiso
              FROM modulo m
              INNER JOIN permiso_modulo pm ON m.id = pm.id_modulo
              INNER JOIN permiso p ON pm.id_permiso = p.id
              WHERE m.estado = 1 IN (SELECT id_permiso FROM privilegio_permiso_rol pp WHERE 
                    pp.id_usuario = 1)


INSERT INTO sub_modulo(id, id_modulo, nombre, descripcion, enlace, estado)
 VALUES (43,8,'Configuracion','Modulo de caja','index.php?c=caja&a=configuracion',1);

SELECT 
        pu.id AS privilegio_id,
        m.id AS modulo_id,
        m.nombre AS modulo_nombre,
        sm.id AS submodulo_id,
        sm.nombre AS submodulo_nombre
        FROM 
        privilegio_rol pu
        INNER JOIN 
        sub_modulo sm ON pu.id_sub_modulo = sm.id
        LEFT JOIN 
        modulo m ON sm.id_modulo = m.id
        WHERE 
        pu.id_usuario = 1
        ORDER BY
        privilegio_id, modulo_id, submodulo_id;
  
        
SELECT pp.id AS id_permiso_modulo, m.id AS id_modulo, m.nombre AS nombre_modulo, p.id AS id_permiso, p.nombre AS nombre_permiso, p.descripcion AS descripcion_permiso
FROM privilegio_permiso_rol pp
INNER JOIN permiso_modulo pm ON pp.id_permiso = pm.id_permiso
INNER JOIN modulo m ON m.id = pm.id_modulo
INNER JOIN permiso p ON p.id = pm.id_permiso
WHERE pp.id_usuario = 1
ORDER BY id_modulo;

SELECT  p.*, sc.nombre AS sub, c.nombre AS categoria, pp.precio_venta AS precio 
FROM productos p 
INNER JOIN subcategorias sc ON sc.id = p.subcategoria_id
INNER JOIN categorias c ON sc.categoria_id = sc.id
INNER JOIN precios_productos pp ON p.id = pp.producto_id WHERE p.estado =1 


SELECT p.nombre, pp.precio_venta AS precio FROM productos p
JOIN precios_productos pp ON pp.producto_id = p.id 
JOIN producto_color pt ON pt.id_producto =p.id
WHERE p.estado = 1 AND pt.id_color = 1



SELECT  pr.*, m.nombre AS municipio,d.nombre AS departamento,
        m.id AS municipios
        FROM persona p
        LEFT JOIN puntos_referencia pr ON p.id_punto_referencia = pr.id
        LEFT JOIN municipio m ON pr.cod_municipio = m.id
        LEFT JOIN departamento d ON m.cod_departamento = d.id
        Where p.id =2