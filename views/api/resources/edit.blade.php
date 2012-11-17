@include(locate('cello::api.widgets.menu'))

<div class="row-fluid">

	<div class="page-header">
		<h2>{{ isset($_title_) ? $_title_ : 'Cello CMS' }}
			@if ( ! empty($_description_))
			<small>{{ $_description_ ?: '' }}</small>
			@endif
		</h2>
	</div>

	{{ $form }}

</div>
