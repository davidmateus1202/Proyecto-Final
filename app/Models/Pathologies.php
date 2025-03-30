<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pathologies extends Model
{
    protected $fillable = [
        'slab_id',
        'name',
        'url_image',
        'long_damage',
        'type_long_damage',
        'width_damage',
        'type_width_damage',
        'repair_long',
        'type_repair_long',
        'repair_width',
        'type_repair_width',
        'type_damage'
    ];

    public function abscisaById()
    {
        
    }

    
}
