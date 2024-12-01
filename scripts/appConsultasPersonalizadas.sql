USE tienditaonline;

/***---------------------------------------------------------------------------------------***/
/*PARA EL MODELO DE CARRITO*/
/* Obtener productos en el carrito por usuario, listar  productos en el carrito de un usuario (usuario_id = 1), 
mostrando su nombre, precio, cantidad, y el costo total por producto.*/
SELECT c.carrito_id, p.nombre AS producto, p.precio, c.cantidad, 
       (p.precio * c.cantidad) AS total
FROM Carrito c
JOIN Productos p ON c.producto_id = p.producto_id
WHERE c.usuario_id = 2;


/*Obtener la lista completa de productos en el carrito por cliente, con el total por producto*/
SELECT c.carrito_id, u.nombre AS cliente, p.nombre AS producto, 
       c.cantidad, p.precio, (c.cantidad * p.precio) AS total_por_producto
FROM Carrito c
INNER JOIN Usuarios u ON c.usuario_id = u.usuario_id
INNER JOIN Productos p ON c.producto_id = p.producto_id
ORDER BY u.usuario_id, c.carrito_id;


/*Obtener el carrito completo de un usuario específico (por usuario_id)*/
SELECT c.carrito_id, p.nombre AS producto, p.precio, c.cantidad, 
       (c.cantidad * p.precio) AS total, p.imagen
FROM Carrito c
INNER JOIN Productos p ON c.producto_id = p.producto_id
WHERE c.usuario_id = 2; -- Cambiar '1' por el ID del usuario deseado



/***---------------------------------------------------------------------------------------***/
/*PARA EL MODELO DE CATEGORIAS*/

/*Obtener todas las categorías sin jerarquía (sin padre)*/
SELECT * 
FROM Categorias 
WHERE categoria_padre_id IS NULL;





/***---------------------------------------------------------------------------------------***/
/*PARA EL MODELO DE PEDIDOS*/
/*Obtener el historial de pedidos por cliente con detalles*/
SELECT p.pedido_id, u.nombre AS cliente, pr.nombre AS producto, 
       p.cantidad, p.subtotal, v.fecha_venta
FROM Pedidos p
INNER JOIN Ventas v ON p.venta_id = v.venta_id
INNER JOIN Usuarios u ON v.usuario_id = u.usuario_id
INNER JOIN Productos pr ON p.producto_id = pr.producto_id
ORDER BY u.usuario_id, v.fecha_venta DESC;


/*Obtener pedidos realizados por un cliente específico*/
SELECT p.pedido_id, pr.nombre AS producto, p.cantidad, p.subtotal, 
       v.fecha_venta, v.total AS total_pedido
FROM Pedidos p
INNER JOIN Ventas v ON p.venta_id = v.venta_id
INNER JOIN Productos pr ON p.producto_id = pr.producto_id
WHERE v.usuario_id = 2; -- Cambiar '1' por el ID del cliente que se quiere


/*Detalle de pedidos por usuario, mostrar los pedidos detallados de un usuario específico (usuario_id = 1), incluyendo fecha de venta.*/
SELECT u.nombre AS cliente, pr.nombre AS producto, p.cantidad, p.subtotal, v.fecha_venta
FROM Pedidos p
JOIN Ventas v ON p.venta_id = v.venta_id
JOIN Usuarios u ON v.usuario_id = u.usuario_id
JOIN Productos pr ON p.producto_id = pr.producto_id
WHERE u.usuario_id = 2;





/***---------------------------------------------------------------------------------------***/
/*PARA EL MODELO DE PRODUCTOS*/
/*Obtener todos los productos con su categoría*/
SELECT p.producto_id, p.nombre, p.descripcion, p.precio, 
       p.cantidad_disponible, c.nombre_categoria AS categoria
FROM Productos p
LEFT JOIN Categorias c ON p.categoria_id = c.categoria_id
WHERE p.estado = 'activo';


/*Buscar productos por palabra clave (por ejemplo: 'locion')*/
SELECT * 
FROM Productos 
WHERE nombre LIKE '%locion%' AND estado = 'activo';


/*Productos más vendidos, 5 productos más vendidos por cantidad total.*/
SELECT p.nombre AS producto, SUM(pe.cantidad) AS cantidad_vendida
FROM Pedidos pe
JOIN Productos p ON pe.producto_id = p.producto_id
GROUP BY p.nombre
ORDER BY cantidad_vendida DESC
LIMIT 5;


/*Verificar stock bajo en productos, productos con menos de 5 unidades disponibles.*/
SELECT nombre, cantidad_disponible
FROM Productos
WHERE cantidad_disponible < 90;


/*Buscar productos por nombre o descripción, encontrar productos cuyo nombre o descripción contiene "jeans" o "pantalon".*/
SELECT producto_id, nombre, descripcion, precio
FROM Productos
WHERE nombre LIKE '%jeans%' OR descripcion LIKE '%pantalon%';





/***---------------------------------------------------------------------------------------***/
/*PARA EL MODELO DE USUARIOS*/
/*Listar todos los usuarios registrados con su rol*/
SELECT usuario_id, nombre, email, rol, fecha_registro
FROM Usuarios;


/*Obtener los detalles de un usuario específico*/
SELECT *
FROM Usuarios
WHERE usuario_id = 2; -- Cambiar '1' por el ID del usuario deseado





/***---------------------------------------------------------------------------------------***/
/*PARA EL MODELO DE VENTAS*/
/*Obtener el resumen de ventas realizadas con el nombre del cliente*/
SELECT v.venta_id, v.fecha_venta, v.total, v.estado, u.nombre AS cliente
FROM Ventas v
INNER JOIN Usuarios u ON v.usuario_id = u.usuario_id
ORDER BY v.fecha_venta DESC;


/*Obtener todas las ventas de un cliente específico*/
SELECT v.venta_id, v.fecha_venta, v.total, v.estado
FROM Ventas v
WHERE v.usuario_id = 2; -- Cambiar '1' por el ID del cliente deseado


/*Ventas totales por cliente, el total de ventas y el monto acumulado por cliente, ordenado de mayor a menor monto.*/
SELECT u.nombre AS cliente, COUNT(v.venta_id) AS total_ventas, SUM(v.total) AS monto_total
FROM Ventas v
JOIN Usuarios u ON v.usuario_id = u.usuario_id
GROUP BY u.nombre
ORDER BY monto_total DESC;














