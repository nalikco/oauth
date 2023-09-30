<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'border-b-2 transition font-medium px-3 py-2 rounded-xl '
    . ($fullWidth ? 'w-full ' : '')
    . ($color == 'white' ? 'text-gray-500 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 hover:border-gray-300 ' : '')
    . ($color == 'default' ? 'bg-teal-500 hover:bg-teal-600 border-teal-600 hover:border-teal-700 text-white ' : '')
    ]) }}
>
    {{ $slot }}
</button>
