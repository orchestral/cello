jQuery(function startCello($) { 'use strict';
	var title, slug, ev;

	ev    = Javie.Events.make();
	title = $('#title');
	slug  = $('input[role="slug-editor"]:first');

	ev.listen('cello.update: slug', function (val) {
		if (_.isUndefined(val)) return ;

		val = val.toLowerCase()
				.replace(/[^\w ]+/g, '-')
				.replace(/ +/g,'-');

		slug.val(val);
		span.text(val);
	});

	title.on('keyup', function titleOnKeyUp() {
		ev.fire('cello.update: slug', [title.val()]);
	});

	slug.on('blur', function slugOnBlur(e) {
		ev.fire('cello.update: slug', [slug.val()]);
	});

	$('*[role="redactor"]').redactor();

	if (slug.val() === '') {
		ev.fire('cello.update: slug', [title.val()]);
	}
});
