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
                                            <button class="btn btn-primary fa-pull-right" onclick="guardarUbicacionModal_()">Agregar Ubicacion</button>
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
                                            <button class="btn btn-info" onclick="filtrarUbicaciones()" style="margin-top: 32px">Filtrar</button>
                                        </div> 
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tablaUbicaciones" style="width: 100%"
                                                class="table table-condensed table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Negocio</th>
                                                        <th>Departamento</th>
                                                        <th>Municipio</th>
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
    @include('main_views.plantas.agregarUbicacion')

    <div class="modal fade" id="eidtarPlantaModal" tabindex="-1" role="dialog"
        aria-labelledby="guardarPlantaModalLabel" aria-hidden="true">
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

<script>

    $(document).ready(function() {
        var negocio = $('#negocio').val();
        tablaUbicaciones(negocio);
    });

    function tablaUbicaciones(negocio) {
        $('#tablaUbicaciones').DataTable({
            autoWidth: true,
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            scrollCollapse: false,
            scrollX: true,

            ajax: {
                url: "{{ route('tablaUbicaciones') }}",
                type: 'post',
                data:
                {
                    negocio, negocio,
                    _token: "{{ csrf_token() }}"
                }
            },
            aoColumns: [{
                    data: 'negocio'
                },
                {
                    data: 'departamento'
                },
                {
                    data: 'municipio'
                },
                {
                    data: 'actions',
                    orderable: false,
                   
                    render: function(data, type, row, meta) {
                        var output = 
                            "<button class='badge rounded-pill bg-danger'" +
                            " onclick='eliminarUbicacion(" + row.id + ")' title='Eliminar Ubicacion'>" +
                            "<i class='fas fa-trash-alt'></i>" +
                            "</button>";

                        return output;
                    }
                }
            ]
        });
    }

    function filtrarUbicaciones()
    {
        var negocio = $('#negocio').val();
        tablaUbicaciones(negocio);
    }

    function eliminarUbicacion(idUbicacion)
    {
        swal({
            title: "Esta seguro?",
            text: "Se borrara la informacion permanentemente!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('deleteUbicacion') }}",
                    type: 'post',
                    data: {
                        idUbicacion: idUbicacion,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function(res) {
                    if (res == 'exito') {
                        swal({
                            title: "Exito!",
                            text: "Ubicacion eliminada!",
                            icon: "success",
                        });
                        $('#tablaUbicaciones').DataTable().ajax.reload();
                    }
                });
            } else {
                swal("Cancelado!");
            }
        });
    }

    function guardarUbicacionModal_() 
    {
        var guardarUbicacionModal = $('#guardarUbicacionModal');
        guardarUbicacionModal.modal('toggle');
    }

    function closeguardarUbicacionModal()
    {
        $('#guardarUbicacionModal').modal('hide');
    }

</script>