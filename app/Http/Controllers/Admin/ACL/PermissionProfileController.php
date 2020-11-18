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

    public function permissionsAvailable(Request $request, $idProfile)
    {

        //Recupera o profile através do id. Se não encontrar, faz um redirect back       
        if(! $profile = $this->profile->find($idProfile)) {
            return redirect()->back();
        }

        //Cria o filtro de permissões
        $filters = $request->except('_token');        

        $permissions = $profile->permissionsAvailable($request->filter);

        return view('admin.pages.profiles.permissions.available', compact('profile','permissions', 'filters'));        

    }

    // Vincula permissão ao perfil
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

    // Desvincula permissão do perfil
    public function detachPermissionProfile($idProfile, $idPermission)
    {
        
        //Recupera o perfil pelo id
        $profile = $this->profile->find($idProfile);
        //Recupera a permissão pelo id
        $permission = $this->permission->find($idPermission);
            
        if(!$profile || !$permission) {
            return redirect()->back();
        }

        //Desvincula permissão
        $profile->permissions()->detach($permission);

        return redirect()->route('profiles.permissions', $profile->id);

    }


}
