<div class="modal-header">
    <h5 class="modal-title" id="guardarProductoModalLabel">Editar Producto</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <div class="col-md-12">
        <div class="row">
            <label for="">Nombre de Producto</label>
            <input type="text" id="nombreProducto_" name="nombreProducto_" class="form-control"
                value="{{ $producto->nombre_producto }}">
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <span><label for="">Medida</label></span>
                <input type="text" id="medida_" name="medida_" class="form-control" value="{{ $producto->medida }}">
            </div>
            <div class="col-md-6">
                <span><label for="">Cantidad Minima</label></span>
                <input type="number" id="cantMinima_" name="cantMinima_" class="form-control"
                    value="{{ $producto->cant_minima }}">
            </div>
        </div>
        <br>
        <div class="row">
            <label for="">Descripcion del Producto</label>
            <textarea name="descripcion_" id="descripcion_" cols="30" rows="3" required
                class="form-control">{{ $producto->descripcion }}</textarea>
        </div>
    </div>
    <br>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="actualizarProducto({{ $producto->id }})">Actualizar <i class="fas fa-highlighter"></i>
        </button>
    </div>

</div>

<script>

    function actualizarProducto(idproducto)
    {
        var nombreProducto = $('#nombreProducto_').val();
        var medida = $('#medida_').val();
        var cantMinima = $('#cantMinima_').val();
        var descripcion = $('#descripcion_').val();

        swal({
            title: "Esta seguro?",
            text: "La informacion anterior sera sustituida por la nueva!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('actualizarProducto') }}",
                    type: 'post',
                    data: 
                    {
                        nombreProducto: nombreProducto,
                        medida: medida,
                        cantMinima: cantMinima,
                        descripcion: descripcion,
                        idproducto: idproducto,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function (res){
                    if (res == 'success')
                    {
                        swal({
                            title: "Exito!",
                            text: "Producto actualizado!",
                            icon: "success",
                        });
                        $('#eidtarProductoModal').modal('hide');
                        $('#tablaProductos').DataTable().ajax.reload();
                        $('#nombreProducto').val('');
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