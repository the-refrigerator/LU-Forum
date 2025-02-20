<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the posts for the thread, sorted by creation date.
     */
    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'desc');
    }
}
