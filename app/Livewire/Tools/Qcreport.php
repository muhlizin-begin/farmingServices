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
