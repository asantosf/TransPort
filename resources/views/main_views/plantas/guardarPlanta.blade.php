    <div class="modal fade" id="guardarPlantaModal" tabindex="-1" role="dialog"
        aria-labelledby="guardarPlantaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="guardarPlantaModalLabel">Agregar Planta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 mb-auto">
                            <button class="btn btn-primary fa-pull-right" onclick="guardarUbicacionModal_()">Agregar Ubicacion</button>
                        </div>
                    </div>
                    <br>
                    <form action="{{ route('guardarPlanta') }}" method="post" name="guardarPlantaForm"
                        id="guardarPlantaForm">
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Nombre de Planta</label>
                                    <input required type="text" id="nombre" name="nombre" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="">Telefono</label>
                                    <input required type="text" id="telefono" name="telefono" class="form-control" placeholder="Ej.: 22222222">
                                </div>
                                <div class="col-md-7">
                                    <label for="">Correo</label>
                                    <input required type="email" id="correo" name="correo" class="form-control" placeholder="ejemplo@correo.com">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Empresa a la que pertenece></label>
                                    <select name="negocio" id="negocio" class="form-control" onchange="ubicaciones(this.value)">
                                        <option value="">Select Option...</option>
                                        @foreach ($rolNegocio as $item)
                                            <option value="{{ $item->id }}">{{ $item->negocio }}</option>               
                                        @endforeach
                                    </select>
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
                                <div class="col-md-12">
                                    <div id="ubicacion_div">
                                        <label for="">Ubicacion</label>
                                        <select required name="ubicacion_id" id="ubicacion_id" class="form-control">
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

                @include('main_views.plantas.agregarUbicacion')

            </div>
        </div>
    </div>

    <script>

        function guardarUbicacionModal_() 
        {
            var guardarUbicacionModal = $('#guardarUbicacionModal');
            guardarUbicacionModal.modal('toggle');
        }

        function closeguardarUbicacionModal()
        {
            $('#guardarUbicacionModal').modal('hide');
        }
        
    </script>