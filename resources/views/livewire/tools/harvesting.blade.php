<div class="flex flex-wrap flex-1 space-y-6">
    {{-- Heading --}}
    <div>
        <flux:heading size="xl">Harvesting</flux:heading>
        <flux:text class="mb-3">System Management Harvesting.</flux:text>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('harvesting') }}" wire:navigate>Harvesting</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('quality') }}" wire:navigate>QC Report</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 w-full gap-6">
        <div class="rounded-lg border border-neutral-700 shadow-md shadow-gray-900 bg-teal-950 p-4">
            <div class="flex justify-between items-start">
                <div>
                    <flux:heading>Plantation 1</flux:heading>
                    <flux:text class="mt-2 text-teal-500">{{ number_format(round($tonasePG1 / 1000), 0, ',', '.') }}
                        Ton</flux:text>
                </div>
                <div class="text-center">
                    <flux:text class="text-white text-xs">Kwalitas Panen</flux:text>
                    <flux:heading size="xl" class="text-teal-500 mt-1">{{ $persentaseKwalitas1 }}%
                    </flux:heading>
                </div>
            </div>
        </div>
        <div class="rounded-lg border border-neutral-700 shadow-md shadow-gray-900 bg-teal-950 p-4">
            <div class="flex justify-between items-start">
                <div>
                    <flux:heading>Plantation 2</flux:heading>
                    <flux:text class="mt-2 text-teal-500">{{ number_format(round($tonasePG2 / 1000), 0, ',', '.') }}
                        Ton</flux:text>
                </div>
                <div class="text-center">
                    <flux:text class="text-white text-xs">Kwalitas Panen</flux:text>
                    <flux:heading size="xl" class="text-teal-500 mt-1">{{ $persentaseKwalitas2 }}%
                    </flux:heading>
                </div>
            </div>
        </div>
        <div class="rounded-lg border border-neutral-700 shadow-md shadow-gray-900 bg-teal-950 p-4">
            <div class="flex justify-between items-start">
                <div>
                    <flux:heading>Plantation 3</flux:heading>
                    <flux:text class="mt-2 text-teal-500">{{ number_format(round($tonasePG3 / 1000), 0, ',', '.') }}
                        Ton</flux:text>
                </div>
                <div class="text-center">
                    <flux:text class="text-white text-xs">Kwalitas Panen</flux:text>
                    <flux:heading size="xl" class="text-teal-500 mt-1">{{ $persentaseKwalitas3 }}%
                    </flux:heading>
                </div>
            </div>
        </div>
    </div>

    {{-- Table data --}}
    <div class="grid grid-cols-1 w-full gap-6">
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
                            <th class="text-sm px-4 py-2 text-left">Lokasi</th>
                            <th class="text-sm px-4 py-2 text-left">Status Lokasi</th>
                            <th class="text-sm px-4 py-2 text-left">Tonase</th>
                            <th class="text-sm px-4 py-2 text-left">Kememaran</th>
                            <th class="text-sm px-4 py-2 text-left">Crown</th>
                            <th class="text-sm px-4 py-2 text-left">Bonggol</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-700">
                        @forelse ($tableStatusTonase as $item)
                            <tr class="hover:bg-zinc-900 transition">
                                <td class="text-sm px-4 py-2">
                                    {{ $tableStatusTonase->firstItem() + $loop->index }}
                                </td>
                                <td class="text-sm px-4 py-2">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d M Y') }}</td>
                                <td class="text-sm px-4 py-2">{{ $item->nama_regu }}</td>
                                <td class="text-sm px-4 py-2">{{ $item->nama_lokasi }}</td>
                                <td class="text-sm px-4 py-2">
                                    <flux:badge size="sm"
                                        color="{{ $item->status_lokasi === 'NSFC' ? 'teal' : 'rose' }}">
                                        {{ $item->status_lokasi }}</flux:badge>
                                </td>
                                <td class="text-sm px-4 py-2 text-teal-500">
                                    {{ round($item->total_tonase / 1000) }}
                                    Ton</td>
                                <td
                                    class="text-sm px-4 py-2 {{ $item->kememaran === 'C' ? 'text-red-500' : 'text-teal-500' }}">
                                    {{ $item->kememaran }}</td>
                                <td
                                    class="text-sm px-4 py-2 {{ $item->crown === 'C' ? 'text-red-500' : 'text-teal-500' }}">
                                    {{ $item->crown }}</td>
                                <td
                                    class="text-sm px-4 py-2 {{ $item->bonggol === 'C' ? 'text-red-500' : 'text-teal-500' }}">
                                    {{ $item->bonggol }}</td>
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
</div>
