<?php

namespace App\Livewire\Tools;

use App\Models\Delivery;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Harvesting extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $status = '';
    public $perPage = '';
    public $tanggal = '';
    public $globalSearch = '';

    public function updating($property)
    {
        if (in_array($property, ['status', 'tanggal', 'globalSearch', 'perPage'])) {
            $this->resetPage();
        }
    }
    public function render()
    {
        $tableStatusTonase = Delivery::join('teams', 'teams.id_regu', '=', 'deliveries.id_regu')

            // -----------------------------------------
            // GLOBAL SEARCH SEBELUM GROUP BY
            // -----------------------------------------
            ->when($this->globalSearch, function ($q) {
                $search = "%{$this->globalSearch}%";

                $q->where(function ($query) use ($search) {
                    $query->where('teams.nama_regu', 'like', $search)
                        ->orWhere('deliveries.status_lokasi', 'like', $search)
                        ->orWhere('deliveries.tanggal_pengiriman', 'like', $search);
                });
            })

            // -----------------------------------------
            // FILTER STATUS
            // -----------------------------------------
            ->when(
                !$this->globalSearch && $this->status,
                fn($q) =>
                $q->where('deliveries.status_lokasi', $this->status)
            )

            // -----------------------------------------
            // FILTER TANGGAL — hanya kalau tidak search
            // -----------------------------------------
            ->when(
                !$this->globalSearch && $this->tanggal,
                fn($q) =>
                $q->where('deliveries.tanggal_pengiriman', $this->tanggal)
            )

            // -----------------------------------------
            // GROUP BY + AGGREGATE
            // -----------------------------------------
            ->select(
                'teams.nama_regu',
                'deliveries.id_regu',
                'deliveries.status_lokasi',
                'deliveries.tanggal_pengiriman'
            )
            ->selectRaw('SUM(deliveries.berat_buah) as total_tonase')
            ->groupBy(
                'deliveries.id_regu',
                'teams.nama_regu',
                'deliveries.status_lokasi',
                'deliveries.tanggal_pengiriman'
            )

            // -----------------------------------------
            // GLOBAL SEARCH UNTUK TONASE
            // -----------------------------------------
            ->when($this->globalSearch, function ($q) {
                $search = "%{$this->globalSearch}%";
                $q->havingRaw("CAST(SUM(deliveries.berat_buah) AS TEXT) LIKE ?", [$search]);
            })

            ->orderBy('tanggal_pengiriman', 'desc')
            ->paginate($this->perPage ?: 10);



        return view('livewire.tools.harvesting', [
            'tableStatusTonase' => $tableStatusTonase,
        ]);
    }
}
