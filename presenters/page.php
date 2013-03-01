<?php namespace Cello\Presenter;

use \Str,
	\Form as F,
	Cello\Model\Page as P,
	Orchestra\Form,
	Orchestra\HTML,
	Orchestra\Table;

class Page {
	
	/**
	 * View table generator for Cello\Model\Page
	 *
	 * @static
	 * @access public
	 * @param  Cello\Model\Page $model
	 * @return Orchestra\Table
	 */
	public static function table($model)
	{
		return Table::of('cello.pages', function ($table) use ($model)
		{
			$table->empty_message = __('orchestra::label.no-data');

			// Add HTML attributes option for the table.
			$table->attributes('class', 'table table-bordered table-striped');

			// attach Model and set pagination option to true
			$table->with($model, true);

			// Add columns
			$table->column('title', function ($column)
			{
				$column->value(function ($row)
				{
					return HTML::create('strong', $row->title);
				});
			});

			$table->column('author', function ($column)
			{
				$column->value(function ($row)
				{
					return ( ! is_null($row->users) ? $row->users->fullname : '');
				});
			});

			$table->column('status', function ($column)
			{
				$column->value(function ($row)
				{
					return Str::title($row->status);
				});
			});

			$table->column('action', function ($column)
			{
				$column->label_attributes(array('class' => 'th-action'));
				$column->value(function ($row)
				{
					// @todo need to use language string for this.
					$html = array(
						HTML::link(
							handles('cello::'.$row->slug),
							__('orchestra::label.view'),
							array('class' => 'btn btn-mini')
						),
						HTML::link(
							handles('orchestra::resources/cello.pages/view/'.$row->id),
							__('orchestra::label.edit'),
							array('class' => 'btn btn-mini btn-warning')
						),
						HTML::link(
							handles('orchestra::resources/cello.pages/delete/'.$row->id),
							__('orchestra::label.delete'),
							array('class' => 'btn btn-mini btn-danger')
						),
					);

					return HTML::create('div', HTML::raw(implode('', $html)), array('class' => 'btn-group'));
				});
			});
		});
	}

	/**
	 * View form generator for Cello\Model\Page
	 * 
	 * @static
	 * @access public
	 * @param  Cello\Model\Page $model
	 * @return Orchestra\Form
	 */
	public static function form($model)
	{
		return Form::of('cello.pages', function ($form) use ($model)
		{
			$form->row($model);
			$form->attributes(array(
				'action' => handles('orchestra::resources/cello.pages/view/'.$model->id),
				'method' => 'POST',
			));

			$form->fieldset(function ($fieldset)
			{
				$fieldset->control('input:text', 'title', function ($control)
				{
					$control->label(__('cello::label.title'));
					$control->attributes(array('class' => 'span12 !span4'));
				});

				$fieldset->control('textarea', 'content', function ($control)
				{
					$control->label(__('cello::label.content'));
					$control->attributes(array('class' => 'span12 !span4', 'role' => 'redactor'));
				});

				$fieldset->control('select', 'status', function ($control)
				{
					$control->label(__('cello::label.status'));
					$control->attributes(array('class' => 'span2 !span4'));
					$control->options(P::status_list());
				});

				$fieldset->control('input:text', 'slug', function($control)
				{
					$control->label(__('cello::label.slug'));
					$control->field(function ($row, $self)
					{
						$url = HTML::create('span', handles('cello::'), array(
							'role'  => 'base-permalink',
							'class' => 'add-on',
						));

						$slug = F::text('slug', $row->slug, array(
							'role' => 'slug-editor',
						));

						return HTML::create('div', HTML::raw($url.$slug), array(
							'class' => 'input-prepend'
						));
					});
				});
			});
		});
	}
}