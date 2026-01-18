<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lesson extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = ['course_id', 'title', 'slug', 'content', 'position', 'is_published'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
