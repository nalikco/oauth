@extends('layout.layout')

@section('content')
    <x-ui.page.container>
        <x-ui.page.content-header :title="__('dashboard.page_title')"/>
        <section class="mt-5 space-y-5">
            @forelse($clients as $client)
                <x-app.client-box :brand="$client->first()->client->brand[app()->getLocale()]"
                                  :image-url="$client->first()->client->image"
                                  :url="$client->first()->client->link"
                                  :name="$client->first()->client->name_translated[app()->getLocale()]"
                                  :description="$client->first()->client->description[app()->getLocale()]"
                                  :delete-url="'#'"
                                  :created-at-label="__('dashboard.enabled')"
                                  :created-at="$client->first()->created_at"/>
            @empty
                <x-ui.text.disabled-text>
                    @lang('dashboard.no_authorized_applications')
                </x-ui.text.disabled-text>
            @endforelse
        </section>
    </x-ui.page.container>
@endsection
