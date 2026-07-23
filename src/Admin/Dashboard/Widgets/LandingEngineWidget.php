<?php
namespace OPA\LandingEngine\Admin\Dashboard\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LandingEngineWidget extends AbstractWidget {

	public function get_id() {
		return 'landing_engine';
	}

	public function get_title() {
		return __( 'Landing Engine', 'opa-engine' );
	}

	public function get_icon() {
		return '<span class="dashicons dashicons-layout"></span>';
	}

	protected function get_data() {
		$registry = \OPA\LandingEngine\Registry\ComponentRegistry::get_instance();
		$components = $registry->get_all();
		
		return [
			'version'          => defined( 'OPA_ENGINE_VERSION' ) ? OPA_ENGINE_VERSION : 'Unknown',
			'db_version'       => get_option( \OPA\LandingEngine\Core\MigrationManager::DB_VERSION_OPTION, '1.0.0' ),
			'installed_comps'  => count( $components ),
			// To check active components, we'd need to parse the global settings
		];
	}

	protected function render_content() {
		$data = $this->get_cached_data();
		$registry = \OPA\LandingEngine\Registry\ComponentRegistry::get_instance();
		$components = $registry->get_all();
		
		// Calculate active components dynamically
		$active = 0;
		foreach ( $components as $id => $class ) {
			$instance = new $class();
			if ( $instance->is_enabled() ) {
				$active++;
			}
		}

		?>
		<ul class="opa-dash-list">
			<li><strong>Plugin Version:</strong> <span class="opa-badge opa-badge--blue">v<?php echo esc_html( $data['version'] ); ?></span></li>
			<li><strong>Database Version:</strong> v<?php echo esc_html( $data['db_version'] ); ?></li>
			<li><strong>Installed Components:</strong> <?php echo esc_html( $data['installed_comps'] ); ?></li>
			<li><strong>Active Components:</strong> <?php echo esc_html( $active ); ?></li>
		</ul>
		<?php
	}
}
