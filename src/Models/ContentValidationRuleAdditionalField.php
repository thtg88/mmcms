<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class ContentValidationRuleAdditionalField extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_validation_rule_additional_fields';

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
        'created_at',
        'content_validation_rule_additional_field_type_id',
        'content_validation_rule_id',
        'display_name',
        'name',
        'updated_at',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'content_validation_rule_additional_validation_field_type_id',
        'created_at',
        'id',
        'display_name',
        'name',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'content_validation_rule_additional_field_type',
    ];

    // RELATIONSHIPS

    public function content_validation_rule_additional_field_type(): BelongsTo
    {
        return $this->belongsTo(
            ContentValidationRuleAdditionalFieldType::class,
            'content_validation_rule_additional_validation_field_type_id',
            'id'
        );
    }
}
