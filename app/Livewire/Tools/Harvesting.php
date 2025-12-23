<?php

namespace App\Livewire\Tools;

use App\Models\Delivery;
use App\Models\Quality;
use App\Models\Team;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Harvesting extends Component
{
    use WithPagination, WithoutUrlPagination;

    // Data untuk chart tonase perPG
    public $chartData = [];
    public function loadChartData()
    {
        $baseYear = Delivery::selectRaw('strftime("%Y", tanggal_pengiriman) as year')->first()->year;
        $baseQuery = Delivery::selectRaw("
            strftime('%m', tanggal_pengiriman) as month,
            SUM(berat_buah) as total_berat
        ")
            ->groupBy('month')
            ->orderBy('month');

        $pg1Data = (clone $baseQuery)->whereIn('id_regu', $this->pg1)->get();
        $pg2Data = (clone $baseQuery)->whereIn('id_regu', $this->pg2)->get();
        $pg3Data = (clone $baseQuery)->whereIn('id_regu', $this->pg3)->get();

        $this->chartData = [
            'categories' => [],
            'series' => [
                ['name' => 'PG1', 'data' => []],
                ['name' => 'PG2', 'data' => []],
                ['name' => 'PG3', 'data' => []],
            ],
            'text' => 'Chart Tonase Plantation ' . $baseYear,
        ];

        foreach ($pg1Data as $row) {
            $this->chartData['categories'][] =
                Carbon::create()->month((int)$row->month)->format('M');

            $this->chartData['series'][0]['data'][] =
                round($row->total_berat / 1000); // konversi ke ton
        }

        foreach ($pg2Data as $row) {
            $this->chartData['series'][1]['data'][] =
                round($row->total_berat / 1000); // konversi ke ton
        }

        foreach ($pg3Data as $row) {
            $this->chartData['series'][2]['data'][] =
                round($row->total_berat / 1000); // konversi ke ton
        }
    }


    // Data untuk persentase kwalitas perPG
    public $persentaseKwalitas1;
    public $persentaseKwalitas2;
    public $persentaseKwalitas3;

    public function persentaseKwalitas()
    {
        $map = ['A' => 3, 'B' => 2, 'C' => 1];

        $hitungPG = function ($pg) use ($map) {
            $rows = Quality::whereIn('id_regu', $pg)->get();

            $skor = $rows->sum(
                fn($r) => ($map[$r->kememaran] ?? 0) + ($map[$r->crown] ?? 0)
            );

            $max = $rows->count() * 6; // 3 + 3, maksimal skor

            return $max ? round(($skor / $max) * 100, 2) : 0;
        };

        $this->persentaseKwalitas1 = $hitungPG($this->pg1);
        $this->persentaseKwalitas2 = $hitungPG($this->pg2);
        $this->persentaseKwalitas3 = $hitungPG($this->pg3);
    }

    // Data untuk total tonase perPG
    public $pg1 = [1, 2, 3, 4, 5, 6, 7, 8];
    public $pg2 = [9, 10, 11, 12, 13, 14, 15, 16];
    public $pg3 = [17, 18, 19, 20, 21, 22, 23, 24];
    public $tonasePG1;
    public $tonasePG2;
    public $tonasePG3;

    public function tonasePG()
    {
        $baseQuery = Delivery::selectRaw('SUM(berat_buah) as total_berat');

        $this->tonasePG1 = (clone $baseQuery)
            ->whereIn('id_regu', $this->pg1)
            ->value('total_berat') ?? 0;
        $this->tonasePG2 = (clone $baseQuery)
            ->whereIn('id_regu', $this->pg2)
            ->value('total_berat') ?? 0;
        $this->tonasePG3 = (clone $baseQuery)
            ->whereIn('id_regu', $this->pg3)
            ->value('total_berat') ?? 0;
    }

    

    // Reset pagination dan filter untuk tabel tonase
    public function updating($property)
    {
        if (in_array($property, ['status', 'tanggal', 'regu', 'perPage'])) {
            $this->resetPage();
        }
    }

    // Isi tabel tonase
    public $teams;
    public function selectregu()
    {
        $this->teams = Team::select('id_regu', 'nama_regu')
            ->groupBy('id_regu', 'nama_regu')
            ->get();
    }

    public $status = '';
    public $perPage = '';
    public $tanggal = '';
    public $regu = '';

    public function render()
    {
        $this->loadChartData();

        $this->tonasePG();
        $this->persentaseKwalitas();
        $this->selectregu();

        $tableStatusTonase = Delivery::join('teams', 'teams.id_regu', '=', 'deliveries.id_regu')
            ->join('locations', 'locations.id_lokasi', '=', 'deliveries.id_lokasi')
            ->leftJoin('qualities', function ($qjoin) {
                $qjoin->on('qualities.id_regu', '=', 'deliveries.id_regu')
                    ->on('qualities.tanggal_kwalitas', '=', 'deliveries.tanggal_pengiriman');
            })
            ->select(
                'locations.nama_lokasi',
                'deliveries.id_lokasi',
                'teams.nama_regu',
                'deliveries.id_regu',
                'deliveries.status_lokasi',
                'deliveries.tanggal_pengiriman',
                'qualities.bonggol',
                'qualities.kememaran',
                'qualities.crown',
            )
            ->selectRaw('SUM(deliveries.berat_buah) as total_tonase')
            ->when(
                $this->status,
                fn($q) =>
                $q->where('deliveries.status_lokasi', $this->status)
            )
            ->when(
                $this->tanggal,
                fn($q) =>
                $q->where('deliveries.tanggal_pengiriman', $this->tanggal)
            )
            ->when(
                $this->regu,
                fn($q) =>
                $q->where('deliveries.id_regu', $this->regu)
            )
            ->groupBy(
                'deliveries.id_lokasi',
                'locations.nama_lokasi',
                'deliveries.id_regu',
                'teams.nama_regu',
                'deliveries.status_lokasi',
                'deliveries.tanggal_pengiriman',
                'qualities.bonggol',
                'qualities.kememaran',
                'qualities.crown',
            )

            ->orderBy('tanggal_pengiriman', 'desc')
            ->paginate($this->perPage ?: 10);

        return view('livewire.tools.harvesting', [
            'tableStatusTonase' => $tableStatusTonase,
        ]);
    }
}
