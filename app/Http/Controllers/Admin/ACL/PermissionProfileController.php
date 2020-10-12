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
            return redirect()->back();
        }

        //Se encontrar, recupera as permissões do profile
        $permissions = $profile->permissions()->paginate();

        return view('admin.pages.profiles.permissions.permissions', compact('profile','permissions'));        

    }

    public function permissionsAvailable($idProfile)
    {

        //Recupera o profile através do id. Se não encontrar, faz um redirect back       
        if(! $profile = $this->profile->find($idProfile)) {
            return redirect()->back();
        }

        $permissions = $this->permission->paginate();

        return view('admin.pages.profiles.permissions.available', compact('profile','permissions'));        

    }

    public function attachPermissionsProfile(Request $request, $idProfile)
    {

        //Recupera o profile através do id. Se não encontrar, faz um redirect back       
        if(! $profile = $this->profile->find($idProfile)) {
            return redirect()->back();
        }

        //Valida as permissões
        if(!$request->permissions || count($request->permissions) == 0) {
            return redirect()
                        ->back()
                        ->with('info', 'Escolha ao menos uma permissão');
        }

        //Vinvula as permissões ao perfil
        $profile->permissions()->attach($request->permissions);
        
        return redirect()->route('profiles.permissions', $profile->id);

    }
}
