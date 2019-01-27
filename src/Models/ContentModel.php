<?php

namespace Thtg88\MmCms\Models;

class ContentModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_models';

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
        'base_route_name',
        'created_at',
        'description',
        'model_name',
        'name',
        'table_name',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'base_route_name',
        'content_fields',
        'created_at',
        'description',
        'id',
        'model_name',
        'name',
        'table_name',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'content_fields',
    ];

    // RELATIONSHIPS

    public function content_fields()
    {
        return $this->hasMany(config('mmcms.models.namespace').'ContentField', 'content_model_id', 'id');
    }
}
