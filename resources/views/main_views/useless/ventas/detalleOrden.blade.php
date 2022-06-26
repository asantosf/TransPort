<div class="modal-header">
    <h5 class="modal-title" id="detalleOrdenModalLabel">Detalle Orden</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <div class="col-md-12"> 
        @if ($devolucion->estado == 2)
            <div class="col-md-12"> 
                <div class="row">
                    <div class="alert alert-danger col-md-12" role="alert" >
                        <strong><h3>Orden Devuelta</h3></strong>
                        
                        <textarea name="" id="" cols="30" rows="5" class="form-control" disabled>{{ $devolucion->comentarios }}</textarea>
                    </div>
                </div>
            </div>
        @else
            
        @endif
        <br>
        <div class="row">
            <table id="tablaDetalle" class="table table-condensed table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No. de Lote</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                        <th>Vencimiento</th>
                    </tr>
                </thead>
                @php $contCant = 0; 
                     $total = 0; @endphp
                <tbody>
                    @foreach ($detalle as $item)
                        <tr>
                            <td>{{ $item->lote_id }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>{{ $item->precio_lote }}</td>
                            <td>{{ $item->subtotal }}</td>
                            <td>{{ $item->vencimiento }}</td>
                        </tr>                    
                        @php $contCant = $contCant + $item->cantidad;
                             $total = $total + $item->subtotal;  @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Cantidad de lotes</th>
                        <th>{{ $contCant }}</th>
                        <th>Total de Orden</th>
                        <th>{{ $total }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>

</div>

<script>

    

</script>
