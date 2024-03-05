<div class="p-2">
    <a href="{{ $getState() ? $getState() : '#' }}" target="_blank">
        <img class="w-16" src="{{ $getState() ? $getState() : '' }}" style="margin: 5px;" />
    </a>
    <a href="{{ $getRecord()->image_sedang_2 ? $getRecord()->image_sedang_2 : '#' }}" target="_blank">
        <img class="w-16" src="{{ $getRecord()->image_sedang_2 ? $getRecord()->image_sedang_2 : '' }}" style="margin: 5px;" />
    </a>
    <a href="{{ $getRecord()->image_sedang_3 ? $getRecord()->image_sedang_3 : '#' }}" target="_blank">
        <img class="w-16" src="{{ $getRecord()->image_sedang_3 ? $getRecord()->image_sedang_3 : '' }}" style="margin: 5px;" />
    </a>
</div>
