<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends BaseModel
{
    use HasFactory, SoftDeletes;

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
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        $factory_classname = str_replace(
            '\\Models\\',
            '\\Database\\Factories\\',
            get_called_class()
        ).'Factory';

        return call_user_func($factory_classname.'::new');
    }

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

    public function journal_entries(): MorphMany
    {
        return $this->morphMany(JournalEntry::class, 'target');
    }
}
