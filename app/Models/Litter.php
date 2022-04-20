<?php

namespace App\Models;

use Approval\Traits\RequiresApproval;
use Awobaz\Compoships\Compoships;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Litter extends Model
{
    use HasFactory, CrudTrait, SoftDeletes, RevisionableTrait, RequiresApproval;

    protected $guarded = ['id'];
    protected bool $revisionCreationsEnabled = true;

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function dam()
    {
        return $this->belongsTo(Dog::class, 'dam_id');
    }

    public function sire()
    {
        return $this->belongsTo(Dog::class, 'sire_id');
    }

    public function damOwner()
    {
        return $this->belongsTo(User::class, 'dam_owner_id');
    }

    public function sireOwner()
    {
        return $this->belongsTo(User::class, 'sire_owner_id');
    }
}
