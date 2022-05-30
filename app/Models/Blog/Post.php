<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Posts class instance will refer to posts table in database
class Post extends Model
{
    use ElasticquentTrait;

    protected $table = 'posts';
    protected $guarded = [];

    protected $mappingProperties = array(
        'title' => array(
            'type' => 'string',
            'analyzer' => 'standard'
        ),
        'content' => array(
            'type' => 'string',
            'analyzer' => 'standard'
        ),
    );

    public function comments(): HasMany
    {
        return $this->hasMany('App\Models\Blog\Comment', 'on_post');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo('App\Models\Auth\User', 'author_id');
    }
}
