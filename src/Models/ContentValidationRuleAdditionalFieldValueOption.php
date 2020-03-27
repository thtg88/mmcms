<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Support\Facades\Config;

class ContentValidationRuleAdditionalFieldValueOption extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_validation_rule_additional_field_value_options';

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
        'content_validation_rule_additional_field_id',
        'created_at',
        'is_empty_option',
        'text',
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

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        //
    ];

    // RELATIONSHIPS

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
