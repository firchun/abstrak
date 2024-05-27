<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileAbstrak extends Model
{
    use HasFactory;
    protected $table = 'file_abstrak';
    protected $guarded = [];
    public function abstrak(): BelongsTo
    {
        return $this->belongsTo(Abstrak::class, 'id_abstrak');
    }
}
