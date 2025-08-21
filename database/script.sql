CREATE DATABASE biblioteca_escolar;
USE biblioteca_escolar;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    tipo ENUM('estudiante', 'administrador') NOT NULL
);

-- Tabla de categorías
CREATE TABLE categorias (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla de autores
CREATE TABLE autores (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla de libros
CREATE TABLE libros (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    categoria_id BIGINT,
    autor_id BIGINT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id),
    FOREIGN KEY (autor_id) REFERENCES autores(id)
);

-- Tabla de préstamos
CREATE TABLE prestamos (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    libro_id BIGINT,
    usuario_id BIGINT,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion DATE NOT NULL,
    FOREIGN KEY (libro_id) REFERENCES libros(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Datos de prueba
INSERT INTO usuarios (nombre, email, password, tipo) VALUES
('Juan Perez', 'juan@example.com', 'hashed_password', 'estudiante'),
('Admin', 'admin@example.com', 'hashed_password', 'administrador');

INSERT INTO categorias (nombre) VALUES ('Ciencia Ficción'), ('Historia');

INSERT INTO autores (nombre) VALUES ('Isaac Asimov'), ('Yuval Noah Harari');

INSERT INTO libros (titulo, categoria_id, autor_id) VALUES
('Fundación', 1, 1),
('Sapiens', 2, 2);