<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'user_id',
        'slug',
        'name',
        'phone',
        'roles',
        'company_name',
        'company_logo',
        'show_in_home',
        'offer_end_in',
        'address'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function valueOffers()
    {
        return $this->hasMany(ValueOffer::class);
    }
    public function participant()
    {
        return $this->hasMany(Participant::class);
    }
    public function sluggable() :array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
