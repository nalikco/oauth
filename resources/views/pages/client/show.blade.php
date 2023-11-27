@extends('layout.layout')
@section('content')
    <x-ui.page.container>
        <x-ui.page.content-header :back-url="route('clients.index')"
                                  :action-url="route('clients.edit', ['client' => $client->id])"
                                  :action-label="__('clients.edit_link')"
                                  :title="$client->name_translated[app()->getLocale()]"/>
        <section class="mt-5 space-y-5">
            <img src="{{ url('/storage/' . $client->image) }}"
                 class="w-32 h-32 rounded-full mx-auto"
                 title="{{ $client->name }}"
                 alt="{{ $client->name }}">
            <x-ui.page.block>
                <div class="grid md:grid-cols-6">
                    <div class="text-gray-500">@lang('clients.show.brand'):</div>
                    <div class="md:col-span-5 font-medium">{{ $client->brand[app()->getLocale()] }}</div>
                </div>
                <div class="grid md:grid-cols-6">
                    <div class="text-gray-500">@lang('clients.show.name'):</div>
                    <div class="md:col-span-5 font-medium">{{ $client->name_translated[app()->getLocale()] }}</div>
                </div>
                <div class="grid md:grid-cols-6">
                    <div class="text-gray-500">@lang('clients.show.description'):</div>
                    <div class="md:col-span-5 font-medium">{{ $client->description[app()->getLocale()] }}</div>
                </div>
                <div class="grid md:grid-cols-6">
                    <div class="text-gray-500">@lang('clients.show.link'):</div>
                    <div class="md:col-span-5 font-medium">
                        <a href="{{ $client->link }}"
                           class="text-teal-500 hover:text-teal-600"
                           target="_blank">{{ $client->link }}</a>
                    </div>
                </div>
                <div class="grid md:grid-cols-6">
                    <div class="text-gray-500">@lang('clients.show.redirect_urls'):</div>
                    <div class="md:col-span-5 font-medium">{{ $client->redirect }}</div>
                </div>
            </x-ui.page.block>
            <div class="flex pt-5">
                <h1 class="text-3xl col-span-4 bg-gray-200/50 flex items-center px-3 pb-2 pt-1.5 h-full rounded-xl font-medium text-teal-500">
                    Authorized users
                </h1>
            </div>
            <div class="space-y-2">
                @forelse($authorized as $token)
                    <x-ui.page.block>
                        @lang('clients.show.user_authorized_application', ['name' => $token->user->name, 'date' => $token->created_at->format('d M Y'), 'boldClass' => 'font-medium'])
                    </x-ui.page.block>
                @empty
                    <x-ui.text.disabled-text>
                        @lang('clients.show.empty_authorized')
                    </x-ui.text.disabled-text>
                @endforelse
            </div>
        </section>
    </x-ui.page.container>
@endsection
