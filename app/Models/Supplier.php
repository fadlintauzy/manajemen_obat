<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'id_supplier';
    protected $guarded = [];

    public function batches()
    {
        return $this->hasMany(Batch::class, 'id_supplier');
    }
}
