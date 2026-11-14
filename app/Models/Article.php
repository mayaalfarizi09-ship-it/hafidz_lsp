<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'slug', 'body', 'image'];

    protected static function booted(): void
    {
        static::creating(function (Article $article): void {
            if (blank($article->slug)) {
                $article->slug = str($article->title)->slug();
            }
        });
    }
}
