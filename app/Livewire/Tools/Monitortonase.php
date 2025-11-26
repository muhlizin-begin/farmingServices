<?php

namespace App\Livewire\Tools;

use Livewire\Component;
use App\Models\Delivery;
use Carbon\Carbon;

class Monitortonase extends Component
{
    // Public monitorTonase
    public $today;
    public $subtoday;
    public $persentasetoday;

    public $week;
    public $subweek;
    public $persentaseweek;

    public $month;
    public $submonth;
    public $persentasemonth;

    public $annual;
    public $subannual;
    public $persentaseannual;

    public $iconpercentasetoday;
    public $iconpercentaseweek;
    public $iconpercentasemonth;
    public $iconpercentaseannual;

    public $colorPercenttoday;
    public $colorPercentweek;
    public $colorPercentmonth;
    public $colorPercentannual;

    public function monitorTonase()
    {
        // Helper persentase
        $calcPercent = function ($current, $previous) {
            if ($previous == 0) {
                return $current > 0 ? 100.00 : 0;
            }
            return abs(round((($current - $previous) / $previous) * 100, 2));
        };

        // >>> TODAY
        $this->today = round(Delivery::whereDate('tanggal_pengiriman', today())->sum('berat_buah') / 1000);
        $this->subtoday = round(Delivery::whereDate('tanggal_pengiriman', today()->subDay())->sum('berat_buah') / 1000);

        $this->persentasetoday = $calcPercent($this->today, $this->subtoday);

        // >>> WEEK (Senin–Minggu)
        $this->week = round(
            Delivery::whereBetween('tanggal_pengiriman', [
                now()->startOfWeek(Carbon::SUNDAY),
                now()->endOfWeek(Carbon::SUNDAY)
            ])->sum('berat_buah') / 1000
        );

        $this->subweek = round(
            Delivery::whereBetween('tanggal_pengiriman', [
                now()->startOfWeek(Carbon::SUNDAY)->subWeek(),
                now()->endOfWeek(Carbon::SUNDAY)->subWeek()
            ])->sum('berat_buah') / 1000
        );

        $this->persentaseweek = $calcPercent($this->week, $this->subweek);

        // >>> MONTH
        $this->month = round(
            Delivery::whereMonth('tanggal_pengiriman', now()->month)
                ->whereYear('tanggal_pengiriman', now()->year)
                ->sum('berat_buah') / 1000
        );

        $this->submonth = round(
            Delivery::whereMonth('tanggal_pengiriman', now()->subMonth()->month)
                ->whereYear('tanggal_pengiriman', now()->subMonth()->year)
                ->sum('berat_buah') / 1000
        );

        $this->persentasemonth = $calcPercent($this->month, $this->submonth);

        // >>> ANNUAL
        $this->annual = round(
            Delivery::whereYear('tanggal_pengiriman', now()->year)
                ->sum('berat_buah') / 1000
        );

        $this->subannual = round(
            Delivery::whereYear('tanggal_pengiriman', now()->subYear()->year)
                ->sum('berat_buah') / 1000
        );

        $this->persentaseannual = $calcPercent($this->annual, $this->subannual);

        // >>> ICON
        $iconPercent = fn($c, $p) => $c < $p ? 'arrow-trending-down' : 'arrow-trending-up';

        $this->iconpercentasetoday  = $iconPercent($this->today, $this->subtoday);
        $this->iconpercentaseweek   = $iconPercent($this->week, $this->subweek);
        $this->iconpercentasemonth  = $iconPercent($this->month, $this->submonth);
        $this->iconpercentaseannual = $iconPercent($this->annual, $this->subannual);

        // >>> WARNA
        $colorPercent = fn($c, $p) => $c < $p ? 'dark:text-red-500' : 'dark:text-green-500';

        $this->colorPercenttoday  = $colorPercent($this->today, $this->subtoday);
        $this->colorPercentweek   = $colorPercent($this->week, $this->subweek);
        $this->colorPercentmonth  = $colorPercent($this->month, $this->submonth);
        $this->colorPercentannual = $colorPercent($this->annual, $this->subannual);
    }

    // Public tableRegu
    public $pg1 = [1, 2, 3, 4, 5, 6, 7, 8,];
    public $pg2 = [9, 10, 11, 12, 13, 14, 15, 16];
    public $pg3 = [17, 18, 19, 20, 21, 22, 23, 24];

    public $reguTonase;
    public $pg1Tonase;
    public $pg2Tonase;
    public $pg3Tonase;

    public $reguToday;
    public $reguWeek;
    public $reguMonth;
    public $reguYear;

    public $pg1Today;
    public $pg2Today;
    public $pg3Today;

    public $pg1Week;
    public $pg2Week;
    public $pg3Week;

    public $pg1Month;
    public $pg2Month;
    public $pg3Month;

    public $pg1Year;
    public $pg2Year;
    public $pg3Year;

    public function tableRegu()
{
    // =============================
    // RANGE DATE
    // =============================
    $today = today();
    $weekStart = now()->startOfWeek(Carbon::SUNDAY);
    $weekEnd   = now()->endOfWeek(Carbon::SUNDAY);
    $month     = now()->month;
    $year      = now()->year;

    // =============================
    // QUERY BASE JOIN
    // =============================
    $baseQuery = Delivery::join('teams', 'teams.id_regu', '=', 'deliveries.id_regu')
        ->select('teams.nama_regu', 'deliveries.id_regu')
        ->groupBy('deliveries.id_regu', 'teams.nama_regu');

    // =============================
    // HARI INI
    // =============================
    $this->reguToday = (clone $baseQuery)
        ->selectRaw('SUM(deliveries.berat_buah) as total_tonase')
        ->whereDate('tanggal_pengiriman', $today)
        ->orderBy('total_tonase', 'desc')
        ->get();

    // =============================
    // MINGGU INI (Senin – Minggu)
    // =============================
    $this->reguWeek = (clone $baseQuery)
        ->selectRaw('SUM(deliveries.berat_buah) as total_tonase')
        ->whereBetween('tanggal_pengiriman', [$weekStart, $weekEnd])
        ->orderBy('total_tonase', 'desc')
        ->get();

    // =============================
    // BULAN INI
    // =============================
    $this->reguMonth = (clone $baseQuery)
        ->selectRaw('SUM(deliveries.berat_buah) as total_tonase')
        ->whereMonth('tanggal_pengiriman', $month)
        ->whereYear('tanggal_pengiriman', $year)
        ->orderBy('total_tonase', 'desc')
        ->get();

    // =============================
    // TAHUN INI
    // =============================
    $this->reguYear = (clone $baseQuery)
        ->selectRaw('SUM(deliveries.berat_buah) as total_tonase')
        ->whereYear('tanggal_pengiriman', $year)
        ->orderBy('total_tonase', 'desc')
        ->get();

    // =============================
    // KELOMPOKKAN PER PG
    // =============================
    $this->pg1Today  = $this->reguToday->whereIn('id_regu', $this->pg1);
    $this->pg2Today  = $this->reguToday->whereIn('id_regu', $this->pg2);
    $this->pg3Today  = $this->reguToday->whereIn('id_regu', $this->pg3);

    $this->pg1Week   = $this->reguWeek->whereIn('id_regu', $this->pg1);
    $this->pg2Week   = $this->reguWeek->whereIn('id_regu', $this->pg2);
    $this->pg3Week   = $this->reguWeek->whereIn('id_regu', $this->pg3);

    $this->pg1Month  = $this->reguMonth->whereIn('id_regu', $this->pg1);
    $this->pg2Month  = $this->reguMonth->whereIn('id_regu', $this->pg2);
    $this->pg3Month  = $this->reguMonth->whereIn('id_regu', $this->pg3);

    $this->pg1Year   = $this->reguYear->whereIn('id_regu', $this->pg1);
    $this->pg2Year   = $this->reguYear->whereIn('id_regu', $this->pg2);
    $this->pg3Year   = $this->reguYear->whereIn('id_regu', $this->pg3);
}

    public function render()
    {
        $this->monitorTonase();
        $this->tableRegu();

        return view('livewire.tools.monitor-tonase');
    }
}
