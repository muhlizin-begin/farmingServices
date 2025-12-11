<?php

namespace App\Livewire\Tools;

use App\Models\Delivery;
use App\Models\Location;
use App\Models\Team;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Harvesting extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $countLoc;

    public function jumlahLokasi()
    {
        $baseQuery = Location::selectRaw('COUNT(id_lokasi) as total_lokasi')
            ->value('total_lokasi');

        $this->countLoc = $baseQuery;
    }

    // Monitor plantation
    public $range_pengiriman = '';
    public $plant = '';
    public $pg1 = [1, 2, 3, 4, 5, 6, 7, 8];
    public $pg2 = [9, 10, 11, 12, 13, 14, 15, 16];
    public $pg3 = [17, 18, 19, 20, 21, 22, 23, 24];
    public $baseQueryPlant = [];

    public function monitorplant()
    {
        // Default values
        $range = $this->range_pengiriman ?: 'Monthly';
        $plant = $this->plant ?: 'PG1';

        // Base Query
        $query = Delivery::join('teams', 'teams.id_regu', '=', 'deliveries.id_regu')
            ->select('teams.nama_regu', 'deliveries.id_regu')
            ->selectRaw('SUM(deliveries.berat_buah) as total_tonase');

        /** ---------------------------------------------------
         *  FILTER RANGE PENGIRIMAN
         * --------------------------------------------------- */
        $query->when($range === 'Today', function ($q) {
            $q->whereDate('deliveries.tanggal_pengiriman', today());
        });

        $query->when($range === 'Weekly', function ($q) {
            $q->whereBetween('deliveries.tanggal_pengiriman', [
                now()->startOfWeek(Carbon::SUNDAY),
                now()->endOfWeek(Carbon::SUNDAY),
            ]);
        });

        $query->when($range === 'Monthly', function ($q) {
            $q->whereYear('deliveries.tanggal_pengiriman', now()->year)
                ->whereMonth('deliveries.tanggal_pengiriman', now()->month);
        });

        $query->when($range === 'Annual', function ($q) {
            $q->whereYear('deliveries.tanggal_pengiriman', now()->year);
        });

        /** ---------------------------------------------------
         *  FILTER PLANT (PG1 / PG2 / PG3)
         * --------------------------------------------------- */
        $query->when($plant, function ($q) use ($plant) {

            $data = match ($plant) {
                'PG1' => $this->pg1,
                'PG2' => $this->pg2,
                'PG3' => $this->pg3,
                default => [],     // WAJIB agar match tidak error
            };

            if (!empty($data)) {
                $q->whereIn('deliveries.id_regu', $data);
            }
        });

        /** ---------------------------------------------------
         *  GROUP & GET RESULT
         * --------------------------------------------------- */
        $this->baseQueryPlant = $query
            ->groupBy('deliveries.id_regu', 'teams.nama_regu')
            ->orderBy('total_tonase', 'desc')
            ->get();
    }


    // Table tonase
    public $status = '';
    public $perPage = '';
    public $tanggal = '';
    public $regu = '';

    public function updating($property)
    {
        if (in_array($property, ['status', 'tanggal', 'regu', 'perPage', 'plant', 'range_pengiriman'])) {
            $this->resetPage();
        }
    }

    public $teams;

    public function selectregu()
    {
        $this->teams = Team::select('id_regu', 'nama_regu')
            ->groupBy('id_regu', 'nama_regu')
            ->get();
    }

    public function render()
    {
        $this->jumlahLokasi();
        $this->monitorplant();
        $this->selectregu();

        $tableStatusTonase = Delivery::join('teams', 'teams.id_regu', '=', 'deliveries.id_regu')
            ->join('locations', 'locations.id_lokasi','=', 'deliveries.id_lokasi')
            ->select(
                'locations.nama_lokasi',
                'deliveries.id_lokasi',
                'teams.nama_regu',
                'deliveries.id_regu',
                'deliveries.status_lokasi',
                'deliveries.tanggal_pengiriman'
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
                'deliveries.tanggal_pengiriman'
            )

            ->orderBy('tanggal_pengiriman', 'desc')
            ->paginate($this->perPage ?: 10);



        return view('livewire.tools.harvesting', [
            'tableStatusTonase' => $tableStatusTonase,
        ]);
    }
}
