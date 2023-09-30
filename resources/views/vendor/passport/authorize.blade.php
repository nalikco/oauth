@php
    $title = $client->name . ' ' . __('auth.authorize_app.title');
@endphp

@extends('layout.layout')

@section('content')
    <x-ui.page.container>
        <h1 class="text-3xl">@lang('auth.authorize_app.title')</h1>
        <section class="mt-5 space-y-5">
            <x-ui.page.block>
                <!-- Introduction -->
                <p><strong>{{ $client->name }}</strong> @lang('auth.authorize_app.description')</p>

                <!-- Scope List -->
                @if (count($scopes) > 0)
                    <div class="scopes">
                        <p><strong>@lang('auth.authorize_app.scopes_description')</strong></p>

                        <ul>
                            @foreach ($scopes as $scope)
                                <li>{{ $scope->description }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex justify-between mt-5">
                    <!-- Authorize Button -->
                    <form method="post" action="{{ route('passport.authorizations.approve') }}">
                        @csrf

                        <input type="hidden" name="state" value="{{ $request->state }}">
                        <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                        <input type="hidden" name="auth_token" value="{{ $authToken }}">
                        <x-ui.buttons.button type="submit">
                            @lang('auth.authorize_app.authorize')
                        </x-ui.buttons.button>
                    </form>

                    <!-- Cancel Button -->
                    <form method="post" action="{{ route('passport.authorizations.deny') }}">
                        @csrf
                        @method('DELETE')

                        <input type="hidden" name="state" value="{{ $request->state }}">
                        <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                        <input type="hidden" name="auth_token" value="{{ $authToken }}">
                        <x-ui.buttons.button type="submit" color="white">
                            @lang('auth.authorize_app.cancel')
                        </x-ui.buttons.button>
                    </form>
                </div>
            </x-ui.page.block>
        </section>
    </x-ui.page.container>
@endsection
