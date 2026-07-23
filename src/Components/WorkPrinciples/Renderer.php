<?php
namespace OPA\LandingEngine\Components\WorkPrinciples;

class Renderer {

	public static function render( $component ) {
		$defaults = $component->get_defaults();
		$options  = get_option( 'opa_home_settings', [] );

		$enable = $options['opa_work_enable'] ?? $defaults['opa_work_enable'];
		if ( $enable !== '1' ) {
			return;
		}

		$badge    = $options['opa_work_badge'] ?? $defaults['opa_work_badge'];
		$title    = $options['opa_work_title'] ?? $defaults['opa_work_title'];
		$desc     = $options['opa_work_desc'] ?? $defaults['opa_work_desc'];
		$image    = $options['opa_work_image'] ?? $defaults['opa_work_image'];
		$features = $options['opa_work_principles'] ?? $defaults['opa_work_principles'];
		$btn_lbl  = $options['opa_work_btn_label'] ?? $defaults['opa_work_btn_label'];
		$btn_url  = $options['opa_work_btn_url'] ?? $defaults['opa_work_btn_url'];

		// Fallback image if not set
		if ( empty( $image ) ) {
			$image = 'https://via.placeholder.com/800x1000/0F172A/C9A14A?text=Illustration';
		}

		?>
		<section class="opa-work" id="work-principles">
			<div class="opa-work__container">
				
				<header class="opa-work__header">
					<div class="opa-work__badge"><?php echo esc_html( $badge ); ?></div>
					<h2 class="opa-work__title"><?php echo esc_html( $title ); ?></h2>
					<p class="opa-work__desc"><?php echo esc_html( $desc ); ?></p>
				</header>

				<div class="opa-work__list">
							<?php 
							$counter = 1;
							foreach ( $features as $feature ) : 
								$num = sprintf('%02d', $counter);
							?>
								<article class="opa-work__item">
									<div class="opa-work__item-icon">
										<?php echo self::get_icon( $feature['icon'] ?? '' ); ?>
									</div>
									<div class="opa-work__item-content">
										<h3 class="opa-work__item-title"><?php echo esc_html( $feature['title'] ?? '' ); ?></h3>
										<p class="opa-work__item-desc"><?php echo esc_html( $feature['description'] ?? '' ); ?></p>
									</div>
								</article>
							<?php 
								$counter++;
							endforeach; 
							?>
						</div>

					<?php if ( ! empty( $btn_lbl ) && ! empty( $btn_url ) ) : ?>
						<div class="opa-work__actions">
							<a href="<?php echo esc_url( $btn_url ); ?>" class="opa-cta-button opa-cta-button--outline">
								<?php echo esc_html( $btn_lbl ); ?>
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
							</a>
						</div>
					<?php endif; ?>

			</div>
		</section>
		<?php
	}

	private static function get_icon( $name ) {
		switch ( $name ) {
			case 'users':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>';
			case 'file-check':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><polyline points="9 15 11 17 15 13"></polyline></svg>';
			case 'shield-check':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path></svg>';
			case 'landmark':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="22" x2="21" y2="22"></line><line x1="6" y1="18" x2="6" y2="11"></line><line x1="10" y1="18" x2="10" y2="11"></line><line x1="14" y1="18" x2="14" y2="11"></line><line x1="18" y1="18" x2="18" y2="11"></line><polygon points="12 2 20 7 4 7 12 2"></polygon></svg>';
			case 'megaphone':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 14v-3z"></path><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"></path></svg>';
			case 'file-text':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>';
			case 'clipboard-check':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect><path d="m9 14 2 2 4-4"></path></svg>';
			default:
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 12 12 12 8"></polyline><line x1="12" y1="8" x2="12" y2="8"></line></svg>';
		}
	}
}
