CREATE DATABASE BD_SatoriAsianCuisine;
USE BD_SatoriAsianCuisine;

-- Tabla de usuarios
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    contraseña VARCHAR(255),
    tipoDeUsario ENUM('Cliente', 'Encargado', 'Cocina', 'Administrador')
);

-- Tabla de ingredientes
CREATE TABLE ingrediente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE
);

-- Tabla de productos
CREATE TABLE producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE,
    descripcion TEXT,
    precio DECIMAL(10, 2),
    imagen VARCHAR(255),
    tipo ENUM('Japones', 'Coreano', 'Chino'),
    categoria ENUM('Entrada', 'Principal', 'Postre', 'Bebida', 'Sopa')
);

-- Tabla de productos_ingredientes (relación muchos a muchos)
CREATE TABLE producto_ingrediente (
    id_producto INT,
    id_ingrediente INT,
    FOREIGN KEY (id_producto) REFERENCES producto(id),
    FOREIGN KEY (id_ingrediente) REFERENCES ingrediente(id),
    PRIMARY KEY (id_producto, id_ingrediente)
);

-- Tabla de combos
CREATE TABLE combo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE,
    precio DECIMAL(10, 2),
    descripcion TEXT,
    categoria ENUM('Desayuno', 'Almuerzo', 'Navidad')
);

-- Tabla de combos_productos (relación muchos a muchos)
CREATE TABLE combos_productos (
    id_combo INT,
    id_producto INT,
    FOREIGN KEY (id_combo) REFERENCES combo(id),
    FOREIGN KEY (id_producto) REFERENCES producto(id),
    PRIMARY KEY (id_combo, id_producto)
);

-- Tabla de menús
CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE,
    fecha_inicio DATE,
    fecha_fin DATE,
    hora_inicio TIME,
    hora_fin TIME
);

-- Tabla de menus_productos (relación muchos a muchos)
CREATE TABLE menus_productos (
    id_menu INT,
    id_producto INT,
    FOREIGN KEY (id_menu) REFERENCES menu(id),
    FOREIGN KEY (id_producto) REFERENCES producto(id),
    PRIMARY KEY (id_menu, id_producto)
);

-- Tabla de estaciones de cocina
CREATE TABLE estacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(300)
);

-- Tabla de Estacione_producto (relación muchos a muchos)
CREATE TABLE estaciones_productos (
    id_estacion INT,
    id_producto INT,
    FOREIGN KEY (id_estacion) REFERENCES estacion(id),
    FOREIGN KEY (id_producto) REFERENCES producto(id),
    PRIMARY KEY (id_estacion, id_producto)
);

-- Tabla de procesos de preparación
CREATE TABLE proceso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT,
    orden INT,
    id_estacion INT,
    FOREIGN KEY (id_producto) REFERENCES producto(id),
    FOREIGN KEY (id_estacion) REFERENCES estacion(id)
);

-- Tabla de pedidos
CREATE TABLE pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    estado ENUM('Pendiente de pago', 'Aceptada', 'Preparación', 'Procesando', 'Entregada'),
    metodo_entrega ENUM('Domicilio', 'Recogida'),
    direccion VARCHAR(255),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES usuario(id)
);

-- Tabla de pedidos_productos (relación muchos a muchos)
CREATE TABLE pedidos_productos (
    id_pedido INT,
    id_producto INT,
    cantidad INT,
    observaciones TEXT,
    FOREIGN KEY (id_pedido) REFERENCES pedido(id),
    FOREIGN KEY (id_producto) REFERENCES producto(id),
    PRIMARY KEY (id_pedido, id_producto)
);

-- Tabla de historial de pedidos
CREATE TABLE historial_pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('Pendiente de pago', 'Aceptada', 'Preparación', 'Procesando', 'Entregada'),
    FOREIGN KEY (id_pedido) REFERENCES pedido(id)
);

-- Tabla de pagos
CREATE TABLE pago (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT,
    monto DECIMAL(10, 2),
    metodo_pago ENUM('Tarjeta', 'Efectivo'),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pedido) REFERENCES pedido(id)
);