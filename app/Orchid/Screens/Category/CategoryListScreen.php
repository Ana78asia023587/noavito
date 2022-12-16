<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class CategoryListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'items' => Category::query()->orderBy('name')->get(),
        ];
    }

    public function name(): ?string
    {
        return 'Категории';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить')
                ->href(route('platform.category.create'))
                ->icon('plus'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('items', [
                TD::make('name', 'Название'),
                TD::make('id', 'Действия')->render(
                    fn(Category $item) => Link::make('Редактировать')
                        ->route('platform.category.edit', $item)
                        ->icon('::makepencil')
                ),
            ])
        ];
    }
}
