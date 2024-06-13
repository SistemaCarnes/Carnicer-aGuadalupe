<?php
include 'conexion_be.php';

if (isset($_POST['codigo_produc'])) {
    $codigo_produc = $_POST['codigo_produc'];

    // Consulta para obtener el dato de la base de datos
    $query = "SELECT nombre, precio_venta, existencia FROM productos_con_inventario WHERE codigo_produc = '$codigo_produc'";
    $resultado = mysqli_query($conexion, $query);

    // Verificar si se encontraron resultados
    if ($resultado) {
        $fila = mysqli_fetch_assoc($resultado);
        echo json_encode([
            'success' => true,
            'nombre' => $fila['nombre'],
            'precio_venta' => $fila['precio_venta'],
            'existencia' => $fila['existencia']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
}
