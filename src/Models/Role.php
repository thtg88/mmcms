<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_at',
        'display_name',
        'name',
        'priority',
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
        'display_name',
        'name',
        'priority',
    ];

    // RELATIONSHIPS

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
