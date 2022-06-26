<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

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
                                    <h6 class="m-0 font-weight-bold text-primary">Administrador de Productos</h6>

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 mb-auto">
                                            <button class="btn btn-primary fa-pull-right" data-toggle="modal"
                                                data-target="#guardarProductoModal">Agregar Producto</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="">Fecha Desde</label>
                                            <input type="date" id="desde" name="desde" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Fecha Hasta</label>
                                            <input type="date" id="hasta" name="hasta" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-info" onclick="filtrar()" style="margin-top: 32px">Filtrar</button>
                                            <button class="btn btn-secondary" onclick="limpiarFiltros()" style="margin-top: 32px">Limpiar Filtros</button>
                                        </div> 
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tablaProductos" style="width: 100%"
                                                class="table table-condensed table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre de Producto</th>
                                                        <th>Medida</th>
                                                        <th>Cantidad Minima</th>
                                                        <th>Fecha Creacion</th>
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

    <!-- Modal -->
    @include('main_views.productos.guardarProducto')

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
</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();

        tableProductos(desde, hasta);
    });

    function tableProductos(desde, hasta) {
        $('#tablaProductos').DataTable({
            autoWidth: true,
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            scrollCollapse: false,
            scrollX: true,

            ajax: {
                url: "{{ route('productosTabla') }}",
                type: 'post',
                data:
                {
                    desde: desde,
                    hasta: hasta,
                    _token: "{{ csrf_token() }}"
                }
            },
            aoColumns: [{
                    data: 'nombre_producto'
                },
                {
                    data: 'medida'
                },
                {
                    data: 'cant_minima'
                },
                {
                    data: 'fecha_creacion'
                },
                {
                    data: 'actions',
                    orderable: false,

                    render: function(data, type, row, meta) {
                        var output = "<button class='badge rounded-pill bg-info'" +
                            "onclick='editarProducto(" + row.id + ")'>" +
                            "<i class='fas fa-edit'></i>" +
                            "</button>" +
                            "<button class='badge rounded-pill bg-danger'" +
                            " onclick='eliminarProducto(" + row.id + ")'>" +
                            "<i class='fas fa-trash-alt'></i>" +
                            "</button>";

                        return output;
                    }
                }
            ]
        });
    }

    function guardarProducto() {
        var nombreProducto = $('#nombreProducto').val();
        var medida = $('#medida').val();
        var cantMinima = $('#cantMinima').val();
        var descripcion = $('#descripcion').val();


        if (nombreProducto == '' || medida == '' || cantMinima == '' || descripcion == '') {
            swal({
                title: "Exito!",
                text: 'Por favor, llene todos los campos requeridos.',
                icon: "info",
            });
        } else {
            $.ajax({
                url: "{{ route('guardarProducto') }}",
                type: 'post',
                data: {
                    nombreProducto: nombreProducto,
                    medida: medida,
                    cantMinima: cantMinima,
                    descripcion: descripcion,
                    _token: "{{ csrf_token() }}"
                }
            }).done(function(res) {
                if (res == 'success') {
                    swal({
                        title: "Exito!",
                        text: "Producto guardado!",
                        icon: "success",
                    });
                    $('#guardarProductoModal').modal('hide');
                    $('#tablaProductos').DataTable().ajax.reload();
                    $('#nombreProducto').val('');
                    $('#medida').val('');
                    $('#cantMinima').val('');
                    $('#descripcion').val('');
                }
            })
        }
    }

    function editarProducto(idProducto) {
        var eidtarProductoModal = $('#eidtarProductoModal');
        var editarProducto_content = $('#editarProducto_content');

        $.ajax({
            url: "{{ route('editarProducto') }}",
            type: 'post',
            data: {
                idProducto: idProducto,
                _token: "{{ csrf_token() }}"
            }
        }).done(function(data) {
            eidtarProductoModal.modal('toggle');
            editarProducto_content.html(data);
        })
    }

    function eliminarProducto(idProducto) 
    {
        swal({
            title: "Esta seguro?",
            text: "Al eliminar, se perdera la información actual!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('eliminarProducto') }}",
                    type: 'post',
                    data: {
                        idProducto: idProducto,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function(res) {
                    if (res == 'success') {
                        swal({
                            title: "Exito!",
                            text: "Producto eliminado!",
                            icon: "success",
                        });
                        $('#tablaProductos').DataTable().ajax.reload();
                    }
                });
            } else {
                swal("Cancelado!");
            }
        });
    }

    function filtrar()
    {
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();

        if (desde == '' || hasta == '') 
        {
            swal({
                title: "Ino!",
                text: "Por favor seleccione fechas antes de filtrar",
                icon: "info",
            });
        } else {
            tableProductos(desde, hasta);
        }
    }

    function limpiarFiltros()
    {
        $('#desde').val('');
        $('#hasta').val('');
        var desde = '';
        var hasta = '';

        tableProductos(desde, hasta);
    }

</script>
