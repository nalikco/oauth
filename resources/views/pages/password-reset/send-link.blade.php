@extends('layout.layout')

@section('content')
    <x-ui.auth.layout :title="__('auth.password_reset.send_link.title')">
        <p class="pb-3 text-gray-500">
            @lang('auth.password_reset.send_link.description')
        </p>
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
                required
            />
            <x-ui.buttons.button full-width type="submit">
                @lang('auth.password_reset.send_link.send_link')
            </x-ui.buttons.button>
        </form>
    </x-ui.auth.layout>
@endsection
