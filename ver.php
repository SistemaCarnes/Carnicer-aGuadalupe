<!DOCTYPE html>
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

$ids= $rows['id'];
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
    <link rel="stylesheet" href="estilo3rep.css">
    <link rel="stylesheet" href="estilrep.css">
  <link rel="stylesheet" href="estilos_tblResultados.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<style>
  @media print {
    body * {
      visibility: hidden;
      /* Oculta todos los elementos */
    }

    .printable,
    .printable * {
      visibility: visible;
      /* Muestra solo los elementos con la clase 'printable' y sus descendientes */
    }

    .printable {
      position: absolute;
      left: 0;
      top: 0;
    }
  }
  </style>
<body>

<body>
<header>
        <div>
        <nav>
            <input type="checkbox" id="menuToggle">
            <label for="menuToggle" class="hamburger">&#9776;</label>
            <div class="contas"> 
                <img src="log.png" alt="Carniceria" >
            <div id="logo"  class="txtmov">      
                <h1>Carniceria Guadalupe</h1>
            </div>
            </div>
            <ul class="nav-list">
                <li>
                <h2 class="d-lg-inline" >
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


<div  class="w-75 m-auto pb-5 pt-3">
   <h2>Ventas realizadas en determinada fecha</h2>
  <form action="" method="GET">

    <section class=" w-75 m-50 pb-5 pt-4 d-lg-inline">
          <div class="col-12 d-lg-inline">
         
            <label ><b>Seleccione el rango de fechas</b></label>
            <input type="date" name="from_date" style=" border-color: #f08030; border-radius: 5px; padding: 5px 10px;" value="<?php if (isset($_GET['from_date'])) {
                                                          echo $_GET['from_date'];
                                                        } ?>" class="form-control" min="<?= date('2024-01-01') ?>" max="<?= date('Y-m-d') ?>">
                                                        
          
        
            <input type="date" name="to_date"  style=" border-color: #f08030; border-radius: 5px; padding: 5px 10px;" value="<?php if (isset($_GET['to_date'])) {
                                                        echo $_GET['to_date'];
                                                      } ?>" class="form-control" min="<?= date('2024-01-01') ?>" max="<?= date('Y-m-d') ?>">
          </div>
      <div class="col-md-12 d-lg-inline">
          <button type="submit" class="btn btn-primary" style="background-color: #f08030; border-color: #f08030; color: white; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 15px;">Buscar</button>
       
      </div>
      </secttion>
    <br>
  </form>
  </div>



<form action="">
<div  class="row w-100">
  <div class="printable">
  <?php
  include 'conexion_be.php';

  if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];

    $query = "SELECT * FROM ventas WHERE fecha_venta BETWEEN '$from_date' AND '$to_date' ";
    $result = $conexion->query($query);
    $query_run = $conexion->query($query);
    $resultado_consulta = $conexion->query($query);
    $query = "SELECT SUM(total_producto) AS total_producto 
    FROM ventas 
    WHERE fecha_venta BETWEEN '$from_date' AND '$to_date'";
$result = $conexion->query($query);

// Check query result
if ($result) {
// Fetch the result as an associative array
$row = mysqli_fetch_assoc($result);

// Extract the total sales value
$totalSales = $row['total_producto'];
// Display the total sales
echo "Total ventas: $ " . $totalSales;
} else {
echo "Error al ejecutar la consulta: " . mysqli_error($connection);
}
    if (!$resultado_consulta) {
      echo "Error: " . mysqli_error($conexion);
      exit;
    }

    if (mysqli_num_rows($query_run) > 0) {
      echo '<table id="tablitadeuwu" class="table ta   table-bordered mb-4">';
      echo "<tr>";
      echo "<th>Id</th>";
      echo "<th>Empleado</th>";
      echo "<th>Producto id</th>";
      echo "<th>Nombre del roducto</th>";
      echo "<th>Categoria</th>";
      echo "<th>Cantidad</th>";
      echo "<th>Precio</th>";
      echo "<th>Fecha de venta</th>";
      echo "<th>Total del producto</th>";
      echo "</tr>";

      foreach ($query_run as $fila) {
        echo "<tr>";
        echo "<td>" . $fila['id'] . "</td>";
        echo "<td>" . $fila['id_empleado'] . "</td>";
        echo "<td>" . $fila['codigo_produc'] . "</td>";
        echo "<td>" . $fila['nombre_producto'] . "</td>";
        echo "<td>" . $fila['categoria_producto'] . "</td>";
        echo "<td>" . $fila['cantidad_producto'] . "</td>";
        echo "<td>" . $fila['precio_producto'] . "</td>";
        echo "<td>" . $fila['fecha_venta'] . "</td>";
        echo "<td>" . $fila['total_producto'] . "</td>";
        echo "</tr>";
      }

      echo "</table>";
    } else {
      echo "<tr><td>No se encontraron resultados</td></tr>";
    }
  }

  ?>
  </div>
  <div>
    <button class='btn btn-primary mb-4' onclick='window.print()'>Exportar a PDF</button>
  </div>
  </div>
  

  
  
  </form>
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
  <p align ="center">&copy; 2024 Carniceria Guadalupe</p>   
  </div>  
</div>   
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script><!-- comment -->

</html>