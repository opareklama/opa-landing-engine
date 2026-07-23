<?php
namespace OPA\Engine\Components\Header;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Renderer {

	public function __construct() {
		// Hook into template redirect or get_header
		// But since we want to enqueue our own assets properly and replace the header:
		add_action( 'get_header', [ $this, 'override_header' ], 1 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
	}

	public function enqueue_assets() {
		$options = get_option( 'opa_header_settings' );
		$is_enabled = isset( $options['opa_header_enable'] ) ? (bool) $options['opa_header_enable'] : true;
		
		if ( $is_enabled ) {
			$css_ver = file_exists( OPA_ENGINE_DIR . 'assets/css/header.css' ) ? filemtime( OPA_ENGINE_DIR . 'assets/css/header.css' ) : OPA_ENGINE_VERSION;
			$js_ver  = file_exists( OPA_ENGINE_DIR . 'assets/js/header.js' ) ? filemtime( OPA_ENGINE_DIR . 'assets/js/header.js' ) : OPA_ENGINE_VERSION;
			
			wp_enqueue_style( 'opa-header-css', OPA_ENGINE_URL . 'assets/css/header.css', [], $css_ver );
			wp_enqueue_script( 'opa-header-js', OPA_ENGINE_URL . 'assets/js/header.js', [], $js_ver, true );
		}
	}

	public function override_header( $name ) {
		$options = get_option( 'opa_header_settings' );
		$is_enabled = isset( $options['opa_header_enable'] ) ? (bool) $options['opa_header_enable'] : true;

		if ( ! $is_enabled ) {
			return;
		}

		$this->render();
		
		// Trick to prevent default header from loading if we hook this early, 
		// but since some themes hardcode `require header.php`, we just output and rely on CSS 
		// or custom template for full control. For this module, we will assume 
		// we are acting as the primary layout renderer.
		// A full framework would use `template_include` to intercept the entire page.
		// For now, we just output our header. 
	}

	public function render() {
		$options = get_option( 'opa_header_settings', [] );
		$global_options = get_option( 'opa_global_settings', [] );

		$is_sticky = isset( $options['opa_header_sticky'] ) && $options['opa_header_sticky'] ? 'opa-header--sticky' : '';
		
		// Strictly check if it's explicitly '0' or unchecked
		$is_transparent = ( !isset( $options['opa_header_transparent'] ) || $options['opa_header_transparent'] == '1' ) ? 'opa-header--transparent' : 'opa-header--solid';
		
		$header_classes = trim( "opa-header {$is_sticky} {$is_transparent}" );

		$logo_text = !empty( $options['opa_header_logo_text'] ) ? $options['opa_header_logo_text'] : 'NT30';
		$phone = !empty( $options['opa_header_phone'] ) ? $options['opa_header_phone'] : '+370 608 88 894';
		$phone_link = 'tel:' . preg_replace('/[^0-9+]/', '', $phone);
		$cta_text = !empty( $options['opa_header_cta_text'] ) ? $options['opa_header_cta_text'] : 'Gauti nemokamą konsultaciją';
		$cta_url = !empty( $options['opa_header_cta_url'] ) ? $options['opa_header_cta_url'] : '#kontaktai';

		$primary_accent = !empty( $global_options['opa_primary_accent'] ) ? $global_options['opa_primary_accent'] : '#C9A14A';
		$dark_bg = !empty( $global_options['opa_dark_background'] ) ? $global_options['opa_dark_background'] : '#0F172A';
		
		$raw_menu = !empty( $options['opa_header_menu_items'] ) ? $options['opa_header_menu_items'] : [];
		
		$menu_items = [];
		if ( is_array( $raw_menu ) ) {
			foreach ( $raw_menu as $item ) {
				if ( empty( $item['label'] ) ) continue;
				$menu_items[] = [
					'label' => $item['label'],
					'url'   => $item['url'] ?? '',
					'subs'  => []
				];
			}
		} elseif ( is_string( $raw_menu ) && !empty($raw_menu) ) {
			$lines = explode( "\n", str_replace( "\r", "", $raw_menu ) );
			foreach ( $lines as $line ) {
				if ( empty( trim( $line ) ) ) continue;
				$parts = explode( '|', $line );
				if ( count( $parts ) >= 2 ) {
					$menu_items[] = [
						'label' => trim( $parts[0] ),
						'url'   => trim( $parts[1] ),
						'subs'  => []
					];
				}
			}
		}

		?>
		<style>
			/* Hide default theme headers to prevent overlap */
			header#masthead, .site-header, header.main-header { display: none !important; }
			
			:root {
				--opa-primary: <?php echo esc_attr( $primary_accent ); ?>;
				--opa-primary-hover: <?php echo esc_attr( $primary_accent ); ?>;
				--opa-dark: <?php echo esc_attr( $dark_bg ); ?>;
				--opa-surface: rgba(15, 23, 42, 0.85);
				--opa-text: #F9FAFB;
				--opa-text-sec: #9CA3AF;
				--opa-font-heading: 'Manrope', sans-serif;
				--opa-font-body: 'Inter', sans-serif;
			}
		</style>

		<header class="<?php echo esc_attr( $header_classes ); ?>" id="opa-header">
			<div class="opa-header__container">
				<!-- Logo -->
				<a href="#pradzia" class="opa-header__logo" aria-label="<?php echo esc_attr( $logo_text ); ?> - Butų Pardavimo Komanda">
					<span class="opa-header__logo-text"><?php echo esc_html( $logo_text ); ?></span>
				</a>

				<!-- Desktop Nav -->
				<nav class="opa-header__nav" aria-label="<?php esc_attr_e( 'Main Navigation', 'opa-engine' ); ?>">
					<ul class="opa-header__menu">
						<?php foreach ( $menu_items as $item ) : ?>
							<li class="<?php echo !empty($item['subs']) ? 'has-dropdown' : ''; ?>">
								<a href="<?php echo esc_url( $item['url'] ); ?>" class="opa-menu-link">
									<?php echo esc_html( $item['label'] ); ?>
									<?php if ( !empty($item['subs']) ) : ?>
										<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
									<?php endif; ?>
								</a>
								<?php if ( !empty($item['subs']) ) : ?>
									<ul class="opa-header__dropdown">
										<?php foreach ( $item['subs'] as $sub ) : ?>
											<li><a href="<?php echo esc_url( $sub['url'] ); ?>"><?php echo esc_html( $sub['label'] ); ?></a></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>

				<!-- Desktop Actions -->
				<div class="opa-header__actions">
					<a href="<?php echo esc_url( $phone_link ); ?>" class="opa-phone-link">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
						<?php echo esc_html( $phone ); ?>
					</a>
					<a href="<?php echo esc_url( $cta_url ); ?>" class="opa-cta-button">
						<?php echo esc_html( $cta_text ); ?>
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
					</a>
				</div>

				<!-- Mobile Toggle -->
				<button class="opa-header__toggle" aria-expanded="false" aria-label="Toggle navigation">
					<span></span><span></span><span></span>
				</button>
			</div>
		</header>

		<!-- Mobile Drawer -->
		<div class="opa-drawer" id="opa-drawer">
			<div class="opa-drawer__header">
				<a href="#pradzia" class="opa-header__logo" aria-label="<?php echo esc_attr( $logo_text ); ?>">
					<span class="opa-header__logo-text"><?php echo esc_html( $logo_text ); ?></span>
				</a>
				<button type="button" class="opa-drawer__close" aria-label="Close menu">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
				</button>
			</div>
			<nav class="opa-drawer__nav">
				<ul class="opa-drawer__menu">
					<?php foreach ( $menu_items as $item ) : ?>
						<li>
							<a href="<?php echo esc_url( $item['url'] ); ?>" class="opa-menu-link"><?php echo esc_html( $item['label'] ); ?></a>
							<?php if ( !empty($item['subs']) ) : ?>
								<ul class="opa-drawer__dropdown">
									<?php foreach ( $item['subs'] as $sub ) : ?>
										<li><a href="<?php echo esc_url( $sub['url'] ); ?>"><?php echo esc_html( $sub['label'] ); ?></a></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
				<div class="opa-drawer__actions">
					<a href="<?php echo esc_url( $phone_link ); ?>" class="opa-phone-link"><?php echo esc_html( $phone ); ?></a>
					<a href="<?php echo esc_url( $cta_url ); ?>" class="opa-cta-button"><?php echo esc_html( $cta_text ); ?></a>
				</div>
			</nav>
		</div>
		<div class="opa-drawer-overlay"></div>
		<?php
	}
}
