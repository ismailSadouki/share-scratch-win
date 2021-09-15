<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'ip',
        'status',
        'reference_code',
        'phone',
        'value_offer_id',
        
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function valueOffer()
    {
        return $this->belongsTo(ValueOffer::class);
    }
}
