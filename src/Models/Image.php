<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Support\Facades\Config;

class Image extends Model
{
    protected $table = 'images';
    protected $primaryKey = 'id';

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
        'url',
    ];

    protected $with = [
        // 'image_category',
    ];

    // ACCESSORS OF EXISTING FIELDS

    public function getImageCategoryIdAttributeName($value)
    {
        return abs($value);
    }

    public function getTargetIdAttributeName($value)
    {
        return abs($value);
    }

    // RELATIONSHIPS

    /**
     * Get all of the owning target models.
     */
    public function target()
    {
        return $this->morphTo(null, 'target_table');
    }

    public function image_category()
    {
        return $this->belongsTo(
            Config::get('mmcms.models.namespace').'ImageCategory',
            'image_category_id',
            'id'
        );
    }
}
