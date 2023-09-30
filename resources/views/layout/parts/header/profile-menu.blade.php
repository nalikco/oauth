@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp

<section class="flex text-sm gap-3">
    @if($user != null)
        <x-ui.header.nav.link route-name="dashboard">
            Dashboard
        </x-ui.header.nav.link>
        @if($user->hasPermissionTo('create client'))
            <x-ui.header.nav.link route-name="clients.index">
                Clients
            </x-ui.header.nav.link>
        @endif
        <x-ui.header.nav.link route-name="sign-out">
            @lang('auth.sign_out_action')
        </x-ui.header.nav.link>
    @else
        <x-ui.header.nav.link route-name="sign-in">
            @lang('auth.sign_in_action')
        </x-ui.header.nav.link>
        <x-ui.header.nav.link route-name="sign-up">
            @lang('auth.sign_up_action')
        </x-ui.header.nav.link>
    @endif
</section>
