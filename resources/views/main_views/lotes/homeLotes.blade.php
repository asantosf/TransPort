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
                                    <h6 class="m-0 font-weight-bold text-primary">Administrador de Lotes</h6>

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 mb-auto">
                                            <button class="btn btn-primary fa-pull-right" data-toggle="modal"
                                                data-target="#guardarLoteModal">Agregar Lote</button>
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
                                            <table id="tablaLote" style="width: 100%"
                                                class="table table-condensed table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th># Lote</th>
                                                        <th>Descripcion</th>
                                                        <th>Cantidad</th>
                                                        <th>Fecha de Produccion</th>
                                                        <th>Fecha de Vencimiento</th>
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
    @include('main_views.lotes.guardarLote')

    <div class="modal fade" id="eidtarLoteModal" tabindex="-1" role="dialog"
        aria-labelledby="guardarLoteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="editarLote_content">
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

    $(document).ready(function (){
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();

        tableLotes(desde, hasta);
        $('#MyDate2').val(4);
        AddMes();

        var ahora = new Date();
        var año = new Date().getFullYear();
        var comienzo = new Date(ahora.getFullYear(), 0, 0);
        var dif = ahora - comienzo - 1000 * 60 * 60 * 24;
        var unDia = 1000 * 60 * 60 * 24;
        var dia = Math.ceil(dif / unDia);

        $('#noLote').val(dia+""+año);
    });

    var obj=document.getElementById('MyDate');
    var obj2 = document.getElementById('MyDate2');
    var obj3 = document.getElementById('MyDate3');
    obj.value = setFormato(new Date());

    function AddMes(){
        var fecha = new Date(obj.value);
        fecha.setMonth( fecha.getMonth() + +(obj2.value));
        obj3.value = setFormato(fecha);
    }

    function setFormato(fecha){
        var day = ("0" + fecha.getDate()).slice(-2);
        var month = ("0" + (fecha.getMonth() + 1)).slice(-2);
        var date = fecha.getFullYear()+"-"+(month)+"-"+(day);
        return date;
    }

    function tableLotes(desde, hasta)
    {
        $('#tablaLote').DataTable({
            autoWidth: true,
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            scrollCollapse: false, 
            scrollX: true,

            ajax: {
                url: "{{ route('loteTabla') }}",
                type: 'post',
                data:
                {
                    desde: desde,
                    hasta: hasta,
                    _token: "{{ csrf_token() }}"
                }
            }, 
            aoColumns:
            [
                {data: 'id'},
                {data: 'descripcion'},
                {data: 'cantidad'},
                {data: 'fecha_produccion'},
                {data: 'fecha_vencimiento'},
                {
                    data: 'actions',
                    orderable: false,

                    render: function(data, type, row, meta) {
                        var output = "<button class='badge rounded-pill bg-info'" +
                                        "onclick='editarLote("+row.id+")'>" +
                                        "<i class='fas fa-edit'></i>" +
                                    "</button>" +
                                    "<button class='badge rounded-pill bg-danger'" +
                                       " onclick='eliminarLote("+row.id+")'>" +
                                       "<i class='fas fa-trash-alt'></i>" +
                                    "</button>";
                        
                        return output;
                    }
                }
            ]
        });
    }

    function guardarLot()
    {
        var noLote = $('#noLote').val();
        var MyDate = $('#MyDate').val();
        var MyDate3 = $('#MyDate3').val();
        var cant = $('#cant').val();
        var calidad = $('#calidad').val();
        var descripcion = $('#descripcion').val();

        if (cant == '')
        {
            swal({
                title: "Atención!",
                text: "Debe especificar una cantidad antes de guardar.",
                icon: "info",
            });
        } else {
            $.ajax({
                url: "{{ route('guardarLote') }}",
                type: 'post',
                data: 
                {
                    noLote: noLote,
                    MyDate: MyDate,
                    MyDate3: MyDate3,
                    cant: cant,
                    calidad: calidad,
                    descripcion: descripcion,
                    _token: "{{ csrf_token() }}"
                }
            }).done(function (res){
                if (res == 'success')
                {
                    swal({
                        title: "Exito!",
                        text: "Lote creado con éxito!",
                        icon: "success",
                    });
                    $('#tablaLote').DataTable().ajax.reload();
                    $('#guardarLoteModal').modal('hide');
                    $('#cant').val('');
                    $('#calidad').val('');
                    $('#descripcion').val('');
                } else if (res == 'existe') {
                    swal({
                        title: "Error!",
                        text: "Numero de lote ya existe, puede modificar o eliminar el existe y crear uno nuevo.",
                        icon: "error",
                    });
                }
            });
        }
    }

    function editarLote(idlote)
    {
        var eidtarLoteModal = $('#eidtarLoteModal');
        var editarLote_content = $('#editarLote_content');

        $.ajax({
            url: "{{ route('editarLote') }}",
            type: 'post',
            data: 
            {
                idlote: idlote,
                _token: "{{ csrf_token() }}"
            }
        }).done(function (data){
            eidtarLoteModal.modal('toggle');
            editarLote_content.html(data);
        })
    }

    function eliminarLote(idLote)
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
                    url: "{{ route('eliminarLote') }}",
                    type: 'post',
                    data: 
                    {
                        idLote: idLote,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function (res){
                    if (res == 'success')
                    {
                        swal({
                            title: "Exito!",
                            text: "Lote eliminado!",
                            icon: "success",
                        });
                        $('#tablaLote').DataTable().ajax.reload();
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
            tableLotes(desde, hasta);
        }
    }

    function limpiarFiltros()
    {
        $('#desde').val('');
        $('#hasta').val('');
        var desde = '';
        var hasta = '';

        tableLotes(desde, hasta);
    }

</script>