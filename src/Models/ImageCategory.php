<?php

namespace Thtg88\MmCms\Models;

class ImageCategory extends Model
{
	protected $table = 'image_categories';
    protected $primaryKey = 'id';

    protected $fillable = [
		'created_at',
		'deleted_at',
		'name',
		'sequence',
		'target_table',
    ];

    protected $visible = [
		'created_at',
		'deleted_at',
		'id',
		'name',
		'sequence',
	    'target_table',
    ];

	// ACCESSORS OF EXISTING FIELDS

	public function getSequenceAttributeName($value)
	{
		return abs($value);
	}

	// RELATIONSHIPS

	public function images()
	{
		return $this->hasMany(
			config('mmcms.models.namespace').'Image',
			'target_table',
			'target_table'
		);
	}
}
