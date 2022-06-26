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
                                    <h6 class="m-0 font-weight-bold text-primary">Administrador de Plantas</h6>

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 mb-auto">
                                            <button class="btn btn-primary fa-pull-right" data-toggle="modal"
                                                data-target="#guardarPlantaModal">Agregar Planta</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="">Empresa a la que pertenece</label>
                                            <select name="negocio" id="negocio" class="form-control">
                                                <option value="">Select Option...</option>
                                                @foreach ($rolNegocio as $item)
                                                    <option value="{{ $item->id }}">{{ $item->negocio }}</option>               
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-info" onclick="filtrarPlanta()" style="margin-top: 32px">Filtrar</button>
                                        </div> 
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tablaPlantas" style="width: 100%" class="table table-condensed table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre de Planta</th>
                                                        <th>Telefono</th>
                                                        <th>Correo</th>
                                                        <th>Ubicacion</th>
                                                        <th>Zona</th>
                                                        <th>Rol de Negocio</th>
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
    @include('main_views.plantas.guardarPlanta')

    <div class="modal fade" id="eidtarPlantaModal" tabindex="-1" role="dialog"
        aria-labelledby="editarPlantaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="editarPlanta_content">
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
        var negocio = $('#negocio').val();
        tablaPlantas(negocio);
    });

    function tablaPlantas(negocio) 
    {
        $('#tablaPlantas').DataTable({
            autoWidth: true,
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            scrollCollapse: false,
            scrollX: true,
            ajax: 
            {
                url: "{{ route('plantasTable') }}",
                type: 'post',
                data:
                {
                    negocio: negocio,
                    _token: "{{ csrf_token() }}"
                }
            },
            aoColumns: 
            [
                {data: 'nombre'},
                {data: 'telefono'},
                {data: 'correo'},
                {data: 'ubicacion'},
                {data: 'zona'},
                {data: 'rol_negocio'},
                {
                    data: 'actions',
                    orderable: false,
                   
                    render: function(data, type, row, meta) {
                        var output = "<button class='badge rounded-pill bg-info'" +
                            "onclick='editarPlanta(" + row.id + ")' title='Editar Planta'>" +
                            "<i class='fas fa-edit'></i>" +
                            "</button>" +
                            "<button class='badge rounded-pill bg-danger'" +
                            " onclick='eliminarPlanta(" + row.id + ")' title='Eliminar Planta'>" +
                            "<i class='fas fa-trash-alt'></i>" +
                            "</button>";

                        return output;
                    }
                }
            ]
        });
    }

    function ubicaciones(rol_negocio) 
    {
        $.ajax({
            url: "{{ route('ubicacionesPlanta') }}",
            type: 'post',
            data: {
                rol_negocio: rol_negocio,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#ubicacion_div').html(data);
            }
        })
    }

    $('#guardarPlantaForm').submit(function() {
        $.ajax({
            url: $('#guardarPlantaForm').attr('action'),
            type: 'POST',
            data: $('#guardarPlantaForm').serialize(),
            success: function(data) {
                if (data == 'exito') {
                    $('#guardarPlantaForm')[0].reset();
                    $('#guardarPlantaModal').modal('hide');
                    $('#tablaPlantas').DataTable().ajax.reload();
                    swal({
                        title: "Exito!",
                        text: "Planta guardada!",
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

    function editarPlanta(idPlanta)
    {
        var eidtarPlantaModal = $('#eidtarPlantaModal');
        var editarPlanta_content = $('#editarPlanta_content');

        $.ajax({
            url: "{{ route('editarPlanta') }}",
            type: 'post',
            data: {
                idPlanta: idPlanta,
                _token: "{{ csrf_token() }}"
            }
        }).done(function(data) {
            eidtarPlantaModal.modal('toggle');
            editarPlanta_content.html(data);
        })
    }

    function eliminarPlanta(idPlanta)
    {
        swal({
            title: "Esta seguro?",
            text: "Al eliminar, se perdera la información permanentemente!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('eliminarPlanta') }}",
                    type: 'post',
                    data: {
                        idPlanta: idPlanta,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function(res) {
                    if (res == 'exito') {
                        swal({
                            title: "Exito!",
                            text: "Planta eliminada!",
                            icon: "success",
                        });
                        $('#tablaPlantas').DataTable().ajax.reload();
                    }
                });
            } else {
                swal("Cancelado!");
            }
        });
    }

    function filtrarPlanta()
    {
        var negocio = $('#negocio').val();
        console.log(negocio);
        tablaPlantas(negocio);
    }
    
</script>