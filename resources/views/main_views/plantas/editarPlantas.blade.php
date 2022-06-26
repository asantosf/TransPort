<div class="modal-header">
    <h5 class="modal-title" id="editarEmpleadoModalLabel">Editar Planta</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ route('actualizarPlanta') }}" method="post" name="updatePlantaForm" id="updatePlantaForm">
        @csrf
        <input type="hidden" id="idPlanta" name="idPlanta" value="{{ $data->id }}">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <label for="">Nombre de Planta</label>
                    <input required type="text" id="nombre" name="nombre" class="form-control" value="{{ $data->nombre }}">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-5">
                    <label for="">Telefono</label>
                    <input required type="text" id="telefono" name="telefono" class="form-control" value="{{ $data->telefono }}">
                </div>
                <div class="col-md-7">
                    <label for="">Correo</label>
                    <input required type="email" id="correo" name="correo" class="form-control" value="{{ $data->correo }}">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label for="">Empresa a la que pertenece</label>
                    <select name="negocio" id="negocio" class="form-control" onchange="ubicaciones_edit(this.value)">
                        <option value="">Select Option...</option>
                        @foreach ($rolNegocio as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $data->tipo_planta ? 'Selected' : '' }}>{{ $item->negocio }}</option>               
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <hr>
            <div class="row">
                <div class="col-md-10">
                    <label for="">Direccion</label>
                    <input required type="text" id="direccion" name="direccion" class="form-control" value="{{ $data->direccion }}">
                </div>
                <div class="col-md-2">
                    <label for="">Zona</label>
                    <input required type="number" id="zona" name="zona" class="form-control" value="{{ $data->zona }}">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div id="ubicacion_edit_div">
                        <label for="">Ubicacion</label>
                        <select required name="ubicacion_id" id="ubicacion_id" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach ($ubicaciones as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $data->ubicaciones_planta_id ? 'Selected' : '' }}>{{ $item->ubicacion }}</option>                
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar <i class="fas fa-save"></i>
            </button>
        </div>
    </form>
</div>

<script>

    $('#updatePlantaForm').submit(function() {
        $.ajax({
            url: $('#updatePlantaForm').attr('action'),
            type: 'POST',
            data: $('#updatePlantaForm').serialize(),
            success: function(data) {
                if (data == 'exito') {
                    $('#eidtarPlantaModal').modal('hide');
                    $('#tablaPlantas').DataTable().ajax.reload();
                    swal({
                        title: "Exito!",
                        text: "Planta actualizada!",
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

    function ubicaciones_edit(rol_negocio) 
    {
        $.ajax({
            url: "{{ route('ubicacionesPlanta') }}",
            type: 'post',
            data: {
                rol_negocio: rol_negocio,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#ubicacion_edit_div').html(data);
            }
        })
    }

</script>