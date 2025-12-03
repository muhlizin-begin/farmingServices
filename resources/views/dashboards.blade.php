<x-layouts.app :title="__('Dashboard') . ' - ' . config('app.name')">

<div wire:poll.3s.keep-alive>
        @livewire('tools.monitortonase')
</div>
        

</x-layouts.app>
