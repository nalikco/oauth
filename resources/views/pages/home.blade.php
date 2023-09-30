@extends('layout.layout')

@section('content')
    <x-ui.page.container>
        <section class="max-w-lg mx-auto">
            <h1 class="text-4xl text-center font-medium mt-10">
                @lang('brand.home.header')
            </h1>
            <p class="text-center mt-5">
                @lang('brand.home.description') <span
                    class="font-medium">@lang('brand.nalikby') @lang('brand.account')</span>.
            </p>
            <section class="mt-7 flex flex-col items-center">
                <x-ui.links.default-link :url="route('sign-up')">
                    @lang('brand.home.action_button')
                </x-ui.links.default-link>
            </section>
        </section>
    </x-ui.page.container>
@endsection
