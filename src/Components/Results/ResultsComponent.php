<?php
namespace OPA\LandingEngine\Components\Results;

use OPA\LandingEngine\Components\AbstractComponent;

class ResultsComponent extends AbstractComponent {

	public function get_id() {
		return 'results';
	}

	public function get_name() {
		return __( 'Results', 'opa-engine' );
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
		$css_path = __DIR__ . '/Assets/results.css';
		if ( file_exists( $css_path ) ) {
			$css_ver = filemtime( $css_path );
			wp_enqueue_style(
				'opa-' . $this->get_id(),
				plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'Components/Results/Assets/results.css',
				[],
				$css_ver
			);
		}
	}
}
