<div class="flex flex-col">
    <label
        for="{{ $name }}"
        class="font-medium"
    >{{ $title }}</label
    >
    <input
        accept="{{ $accept }}"
        class="relative m-0 mt-1 block w-full min-w-0 flex-auto rounded border border-solid border-gray-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-gray-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-gray-700 focus:shadow-te-primary focus:outline-none"
        type="file"
        @if($required) required @endif
        name="{{ $name }}"
        id="{{ $name }}"/>
    @error($name)
    <div class="font-medium text-sm text-rose-500 mt-0.5">
        {{ $message }}
    </div>
    @enderror
</div>
