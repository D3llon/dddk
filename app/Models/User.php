<?php

namespace App\Models;

use Approval\Traits\ApprovesChanges;
use Approval\Traits\RequiresApproval;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Venturecraft\Revisionable\RevisionableTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, CrudTrait, SoftDeletes, RevisionableTrait, RequiresApproval, ApprovesChanges;

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
            } elseif ($user->id === $this->id) {
                if (array_key_exists('password', $this->getDirty())) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function authorizedToApprove(\Approval\Models\Modification $modification): bool
    {
        return $this->hasRole('admin');
    }

    protected function authorizedToDisapprove(\Approval\Models\Modification $modification): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'street',
        'city',
        'zip',
        'county',
        'municipality',
        'nationality_id',
        'phone',
        'family_membership_parent_id',
        'other_club_membership',
        'spz_membership',
        'is_senior',
        'is_handicapped',
        'accepted_data_publication',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_senior'         => 'boolean',
        'is_handicapped'    => 'boolean'
    ];

    public function breedingStation()
    {
        return $this->belongsTo(BreedingStation::class);
    }

    public function breeds()
    {
        return $this->belongsToMany(Breed::class, 'user_breeds');
    }

    public function dogs()
    {
        return $this->hasMany(Dog::class);
    }

    public function litters()
    {
        return $this->hasMany(Litter::class, ['sire_owner_id', 'dam_owner_id']);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_registrations');
    }

    public function nationality()
    {
        return $this->belongsTo(Country::class, 'nationality_id');
    }

    public function familyMembership()
    {
        return $this->belongsTo(User::class, 'family_membership_parent_id');
    }
}
