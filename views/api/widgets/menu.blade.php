@section('cello::primary_menu')
<ul class="nav">
	@if (Orchestra\Acl::make('cello')->can('manage-pages'))
	<li class="{{ URI::is('*/resources/cello.pages*') ? 'active' : '' }}">
		{{ HTML::link(handles('orchestra::resources/cello.pages'), 'Pages') }}
	</li>
	@endif
</ul>
@endsection

@section('cello::secondary_menu')
<ul class="nav pull-right">
	<li>
		<a href="{{ handles('cello') }}" target="_blank"><i class="icon-home"></i> Website</a>
	</li>
</ul>
@endsection

<?php

$navbar = new Orchestra\Fluent(array(
	'id'             => 'cello',
	'title'          => 'Cello CMS',
	'url'            => handles('orchestra::resources/cello'),
	'primary_menu'   => Laravel\Section::yield('cello::primary_menu'),
	'secondary_menu' => Laravel\Section::yield('cello::secondary_menu'),
)); ?>

{{ Orchestra\Decorator::navbar($navbar) }}