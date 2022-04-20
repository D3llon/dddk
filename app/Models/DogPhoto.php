<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class DogPhoto extends Model
{
    use HasFactory, CrudTrait, SoftDeletes, RevisionableTrait;

    protected $guarded = ['id'];
    protected $revisionCreationsEnabled = true;

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function dog()
    {
        return $this->belongsTo(Dog::class);
    }
}
