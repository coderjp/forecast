<?php

namespace Coderjp\Forecast\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Day extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'code', 'temperature'];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public function forecast(): BelongsTo
    {
        return $this->belongsTo(Forecast::class);
    }
}
