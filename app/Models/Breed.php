<?php

namespace App\Models;

use Approval\Traits\RequiresApproval;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Breed extends Model
{
    use HasFactory, CrudTrait, SoftDeletes, RevisionableTrait, RequiresApproval;

    protected $guarded = ['id'];
    protected $revisionCreationsEnabled = true;

//    protected function requiresApprovalWhen($modifications): bool
//    {
//        if (\Auth::user()->hasRole('admin')) {
//            return false;
//        }
//
//        return true;
//    }

    public function dogs()
    {
        return $this->hasMany(Dog::class);
    }

    public function litters()
    {
        return $this->hasMany(Litter::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_breeds');
    }
}
