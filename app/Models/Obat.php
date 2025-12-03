<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $primaryKey = 'id_obat';
    protected $guarded = [];

    public function batches()
    {
        return $this->hasMany(Batch::class, 'id_obat');
    }
}
