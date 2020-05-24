<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Config;

class Image extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'caption',
        'created_at',
        'deleted_at',
        'image_category_id',
        'name',
        'title',
        'target_id',
        'target_table',
        'url',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'caption',
        'created_at',
        'deleted_at',
        'id',
        // 'image_category',
        'image_category_id',
        'name',
        'title',
        'target_id',
        'target_table',
        'updated_at',
        'url',
    ];

    protected $with = [
        // 'image_category',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
        'image_category_id' => 'integer',
        'target_id' => 'integer',
        'updated_at' => 'datetime',
    ];

    // RELATIONSHIPS

    /**
     * Get all of the owning target models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function target(): MorphTo
    {
        return $this->morphTo(null, 'target_table');
    }

    public function image_category(): BelongsTo
    {
        return $this->belongsTo(
            ImageCategory::class,
            'image_category_id',
            'id'
        );
    }
}
