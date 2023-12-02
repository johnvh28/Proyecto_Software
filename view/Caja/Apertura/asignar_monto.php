<?php require_once "view/include/header_admin.php"; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="#">Caja</a></li>
                        <li class="breadcrumb-item active">Solicitud de apertura de caja</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="card mb-30">
            <div class="card-header">
                <div class="pull-left">
                    <h4 class="text-blue h4">Asignar Montos</h4>
                    <p class="mb-30">Rellene todos los campos*</p>
                </div>
            </div>
            <form id="crear" class="card-body" name="crear" autocomplete="off">
                <?php $id_apertura = $_GET['id'] ?>


                <div class="form-group row">
                    <div class="col-md-4 col-sm-12">
                        <label style="font: bold 16px Arial, sans-serif;">Tipo de moneda para apertura:</label>
                        <select name="moneda" id="moneda" class="select2 form-select-lg shadow-none" style="width: 100%; height:100%" required>
                            <?php foreach ($moneda['moneda'] as $divisa) { ?>
                                <optgroup label="<?php echo $divisa['nombre']; ?>" data-nombre="<?php echo $divisa['nombre']; ?>">
                                    <?php foreach ($divisa['monedas'] as $moneda) { ?>
                                        <option value="<?php echo $moneda['id']; ?>" data-nombre="<?php echo $moneda['nombre']; ?>"><?php echo $moneda['nombre']; ?></option>
                                    <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label style="font: bold 16px Arial, sans-serif;">Monto de la denominacion:</label>
                        <input name="monto_dolares" id="monto_dolares" type="number" class="form-control">
                    </div>


                    <div class="col-md-4 col-sm-12 d-flex align-items-end">
                        <button id="guardar" name="guardar" type="button" class="btn btn-success">Agregar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card mb-30">
            <div id="carrito" class="col-md-12">
                <div class="card-header">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Desglose de apertura</h4>
                      
                    </div>
                </div>
                <form id="formulario" action="index.php?c=caja&a=guardar_apertura" method="post">
                    <!-- Otros campos del formulario -->
                    <input type="text" name="id" value=" <?php echo $id = $_GET['id'] ?>" hidden>
                    <input type="text" name="id_trabajador" value="<?php echo $_SESSION['IdEmpleado'] ?>" hidden>
                    <input type="hidden" id="datosCarrito" name="datosCarrito" value="">
                    <div class="col-md-4 col-sm-12 d-flex align-items-end">
                        <input type="submit" value="Realizar solicitud" class="btn btn-success" id="btnSolicitud">
                        <br>
                        <br>
                    </div>

                </form>
                <div class="table-responsive">
                    <table id="tabla-caja" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Divisa</th>
                                <th scope="col">Denominacion</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>

                    </table>
                </div>

            </div>

        </div>



    </section>
</div>
<script>
    const carrito = []; // Definir el arreglo del carrito

    const guardarBtn = document.getElementById('guardar');
    const monedaSelect = document.getElementById('moneda');

    const montoDolaresInput = document.getElementById('monto_dolares');
    const tablaCaja = document.getElementById('tabla-caja');

    function actualizarEstadoBotonSolicitud() {
        const btnSolicitud = document.getElementById('btnSolicitud');

        if (carrito.length > 0) {
            btnSolicitud.style.display = 'block';
        } else {
            btnSolicitud.style.display = 'none';
        }
    }
    guardarBtn.addEventListener('click', function(event) {
        event.preventDefault();

        const monedaSeleccionada = monedaSelect.options[monedaSelect.selectedIndex];
        const divisaNombre = monedaSeleccionada.parentElement.label;
        const monedaNombre = monedaSeleccionada.dataset.nombre;
        const monedaId = monedaSeleccionada.value;
        const montoDolares = parseFloat(montoDolaresInput.value);

        const fila = document.createElement('tr');
        const columnaNumero = document.createElement('td');
        const columnaDivisa = document.createElement('td');
        const columnaMoneda = document.createElement('td');
        const columnaDenominacion = document.createElement('td');

        const columnaAcciones = document.createElement('td');

        columnaNumero.textContent = tablaCaja.rows.length; // Número de la fila
        columnaDivisa.textContent = divisaNombre;
        columnaMoneda.textContent = monedaNombre;
        columnaDenominacion.textContent = montoDolares; // Puedes modificar esto según tus necesidades

        const editarBtn = document.createElement('button');
        editarBtn.textContent = 'Editar';
        editarBtn.classList.add('btn', 'btn-warning');
        editarBtn.addEventListener('click', editarCantidad);
        const espacio = document.createElement('span');
        espacio.innerHTML = '&nbsp;';

        const eliminarBtn = document.createElement('button');
        eliminarBtn.textContent = 'Eliminar';
        eliminarBtn.classList.add('btn', 'btn-danger');
        eliminarBtn.addEventListener('click', eliminarDenominacion);

        columnaAcciones.appendChild(editarBtn);
        columnaAcciones.appendChild(espacio);
        columnaAcciones.appendChild(eliminarBtn);

        fila.appendChild(columnaNumero);
        fila.appendChild(columnaDivisa);
        fila.appendChild(columnaMoneda);
        fila.appendChild(columnaDenominacion);
        fila.appendChild(columnaAcciones);

        tablaCaja.querySelector('tbody').appendChild(fila);

        // Agregar al carrito
        const producto = {
            divisa: divisaNombre,
            moneda: monedaNombre,
            monedaId: monedaId,
            denominacion: '', // Puedes modificar esto según tus necesidades
            monto: montoDolares
        };

        carrito.push(producto);

        montoDolaresInput.value = '';
        actualizarEstadoBotonSolicitud();
    });

    function editarCantidad(event) {
        const fila = event.target.parentElement.parentElement; // Obtener la fila actual
        const index = fila.rowIndex - 1; // Obtener el índice de la fila restando 1
        Swal.fire({
            title: 'Ingrese la nueva cantidad:',
            input: 'number',
            inputAttributes: {
                step: '0.01', // Ajusta el paso según tus necesidades
            },
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                if (!value) {
                    return 'Debes ingresar una cantidad';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const nuevaCantidad = parseFloat(result.value);
                carrito[index].cantidad = nuevaCantidad;
                fila.querySelector('td:nth-child(4)').textContent = nuevaCantidad;
            }
        });
    }

    function eliminarDenominacion(event) {
        const fila = event.target.parentElement.parentElement; // Obtener la fila actual
        const index = fila.rowIndex - 1; // Obtener el índice de la fila restando 1
        carrito.splice(index, 1);
        fila.remove(); // Eliminar la fila de la tabla
    }
    document.getElementById('formulario').addEventListener('submit', function(event) {
        const datosCarritoInput = document.getElementById('datosCarrito');
        datosCarritoInput.value = JSON.stringify(carrito);
    });
    actualizarEstadoBotonSolicitud();
</script>
<?php require_once "view/include/footer_admin.php"; ?>