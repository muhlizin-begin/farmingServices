<?php

namespace App\Livewire\Tools;

use App\Models\Team;
use App\Models\Quality;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Qcreport extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $pg1 = [1, 2, 3, 4, 5, 6, 7, 8];
    public $pg2 = [9, 10, 11, 12, 13, 14, 15, 16];
    public $pg3 = [17, 18, 19, 20, 21, 22, 23, 24];
    public $rankPG1 = [];
    public $rankPG2 = [];
    public $rankPG3 = [];
    public $chartRankPG1;
    public $chartRankPG2;
    public $chartRankPG3;
    public $chartRank = [];

    public function chartRankRegu()
    {
        $map = ['A' => 3, 'B' => 2, 'C' => 1];
        $groups = [
            'chartRankPG1' => $this->pg1,
            'chartRankPG2' => $this->pg2,
            'chartRankPG3' => $this->pg3,
        ];

        foreach ($groups as $property => $ids) {
            $baseQuery = Quality::select('id_regu', 'kememaran', 'crown')
                ->whereIn('id_regu', $ids)
                ->get();

            $maxScore = $baseQuery->count() * 6;
            $nilaiRegu = $baseQuery->sum(function ($item) use ($map) {
                return ($map[$item->kememaran] ?? 0) + ($map[$item->crown] ?? 0);
            });
            $this->$property = $maxScore > 0 ? round(($nilaiRegu / $maxScore) * 100, 2) : 0;
        }

        $this->chartRank = [
            'series' => [
                $this->chartRankPG1,
                $this->chartRankPG2,
                $this->chartRankPG3,
            ],
            'labels' => ['PG 1', 'PG 2', 'PG 3'],
        ];
    }

    public function rankRegu()
    {
        $map = ['A' => 3, 'B' => 2, 'C' => 1];

        // Buat daftar grup yang akan diproses
        $groups = [
            'rankPG1' => $this->pg1,
            'rankPG2' => $this->pg2,
            'rankPG3' => $this->pg3,
        ];

        foreach ($groups as $property => $ids) {
            $this->$property = Quality::join('teams', 'teams.id_regu', '=', 'qualities.id_regu')
                ->select('teams.nama_regu', 'qualities.id_regu', 'qualities.kememaran', 'qualities.crown')
                ->whereIn('qualities.id_regu', $ids)
                ->get()
                ->groupBy('id_regu')
                ->map(function ($items) use ($map) {
                    $first = $items->first();

                    $totalScore = $items->sum(function ($item) use ($map) {
                        return ($map[$item->kememaran] ?? 0) + ($map[$item->crown] ?? 0);
                    });

                    $maxScore = $items->count() * 6;

                    return (object) [
                        'id_regu'     => $first->id_regu,
                        'nama_regu'   => $first->nama_regu,
                        'total_score' => $maxScore > 0 ? round(($totalScore / $maxScore) * 100, 2) : 0,
                        'jumlah_data' => $items->count()
                    ];
                })
                ->sortByDesc('total_score')
                ->values();
        }
    }


    // Table tonase
    public $perPage = '';
    public $tanggal = '';
    public $regu = '';

    public function updating($property)
    {
        if (in_array($property, ['tanggal', 'regu', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $this->rankRegu();
        $this->chartRankRegu();

        $teams = Team::select('id_regu', 'nama_regu')
            ->groupBy('id_regu', 'nama_regu')
            ->get();

        $quality = Quality::join('teams', 'teams.id_regu', '=', 'qualities.id_regu')
            ->join('locations', 'locations.id_lokasi', '=', 'qualities.id_lokasi')
            ->select(
                'teams.nama_regu',
                'qualities.id_regu',
                'locations.nama_lokasi',
                'qualities.id_lokasi',
                'tanggal_kwalitas',
                'bonggol',
                'kememaran',
                'crown'
            )
            ->when(
                $this->tanggal,
                fn($q) =>
                $q->where('qualities.tanggal_kwalitas', $this->tanggal)
            )
            ->when(
                $this->regu,
                fn($q) =>
                $q->where('qualities.id_regu', $this->regu)
            )
            ->groupBy(
                'teams.nama_regu',
                'qualities.id_regu',
                'locations.nama_lokasi',
                'qualities.id_lokasi',
                'tanggal_kwalitas',
                'bonggol',
                'kememaran',
                'crown'
            )
            ->orderBy('tanggal_kwalitas', 'desc')
            ->paginate($this->perPage ?: 10);;

        return view('livewire.tools.qcreport', [
            'teams' => $teams,
            'quality' => $quality,
        ]);
    }
}
