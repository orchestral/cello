jQuery(function startCello($) { 'use strict';
	var title, slug, span, ev;

	ev    = Javie.Events.make();
	title = $('#title');
	slug  = $('input[role="slug-editor"]:first').hide();
	span  = $('span[role="slug"]:first').css('cursor', 'pointer');

	span.on('click', function onClickSlugSpan (e) {
		slug.show();
		span.hide();
	});

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
