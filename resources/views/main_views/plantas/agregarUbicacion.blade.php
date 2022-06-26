<div class="modal fade" id="guardarUbicacionModal" tabindex="-1" role="dialog"
        aria-labelledby="guardarUbicacionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="guardarUbicacionModalLabel">Agregar Ubicacion</h5>
                    <button type="button" class="close" aria-label="Close" onclick="closeguardarUbicacionModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Empresa a la que pertenece</label>
                                <select name="negocio_ubicacion" id="negocio_ubicacion" class="form-control">
                                    <option value="">Select Option...</option>
                                    @foreach ($rolNegocio as $item)
                                        <option value="{{ $item->id }}">{{ $item->negocio }}</option>               
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Departamento</label>
                                <select required name="departamento_id" id="departamento_id" class="form-control"
                                    onchange="municipioUbicaciones(this.value)">
                                    <option value="">Seleccionar...</option>
                                    @foreach ($deptos as $item)
                                        <option value="{{ $item->id }}">{{ $item->departamento }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <div id="muni_div">
                                    <label for="">Municipio</label>
                                    <select required name="municipio" id="municipio" class="form-control">
                                        <option value="">Seleccionar...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeguardarUbicacionModal()">Close</button>
                        <button type="button" class="btn btn-success" onclick="guardarUbicacion()">Guardar <i class="fas fa-save"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        function municipioUbicaciones(deptoid) {
            $.ajax({
                url: "{{ route('selectMunicipioUbicacion') }}",
                type: 'post',
                data: {
                    deptoid: deptoid,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#muni_div').html(data);
                }
            })
        }

        function guardarUbicacion()
        {
            var negocio = $('#negocio_ubicacion').val();
            var departamento_id = $('#departamento_id').val();
            var municipio = $('#municipio_ubicaciones').val();
            var rol_negocio = $('#negocio').val();
            
            swal({
                title: "Esta seguro?",
                text: "Se creara la ubicacion para el negocio seleccionado.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((confirm)=>{
                if (confirm) {
                    $.ajax({
                        url: "{{ route('storeUbicacion') }}",
                        type: 'post',
                        data: {
                            negocio: negocio,
                            departamento_id: departamento_id,
                            municipio: municipio,
                            _token: "{{ csrf_token() }}"
                        }
                    }).done(function (res) {
                        if (res == 'exito') 
                        {
                            swal({
                                title: "Exito!",
                                text: "Ubicacion guardada!",
                                icon: "success",
                            });
                            $('#tablaUbicaciones').DataTable().ajax.reload();
                            closeguardarUbicacionModal();
                            ubicaciones(rol_negocio);
                        } else {
                            swal({
                                title: "Error!",
                                text: "Algo salio mal, intenta de nuevo.",
                                icon: "error",
                            });
                        }
                    })
                } else {
                    swal("Cancelado!");
                }
            });
        }

        /*$('#save_ubicacion').submit(function() {
            $.ajax({
                url: $('#save_ubicacion').attr('action'),
                type: 'POST',
                data: $('#save_empleado').serialize(),
                success: function(data) {
                    if (data == 'success') {
                        $('#save_ubicacion')[0].reset();
                        $('#guardarUbicacionModal').modal('hide');
                        swal({
                            title: "Exito!",
                            text: "Empleado guardado!",
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
        });*/

    </script>