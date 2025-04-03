<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slabs extends Model
{
    protected $fillable = ['abscisa_id', 'long', 'width', 'type_long', 'type_width', 'latitude', 'longitude'];

    /**
     * Get all pathologies by slab
     */
    public function pathologies()
    {
        return $this->hasMany(Pathologies::class, 'slab_id');
    }
}
