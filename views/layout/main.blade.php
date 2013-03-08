<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />

	<title>{{ HTML::title() }}</title>

	<?php

	$asset = Asset::container('cello.frontend');

	$asset->style('foundation', 'bundles/orchestra/vendor/foundation/css/foundation.min.css');
	$asset->script('foundation', 'bundles/orchestra/vendor/foundation/js/foundation.min.js'); ?>

	{{ $asset->styles() }}
	{{ $asset->scripts() }}

</head>
<body>
	<div class="row">
		<div class="twelve columns">
			<h2>{{ memorize('site.name') }}</h2>
			<p>{{ memorize('site.description') }}</p>
			<hr />
		</div>
	</div>

	@yield('content')

</body>
</html>
