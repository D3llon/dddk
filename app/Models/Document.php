<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    const TYPE_DOG = 'dog';
    const TYPE_STATION = 'station';
    const TYPE_EVENT = 'event';
    const TYPE_EVENT_REGISTRATION = 'event-registration';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dog()
    {
        return $this->belongsTo(Dog::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function breedingStation()
    {
        return $this->belongsTo(BreedingStation::class);
    }
}