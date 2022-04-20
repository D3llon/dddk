<?php

namespace App\Models;

use Approval\Traits\RequiresApproval;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class BreedingStation extends Model
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
        if (empty($modifications)) {
            return false;
        } elseif (\Auth::check()) {
            $user = \Auth::user();
            if ($user->hasRole('admin')) {
                return false;
            }
        }

        return $this->id !== null;
    }

    public function dogs()
    {
        return $this->hasMany(Dog::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
