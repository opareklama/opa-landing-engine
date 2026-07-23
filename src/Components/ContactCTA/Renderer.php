<?php
namespace OPA\LandingEngine\Components\ContactCTA;

class Renderer {

	public static function render( $component ) {
		$defaults = $component->get_defaults();
		$options  = get_option( 'opa_home_settings', [] );

		$enable = $options['opa_contact_enable'] ?? $defaults['opa_contact_enable'];
		if ( $enable !== '1' ) {
			return;
		}

		$badge     = $options['opa_contact_badge'] ?? $defaults['opa_contact_badge'];
		$title     = $options['opa_contact_title'] ?? $defaults['opa_contact_title'];
		$desc      = $options['opa_contact_desc'] ?? $defaults['opa_contact_desc'];
		$shortcode = $options['opa_contact_shortcode'] ?? $defaults['opa_contact_shortcode'];
		$phone     = $options['opa_contact_phone'] ?? $defaults['opa_contact_phone'];
		$email     = $options['opa_contact_email'] ?? $defaults['opa_contact_email'];

		?>
		<section class="opa-contact" id="contact">
			<div class="opa-contact__container">
				
				<div class="opa-contact__header">
					<?php if ( ! empty( $badge ) ) : ?>
						<div class="opa-contact__badge"><?php echo esc_html( $badge ); ?></div>
					<?php endif; ?>
					
					<h2 class="opa-contact__title"><?php echo esc_html( $title ); ?></h2>
					<p class="opa-contact__desc"><?php echo esc_html( $desc ); ?></p>
				</div>

				<div class="opa-contact__form-card">
					<?php 
					if ( ! empty( $shortcode ) ) {
						echo do_shortcode( $shortcode );
					} else {
						echo '<p style="text-align:center;">' . esc_html__( 'Please configure the form shortcode in the admin panel.', 'opa-engine' ) . '</p>';
					}
					?>
				</div>

				<?php if ( ! empty( $phone ) || ! empty( $email ) ) : ?>
					<div class="opa-contact__info">
						<?php if ( ! empty( $phone ) ) : ?>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="opa-contact__link">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
								<?php echo esc_html( $phone ); ?>
							</a>
						<?php endif; ?>
						
						<?php if ( ! empty( $email ) ) : ?>
							<a href="mailto:<?php echo esc_attr( $email ); ?>" class="opa-contact__link">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
								<?php echo esc_html( $email ); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}
}
