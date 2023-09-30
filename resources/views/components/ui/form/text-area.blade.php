<div class="flex flex-col">
    <label for="{{ $name }}" class="font-medium">{{ $title }}</label>
    <textarea id="{{ $name }}"
              name="{{ $name }}"
              rows="{{ $rows }}"
              @if($required) required @endif
              @if($autoFocus) autofocus @endif
              class="mt-1 bg-gray-100 rounded-lg px-3 py-1.5 focus:outline-teal-400"
              placeholder="{{ $placeholder }}">{{ $value }}</textarea>
    @error($name)
    <div class="font-medium text-sm text-rose-500 mt-0.5">
        {{ $message }}
    </div>
    @enderror
</div>
