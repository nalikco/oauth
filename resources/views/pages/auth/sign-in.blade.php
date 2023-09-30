@extends('layout.layout')

@section('content')
    <x-ui.auth.layout :title="__('auth.sign_in.title')">
        <form method="POST"
              class="space-y-2"
              action="{{ route('sign-in.handle') }}">
            <div class="-mt-2">
                @csrf
            </div>
            <x-ui.form.input
                name="email"
                type="email"
                :title="__('auth.sign_up.fields.email')"
                :value="old('email', '')"
                required
            />
            <div class="relative">
                <a href="{{ route('password.send-link') }}"
                   class="absolute right-0 top-0.5 text-gray-500 hover:text-teal-500 transition text-sm">
                    @lang('auth.sign_in.forgot_password')
                </a>
                <x-ui.form.input
                    name="password"
                    type="password"
                    :title="__('auth.sign_up.fields.password')"
                    required
                />
            </div>
            <x-ui.buttons.button full-width type="submit">
                @lang('auth.sign_in_action')
            </x-ui.buttons.button>
        </form>
    </x-ui.auth.layout>
@endsection
