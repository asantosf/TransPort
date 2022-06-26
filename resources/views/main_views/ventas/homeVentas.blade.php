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
                                        <div class="col-md-4">
                                            <label for="">Nit</label>
                                            <input type="text" id='buscar' name="buscar" placeholder="Buscar..." class="form-control">
                                            <input type="hidden" id="idcliente" name="idcliente">
                                            <input type="hidden" id="idorden" name="idorden">
                                        </div>
                                        <div class="col-md-8">
                                            <label for="">Nombre Cliente</label>
                                            <input type="text" id="cliente" name="cliente" class="form-control" >
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="">Direccion</label>
                                            <input type="text" id="direccion" name="direccion" class="form-control" >
                                        </div>
                                    </div>
                                    <br>
                                    <div id="detalleOrden">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Producto</label>
                                                <input type="text" id="producto" name="producto" class="form-control">
                                                <input type="hidden" id="idproducto" name="idproducto">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row" id="disponible_div">
                                            <div class="col-md-3">
                                                <label for="">Disponible</label>
                                                <input disabled type="text" id="disponible_" name="disponible_" class="form-control"> 
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Precio</label>
                                                <input type="number" id="precio_" name="precio_" class="form-control" disabled>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Cantidad</label>
                                                <input type="number" id="cantidad_" name="cantidad_" class="form-control">
                                            </div> 
                                            <div class="col-md-3" id="agregar">
                                                <button type="button" class="badge badge-pill badge-success" onclick="agregar()" style="margin-top: 40px">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="metodo_pago" id="metodo_pago" class="form-control">
                                                    <option value="">Seleccione Metodo de Pago</option>
                                                    @foreach ($metodo_pago as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6" id="botonGuardar_div">
                                                <button class="btn btn-success fa-pull-left" onclick="guardarOrden()">
                                                    Guardar
                                                </button>    
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row" id="detalleOrden_div">
                                        <h4>Detalle de Factura</h4>
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
        $('#agregar').hide();
        $('#detalleOrden').hide();
        $('#botonGuardar_div').hide();
        $('#detalleOrden_div').hide();

        //buscar cliente
        $("#buscar").autocomplete({
            minLength: 3
        }, {
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "{{ route('validaNIT') }}",
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

                guardarTemporal(ui.item.value);
                
                $('#buscar').val(ui.item.nit);
                $('#cliente').val(ui.item.label);
                $('#idcliente').val(ui.item.value);
                $('#direccion').val(ui.item.direccion);
                $('#detalleOrden').show();
                $('#botonGuardar_div').show();
                $('#detalleOrden_div').show();

                return false;
            }
        });

        //buscar producto
        $("#producto").autocomplete({
        minLength: 1
        }, {
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "{{ route('buscarProducto') }}",
                    type: 'post',
                        dataType: "json",
                        data: {
                            _token: "{{ csrf_token() }}",
                            producto: request.term
                        },
                        success: function(data) {

                            response(data);
                        }
                    });
            },
            select: function(event, ui) {
                
                $('#producto').val(ui.item.label);
                $('#idproducto').val(ui.item.value);
                $('#precio_').val(ui.item.precio);
                $('#disponible_').val(ui.item.stock);
                $('#agregar').show();

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

    function guardarTemporal(idcliente)
    {
        $.ajax({
            url: "{{ route('temporal') }}",
            type: 'post',
            data:
            {
                idcliente: idcliente,
                _token: "{{ csrf_token() }}"
            }
        }).done(function (res) {
            $('#idorden').val(res); 
        });
    }

    function detalleTemp(idproducto, cantidad, idcliente, idordenTemp)
    {
        $.ajax({
            url: "{{ route('detalleTemp') }}",
            type:'post',
            data:
            {
                idcliente: idcliente,
                idordenTemp: idordenTemp,
                idproducto: idproducto,
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
        var metodo_pago = $('#metodo_pago').val();
        var nuevoNit = $('#buscar').val();
        var cliente = $('#cliente').val();
        var direccion = $('#direccion').val();

        if (detallOrden == '' || metodo_pago == '')
        {
            swal({
                title: "Atención!",
                text: "Por favor, complete los datos necesarios antes de guardar.",
                icon: "info",
            });
        } else {
            swal({
                title: "Esta seguro?",
                text: "De crear la factura.",
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
                            metodo_pago: metodo_pago,
                            nuevoNit: nuevoNit,
                            cliente: cliente,
                            direccion: direccion,
                            _token: "{{ csrf_token() }}"
                        }
                    }).done(function (res){
                        if (res == 'success')
                        {
                            swal({
                                title: "Exito!",
                                text: "Factura guardada con exito!",
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
        $('#idorden').val('');
        $('#cliente').val('');
        $('#direccion').val('');
        $('#producto').val('');
        $('#disponible_').val('');
        $('#precio_').val('');
        $('#cantidad_').val('');
        limpiarTabla();
        $('#detalleOrden').hide();
        $('#detalleOrden_div').hide();
    }

    function agregar() 
    {
        var idcliente = $('#idcliente').val();
        var idordenTemp = $('#idorden').val();
        var producto = $('#producto').val();
        var idproducto = $('#idproducto').val();
        var cantidad = $('#cantidad_').val();
        var precio = $('#precio_').val();
        var disponible = $('#disponible_').val();

        var subtotal = cantidad * precio;
        
        if (parseInt(disponible) < parseInt(cantidad))
        {
            swal({
                title: "Atención!",
                text: "Cantidad supera la disponibilidad, por favor revise.\n Lote: "+loteName+"\nCantidad disponible: "+disponible,
                icon: "warning",
            });
        } else if (cantidad == '') {
            swal({
                title: "Atención!",
                text: "Ingrese cantidad comprada, antes de agregar el producto.",
                icon: "warning",
            });
        } else {        
            detalleTemp(idproducto, cantidad, idcliente, idordenTemp);
            
            detallOrden.push({
                idproducto: idproducto,
                producto: producto,
                cantidad: cantidad,
                precio: precio,
                subtotal: subtotal
            });

            $('#producto').val('');
            $('#cantidad_').val('');
            $('#precio_').val('');
            $('#disponible_').val('');
            $('#agregar').hide();

            cargarTabla();
            cargarPieTabla();

            return detallOrden
        }
    }

    function cargarTabla() 
    {
        $('#tbody_').html("");
        for (var i = 0; i < detallOrden.length; i++) 
        {
            var tr =
                `<tr>
                <td>` + detallOrden[i].producto + `</td>
                <td>` + detallOrden[i].cantidad + `</td>
                <td>Q.` + detallOrden[i].precio + `</td>
                <td>Q.` + detallOrden[i].subtotal + `</td>
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
            <td>Q.` + total + `</td>
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
