<label for="">Ubicacion</label>
<select required name="ubicacion_id" id="ubicacion_id" class="form-control">
    <option value="">Seleccionar...</option>
    @foreach ($ubicaciones as $item)
        <option value="{{ $item->id }}">{{ $item->ubicacion }}</option>                
    @endforeach
</select>