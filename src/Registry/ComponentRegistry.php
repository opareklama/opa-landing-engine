<?php
namespace OPA\LandingEngine\Registry;

/**
 * Component Registry for AntyGravity Home Engine
 */
class ComponentRegistry {
	private static $instance = null;
	private $components = [];

	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {}

	/**
	 * Register a new component
	 */
	public function register( $id, $component_class ) {
		if ( ! isset( $this->components[ $id ] ) ) {
			$this->components[ $id ] = $component_class;
		}
	}

	/**
	 * Get all registered components
	 */
	public function get_all() {
		return $this->components;
	}

	/**
	 * Get a specific component instance
	 */
	public function get( $id ) {
		if ( isset( $this->components[ $id ] ) ) {
			$class = $this->components[ $id ];
			return new $class();
		}
		return null;
	}
}
