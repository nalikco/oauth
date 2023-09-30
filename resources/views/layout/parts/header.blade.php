<header class="h-14 bg-white">
    <x-ui.page.container class="flex items-center justify-between h-14 px-5 lg:px-0">
        <section>
            <a href="{{ route('home') }}">
                @include('layout.parts.logo')
            </a>
        </section>
        @include('layout.parts.header.profile-menu')
    </x-ui.page.container>
</header>
