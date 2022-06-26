<label for="">Planta</label>
<select name="materia" id="materia" class="form-control">
    <option value="">Seleccionar Opcion...</option>
    @foreach ($planta as $item)
        <option value="{{ $item->id }}" {{ $item->id == $productoInfo->planta_produccion_id ? 'Selected' : '' }}>{{ $item->nombre }}</option>
    @endforeach
</select>