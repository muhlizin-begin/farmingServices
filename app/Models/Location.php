<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';
    protected $guarded = ['id_lokasi'];
    protected $primaryKey = 'id_lokasi';

    public function delivery()
    {
        return $this->hasMany(Team::class, 'id_pengiriman');
    }
}
