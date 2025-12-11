<div class="flex flex-wrap flex-1 space-y-6">
    {{-- Heading --}}
    <div>
        <flux:heading size="xl">QC Report</flux:heading>
        <flux:text class="mb-3">Harvest Quality Monitoring.</flux:text>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('harvesting') }}" wire:navigate>Harvesting</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('quality') }}" wire:navigate>QC Report</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    {{-- Display data --}}
    <div class="grid grid-cols-1 md:grid-cols-3 w-full gap-6">
        <div class="flex items-center rounded-md border border-neutral-700 shadow-md shadow-gray-900 space-x-2 p-4">
            <div class="rounded-full bg-teal-500/50 p-4">
                <flux:icon.presentation-chart-line class="text-white size-8" />
            </div>
            <div>
                <flux:text>Kwalitas Panen - PG1</flux:text>
                <flux:heading size="xl" class="mt-1 text-teal-500" wire:poll.keep-alive>70 %</flux:heading>
                <flux:text class="text-xs text-amber-500">Dari 690 lokasi</flux:text>
            </div>
        </div>
        <div class="flex items-center rounded-md border border-neutral-700 shadow-md shadow-gray-900 space-x-2 p-4">
            <div class="rounded-full bg-teal-500/50 p-4">
                <flux:icon.presentation-chart-line class="text-white size-8" />
            </div>
            <div>
                <flux:text>Kwalitas Panen - PG2</flux:text>
                <flux:heading size="xl" class="mt-1 text-teal-500" wire:poll.keep-alive>70 %</flux:heading>
                <flux:text class="text-xs text-amber-500">Dari 690 lokasi</flux:text>
            </div>
        </div>
        <div class="flex items-center rounded-md border border-neutral-700 shadow-md shadow-gray-900 space-x-2 p-4">
            <div class="rounded-full bg-teal-500/50 p-4">
                <flux:icon.presentation-chart-line class="text-white size-8" />
            </div>
            <div>
                <flux:text>Kwalitas Panen - PG3</flux:text>
                <flux:heading size="xl" class="mt-1 text-teal-500" wire:poll.keep-alive>70 %</flux:heading>
                <flux:text class="text-xs text-amber-500">Dari 690 lokasi</flux:text>
            </div>
        </div>
    </div>

    {{-- data table --}}
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 w-full">
        <div class="xl:col-span-3">
            <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900">
                <div class="grid grid-cols-1 md:grid-cols-2 p-4 gap-4">
                    <div class="flex flex-1 items-center space-x-4">
                        <div class="w-50">
                            <flux:input type="date" max="2999-12-31" wire:model.live="tanggal" label="Tanggal" />
                        </div>
                        <div class="w-50">
                            <flux:select wire:model.live="regu" label="Regu">
                                @foreach ($teams as $item)
                                    <flux:select.option value="{{$item->id_regu}}">{{$item->nama_regu}}</flux:select.option>
                                @endforeach
                                <flux:select.option value="">All Teams</flux:select.option>
                            </flux:select>
                        </div>
                    </div>
                    <div class="flex flex-1 items-center justify-end space-x-4">
                        <div class="w-25">
                            <flux:select wire:model.live="perPage" label="Page">
                                <flux:select.option value="10">10</flux:select.option>
                                <flux:select.option value="25">25</flux:select.option>
                                <flux:select.option value="50">50</flux:select.option>
                            </flux:select>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto p-4">
                    <table class="min-w-full table-fixed divide-y divide-neutral-700">
                        <thead>
                            <tr class="bg-neutral-900">
                                <th class="text-sm px-4 py-2 text-left">No</th>
                                <th class="text-sm px-4 py-2 text-left">Tanggal</th>
                                <th class="text-sm px-4 py-2 text-left">Regu</th>
                                <th class="text-sm px-4 py-2 text-left">Lokasi</th>
                                <th class="text-sm px-4 py-2 text-left">Bonggol</th>
                                <th class="text-sm px-4 py-2 text-left">Kememaran</th>
                                <th class="text-sm px-4 py-2 text-left">Crown</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($quality as $item)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="text-sm px-4 py-2">
                                        {{ $quality->firstItem() + $loop->index }}
                                    </td>
                                    <td class="text-sm px-4 py-2">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kwalitas)->format('d M Y') }}</td>
                                    <td class="text-sm px-4 py-2">{{ $item->nama_regu }}</td>
                                    <td class="text-sm px-4 py-2">{{ $item->nama_lokasi }}</td>
                                    <td class="text-sm px-4 py-2 text-teal-500">{{$item->bonggol}}</td>
                                    <td class="text-sm px-4 py-2 text-teal-500">{{$item->kememaran}}</td>
                                    <td class="text-sm px-4 py-2 text-teal-500">{{$item->crown}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-zinc-400">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                     <div class="mt-4">
                        {{ $quality->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="xl:col-start-4">

        </div>
    </div>
</div>
