<div class="modal-header">
    <h5 class="modal-title" id="guardarProductoModalLabel">Editar Producto</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <form action="{{ route('actualizarEmpleado') }}" method="post" id="update_empleado">
        @csrf
        <input type="hidden" id="id" name="id" value="{{ $empleado->id }}">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <label for="">Primer Nombre</label>
                    <input required type="text" id="primer_nombre" name="primer_nombre" class="form-control" value="{{ $empleado->primer_nombre }}">
                </div>
                <div class="col-md-4">
                    <label for="">Segundo Nombre</label>
                    <input type="text" id="segundo_nombre" name="segundo_nombre" class="form-control" value="{{ $empleado->segundo_nombre }}">
                </div>
                <div class="col-md-4">
                    <label for="">Tercer Nombre</label>
                    <input type="text" id="tercer_nombre" name="tercer_nombre" class="form-control" value="{{ $empleado->tercer_nombre }}">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <label for="">Primer Apellido</label>
                    <input required type="text" id="primer_apellido" name="primer_apellido" class="form-control" value="{{ $empleado->primer_apellido }}">
                </div>
                <div class="col-md-4">
                    <label for="">Segundo Apellido</label>
                    <input type="text" id="segundo_apellido" name="segundo_apellido" class="form-control" value="{{ $empleado->segundo_apellido }}">
                </div>
                <div class="col-md-4">
                    <label for="">Apellido de Casada</label>
                    <input type="text" id="apellido_casada" name="apellido_casada" class="form-control" value="{{ $empleado->apellido_casada }}">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <label for="">DPI</label>
                    <input required type="number" id="dpi" name="dpi" class="form-control"
                        placeholder="ej.: 2753856940101" value="{{ $empleado->no_identificacion }}">
                </div>
                <div class="col-md-4">
                    <label for="">NIT</label>
                    <input required type="number" id="nit" name="nit" class="form-control"
                        placeholder="ej.: 22222222" value="{{ $empleado->no_tributario }}">
                </div>
                <div class="col-md-4">
                    <label for="">Telefono</label>
                    <input required type="number" id="telefono" name="telefono" class="form-control"
                        placeholder="ej.: 55555555" value="{{ $empleado->telefono }}">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-7">
                    <label for="">Puesto</label>
                    <input required type="text" id="puesto" name="puesto" class="form-control" value="{{ $employment->puesto }}">
                </div>
                <div class="col-md-5">
                    <label for="">Fecha de Ingreso</label>
                    <input required type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control" value="{{ $empleado->fecha_ingreso }}">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label for="">Empresa a la que pertenece></label>
                    <select name="negocio" id="negocio" class="form-control">
                        <option value="">Select Option...</option>
                        @foreach ($negocios as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $employment->planta_id ? 'Selected' : '' }}>
                                {{ $item->nombre }}</option>               
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <hr>
            <div class="row">
                <div class="col-md-10">
                    <label for="">Direccion</label>
                    <input required type="text" id="direccion" name="direccion" class="form-control"
                        placeholder="calle, no. casa, colonia, etc." value="{{ $empleado->direccion }}">
                </div>
                <div class="col-md-2">
                    <label for="">Zona</label>
                    <input required type="number" id="zona" name="zona" class="form-control" placeholder="ej. 1 - 12" value="{{ $empleado->zona }}">
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
                            <option value="{{ $item->id }}" {{ $item->id == $empleado->departamento_id ? 'Selected' : '' }}>
                                {{ $item->departamento }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <div id="municipio_div_">
                        <label for="">Municipio</label>
                        <select required name="municipio_id" id="municipio_id" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach ($munEmpleado as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $empleado->municipio_id ? 'Selected' : '' }}>
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

    $('#update_empleado').submit(function() {
        $.ajax({
            url: $('#update_empleado').attr('action'),
            type: 'POST',
            data: $('#update_empleado').serialize(),
            success: function(data) {
                if (data == 'exito') {
                    $('#editarEmpleadoModal').modal('hide');
                    $('#tablaEmpleados').DataTable().ajax.reload();
                    swal({
                        title: "Exito!",
                        text: "Empleado actualizado!",
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
