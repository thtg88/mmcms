<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoEntry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'seo_entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_at',
        'deleted_at',
        'facebook_description',
        'facebook_image',
        'facebook_title',
        'json_schema',
        'meta_description',
        'meta_robots_follow',
        'meta_robots_index',
        'meta_title',
        'page_title',
        'target_id',
        'target_table',
        'twitter_description',
        'twitter_image',
        'twitter_title',
        'updated_at',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'created_at',
        'deleted_at',
        'facebook_description',
        'facebook_image',
        'facebook_title',
        'id',
        'json_schema',
        'meta_description',
        'meta_robots_follow',
        'meta_robots_index',
        'meta_title',
        'page_title',
        'target',
        'target_id',
        'target_table',
        'twitter_description',
        'twitter_image',
        'twitter_title',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
        'target_id'  => 'integer',
        'updated_at' => 'datetime',
    ];

    // RELATIONSHIPS

    public function target(): MorphTo
    {
        return $this->morphTo(null, 'target_table');
    }
}
