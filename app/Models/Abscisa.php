<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abscisa extends Model
{
    protected $fillable = ['name', 'number_of_abscisas' , 'project_id', 'status'];

    
    public function slabs()
    {
        return $this->hasMany(Slabs::class, 'abscisa_id');
    }
}
