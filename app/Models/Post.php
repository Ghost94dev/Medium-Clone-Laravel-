<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        //'image',
        'user_id',
        'published_at',
    ];

     protected $casts = [
        'published_at' => 'datetime',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->width(400)
            ->nonQueued();
        $this
            ->addMediaConversion('large')
            ->width(1200)
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->singleFile();
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function readTime($wordPerMinute = 100)
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / $wordPerMinute); // Assuming average reading speed of 200 words per minute
        return max(1, $minutes);
    }


   public function imageUrl(string $conversion = ''): ?string
{
    $media = $this->getFirstMedia('default');

    if (! $media) {
        return null;
    }

    if ($conversion && $media->hasGeneratedConversion($conversion)) {
        return $media->getUrl($conversion);
    }

    return $media->getUrl();
}

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function claps()
    {
        return $this->hasMany(Clap::class);
    } 

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }


    
}
