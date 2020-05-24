<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class ContentTypeContentValidationRule extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_type_content_validation_rules';

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
        'content_type_id',
        'content_validation_rule_id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'content_type_id',
        'content_validation_rule',
        'content_validation_rule_id',
        'created_at',
        'id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'content_validation_rule',
    ];

    // RELATIONSHIPS

    public function content_type(): BelongsTo
    {
        return $this->belongsTo(ContentType::class, 'content_type_id', 'id');
    }

    public function content_validation_rule(): BelongsTo
    {
        return $this->belongsTo(
            ContentValidationRule::class,
            'content_validation_rule_id',
            'id'
        );
    }
}
