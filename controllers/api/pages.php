<?php

use \Config,
	Cello\Model\Page,
	Orchestra\Form, 
	Orchestra\HTML,
	Orchestra\Messages,  
	Orchestra\Table,
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
		$pages = Page::with('users')
					->where_not_in('status', array(Page::STATUS_DELETED));

		$pages = $pages->paginate(30);

		$table = Table::of('cello.pages', function ($table) use ($pages)
		{
			$table->empty_message = __('orchestra::label.no-data')->get();

			// Add HTML attributes option for the table.
			$table->attr('class', 'table table-bordered table-striped');

			// attach Model and set pagination option to true
			$table->with($pages, true);

			// Add columns
			$table->column('title', function ($column)
			{
				$column->value = function ($row) 
				{
					return HTML::create('strong', $row->title);
				};
			});

			$table->column('author', function ($column)
			{
				$column->value = function ($row) 
				{
					return ( ! is_null($row->users) ? $row->users->fullname : '');
				};
			});

			$table->column('status', function ($column)
			{
				$column->value = function ($row) 
				{
					return Str::title($row->status);
				};
			});

			$table->column('action', function ($column)
			{
				$column->value = function ($row)
				{
					$html = array(
						HTML::link(handles('cello::'.$row->slug), 'View', array('class' => 'btn btn-mini')),
						HTML::link(handles('orchestra::resources/cello.pages/view/'.$row->id), 'Edit', array('class' => 'btn btn-mini btn-warning')),
						HTML::link(handles('orchestra::resources/cello.pages/delete/'.$row->id), 'Delete', array('class' => 'btn btn-mini btn-danger')),
					);

					return HTML::create('div', HTML::raw(implode('', $html)), array('class' => 'btn-group'));
				};
			});
		});

		$data = array(
			'eloquent' => $pages,
			'table'    => $table,
		);

		View::share('_title_', __('cello::title.pages.list')->get());

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
		$page = Page::where('id', '=', $id)
					->or_where('slug', '=', $id)
					->first();

		if (is_null($page))
		{
			$type = 'create';
			$page = new Page;
		}

		$form = Form::of('cello.pages', function ($form) use ($page)
		{
			$form->row($page);
			$form->attr(array(
				'action' => handles('orchestra::resources/cello.pages/view/'.$page->id),
				'method' => 'POST',
			));

			$form->fieldset(function ($fieldset) 
			{
				$fieldset->control('input:text', __('cello::label.title')->get(), function ($control)
				{
					$control->name = 'title';
					$control->attr = array('class' => 'span12 !span4');
				});

				$fieldset->control('textarea', __('cello::label.content')->get(), function ($control)
				{
					$control->name = 'content';
					$control->attr = array('class' => 'span12 !span4', 'role' => 'redactor'); 
				});

				$fieldset->control('select', __('cello::label.status')->get(), function ($control)
				{
					$control->name    = 'status';
					$control->attr    = array('class' => 'span2 !span4');
					$control->options = Page::status_list();
				});

				$fieldset->control('input:text', handles('cello'), 'slug');
			});
		});

		$data = array(
			'eloquent' => $page,
			'form'     => $form,
		);

		View::share('_title_', __("cello::title.pages.{$type}")->get());

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

		$rules         = array(
			'title'   => 'required',
			'slug'    => array('required', 'min:2', 'match:/[a-z0-9\-]+/', "unique:cello_pages,slug,{$page_id}"),
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

		$m->add('success', __("cello::response.pages.{$type}"));

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
			$m->add('error', __('orchestra::response.db-404')->get());
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

				$m->add('success', __('cello::response.pages.delete')->get());
			}
			catch (Exception $e)
			{
				$m->add('error', __('orchestra::response.db-failed')->get());
			}
		}

		return Redirect::to(handles('orchestra::resources/cello.pages'))
				->with('message', $m->serialize());
	}
}