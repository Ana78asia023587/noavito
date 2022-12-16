<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryEditScreen extends Screen
{
    private Category $item;

    public function query(Category $item): iterable
    {
        $this->item = $item;

        return [
            'item' => $item,
        ];
    }

    public function name(): ?string
    {
        return 'Категория';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('save'),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->item->exists),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('item.name')
                    ->type('text')
                    ->title('Название')
                    ->required(),
            ]),
        ];
    }

    public function save(Request $request): RedirectResponse
    {
        Category::query()->findOrNew($request->route('item'))->fill($request->get('item'))->save();

        Toast::info('Запись сохранена');

        return redirect()->route('platform.category');
    }

    public function remove(Category $item): RedirectResponse
    {
        $item->delete();

        Toast::info('Запись удалена');

        return redirect()->route('platform.category');
    }
}
