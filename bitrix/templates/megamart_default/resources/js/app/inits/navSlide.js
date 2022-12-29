export default function (context) {
	$(context).find('.nav-slide').each(function () {
		var $nav = $(this);
		var $line = $('<li>').addClass('nav-slide-line');
		var $currentActive = $nav.find('.active');
		var $items = $nav.find('.nav-item');

		var setActive = function ($item) {
			var $span = $item.children('span');

			$line.css({
				'width': $span.outerWidth(),
				'left': $span.position().left + $nav.scrollLeft()
			});
		}

		$nav.append($line);

		setActive($nav.find('.active'));

		$nav.find('.nav-link').on('mouseenter', function () {
			var $item = $(this);

			setActive($item);
		});

		$(this).on('mouseleave', function () {
			setActive($currentActive);
		});

		if ($nav.attr('role') == 'tablist') {
			$items.on('shown.bs.tab', function () {
				var $item = $(this).children('.nav-link');
				$currentActive = $item;

				setActive($currentActive);
			});
		} else {
			$items.find('.nav-link').on('click', function () {
				var $item = $(this);

				$currentActive.removeClass('active');
				$item.addClass('active')

				$currentActive = $item;
				setActive($currentActive);
			});
		}

	});
}
