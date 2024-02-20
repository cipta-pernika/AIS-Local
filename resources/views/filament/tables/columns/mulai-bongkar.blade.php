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
    <p class="mt-1">Actual</p>
    <br />
    <small style="color: #17a2b8; font-style: italic">Mulai Bongkar - Selesai</small>
    <br />
    {{ \Carbon\Carbon::parse($getRecord()->mulai_bongkar)->format('Y-m-d H:i') }} -
    {{ \Carbon\Carbon::parse($getRecord()->mulai_bongkar)->format('Y-m-d H:i') }}
</div>