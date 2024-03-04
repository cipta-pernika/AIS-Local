<div class="p-2">
    <small style="color: #17a2b8; font-style: italic">Mulai Bongkar - Selesai</small>
    <br />
    {{ \Carbon\Carbon::parse($getRecord()->mulai_bongkar)->format('Y-m-d') }} -
    {{ \Carbon\Carbon::parse($getRecord()->selesai_bongkar)->format('Y-m-d') }}
    <br />
    <small style="color: #17a2b8; font-style: italic">Mulai Muat - Selesai</small>
    <br />
    {{ \Carbon\Carbon::parse($getRecord()->mulai_muat)->format('Y-m-d') }} -
    {{ \Carbon\Carbon::parse($getRecord()->selesai_muat)->format('Y-m-d') }}
    <hr class="mt-1" />
    @if ($getRecord()->actual_mulai_bongkar || $getRecord()->actual_selesai_bongkar || $getRecord()->actual_mulai_muat || $getRecord()->actual_selesai_muat)
    <p class="mt-1">Aktual</p>
    <br />
    <small style="color: #17a2b8; font-style: italic">Aktual Mulai Bongkar - Selesai</small>
    <br />
    @if ($getRecord()->actual_mulai_bongkar || $getRecord()->actual_selesai_bongkar)
    {{ \Carbon\Carbon::parse($getRecord()->actual_mulai_bongkar)->format('Y-m-d H:i') }} -
    {{ \Carbon\Carbon::parse($getRecord()->actual_selesai_bongkar)->format('Y-m-d H:i') }}
    @endif
    <br />
    <small style="color: #17a2b8; font-style: italic">Aktual Mulai Muat - Selesai</small>
    <br />
    @if ($getRecord()->actual_mulai_muat || $getRecord()->actual_selesai_muat)
    {{ \Carbon\Carbon::parse($getRecord()->actual_mulai_muat)->format('Y-m-d H:i') }} -
    {{ \Carbon\Carbon::parse($getRecord()->actual_selesai_muat)->format('Y-m-d H:i') }}
    @endif
    @endif
</div>