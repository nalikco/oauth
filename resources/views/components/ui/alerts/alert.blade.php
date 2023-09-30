<div {{ $attributes->merge(
    ['class' => 'py-2 rounded-2xl px-5 ' . ($type == 'success' ? 'bg-teal-400/50 text-teal-800' : '') . ($type == 'warning' ? 'bg-orange-400/50 text-orange-800' : '') . ($type == 'error' ? 'bg-rose-400/50 text-rose-800' : '')],
    ) }}>
    {{ $slot }}
</div>
