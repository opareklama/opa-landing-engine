<?php
namespace OPA\LandingEngine\Components\Results;

class Renderer {

	public static function render( $component ) {
		$defaults = $component->get_defaults();
		$options  = get_option( 'opa_home_settings', [] );

		$enable = $options['opa_results_enable'] ?? $defaults['opa_results_enable'];
		if ( $enable !== '1' ) {
			return;
		}

		$badge       = $options['opa_results_badge'] ?? $defaults['opa_results_badge'];
		$title       = $options['opa_results_title'] ?? $defaults['opa_results_title'];
		$desc        = $options['opa_results_desc'] ?? $defaults['opa_results_desc'];
		$stats       = $options['opa_results_stats'] ?? $defaults['opa_results_stats'];

		?>
		<section class="opa-results" id="results">
			<div class="opa-results__container">
				
				<header class="opa-results__header">
					<div class="opa-results__badge"><?php echo esc_html( $badge ); ?></div>
					<h2 class="opa-results__title"><?php echo esc_html( $title ); ?></h2>
					<p class="opa-results__desc"><?php echo esc_html( $desc ); ?></p>
				</header>

				<div class="opa-results__grid">
					<?php foreach ( $stats as $index => $stat ) : ?>
						<article class="opa-results__card" style="--card-delay: <?php echo $index * 0.15; ?>s">
							<div class="opa-results__card-inner">
								<div class="opa-results__number-wrap">
									<span class="opa-results__number opa-js-counter" data-target="<?php echo esc_attr( $stat['number'] ?? '0' ); ?>">0</span>
									<span class="opa-results__suffix"><?php echo esc_html( $stat['suffix'] ?? '' ); ?></span>
								</div>
								<h3 class="opa-results__card-title"><?php echo esc_html( $stat['title'] ?? '' ); ?></h3>
								<p class="opa-results__card-desc"><?php echo esc_html( $stat['description'] ?? '' ); ?></p>
							</div>
						</article>
					<?php endforeach; ?>
				</div>

			</div>
		</section>

		<script>
		document.addEventListener('DOMContentLoaded', function() {
			const resultsSection = document.getElementById('results');
			if (!resultsSection) return;

			const animateValue = (obj, start, end, duration) => {
				let startTimestamp = null;
				const step = (timestamp) => {
					if (!startTimestamp) startTimestamp = timestamp;
					const progress = Math.min((timestamp - startTimestamp) / duration, 1);
					// Ease out cubic
					const easeProgress = 1 - Math.pow(1 - progress, 3);
					obj.innerHTML = Math.floor(easeProgress * (end - start) + start);
					if (progress < 1) {
						window.requestAnimationFrame(step);
					} else {
						obj.innerHTML = end;
					}
				};
				window.requestAnimationFrame(step);
			};

			const observer = new IntersectionObserver((entries) => {
				entries.forEach(entry => {
					if (entry.isIntersecting) {
						entry.target.classList.add('opa-is-visible');
						
						const counters = entry.target.querySelectorAll('.opa-js-counter');
						counters.forEach(counter => {
							const target = parseInt(counter.getAttribute('data-target'), 10) || 0;
							// Add a slight delay based on the card's CSS variable to sync with fade-in
							const delayStr = counter.closest('.opa-results__card').style.getPropertyValue('--card-delay');
							const delay = parseFloat(delayStr) * 1000 || 0;
							
							setTimeout(() => {
								animateValue(counter, 0, target, 2000);
							}, delay + 200); // 200ms extra buffer
						});
						
						observer.unobserve(entry.target);
					}
				});
			}, { threshold: 0.2 });

			observer.observe(resultsSection);
		});
		</script>
		<?php
	}
}
