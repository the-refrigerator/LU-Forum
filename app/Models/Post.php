<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'author_id',
        'thread_id',
    ];

    /**
     * Get the author that owns the post.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the thread that the post belongs to.
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }
}
