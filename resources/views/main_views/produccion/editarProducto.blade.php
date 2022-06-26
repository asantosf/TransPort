<div class="modal-header">
    <h5 class="modal-title" id="editarProductoModalLabel">Editar Producto</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <label for="">Nombre Producto</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $producto->nombre }}">
            </div>
            <div class="col-md-6">
                <span><label for="">Precio</label></span>
                <input type="text" id="precio" name="precio" class="form-control" value="{{ $producto->valor_unitario }}">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <span><label for="">Cantidad Minima</label></span>
                <textarea name="descripcion" id="descripcion" cols="30" rows="3" class="form-control">
                    {{ $producto->descripcion }}
                </textarea>
            </div>
        </div>
    </div>
    <br>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="actualizarMateriaPrima({{ $producto->id }})">
            Actualizar <i class="fas fa-highlighter"></i>
        </button>
    </div>

</div>

<script>

    function actualizarMateriaPrima(idProducto)
    {
        var nombre = $('#nombre').val();
        var precio = $('#precio').val();
        var descripcion = $('#descripcion').val();

        swal({
            title: "Esta seguro?",
            text: "La informacion anterior sera sustituida!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('updateProducto') }}",
                    type: 'post',
                    data: 
                    {
                        idProducto: idProducto,
                        nombre: nombre,
                        precio: precio,
                        descripcion: descripcion,
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
                        $('#eidtarProductoModal').modal('hide');
                        $('#tablaProduccion').DataTable().ajax.reload();
                        $('#nombre').val('');
                        $('#precio').val('');
                        $('#descripcion').val('');
                    }
                })
            } else {
                swal("Cancelado!");
            }
        });
    }

</script>