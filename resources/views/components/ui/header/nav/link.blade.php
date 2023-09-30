<a {{ $attributes->merge([
    'class' => 'px-3 h-14 flex items-center font-medium border-b ' . ($active ? 'border-teal-400 text-teal-500' : 'hover:border-teal-400 hover:text-teal-500 transition'),
    'href' => route($routeName),
    ]) }}>
    {{ $slot }}
</a>
