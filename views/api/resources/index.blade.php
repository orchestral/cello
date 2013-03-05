@include(locate('cello::api.widgets.menu'))

<div class="row-fluid">
	<?php Orchestra\Site::set('header::add-button', true); ?>
	@include(locate('orchestra::layout.widgets.header'))
	{{ $table }}
</div>