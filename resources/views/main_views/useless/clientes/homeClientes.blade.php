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
                                    <h6 class="m-0 font-weight-bold text-primary">Administrador de Clientes</h6>

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 mb-auto">
                                            <button class="btn btn-primary fa-pull-right" data-toggle="modal"
                                                data-target="#guardarClienteModal">Agregar Cliente</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tablaClientes" style="width: 100%"
                                                class="table table-condensed table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Empresa</th>
                                                        <th>Rerpesentante</th>
                                                        <th>Correo</th>
                                                        <th>Telefono</th>
                                                        <th>Zona</th>
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
    @include('main_views.clientes.guardarCliente')

    <div class="modal fade" id="editarClienteModal" tabindex="-1" role="dialog"
        aria-labelledby="editarClienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="editarCliente_content">
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

<script>
    $(document).ready(function() {
        tablaClientes();
    });

    function tablaClientes() {
        $('#tablaClientes').DataTable({
            autoWidth: true,
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            scrollCollapse: false,
            scrollX: true,

            ajax: {
                url: "{{ route('clientesTabla') }}",
                type: 'get'
            },
            aoColumns: [{
                    data: 'nombre_comercial'
                },
                {
                    data: 'intermediario'
                },
                {
                    data: 'correo'
                },
                {
                    data: 'telefono'
                },
                {
                    data: 'zona'
                },
                {
                    data: 'actions',
                    orderable: false,

                    render: function(data, type, row, meta) {
                        var output = "<button class='badge rounded-pill bg-info'" +
                            "onclick='editarCliente(" + row.id + ")'>" +
                            "<i class='fas fa-edit'></i>" +
                            "</button>" +
                            "<button class='badge rounded-pill bg-danger'" +
                            " onclick='eliminarCliente(" + row.id + ")'>" +
                            "<i class='fas fa-trash-alt'></i>" +
                            "</button>";

                        return output;
                    }
                }
            ]
        });
    }

    function municipio(deptoid) {
        $.ajax({
            url: "{{ route('selectMunicipio') }}",
            type: 'post',
            data: {
                deptoid: deptoid,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#municipio_div').html(data);
            }
        })
    }

    $('#save_client').submit(function() {
        $.ajax({
            url: $('#save_client').attr('action'),
            type: 'POST',
            data: $('#save_client').serialize(),
            success: function(data) {
                if (data == 'exito') {
                    $('#save_client')[0].reset();
                    $('#guardarClienteModal').modal('hide');
                    $('#tablaClientes').DataTable().ajax.reload();
                    swal({
                        title: "Exito!",
                        text: "Cliente guardado!",
                        icon: "success",
                    });
                } else {
                    swal({
                        title: "Error!",
                        text: "Algo salió mal, intenta de nuevo.",
                        icon: "error",
                    });
                }
            }
        });
        return false;
    });

    function editarCliente(idCliente) 
    {
        var editarClienteModal = $('#editarClienteModal');
        var editarCliente_content = $('#editarCliente_content');

        $.ajax({
            url: "{{ route('editarCliente') }}",
            type: 'post',
            data: {
                idCliente: idCliente,
                _token: "{{ csrf_token() }}"
            }
        }).done(function(data) {
            editarClienteModal.modal('toggle');
            editarCliente_content.html(data);
        })
    }

    function eliminarCliente(idCliente) {
        swal({
            title: "Esta seguro?",
            text: "Al eliminar, se perdera la información actual!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('eliminarCliente') }}",
                    type: 'post',
                    data: {
                        idCliente: idCliente,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function(res) {
                    if (res == 'success') {
                        swal({
                            title: "Exito!",
                            text: "Cliente eliminado!",
                            icon: "success",
                        });
                        $('#tablaClientes').DataTable().ajax.reload();
                    }
                });
            } else {
                swal("Cancelado!");
            }
        });
    }
</script>
