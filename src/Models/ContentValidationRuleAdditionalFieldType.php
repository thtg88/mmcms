<?php

namespace Thtg88\MmCms\Models;

class ContentValidationRuleAdditionalFieldType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_validation_rule_additional_field_types';

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
        'display_name',
        'name',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
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
        //
    ];

    // RELATIONSHIPS

}
