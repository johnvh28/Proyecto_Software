/***MARCAS*/
INSERT INTO marcas (id,nombre, descripcion, estado) VALUES
  (1,'Adidas', 'Marca deportiva mundialmente reconocida', 1),
  (2,'Nike', 'Otra marca deportiva muy popular', 1),
  (3,'Levi\'s', 'Marca de ropa vaquera', 1),
  (4,'Gucci', 'Marca de lujo italiana', 1),
  (5,'H&M', 'Marca de moda asequible', 1),
  (6,'Zara', 'Marca de moda global', 1),
  (7,'Apple', 'Marca de productos electrónicos', 1),
  (8,'Samsung', 'Otra marca de productos electrónicos', 1),
  (9,'Coca-Cola', 'Marca de bebidas', 1),
  (10,'Pepsi', 'Otra marca de bebidas', 1);

INSERT INTO modelos (id,marca_id, nombre, descripcion, estado) VALUES
  (1,1, 'Camisa Casual Rayada', 'Camisa de manga larga para uso diario', 1),
  (2,1, 'Pantalones Vaqueros Slim Fit', 'Pantalones vaqueros ajustados y modernos', 1),
  (3,2, 'Vestido Floral Veraniego', 'Vestido ligero con estampado floral', 1),
  (4,2, 'Chaqueta de Punto Elegante', 'Chaqueta de punto para ocasiones formales', 1),
  (5,3, 'Suéter de Cuello Alto', 'Suéter cómodo con cuello alto', 1),
  (6,3, 'Pantalones Chinos Clásicos', 'Pantalones chinos para un look casual', 1),
  (7,4, 'Blusa de Seda', 'Blusa elegante hecha de seda', 1),
  (8,4, 'Pantalones de Traje', 'Pantalones formales para eventos especiales', 1),
  (9,5, 'Camiseta Básica de Algodón', 'Camiseta básica y cómoda', 1),
  (10,5, 'Shorts Deportivos Transpirables', 'Shorts ideales para actividades deportivas', 1);

INSERT INTO tallas (id,nombre, descripcion, estado) VALUES
  (1,'S', 'Pequeña', 1),
  (2,'M', 'Mediana', 1),
  (3,'L', 'Grande', 1),
  (4,'XL', 'Extra Grande', 1),
  (5,'XXL', 'Doble Extra Grande', 1),
  (6,'XXXL', 'Triple Extra Grande', 1);


INSERT INTO tela (id,nombre, descripcion, estado) VALUES
  (1,'Algodón', 'Material suave y transpirable', 1),
  (2,'Poliéster', 'Material resistente y duradero', 1),
  (3,'Lino', 'Material natural y fresco', 1),
  (4,'Denim', 'Tejido vaquero clásico', 1),
  (5,'Seda', 'Material lujoso y delicado', 1),
  (6,'Cuero', 'Material resistente y elegante', 1);


INSERT INTO estilo_cuello (id,nombre, descripcion, estado) VALUES
  (1,'Cuello Redondo', 'Cuello clásico y versátil', 1),
  (2,'Cuello en V', 'Cuello con forma de V', 1),
  (3,'Cuello Mao', 'Cuello tipo cuello mao', 1),
  (4,'Cuello Polo', 'Cuello de polo deportivo', 1),
  (5,'Cuello Alto', 'Cuello alto y ajustado', 1),
  (6,'Sin Cuello', 'Sin cuello (cuello redondo)', 1);


INSERT INTO manga (id,nombre, descripcion, estado) VALUES
  (1,'Manga Corta', 'Manga corta para mayor comodidad', 1),
  (2,'Manga Larga', 'Manga larga para mayor cobertura', 1),
  (3,'Manga 3/4', 'Manga tres cuartos', 1),
  (4,'Manga Farol', 'Manga estilo farol', 1),
  (5,'Sin Manga', 'Sin mangas (manga corta)', 1),
  (6,'Manga Raglán', 'Manga estilo raglán', 1);

INSERT INTO color (id,nombre, descripcion, estado) VALUES
  (1,'Rojo', 'Color rojo vibrante', 1),
  (2,'Azul', 'Color azul clásico', 1),
  (3,'Verde', 'Color verde fresco', 1),
  (4,'Negro', 'Color negro elegante', 1),
  (5,'Blanco', 'Color blanco puro', 1),
  (6,'Gris', 'Color gris neutral', 1);


INSERT INTO categorias (id,nombre, descripcion, estado) VALUES
  (1,'Ropa para Hombres', 'Colección de moda masculina', 1),
  (2,'Ropa para Mujeres', 'Colección de moda femenina', 1),
  (3,'Ropa para Niños', 'Colección de moda infantil', 1),
  (4,'Calzado', 'Zapatos de moda para todas las edades', 1),
  (5,'Accesorios', 'Complementos de moda', 1);


INSERT INTO subcategorias (id,categoria_id, nombre, descripcion, estado) VALUES
  (1,1, 'Camisetas', 'Variedad de camisetas para hombres', 1),
  (2,1, 'Pantalones', 'Pantalones de moda para hombres', 1),
  (3,1, 'Chaquetas', 'Chaquetas modernas para hombres', 1),
  (4,2, 'Vestidos', 'Vestidos elegantes para mujeres', 1),
  (5,2, 'Faldas', 'Faldas de moda para mujeres', 1),
  (6,2, 'Blusas', 'Blusas modernas para mujeres', 1),
  (7,3, 'Ropa para Bebés', 'Ropa adorable para bebés', 1),
  (8,3, 'Ropa para Niños', 'Moda cómoda para niños', 1),
  (9,4, 'Zapatos para Hombres', 'Calzado moderno para hombres', 1),
  (10,4, 'Zapatos para Mujeres', 'Calzado elegante para mujeres', 1),
  (11,5, 'Bolsos', 'Bolsos de moda para todas las ocasiones', 1),
  (12,5, 'Bufandas', 'Bufandas y pañuelos de moda', 1);
