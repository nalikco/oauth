<x-ui.page.block class="flex flex-col md:flex-row justify-between items-center">
    <section class="flex items-center gap-5">
        @if($imageUrl)
            <a href="{{ $url }}">
                <img src="{{ url('/storage/' . $imageUrl) }}"
                     class="w-16 h-16 rounded-full"
                     title="{{ $name }}"
                     alt="{{ $name }}">
            </a>
        @endif
        <div>
            <p class="text-gray-500 text-sm leading-3">{{ $brand }}</p>
            <a href="{{ $url }}"
               class="text-2xl text-teal-500">{{ $name }}</a>
            <p class="text-gray-700">
                {{ $description }}
            </p>
        </div>
    </section>
    <section class="flex flex-col mt-3 md:mt-0 w-full md:w-max items-end gap-2">
        <form action="{{ $deleteUrl }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-rose-500 font-medium text-center md:text-left w-full md:w-max text-white py-2 px-3 rounded-lg hover:bg-rose-600 transition">
                @lang('dashboard.disable_action')
            </button>
        </form>
        <p class="text-right text-sm text-gray-500">
            {{ $createdAtLabel }} {{ $createdAt->translatedFormat('d M Y') }}
        </p>
    </section>
</x-ui.page.block>
