<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ContentValidationRule extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_validation_rules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_at',
        'deleted_at',
        'description',
        'name',
        'updated_at',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'created_at',
        'id',
        'description',
        'name',
    ];

    // RELATIONSHIPS

    public function content_fields(): HasManyThrough
    {
        return $this->hasManyThrough(
            ContentField::class,
            ContentFieldContentValidationRule::class,
            'content_validation_rule_id',
            'content_field_id',
            'id',
            'id'
        );
    }

    public function content_field_content_validation_rules(): HasMany
    {
        return $this->hasMany(
            ContentFieldContentValidationRule::class,
            'content_validation_rule_id',
            'id'
        );
    }

    public function content_types(): HasManyThrough
    {
        return $this->hasManyThrough(
            ContentType::class,
            ContentTypeContentValidationRule::class,
            'content_validation_rule_id',
            'content_type_id',
            'id',
            'id'
        );
    }

    public function content_type_content_validation_rules(): HasMany
    {
        return $this->hasMany(
            ContentTypeContentValidationRule::class,
            'content_validation_rule_id',
            'id'
        );
    }
}
