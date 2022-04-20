<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Event extends Model
{
    use HasFactory, CrudTrait, SoftDeletes, RevisionableTrait;

    protected $guarded = ['id'];
    protected bool $revisionCreationsEnabled = true;

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'event_registrations');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function getRegistrationAttribute()
    {
        return Document::where('event_id', $this->id)->where('type', Document::TYPE_EVENT)->first()?->path;
    }

//    protected function registration(): Attribute
//    {
//        return new Attribute(
//            get: fn ($value) => $value,
//            set: function ($value) {
//                $attribute_name = "registration";
//                $disk = "public";
//                $destination_path = "documents/events";
//
//
//                $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
//            }
//        );
//    }
}
