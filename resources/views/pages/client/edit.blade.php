@extends('layout.layout')

@section('content')
    <x-ui.page.container>
        <x-ui.page.content-header :back-url="route('clients.show', ['client' => $client->id])"
                                  :title="__('clients.edit.title', ['name' => $client->name_translated[app()->getLocale()]])"/>
        <section class="mt-5 space-y-5">
            <x-ui.page.block>
                <x-app.client.edit-form :action-url="route('clients.update', ['client' => $client->id])"
                                        method="PATCH"
                                        :client="$client"/>
            </x-ui.page.block>
        </section>
    </x-ui.page.container>
@endsection
