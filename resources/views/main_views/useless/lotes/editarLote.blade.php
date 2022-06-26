<div class="modal-header">
    <h5 class="modal-title" id="guardarLoteModalLabel">Agregar Lote</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <div class="col-md-12">
        <div class="row">
            <label for="">Numero de Lote</label>
            <input type="text" id="noLote" name="noLote" class="form-control" disabled value="{{ $lote->id }}">
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <span><label for="">Fecha de Producción</label></span>
                <input id="MyDate_"  disabled value="{{ $lote->fecha_produccion }}">
            </div>
            <div class="col-md-6">
                <span><label for="">Fecha de Vencimiento</label></span>
                <input id="MyDate3_"  disabled value="{{ $lote->fecha_vencimiento }}">
            </div>
        </div>
        <br>
        <div class="row">
            <label for="">Cantidad</label>
            <input type="number" id="cant_" name="cant" class="form-control" value="{{ $lote->cantidad }}">
        </div>
        <br>
        <div class="row">
            <label for="">Comentarios Control de Calidad</label>
            <textarea name="calidad" id="calidad_" cols="30" rows="3" class="form-control">{{ $lote->control_calidad }}</textarea>
        </div>
        <br>
        <div class="row">
            <label for="">Descripción</label>
            <textarea name="descripcion" id="descripcion_" cols="30" rows="3" class="form-control">{{ $lote->descripcion }}</textarea>
        </div>
    </div>
    <br>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="actualizarLote({{ $lote->id }})">Actualizar <i class="fas fa-highlighter"></i>
        </button>
    </div>
</div>

<script>

    function actualizarLote(idlote)
    {
        var cant_ = $('#cant_').val();
        var calidad_ = $('#calidad_').val();
        var descripcion_ = $('#descripcion_').val();

        swal({
            title: "Esta seguro?",
            text: "La informacion anterior sera sustituida con la nueva.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('actualizarLote') }}",
                    type: 'post',
                    data: 
                    {
                        idlote: idlote,
                        cant_: cant_,
                        calidad_: calidad_,
                        descripcion_: descripcion_,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function (res){
                    if (res == 'success')
                    {
                        swal({
                            title: "Exito!",
                            text: "Lote actualizado!",
                            icon: "success",
                        });
                        $('#eidtarLoteModal').modal('hide');
                        $('#tablaLote').DataTable().ajax.reload();
                    }
                })
            } else {
                swal("Cancelado!");
            }
        });
    }

</script>