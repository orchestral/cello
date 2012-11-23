jQuery(function startCello($) { 'use strict';
	var title, slug, ev;

	ev    = Javie.Events.make();
	title = $('#title');
	slug  = $('#slug');

	// @todo, ev.listener can be replace with ev.listen.
	ev.listener('cello.update: slug', function (title, slug) {
		var val;

		val = title.val();

		if (_.isUndefined(val)) return ;

		val = title.val().toLowerCase()
				.replace(/[^\w ]+/g, '-')
				.replace(/ +/g,'-');

		slug.val(val);
	});

	title.on('keyup', function titleOnKeyUp() {
		ev.fire('cello.update: slug', [title, slug]);
	});

	$('*[role="redactor"]').redactor();

	ev.fire('cello.update: slug', [title, slug]);
});
