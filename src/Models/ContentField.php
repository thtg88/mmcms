<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Support\Facades\Config;

class ContentField extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_fields';

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
        'content_model_id',
        'content_type_id',
        'created_at',
        'display_name',
        'helper_text',
        'is_resource_name',
        'name',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'content_model_id',
        'content_type',
        'content_type_id',
        'created_at',
        'display_name',
        'helper_text',
        'id',
        'is_resource_name',
        'name',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'content_type',
    ];

    // RELATIONSHIPS

    public function content_model()
    {
        return $this->belongsTo(
            Config::get('mmcms.models.namespace').'ContentModel',
            'content_model_id',
            'id'
        );
    }

    public function content_type()
    {
        return $this->belongsTo(
            Config::get('mmcms.models.namespace').'ContentType',
            'content_type_id',
            'id'
        );
    }
}
