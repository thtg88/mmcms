<?php

namespace Thtg88\MmCMs\Models;

use Illuminate\Support\Facades\Config;

class JournalEntry extends Model
{
    protected $table = 'journal_entries';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action',
        'created_at',
        'deleted_at',
        'target_id',
        'target_table',
        'updated_at',
        'user_id',
        'user_ip_address',
        'content',
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

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        //
    ];

    // RELATIONSHIPS

    public function target()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(
            Config::get('mmcms.models.namespace').'User',
            'user_id',
            'id'
        );
    }
}
