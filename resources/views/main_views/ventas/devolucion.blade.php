<div class="modal-header">
    <h5 class="modal-title" id="detalleOrdenModalLabel">Devolucion de Orden</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <div class="col-md-12">
        <div class="row">
            <div class="alert alert-warning" role="alert">
                Esta a punto de devolver la orden de: <strong>{{ $query->nombre_comercial }}</strong><br>
                Por un total de: <strong>{{ $query->total }}</strong><br><br>
                Por favor, agregue la razón por la cual se esta procesando la devolución.
            </div>
        </div>
        <div class="row">
            <textarea name="comentarios" id="comentarios" cols="30" rows="3" class="form-control"
                placeholder="Razon de devolución..."></textarea>
        </div>
    </div>
    <br>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="devolucion({{ $query->idorden }})">Devolver</button>
    </div>

</div>

<script>
    function devolucion(idorden) 
    {
        var comentarios = $('#comentarios').val();

        if (comentarios == '')
        {
            swal({
                title: "Atención!",
                text: "Debe ingresar una razon de devolucion, antes de guardar.",
                icon: 'warning'
            });
        } else {
            swal({
                title: "Esta seguro?",
                text: "Al procesar la devolución, la orden no se podrá modificar más.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((devolucion) => {
                if (devolucion) {
                    $.ajax({
                        url: "{{ route('devolucionOrden') }}",
                        type: "post",
                        data: {
                            idorden: idorden,
                            comentarios: comentarios,
                            _token: "{{ csrf_token() }}"
                        }
                    }).done(function(data) {
                        swal({
                            title: "Exito",
                            text: "Orden devuelta correctamente, recurde descartar el producto devuelto.",
                            icon: 'success'
                        });
                        $('#tablaVentas').DataTable().ajax.reload();
                        $('#devolucionModal').modal('hide');
                    });
                } else {
                    swal("Cancelado!");
                }
            });
        }
    }
</script>
