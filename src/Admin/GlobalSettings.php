<?php
namespace OPA\Engine\Admin;

use OPA\Engine\Fields\FieldFactory;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GlobalSettings {

	public function __construct() {
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	public function register_settings() {
		register_setting( 'opa_global_settings_group', 'opa_global_settings' );

		// Theme Section
		add_settings_section(
			'opa_global_theme_section',
			__( 'Theme & Branding', 'opa-engine' ),
			null,
			'opa-global-settings'
		);

		// Contact Section
		add_settings_section(
			'opa_global_contact_section',
			__( 'Contact Information', 'opa-engine' ),
			null,
			'opa-global-settings'
		);

		$this->register_theme_fields();
		$this->register_contact_fields();
	}

	private function register_theme_fields() {
		add_settings_field(
			'opa_primary_accent',
			__( 'Primary Accent Color', 'opa-engine' ),
			[ $this, 'render_field' ],
			'opa-global-settings',
			'opa_global_theme_section',
			[
				'id'      => 'opa_primary_accent',
				'type'    => 'color',
				'default' => '#C9A14A',
			]
		);
		
		add_settings_field(
			'opa_dark_background',
			__( 'Dark Background Color', 'opa-engine' ),
			[ $this, 'render_field' ],
			'opa-global-settings',
			'opa_global_theme_section',
			[
				'id'      => 'opa_dark_background',
				'type'    => 'color',
				'default' => '#0F172A',
			]
		);
	}

	private function register_contact_fields() {
		add_settings_field(
			'opa_contact_phone',
			__( 'Phone Number', 'opa-engine' ),
			[ $this, 'render_field' ],
			'opa-global-settings',
			'opa_global_contact_section',
			[
				'id'      => 'opa_contact_phone',
				'type'    => 'text',
				'default' => '',
			]
		);

		add_settings_field(
			'opa_contact_email',
			__( 'Email Address', 'opa-engine' ),
			[ $this, 'render_field' ],
			'opa-global-settings',
			'opa_global_contact_section',
			[
				'id'      => 'opa_contact_email',
				'type'    => 'email',
				'default' => '',
			]
		);
	}

	public function render_field( $args ) {
		$options = get_option( 'opa_global_settings' );
		$id      = $args['id'];
		$type    = $args['type'];
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $args['default'];
		
		// Use the FieldFactory to render
		FieldFactory::render( $type, 'opa_global_settings[' . $id . ']', $value );
	}
}
