/*DROP DATABASE VogueNook  */

CREATE DATABASE VogueNook;

USE VogueNook;

CREATE TABLE
    genero(
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        estado TINYINT(1) NOT NULL DEFAULT 1
    );

CREATE TABLE
    pais(
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(250) NOT NULL,
        code VARCHAR(250),
        estado INTEGER NOT NULL
    );

CREATE TABLE
    departamento(
        id INTEGER PRIMARY KEY,
        cod_pais INTEGER,
        nombre VARCHAR(100) NOT NULL,
        cod_postal INTEGER,
        estado TINYINT(1) NOT NULL DEFAULT 1,

FOREIGN KEY (cod_pais) REFERENCES pais(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE
    municipio(
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        cod_departamento INTEGER,
        estado INTEGER,
        FOREIGN KEY (cod_departamento) REFERENCES departamento(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    puntos_referencia(
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        descripcion VARCHAR(350) NOT NULL,
        cod_municipio INTEGER,

FOREIGN KEY (cod_municipio) REFERENCES municipio(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE
    persona(
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        telefono INTEGER NOT NULL,
        id_punto_referencia INTEGER,
        correo VARCHAR(40) UNIQUE,
        foto VARCHAR(250),
        fecha_registro DATE,
        FOREIGN KEY (id_punto_referencia) REFERENCES puntos_referencia(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    persona_natural(
        id INTEGER PRIMARY KEY,
        id_persona INTEGER,
        id_nacionalidad INTEGER,
        id_genero INTEGER,
        apellido VARCHAR(80),
        tipo_identificacion VARCHAR(25),
        identificacion VARCHAR(25),
        fecha_nacimiento DATE,
        FOREIGN KEY (id_persona) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_nacionalidad) REFERENCES pais(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_genero) REFERENCES genero(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    persona_juridica(
        id INTEGER PRIMARY KEY,
        id_persona INTEGER,
        fecha_constitucional DATE,
        numero_ruc VARCHAR(18) NOT NULL,
        razon_social VARCHAR(250),
        FOREIGN KEY (id_persona) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    cliente(
        id INTEGER PRIMARY KEY,
        id_persona INTEGER,
        tipo_cliente VARCHAR(20) NOT NULL,
        estado TINYINT(1) NOT NULL DEFAULT 1,
        FOREIGN KEY (id_persona) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    proveedor(
        id INTEGER PRIMARY KEY,
        id_persona INTEGER,
        sector_comercial VARCHAR(50) NOT NULL,
        nacionalidad VARCHAR(50),
        estado TINYINT(1) NOT NULL DEFAULT 1,
        FOREIGN KEY (id_persona) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    contacto_proveedor(
        id INTEGER PRIMARY KEY,
        id_persona INTEGER,
        cargo VARCHAR(80),
        celular INTEGER,
        estado TINYINT(1) NOT NULL DEFAULT 1,
        FOREIGN KEY (id_persona) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    puestos (
        id INTEGER PRIMARY KEY NOT NULL,
        codigo CHAR(10) NOT NULL,
        nombre VARCHAR(50) NOT NULL,
        perfil VARCHAR(50) NOT NULL,
        descripcion TEXT,
        estado TINYINT(1) NOT NULL DEFAULT 1
    );

CREATE TABLE
    estado_civil(
        id INTEGER PRIMARY KEY,
        nombre_estado VARCHAR(50) NOT NULL,
        estado TINYINT(1) NOT NULL DEFAULT 1
    );

CREATE TABLE
    empleado(
        id INTEGER PRIMARY KEY,
        id_persona INTEGER,
        id_estado_civil INTEGER,
        cod_trabajador VARCHAR(30) NOT NULL,
        codigo_inss VARCHAR(20) UNIQUE,
        fecha_registro DATE,
        estado TINYINT(1) NOT NULL DEFAULT 1,
        FOREIGN KEY (id_estado_civil) REFERENCES estado_civil (id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_persona) REFERENCES persona (id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    historial_cargos (
        id INTEGER PRIMARY KEY NOT NULL,
        id_cargo INT NOT NULL,
        id_empleado INT NOT NULL,
        fecha_registro DATE,
        estado TINYINT(1) NOT NULL DEFAULT 1,
        FOREIGN KEY (id_cargo) REFERENCES puestos (id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_empleado) REFERENCES empleado (id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    salarios (
        id INTEGER PRIMARY KEY NOT NULL,
        id_empleado INT NOT NULL,
        salario DECIMAL(10, 2) NOT NULL,
        fecha_registro DATE,
        fecha_cambio DATE,
        estado TINYINT(1) NOT NULL DEFAULT 1,
        FOREIGN KEY (id_empleado) REFERENCES empleado (id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    tipo_contratos(
        id INTEGER PRIMARY KEY NOT NULL,
        nombre VARCHAR(120) NOT NULL,
        descripcion VARCHAR(500),
        estado TINYINT(1) NOT NULL DEFAULT 1
    );

CREATE TABLE
    contratos(
        id INTEGER PRIMARY KEY NOT NULL,
        id_tipo INTEGER NOT NULL,
        id_empleado INTEGER NOT NULL,
        codigo VARCHAR(120),
        tomo VARCHAR(120),
        folio VARCHAR(120),
        contrato VARCHAR(250) NOT NULL,
        fecha_registro DATE DEFAULT CURRENT_DATE,
        fecha_vencimiento DATE,
        fecha_cambio DATE,
        estado TINYINT(1) NOT NULL DEFAULT 1,
        FOREIGN KEY (id_tipo) REFERENCES tipo_contratos (id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_empleado) REFERENCES empleado (id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    marcas (
        id INTEGER PRIMARY KEY NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        descripcion VARCHAR(250),
        estado TINYINT(1) NOT NULL DEFAULT 1
    );

CREATE TABLE
    modelos (
        id INTEGER PRIMARY KEY NOT NULL,
        marca_id INT NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        descripcion VARCHAR(250),
        estado TINYINT(1) NOT NULL DEFAULT 1,

FOREIGN KEY (marca_id) REFERENCES marcas (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE
    tallas (
        id INTEGER PRIMARY KEY NOT NULL,
        nombre VARCHAR(20) NOT NULL,
        descripcion VARCHAR(250),
        estado TINYINT(1) NOT NULL DEFAULT 1
    );

CREATE TABLE
    tela(
        id INTEGER PRIMARY KEY NOT NULL,
        nombre VARCHAR(80) NOT NULL,
        descripcion VARCHAR(250),
        estado INTEGER
    );

CREATE TABLE
    estilo_cuello(
        id INTEGER PRIMARY KEY NOT NULL,
        nombre VARCHAR(80) NOT NULL,
        descripcion VARCHAR(250),
        estado INTEGER
    );

CREATE TABLE
    manga(
        id INTEGER PRIMARY KEY NOT NULL,
        nombre VARCHAR(80) NOT NULL,
        descripcion VARCHAR(250),
        estado INTEGER
    );

CREATE TABLE
    color(
        id INTEGER PRIMARY KEY NOT NULL,
        nombre VARCHAR(80) NOT NULL,
        descripcion VARCHAR(250),
        estado INTEGER
    );

CREATE TABLE
    categorias (
        id INTEGER PRIMARY KEY NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        descripcion VARCHAR(250),
        estado TINYINT(1) NOT NULL DEFAULT 1
    );

CREATE TABLE
    subcategorias (
        id INTEGER PRIMARY KEY NOT NULL,
        categoria_id INT NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        descripcion VARCHAR(250),
        estado TINYINT(1) NOT NULL DEFAULT 1,
        FOREIGN KEY (categoria_id) REFERENCES categorias (id) ON DELETE CASCADE ON UPDATE CASCADE
    );



CREATE TABLE
    productos (
        id INTEGER PRIMARY KEY NOT NULL,
        subcategoria_id INT NOT NULL,
        codigo CHAR(15) NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT,
        foto VARCHAR(250),
        estado TINYINT(1) NOT NULL DEFAULT 1,
        FOREIGN KEY (subcategoria_id) REFERENCES subcategorias (id) ON DELETE CASCADE ON UPDATE CASCADE
    );

    CREATE TABLE
        producto_color(
            id INTEGER PRIMARY KEY NOT NULL,
            id_producto INTEGER NOT NULL,
            id_color INTEGER NOT NULL,
            estado INTEGER,
            foto VARCHAR(250),
            FOREIGN KEY (id_Producto) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (id_color) REFERENCES color(id) ON DELETE CASCADE ON UPDATE CASCADE
        );

    CREATE TABLE
        producto_talla(
            id INTEGER PRIMARY KEY NOT NULL,
            id_producto INTEGER NOT NULL,
            id_talla INTEGER NOT NULL,
            estado INTEGER,
            foto VARCHAR(250),
            FOREIGN KEY (id_Producto) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (id_talla) REFERENCES tallas(id) ON DELETE CASCADE ON UPDATE CASCADE
        );

    CREATE TABLE
        producto_estilo_cuello(
            id INTEGER PRIMARY KEY NOT NULL,
            id_producto INTEGER NOT NULL,
            id_cuello INTEGER NOT NULL,
            estado INTEGER,
            foto VARCHAR(250),
            FOREIGN KEY (id_Producto) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (id_cuello) REFERENCES estilo_cuello(id) ON DELETE CASCADE ON UPDATE CASCADE
        );

    CREATE TABLE
        producto_manga(
            id INTEGER PRIMARY KEY NOT NULL,
            id_producto INTEGER NOT NULL,
            id_manga INTEGER NOT NULL,
            estado INTEGER,
            foto VARCHAR(250),
            FOREIGN KEY (id_Producto) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (id_manga) REFERENCES manga(id) ON DELETE CASCADE ON UPDATE CASCADE
        );
    CREATE TABLE
        producto_modelos(
            id INTEGER PRIMARY KEY NOT NULL,
            id_producto INTEGER NOT NULL,
            id_modelo INTEGER NOT NULL,
            estado INTEGER,
            foto VARCHAR(250),
            FOREIGN KEY (id_Producto) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (id_modelo) REFERENCES modelos(id) ON DELETE CASCADE ON UPDATE CASCADE
        );
CREATE TABLE
    precios_productos (
        id INTEGER PRIMARY KEY NOT NULL,
        producto_id INT NOT NULL,
        precio_compra DECIMAL(10, 2) NOT NULL,
        margen_ganancia FLOAT,
        precio_venta DECIMAL(10, 2),
        fecha_registro DATE,
        estado TINYINT(1) NOT NULL DEFAULT 1,
        FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

/**La pide el de bodega a hace una solicitud de compra*/

CREATE TABLE
    solicitudes_compra (
        id INTEGER PRIMARY KEY NOT NULL,
        id_trabajador INTEGER NOT NULL,
        revisado_por INTEGER NOT NULL,
        fecha_emision DATE,
        fecha_entrega DATE NOT NULL,
        estado TINYINT(1) NOT NULL,
        FOREIGN KEY (id_trabajador) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (revisado_Por) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    detalles_solicitudes_compra (
        id INTEGER PRIMARY KEY NOT NULL,
        id_solicitud INT NOT NULL,
        id_producto INT NOT NULL,
        cantidad INT,
        descripcion VARCHAR(250),
        FOREIGN KEY (id_solicitud) REFERENCES solicitudes_compra(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE

);

CREATE TABLE
    cotizaciones_compra (
        id INTEGER PRIMARY KEY NOT NULL,
        id_proveedor INT NOT NULL,
        id_solicitud INT NOT NULL,
        elaborador INT NOT NULL,
        cod_cotizacion_proveedor VARCHAR(120),
        sub_total DECIMAL(10, 2),
        impuesto_aplicable DECIMAL(10, 2),
        descuento DECIMAL(10, 2),
        costo_total DECIMAL(10, 2),
        fecha_cotizacion DATE,
        fecha_expiracion DATE,
        fecha_entrega DATE,
        estado TINYINT(1) NOT NULL,
        FOREIGN KEY (id_proveedor) REFERENCES proveedor(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_solicitud) REFERENCES solicitudes_compra(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (elaborador) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    detalles_cotizaciones_compra (
        id INTEGER PRIMARY KEY NOT NULL,
        id_cotizacion INTEGER,
        id_producto INTEGER NOT NULL,
        cantidad INT NOT NULL,
        precio_unitario DECIMAL(10, 2),
        FOREIGN KEY (id_cotizacion) REFERENCES cotizaciones_compra(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

/**Tipos de compras si el planeada,impulsiva,comparacion***/

CREATE TABLE
    tipo_orden_compra (
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        descripcion VARCHAR(250),
        estado TINYINT(1) NOT NULL
    );

CREATE TABLE
    orden_compra (
        id INTEGER PRIMARY KEY NOT NULL,
        id_tipo INTEGER,
        id_proveedor INTEGER NOT NULL,
        subtotal DECIMAL(10, 2) NOT NULL,
        descuento DECIMAL(10, 2),
        iva_total DECIMAL(10, 2),
        total DECIMAL(10, 2),
        fecha DATE DEFAULT NOW(),
        forma_pago VARCHAR(150) NOT NULL,
        estado TINYINT(1) NOT NULL,
        FOREIGN KEY (id_proveedor) REFERENCES proveedor(id),
        FOREIGN KEY (id_tipo) REFERENCES tipo_orden_compra(id)
    );

CREATE TABLE
    detalle_orden_compra (
        id INTEGER PRIMARY KEY,
        id_orden_compra INTEGER,
        id_producto INTEGER,
        cantidad INTEGER NOT NULL,
        precio_unitario DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (id_orden_compra) REFERENCES orden_compra(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_producto) REFERENCES productos(id)
    );

CREATE TABLE
    compras (
        id INTEGER PRIMARY KEY,
        id_orden_compra INTEGER,
        id_proveedor INTEGER,
        id_trabajador INTEGER,
        fecha_compra DATE,
        fecha_recepcion DATE,
        descripcion VARCHAR(255) NOT NULL,
        descuento DECIMAL(10, 2) NOT NULL,
        subtotal DECIMAL(10, 2) NOT NULL,
        iva_total DECIMAL(10, 2),
        total DECIMAL(10, 2),
        estado TINYINT(1) NOT NULL,
        FOREIGN KEY (id_orden_compra) REFERENCES orden_compra(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_proveedor) REFERENCES proveedor(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_trabajador) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    detalles_compras (
        id INTEGER PRIMARY KEY,
        id_compra INTEGER,
        id_producto INTEGER,
        cantidad_solicitada INTEGER NOT NULL,
        cantidad_recibida INTEGER NOT NULL,
        FOREIGN KEY (id_compra) REFERENCES compras(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    devolucion_compra (
        id INTEGER PRIMARY KEY,
        id_compra INTEGER,
        id_proveedor INTEGER,
        id_producto INTEGER,
        motivo VARCHAR(250) NOT NULL,
        fecha DATE DEFAULT NOW(),
        autorizado INTEGER,
        FOREIGN KEY (id_compra) REFERENCES compras(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_proveedor) REFERENCES proveedor(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (autorizado) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

/**Haciendo uso de recursividad se utilizara esta tablas para manejar los pedidos tanto en local como en linea*/

-- Creación de Tabla para Pedidos

CREATE TABLE
    pedido (
        id INTEGER PRIMARY KEY,
        cliente_id INTEGER,
        fecha_pedido DATE NOT NULL,
        subtotal DECIMAL(10, 2) NOT NULL,
        descuento DECIMAL(10, 2) NOT NULL,
        total DECIMAL(10, 2) NOT NULL,
        estado INTEGER,
        FOREIGN KEY (cliente_id) REFERENCES cliente(id)
    );

CREATE TABLE
    detalle_pedido (
        id INTEGER PRIMARY KEY,
        pedido_id INTEGER,
        producto_id INTEGER,
        cantidad INTEGER NOT NULL,
        precio_unitario DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (pedido_id) REFERENCES pedido(id),
        FOREIGN KEY (producto_id) REFERENCES productos(id)
    );
CREATE TABLE direccion_pedidos(
    id INTEGER PRIMARY KEY,
    id_puntos_referencia INTEGER ,
    pedido_id INTEGER,
    estado INTEGER,
    FOREIGN KEY (id_puntos_referencia) REFERENCES puntos_referencia(id),
    FOREIGN KEY (pedido_id) REFERENCES pedido(id)
);
CREATE TABLE
    venta (
        id INTEGER PRIMARY KEY,
        id_cliente INTEGER,
        id_trabajador INTEGER,
        codigo VARCHAR(25) NOT NULL,
        subtotal DECIMAL(10, 2),
        descuento DECIMAL(10, 2),
        impuesto DECIMAL(10, 2),
        total DECIMAL(10, 2) NOT NULL,
        fecha_venta DATE DEFAULT NOW(),
        tipo_venta VARCHAR(20),
        estado INTEGER,
        FOREIGN KEY (id_cliente) REFERENCES cliente(id),
        FOREIGN KEY (id_trabajador) REFERENCES empleado(id)
    );

-- Creación de Tabla para Detalles de Ventas

CREATE TABLE
    detalle_venta (
        id INTEGER PRIMARY KEY,
        id_venta INTEGER,
        id_pedido INTEGER,
        monto DECIMAL(10, 2),
        FOREIGN KEY (id_venta) REFERENCES venta(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_pedido) REFERENCES pedido(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

-- Tabla para Entregas de Pedidos

CREATE TABLE
    entrega_pedido (
        id INTEGER PRIMARY KEY,
        id_venta INTEGER,
        codigo VARCHAR(50) NOT NULL UNIQUE,
        fecha_entrega DATE,
        estado INTEGER,
        asignado_por INTEGER,
        realizado_por INTEGER,
        observaciones TEXT,
        FOREIGN KEY (id_venta) REFERENCES venta(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (asignado_por) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (realizado_por) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

-- Tabla para Detalles de Entrega de Pedidos

CREATE TABLE
    detalle_entrega (
        id INTEGER PRIMARY KEY,
        id_entrega INTEGER,
        id_direccion_pedidos INTEGER,
        nombre_receptor VARCHAR(100) NOT NULL,
        identificacion_receptor VARCHAR(25),
        telefono_receptor VARCHAR(20),
        firma_receptor BLOB,
        -- Para almacenar una firma digital del receptor si es necesario
        comentarios TEXT,
        estado INTEGER,
        fecha_inicio_entrega DATETIME,
        fecha_fin_entrega DATETIME,
        FOREIGN KEY (id_entrega) REFERENCES entrega_pedido(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    Ubicacion(
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(120) NOT NULL,
        descripcion VARCHAR(250) NOT NULL,
        estado INTEGER
    );

CREATE TABLE
    sub_ubicacion (
        id INTEGER PRIMARY KEY,
        id_ubicacion INTEGER,
        nombre VARCHAR(120) NOT NULL,
        descripcion VARCHAR(250),
        estado INTEGER,

FOREIGN KEY (id_ubicacion) REFERENCES ubicacion (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE
    niveles_estantes (
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(120) NOT NULL,
        descripcion VARCHAR(120),
        peso_maximo VARCHAR(50),
        estado INTEGER
    );

CREATE TABLE
    estantes(
        id INTEGER PRIMARY KEY,
        id_sub_ubicacion INTEGER,
        id_categoria_estantes INTEGER,
        id_nivel INTEGER,
        nombre VARCHAR(120) NOT NULL,
        descripcion VARCHAR(250),
        estado INTEGER NOT NULL,

FOREIGN KEY (id_sub_ubicacion) REFERENCES sub_ubicacion (id) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (id_nivel) REFERENCES niveles_estantes (id) ON DELETE CASCADE ON UPDATE CASCADE
);
-- Creación de Tabla para Movimientos de Bodega

CREATE TABLE
    movimiento (
        id INTEGER PRIMARY KEY,
        tipo ENUM('Entrada', 'Salida') NOT NULL,
        fecha_movimiento DATE NOT NULL,
        descripcion TEXT
    );

-- Creación de Tabla para Lotes

CREATE TABLE
    lote (
        id INTEGER PRIMARY KEY,
        producto_id INTEGER,
        numero_lote VARCHAR(50) NOT NULL,
        fecha_vencimiento DATE,
        cantidad INTEGER NOT NULL,
        movimiento_id INTEGER,
        FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (movimiento_id) REFERENCES movimiento(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

-- Creación de Tabla para Control de Inventario

CREATE TABLE
    inventario (
        id INTEGER PRIMARY KEY,
        producto_id INTEGER,
        lote_id INTEGER,
        cantidad INTEGER NOT NULL,
        stock_maximo INTEGER NOT NULL,
        stock_minimo INTEGER NOT NULL,

FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (lote_id) REFERENCES lote(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE
    tipo_movimiento(
        id INTEGER PRIMARY KEY,
        concepto VARCHAR(250),
        id_movimiento INTEGER,

FOREIGN KEY (id_movimiento) REFERENCES movimiento(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla para modulo de caja

CREATE TABLE
    tipo_caja(
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(80) NOT NULL,
        descripcion VARCHAR(250),
        estado INTEGER
    );

/** Para manejar los tipos de monedas tanto extrajeras como nacional*/

CREATE TABLE
    divisa(
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        simbolo VARCHAR(25),
        local BOOLEAN,
        estado INTEGER
    );

/** Para manejar las denominaciones tanto las de  billete como monedas*/

CREATE TABLE
    moneda(
        id INTEGER PRIMARY KEY,
        id_divisa INTEGER,
        denominacion DECIMAL(10, 2) NOT NULL,
        estado INTEGER,
        FOREIGN KEY (id_divisa) REFERENCES divisa(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    tipo_cambio (
        id INTEGER PRIMARY KEY,
        id_divisa INTEGER,
        fecha DATE NOT NULL,
        cambio DECIMAL(10, 2),
        FOREIGN KEY (id_divisa) REFERENCES divisa(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    caja(
        id INTEGER PRIMARY KEY,
        tipo INTEGER,
        creada_por INTEGER,
        nombre VARCHAR(100) NOT NULL,
        fecha_registro TIMESTAMP DEFAULT NOW(),
        estado INTEGER,
        FOREIGN KEY (tipo) REFERENCES tipo_caja(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (creada_por) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    apertura_caja(
        id INTEGER PRIMARY KEY,
        id_caja INTEGER,
        id_trabajador INTEGER,
        id_autorizado_por INTEGER,
        fecha_apertura DATE,
        estado INTEGER,
        FOREIGN KEY (id_caja) REFERENCES caja(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_trabajador) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_autorizado_por) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    detalle_apertura_caja(
        id INTEGER PRIMARY KEY,
        id_apertura_caja INTEGER,
        id_moneda INTEGER,
        monto DECIMAL(10, 2) NOT NULL,
        total DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (id_apertura_caja) REFERENCES apertura_caja(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_moneda) REFERENCES moneda(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    metodo_pago (
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        descripcion VARCHAR(250),
        estado INTEGER
    );

CREATE TABLE
    movimiento_caja (
        id INTEGER PRIMARY KEY,
        id_caja INTEGER,
        id_trabajador INTEGER,
        fecha_movimiento DATE,
        tipo_movimiento ENUM('Entrada', 'Salida') NOT NULL,
        monto_cordobas NUMERIC(10, 2),
        monto_dolares NUMERIC(10, 2),
        id_metodo_pago INTEGER,
        FOREIGN KEY (id_caja) REFERENCES caja(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_trabajador) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_metodo_pago) REFERENCES metodo_pago(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    arqueo_caja(
        id INTEGER PRIMARY KEY,
        id_caja INTEGER,
        id_trabajador INTEGER,
        fecha_arqueo DATE,
        monto_inicial NUMERIC(10, 2),
        monto_final NUMERIC(10, 2),
        estado INTEGER,
        FOREIGN KEY (id_caja) REFERENCES apertura_caja(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_trabajador) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    detalle_arqueo (
        id INTEGER PRIMARY KEY,
        id_apertura INTEGER,
        id_moneda INTEGER,
        cantidad_billete INTEGER NOT NULL,
        monton_billete DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (id_apertura) REFERENCES arqueo_caja(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_moneda) REFERENCES moneda(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    cierre_caja(
        id INTEGER PRIMARY KEY,
        id_trabajador INTEGER,
        id_autorizado INTEGER,
        motivo VARCHAR(250),
        fecha_cierre DATE,
        estado INTEGER,
        FOREIGN KEY (id_trabajador) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_autorizado) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    detalle_cierre_caja(
        id INTEGER PRIMARY KEY,
        id_caja INTEGER,
        id_cierre_caja INTEGER,
        id_moneda INTEGER,
        monto_cierre DECIMAL(10, 2) NOT NULL,

FOREIGN KEY (id_cierre_caja) REFERENCES cierre_caja(id) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (id_caja) REFERENCES caja(id) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (id_moneda) REFERENCES moneda(id) ON DELETE CASCADE ON UPDATE CASCADE
);

/** Para los roles */

CREATE TABLE
    perfil(
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(120) NOT NULL,
        descripcion VARCHAR(250),
        estado INTEGER
    );

CREATE TABLE
    rol(
        id INTEGER PRIMARY KEY,
        id_perfil INTEGER,
        codigo VARCHAR(10) UNIQUE NOT NULL,
        nombre VARCHAR(50) NOT NULL,
        descripcion VARCHAR(250) NOT NULL,
        fecha_registro DATE DEFAULT NOW(),
        estado INTEGER,
        FOREIGN KEY (id_perfil) REFERENCES perfil(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    modulo(
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(80) NOT NULL,
        descripcion VARCHAR(250),
        fecha_registro DATE DEFAULT NOW(),
        icono VARCHAR(250),
        estado INTEGER
    );

CREATE TABLE
    sub_modulo(
        id INTEGER PRIMARY KEY,
        id_modulo INTEGER,
        nombre VARCHAR(80) NOT NULL,
        descripcion VARCHAR(250) NOT NULL,
        enlace VARCHAR(250),
        estado INTEGER,
        FOREIGN KEY (id_modulo) REFERENCES modulo(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    permiso (
        id INTEGER PRIMARY KEY,
        nombre VARCHAR(80) UNIQUE NOT NULL,
        descripcion VARCHAR(100)
    );

CREATE TABLE
    permiso_modulo(
        id INTEGER PRIMARY KEY,
        id_modulo INTEGER,
        id_permiso INTEGER,
        UNIQUE(id_modulo, id_permiso),
        FOREIGN KEY (id_modulo) REFERENCES modulo(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_permiso) REFERENCES permiso(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    usuario(
        id INTEGER PRIMARY KEY,
        id_rol INTEGER,
        id_persona INTEGER,
        codigo VARCHAR(10) UNIQUE NOT NULL,
        usuario VARCHAR(80) NOT NULL,
        fecha_registro DATE DEFAULT NOW(),
        estado INTEGER,
        FOREIGN KEY (id_rol) REFERENCES rol(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_persona) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    detalle_usuario (
        id INTEGER PRIMARY KEY,
        id_usuario INTEGER,
        contraseña VARCHAR(250) NOT NULL,
        fecha DATE DEFAULT NOW(),
        estado INTEGER,
        FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    roles_temporales(
        id INTEGER PRIMARY KEY,
        id_rol INTEGER,
        id_usuario INTEGER,
        autorizado INTEGER,
        fecha_registro DATE,
        estado INTEGER,
        FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (autorizado) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_rol) REFERENCES rol(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE privilegio_rol (
    id INTEGER PRIMARY KEY,
    id_sub_modulo INTEGER,
    id_usuario INTEGER,
    autorizacion INTEGER,

	FOREIGN KEY (id_sub_modulo)REFERENCES sub_modulo(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (id_usuario)REFERENCES rol(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (autorizacion)REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE
    privilegio_permiso_rol (
        id INTEGER PRIMARY KEY,
        id_permiso INTEGER,
        id_usuario INTEGER,
        autorizacion INTEGER,
        FOREIGN KEY (id_permiso) REFERENCES permiso_modulo(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_usuario) REFERENCES rol(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (autorizacion) REFERENCES empleado(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    conexion(
        id INTEGER PRIMARY KEY,
        id_usuario INTEGER,
        mac VARCHAR(250),
        ip VARCHAR(250) NOT NULL,
        navegador VARCHAR(120),
        version_navegador VARCHAR(250),
        dispositivo VARCHAR(250),
        version_dispositivo VARCHAR(250),
        fecha_ingreso DATE DEFAULT NOW(),
        estado INTEGER,
        FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    bloqueo_usuario(
        id INTEGER PRIMARY KEY,
        id_usuario INTEGER,
        descripcion VARCHAR(250),
        estado INTEGER,
        FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    historial_de_sesion(
        id INTEGER PRIMARY KEY,
        id_usuario INTEGER,
        ip VARCHAR(250),
        accion VARCHAR(120),
        descripcion VARCHAR(250),
        fecha DATE DEFAULT NOW(),
        FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
    );