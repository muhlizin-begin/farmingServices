<div class="flex flex-wrap flex-1">
    {{-- Heading --}}
    <div>
        <flux:heading size="xl">Harvesting</flux:heading>
        <flux:text class="mb-3">System Management Harvesting.</flux:text>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('harvesting') }}" wire:navigate>Harvesting</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    {{-- filter data --}}
    <div class="grid grid-cols-1 w-full my-6 rounded-md border border-neutral-700 shadow-md shadow-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-2 p-4 gap-4">
            <div class="flex flex-1 items-center space-x-4">
                <div class="w-50">
                    <flux:input type="date" max="2999-12-31" wire:model.live="tanggal" placeholder="yyyy-mm-dd" />
                </div>
                <div class="w-50">
                    <flux:select wire:model.live="status">
                        <flux:select.option value="">All Statuses</flux:select.option>
                        <flux:select.option value="NSFC">NSFC</flux:select.option>
                        <flux:select.option value="NSSC">NSSC</flux:select.option>
                        <flux:select.option value="NSFM">NSFM</flux:select.option>
                    </flux:select>
                </div>
            </div>

            <div class="flex flex-1 items-center justify-end space-x-4">
                <div class="w-25">
                    <flux:select wire:model.live="perPage">
                        <flux:select.option value="10">10</flux:select.option>
                        <flux:select.option value="25">25</flux:select.option>
                        <flux:select.option value="50">50</flux:select.option>
                    </flux:select>
                </div>

                <div class="w-70">
                    <flux:select wire:model.live="regu">
                        @foreach ($teams as $item)
                            <flux:select.option value="{{ $item->id_regu }}">{{ $item->nama_regu }}</flux:select.option>
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
                            <td class="text-sm px-4 py-2">{{ $status->status_lokasi }}</td>
                            <td class="text-sm px-4 py-2">{{ round($status->total_tonase / 1000) }} Ton</td>
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
