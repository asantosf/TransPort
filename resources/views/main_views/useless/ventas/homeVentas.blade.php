<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    @include('layouts.librerias')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layouts.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">

                            <!-- Approach -->
                            <div class="card shadow mb-12">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="m-0 font-weight-bold text-primary">Administrador de Ventas</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-info fa-pull-right" onclick="limpiar()">Nueva
                                                Orden</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" id='buscar' name="buscar" placeholder="Buscar..."
                                                class="form-control">
                                            <input type="hidden" id="idcliente" name="idcliente">
                                            <input type="hidden" id="idorden" name="idorden">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="">Nombre Cliente</label>
                                            <input type="text" id="nombre_comercial" name="nombre_comercial"
                                                class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Nit</label>
                                            <input type="text" id="nit" name="nit" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Telefono</label>
                                            <input type="text" id="telefono" name="telefono" class="form-control"
                                                disabled>
                                        </div>
                                    </div>
                                    <br>
                                    <div id="detalleOrden">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Lote</label>
                                                <select name="lote" id="lote" class="form-control"
                                                    onchange="llenarDisponible(this.value)">
                                                    <option value="">Seleccionar....</option>
                                                    @foreach ($lotes as $item)
                                                        <option value="{{ $item->id }}">{{ $item->id }} -
                                                            {{ $item->descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row" id="disponible_div">
                                            <div class="col-md-2">
                                                <label for="">Disponible</label>
                                                <input disabled type="text" id="disponible_" name="disponible_"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Fecha de Vencimiento</label>
                                                <input disabled type="text" id="vencimient_" name="vencimiento_"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Cantidad</label>
                                                <input type="number" id="cantidad_" name="cantidad_"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Precio</label>
                                                <input type="number" id="precio_" name="precio_" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" id="botonGuardar_div">
                                                <button class="btn btn-success fa-pull-left" onclick="guardarOrden()"
                                                    style="margin-top: 32px">
                                                    Guardar
                                                </button>    
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row" id="detalleOrden_div">
                                        <h4>Detalle de Orden</h4>
                                        <div class="col-md-4">
                                            <button class="badge badge-warning" onclick="limpiarTabla()">Limpiar
                                                Detalle</button>
                                            <button class="badge badge-danger" onclick="removerLast()">Remover
                                                ultimo</button>
                                        </div>
                                        <br><br>
                                        <table class="display table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Descripcion</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_">

                                            </tbody>
                                            <tbody id="tfoot_">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Developed by &copy; Allan Santos - 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Modal -->
    @include('main_views.ventas.guardarVentas')

    <div class="modal fade" id="eidtarProductoModal" tabindex="-1" role="dialog"
        aria-labelledby="guardarProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="editarProducto_content">
            </div>
        </div>
    </div>

    <!--Cambio de contraseña modal-->
    @include('layouts.passwordModal')

    <!-- Logout Modal-->
    @include('layouts.logoutModal')

    @include('layouts.scripts')
    <!-- Script -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>

</html>

<script type="text/javascript">
    var detallOrden = [];

    $(document).ready(function() {
        $('#detalleOrden').hide();
        $('#botonGuardar_div').hide();
        $('#detalleOrden_div').hide();

        $("#buscar").autocomplete({
            minLength: 3
        }, {
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "{{ route('buscarCliente') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: request.term
                    },
                    success: function(data) {

                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                
                if (ui.item.orden_pendiente != 0)
                {
                    ordenPendiente(ui.item.orden_pendiente);
                } 

                guardarTemporal(ui.item.value, ui.item.nit);
                $('#buscar').val(ui.item.label);
                $('#nit').val(ui.item.nit);
                $('#nombre_comercial').val(ui.item.nombre_comercial);
                $('#telefono').val(ui.item.telefono);
                $('#idcliente').val(ui.item.value);
                $('#detalleOrden').show();
                $('#botonGuardar_div').show();
                $('#detalleOrden_div').show();

                return false;
            }
        });
    });

    function ordenPendiente(idorden)
    {
        $.ajax({
            url: "{{ route('borrarPendiente') }}",
            type: 'post',
            data:
            {
                idorden: idorden,
                _token: "{{ csrf_token() }}"
            }
        }).done(function (res) {
        });
    }

    function guardarTemporal(idcliente, nit)
    {
        $.ajax({
            url: "{{ route('temporal') }}",
            type: 'post',
            data:
            {
                idcliente: idcliente,
                nit: nit,
                _token: "{{ csrf_token() }}"
            }
        }).done(function (res) {
            $('#idorden').val(res); 
        });
    }

    function detalleTemp(lote, cantidad, idcliente, idordenTemp)
    {
        $.ajax({
            url: "{{ route('detalleTemp') }}",
            type:'post',
            data:
            {
                idcliente: idcliente,
                idordenTemp: idordenTemp,
                lote: lote,
                cantidad: cantidad,
                _token: "{{ csrf_token() }}"
            }
        })
    }

    function guardarOrden() 
    {
        var idcliente = $('#idcliente').val();
        var idorden = $('#idorden').val();
        var total = cargarPieTabla();

        if (detallOrden == '')
        {
            swal({
                title: "Atención!",
                text: "Ordenes deben contener al menos 1 registro de detalle.",
                icon: "info",
            });
        } else {
            swal({
                title: "Esta seguro?",
                text: "Al guardar no sera posible modificar esta orden.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((guardar) => {
                if (guardar) {
                    $.ajax({
                        url: "{{ route('guardarOrden') }}",
                        type: 'post',
                        data: 
                        {
                            idcliente: idcliente,
                            detallOrden: detallOrden,
                            idorden: idorden,
                            total: total,
                            _token: "{{ csrf_token() }}"
                        }
                    }).done(function (res){
                        if (res == 'success')
                        {
                            swal({
                                title: "Exito!",
                                text: "Orden guardada con exito!",
                                icon: "success",
                            });
                            limpiar();
                        } else {
                            swal({
                                title: "Error!",
                                text: "Algo salió mal, por favor intente de nuevo.",
                                icon: "error",
                            });
                        }
                    });
                } else {
                    swal("Cancelado!");
                }
            });
        }
    }

    function limpiar() 
    {
        $('#buscar').val('');
        $('#idcliente').val('');
        $('#nombre_comercial').val('');
        $('#nit').val('');
        $('#telefono').val('');
        $('#lote').val('');
        $('#disponible').val('');
        $('#vencimiento').val('');
        $('#idorden').val('');
        limpiarTabla();
        $('#detalleOrden').hide();
        $('#detalleOrden_div').hide();
    }

    function agregar() 
    {
        var idcliente = $('#idcliente').val();
        var idordenTemp = $('#idorden').val();
        var lote = $('#lote').val();
        var loteName = $('#lote  option:selected').text();
        var cantidad = $('#cantidad').val();
        var precio = $('#precio').val();
        var subtotal = cantidad * precio;
        var disponibleActual = $('#precio').val();
        var vencimiento = $('#vencimiento').val();
        var disponible = $('#disponible').val();
        
        console.log(disponible);
        console.log(cantidad);

        if (parseInt(disponible) < parseInt(cantidad))
        {
            swal({
                title: "Atención!",
                text: "Cantidad supera la disponibilidad, por favor revise.\n Lote: "+loteName+"\nCantidad disponible: "+disponible,
                icon: "warning",
            });
        } else {        
            detalleTemp(lote, cantidad, idcliente, idordenTemp);
            
            detallOrden.push({
                lote: lote,
                loteName: loteName,
                vencimiento: vencimiento,
                cantidad: cantidad,
                precio: precio,
                subtotal: subtotal
            });

            $('#disponible').val('');
            $('#vencimiento').val('');
            $('#lote').val('');
            $('#cantidad').val('');
            $('#precio').val('');

            cargarTabla();
            cargarPieTabla();

            return detallOrden
        }
    }

    function cargarTabla() {
        $('#tbody_').html("");
        for (var i = 0; i < detallOrden.length; i++) 
        {
            var tr =
                `<tr>
                <td>` + detallOrden[i].loteName + `</td>
                <td>` + detallOrden[i].cantidad + `</td>
                <td>` + detallOrden[i].precio + `</td>
                <td>` + detallOrden[i].subtotal + `</td>
            </tr>`;
            $('#tbody_').append(tr);
        }
    }

    function cargarPieTabla() 
    {
        $('#tfoot_').html("");
        var total = 0;
        for (var i = 0; i < detallOrden.length; i++) {
            total = detallOrden[i].subtotal + total;
        }
        var tr =
            `<tr>
            <td></td>
            <td></td>
            <th>Total</th>
            <td>` + total + `</td>
        </tr>`;
        $('#tfoot_').append(tr);

        return total;
    }

    function limpiarTabla() 
    {
        var tipo = 1;
        var idorden = $('#idorden').val();

        liberarTemporal(idorden, tipo);

        detallOrden = [];

        cargarTabla();
        cargarPieTabla();
    }

    function removerLast() 
    {
        var idorden = $('#idorden').val();
        var tipo = 2;
        detallOrden.pop();

        liberarTemporal(idorden, tipo);

        cargarTabla();
        cargarPieTabla();
    }

    function llenarDisponible(idlote) 
    {
        $.ajax({
            url: "{{ route('disponible') }}",
            type: 'post',
            data: {
                idlote: idlote,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#disponible_div').html(data);
            }
        })
    }
    
    function liberarTemporal(idorden, tipo)
    {
        $.ajax({
            url: "{{ route('removerUlitmo') }}",
            type: 'post',
            data:
            {
                idorden: idorden,
                tipo: tipo,
                _token: "{{ csrf_token() }}"
            }
        }).done(function (res) {
            if (res == 1)
            {
                $('#disponible').val('');
                $('#vencimiento').val('');
                $('#lote').val('');
                $('#cantidad').val('');
                $('#precio').val('');
            }
        });
    }

</script>
