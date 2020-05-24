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

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

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

    public function content_type_content_validation_rules()
    {
        return $this->hasMany(
            Config::get('mmcms.models.namespace').'ContentTypeContentValidationRule',
            'content_validation_rule_id',
            'id'
        );
    }
}
