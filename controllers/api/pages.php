<?php

use \Config,
	Cello\Model\Page,
	Orchestra\Form, 
	Orchestra\Messages,  
	Orchestra\Table,
	Orchestra\View;

class Cello_Api_Pages_Controller extends Controller 
{
	public $restful = true;

	public function get_index()
	{
		$pages = Page::with('users')->where_not_null('id');

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
					return '<strong>'.$row->title.'</strong>';
				};
			});

			$table->column('author', function ($column)
			{
				$column->value = function ($row) 
				{
					return ( ! is_null($row->users) ? $row->users->fullname : '');
				};
			});

			$table->column('action', function ($column)
			{
				$column->value = function ($row)
				{
					$html = array(
						'<div class="btn-group">',
						HTML::link(handles('cello::'.$row->slug), 'View', array('class' => 'btn btn-mini')),
						HTML::link(handles('orchestra::resources/cello.pages/view/'.$row->id), 'Edit', array('class' => 'btn btn-mini btn-warning')),
						HTML::link(handles('orchestra::resources/cello.pages/delete/'.$row->id), 'Delete', array('class' => 'btn btn-mini btn-danger')),
						'</div>',
					);

					return implode('', $html);
				};
			});
		});

		$data = array(
			'eloquent'  => $pages,
			'table'     => $table,
			'page_name' => 'Cello CMS',
			'page_desc' => 'List of Pages',
		);

		return View::make('cello::api.resources.index', $data);
	}

	public function get_view($id = null)
	{
		$type = 'update';
		$page = Page::find($id);

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
			'eloquent'  => $page,
			'form'      => $form,
			'page_name' => 'Cello CMS',
			'page_desc' => __("cello::title.pages.{$type}")->get(),
		);

		return View::make('cello::api.resources.edit', $data);
	}

	public function post_view($id = null)
	{
		$input         = Input::all();
		$slug          = ! empty($input['slug']) ? $input['slug'] : '';
		$input['slug'] = Str::slug($slug, '-');
		$page_id       = $id ?: '0';

		$rules         = array(
			'title'   => 'required',
			'slug'    => array("unique:cello_pages,slug,{$page_id}"),
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
}