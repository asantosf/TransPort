<div class="modal fade" id="guardarMateriaPrimaModal" tabindex="-1" role="dialog"
        aria-labelledby="guardarMateriaPrimaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="guardarMateriaPrimaModalLabel">Agregar Materia Prima</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('guardarMateriaPrima') }}" method="post" name="guardarMateriaPrimaForm"
                        id="guardarMateriaPrimaForm">
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <label for="">Nombre de Materia Prima</label>
                                <input type="text" id="nombreMateriaPrima" name="nombreMateriaPrima" class="form-control"
                                    required placeholder="Ej.: Arena, Tierra, etc...">
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <span><label for="">Medida</label></span>
                                    <input type="text" id="medida" name="medida" class="form-control" required
                                        placeholder="Ej.: Libras, Saco, Onzas, etc.">
                                </div>
                                <div class="col-md-6">
                                    <span><label for="">Cantidad Minima</label></span>
                                    <input type="number" id="cantMinima" name="cantMinima" class="form-control"
                                        min="0" required placeholder="Ej.: 10, 20, 30">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Planta</label>
                                    <select name="planta_save" id="planta_save" class="form-control">
                                        <option value="">Seleccionar Opcion...</option>
                                        @foreach ($planta as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" onclick="guardarMateriaPrima()">Guardar <i
                                    class="fas fa-save"></i>
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>