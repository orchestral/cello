@layout(locate('cello::layout.main'))

@section('content')

<h2>{{ $page->title }}</h2>

<div class="row">
	<div class="twelve columns">
		{{ $page->content }}
	</div>
</div>
@endsection