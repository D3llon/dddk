<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalAccessToken extends Model
{
    use HasFactory, CrudTrait, SoftDeletes;

    protected $guarded = ['id'];
}
