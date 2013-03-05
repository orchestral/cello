<?php

use \Config,
	Cello\Model\Page,
	Orchestra\Messages,
	Orchestra\Site,
	Orchestra\View;

class Cello_Api_Pages_Controller extends Controller {

	public $restful = true;

	/**
	 * Construct this controller
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'cello::manage-pages');
	}

	/**
	 * Display a list of available pages
	 *
	 * GET (orchestra)/resources/cello.pages
	 *
	 * @access public
	 * @return Response
	 */
	public function get_index()
	{
		$pages = Page::recent_available()->paginate(30);
		$table = Cello\Presenter\Page::table($pages);
		$data  = array(
			'eloquent' => $pages,
			'table'    => $table,
		);

		Site::set('title', __('cello::title.pages.list'));

		return View::make('cello::api.resources.index', $data);
	}

	/**
	 * Show edit a page
	 *
	 * GET (orchestra)/resources/cello.pages/view/(:id)
	 *
	 * @access public
	 * @param  int      $id
	 * @return Response
	 */
	public function get_view($id = null)
	{
		$type = 'update';
		$page = Page::identity($id)->first();

		if (is_null($page))
		{
			$type = 'create';
			$page = new Page;
		}

		$form = Cello\Presenter\Page::form($page);

		$data = array(
			'eloquent' => $page,
			'form'     => $form,
		);

		Site::set('title', __("cello::title.pages.{$type}"));

		return View::make('cello::api.resources.edit', $data);
	}

	/**
	 * Update a page
	 *
	 * POST (orchestra)/resources/cello.pages/view/(:id)
	 *
	 * @access public
	 * @param  int      $id
	 * @return Response
	 */
	public function post_view($id = null)
	{
		$input         = Input::all();
		$slug          = ! empty($input['slug']) ? $input['slug'] : '';
		$input['slug'] = Str::slug($slug, '-');
		$page_id       = $id ?: '0';

		$rules = array(
			'title'   => 'required',
			'slug'    => array(
				'required',
				'min:2',
				'match:/[a-z0-9\-]+/',
				"unique:cello_pages,slug,{$page_id}",
			),
			'content' => 'required',
			'status'  => 'required',
		);

		$m = new Messages;
		$v = Validator::make($input, $rules);

		if ($v->fails())
		{
			return Redirect::to(handles('orchestra::resources/cello.pages/view/'.$id))
					->with_input()
					->with_errors($v);
		}

		$type = 'update';
		$page = Page::find($id);

		if (is_null($page))
		{
			$type = 'create';
			$page = new Page(array(
				'user_id' => Auth::user()->id,
			));
		}

		$page->title   = $input['title'];
		$page->content = $input['content'];
		$page->status  = $input['status'];
		$page->slug    = $input['slug'];

		$page->save();

		$m->add('success', __("cello::response.pages.{$type}", array(
			'name' => $page->title,
		)));

		return Redirect::to(handles('orchestra::resources/cello.pages'))
			->with('message', $m->serialize());
	}

	/**
	 * Delete a page
	 *
	 * GET (orchestra)/resources/cello.pages/delete/(:id)
	 *
	 * @access public
	 * @param  int      $id
	 * @return Response
	 */
	public function get_delete($id = null)
	{
		$m    = new Messages;
		$page = Page::find($id);

		if (is_null($page))
		{
			$m->add('error', __('orchestra::response.db-404'));
		}
		else
		{
			try
			{

				DB::transaction(function () use ($page)
				{
					$page->status = Page::STATUS_DELETED;
					$page->save();
				});

				$m->add('success', __('cello::response.pages.delete', array(
					'name' => $page->title,
				)));
			}
			catch (Exception $e)
			{
				$m->add('error', __('orchestra::response.db-failed'));
			}
		}

		return Redirect::to(handles('orchestra::resources/cello.pages'))
				->with('message', $m->serialize());
	}
}
