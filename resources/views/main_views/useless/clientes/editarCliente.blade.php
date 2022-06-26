<div class="modal-header">
    <h5 class="modal-title" id="guardarProductoModalLabel">Editar Producto</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <form action="{{ route('actualizarCliente') }}" method="post" id="update_client">
        @csrf
        <input type="hidden" id="id" name="id" value="{{ $cliente->id }}">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <label for="">Nombre Comercial</label>
                    <input required type="text" id="nombre_comercial" name="nombre_comercial"
                        class="form-control" value="{{ $cliente->nombre_comercial }}">
                </div>
                <div class="col-md-4">
                    <span><label for="">Nombre Patente</label></span>
                    <input required type="text" id="nombre_patente" name="nombre_patente"
                        class="form-control" value="{{ $cliente->nombre_patente }}">
                </div>
                <div class="col-md-4">
                    <span><label for="">Representa Legal</label></span>
                    <input required type="text" id="intermediario" name="intermediario"
                        class="form-control" value="{{ $cliente->intermediario }}">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <label for="">NIT</label>
                    <input required type="number" id="nit" name="nit" class="form-control"
                        placeholder="ej.: 22222222" value="{{ $cliente->nit }}">
                </div>
                <div class="col-md-4">
                    <label for="">Telefono</label>
                    <input required type="number" id="telefono" name="telefono" class="form-control"
                        placeholder="ej.: 55555555" value="{{ $cliente->telefono }}">
                </div>
                <div class="col-md-4">
                    <label for="">Correo</label>
                    <input required type="email" id="correo" name="correo" class="form-control"
                        placeholder="ejemplo@correo.com" value="{{ $cliente->correo }}">
                </div>
            </div>
            <br>
            <hr>
            <div class="row">
                <div class="col-md-10">
                    <label for="">Direccion</label>
                    <input required type="text" id="direccion" name="direccion" class="form-control"
                        placeholder="calle, no. casa, colonia, etc." value="{{ $cliente->direccion }}">
                </div>
                <div class="col-md-2">
                    <label for="">Zona</label>
                    <input required type="number" id="zona" name="zona" class="form-control"
                        placeholder="ej. 1, 12" value="{{ $cliente->zona }}">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="">Departamento</label>
                    <select required name="departamento_id" id="departamento_id" class="form-control"
                        onchange="municipio(this.value)">
                        <option value="">Seleccionar...</option>
                        @foreach ($deptos as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $cliente->departamento_id ? 'Selected' : '' }}>
                                {{ $item->departamento }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <div id="municipio_div_">
                        <label for="">Municipio</label>
                        <select required name="municipio_id" id="municipio_id" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach ($munClinete as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $cliente->municipio_id ? 'Selected' : '' }}>
                                    {{ $item->municipio }}</option>                      
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

    function municipio(deptoid) {
        $.ajax({
            url: "{{ route('selectMunicipio') }}",
            type: 'post',
            data: {
                deptoid: deptoid,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#municipio_div_').html(data);
            }
        })
    }

    $('#update_client').submit(function() {
        $.ajax({
            url: $('#update_client').attr('action'),
            type: 'POST',
            data: $('#update_client').serialize(),
            success: function(data) {
                if (data == 'exito') {
                    $('#editarClienteModal').modal('hide');
                    $('#tablaClientes').DataTable().ajax.reload();
                    swal({
                        title: "Exito!",
                        text: "Cliente actualizado!",
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

</script>