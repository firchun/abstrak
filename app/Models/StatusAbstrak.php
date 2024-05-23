<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusAbstrak extends Model
{
    use HasFactory;
    protected $table = 'status_abstrak';
    protected $guearded = [];

    public function abstrak(): BelongsTo
    {
        return $this->belongsTo(Abstrak::class, 'id_abstrak');
    }
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_staff');
    }
}
