<?php
namespace OPA\LandingEngine\Components\Hero;

use OPA\LandingEngine\Components\AbstractComponent;

/**
 * Hero Component Main Class
 */
class HeroComponent extends AbstractComponent {

	public function get_id() {
		return 'hero';
	}

	public function get_name() {
		return 'Hero Section';
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
			$css_ver = file_exists( __DIR__ . '/Assets/hero.css' ) ? filemtime( __DIR__ . '/Assets/hero.css' ) : '1.0.0';
			$js_ver  = file_exists( __DIR__ . '/Assets/hero.js' ) ? filemtime( __DIR__ . '/Assets/hero.js' ) : '1.0.0';
			wp_enqueue_style( 'opa-hero', plugin_dir_url( __FILE__ ) . 'Assets/hero.css', [], $css_ver );
			wp_enqueue_script( 'opa-hero', plugin_dir_url( __FILE__ ) . 'Assets/hero.js', [], $js_ver, true );
		}
	}
}
