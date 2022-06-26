<label for="">Municipio</label>
<select required name="municipio_ubicaciones" id="municipio_ubicaciones" class="form-control">
    <option value="">Seleccionar...</option>
    @foreach ($municipios as $item)
        <option value="{{ $item->id }}">{{ $item->municipio }}</option>                
    @endforeach
</select>