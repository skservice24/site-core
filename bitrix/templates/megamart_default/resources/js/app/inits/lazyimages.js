export default function (context) {

	[...context.querySelectorAll('[loading="lazy"]')].forEach(item => {
		if (!item.complete)
		{
			item.classList.add('lazy-anim-img');
			item.addEventListener('load', ({ target }) => {
				target.classList.remove('lazy-anim-img');
				target.removeAttribute('loading');
			});
		}
	});
}
