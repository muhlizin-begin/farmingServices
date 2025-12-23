<div class="flex flex-wrap flex-1">
    {{-- Heading --}}
    {{-- add --}}
    <div>
        <flux:heading size="xl">Dashboard</flux:heading>
        <flux:text class="mb-3">Pineapple weight monitoring information.</flux:text>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('harvesting') }}" wire:navigate>Harvesting</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('quality') }}" wire:navigate>QC Report</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    {{-- monitor tonase --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 w-full gap-6 my-6">
        <div class="rounded-md bg-linear-to-r from-teal-950 to-zinc-800 border border-neutral-700 shadow-md shadow-gray-900 p-4">
            <flux:text>Today</flux:text>
            <flux:heading size="xl" class="mt-1" wire:poll.keep-alive>{{ number_format($today,0,',','.') }} Ton</flux:heading>
            <div class="flex items-center gap-2">
                <flux:icon :name="$iconpercentasetoday" variant="micro" class="{{ $colorPercenttoday }}"
                    wire:poll.keep-alive />
                <span class="text-sm {{ $colorPercenttoday }}" wire:poll.keep-alive>{{ $persentasetoday }}% Last
                    Day</span>
            </div>
        </div>

        <div class="rounded-md border bg-linear-to-r from-teal-950 to-zinc-800 border-neutral-700 shadow-md shadow-gray-900 p-4">
            <flux:text>This Week</flux:text>
            <flux:heading size="xl" class="mt-1" wire:poll.keep-alive>{{ number_format($week,0,',','.') }} Ton</flux:heading>
            <div class="flex items-center gap-2">
                <flux:icon :name="$iconpercentaseweek" variant="micro" class="{{ $colorPercentweek }}"
                    wire:poll.keep-alive />
                <span class="text-sm {{ $colorPercentweek }}" wire:poll.keep-alive>{{ $persentaseweek }}% Last
                    Week</span>
            </div>
        </div>

        <div class="rounded-md border bg-linear-to-r from-teal-950 to-zinc-800 border-neutral-700 shadow-md shadow-gray-900 p-4">
            <flux:text>This Month</flux:text>
            <flux:heading size="xl" class="mt-1" wire:poll.keep-alive>{{ number_format($month,0,',','.') }} Ton</flux:heading>
            <div class="flex items-center gap-2">
                <flux:icon :name="$iconpercentasemonth" variant="micro" class="{{ $colorPercentmonth }}"
                    wire:poll.keep-alive />
                <span class="text-sm {{ $colorPercentmonth }}" wire:poll.keep-alive>{{ $persentasemonth }}% Last
                    Month</span>
            </div>
        </div>

        <div class="rounded-md border bg-linear-to-r from-teal-950 to-zinc-800 border-neutral-700 shadow-md shadow-gray-900 p-4">
            <flux:text>Annual</flux:text>
            <flux:heading size="xl" class="mt-1" wire:poll.keep-alive>{{ number_format($annual,0,',','.') }} Ton</flux:heading>
            <div class="flex items-center gap-2">
                <flux:icon :name="$iconpercentaseannual" variant="micro" class="{{ $colorPercentannual }}"
                    wire:poll.keep-alive />
                <span class="text-sm {{ $colorPercentannual }}" wire:poll.keep-alive>{{ $persentaseannual }}% Last
                    Year</span>
            </div>
        </div>
    </div>

    {{-- <div class="flex flex-1 w-full mb-2">
        <flux:button.group>
            <flux:button size="sm" variant="filled">Oldest</flux:button>
            <flux:button size="sm" variant="filled">Newest</flux:button>
            <flux:button size="sm" variant="filled">Top</flux:button>
        </flux:button.group>
    </div> --}}

    <flux:separator text="monitoring today" />

    {{-- table regu harian --}}
    <div class="mt-6">
        <flux:heading size="xl">Today</flux:heading>
        <flux:text>Daily Monitoring of Plantations.</flux:text>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 w-full gap-6 my-6">
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <div class="mb-6">
                <flux:heading size="xl">PG1</flux:heading>
                <flux:text>Plantation Group 1</flux:text>
            </div>

            <div class="bg-zinc-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-700">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">
                                    Regu
                                </th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200">
                                    Total Tonase
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($pg1Today as $regu)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="px-4 py-2 text-sm text-gray-200">
                                        {{ $regu->nama_regu }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-100">
                                        {{ round($regu->total_tonase / 1000) }} Ton
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center text-gray-400 text-sm">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <div class="mb-6">
                <flux:heading size="xl">PG2</flux:heading>
                <flux:text>Plantation Group 2</flux:text>
            </div>

            <div class="bg-zinc-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-700">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">
                                    Regu
                                </th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200">
                                    Total Tonase
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($pg2Today as $regu)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="px-4 py-2 text-sm text-gray-200">
                                        {{ $regu->nama_regu }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-100">
                                        {{ round($regu->total_tonase / 1000) }} Ton
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center text-gray-400 text-sm">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <div class="mb-6">
                <flux:heading size="xl">PG3</flux:heading>
                <flux:text>Plantation Group 3</flux:text>
            </div>

            <div class="bg-zinc-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-700">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">
                                    Regu
                                </th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200">
                                    Total Tonase
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($pg3Today as $regu)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="px-4 py-2 text-sm text-gray-200">
                                        {{ $regu->nama_regu }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-100">
                                        {{ round($regu->total_tonase / 1000) }} Ton
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center text-gray-400 text-sm">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <flux:separator text="monitoring weekly" />

    {{-- table regu mingguan --}}
    <div class="mt-6">
        <flux:heading size="xl">This Week</flux:heading>
        <flux:text>Weekly Monitoring of Plantations.</flux:text>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 w-full gap-6 my-6">
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <div class="mb-6">
                <flux:heading size="xl">PG1</flux:heading>
                <flux:text>Plantation Group 1</flux:text>
            </div>

            <div class="bg-zinc-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-700">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">
                                    Regu
                                </th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200">
                                    Total Tonase
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($pg1Week as $regu)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="px-4 py-2 text-sm text-gray-200">
                                        {{ $regu->nama_regu }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-100">
                                        {{ round($regu->total_tonase / 1000) }} Ton
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center text-gray-400 text-sm">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <div class="mb-6">
                <flux:heading size="xl">PG2</flux:heading>
                <flux:text>Plantation Group 2</flux:text>
            </div>

            <div class="bg-zinc-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-700">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">
                                    Regu
                                </th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200">
                                    Total Tonase
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($pg2Week as $regu)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="px-4 py-2 text-sm text-gray-200">
                                        {{ $regu->nama_regu }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-100">
                                        {{ round($regu->total_tonase / 1000) }} Ton
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center text-gray-400 text-sm">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <div class="mb-6">
                <flux:heading size="xl">PG3</flux:heading>
                <flux:text>Plantation Group 3</flux:text>
            </div>

            <div class="bg-zinc-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-700">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">
                                    Regu
                                </th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200">
                                    Total Tonase
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($pg3Week as $regu)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="px-4 py-2 text-sm text-gray-200">
                                        {{ $regu->nama_regu }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-100">
                                        {{ round($regu->total_tonase / 1000) }} Ton
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center text-gray-400 text-sm">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <flux:separator text="monitoring monthly" />

    {{-- table regu bulanan --}}
    <div class="mt-6">
        <flux:heading size="xl">This Month</flux:heading>
        <flux:text>Monthly Monitoring of Plantations.</flux:text>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 w-full gap-6 my-6">
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <div class="mb-6">
                <flux:heading size="xl">PG1</flux:heading>
                <flux:text>Plantation Group 1</flux:text>
            </div>

            <div class="bg-zinc-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-700">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">
                                    Regu
                                </th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200">
                                    Total Tonase
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($pg1Month as $regu)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="px-4 py-2 text-sm text-gray-200">
                                        {{ $regu->nama_regu }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-100">
                                        {{ round($regu->total_tonase / 1000) }} Ton
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center text-gray-400 text-sm">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <div class="mb-6">
                <flux:heading size="xl">PG2</flux:heading>
                <flux:text>Plantation Group 2</flux:text>
            </div>

            <div class="bg-zinc-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-700">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">
                                    Regu
                                </th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200">
                                    Total Tonase
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($pg2Month as $regu)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="px-4 py-2 text-sm text-gray-200">
                                        {{ $regu->nama_regu }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-100">
                                        {{ round($regu->total_tonase / 1000) }} Ton
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center text-gray-400 text-sm">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <div class="mb-6">
                <flux:heading size="xl">PG3</flux:heading>
                <flux:text>Plantation Group 3</flux:text>
            </div>

            <div class="bg-zinc-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-700">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">
                                    Regu
                                </th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200">
                                    Total Tonase
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($pg3Month as $regu)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="px-4 py-2 text-sm text-gray-200">
                                        {{ $regu->nama_regu }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-100">
                                        {{ round($regu->total_tonase / 1000) }} Ton
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center text-gray-400 text-sm">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <flux:separator text="monitoring Annual" />

    {{-- table regu tahunan --}}
    <div class="mt-6">
        <flux:heading size="xl">Annual</flux:heading>
        <flux:text>Annual Monitoring of Plantations.</flux:text>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 w-full gap-6 my-6">
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <div class="mb-6">
                <flux:heading size="xl">PG1</flux:heading>
                <flux:text>Plantation Group 1</flux:text>
            </div>

            <div class="bg-zinc-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-700">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">
                                    Regu
                                </th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200">
                                    Total Tonase
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($pg1Year as $regu)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="px-4 py-2 text-sm text-gray-200">
                                        {{ $regu->nama_regu }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-100">
                                        {{ round($regu->total_tonase / 1000) }} Ton
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center text-gray-400 text-sm">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <div class="mb-6">
                <flux:heading size="xl">PG2</flux:heading>
                <flux:text>Plantation Group 2</flux:text>
            </div>

            <div class="bg-zinc-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-700">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">
                                    Regu
                                </th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200">
                                    Total Tonase
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($pg2Year as $regu)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="px-4 py-2 text-sm text-gray-200">
                                        {{ $regu->nama_regu }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-100">
                                        {{ round($regu->total_tonase / 1000) }} Ton
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center text-gray-400 text-sm">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="rounded-md border border-neutral-700 shadow-md shadow-neutral-900 p-4">
            <div class="mb-6">
                <flux:heading size="xl">PG3</flux:heading>
                <flux:text>Plantation Group 3</flux:text>
            </div>

            <div class="bg-zinc-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-700">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">
                                    Regu
                                </th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200">
                                    Total Tonase
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-700">
                            @forelse ($pg3Year as $regu)
                                <tr class="hover:bg-zinc-900 transition">
                                    <td class="px-4 py-2 text-sm text-gray-200">
                                        {{ $regu->nama_regu }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-100">
                                        {{ round($regu->total_tonase / 1000) }} Ton
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center text-gray-400 text-sm">
                                        Data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
