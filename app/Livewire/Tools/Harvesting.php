<?php

namespace App\Livewire\Tools;

use App\Models\Delivery;
use App\Models\Team;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Harvesting extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $teams;

    public function selectregu(){
        $this->teams = Team::select('id_regu', 'nama_regu')
                       ->groupBy('id_regu', 'nama_regu')
                       ->get();
    }

    public $status = '';
    public $perPage = '';
    public $tanggal = '';
    public $regu = '';

    public function updating($property)
    {
        if (in_array($property, ['status', 'tanggal', 'regu', 'perPage'])) {
            $this->resetPage();
        }
    }
    public function render()
    {
        $this->selectregu();

        $tableStatusTonase = Delivery::join('teams', 'teams.id_regu', '=', 'deliveries.id_regu')
            ->select(
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
