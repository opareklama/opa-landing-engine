<?php
namespace OPA\LandingEngine\Components;

/**
 * Abstract Component for AntyGravity Home Engine
 */
abstract class AbstractComponent {

	public $id;
	public $name;
	public $settings_prefix;

	public function __construct() {
		$this->id = $this->get_id();
		$this->name = $this->get_name();
		$this->settings_prefix = 'opa_comp_' . $this->id . '_';
	}

	/**
	 * Must return the unique ID of the component (e.g., 'hero')
	 */
	abstract public function get_id();

	/**
	 * Must return the human-readable name (e.g., 'Hero Section')
	 */
	abstract public function get_name();

	/**
	 * Must render the HTML output
	 */
	abstract public function render();

	/**
	 * Should register the WordPress Settings API fields for this component
	 */
	abstract public function register_settings( $page, $section );

	/**
	 * Enqueue assets (CSS/JS) if the component is active
	 */
	public function enqueue_assets() {}

	/**
	 * Get default settings/content for the component
	 */
	abstract public function get_defaults();

	/**
	 * Helper to get a specific setting value, falling back to default
	 */
	public function get_setting( $key ) {
		$options = get_option( 'opa_home_settings', [] );
		$full_key = $this->settings_prefix . $key;
		
		if ( isset( $options[ $full_key ] ) ) {
			return $options[ $full_key ];
		}
		
		$defaults = $this->get_defaults();
		return isset( $defaults[ $key ] ) ? $defaults[ $key ] : null;
	}

	/**
	 * Check if the component is enabled in settings
	 */
	public function is_enabled() {
		return $this->get_setting( 'enable' ) !== '0';
	}
}
