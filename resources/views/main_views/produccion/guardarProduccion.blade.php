
<div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <label for="">Nombre de Producto</label>
            <input type="text" id="producto" name="producto" placeholder="Buscar..." class="form-control">
            <input type="hidden" id="idproducto" name="idproducto">
        </div>
        <div class="col-md-4">
            <span><label for="">Precio</label></span>
            <input type="text" id="precio" name="precio" class="form-control" required
                placeholder="Ej.: Q.">
        </div>
        <div class="col-md-4">
            <span><label for="">Cantidad Ingreso</label></span>
            <input type="number" id="cantidad" name="cantidad" class="form-control"
                min="0" required placeholder="Ej.: 10, 20, 30">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="">Descripcion</label>
            <textarea name="descripcion" id="descripcion" cols="30" rows="2" class="form-control"></textarea>
        </div>
        <div class="col-md-6"  id="planta_producto">
            <label for="">Planta</label>
            <select name="planta_produccion" id="planta_produccion" class="form-control">
                <option value="">Seleccionar Opcion...</option>
                @foreach ($planta as $item)
                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <hr>
    <div class="row col-md-12" id="detalleOrden_div">
        <H5>Materia Prima</H5>
    </div>
    <br>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <label for="">Materia Prima</label>
                <select name="materia" id="materia" class="form-control" onchange="materia_disponible(this.value)">
                    <option value="">Seleccionar Opcion...</option>
                    @foreach ($materiaPrima as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6" id="materia_disponible">
                <label for="">Disponible</label>
                <input type="number" class="form-control" disabled>
            </div>
            <div class="col-md-6">
                <label for="">Cantidad Utilizada</label>
                <input type="number" id="cantidad_utilizada" name="cantidad_utilizada" class="form-control">
            </div>
        </div>
        <br>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h5>Detalle de Uso de Materia Prima</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="badge badge-warning" onclick="limpiarTablaProduccion()">Limpiar</button>
                <button class="badge badge-danger" onclick="removerLastProduccion()">Remover Ultimo</button>
                <button class="badge badge-success pull-right" onclick="agregarMateria()">Agregar</button>
            </div>
        </div>
        <br>
        <div class="row">
            <table class="display table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody id="tbody_produccion">
    
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="back()"">Close</button>
        <button type="button" class="btn btn-success" onclick="guardarProduccion()">
            Guardar <i class="fas fa-save"></i>
        </button>
    </div>
</div>

<script>

    var detallMateria = [];

    $("#producto").autocomplete({
        minLength: 1
    }, {
        source: function(request, response) {
            // Fetch data
            $.ajax({
                url: "{{ route('buscarProducto') }}",
                type: 'post',
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        producto: request.term
                    },
                    success: function(data) {

                        response(data);
                    }
                });
        },
        select: function(event, ui) {
            
            $('#producto').val(ui.item.label);
            $('#idproducto').val(ui.item.value);
            $('#precio').val(ui.item.precio);
            $('#descripcion').val(ui.item.descripcion);

            if (ui.item.value != null)
            {
                selectPlantaProducto(ui.item.value);
            }

            return false;
        }
    });

    function selectPlantaProducto(idProducto)
    {
        $.ajax({
            url: "{{ route('selectPlantaProducto') }}",
            type: 'post',
            data: {
                idProducto: idProducto,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#planta_producto').html(data);
            }
        });
    }

    function guardarProduccion() 
    {
        var idproducto = $('#idproducto').val();
        var producto = $('#producto').val();
        var precio = $('#precio').val();
        var cantidad = $('#cantidad').val();
        var descripcion = $('#descripcion').val();
        var planta_produccion = $('#planta_produccion').val();

        if (precio == '' || detallMateria.length == 0 )
        {
            swal({
                title: "Alto!",
                text: 'Por favor, llene todos los campos requeridos.',
                icon: "info",
            });
        } else {
            $.ajax({
                url: "{{ route('guardarProduccion') }}",
                type: 'post',
                data: {
                    idproducto: idproducto,
                    producto: producto,
                    precio: precio,
                    descripcion: descripcion,
                    detallMateria: detallMateria,
                    cantidad: cantidad,
                    planta_produccion: planta_produccion,
                    _token: "{{ csrf_token() }}"
                }
            }).done(function(res) {
                if (res == 'success') {
                    swal({
                        title: "Exito!",
                        text: "Materia Prima guardado!",
                        icon: "success",
                    });
                    window.location.href = "{{ route('homeProduccion') }}";
                }
            })
        }
    }

    function materia_disponible(idMateria)
    {
        $.ajax({
            url: "{{ route('materiaPrimaDisponible') }}",
            type: 'post',
            data: {
                idMateria: idMateria,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#materia_disponible').html(data);
            }
        });
    }

    function agregarMateria() 
    {
        var idproducto = $('#idproducto').val();
        var producto = $('#producto').val();
        var precio = $('#precio').val();
        var cantidad = $('#cantidad').val();
        var descripcion = $('#descripcion').val();
        var planta_produccion = $('#planta_produccion').val();
        var disponible_materia = $('#disponible_materia').val();
        var idmateria = $('#materia').val();
        var cantidad_utilizada = $('#cantidad_utilizada').val();
        var materiaName = $('#materia  option:selected').text();
        
        if (parseInt(disponible_materia) < parseInt(cantidad))
        {
            swal({
                title: "Atención!",
                text: "Cantidad supera la disponibilidad, por favor revise.\n Cantidad disponible: "+disponible_materia,
                icon: "warning",
            });
        } else {    
            detallMateria.push({
                idproducto: idproducto,
                idmateria: idmateria,
                materiaName: materiaName,
                cantidad_utilizada: cantidad_utilizada
            });

            $('#disponible_materia').val('');
            $('#materia').val('');
            $('#cantidad_utilizada').val('');

            cargarTablaProduccion();

            return detallMateria
        }
    }

    function cargarTablaProduccion() 
    {
        $('#tbody_produccion').html("");
        for (var i = 0; i < detallMateria.length; i++) 
        {
            var tr =
                `<tr>
                <td>` + detallMateria[i].materiaName + `</td>
                <td>` + detallMateria[i].cantidad_utilizada + `</td>
            </tr>`;
            $('#tbody_produccion').append(tr);
        }
    }

    function limpiarTablaProduccion() 
    {
        detallMateria = [];

        cargarTablaProduccion();
    }

    function removerLastProduccion() 
    {
        detallMateria.pop();

        cargarTablaProduccion();
    }

    function back()
    {
        swal({
            title: "Esta seguro?",
            text: "Al regresar se perdera la información ingresada!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "{{ route('homeProduccion') }}";
            } else {
                swal("Cancelado!");
            }
        });
    }
    
</script>