<div class="flex flex-wrap flex-1 space-y-6">
    {{-- Heading --}}
    <div>
        <flux:heading size="xl">Harvesting</flux:heading>
        <flux:text class="mb-3">System Management Harvesting.</flux:text>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('harvesting') }}" wire:navigate>Harvesting</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    {{-- Display data --}}
    <div class="grid grid-cols-1 md:grid-cols-3 w-full gap-6">
        <div class="flex items-center rounded-md border border-neutral-700 shadow-md shadow-gray-900 space-x-2 p-4">
            <div class="rounded-full bg-teal-500/50 p-4">
                <flux:icon.trophy class="text-white" />
            </div>
            <div>
                <flux:text>Jumlah Regu Panen</flux:text>
                <flux:heading size="lg" class="mt-1 text-teal-500" wire:poll.keep-alive>24 Regu</flux:heading>
            </div>
        </div>
        <div class="flex items-center rounded-md border border-neutral-700 shadow-md shadow-gray-900 space-x-2 p-4">
            <div class="rounded-full bg-amber-500/50 p-4">
                <flux:icon.truck class="text-white" />
            </div>
            <div>
                <flux:text>Jumlah Harvester</flux:text>
                <flux:heading size="lg" class="mt-1 text-amber-500" wire:poll.keep-alive>13 Unit</flux:heading>
            </div>
        </div>
        <div class="flex items-center rounded-md border border-neutral-700 shadow-md shadow-gray-900 space-x-2 p-4">
            <div class="rounded-full bg-cyan-500/50 p-4">
                <flux:icon.globe-asia-australia class="text-white" />
            </div>
            <div>
                <flux:text>Jumlah Lokasi Panen</flux:text>
                <flux:heading size="lg" class="mt-1 text-cyan-500" wire:poll.keep-alive>{{ $countLoc }} Lokasi
                </flux:heading>
            </div>
        </div>
    </div>

    <flux:separator text="Data Table" />

    {{-- Table data --}}
    <div class="grid grid-cols-1 md:grid-cols-4 w-full gap-6">
        <div class="md:col-span-3">
            <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900">
                <div class="grid grid-cols-1 md:grid-cols-2 p-4 gap-4">
                    <div class="flex flex-1 items-center space-x-4">
                        <div class="w-50">
                            <flux:input type="date" max="2999-12-31" wire:model.live="tanggal" label="Tanggal" />
                        </div>
                        <div class="w-50">
                            <flux:select wire:model.live="status" label="Status">
                                <flux:select.option value="">All Statuses</flux:select.option>
                                <flux:select.option value="NSFC">NSFC</flux:select.option>
                                <flux:select.option value="NSSC">NSSC</flux:select.option>
                                <flux:select.option value="NSFM">NSFM</flux:select.option>
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

                        <div class="w-70">
                            <flux:select wire:model.live="regu" label="Regu">
                                @foreach ($teams as $item)
                                    <flux:select.option value="{{ $item->id_regu }}">{{ $item->nama_regu }}
                                    </flux:select.option>
                                @endforeach
                                <flux:select.option value="">All Teams</flux:select.option>
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
                                <th class="text-sm px-4 py-2 text-left">Status Lokasi</th>
                                <th class="text-sm px-4 py-2 text-left">Tonase</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($tableStatusTonase as $status)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="text-sm px-4 py-2">
                                        {{ $tableStatusTonase->firstItem() + $loop->index }}
                                    </td>
                                    <td class="text-sm px-4 py-2">
                                        {{ \Carbon\Carbon::parse($status->tanggal_pengiriman)->format('d M Y') }}</td>
                                    <td class="text-sm px-4 py-2">{{ $status->nama_regu }}</td>
                                    <td class="text-sm px-4 py-2">
                                        <flux:badge size="sm"
                                            color="{{ $status->status_lokasi === 'NSFC' ? 'teal' : 'rose' }}">
                                            {{ $status->status_lokasi }}</flux:badge>
                                    </td>
                                    <td class="text-sm px-4 py-2 text-teal-500">
                                        {{ round($status->total_tonase / 1000) }}
                                        Ton</td>
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
                        {{ $tableStatusTonase->links() }}
                    </div>

                </div>
            </div>
        </div>

        <div class="md:col-start-4">
            <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4 space-y-2">
                <div class="flex items-start space-x-2 mb-3">
                    <div>
                        <flux:icon.clipboard-document-check class="text-cyan-500" />
                    </div>
                    <div class="flex items-end justify-between w-full">
                        <div>
                            <flux:heading size="lg">Aktivitas Terbaru</flux:heading>
                            <flux:text class="text-xs">Panen Mekanis.</flux:text>
                        </div>
                    </div>
                </div>
                <div class="flex justify-start items-center space-x-2">
                    <div class="w-30">
                        <flux:select size="sm" wire:model.live="range_pengiriman" placeholder="Statues">
                            <flux:select.option value="Today">Today</flux:select.option>
                            <flux:select.option value="Weekly">Weekly</flux:select.option>
                            <flux:select.option value="Monthly">Monthly</flux:select.option>
                            <flux:select.option value="Annual">Annual</flux:select.option>
                        </flux:select>
                    </div>
                    <div class="w-20">
                        <flux:select size="sm" wire:model.live="plant">
                            <flux:select.option value="PG1">Pg1</flux:select.option>
                            <flux:select.option value="PG2">Pg2</flux:select.option>
                            <flux:select.option value="PG3">Pg3</flux:select.option>
                        </flux:select>
                    </div>
                </div>

                @forelse ($baseQueryPlant as $item)
                    <div
                        class="flex space-x-3 items-center rounded-lg shadow-sm shadow-neutral-900 border border-neutral-700 border-l-4 border-l-teal-700 p-2">
                        <div class="rounded-lg p-2 bg-teal-500/25 flex items-center">
                            <flux:icon.check-badge class="text-white" />
                        </div>
                        <div class="flex justify-between items-center w-full mr-3">
                            <div>
                                <flux:heading size="md">{{ $item->nama_regu }}</flux:heading>
                                <flux:text class="text-xs text-amber-500">
                                    {{ round($item->total_tonase / 1000) }} Ton
                                </flux:text>
                            </div>
                            <div>
                                <flux:text class="text-green-500">5.8%</flux:text>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex justify-center space-x-2 mt-6">
                        <div>
                            <flux:icon.x-circle variant="micro" class="text-neutral-400" />
                        </div>   
                        <div class="text-center text-neutral-400">
                            <flux:text class="text-xs text-neutral-400">
                                    Tidak ada data.
                                </flux:text>
                        </div>
                    </div>
                @endforelse


            </div>
        </div>
    </div>
</div>
