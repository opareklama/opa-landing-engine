<?php
namespace OPA\LandingEngine\Components\WhyNT30;

use OPA\LandingEngine\Components\AbstractComponent;

class WhyNT30Component extends AbstractComponent {

	public function get_id() {
		return 'why-nt30';
	}

	public function get_name() {
		return 'Why NT30 Section';
	}

	public function render() {
		if ( ! $this->is_enabled() ) {
			return;
		}
		require_once __DIR__ . '/Renderer.php';
		Renderer::render( $this );
	}

	public function register_settings( $page, $section ) {
		require_once __DIR__ . '/Settings.php';
		Settings::register( $this, $page, $section );
	}

	public function get_defaults() {
		require_once __DIR__ . '/Defaults.php';
		return Defaults::get();
	}

	public function enqueue_assets() {
		if ( $this->is_enabled() ) {
			$css_ver = file_exists( __DIR__ . '/Assets/whynt30.css' ) ? filemtime( __DIR__ . '/Assets/whynt30.css' ) : '1.0.0';
			wp_enqueue_style( 'opa-whynt30', plugin_dir_url( __FILE__ ) . 'Assets/whynt30.css', [], $css_ver );
		}
	}
}
