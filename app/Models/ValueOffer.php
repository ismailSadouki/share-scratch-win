<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValueOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'image',
        'value',
        'will_get'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
