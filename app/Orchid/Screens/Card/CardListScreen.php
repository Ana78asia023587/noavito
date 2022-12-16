<?php

namespace App\Orchid\Screens\Card;

use App\Http\Utilities\Region;
use App\Models\Card;
use App\Scopes\Card\ModeratedScope;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class CardListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'items' => Card::query()->withoutGlobalScope(ModeratedScope::class)->with('user')->get(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Объявления';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('items', [
                TD::make('title', 'Название'),
                TD::make('region', 'Регион')->render(fn(Card $item) => Region::all()[$item->region]),
                TD::make('city', 'Город'),
                TD::make('price', 'Цена'),
                TD::make('description', 'Описание'),
                TD::make('user.name', 'Пользователь'),
                TD::make('is_moderated', 'Одобрить')->render(
                    fn(Card $item) =>
                    $item->is_moderated ? 'Одобрено' :
                        Button::make('Одобрить')->method('moderate', ['item' => $item->id])
                ),
            ])
        ];
    }

    public function moderate(Request $request)
    {
        $card = Card::query()->withoutGlobalScope(ModeratedScope::class)->find($request->get('item'));

        $card->is_moderated = 1;
        $card->save();

        return redirect()->back();
    }
}
