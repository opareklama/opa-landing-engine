<?php
namespace OPA\LandingEngine\Admin\Dashboard;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DashboardManager {
	
	private $widgets = [];
	
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );
		add_action( 'wp_ajax_opa_dash_refresh', [ $this, 'ajax_refresh' ] );
		
		$this->register_default_widgets();
	}
	
	public function register_widget( $widget ) {
		if ( $widget instanceof Widgets\AbstractWidget ) {
			$this->widgets[ $widget->get_id() ] = $widget;
		}
	}
	
	private function register_default_widgets() {
		require_once __DIR__ . '/Widgets/AbstractWidget.php';
		
		// Include widget files
		$widget_files = [
			'WebsiteWidget',
			'LandingEngineWidget',
			'ComponentStatusWidget',
			'HealthWidget',
			'PerformanceWidget',
			'SecurityWidget',
			'SEOWidget',
			'UpdateCenterWidget',
			'LogsWidget',
			'RecommendationsWidget',
			'ServerInfoWidget',
		];
		
		foreach ( $widget_files as $file ) {
			$path = __DIR__ . '/Widgets/' . $file . '.php';
			if ( file_exists( $path ) ) {
				require_once $path;
				$class = '\\OPA\\LandingEngine\\Admin\\Dashboard\\Widgets\\' . $file;
				if ( class_exists( $class ) ) {
					$this->register_widget( new $class() );
				}
			}
		}
	}
	
	public function enqueue_assets( $hook ) {
		// Only enqueue on our specific dashboard page
		if ( strpos( $hook, 'opa-landing-engine' ) !== false ) {
			wp_enqueue_style( 'opa-dashboard-css', OPA_ENGINE_URL . 'src/Admin/Dashboard/Assets/dashboard.css', [], OPA_ENGINE_VERSION );
			wp_enqueue_script( 'opa-dashboard-js', OPA_ENGINE_URL . 'src/Admin/Dashboard/Assets/dashboard.js', [ 'jquery' ], OPA_ENGINE_VERSION, true );
			
			wp_localize_script( 'opa-dashboard-js', 'opaDashParams', [
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'opa_dash_refresh_nonce' )
			] );
		}
	}
	
	public function ajax_refresh() {
		check_ajax_referer( 'opa_dash_refresh_nonce', 'nonce' );
		
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'Unauthorized' );
		}
		
		// Clear all widget caches
		foreach ( $this->widgets as $widget ) {
			$widget->clear_cache();
		}
		
		wp_send_json_success( 'Dashboard refreshed successfully.' );
	}
	
	public function render() {
		?>
		<div class="wrap opa-dash-wrap">
			<div class="opa-dash-header">
				<div class="opa-dash-header__info">
					<h1><?php esc_html_e( 'OPA Command Center', 'opa-engine' ); ?></h1>
					<p><?php esc_html_e( 'Comprehensive overview of your website environment.', 'opa-engine' ); ?></p>
				</div>
				<div class="opa-dash-header__actions">
					<button type="button" class="button button-primary opa-dash-refresh-btn">
						<span class="dashicons dashicons-update-alt"></span> 
						<?php esc_html_e( 'Refresh Data', 'opa-engine' ); ?>
					</button>
				</div>
			</div>
			
			<div class="opa-dash-grid">
				<?php 
				foreach ( $this->widgets as $widget ) {
					$widget->render();
				}
				?>
			</div>
		</div>
		<?php
	}
}
