<div class="modal fade" id="guardarProductoModal" tabindex="-1" role="dialog"
        aria-labelledby="guardarProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="guardarProductoModalLabel">Agregar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('guardarProducto') }}" method="post" name="guardarProductoForm"
                        id="guardarProductoForm">
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <label for="">Nombre de Producto</label>
                                <input type="text" id="nombreProducto" name="nombreProducto" class="form-control"
                                    required placeholder="Ej.: Harina">
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <span><label for="">Medida</label></span>
                                    <input type="text" id="medida" name="medida" class="form-control" required
                                        placeholder="Ej.: Libras, Onzas, etc.">
                                </div>
                                <div class="col-md-6">
                                    <span><label for="">Cantidad Minima</label></span>
                                    <input type="number" id="cantMinima" name="cantMinima" class="form-control"
                                        min="0" required placeholder="Ej.: 10, 20, 30">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label for="">Descripcion del Producto</label>
                                <textarea name="descripcion" id="descripcion" cols="30" rows="3" required
                                    class="form-control"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" onclick="guardarProducto()">Guardar <i
                                    class="fas fa-save"></i>
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>