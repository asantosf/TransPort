<div class="row">
    <div class="col-md-2">
        <label for="">Disponible</label>
        <input disabled type="text" id="disponible" name="disponible" class="form-control" value="{{ $disponible->disponible }}">
    </div>
    <div class="col-md-3">
        <label for="">Fecha de Vencimiento</label>
        <input disabled type="text" id="vencimiento" name="vencimiento" class="form-control" value="{{ $disponible->vencimiento }}">
    </div>
    <div class="col-md-3">
        <label for="">Cantidad</label>
        <input type="number" id="cantidad" name="cantidad" class="form-control">
    </div>
    <div class="col-md-3">
        <label for="">Precio</label>
        <input type="number" id="precio" name="precio" class="form-control">
    </div>
    <div class="col-md-1">
        <button class="btn btn-success" onclick="agregar()" style="margin-top: 32px">
            <i class="fas fa-cart-plus"></i>
        </button>
    </div>    
</div>