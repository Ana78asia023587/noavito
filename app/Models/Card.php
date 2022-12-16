<?php

namespace App\Models;

use App\Scopes\Card\ModeratedScope;
use App\Scopes\Card\OrderScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Orchid\Screen\AsSource;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Illuminate\Http\Request;

class Card extends Model
{
    use HasFactory, Favoriteable, AsSource;

    protected $guarded = ['id'];

    protected $casts = [
        'published_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope(new ModeratedScope());
        self::addGlobalScope(new OrderScope());
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favorites(): MorphToMany
    {
        return $this->morphToMany(User::class, 'favoriteable', 'favorites');
    }

    public function getPriceAttribute($price)
    {
        return number_format($price, 2, ',', ' ') . '';
    }

    public function addPhoto(Photo $photo)
    {
        return $this->photos()->save($photo);
    }

    /**
     * Возвращаем список объявлений.
     *
     * @param  \App\Models\Category  $category
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return Builder
     */
    public static function getCards(Category $category, User $user, Request $request)
    {
        if ($category->exists) {
            return static::where('category_id', $category->id)->get();
        }

        if ($user->exists) {
            if ($request->favorites) {
                return $user->getFavoriteItems(Card::class)->get();
            }
            return static::where('user_id', $user->id)->withoutGlobalScope(ModeratedScope::class)->get();
        }

        return static::all();
    }

    /**
     * Возвращаем путь до первого фото из объявления для показа на главной странице.
     *
     * @return string
     */
    public function firstPhotoPath()
    {
        if($this->photos()->first())
            return '/' . $this->photos()->firstOrFail()->thumbnail_path;
        return "/img/no-image-available.jpg";
    }

    public function publish()
    {
        $this->published_date = now();
    }
}
