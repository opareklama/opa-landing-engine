<?php
namespace OPA\LandingEngine\Components\FAQ;

use OPA\LandingEngine\Components\AbstractComponent;

class FAQComponent extends AbstractComponent {

	public function get_id() {
		return 'faq';
	}

	public function get_name() {
		return __( 'FAQ', 'opa-engine' );
	}

	public function get_defaults() {
		require_once __DIR__ . '/Defaults.php';
		return Defaults::get();
	}

	public function register_settings( $page, $section ) {
		require_once __DIR__ . '/Settings.php';
		Settings::register( $this, $page, $section );
	}

	public function render() {
		require_once __DIR__ . '/Renderer.php';
		Renderer::render( $this );
	}

	public function enqueue_assets() {
		$css_path = __DIR__ . '/Assets/faq.css';
		if ( file_exists( $css_path ) ) {
			$css_ver = filemtime( $css_path );
			wp_enqueue_style(
				'opa-' . $this->get_id(),
				plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'Components/FAQ/Assets/faq.css',
				[],
				$css_ver
			);
		}
	}
}
