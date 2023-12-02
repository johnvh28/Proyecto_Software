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



SELECT * FROM detalle_usuario;



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
LEFT JOIN color c ON pc.id_color = c.id
LEFT JOIN manga m ON pm.id_manga = m.id
LEFT JOIN tallas t ON pt.id_talla = t.id


SELECT  p.*, sc.nombre AS sub, c.nombre AS categoria, pp.precio_venta AS precio FROM productos p 
INNER JOIN subcategorias sc ON sc.id = p.subcategoria_id
INNER JOIN categorias c ON sc.categoria_id = sc.id
LEFT JOIN precios_productos pp ON p.id = pp.producto_id



SELECT DISTINCT p.*, sc.nombre AS sub, c.nombre AS categoria, pp.precio_venta AS precio
FROM productos p 
INNER JOIN subcategorias sc ON sc.id = p.subcategoria_id
INNER JOIN categorias c ON sc.categoria_id = c.id
LEFT JOIN precios_productos pp ON p.id = pp.producto_id
WHERE p.estado = 1;
