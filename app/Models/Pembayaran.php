<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran';
    protected $guearded = [];

    public function abstrak(): BelongsTo
    {
        return $this->belongsTo(Abstrak::class, 'id_abstrak');
    }
}
