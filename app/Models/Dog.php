<?php

namespace App\Models;

use Approval\Traits\RequiresApproval;
use Awobaz\Compoships\Compoships;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Dog extends Model
{
    use HasFactory, CrudTrait, SoftDeletes, RevisionableTrait, RequiresApproval;

    protected $guarded = ['id'];
    protected bool $revisionCreationsEnabled = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->deleteWhenDisapproved = true;
    }

    protected function requiresApprovalWhen($modifications): bool
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            if ($user->hasRole('admin')) {
                return false;
            }
        }

        return $this->id !== null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function sire()
    {
        return $this->belongsTo(Dog::class, 'sire_id');
    }

    public function dam()
    {
        return $this->belongsTo(Dog::class, 'dam_id');
    }

    public function puppies()
    {
        return $this->hasMany(Dog::class, ($this->sex === 'F' ? 'dam_id' : 'sire_id'));
    }

    public function litter()
    {
        return $this->belongsTo(Litter::class);
    }

    public function myLitters()
    {
        return $this->hasMany(Litter::class, ($this->sex === 'F' ? 'dam_id' : 'sire_id'));
    }

    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'dog_photos');
    }

    public function breedingStation()
    {
        return $this->belongsTo(BreedingStation::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function getSiblings()
    {
        if ($this->sire && $this->dam) {
            return Dog::where('dam_id', $this->dam_id)
                ->where('sire_id', $this->sire_id)
                ->where('id', '!=', $this->id)
                ->get();
        }
        return collect();
    }
}
