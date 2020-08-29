<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPlan extends Model
{
    protected $table = 'details_plan';

    protected $fillable = ['name'];

    //Relacionamento muitos pra um entre detalhes e plano
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
