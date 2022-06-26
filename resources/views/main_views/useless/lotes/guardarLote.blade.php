<div class="modal fade" id="guardarLoteModal" tabindex="-1" role="dialog"
        aria-labelledby="guardarLoteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
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
                            <input type="text" id="noLote" name="noLote" class="form-control" disabled>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <span><label for="">Fecha de Producción</label></span>
                                <input id="MyDate" value="" disabled>
                            </div>
                            <div class="col-md-6">
                                <span><label for="">Fecha de Vencimiento</label></span>
                                <input id="MyDate3" value="" disabled>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="">Cantidad</label>
                            <input type="number" id="cant" name="cant" class="form-control">
                        </div>
                        <br>
                        <div class="row">
                            <label for="">Comentarios Control de Calidad</label>
                            <textarea name="calidad" id="calidad" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        <br>
                        <div class="row">
                            <label for="">Descripción</label>
                            <textarea name="descripcion" id="descripcion" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="guardarLot()">Guardar <i class="fas fa-save"></i>
                        </button>
                    </div>

                    <input id="MyDate2" value="" placeholder="Sumar meses" type="hidden">
                </div>

            </div>
        </div>
    </div>