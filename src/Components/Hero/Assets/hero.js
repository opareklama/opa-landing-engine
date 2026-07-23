document.addEventListener('DOMContentLoaded', () => {
	const animatedElements = document.querySelectorAll('[data-opa-animate]');

	if (animatedElements.length === 0) return;

	const observerOptions = {
		root: null,
		rootMargin: '0px',
		threshold: 0.1
	};

	const observer = new IntersectionObserver((entries, observer) => {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
				const el = entry.target;
				const animationType = el.getAttribute('data-opa-animate');
				
				// Standard fade-up logic is handled via CSS class 'is-visible'
				if (animationType === 'fade-up' || animationType === 'fade') {
					el.classList.add('is-visible');
				}
				
				// Unobserve once animated
				observer.unobserve(el);
			}
		});
	}, observerOptions);

	animatedElements.forEach(el => observer.observe(el));
});
