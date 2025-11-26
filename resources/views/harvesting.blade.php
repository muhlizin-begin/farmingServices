<x-layouts.app :title="__('Harvesting') . ' - ' . config('app.name')">
    <div wire:poll.3s.keep-alive>
        @livewire('tools.harvesting')
    </div>
</x-layouts.app>
