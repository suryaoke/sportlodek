<div class="mb-3">
    <label class="form-label text-capitalize">{{ $label ? $label : Str::replace('_', ' ', $name) }}</label>
    <input type="file" class="form-control" name="{{ $name }}" accept=".jpg,.jpeg,.png">
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
