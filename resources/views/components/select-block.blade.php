  <select class="form-select" class="form-control" name="{{ $name }}">
    <option value="" disabled selected>{{ $placeholder }}</option>
    @foreach ($options as $key => $label)
        <option value="{{ $key }}" @selected($key == $value)>{{ $label }}</option>
    @endforeach
</select>


@isset($hint)
    <small class="text-muted">{{ $hint }}</small>
@endisset

