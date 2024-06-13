<!DOCTYPE html>

<?php
include 'conexion_be.php';
session_start();
$id = isset($_SESSION['usuarioingresando']) ? $_SESSION['usuarioingresando'] : 0;
$corre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 0;
$sql = "SELECT nombre FROM empleado WHERE id = '$id' ";

$sql1 = "SELECT contrasena FROM empleado WHERE id = '$id' ";
$result1 = $conexion->query($sql1);

// Crear una consulta SQL
$sql2 = "SELECT id, nombre, precio_venta FROM productos_con_inventario";
// Ejecutar la consulta
$result3 = $conexion->query($sql2);
$rows = $result3->fetch_array();

$ids = $rows['id'];
$sql3 = "SELECT nombre, precio_venta FROM productos_con_inventario WHERE id = '$ids' ";
$res = $conexion->query($sql3);
$rowt = $res->fetch_assoc();

?>
<html>

<head>
    <link rel="shortcut icon" href="log.png" type="icono"> <!--Este es el icono-->
    <title>Carniceria Guadalupe</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo3.css">
    <link rel="stylesheet" href="estil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="ventas_prod.css">
</head>

<body>
    <header>
        <div>
            <nav>
                <input type="checkbox" id="menuToggle">
                <label for="menuToggle" class="hamburger">&#9776;</label>
                <div class="contas">
                    <img src="log.png" alt="Carniceria">
                    <div id="logo" class="txtmov">
                        <h1>Carniceria Guadalupe</h1>
                    </div>
                </div>
                <ul class="nav-list">
                    <li>
                        <h2 class="d-lg-inline">
                            Bienvenid@
                            <?php
                            $sql2 = "SELECT nombre FROM empleado WHERE id = '$id' ";
                            $results = $conexion->query($sql2);
                            $row2 = $results->fetch_assoc();
                            $partes_nombre = explode(" ", $row2['nombre']);
                            echo "<h2 class='d-lg-inline'>$partes_nombre[0]</h2> ";
                            ?>

                        </h2>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <section class="app">
        <aside class="sidebar">
            <nav class="sidebar-nav">

                <ul>
                    <li>
                        <a href="ventas_prod.php"><i class="bi bi-cart3"></i><span class="d-lg-inline">Ventas</span></a>
                        <ul class="nav-flyout">
                            <li>
                                <a href="prod_disp.php">Productos disponibles</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="ver.php"><i class="bi bi-journal-text"></i><span class="d-lg-inline">Reporte de ventas</span></a>

                    </li>
                    <li>
                        <a href="Pedido.php"><i class="bi bi-unity"></i><span class="d-lg-inline">Pedidos</span></a>

                    </li>
                    <li>
                        <a href="#"><i class="bi bi-person-fill"></i>
                            <?php
                            $sql1 = "SELECT nombre FROM empleado WHERE id = '$id' ";
                            $results = $conexion->query($sql1);
                            $row2 = $results->fetch_assoc();
                            $partes_nombre = explode(" ", $row2['nombre']);
                            echo "<div class='d-lg-inline'>$partes_nombre[0]</div> ";
                            ?> </a>
                        <ul class="nav-flyout">
                            <li>
                                <a href="logout.php">Cerrar sesion</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>
    </section>
    <?php
    // Verificar si se ha enviado un dato mediante el formulario
    if (isset($_POST['dato_seleccionado'])) {
        $dato_seleccionado = $_POST['dato_seleccionado'];

        // Consulta para obtener el dato de la base de datos
        $query = "SELECT * FROM productos_con_inventario WHERE id = $dato_seleccionado";
        $resultado = mysqli_query($conexion, $query);

        // Verificar si se encontraron resultados
        if ($resultado) {
            $fila = mysqli_fetch_assoc($resultado);
            $dato = $fila['nombre'];
        } else {
            echo "Error al obtener el dato de la base de datos.";
        }
    }
    ?>
    <div class="row w-75 m-auto pb-5 pt-4">
        <main class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>Datos del producto</h2>
                    <form id="checkoutForm">
                        <div id="contenedorCodigo" class="mb-3">
                            <select name="dato_seleccionado" id="idProducto" class="form-control">
                                <option value="ID">Selecciona un Código</option>
                                <?php
                                $query = "SELECT codigo_produc, nombre FROM productos_con_inventario WHERE existencia > 0";
                                $resul = mysqli_query($conexion, $query);
                                while ($rowt = mysqli_fetch_assoc($resul)) {
                                    echo "<option value='" . $rowt['codigo_produc'] . "'>" . $rowt['codigo_produc'] . " - " . $rowt['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                            <button type="button" id="mostrarProducto" class="btn btn-info mt-2">Mostrar</button>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="nombreProducto" placeholder="Este es el nombre del producto" readonly>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="number" class="form-control" id="existenciaProducto" placeholder="Cantidad disponible del producto" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">Kg</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" class="form-control" id="precioProducto" placeholder="Este es el precio del producto" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="number" class="form-control" id="cantidadProducto" placeholder="Ingrese la cantidad del producto" required min="0">
                                <div class="input-group-append">
                                    <span class="input-group-text">Kg</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary mt-3" id="btnAgregarProd">Agregar producto</button>
                        </div>
                    </form>

                </div>
                <div class="col-md-8">
                    <h2>Detalles del pedido</h2>
                    <div id="productos">
                        <table class="table table-striped" id="tabla">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td id="" colspan="6"><strong>Total venta</strong></td>
                                    <td id="totalVenta"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row col-12">
                        <div class="col-md-5 d-lg-inline ">
                            <label for="montoRec" class=" justify-content-start">Monto recibido:</label>
                            <input type="number" class="form-control ml-0" id="montoRec" placeholder="Ingrese el monto recibido">
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-success mt-3" id="vender">Generar venta</button>
                        <button type="button" class="btn btn-danger mt-3" id="cancelar">Cancelar</button>
                    </div>
                </div>
            </div>
        </main>
        <!-- Modal para mostrar el cambio -->
        <div class="modal fade" id="cambioModal" tabindex="-1" aria-labelledby="cambioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cambioModalLabel">Cambio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="cambioTexto"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ... otros scripts ... -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="ventas_prod.js"></script>
    </div>
</body>

<footer class="footcolor ">
    <div class="contenedor">
        <div class="section  ">
            <i class="fab fa-facebook-f"></i> CarniceriaGuadalupe Oaxaca<br>
            <i class="fab fa-instagram"></i> Guadalupe<br>
            <i class="fab fa-facebook-messenger"></i>Carniceria Guadalupe oax<br>
        </div>

        <div class="section ">
            <h4 class="pt-2">Horario</h4>
            <i>
                <img src="img/hora.png" class=" img-fluid" width="20" height="20">
            </i> Lunes- Viernes: 9:00 AM - 8:00 PM <br>
            Sabado: 10:00 AM - 3:00 PM <br>
        </div>

        <div class="section ">
            <p align="center">&copy; 2024 Carniceria Guadalupe</p>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script><!-- comment -->

</html>