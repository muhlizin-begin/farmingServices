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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 w-full gap-6">
        <div class=" rounded-md bg-teal-950 border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <flux:heading class="text-amber-500" size="lg">Chart Plantations</flux:heading>
            <flux:text class="text-xs mt-1">Kwalitas Regu</flux:text>
            <div class="flex items-center justify-center">
                <div id="chart1"></div>
                <script>
    // Bungkus dalam fungsi agar bisa dipanggil berulang kali
    function initChartRank() {
        const chartElement = document.querySelector("#chart1");
        const chartRank = @json($chartRank);

        // Pastikan elemen ada dan data tersedia
        if (chartElement && chartRank && chartRank.series && chartRank.series.length) {
            
            // Bersihkan konten di dalam element sebelum render ulang
            // Ini penting untuk mencegah chart duplikat saat navigasi SPA
            chartElement.innerHTML = '';

            const options = {
                chart: {
                    type: 'donut',
                    width: 350,
                },
                dataLabels: { enabled: true },
                series: chartRank.series,
                labels: chartRank.labels,
                legend: {
                    position: 'bottom',
                }
            };

            const chart = new ApexCharts(chartElement, options);
            chart.render();
        }
    }

    // 1. Jalankan saat navigasi via wire:navigate selesai
    document.addEventListener('livewire:navigated', () => {
        initChartRank();
    });

    // 2. Jalankan saat pertama kali halaman dimuat (standard reload)
    document.addEventListener('DOMContentLoaded', () => {
        initChartRank();
    });
</script>
            </div>
        </div>
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <flux:heading size="lg">Plantation 1</flux:heading>
            <flux:text class="text-xs mt-1">Kwalitas Regu</flux:text>

            <div class="overflow-x-auto p-4">
                <table class="min-w-full table-fixed divide-y divide-neutral-700">
                    <thead class="bg-teal-950">
                        <tr>
                            <th class="text-xs md:text-sm px-4 py-2 text-left">#</th>
                            <th class="text-xs md:text-sm px-4 py-2 text-left">Regu</th>
                            <th class="text-xs md:text-sm px-4 py-2 text-left">Kwalitas</th>
                            <th class="text-xs md:text-sm px-4 py-2 text-left">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-700">
                        @forelse ($rankPG1 as $item)
                            <tr class="hover:bg-teal-950 transition">
                                <td class="text-xs md:text-sm px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="text-xs md:text-sm px-4 py-2">{{ $item->nama_regu }}</td>
                                <td class="text-xs md:text-sm px-4 py-2">{{ $item->total_score }}%</td>
                                <td class="text-xs md:text-sm px-4 py-2">{{ $item->jumlah_data }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-zinc-400">
                                    Data tidak ada
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <flux:heading size="lg">Plantation 2</flux:heading>
            <flux:text class="text-xs mt-1">Kwalitas Regu</flux:text>

            <div class="overflow-x-auto p-4">
                <table class="min-w-full table-fixed divide-y divide-neutral-700">
                    <thead class="bg-teal-950">
                        <tr>
                            <th class="text-xs md:text-sm px-4 py-2 text-left">#</th>
                            <th class="text-xs md:text-sm px-4 py-2 text-left">Regu</th>
                            <th class="text-xs md:text-sm px-4 py-2 text-left">Kwalitas</th>
                            <th class="text-xs md:text-sm px-4 py-2 text-left">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-700">
                        @forelse ($rankPG2 as $item)
                            <tr class="hover:bg-teal-950 transition">
                                <td class="text-xs md:text-sm px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="text-xs md:text-sm px-4 py-2">{{ $item->nama_regu }}</td>
                                <td class="text-xs md:text-sm px-4 py-2">{{ $item->total_score }}%</td>
                                <td class="text-xs md:text-sm px-4 py-2">{{ $item->jumlah_data }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-zinc-400">
                                    Data tidak ada
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <flux:heading size="lg">Plantation 3</flux:heading>
            <flux:text class="text-xs mt-1">Kwalitas Regu</flux:text>

            <div class="overflow-x-auto p-4">
                <table class="min-w-full table-fixed divide-y divide-neutral-700">
                    <thead class="bg-teal-950">
                        <tr>
                            <th class="text-xs md:text-sm px-4 py-2 text-left">#</th>
                            <th class="text-xs md:text-sm px-4 py-2 text-left">Regu</th>
                            <th class="text-xs md:text-sm px-4 py-2 text-left">Kwalitas</th>
                            <th class="text-xs md:text-sm px-4 py-2 text-left">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-700">
                        @forelse ($rankPG3 as $item)
                            <tr class="hover:bg-teal-950 transition">
                                <td class="text-xs md:text-sm px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="text-xs md:text-sm px-4 py-2">{{ $item->nama_regu }}</td>
                                <td class="text-xs md:text-sm px-4 py-2">{{ $item->total_score }}%</td>
                                <td class="text-xs md:text-sm px-4 py-2">{{ $item->jumlah_data }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-zinc-400">
                                    Data tidak ada
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- data table --}}
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 w-full">
        <div class="xl:col-span-4">
            <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900">
                <div class="grid grid-cols-1 md:grid-cols-2 p-4 gap-4">
                    <div class="flex flex-1 items-center space-x-4">
                        <div class="w-50">
                            <flux:input type="date" max="2999-12-31" wire:model.lazy="tanggal" label="Tanggal" />
                        </div>
                        <div class="w-50">
                            <flux:select wire:model.live="regu" label="Regu">
                                @foreach ($teams as $item)
                                    <flux:select.option value="{{ $item->id_regu }}">{{ $item->nama_regu }}
                                    </flux:select.option>
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
                                <th class="text-xs md:text-sm px-4 py-2 text-left">No</th>
                                <th class="text-xs md:text-sm px-4 py-2 text-left">Tanggal</th>
                                <th class="text-xs md:text-sm px-4 py-2 text-left">Regu</th>
                                <th class="text-xs md:text-sm px-4 py-2 text-left">Lokasi</th>
                                <th class="text-xs md:text-sm px-4 py-2 text-left">Bonggol</th>
                                <th class="text-xs md:text-sm px-4 py-2 text-left">Kememaran</th>
                                <th class="text-xs md:text-sm px-4 py-2 text-left">Crown</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($quality as $item)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="text-xs md:text-sm px-4 py-2">
                                        {{ $quality->firstItem() + $loop->index }}
                                    </td>
                                    <td class="text-xs md:text-sm px-4 py-2">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kwalitas)->format('d M Y') }}</td>
                                    <td class="text-xs md:text-sm px-4 py-2">{{ $item->nama_regu }}</td>
                                    <td class="text-xs md:text-sm px-4 py-2">{{ $item->nama_lokasi }}</td>
                                    <td class="text-xs md:text-sm px-4 py-2 text-teal-500">{{ $item->bonggol }}</td>
                                    <td class="text-xs md:text-sm px-4 py-2 text-teal-500">{{ $item->kememaran }}</td>
                                    <td class="text-xs md:text-sm px-4 py-2 text-teal-500">{{ $item->crown }}</td>
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
