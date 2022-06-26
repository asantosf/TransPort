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
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Control de Produccion</h6>

                                </div>
                                <div class="card-body"  id="div_sustituir">
                                    <div class="row">
                                        <div class="col-lg-12 mb-auto">
                                            <button class="btn btn-primary fa-pull-right" onclick="guardarProduccion()">Agregar Producto</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Planta</label>
                                                <select name="planta" id="planta" class="form-control">
                                                    <option value="">Seleccionar Opcion...</option>
                                                    @foreach ($planta as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-info" onclick="filtrarProduccion()" style="margin-top: 32px">Filtrar</button>
                                            </div> 
                                        </div>
                                        <br><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="tablaProduccion" style="width: 100%" class="table table-condensed table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Producto</th>
                                                            <th>Precio</th>
                                                            <th>Disponible</th>
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

    <div class="modal fade" id="eidtarProductoModal" tabindex="-1" role="dialog" aria-labelledby="editarProductoModalLabel" aria-hidden="true">
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
    
    
</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {
        var planta = $('#planta').val();

        tableProduccion(planta);

    });
    
    function tableProduccion(planta) 
    {
        $('#tablaProduccion').DataTable({
            autoWidth: true,
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            scrollCollapse: false,
            scrollX: true,

            ajax: {
                url: "{{ route('produccionTabla') }}",
                type: 'post',
                data:
                {
                    planta: planta,
                    _token: "{{ csrf_token() }}"
                }
            },
            aoColumns: 
            [
                {data: 'nombre'},
                {data: 'valor_unitario'},
                {data: 'stock'},
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

    function editarProducto(idProducto) 
    {
        var eidtarProductoModal = $('#eidtarProductoModal');
        var editarProducto_content = $('#editarProducto_content');

        $.ajax({
            url: "{{ route('showProduccion') }}",
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
                    url: "{{ route('destroyProduccion') }}",
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
                        $('#tablaProduccion').DataTable().ajax.reload();
                    }
                });
            } else {
                swal("Cancelado!");
            }
        });
    }

    function filtrarProduccion()
    {
        var planta = $('#planta').val();

        if (planta == '') 
        {
            swal({
                title: "Ino!",
                text: "Por favor seleccione fechas antes de filtrar",
                icon: "info",
            });
        } else {
            tablaProduccion(planta);
        }
    }

    function guardarProduccion()
    {
        $.ajax({
            url: "{{ route('cargarGuardarProducto') }}",
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#div_sustituir').html(data);
            }
        });
    }
    
</script>
