<?php

namespace App\Models;

use Approval\Traits\RequiresApproval;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Photo extends Model
{
    use HasFactory, CrudTrait, SoftDeletes, RevisionableTrait;

    protected $guarded = ['id'];
    protected bool $revisionCreationsEnabled = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dogs()
    {
        return $this->belongsToMany(Dog::class, 'dog_photos');
    }
}
