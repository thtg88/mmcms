<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ContentValidationRuleAdditionalFieldValueOption extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_validation_rule_additional_field_value_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content_validation_rule_additional_field_id',
        'created_at',
        'is_empty_option',
        'text',
        'updated_at',
        'value',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'content_validation_rule_additional_field_id',
        'created_at',
        'id',
        'is_empty_option',
        'text',
        'value',
    ];

    // RELATIONSHIPS

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
}
