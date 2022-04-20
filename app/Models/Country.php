<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use CrudTrait;

    protected $guarded = ['id'];

    public const municipalities = [
        'Banskobystrický',
        'Bratislavský',
        'Košický',
        'Nitriansky',
        'Prešovský',
        'Trenčiansky',
        'Trnavský',
        'Žilinský'
    ];

    public const alphabet = [
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z'
    ];
}