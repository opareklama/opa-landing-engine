document.addEventListener('DOMContentLoaded', () => {
	const header = document.getElementById('opa-header');
	const toggle = document.querySelector('.opa-header__toggle');
	const drawer = document.getElementById('opa-drawer');
	const overlay = document.querySelector('.opa-drawer-overlay');
	const closeBtn = document.querySelector('.opa-drawer__close');
	const menuLinks = document.querySelectorAll('.opa-drawer__menu a');

	// Sticky Header
	if (header && header.classList.contains('opa-header--sticky')) {
		const onScroll = () => {
			if (window.scrollY > 50) {
				header.classList.add('is-scrolled');
			} else {
				header.classList.remove('is-scrolled');
			}
		};
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll(); // trigger on load
	}

	// Mobile Drawer Toggle
	const openDrawer = () => {
		toggle.setAttribute('aria-expanded', 'true');
		drawer.classList.add('is-open');
		overlay.classList.add('is-open');
		document.body.style.overflow = 'hidden';
	};

	const closeDrawer = () => {
		toggle.setAttribute('aria-expanded', 'false');
		drawer.classList.remove('is-open');
		overlay.classList.remove('is-open');
		document.body.style.overflow = '';
	};

	if (toggle && drawer && overlay) {
		toggle.addEventListener('click', () => {
			const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
			if (isExpanded) {
				closeDrawer();
			} else {
				openDrawer();
			}
		});

		overlay.addEventListener('click', closeDrawer);
		if (closeBtn) {
			closeBtn.addEventListener('click', closeDrawer);
		}

		// Close drawer on link click
		menuLinks.forEach(link => {
			link.addEventListener('click', closeDrawer);
		});
	}

	// Active Menu Highlight & Smooth Scroll (Basic Implementation)
	const desktopLinks = document.querySelectorAll('.opa-header__menu a');
	const sections = Array.from(desktopLinks).map(link => {
		const targetId = link.getAttribute('href');
		if (targetId && targetId.startsWith('#')) {
			return document.querySelector(targetId);
		}
		return null;
	}).filter(Boolean);

	const highlightNav = () => {
		let scrollY = window.scrollY;
		sections.forEach(current => {
			const sectionHeight = current.offsetHeight;
			const sectionTop = current.offsetTop - 100;
			const sectionId = current.getAttribute('id');
			
			if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
				desktopLinks.forEach(link => {
					link.classList.remove('is-active');
					if (link.getAttribute('href') === '#' + sectionId) {
						link.classList.add('is-active');
					}
				});
			}
		});
	};

	if (sections.length > 0) {
		window.addEventListener('scroll', highlightNav, { passive: true });
	}
});
