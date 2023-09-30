<!DOCTYPE html>
<html @include('layout.parts.lang')>
<head>
    @include('layout.parts.head')
</head>
<body>
@include('layout.parts.header')
<div class="mt-5">
    @if(session()->has('success') || session()->has('warning') || session()->has('error'))
        <div class="mt-5 mb-5 mx-auto w-full max-w-md space-y-2">
            @if(session()->has('success'))
                <x-ui.alerts.alert type="success">
                    {{ session()->get('success') }}
                </x-ui.alerts.alert>
            @endif
            @if(session()->has('warning'))
                <x-ui.alerts.alert type="warning">
                    {{ session()->get('warning') }}
                </x-ui.alerts.alert>
            @endif
            @if(session()->has('error'))
                <x-ui.alerts.alert type="error">
                    {{ session()->get('error') }}
                </x-ui.alerts.alert>
            @endif
        </div>
    @endif
    <div class="mx-5 lg:mx-0">
        @yield('content')
    </div>
</div>
@include('layout.parts.footer')
</body>
</html>
