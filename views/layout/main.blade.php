<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />

	<title>{{ HTML::title(isset($_title_) ? $_title_ : '') }}</title>

	<?php

	$asset = Asset::container('cello.frontend');

	$asset->style('foundation', 'bundles/cello/vendor/foundation/stylesheets/foundation.min.css');
	$asset->style('cello', 'bundles/cello/css/cello-style.css', array('foundation'));

	$asset->script('jquery', 'bundles/orchestra/jquery.min.js');
	$asset->script('modernizr', 'bundles/cello/vendor/foundation/javascripts/modernizr.foundation.js'); ?>

	{{ $asset->styles() }}
	{{ $asset->scripts() }}

</head>
<body>
	<div class="row">
		<div class="twelve columns">
			<h1>{{ memorize('site.name') }} <small>{{ memorize('site.description') }}</small>
			<hr />
		</div>
	</div>


<div class="row">

	<div class="twelve columns" role="content">

		<article>
			@yield('content')
		</article>

	</div>
</div>

	<footer class="row">
		<div class="twelve columns">
			<hr />
			<div class="row">
				<div class="six columns">
					<p>&copy; Copyright no one at all. Go to town.</p>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>