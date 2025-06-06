<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = ['title', 'content', 'image_url', 'scheduled_time', 'status', 'user_id'];
    protected $hidden = [];
    public $timestamps = true;
    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'post_platform')
                    ->withPivot('platform_status')
                    ->withTimestamps();
    }

    public function getImagePathAttribute(): string | null
    {
        return $this['image_url'] ? asset('uploads/posts/'. $this['image_url']) : null;
    }
}
