<?php
namespace OPA\Engine\Components\Footer;

class Renderer {

	public function __construct() {
		add_action( 'wp_footer', [ $this, 'render_footer' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
	}

	public function enqueue_assets() {
		$css_path = __DIR__ . '/Assets/footer.css';
		if ( file_exists( $css_path ) ) {
			$css_ver = filemtime( $css_path );
			wp_enqueue_style(
				'opa-footer-style',
				plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'Components/Footer/Assets/footer.css',
				[],
				$css_ver
			);
		}
	}

	public function render_footer() {
		$defaults = Defaults::get();
		$options  = get_option( 'opa_footer_settings', [] );

		$enable = $options['opa_footer_enable'] ?? $defaults['opa_footer_enable'];
		if ( $enable !== '1' ) {
			return;
		}

		$logo          = $options['opa_footer_logo'] ?? $defaults['opa_footer_logo'];
		$desc          = $options['opa_footer_desc'] ?? $defaults['opa_footer_desc'];
		$phone         = $options['opa_footer_phone'] ?? $defaults['opa_footer_phone'];
		$email         = $options['opa_footer_email'] ?? $defaults['opa_footer_email'];
		$location      = $options['opa_footer_location'] ?? $defaults['opa_footer_location'];
		$copyright     = $options['opa_footer_copyright'] ?? $defaults['opa_footer_copyright'];
		$designer_text = $options['opa_footer_designer_text'] ?? $defaults['opa_footer_designer_text'];
		$designer_url  = $options['opa_footer_designer_url'] ?? $defaults['opa_footer_designer_url'];

		?>
		<footer class="opa-footer" id="footer">
			<div class="opa-footer__container">
				
				<!-- 3 Column Main Footer -->
				<div class="opa-footer__main">
					
					<!-- Col 1: Brand -->
					<div class="opa-footer__col opa-footer__col--brand">
						<?php if ( ! empty( $logo ) ) : ?>
							<img src="<?php echo esc_url( $logo ); ?>" alt="NT30 Logo" class="opa-footer__brand-logo">
						<?php else : ?>
							<h3 class="opa-footer__brand-text">NT30</h3>
						<?php endif; ?>
						<p class="opa-footer__desc"><?php echo esc_html( $desc ); ?></p>
					</div>

					<!-- Col 2: Quick Links -->
					<div class="opa-footer__col opa-footer__col--links">
						<h4 class="opa-footer__heading">Nuorodos</h4>
						<ul class="opa-footer__list">
							<?php
							$registry = \OPA\LandingEngine\Registry\ComponentRegistry::get_instance();
							$components = [
								'hero'     => [ 'id' => '#pradzia', 'label' => 'Pradžia' ],
								'why-nt30' => [ 'id' => '#why-nt30', 'label' => 'Kodėl NT30' ],
								'process'  => [ 'id' => '#process', 'label' => 'Procesas' ],
								'results'  => [ 'id' => '#results', 'label' => 'Rezultatai' ],
								'faq'      => [ 'id' => '#faq', 'label' => 'DUK' ],
								'contact'  => [ 'id' => '#contact', 'label' => 'Kontaktai' ],
							];
							
							foreach ( $components as $comp_id => $link ) {
								$class = $registry->get( $comp_id );
								if ( $class ) {
									$instance = new $class();
									if ( $instance->is_enabled() ) {
										echo '<li><a href="' . esc_attr( $link['id'] ) . '">' . esc_html( $link['label'] ) . '</a></li>';
									}
								}
							}
							?>
						</ul>
					</div>

					<!-- Col 3: Contact -->
					<div class="opa-footer__col opa-footer__col--contact">
						<h4 class="opa-footer__heading">Kontaktai</h4>
						<ul class="opa-footer__contact-list">
							<?php if ( ! empty( $phone ) ) : ?>
								<li>
									<div class="opa-footer__icon-wrap">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
									</div>
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
								</li>
							<?php endif; ?>
							<?php if ( ! empty( $email ) ) : ?>
								<li>
									<div class="opa-footer__icon-wrap">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
									</div>
									<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
								</li>
							<?php endif; ?>
							<?php if ( ! empty( $location ) ) : ?>
								<li>
									<div class="opa-footer__icon-wrap">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
									</div>
									<span><?php echo esc_html( $location ); ?></span>
								</li>
							<?php endif; ?>
						</ul>
					</div>

				</div>

				<!-- Bottom Bar -->
				<div class="opa-footer__bottom">
					<div class="opa-footer__copyright">
						<?php echo esc_html( $copyright ); ?>
					</div>
					<div class="opa-footer__credit">
						Sukurta <a href="<?php echo esc_url( $designer_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $designer_text ); ?></a>
					</div>
				</div>

			</div>
		</footer>
		<?php
	}
}
