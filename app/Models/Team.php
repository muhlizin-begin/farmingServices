<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'teams';
    protected $guarded = ['id_regu'];
    protected $primaryKey = 'id_regu';

    public function delivery()
    {
        return $this->hasMany(Team::class, 'id_pengiriman');
    }
}
