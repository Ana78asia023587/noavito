<?php

namespace App\Console\Commands\Card;

use App\Models\Card;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class RepublishCards extends Command
{
    protected $signature = 'card:republish';

    protected $description = 'Публикация объвлений pro пользователей';

    public function handle()
    {
        /** @var Card[]|Collection $cards */
        $cards = Card::query()->whereHas('user', function (Builder $builder) {
            return $builder->whereHas('roles', function (Builder $builder) {
                return $builder->where('slug', 'pro-user');
            });
        })->get();

        foreach ($cards as $card) {
            $card->publish();
            $card->save();
        }
    }
}
