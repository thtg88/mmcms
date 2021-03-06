<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ContentType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_types';

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
        'updated_at',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'content_migration_method',
        'content_migration_method_id',
        'content_type_content_validation_rules',
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
        'content_type_content_validation_rules.content_validation_rule',
    ];

    // RELATIONSHIPS

    public function content_migration_method(): BelongsTo
    {
        return $this->belongsTo(
            ContentMigrationMethod::class,
            'content_migration_method_id',
            'id'
        );
    }

    public function content_type_content_validation_rules(): HasMany
    {
        return $this->hasMany(
            ContentTypeContentValidationRule::class,
            'content_type_id',
            'id'
        );
    }

    public function content_validation_rules(): HasManyThrough
    {
        return $this->hasManyThrough(
            ContentValidationRule::class,
            ContentTypeContentValidationRule::class,
            'content_type_id',
            'id',
            'content_validation_rule_id',
            'id'
        );
    }
}
