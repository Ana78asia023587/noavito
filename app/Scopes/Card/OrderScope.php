<?php

namespace App\Scopes\Card;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrderScope implements Scope
{
    public function apply(Builder $builder, Model $model): Builder
    {
        return $builder->orderByRaw('published_date DESC NULLS LAST');
    }
}
