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
                                    <h6 class="m-0 font-weight-bold text-primary">Administrador de Materia Prima</h6>

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 mb-auto">
                                            <button class="btn btn-primary fa-pull-right" data-toggle="modal"
                                                data-target="#guardarMateriaPrimaModal">Agregar Materia Prima</button>
                                        </div>
                                    </div>
                                    <hr>
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
                                            <button class="btn btn-info" onclick="filtrar()" style="margin-top: 32px">Filtrar</button>
                                        </div> 
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tablaMateriaPrimas" style="width: 100%"
                                                class="table table-condensed table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre de Materia Prima</th>
                                                        <th>Medida</th>
                                                        <th>Cantidad Minima</th>
                                                        <th>Planta</th>
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
    @include('main_views.materia_prima.guardarMateriaPrima')

    <div class="modal fade" id="eidtarMateriaPrimaModal" tabindex="-1" role="dialog"
        aria-labelledby="guardarMateriaPrimaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="editarMateriaPrima_content">
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
        var planta = $('#planta').val();

        tableMateriaPrimas(planta);
    });
    
    function tableMateriaPrimas(planta) {
        $('#tablaMateriaPrimas').DataTable({
            autoWidth: true,
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            scrollCollapse: false,
            scrollX: true,

            ajax: {
                url: "{{ route('materiaPrimaTabla') }}",
                type: 'post',
                data:
                {
                    planta: planta,
                    _token: "{{ csrf_token() }}"
                }
            },
            aoColumns: 
            [
                {data: 'nombre_materia_prima'},
                {data: 'medida'},
                {data: 'cantidad_minima'},
                {data: 'planta'},
                {
                    data: 'actions',
                    orderable: false,

                    render: function(data, type, row, meta) {
                        var output = "<button class='badge rounded-pill bg-info'" +
                            "onclick='editarMateriaPrima(" + row.id + ")'>" +
                            "<i class='fas fa-edit'></i>" +
                            "</button>" +
                            "<button class='badge rounded-pill bg-danger'" +
                            " onclick='eliminarMateriaPrima(" + row.id + ")'>" +
                            "<i class='fas fa-trash-alt'></i>" +
                            "</button>";

                        return output;
                    }
                }
            ]
        });
    }

    function guardarMateriaPrima() {
        var nombreMateriaPrima = $('#nombreMateriaPrima').val();
        var medida = $('#medida').val();
        var cantMinima = $('#cantMinima').val();
        var planta_save = $('#planta_save').val();


        if (nombreMateriaPrima == '' || medida == '' || cantMinima == '' || planta_save == '') {
            swal({
                title: "Exito!",
                text: 'Por favor, llene todos los campos requeridos.',
                icon: "info",
            });
        } else {
            $.ajax({
                url: "{{ route('guardarMateriaPrima') }}",
                type: 'post',
                data: {
                    nombreMateriaPrima: nombreMateriaPrima,
                    medida: medida,
                    cantMinima: cantMinima,
                    planta_save: planta_save,
                    _token: "{{ csrf_token() }}"
                }
            }).done(function(res) {
                if (res == 'success') {
                    swal({
                        title: "Exito!",
                        text: "Materia Prima guardado!",
                        icon: "success",
                    });
                    $('#guardarMateriaPrimaModal').modal('hide');
                    $('#tablaMateriaPrimas').DataTable().ajax.reload();
                    $('#nombreMateriaPrima').val('');
                    $('#medida').val('');
                    $('#cantMinima').val('');
                    $('#descripcion').val('');
                }
            })
        }
    }

    function editarMateriaPrima(idMateriaPrima) {
        var eidtarMateriaPrimaModal = $('#eidtarMateriaPrimaModal');
        var editarMateriaPrima_content = $('#editarMateriaPrima_content');

        $.ajax({
            url: "{{ route('editarMateriaPrima') }}",
            type: 'post',
            data: {
                idMateriaPrima: idMateriaPrima,
                _token: "{{ csrf_token() }}"
            }
        }).done(function(data) {
            eidtarMateriaPrimaModal.modal('toggle');
            editarMateriaPrima_content.html(data);
        })
    }

    function eliminarMateriaPrima(idMateriaPrima) 
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
                    url: "{{ route('eliminarMateriaPrima') }}",
                    type: 'post',
                    data: {
                        idMateriaPrima: idMateriaPrima,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function(res) {
                    if (res == 'success') {
                        swal({
                            title: "Exito!",
                            text: "Materia Prima eliminado!",
                            icon: "success",
                        });
                        $('#tablaMateriaPrimas').DataTable().ajax.reload();
                    }
                });
            } else {
                swal("Cancelado!");
            }
        });
    }

    function filtrar()
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
            tableMateriaPrimas(planta);
        }
    }

    function limpiarFiltros()
    {
        $('#planta').val('');
        var planta = '';

        tableMateriaPrimas(planta);
    }

</script>
