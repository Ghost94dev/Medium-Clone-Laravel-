<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'image',
        'bio',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('avatar')
            ->width(200)
            ->crop(128, 128)
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile();
    }


    public function avatarUrl(string $conversion = 'avatar'): string
    {
        $media = $this->getFirstMedia('avatar');

        if (! $media) {
            return 'https://www.gravatar.com/avatar/' .
                md5(strtolower(trim($this->email))) .
                '?d=mp&s=200';
        }

        return $media->hasGeneratedConversion($conversion)
            ? $media->getUrl($conversion)
            : $media->getUrl();
    }


    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function following(){
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function followers(){
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function isfollowedBy(?User $user){
        if(!$user){
            return false;
        }
        return $this->followers()->where('follower_id', $user->id)->exists();
    } 

    public function hasClapped(Post $post)
    {
        return $post->claps()->where('user_id', $this->id)->exists();

    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    

   
    
}