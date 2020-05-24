<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;

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
        'updated_at',
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

    public function content_fields(): HasMany
    {
        return $this->hasMany(ContentField::class, 'content_model_id', 'id');
    }
}
