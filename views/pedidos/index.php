<?php
if (empty($pedidos)) {
    echo "<p>No tienes pedidos.</p>";
} else {
    echo "<h1>Mis Pedidos</h1>";
    echo "<table border='1'>";
    echo "<thead><tr>
            <th>Fecha de Venta</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Estado</th>
          </tr></thead>";
    echo "<tbody>";

    foreach ($pedidos as $pedido) {
        echo "<tr>";
        echo "<td>" . $pedido['fecha_venta'] . "</td>";
        echo "<td>" . $pedido['nombre'] . "</td>";
        echo "<td>" . $pedido['cantidad'] . "</td>";
        echo "<td>" . number_format($pedido['subtotal'], 2) . "</td>";
        echo "<td>" . $pedido['estado'] . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
}
?>
