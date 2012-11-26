<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />

	<title>{{ HTML::title(isset($_title_) ? $_title_ : '') }}</title>

	<?php

	$asset = Asset::container('cello.frontend');

	$asset->style('foundation', 'bundles/cello/vendor/foundation/stylesheets/foundation.min.css');

	$asset->script('jquery', 'bundles/orchestra/js/jquery.min.js');
	$asset->script('modernizr', 'bundles/cello/vendor/foundation/javascripts/modernizr.foundation.js'); ?>

	{{ $asset->styles() }}
	{{ $asset->scripts() }}

</head>
<body>
	<div class="row">
		<div class="twelve columns">
			<h2>{{ memorize('site.name') }}<h2>
			<p>{{ memorize('site.description') }}</p>
			<hr />
		</div>
	</div>


	@yield('content')

</body>
</html>
