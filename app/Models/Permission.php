<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'description'];

    /** 
     * Método que faz relacionamento many-to-many com profiles
     * 
     * Get Profiles
    */
    public function profiles()
    {
        return $this->belongsToMany(Profile::class);
    }
}
