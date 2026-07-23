<?php
namespace OPA\Engine\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Menu {

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_menus' ] );
	}

	public function register_menus() {
		add_menu_page(
			__( 'NT30', 'opa-engine' ),
			__( 'NT30', 'opa-engine' ),
			'manage_options',
			'opa-landing-engine',
			[ $this, 'render_dashboard' ],
			'dashicons-building',
			2 // Position it near the top
		);

		// Rename the first default submenu from 'AntyGravity' to 'Dashboard'
		add_submenu_page(
			'opa-landing-engine',
			__( 'Dashboard', 'opa-engine' ),
			__( 'Dashboard', 'opa-engine' ),
			'manage_options',
			'opa-landing-engine',
			[ $this, 'render_dashboard' ]
		);

		add_submenu_page(
			'opa-landing-engine',
			__( 'Global Settings', 'opa-engine' ),
			__( 'Global Settings', 'opa-engine' ),
			'manage_options',
			'opa-global-settings',
			[ $this, 'render_global_settings' ]
		);
	}

	public function render_dashboard() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'NT30 Dashboard', 'opa-engine' ); ?></h1>
			<p><?php esc_html_e( 'Welcome to the NT30 Landing Page engine. Manage your globally optimized, modular landing page from here.', 'opa-engine' ); ?></p>
		</div>
		<?php
	}

	public function render_global_settings() {
		// Will render the global settings form
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Global Settings', 'opa-engine' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'opa_global_settings_group' );
				do_settings_sections( 'opa-global-settings' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}
