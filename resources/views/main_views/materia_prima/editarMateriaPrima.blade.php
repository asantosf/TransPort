<div class="modal-header">
    <h5 class="modal-title" id="guardarMateriaPrimaModalLabel">Editar Materia Prima</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <div class="col-md-12">
        <div class="row">
            <label for="">Nombre de Materia Prima</label>
            <input type="text" id="nombreMateriaPrima_" name="nombreMateriaPrima_" class="form-control" value="{{ $MateriaPrima->nombre }}">
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <span><label for="">Medida</label></span>
                <input type="text" id="medida_" name="medida_" class="form-control" value="{{ $MateriaPrima->medida }}">
            </div>
            <div class="col-md-6">
                <span><label for="">Cantidad Minima</label></span>
                <input type="number" id="cantMinima_" name="cantMinima_" class="form-control" value="{{ $MateriaPrima->cantidad_minima }}">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <label for="">Planta</label>
                <select name="planta_update" id="planta_update" class="form-control">
                    <option value="">Seleccionar Opcion...</option>
                    @foreach ($planta as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $MateriaPrima->planta_id ? 'Selected' : '' }}>{{ $item->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <br>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="actualizarMateriaPrima({{ $MateriaPrima->id }})">
            Actualizar <i class="fas fa-highlighter"></i>
        </button>
    </div>

</div>

<script>

    function actualizarMateriaPrima(idMateriaPrima)
    {
        var nombreMateriaPrima = $('#nombreMateriaPrima_').val();
        var medida = $('#medida_').val();
        var cantMinima = $('#cantMinima_').val();
        var planta = $('#planta_update').val();

        swal({
            title: "Esta seguro?",
            text: "La informacion anterior sera sustituida!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('actualizarMateriaPrima') }}",
                    type: 'post',
                    data: 
                    {
                        nombreMateriaPrima: nombreMateriaPrima,
                        medida: medida,
                        cantMinima: cantMinima,
                        planta: planta,
                        idMateriaPrima: idMateriaPrima,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function (res){
                    if (res == 'success')
                    {
                        swal({
                            title: "Exito!",
                            text: "Materia Prima actualizado!",
                            icon: "success",
                        });
                        $('#eidtarMateriaPrimaModal').modal('hide');
                        $('#tablaMateriaPrimas').DataTable().ajax.reload();
                        $('#nombreMateriaPrima').val('');
                        $('#medida').val('');
                        $('#cantMinima').val('');
                        $('#descripcion').val('');
                    }
                })
            } else {
                swal("Cancelado!");
            }
        });
    }

</script>