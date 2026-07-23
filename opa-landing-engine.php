<?php
/**
 * Plugin Name: OPA Landing Engine
 * Plugin URI: https://opareklama.lt
 * Description: The core engine for high-performance, modular, and AI-optimized landing pages. Built for speed, SEO, and GEO.
 * Version: 1.0.8
 * Author: OPA Reklama
 * Author URI: https://opareklama.lt
 * Text Domain: opa-engine
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'OPA_ENGINE_VERSION', '1.0.8' );
define( 'OPA_ENGINE_DIR', plugin_dir_path( __FILE__ ) );
define( 'OPA_ENGINE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Health & Environment Verification
 */
function opa_engine_health_check() {
	if ( version_compare( PHP_VERSION, '7.4', '<' ) ) {
		add_action( 'admin_notices', function() {
			echo '<div class="error"><p><strong>OPA Landing Engine:</strong> Requires PHP 7.4 or higher.</p></div>';
		} );
		return false;
	}
	return true;
}

if ( ! opa_engine_health_check() ) {
	return;
}

/**
 * Composer Autoloader
 */
if ( file_exists( OPA_ENGINE_DIR . 'vendor/autoload.php' ) ) {
	require_once OPA_ENGINE_DIR . 'vendor/autoload.php';
}

/**
 * Plugin Update Checker (PUC) Integration
 * Automatically polls the public GitHub repo for releases.
 */
if ( class_exists( 'YahnisElsts\\PluginUpdateChecker\\v5\\PucFactory' ) ) {
	$opa_update_checker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
		'https://github.com/opareklama/opa-landing-engine/',
		__FILE__,
		'opa-landing-engine'
	);
	$opa_update_checker->setBranch('main');
}

/**
 * PSR-4 Autoloader
 */
spl_autoload_register( function ( $class ) {
	$prefix = 'OPA\\Engine\\';
	$base_dir = OPA_ENGINE_DIR . 'src/';

	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}

	$relative_class = substr( $class, $len );
	$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

	if ( file_exists( $file ) ) {
		require $file;
	}
} );

/**
 * Initialize the core plugin
 */
function opa_engine_init() {
	require_once __DIR__ . '/src/Registry/ComponentRegistry.php';
	require_once __DIR__ . '/src/Components/AbstractComponent.php';
	require_once __DIR__ . '/src/Components/Hero/HeroComponent.php';
	require_once __DIR__ . '/src/Components/WhyNT30/WhyNT30Component.php';
	require_once __DIR__ . '/src/Components/WorkPrinciples/WorkPrinciplesComponent.php';
	require_once __DIR__ . '/src/Components/Process/ProcessComponent.php';
	require_once __DIR__ . '/src/Components/Results/ResultsComponent.php';
	require_once __DIR__ . '/src/Components/FAQ/FAQComponent.php';
	require_once __DIR__ . '/src/Components/ContactCTA/ContactCTAComponent.php';
	
	// Initialize Registry & register default components
	$registry = \OPA\LandingEngine\Registry\ComponentRegistry::get_instance();
	$registry->register( 'hero', \OPA\LandingEngine\Components\Hero\HeroComponent::class );
	$registry->register( 'why-nt30', \OPA\LandingEngine\Components\WhyNT30\WhyNT30Component::class );
	$registry->register( 'work-principles', \OPA\LandingEngine\Components\WorkPrinciples\WorkPrinciplesComponent::class );
	$registry->register( 'process', \OPA\LandingEngine\Components\Process\ProcessComponent::class );
	$registry->register( 'results', \OPA\LandingEngine\Components\Results\ResultsComponent::class );
	$registry->register( 'contact', \OPA\LandingEngine\Components\ContactCTA\ContactCTAComponent::class );
	$registry->register( 'faq', \OPA\LandingEngine\Components\FAQ\FAQComponent::class );

	require_once __DIR__ . '/src/Admin/HomeSettings.php';
	require_once __DIR__ . '/src/Renderer/HomeRenderer.php';
	
	$home_settings = new \OPA\LandingEngine\Admin\HomeSettings();
	$home_settings->register();

	$home_renderer = new \OPA\LandingEngine\Renderer\HomeRenderer();
	$home_renderer->register();

	require_once __DIR__ . '/src/Core/MigrationManager.php';
	\OPA\LandingEngine\Core\MigrationManager::init();

	if ( class_exists( '\OPA\Engine\Core\Plugin' ) ) {
		\OPA\Engine\Core\Plugin::get_instance();
	}

	// Initialize Dashboard Manager
	require_once __DIR__ . '/src/Admin/Dashboard/DashboardManager.php';
	// Just instantiating it registers the hooks
	new \OPA\LandingEngine\Admin\Dashboard\DashboardManager();
}

add_action( 'plugins_loaded', 'opa_engine_init' );
