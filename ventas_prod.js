var agregar = document.getElementById("btnAgregarProd");
var tabla = document.getElementById('tabla');
var guardar = document.getElementById('vender');
var data = [];
var cant = 1;

agregar.addEventListener("click", btnAgregarProd);
guardar.addEventListener("click", save);

function btnAgregarProd() {
    var id = document.getElementById('idProducto').value;
    var nombre = document.getElementById('nombreProducto').value;
    var precio = parseFloat(document.getElementById('precioProducto').value);
    var cantidad = parseFloat(document.getElementById('cantidadProducto').value);

    if (!id || !nombre || isNaN(precio) || isNaN(cantidad) || cantidad <= 0) {
        alert("Por favor, completa todos los campos correctamente.");
        return;
    }

    var total = (precio * cantidad).toFixed(2);

    // Agregar elementos al arreglo
    data.push({
        "no": cant,
        "id": id,
        "nombre": nombre,
        "precio": precio,
        "cantidad": cantidad,
        "total": parseFloat(total)
    });

    var id_row = 'row' + cant;
    var fila = '<tr id="' + id_row + '"><td>' + cant + '</td><td>' + id + '</td><td>' + nombre +
        '</td><td>' + precio.toFixed(2) + '</td><td>' + cantidad.toFixed(2) + '</td><td>' + total +
        '</td><td><a href="#" class="btn btn-warning" onclick="editar(' + (cant - 1) +
        ')">Editar</a> <a href="#" class="btn btn-danger" onclick="eliminar(' + (cant - 1) +
        ')">Eliminar</a></td></tr>';

    // Agregar a la tabla
    $("#tabla tbody").append(fila);
    $("#idProducto").val('');
    $("#nombreProducto").val('');
    $("#precioProducto").val('');
    $("#cantidadProducto").val('');
    $("#idProducto").focus();
    cant++;
    sumar();
}

function sumar() {
    let tot = 0;
    for (let x of data) {
        tot += x.total;
    }
    document.querySelector("#totalVenta").innerHTML = "$ " + parseFloat(tot).toFixed(2);
}

function eliminar(row) {
    // Remueve la fila de la tabla html
    $("#row" + (row + 1)).remove();

    // Remover el elemento del arreglo
    data.splice(row, 1);

    // Actualizar índices y IDs de las filas restantes en la tabla
    for (let i = row; i < data.length; i++) {
        let newIndex = i + 1;
        $("#row" + (newIndex + 1)).attr('id', 'row' + newIndex);
        $("#row" + newIndex + " td:first-child").text(newIndex);
        $("#row" + newIndex + " .btn-warning").attr('onclick', 'editar(' + i + ')');
        $("#row" + newIndex + " .btn-danger").attr('onclick', 'eliminar(' + i + ')');
    }

    sumar();
}

function editar(row) {
    var canti = parseFloat(prompt("Nueva cantidad"));
    if (isNaN(canti) || canti <= 0) {
        alert("Por favor, introduce un número válido.");
        return;
    }
    data[row].cantidad = canti;
    data[row].total = parseFloat((data[row].cantidad * data[row].precio).toFixed(2));

    var filaid = document.getElementById("row" + (row + 1));
    var celdas = filaid.getElementsByTagName('td');
    celdas[4].innerHTML = canti.toFixed(2);
    celdas[5].innerHTML = data[row].total.toFixed(2);

    console.log(data);
    sumar();
}

function save() {
    var totalVenta = parseFloat(document.querySelector("#totalVenta").textContent.replace('$ ', ''));
    var montoRecibido = parseFloat($("#montoRec").val());

    console.log("Monto recibido:", montoRecibido);
    console.log("Total venta:", totalVenta);

    if (isNaN(montoRecibido) || montoRecibido <= 0) {
        alert("Por favor, ingresa un monto recibido válido.");
        return;
    }

    var cambio = montoRecibido - totalVenta;

    if (cambio < 0) {
        alert("El monto recibido es insuficiente para cubrir el total de la venta.");
        return;
    }

    $("#cambio").val(cambio.toFixed(2));

    var json = JSON.stringify(data);
    $.ajax({
        type: "POST",
        url: "productos_vend.php",
        data: { json: json },
        success: function (resp) {
            console.log(resp);
            alert("Venta registrada con éxito. Cambio: $" + cambio.toFixed(2));
            location.reload();
        }
    });
}

// Funcionalidad del botón Cancelar
$("#cancelar").click(function () {
    // Limpiar todos los campos del formulario y la tabla de productos
    $("#checkoutForm")[0].reset();
    $("#tabla tbody").empty();
    $("#totalVenta").text("$ 0.00");
    $("#montoRec").val('');
    $("#cambio").val('');
    data = [];
    cant = 1;
});

// Código para mostrar producto
$("#mostrarProducto").click(function () {
    var codigoProducto = $("#idProducto").val();
    if (codigoProducto !== "ID") {
        $.ajax({
            type: "POST",
            url: "obtener_producto.php",
            data: { codigo_produc: codigoProducto },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#nombreProducto").val(response.nombre);
                    $("#existenciaProducto").val(response.existencia); // Aquí se agrega la cantidad existente
                    $("#precioProducto").val(response.precio_venta);
                } else {
                    alert("Error al obtener el dato de la base de datos.");
                }
            }
        });
    } else {
        alert("Por favor, selecciona un producto.");
    }
});

