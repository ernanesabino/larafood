<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['name', 'description'];

    
    /** 
     * Método que faz relacionamento many-to-many com permissions
     * 
     * Get Permissions
    */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
