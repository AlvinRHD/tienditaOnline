USE tienditaonline;

/*INSERTS PARA USUARIOS*/
-- contra juan321
INSERT INTO Usuarios (nombre, email, direccion, telefono, password, rol) 
VALUES ('Juan Pérez', 'juan@example.com', 'Av. Principal #123', '5551234567', '$2y$10$wixZDK52CjZY1is8FugFq.Hhg/MwkFEN/ikGBIGN0QizyyMT.gIWO', 'cliente');

-- contra maria321
INSERT INTO Usuarios (nombre, email, direccion, telefono, password, rol) 
VALUES ('María López', 'maria@example.com', 'Calle Falsa #456', '5557654321', '$2y$10$Pw9AnxD4eIzCsKdISeQgnek8zzC4Xd2ZiBCa/n0oVEEwK7DQNeTde', 'cliente');

-- contra carlos321
INSERT INTO Usuarios (nombre, email, direccion, telefono, password, rol) 
VALUES ('Carlos Rivera', 'carlos@example.com', 'Calle Luna #789', '5559876543', '$2y$10$5iE8KWGNTzClo9ikWpJ4CubVqKsaG6f6yioT50FHixvkQiWYhQkUe', 'cliente');


select * from usuarios;

-- usuario admin admin321
INSERT INTO Usuarios (nombre, email, direccion, telefono, password, rol)
VALUES ('Witty', 'witty@tiendita.com', 'Dirección de ejemplo', '123456789', '$2y$10$mt/AqOFvwB5kF1lSEoJi7.3mgRENrgmCfeqcgshF0R9HAMrWgV0gW', 'admin');


-- Eliminar admin tuve problemas
select * from usuarios;
SELECT * FROM Usuarios WHERE rol = 'admin';
DELETE FROM Usuarios WHERE usuario_id = 1;


-- Eliminar lo relacionado con admin
select * from Carrito;
SELECT * FROM Carrito WHERE usuario_id = '1';
DELETE FROM Carrito WHERE usuario_id = 1;


/*INSERTS PARA PEDIDOS*/
INSERT INTO Pedidos (venta_id, producto_id, cantidad, subtotal) 
VALUES (1, 1, 2, 3000.00);

INSERT INTO Pedidos (venta_id, producto_id, cantidad, subtotal) 
VALUES (2, 3, 1, 299.99);

INSERT INTO Pedidos (venta_id, producto_id, cantidad, subtotal) 
VALUES (1, 2, 5, 4999.95);




