<label for="">Municipio</label>
<select required name="municipio_id" id="municipio_id" class="form-control">
    <option value="">Seleccionar...</option>
    @foreach ($municipios as $item)
        <option value="{{ $item->id }}">{{ $item->municipio }}</option>                
    @endforeach
</select>