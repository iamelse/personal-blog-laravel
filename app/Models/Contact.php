<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Yogameleniawan\SearchSortEloquent\Traits\Searchable;
use Yogameleniawan\SearchSortEloquent\Traits\Sortable;
use Illuminate\Support\Str;

class Contact extends Model
{
    use HasFactory, Searchable, Sortable;

    protected static function booted()
    {
        static::creating(function ($contact) {
            // slugify nama dan ubah menjadi uppercase
            $name = Str::slug($contact->name, '-'); // ganti spasi jadi dash
            $name = strtoupper($name);

            // format datetime, contoh: 20250917T1430
            $datetime = Carbon::now()->format('Ymd\THi');

            // gabungkan menjadi custom ID
            $contact->custom_id = "MSG-{$name}-{$datetime}";
        });
    }

    protected $guarded = ['id', 'custom_id'];

    public function getRouteKeyName(): string
    {
        return 'custom_id';
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
