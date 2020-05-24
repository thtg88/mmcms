<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;

class ImageCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'image_categories';

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
        'name',
        'sequence',
        'target_table',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'created_at',
        'deleted_at',
        'id',
        'name',
        'sequence',
        'target_table',
        'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
        'sequence' => 'integer',
        'updated_at' => 'datetime',
    ];

    // RELATIONSHIPS

    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'target_table', 'target_table');
    }
}
