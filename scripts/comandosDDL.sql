CREATE DATABASE IF NOT EXISTS tienditaOnline;
USE tienditaOnline;

-- Tabla de usuarios (clientes y administradores)
CREATE TABLE Usuarios (
    usuario_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre NVARCHAR(100) NOT NULL,
    email NVARCHAR(100) UNIQUE NOT NULL,
    direccion NVARCHAR(255),
    telefono NVARCHAR(15),
    password NVARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'admin') NOT NULL DEFAULT 'cliente',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);


-- Tabla de categorías (con jerarquías)
CREATE TABLE Categorias(
    categoria_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre_categoria NVARCHAR(100) NOT NULL,
    categoria_padre_id INT,
    FOREIGN KEY (categoria_padre_id) REFERENCES Categorias(categoria_id) ON DELETE SET NULL
);


-- Tabla de productos
CREATE TABLE Productos(
    producto_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre NVARCHAR(100) NOT NULL,
    descripcion NVARCHAR(255),
    precio DECIMAL(10, 2) NOT NULL,
    cantidad_disponible INT NOT NULL,
    categoria_id INT,
    imagen VARCHAR(255),
    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES Categorias(categoria_id)
);


-- Tabla de carrito
CREATE TABLE Carrito (
    carrito_id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    fecha_agregado DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(usuario_id),
    FOREIGN KEY (producto_id) REFERENCES Productos(producto_id)
);


-- Tabla de ventas
CREATE TABLE Ventas (
    venta_id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    fecha_venta DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL,
    estado ENUM('pendiente', 'completada', 'cancelada') NOT NULL DEFAULT 'pendiente',
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(usuario_id)
);


-- Tabla de pedidos
CREATE TABLE Pedidos (
    pedido_id INT PRIMARY KEY AUTO_INCREMENT,
    venta_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (venta_id) REFERENCES Ventas(venta_id),
    FOREIGN KEY (producto_id) REFERENCES Productos(producto_id)
);
