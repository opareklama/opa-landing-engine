<?php
namespace OPA\LandingEngine\Components\Process;

class Renderer {

	public static function render( $component ) {
		$defaults = $component->get_defaults();
		$options  = get_option( 'opa_home_settings', [] );

		$enable = $options['opa_process_enable'] ?? $defaults['opa_process_enable'];
		if ( $enable !== '1' ) {
			return;
		}

		$badge    = $options['opa_process_badge'] ?? $defaults['opa_process_badge'];
		$title    = $options['opa_process_title'] ?? $defaults['opa_process_title'];
		$desc     = $options['opa_process_desc'] ?? $defaults['opa_process_desc'];
		$steps    = $options['opa_process_steps'] ?? $defaults['opa_process_steps'];
		$btn_lbl  = $options['opa_process_btn_label'] ?? $defaults['opa_process_btn_label'];
		$btn_url  = $options['opa_process_btn_url'] ?? $defaults['opa_process_btn_url'];

		?>
		<section class="opa-process" id="process">
			<div class="opa-process__container">
				
				<header class="opa-process__header">
					<div class="opa-process__badge"><?php echo esc_html( $badge ); ?></div>
					<h2 class="opa-process__title"><?php echo esc_html( $title ); ?></h2>
					<p class="opa-process__desc"><?php echo esc_html( $desc ); ?></p>
				</header>

				<div class="opa-process__timeline">
					<div class="opa-process__track"></div>
					<div class="opa-process__progress"></div>
					
					<div class="opa-process__grid">
						<?php 
						$counter = 1;
						foreach ( $steps as $index => $step ) : 
							$num = sprintf('%02d', $counter);
							$wave_delay = $index; // 0, 1, 2, 3, 4, 5
						?>
							<article class="opa-process__step" style="--step-delay: <?php echo $counter * 0.2; ?>s; --wave-delay: <?php echo $wave_delay; ?>s;">
								<div class="opa-process__node">
									<div class="opa-process__node-inner"></div>
								</div>
								<div class="opa-process__content">
									<?php if ( $index === 5 ) : ?>
										<div class="opa-process__celebration">
											<span class="opa-sparkle opa-sparkle-1">✦</span>
											<span class="opa-sparkle opa-sparkle-2">✦</span>
											<span class="opa-sparkle opa-sparkle-3">✦</span>
										</div>
									<?php endif; ?>
									<span class="opa-process__number"><?php echo $num; ?></span>
									<h3 class="opa-process__step-title"><?php echo esc_html( $step['title'] ?? '' ); ?></h3>
									<p class="opa-process__step-desc"><?php echo esc_html( $step['description'] ?? '' ); ?></p>
								</div>
							</article>
						<?php 
							$counter++;
						endforeach; 
						?>
					</div>
				</div>

				<?php if ( ! empty( $btn_lbl ) && ! empty( $btn_url ) ) : ?>
					<div class="opa-process__actions">
						<a href="<?php echo esc_url( $btn_url ); ?>" class="opa-cta-button opa-cta-button--dark">
							<?php echo esc_html( $btn_lbl ); ?>
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
						</a>
					</div>
				<?php endif; ?>

			</div>
		</section>

		<script>
		document.addEventListener('DOMContentLoaded', function() {
			const processSection = document.getElementById('process');
			if (!processSection) return;

			const observer = new IntersectionObserver((entries) => {
				entries.forEach(entry => {
					if (entry.isIntersecting) {
						entry.target.classList.add('opa-is-visible');
						observer.unobserve(entry.target);
					}
				});
			}, { threshold: 0.3 });

			observer.observe(processSection);
		});
		</script>
		<?php
	}
}
