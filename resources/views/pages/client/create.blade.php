@extends('layout.layout')

@section('content')
    <x-ui.page.container>
        <x-ui.page.content-header :back-url="route('clients.index')"
                                  :title="__('clients.create.title')"/>
        <section class="mt-5 space-y-5">
            <x-ui.page.block>
                <x-app.client.edit-form :action-url="route('clients.store')"/>
            </x-ui.page.block>
        </section>
    </x-ui.page.container>
@endsection
