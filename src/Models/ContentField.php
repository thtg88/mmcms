<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Config;

class ContentField extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_fields';

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
        'content_model_id',
        'content_type_id',
        'created_at',
        'display_name',
        'helper_text',
        'is_mandatory',
        'is_resource_name',
        'name',
        'updated_at',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'content_model_id',
        'content_type',
        'content_type_id',
        'created_at',
        'display_name',
        'helper_text',
        'id',
        'is_mandatory',
        'is_resource_name',
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'content_model_id' => 'integer',
        'content_type_id' => 'integer',
        'is_mandatory' => 'boolean',
        'is_resource_name' => 'boolean',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'content_field_content_validation_rules',
        'content_type',
    ];

    // RELATIONSHIPS

    public function content_field_content_validation_rules(): HasMany
    {
        return $this->hasMany(
            ContentFieldContentValidationRule::class,
            'content_field_id',
            'id'
        );
    }

    public function content_validation_rules(): HasManyThrough
    {
        return $this->hasManyThrough(
            ContentValidationRule::class,
            ContentFieldContentValidationRule::class,
            'content_field_id',
            'id',
            'content_validation_rule_id',
            'id'
        );
    }

    public function content_model(): BelongsTo
    {
        return $this->belongsTo(ContentModel::class, 'content_model_id', 'id');
    }

    public function content_type(): BelongsTo
    {
        return $this->belongsTo(ContentType::class, 'content_type_id', 'id');
    }
}
