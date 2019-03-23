<?php

namespace SdSomersetDesign\CastleCombe\Models;

class SeoEntry extends Model
{
	protected $table = 'seo_entries';
    protected $primaryKey = 'id';

    protected $fillable = [
	    'created_at',
		'deleted_at',
		'facebook_description',
		'facebook_image',
		'facebook_title',
		'json_schema',
		'meta_description',
		'meta_robots_follow',
		'meta_robots_index',
		'meta_title',
		'page_title',
		'target_id',
		'target_table',
		'twitter_description',
		'twitter_image',
		'twitter_title',
    ];

    protected $visible = [
	    'created_at',
		'deleted_at',
		'facebook_description',
		'facebook_image',
		'facebook_title',
		'id',
		'json_schema',
		'meta_description',
		'meta_robots_follow',
		'meta_robots_index',
		'meta_title',
		'page_title',
		'target',
	    'target_id',
		'target_table',
		'twitter_description',
		'twitter_image',
		'twitter_title',
    ];

	// ACCESSORS OF EXISTING FIELDS

	public function getTargetIdAttributeName($value)
	{
		return abs($value);
	}

	// RELATIONSHIPS

	public function target()
    {
        return $this->morphTo(null, 'target_table');
    }
}
