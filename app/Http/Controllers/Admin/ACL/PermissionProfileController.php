<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionProfileController extends Controller
{

    //Cria o construtor
    protected $profile, $permission;

    public function __construct(Profile $profile, Permission $permission)
    {
        $this->profile = $profile;
        $this->permission = $permission;   
    }

    // Lista as permissões de um perfil
    public function permissions($idProfile)
    {
        //Recupera o profile através do id. Se não encontrar, faz um redirect back
        $profile = $this->profile->find($idProfile);
        if(!$profile) {
            redirect()->back();
        }

        //Se encontrar, recupera as permissões do profile
        $permissions = $profile->permissions()->paginate();

        return view('admin.pages.profiles.permissions.permissions', compact('profile','permissions'));        

    }
}
