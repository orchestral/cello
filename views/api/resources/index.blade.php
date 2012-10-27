@include(theme_path('cello::api.widgets.menu'))

<div class="row-fluid">
	
	<div class="page-header">

		<div class="pull-right">
			<a href="{{ URL::current() }}/view" class="btn btn-primary">Add</a>
		</div>
		<h2>{{ $page_name }}
			@if ( ! empty($page_desc))
			<small>{{ $page_desc ?: '' }}</small>
			@endif
		</h2>
	</div>

	{{ $table }}

</div>