<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'url', 'price', 'description'];

    //Relacionamento um pra muitos entre plano e detalhes 
    //(um plano pode ter vários detalhes e um detalhe é específico de um plano)
    public function details()
    {
        return $this->hasMany(DetailPlan::class);
    }

    public function search($filter = null)
    {
        $results = $this->where('name', 'LIKE', "%{$filter}%")
                        ->orWhere('description', 'LIKE', "%{$filter}%")
                        ->paginate();

        return $results;             
    }
}
