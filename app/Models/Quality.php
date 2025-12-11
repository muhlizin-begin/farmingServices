<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quality extends Model
{
    use HasFactory;

    protected $table = 'qualities';
    protected $guarded = ['id_kwalitas'];
    protected $primaryKey = 'id_kwalitas';

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_lokasi');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'id_regu');
    }
}
