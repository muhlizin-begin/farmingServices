<x-layouts.app :title="__('QC Report') . ' - ' . config('app.name')">
    <div wire:poll.3s.keep-alive>
        @livewire('tools.qcreport')
    </div>
</x-layouts.app>