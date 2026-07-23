<?php
namespace OPA\LandingEngine\Components\WhyNT30;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Renderer {

	public static function render( $component ) {
		$defaults = $component->get_defaults();
		$options  = get_option( 'opa_home_settings', [] );

		$title    = $options['opa_why_title'] ?? $defaults['opa_why_title'];
		$subtitle = $options['opa_why_subtitle'] ?? $defaults['opa_why_subtitle'];
		$features = $options['opa_why_features'] ?? $defaults['opa_why_features'];
		$btn_lbl  = $options['opa_why_btn_label'] ?? $defaults['opa_why_btn_label'];
		$btn_url  = $options['opa_why_btn_url'] ?? $defaults['opa_why_btn_url'];
		$bg_image = $options['opa_why_bg_image'] ?? '';

		?>
		<section class="opa-why" id="why-nt30">
			<?php if ( ! empty( $bg_image ) ) : ?>
				<div class="opa-why__bg-image" style="background-image: url('<?php echo esc_url( $bg_image ); ?>');"></div>
			<?php endif; ?>
			
			<div class="opa-why__container">
				<header class="opa-why__header">
					<div class="opa-why__header-top">
						<span class="opa-why__line"></span>
						<span class="opa-why__top-title">KODĖL NT30?</span>
						<span class="opa-why__line"></span>
					</div>
					<h2 class="opa-why__title">
						<?php 
						// Highlight NT30? if it exists in the title
						$highlighted_title = str_replace('NT30?', '<span class="opa-why__highlight">NT30?</span>', esc_html($title));
						echo $highlighted_title;
						?>
					</h2>
					<div class="opa-why__separator">
						<span class="opa-why__line"></span>
						<span class="opa-why__diamond"></span>
						<span class="opa-why__line"></span>
					</div>
					<p class="opa-why__subtitle"><?php echo esc_html( $subtitle ); ?></p>
				</header>

				<div class="opa-why__grid">
					<?php 
					$counter = 1;
					foreach ( $features as $feature ) : 
						$num = sprintf('%02d', $counter);
					?>
						<article class="opa-why__card">
							<div class="opa-why__icon-wrapper">
								<div class="opa-why__icon">
									<?php echo self::get_icon( $feature['icon'] ?? 'check' ); ?>
								</div>
							</div>
							<div class="opa-why__card-content">
								<span class="opa-why__card-number"><?php echo $num; ?></span>
								<h3 class="opa-why__card-title"><?php echo esc_html( $feature['title'] ?? '' ); ?></h3>
								<p class="opa-why__card-desc"><?php echo esc_html( $feature['description'] ?? '' ); ?></p>
							</div>
						</article>
					<?php 
						$counter++;
					endforeach; 
					?>
				</div>

				<?php if ( ! empty( $btn_lbl ) && ! empty( $btn_url ) ) : ?>
					<div class="opa-why__actions">
						<div class="opa-why__actions-top">
							<svg class="opa-why__arrow" width="60" height="40" viewBox="0 0 60 40" fill="none" stroke="#C9A14A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M5 5 C 10 30, 30 35, 55 35"></path>
								<polyline points="45 25 55 35 45 45" transform="translate(0,0)"></polyline>
							</svg>
							<span class="opa-why__pre-btn">PASIRUOŠĘS PARDUOTI?</span>
						</div>
						<a href="<?php echo esc_url( $btn_url ); ?>" class="opa-cta-button opa-cta-button--dark">
							<?php echo esc_html( $btn_lbl ); ?>
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}

	private static function get_icon( $name ) {
		switch ( $name ) {
			case 'clock':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>';
			case 'users':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>';
			case 'shield':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>';
			case 'check':
			default:
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
		}
	}
}
