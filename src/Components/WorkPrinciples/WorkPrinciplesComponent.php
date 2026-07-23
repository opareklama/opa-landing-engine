<?php
namespace OPA\LandingEngine\Components\WorkPrinciples;

use OPA\LandingEngine\Components\AbstractComponent;
use OPA\LandingEngine\Registry\ComponentRegistry;

class WorkPrinciplesComponent extends AbstractComponent {

	public function get_id() {
		return 'work-principles';
	}

	public function get_name() {
		return __( 'Working Principles', 'opa-engine' );
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
		$css_path = __DIR__ . '/Assets/workprinciples.css';
		if ( file_exists( $css_path ) ) {
			$css_ver = filemtime( $css_path );
			wp_enqueue_style(
				'opa-' . $this->get_id(),
				plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'Components/WorkPrinciples/Assets/workprinciples.css',
				[],
				$css_ver
			);
		}
	}
}
