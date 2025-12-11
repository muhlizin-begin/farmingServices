<x-layouts.app :title="__('quality') . ' - ' . config('app.name')">
    <div wire:poll.3s.keep-alive>
        @livewire('tools.qcreport')
    </div>
</x-layouts.app>