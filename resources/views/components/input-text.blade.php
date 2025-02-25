<div class="mb-3">
    <label class="form-label text-capitalize">{{ $label ? $label : str_replace('_', ' ', $name) }} <span
            class="form-label-description" id="{{ $name }}CharCount">0/200</span></label>

    <textarea id="{{ $name }}TextArea" rows="4" class="form-control" name="{{ $name }}"
        placeholder="{{ $placeholder }}" maxlength="200">{{ $value }}</textarea>

    <x-input-error :messages="$errors->get($name)" class="mt-2" />
    @isset($hint)
        {{ $hint }}
    @endisset
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('{{ $name }}TextArea');
        const charCount = document.getElementById('{{ $name }}CharCount');
        const maxChars = 200;

        textarea.addEventListener('input', function() {
            const currentLength = textarea.value.length;
            charCount.textContent = `${currentLength}/${maxChars}`;
        });
    });
</script>
