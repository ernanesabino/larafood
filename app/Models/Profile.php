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

    /** 
     * Permission not linked with this profile
    */
    public function permissionsAvailable()
    {

        $permissions = Permission::whereNotIn('id', function($query){
            $query->select('permission_profile.permission_id');
            $query->from('permission_profile');
            $query->whereRaw("permission_profile.profile_id={$this->id}");
        })
        ->paginate();

        return $permissions;                    
    }
}
