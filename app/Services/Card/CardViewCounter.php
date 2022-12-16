<?php

namespace App\Services\Card;

use App\Models\Card;
use Illuminate\Support\Facades\Cookie;

class CardViewCounter
{
    public function increment(Card $card): void
    {
        $cookie = 'view-' . $card->id;

        if (!Cookie::has($cookie)) {
            $card->increment('view_count');
            Cookie::queue($cookie, $card->id);
        }
    }

    private function getCookieName(Card $card): string
    {
        return 'view-' . $card->id;
    }
}
