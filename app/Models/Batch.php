<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $primaryKey = 'id_batch';
    protected $guarded = [];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
}
