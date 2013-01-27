<?php namespace Cello\Model;

use \Config,
	\Eloquent;

class Page extends Eloquent {

	const STATUS_DRAFT   = 'draft';
	const STATUS_PUBLISH = 'publish';
	const STATUS_PRIVATE = 'private';
	const STATUS_DELETED = 'deleted';

	public static $table = 'cello_pages';

	/**
	 * Get page by id or slug
	 *
	 * @static
	 * @access public
	 * @param  mixed    $id
	 * @return self
	 */
	public static function identity($id)
	{
		return static::where('id', '=', $id)
				->or_where('slug', '=', $id);
	}

	/**
	 * Get available page order by recent updated.
	 *
	 * @static
	 * @access public
	 * @return self
	 */
	public static function recent_available()
	{
		return static::with('users')
				->where_not_in('status', array(static::STATUS_DELETED))
				->order_by('updated_at', 'DESC');
	}

	/**
	 * Available status for a page
	 *
	 * @static
	 * @access public
	 * @return array
	 */
	public static function status_list()
	{
		return array(
			static::STATUS_PUBLISH => __('cello::status.'.static::STATUS_PUBLISH)->get(),
			static::STATUS_PRIVATE => __('cello::status.'.static::STATUS_PRIVATE)->get(),
			static::STATUS_DRAFT   => __('cello::status.'.static::STATUS_DRAFT)->get(),
		);
	}

	/**
	 * Belongs To `users` table
	 *
	 * @access public
	 * @return Orchestra\Model\User
	 */
	public function users()
	{
		return $this->belongs_to(Config::get('auth.model'), 'user_id');
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