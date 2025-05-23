<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'url',
        'start_lat',
        'start_lng',
        'end_lat',
        'end_lng',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_projects');
    }

    /**
     * Get single abscisa in progress
     */
    public function abscisaInProgress()
    {
        return $this->hasOne(Abscisa::class)
            ->where('status', 'in_progress')
            ->with('slabs');
    }

    /**
     * Get all abscisas by project id
     */
    public function abscisas()
    {
        return $this->hasMany(Abscisa::class)
            ->with('slabsWithPathologies');
    }
}
