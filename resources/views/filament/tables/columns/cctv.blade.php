<div class="p-2">
    <a href="{{ $getState() ? $getState() : '#' }}" target="_blank">
        <img class="w-16" src="{{ $getState() ? $getState() : '' }}" style="margin: 5px;" />
    </a>
    <a href="{{ $getRecord()->image_mulai_2 ? $getRecord()->image_mulai_2 : '#' }}" target="_blank">
        <img class="w-16" src="{{ $getRecord()->image_mulai_2 ? $getRecord()->image_mulai_2 : '' }}" style="margin: 5px;" />
    </a>
    <a href="{{ $getRecord()->image_mulai_3 ? $getRecord()->image_mulai_3 : '#' }}" target="_blank">
        <img class="w-16" src="{{ $getRecord()->image_mulai_3 ? $getRecord()->image_mulai_3 : '' }}" style="margin: 5px;" />
    </a>
</div>
