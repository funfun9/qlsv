<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class deleteScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->update(["delete" => "1", 
        "deleted_by"=>Auth::user()->username]);
    }
}