<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $primaryKey = 'id_activity';
    protected $guarded = [];

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'id_batch');
    }
}
