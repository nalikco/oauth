<div class="grid grid-cols-12 h-12 items-center">
    <div {{ $attributes->merge(['class' => 'h-full flex justify-start items-center' . ($backUrl ? ' col-span-4' : ' col-span-7')]) }}>
        @if ($backUrl)
            <a href="{{ $backUrl }}"
               class="bg-gray-200/50 hover:bg-gray-200 transition py-3 px-3 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                     viewBox="0 0 50.000000 50.000000" preserveAspectRatio="xMidYMid meet">

                    <g transform="translate(0.000000,50.000000) scale(0.100000,-0.100000)" fill="#14b8a6"
                       stroke="none">
                        <path
                            d="M235 360 l-110 -110 112 -112 c90 -89 115 -110 125 -100 10 10 -8 33 -87 112 l-100 100 99 99 c86 86 108 121 78 121 -4 0 -57 -50 -117 -110z"/>
                    </g>
                </svg>
            </a>
        @else
            <h1 class="text-3xl col-span-4 bg-gray-200/50 flex items-center px-3 h-full rounded-xl font-medium text-teal-500">{{ $title }}</h1>
        @endif
    </div>
    <div {{ $attributes->merge(['class' => 'h-full flex justify-center items-center' . ($backUrl ? ' col-span-4' : '')]) }}>
        @if ($backUrl)
            <h1 class="text-3xl col-span-4 bg-gray-200/50 flex items-center px-3 h-full rounded-xl font-medium text-teal-500">{{ $title }}</h1>
        @endif
    </div>
    <div class="col-span-4 h-full flex justify-end items-center">
        @if ($actionUrl && $actionLabel)
            <x-ui.links.default-link :url="$actionUrl" size="sm">
                {{ $actionLabel }}
            </x-ui.links.default-link>
        @endif
    </div>
</div>
