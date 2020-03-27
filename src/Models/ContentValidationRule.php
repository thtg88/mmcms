<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Support\Facades\Config;

class ContentValidationRule extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_validation_rules';

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
        'content_migration_method_id',
        'created_at',
        'description',
        'name',
        'priority',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'content_migration_method',
        'content_migration_method_id',
        'created_at',
        'id',
        'description',
        'name',
        'priority',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'content_migration_method',
    ];

    // RELATIONSHIPS

    public function content_migration_method()
    {
        return $this->belongsTo(
            Config::get('mmcms.models.namespace').'ContentMigrationMethod',
            'content_migration_method_id',
            'id'
        );
    }

    public function content_types()
    {
        return $this->hasManyThrough(
            Config::get('mmcms.models.namespace').'ContentType',
            Config::get('mmcms.models.namespace').'ContentTypeContentValidationRule',
            'content_validation_rule_id',
            'content_type_id',
            'id',
            'id'
        );
    }
}
