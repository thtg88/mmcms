<?php

namespace Thtg88\MmCms\Models;

class ContentType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_types';

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
        'content_validation_rules',
        'created_at',
        'description',
        'id',
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
        'content_validation_rules',
    ];

    // RELATIONSHIPS

    public function content_migration_method()
    {
        return $this->belongsTo(
            config('mmcms.models.namespace').'ContentMigrationMethod',
            'content_migration_method_id',
            'id'
        );
    }

    public function content_validation_rules()
    {
        return $this->hasManyThrough(
            config('mmcms.models.namespace').'ContentValidationRule',
            config('mmcms.models.namespace').'ContentTypeContentValidationRule',
            'content_type_id',
            'id',
            'content_validation_rule_id',
            'id'
        );
    }
}
