<?php
namespace OPA\LandingEngine\Renderer;

use OPA\LandingEngine\Registry\ComponentRegistry;

/**
 * Renders the [nt30_home] shortcode and dynamically loops through components
 */
class HomeRenderer {

	public function register() {
		add_shortcode( 'nt30_home', [ $this, 'render_shortcode' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_component_assets' ] );
	}

	public function render_shortcode( $atts ) {
		$settings = get_option( 'opa_home_settings', [] );

		// Check if Home Page is enabled globally
		if ( isset( $settings['enable_home'] ) && $settings['enable_home'] === '0' ) {
			return '';
		}

		$registry = ComponentRegistry::get_instance();
		$components = $registry->get_all();
		
		// Get saved order or default
		$saved_order = isset( $settings['component_order'] ) && !empty($settings['component_order']) ? explode( ',', $settings['component_order'] ) : array_keys( $components );
		
		// Ensure new components that aren't in the saved order get appended
		foreach ( array_keys( $components ) as $id ) {
			if ( ! in_array( $id, $saved_order ) ) {
				$saved_order[] = $id;
			}
		}

		ob_start();

		$global_padding = isset( $settings['global_padding'] ) && is_numeric( $settings['global_padding'] ) ? intval( $settings['global_padding'] ) : 120;
		$mobile_padding = max(40, intval($global_padding * 0.6));

		echo '<div class="opa-landing-engine-home">';
		
		echo '<style>
			.opa-landing-engine-home section:not(.opa-hero) {
				padding-top: ' . esc_attr($global_padding) . 'px !important;
				padding-bottom: ' . esc_attr($global_padding) . 'px !important;
			}
			@media (max-width: 768px) {
				.opa-landing-engine-home section:not(.opa-hero) {
					padding-top: ' . esc_attr($mobile_padding) . 'px !important;
					padding-bottom: ' . esc_attr($mobile_padding) . 'px !important;
				}
			}
		</style>';

		// Loop through registry in the saved drag-and-drop order
		foreach ( $saved_order as $id ) {
			if ( isset( $components[ $id ] ) ) {
				$instance = new $components[ $id ]();
				// The AbstractComponent->render() handles its own `is_enabled()` check
				$instance->render();
			}
		}

		echo '</div>';

		return ob_get_clean();
	}

	public function enqueue_component_assets() {
		$settings = get_option( 'opa_home_settings', [] );
		
		if ( isset( $settings['enable_home'] ) && $settings['enable_home'] === '0' ) {
			return;
		}

		$registry = ComponentRegistry::get_instance();
		$components = $registry->get_all();
		$saved_order = isset( $settings['component_order'] ) && !empty($settings['component_order']) ? explode( ',', $settings['component_order'] ) : array_keys( $components );
		foreach ( array_keys( $components ) as $id ) {
			if ( ! in_array( $id, $saved_order ) ) {
				$saved_order[] = $id;
			}
		}

		// Tell active components to load their CSS/JS
		foreach ( $saved_order as $id ) {
			if ( isset( $components[ $id ] ) ) {
				$instance = new $components[ $id ]();
				$instance->enqueue_assets();
			}
		}
	}
}
