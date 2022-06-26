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
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#home">Crear Usuario</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#menu1">Listado de Usuarios</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane container active" id="home">
                                            <br>
                                            <form action="{{ route('guardarUsuario') }}" method="POST" id="guardar_usuario">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" id='buscar' name="buscar" placeholder="Buscar..."
                                                            class="form-control">
                                                        <input type="hidden" id="name" name="name">
                                                        <input type="hidden" id="idempleado" name="idempleado">
                                                        <input type="hidden" id="usuario" name="usuario">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="">Puesto</label>
                                                        <input type="text" id="puesto" name="puesto" class="form-control"
                                                            disabled required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Fecha de ingreso</label>
                                                        <input type="text" id="fecha_ingreso" name="fecha_ingreso"
                                                            class="form-control" disabled required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Usuario</label>
                                                        <input type="text" id="usuario_" name="usuario_"
                                                            class="form-control" disabled required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Rol</label>
                                                        <select name="rol" id="rol" class="form-control" required>
                                                            <option value="">Seleccionar...</option>
                                                            @foreach ($rol as $item)
                                                                <option value="{{ $item->id }}">{{ $item->rol }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <button type="submit" class="btn btn-success btn-block">
                                                            <i class="fas fa-user-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                        </div>
                                        <div class="tab-pane container fade" id="menu1">
                                            <br>
                                            <table id="tablaUsuarios" style="width: 100%"
                                                class="table table-condensed table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Empid</th>
                                                        <th>Nombre Empleado</th>
                                                        <th>Usuario</th>
                                                        <th>Rol</th>
                                                        <th>Creado Por</th>
                                                        <th>Fecha de Creacion</th>
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
    
    
</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {
        $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
            $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
        } );

        $('#tablaUsuarios').DataTable({
            autoWidth: true,
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            scrollCollapse: false,
            scrollX: true,

            ajax: {
                url: "{{ route('usuariosTabla') }}",
                type: 'get'
            },
            aoColumns: [{
                    data: 'empid'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'rol'
                },
                {
                    data: 'creado_por'
                },
                {
                    data: 'fecha_creacion'
                },
                {
                    data: 'actions',
                    orderable: false,

                    render: function(data, type, row, meta) {
                        var output = "<button class='badge rounded-pill bg-primary'" +
                            "onclick='resetearPassword(" + row.id + ")' title='Resetear Passwrod'>" +
                            "<i class='fas fa-user-shield'></i>" +
                            "</button>" +
                            "<button class='badge rounded-pill bg-danger'" +
                            " onclick='eliminarUsuario(" + row.id + ")' title='Eliminar Usuario'>" +
                            "<i class='fas fa-user-minus'></i>" +
                            "</button>";

                        return output;
                    }
                }
            ]
        });

        $("#buscar").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "{{ route('buscarEmpleado') }}",
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
                $('#name').val(ui.item.name);
                $('#buscar').val(ui.item.label);
                $('#puesto').val(ui.item.puesto);
                $('#fecha_ingreso').val(ui.item.fecha_ingreso);
                $('#usuario').val(ui.item.usuario);
                $('#usuario_').val(ui.item.usuario); 
                $('#idempleado').val(ui.item.value);

                return false;
            }
        });
    });

    $('#guardar_usuario').submit(function() {
        var empleado = $('#name').val();
        
        $.ajax({
            url: $('#guardar_usuario').attr('action'),
            type: 'POST',
            data: $('#guardar_usuario').serialize(),
            success: function(data) {
                if (data == 'activo')
                {
                    $('#guardar_usuario')[0].reset();
                    swal({
                        title: "Error!",
                        text: empleado+" ya cuenta con un usuario activo.",
                        icon: "error",
                    });
                }
                else if (data == 'exito') {
                    $('#guardar_usuario')[0].reset();
                    $('#tablaUsuarios').DataTable().ajax.reload();
                    swal({
                        title: "Exito!",
                        text: "Usuario Creado!",
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

    function resetearPassword(iduser, user)
    {
        swal({
            title: "Esta seguro?",
            text: "La clave se reseteara a 'secret'.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willReset) => {
            if (willReset) {
                $.ajax({
                    url: "{{ route('resetPassword') }}",
                    type: 'post',
                    data: 
                    {
                        iduser: iduser,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function (res){
                    if (res == 'success')
                    {
                        swal({
                            title: "Exito!",
                            text: "Password Reseteado\nEl usuario debe cambiar la clave al entrar nuevamente.",
                            icon: "success",
                        });
                    }
                });
            } else {
                swal("Cancelado!");
            }
        });
    }

    function eliminarUsuario(iduser)
    {
        swal({
            title: "Esta seguro?",
            text: "Esta a punto de eliminar un usuario, este no podra ser recuperado.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('eliminarUsuario') }}",
                    type: 'post',
                    data: 
                    {
                        iduser: iduser,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function (res){
                    if (res == 'success')
                    {
                        swal({
                            title: "Exito!",
                            text: "Usuario eliminado!",
                            icon: "success",
                        });
                        $('#tablaUsuarios').DataTable().ajax.reload();
                    }
                });
            } else {
                swal("Cancelado!");
            }
        });
    }

</script>
