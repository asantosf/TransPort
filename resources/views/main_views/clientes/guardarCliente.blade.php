<div class="modal fade" id="guardarClienteModal" tabindex="-1" role="dialog"
        aria-labelledby="guardarClienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="guardarClienteModalLabel">Agregar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('guardarCliente') }}" method="post" id="save_client">
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Nombre Comercial</label>
                                    <input required type="text" id="nombre_comercial" name="nombre_comercial"
                                        class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <span><label for="">Representa Legal</label></span>
                                    <input required type="text" id="intermediario" name="intermediario"
                                        class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">NIT</label>
                                    <input required type="number" id="nit" name="nit" class="form-control"
                                        placeholder="ej.: 22222222">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Telefono</label>
                                    <input required type="number" id="telefono" name="telefono" class="form-control"
                                        placeholder="ej.: 55555555">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Correo</label>
                                    <input required type="email" id="correo" name="correo" class="form-control"
                                        placeholder="ejemplo@correo.com">
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="row">
                                <div class="col-md-10">
                                    <label for="">Direccion</label>
                                    <input required type="text" id="direccion" name="direccion" class="form-control"
                                        placeholder="calle, no. casa, colonia, etc.">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Zona</label>
                                    <input required type="number" id="zona" name="zona" class="form-control"
                                        placeholder="ej. 1, 12">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Departamento</label>
                                    <select required name="departamento_id" id="departamento_id" class="form-control"
                                        onchange="municipio(this.value)">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($deptos as $item)
                                            <option value="{{ $item->id }}">{{ $item->departamento }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <div id="municipio_div">
                                        <label for="">Municipio</label>
                                        <select required name="municipio_id" id="municipio_id" class="form-control">
                                            <option value="">Seleccionar...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Guardar <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>