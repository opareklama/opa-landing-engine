<?php
namespace OPA\LandingEngine\Core;

use OPA\LandingEngine\Registry\ComponentRegistry;

/**
 * Migration Manager
 * Safely merges new defaults without overwriting client data.
 */
class MigrationManager {

	const DB_VERSION_OPTION = 'opa_engine_db_version';

	public static function init() {
		add_action( 'admin_init', [ self::class, 'run_migrations' ] );
	}

	public static function run_migrations() {
		$current_version = get_option( self::DB_VERSION_OPTION, '0.0.0' );
		$code_version    = OPA_ENGINE_VERSION;

		if ( version_compare( $current_version, $code_version, '<' ) ) {
			self::migrate_settings();
			update_option( self::DB_VERSION_OPTION, $code_version );
		}
	}

	private static function migrate_settings() {
		$existing_settings = get_option( 'opa_home_settings', [] );
		$new_settings      = $existing_settings;
		$changed           = false;

		// Merge component defaults safely
		$registry = ComponentRegistry::get_instance();
		$components = $registry->get_all();

		foreach ( $components as $id => $class ) {
			$instance = new $class();
			$defaults = $instance->get_defaults();

			foreach ( $defaults as $key => $value ) {
				// Only add the key if it does NOT exist.
				// This preserves empty strings or unchecked values (0).
				if ( ! array_key_exists( $key, $new_settings ) ) {
					$new_settings[ $key ] = $value;
					$changed = true;
				}
			}
		}

		if ( $changed ) {
			update_option( 'opa_home_settings', $new_settings );
		}
	}
}
