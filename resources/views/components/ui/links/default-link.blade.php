<a href="{{ $url }}"
    {{ $attributes->merge(['class' => 'bg-teal-500 hover:bg-teal-600 border-b-2 border-teal-600 hover:border-teal-700 transition font-medium text-white rounded-xl' . ($size == 'sm' ? ' px-4 py-2' : '') . ($size == 'default' ? ' px-5 py-3' : '')]) }}>
    {{ $slot }}
</a>
