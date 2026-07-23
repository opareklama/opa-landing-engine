<?php
namespace OPA\Engine\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {

	/**
	 * @var Plugin
	 */
	private static $instance = null;

	/**
	 * Get instance
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Include required core files
	 */
	private function includes() {
		if ( is_admin() ) {
			new \OPA\Engine\Admin\Menu();
			new \OPA\Engine\Admin\GlobalSettings();
			new \OPA\Engine\Components\Header\Settings();
			new \OPA\Engine\Components\Footer\Settings();
		} else {
			new \OPA\Engine\Components\Header\Renderer();
			new \OPA\Engine\Components\Footer\Renderer();
		}
	}

	/**
	 * Init core hooks
	 */
	private function init_hooks() {
		add_action( 'init', [ $this, 'on_init' ] );
	}

	/**
	 * On Init hook
	 */
	public function on_init() {
		// Initialize the framework components
	}
}
