<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Config\Repository as Config;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'deleted_at',
        'updated_at',
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
