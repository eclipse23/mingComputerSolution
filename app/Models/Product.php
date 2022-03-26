<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-image-one')->singleFile();
        $this->addMediaCollection('product-image-two')->singleFile();
        $this->addMediaCollection('product-image-three')->singleFile();
        $this->addMediaCollection('product-image-four')->singleFile();
        $this->addMediaCollection('product-image-five')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->crop('crop-center', 500, 500)
            ->format('png');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function inquires()
    {
        return $this->hasMany(Inquire::class);
    }

    public function images()
    {
        $urls = array(
            0 => count($this->getMedia('product-image-one')) > 1
                ? $this->getMedia('product-image-one')[1]->getUrl()
                : $this->getFirstMediaUrl('product-image-one'),
            1 => count($this->getMedia('product-image-two')) > 1
                ? $this->getMedia('product-image-two')[1]->getUrl()
                : $this->getFirstMediaUrl('product-image-two'),
            2 => count($this->getMedia('product-image-three')) > 1
                ? $this->getMedia('product-image-three')[1]->getUrl()
                : $this->getFirstMediaUrl('product-image-three'),
            3 => count($this->getMedia('product-image-four')) > 1
                ? $this->getMedia('product-image-four')[1]->getUrl()
                : $this->getFirstMediaUrl('product-image-four'),
            4 => count($this->getMedia('product-image-five')) > 1
                ? $this->getMedia('product-image-five')[1]->getUrl()
                : $this->getFirstMediaUrl('product-image-five')
        );

        return $urls;
    }

    public function cartItem()
    {
        return $this->hasOne(CartItem::class);
    }
}
