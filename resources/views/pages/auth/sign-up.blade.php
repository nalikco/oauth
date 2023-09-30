@extends('layout.layout')

@section('content')
    <x-ui.auth.layout :title="__('auth.sign_up.title')">
        <form method="POST"
              class="space-y-2"
              action="{{ route('sign-up.handle') }}">
            <div class="-mt-2">
                @csrf
            </div>
            <x-ui.form.input
                name="name"
                :title="__('auth.sign_up.fields.name')"
                :value="old('name', '')"
                required
                auto-focus
            />
            <x-ui.form.input
                name="email"
                type="email"
                :title="__('auth.sign_up.fields.email')"
                :value="old('email', '')"
                required
            />
            <x-ui.form.input
                name="password"
                type="password"
                :title="__('auth.sign_up.fields.password')"
                required
            />
            <x-ui.form.input
                name="password_confirmation"
                type="password"
                :title="__('auth.sign_up.fields.password_confirmation')"
                required
            />
            <x-ui.buttons.button full-width type="submit">
                @lang('brand.home.action_button')
            </x-ui.buttons.button>
        </form>
    </x-ui.auth.layout>
@endsection
