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
                                            <h6 class="m-0 font-weight-bold text-primary">Reporte de Ventas</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Fecha Desde</label>
                                            <input type="date" id="desde" name="desde" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Fecha Hasta</label>
                                            <input type="date" id="hasta" name="hasta" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Estado</label>
                                            <select name="estado" id="estado" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="1">Procesadas</option>
                                                <option value="2">Devoluciones</option>
                                                <option value="nulo">Canceladas</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-info" onclick="filtrar()" style="margin-top: 32px">Filtrar</button>
                                            <button class="btn btn-secondary" onclick="limpiarFiltros()" style="margin-top: 32px">Limpiar Filtros</button>
                                        </div> 
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tablaVentas" style="width: 100%"
                                                class="table table-condensed table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Id Orden</th>
                                                        <th>Cliente</th>
                                                        <th>Total</th>
                                                        <th>Ingresado Por</th>
                                                        <th>Estado de Venta</th>
                                                        <th>Fecha de Orden</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
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

    <div class="modal fade" id="detaleOrdenModal" tabindex="-1" role="dialog"
        aria-labelledby="detalleOrdenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:1250px;">
            <div class="modal-content" id="detaleOrden_content">
            </div>
        </div>
    </div>

    <div class="modal fade" id="devolucionModal" tabindex="-1" role="dialog"
        aria-labelledby="devolucionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" style="width:1250px;">
            <div class="modal-content" id="devolucion_content">
            </div>
        </div>
    </div>

</body>

</html>

<script type="text/javascript">

    $(document).ready(function() {
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var estado = $('#estado').val();

        tableVentas(desde, hasta, estado);
    });

    function tableVentas(desde, hasta, estado) 
    {
        $('#tablaVentas').DataTable({
            autoWidth: true,
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            scrollCollapse: false,
            scrollX: true,

            ajax: {
                url: "{{ route('tablaVentas') }}",
                type: 'post',
                data:
                {
                    desde: desde,
                    hasta: hasta,
                    estado, estado,
                    _token: "{{ csrf_token() }}"
                }
            },
            aoColumns: 
            [
                { data: 'idorden' },
                { data: 'nombre_cliente' },
                { data: 'total' },
                { data: 'creado_por' },
                { data: 'estado' },
                { data: 'fecha_orden' },
                {
                    data: 'actions',
                    orderable: false,
                    
                    render: function(data, type, row, meta) {

                        if (row.estado == 'Cancelada')
                        {
                            var output = "<button class='badge rounded-pill bg-danger'" +
                            " onclick='finalizar(" + row.idorden + ")' title='Finalizar Orden'>" +
                            "<i class='far fa-times-circle'></i>" +
                            "</button>";
                        } else if (row.estado == 'Devolución') {
                            var output = "<button class='badge rounded-pill bg-info'" +
                            "onclick='detalles(" + row.idorden + ")' title='Detalles de Orden'>" +
                            "<i class='fas fa-eye'></i>" +
                            "</button>";
                        } else {
                            var output = "<button class='badge rounded-pill bg-info'" +
                            "onclick='detalles(" + row.idorden + ")' title='Detalles de Orden'>" +
                            "<i class='fas fa-eye'></i>" +
                            "</button>" +
                            "<button class='badge rounded-pill bg-warning'" +
                            " onclick='devolucionLoad(" + row.idorden + ")' title='Devolución'>" +
                            "<i class='fas fa-cart-arrow-down'></i>" +
                            "</button>";   
                        }

                        return output;
                    }
                }
            ]
        });
    }

    function filtrar()
    {
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var estado = $('#estado').val();

        if (desde == '' && hasta == '' && estado == '') 
        {
            swal({
                title: "Info!",
                text: "Por favor seleccione fechas antes de filtrar",
                icon: "info",
            });
        } else {
            tableVentas(desde, hasta, estado);
        }
    }

    function limpiarFiltros()
    {
        $('#desde').val('');
        $('#hasta').val('');
        $('#estado').val('')
        var desde = '';
        var hasta = '';
        var estado = '';

        tableVentas(desde, hasta, estado);
    }

    function detalles(idorden)
    {
        var detaleOrdenModal = $('#detaleOrdenModal');
        var detaleOrden_content = $('#detaleOrden_content');
        $.ajax({
            url: "{{ route('orderDetail') }}",
            type:"post",
            data:
            {
                idorden: idorden,
                _token: "{{ csrf_token() }}"
            }
        }).done(function (data) {
            detaleOrdenModal.modal('toggle');
            detaleOrden_content.html(data);
        });
    }

    function finalizar(idorden)
    {
        swal({
            title: "Esta seguro?",
            text: "Al cancelar la orden, se liberaran los productos en reserva.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('finalizarOrden') }}",
                    type:"post",
                    data:
                    {
                        idorden: idorden,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function (data) {
                    swal({
                        title: "Exito",
                        text: "Orden Finalizada correctamente, cantidades en reserva, han sido liberadas.",
                        icon: 'success'
                    });
                    $('#tablaVentas').DataTable().ajax.reload();
                });
            }
            else {
                swal("Cancelado!");
            }
        });
    }
    
    function devolucionLoad(idorden)
    {
        var devolucionModal = $('#devolucionModal');
        var devolucion_content = $('#devolucion_content');

        $.ajax({
            url: "{{ route('devolucionOrdenView') }}",
            type:"post",
            data:
            {
                idorden: idorden,
                _token: "{{ csrf_token() }}"
            }
        }).done(function (data) {
            devolucionModal.modal('toggle');
            devolucion_content.html(data);
        });
    }

</script>