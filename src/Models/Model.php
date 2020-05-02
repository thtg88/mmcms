<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Returns the eager loaded relationship names for the model class.
     *
     * @return array
     */
    public function getWith()
    {
        return $this->with;
    }

    // RELATIONSHIPS

    public function journal_entries()
    {
        return $this->morphMany(
            Config::get('mmcms.models.namespace').'JournalEntry',
            'target'
        );
    }
}
