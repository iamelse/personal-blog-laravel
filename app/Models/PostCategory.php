<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Yogameleniawan\SearchSortEloquent\Traits\Searchable;
use Yogameleniawan\SearchSortEloquent\Traits\Sortable;

class PostCategory extends Model
{
    use HasFactory, Sluggable, Searchable, Sortable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the formmated user's created_at.
     * @return Attribute
     */
    protected function formattedCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at
                ? Carbon::parse($this->created_at)->format('d M, Y H:i')
                : '[null]'
        );
    }

    /**
     * Get the formmated user's updated_at.
     * @return Attribute
     */
    protected function formattedUpdatedAt(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->updated_at
                ? Carbon::parse($this->updated_at)->format('d M, Y H:i')
                : '[null]'
        );
    }
}
