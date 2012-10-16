<?php namespace Cello\Model;

use \Eloquent;

class Page extends Eloquent 
{
	const STATUS_DRAFT   = 'draft';
	const STATUS_PUBLISH = 'publish';
	const STATUS_PRIVATE = 'private';

	public static $table = 'cello_pages';

	public static function status_list()
	{
		return array(
			static::STATUS_DRAFT   => __('cello::status.'.static::STATUS_DRAFT)->get(),
			static::STATUS_PUBLISH => __('cello::status.'.static::STATUS_PUBLISH)->get(),
			static::STATUS_PRIVATE => __('cello::status.'.static::STATUS_PRIVATE)->get(),
		);
	}

	public function users()
	{
		return $this->belongs_to('Orchestra\Model\User', 'user_id');
	}

	/**
	 * Getter for `meta`
	 */
	public function get_meta()
	{
		return unserialize($this->get_attribute('meta'));
	}
	
	/**
	 * Setter for `meta`
	 */
	public function set_meta($meta)
	{
		$this->set_attribute('meta', serialize($meta));
	}
}