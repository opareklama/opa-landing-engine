<?php
namespace OPA\LandingEngine\Admin;

use OPA\LandingEngine\Registry\ComponentRegistry;

/**
 * Handles the "NT30 Home" Tabbed Admin Dashboard and Section Builder
 */
class HomeSettings {

	private $page_hook;

	public function register() {
		add_action( 'admin_menu', [ $this, 'add_menu_page' ], 20 );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	public function add_menu_page() {
		$this->page_hook = add_submenu_page(
			'opa-landing-engine',
			__( 'NT30 Home', 'opa-engine' ),
			__( 'NT30 Home', 'opa-engine' ),
			'manage_options',
			'opa-engine-home',
			[ $this, 'render_admin_page' ]
		);
	}

	public function register_settings() {
		// Register a single option array to store the entire state
		register_setting( 'opa_home_settings_group', 'opa_home_settings' );

		// We would normally loop through ComponentRegistry to register fields.
		// For the Hero demo, it's explicitly done via the component.
		$registry = ComponentRegistry::get_instance();
		$components = $registry->get_all();
		
		foreach ( $components as $id => $class ) {
			$instance = new $class();
			$instance->register_settings( 'opa-engine-home', 'opa_home_' . $id . '_section' );
		}
	}

	public function enqueue_admin_assets( $hook ) {
		if ( $this->page_hook !== $hook ) {
			return;
		}
		
		// Enqueue WordPress media library scripts
		wp_enqueue_media();
		
		// Enqueue the custom tab & drag-drop logic
		wp_enqueue_style( 'opa-admin-ui', plugin_dir_url( __FILE__ ) . 'Assets/admin-ui.css', [], '1.0.0' );
		wp_enqueue_script( 'opa-admin-ui', plugin_dir_url( __FILE__ ) . 'Assets/admin-ui.js', [], '1.0.0', true );
	}

	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$registry = ComponentRegistry::get_instance();
		$components = $registry->get_all();
		$settings = get_option( 'opa_home_settings', [] );

		// Retrieve saved order, or default to registered order
		$saved_order = isset( $settings['component_order'] ) ? explode( ',', $settings['component_order'] ) : array_keys( $components );

		?>
		<div class="wrap opa-admin-wrap">
			<h1><?php esc_html_e( 'NT30 Home', 'opa-engine' ); ?></h1>
			
			<form action="options.php" method="post" id="opa-home-form">
				<?php settings_fields( 'opa_home_settings_group' ); ?>
				
				<!-- Hidden field to store order -->
				<input type="hidden" name="opa_home_settings[component_order]" id="opa-component-order" value="<?php echo esc_attr( implode( ',', $saved_order ) ); ?>">

				<div class="opa-admin-layout">
					
					<!-- Top Horizontal Tabs -->
					<h2 class="nav-tab-wrapper opa-admin-tabs" id="opa-admin-tabs">
						<a href="#tab-general" class="nav-tab nav-tab-active" data-tab="general"><?php esc_html_e( 'General', 'opa-engine' ); ?></a>
						<a href="#tab-builder" class="nav-tab" data-tab="builder"><?php esc_html_e( 'Section Builder', 'opa-engine' ); ?></a>
						<?php foreach ( $components as $id => $class ) : 
							$instance = new $class();
						?>
							<a href="#tab-<?php echo esc_attr( $id ); ?>" class="nav-tab" data-tab="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $instance->get_name() ); ?></a>
						<?php endforeach; ?>
					</h2>

					<!-- Content Area -->
					<div class="opa-admin-content">
						
						<!-- General Tab -->
						<div class="opa-tab-panel is-active" id="tab-general">
							<h2><?php esc_html_e( 'General Settings', 'opa-engine' ); ?></h2>
							<table class="form-table">
								<tr>
									<th scope="row"><label for="opa_enable_home"><?php esc_html_e( 'Enable Home Page', 'opa-engine' ); ?></label></th>
									<td>
										<input type="hidden" name="opa_home_settings[enable_home]" value="0">
										<input type="checkbox" name="opa_home_settings[enable_home]" id="opa_enable_home" value="1" <?php checked( '1', $settings['enable_home'] ?? '1' ); ?>>
									</td>
								</tr>
								<tr>
									<th scope="row"><label for="opa_global_padding"><?php esc_html_e( 'Section Gap (Padding)', 'opa-engine' ); ?></label></th>
									<td>
										<input type="number" name="opa_home_settings[global_padding]" id="opa_global_padding" value="<?php echo esc_attr( $settings['global_padding'] ?? '120' ); ?>" class="small-text"> px
										<p class="description"><?php esc_html_e( 'Adjust the top/bottom gap between all sections (Default: 120).', 'opa-engine' ); ?></p>
									</td>
								</tr>
								<!-- Other general settings... -->
							</table>
						</div>

						<!-- Section Builder Tab -->
						<div class="opa-tab-panel" id="tab-builder">
							<h2><?php esc_html_e( 'Drag & Drop Section Builder', 'opa-engine' ); ?></h2>
							<p class="description"><?php esc_html_e( 'Drag to reorder the sections on the home page.', 'opa-engine' ); ?></p>
							
							<ul class="opa-sortable-list" id="opa-section-builder">
								<?php foreach ( $saved_order as $id ) : 
									if ( ! isset( $components[ $id ] ) ) continue;
									$instance = new $components[$id]();
									$is_enabled = $instance->is_enabled();
								?>
									<li class="opa-sortable-item" draggable="true" data-id="<?php echo esc_attr( $id ); ?>">
										<div class="opa-sortable-handle">☰</div>
										<div class="opa-sortable-name"><?php echo esc_html( $instance->get_name() ); ?></div>
										<div class="opa-sortable-status">
											<span class="badge <?php echo $is_enabled ? 'badge-success' : 'badge-disabled'; ?>">
												<?php echo $is_enabled ? 'Active' : 'Disabled'; ?>
											</span>
										</div>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>

						<!-- Component Tabs -->
						<?php foreach ( $components as $id => $class ) : ?>
							<div class="opa-tab-panel" id="tab-<?php echo esc_attr( $id ); ?>">
								<h2><?php echo esc_html( (new $class())->get_name() ); ?> <?php esc_html_e( 'Settings', 'opa-engine' ); ?></h2>
								<table class="form-table">
									<?php do_settings_fields( 'opa-engine-home', 'opa_home_' . $id . '_section' ); ?>
								</table>
							</div>
						<?php endforeach; ?>

						<?php submit_button(); ?>
					</div>
				</div>
			</form>
		</div>
		<?php
	}
}
