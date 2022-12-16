<?php

namespace App\Scopes\Card;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ModeratedScope implements Scope
{
    public function apply(Builder $builder, Model $model): Builder
    {
        return $builder->where('is_moderated', 1);
    }
}
