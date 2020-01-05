<?php

namespace Thtg88\MmCms\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Thtg88\MmCms\Models\Role;
use Thtg88\MmCms\Models\JournalEntry;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

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
        'email',
        'name',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'created_at',
        'email',
        'id',
        'name',
        'role',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'role',
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
        return $this->morphMany(JournalEntry::class, 'target');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
