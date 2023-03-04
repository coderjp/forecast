<?php

namespace Coderjp\Forecast\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Forecast extends Model
{
    use HasFactory;

    protected $fillable = ['ip', 'country', 'city', 'latitude', 'longitude'];

    public function days(): HasMany
    {
        return $this->hasMany(Day::class);
    }
}
