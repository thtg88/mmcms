<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class JournalEntry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'journal_entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action',
        'content',
        'created_at',
        'deleted_at',
        'target_id',
        'target_table',
        'updated_at',
        'user_id',
        'user_ip_address',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'action',
        'created_at',
        'id',
        'target',
        'target_id',
        'user',
        'user_id',
        'user_ip_address',
        'content',
    ];

    // RELATIONSHIPS

    public function target(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
