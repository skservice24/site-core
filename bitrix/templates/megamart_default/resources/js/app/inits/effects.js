const { Waves } = window;

export default function() {

	// c-icon-count siblings
	$(document).on('mouseenter', '.c-icon-count', function () {

		$(this).velocity({
			opacity: 1
		}, {
			duration: 200
		});

		$(this).siblings('.c-icon-count').velocity('stop').velocity({
			opacity: 0.6
		}, {
			duration: 200
		});

		$(this).one('mouseleave', () => {

			$(this).velocity({
				opacity: 1
			}, {
				duration: 200
			});

			$(this).siblings('.c-icon-count').velocity({
				opacity: 1
			}, {
				duration: 200
			});
		});
	});

	Waves.attach(
		[...document.querySelectorAll(`
			.has-ripple,
			.c-icon-count,
			.dropdown-item,
			.mmenu-type1-item:not(.mmenu-type1-item--inheader) > .mmenu-type1-item__link,
			.mmenu-vertical-item__link,
			.b-dl-menu__link,
			.c-button-control,
			.bx-filter-parameters-box-title,
			.b-sidebar-nav__link
		`)],
		'waves-effect waves-base'
	);

    Waves.init();
}
