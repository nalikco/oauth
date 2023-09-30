<form action="{{ $actionUrl }}"
      class="space-y-4"
      enctype="multipart/form-data"
      method="POST">
    @csrf
    @method($method)
    <div>
        <x-ui.form.file-upload
            name="image"
            :title="__('validation.attributes.image')"
            accept="image/*"
            required
        />
    </div>
    <div class="grid grid-cols-2 items-center gap-5 border-t-2 pt-3">
        <div>
            <x-ui.form.input
                name="brand_en"
                :title="__('validation.attributes.brand_en')"
                :value="old('brand_en', $client->brand['en'] ?? '')"
                required
                auto-focus
            />
        </div>
        <div>
            <x-ui.form.input
                name="brand_ru"
                :title="__('validation.attributes.brand_ru')"
                :value="old('brand_ru', $client->brand['ru'] ?? '')"
                required
            />
        </div>
    </div>
    <div class="grid grid-cols-2 items-center gap-5 border-t-2 pt-3">
        <div>
            <x-ui.form.input
                name="name_en"
                :title="__('validation.attributes.name_en')"
                :value="old('name_en', $client->name_translated['en'] ?? '')"
                required
                auto-focus
            />
        </div>
        <div>
            <x-ui.form.input
                name="name_ru"
                :title="__('validation.attributes.name_ru')"
                :value="old('name_ru', $client->name_translated['ru'] ?? '')"
                required
            />
        </div>
    </div>
    <div class="grid grid-cols-2 items-center gap-5 border-t-2 pt-3">
        <div>
            <x-ui.form.text-area
                name="description_en"
                :title="__('validation.attributes.description_en')"
                :value="old('description_en', $client->description['en'] ?? '')"
                required
                auto-focus
            />
        </div>
        <div>
            <x-ui.form.text-area
                name="description_ru"
                :title="__('validation.attributes.description_ru')"
                :value="old('description_ru', $client->description['ru'] ?? '')"
                required
            />
        </div>
    </div>
    <div class="border-t-2 pt-3 space-y-2">
        <x-ui.form.input
            name="redirect_url"
            :title="__('validation.attributes.redirect_url')"
            :value="old('redirect_url', $client->redirect ?? '')"
            required
        />
        <x-ui.form.input
            name="link"
            :title="__('validation.attributes.link')"
            :value="old('link', $client->link ?? '')"
            required
        />
    </div>
    <div class="border-t-2 pt-3">
        <x-ui.buttons.button type="submit" :full-width="true">
            @if($client == null)
                @lang('clients.create.create')
            @else
                @lang('clients.edit.save')
            @endif
        </x-ui.buttons.button>
    </div>
</form>
