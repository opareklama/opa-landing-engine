<?php
namespace OPA\LandingEngine\Components\Hero;

/**
 * Renderer for Hero Component
 */
class Renderer {

	public static function render( $component ) {
		$badge = $component->get_setting( 'badge' );
		$headline = $component->get_setting( 'headline' );
		$description = $component->get_setting( 'description' );
		$primary_label = $component->get_setting( 'primary_button_label' );
		$primary_url = $component->get_setting( 'primary_button_url' );
		$secondary_label = $component->get_setting( 'secondary_button_label' );
		$secondary_url = $component->get_setting( 'secondary_button_url' );
		$trust_items = $component->get_setting( 'trust_items' );
		$bg_image = $component->get_setting( 'background_image' ); // URL to image
		$mobile_bg_image = $component->get_setting( 'mobile_background_image' ); // URL to image

		// Fallback placeholders if images aren't set
		$bg_image = $bg_image ?: 'https://via.placeholder.com/1920x1080/0F172A/C9A14A?text=Hero+Background';
		$mobile_bg_image = $mobile_bg_image ?: $bg_image;

		$animation = $component->get_setting( 'animation' );
		$anim_attr = $animation !== 'none' ? 'data-opa-animate="' . esc_attr( $animation ) . '"' : '';

		?>
		<section class="opa-hero" id="pradzia" aria-label="Hero Section">
			
			<!-- High Performance Background via Picture Tag -->
			<div class="opa-hero__bg-container" aria-hidden="true">
				<picture>
					<source media="(max-width: 768px)" srcset="<?php echo esc_url( $mobile_bg_image ); ?>">
					<img src="<?php echo esc_url( $bg_image ); ?>" 
						 alt="" 
						 class="opa-hero__bg-img" 
						 loading="eager" 
						 fetchpriority="high">
				</picture>
				<?php if ( $component->get_setting( 'overlay_enable' ) === '1' ) : ?>
					<div class="opa-hero__overlay" style="background-color: <?php echo esc_attr( $component->get_setting( 'overlay_color' ) ); ?>; opacity: <?php echo esc_attr( $component->get_setting( 'overlay_opacity' ) ); ?>;"></div>
				<?php endif; ?>
			</div>

			<div class="opa-hero__container">
				<div class="opa-hero__content" <?php echo $anim_attr; ?>>
					
					<?php if ( $badge ) : ?>
						<span class="opa-hero__badge"><?php echo esc_html( $badge ); ?></span>
					<?php endif; ?>

					<header>
						<h1 class="opa-hero__headline"><?php echo esc_html( $headline ); ?></h1>
					</header>

					<?php if ( $description ) : ?>
						<p class="opa-hero__description"><?php echo nl2br( esc_html( $description ) ); ?></p>
					<?php endif; ?>

					<div class="opa-hero__actions">
						<?php if ( $primary_label ) : ?>
							<a href="<?php echo esc_url( $primary_url ); ?>" class="opa-cta-button opa-cta-button--primary">
								<?php echo esc_html( $primary_label ); ?>
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
							</a>
						<?php endif; ?>

						<?php if ( $secondary_label ) : ?>
							<a href="<?php echo esc_url( $secondary_url ); ?>" class="opa-cta-button opa-cta-button--secondary">
								<?php echo esc_html( $secondary_label ); ?>
							</a>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $trust_items ) && is_array( $trust_items ) ) : ?>
						<div class="opa-hero__trust">
							<?php foreach ( $trust_items as $item ) : ?>
								<div class="opa-hero__trust-item">
									<div class="opa-hero__trust-icon-wrapper">
										<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
									</div>
									<span><?php echo esc_html( $item['text'] ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</section>
		<?php
	}
}
