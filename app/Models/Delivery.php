<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'deliveries';
    protected $guarded = ['id_pengiriman'];
    protected $primaryKey = 'id_pengiriman';

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_lokasi');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'id_regu');
    }
}
