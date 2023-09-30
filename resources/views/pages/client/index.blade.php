@extends('layout.layout')

@section('content')
    <x-ui.page.container>
        <x-ui.page.content-header :title="__('clients.clients')"
                                  :action-label="__('clients.create.create')"
                                  :action-url="route('clients.create')"/>
        <section class="mt-5 space-y-5">
            @forelse($clients as $client)
                <x-app.client-box :brand="$client->brand[app()->getLocale()]"
                                  :image-url="$client->image"
                                  :url="route('clients.show', ['client' => $client->id])"
                                  :name="$client->name_translated[app()->getLocale()]"
                                  :description="$client->description[app()->getLocale()]"
                                  :delete-url="route('clients.destroy', ['client' => $client->id])"
                                  :created-at-label="__('clients.created')"
                                  :created-at="$client->created_at"/>
            @empty
                <x-ui.text.disabled-text>
                    @lang('clients.no_clients')
                </x-ui.text.disabled-text>
            @endforelse
        </section>
    </x-ui.page.container>
@endsection
