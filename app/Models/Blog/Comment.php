<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $guarded = [];
    protected $table = 'comments';

    public function author(): BelongsTo
    {
        return $this->belongsTo('App\Models\Auth\User', 'from_user');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo('App\Models\Blog\Posts', 'on_post');
    }
}
