@layout(locate('cello::layout.main'))

@section('content')
<div class="row">
	<div class="eight columns">
		<h3>{{ $page->title }}</h3>
		{{ $page->content }}
	</div>

	<div class="four columns">
		@placeholder('cello.sidebar')
	</div>
</div>
@endsection