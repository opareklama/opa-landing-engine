<?php
namespace OPA\LandingEngine\Admin\Dashboard\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WebsiteWidget extends AbstractWidget {

	public function get_id() {
		return 'website';
	}

	public function get_title() {
		return __( 'Website Overview', 'opa-engine' );
	}

	public function get_icon() {
		return '<span class="dashicons dashicons-admin-site"></span>';
	}

	protected function get_data() {
		global $wp_version;
		
		$theme = wp_get_theme();
		$active_plugins = get_option( 'active_plugins', [] );

		return [
			'name'        => get_bloginfo( 'name' ),
			'url'         => get_bloginfo( 'url' ),
			'environment' => wp_get_environment_type(),
			'theme'       => $theme->get( 'Name' ),
			'plugins'     => count( $active_plugins ),
			'wp_version'  => $wp_version,
			'php_version' => PHP_VERSION,
			'mysql'       => $this->get_mysql_version(),
			'server'      => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
			'memory'      => ini_get( 'memory_limit' ),
			'upload'      => ini_get( 'upload_max_filesize' ),
			'timezone'    => wp_timezone_string(),
			'language'    => get_locale(),
		];
	}

	private function get_mysql_version() {
		global $wpdb;
		return $wpdb->db_version();
	}

	protected function render_content() {
		$data = $this->get_cached_data();
		?>
		<ul class="opa-dash-list">
			<li><strong>Site Name:</strong> <?php echo esc_html( $data['name'] ); ?></li>
			<li><strong>URL:</strong> <a href="<?php echo esc_url( $data['url'] ); ?>" target="_blank"><?php echo esc_html( $data['url'] ); ?></a></li>
			<li><strong>Environment:</strong> <span class="opa-badge opa-badge--blue"><?php echo esc_html( ucfirst( $data['environment'] ) ); ?></span></li>
			<li><strong>Active Theme:</strong> <?php echo esc_html( $data['theme'] ); ?></li>
			<li><strong>Active Plugins:</strong> <?php echo esc_html( $data['plugins'] ); ?></li>
			<li><strong>WordPress:</strong> <?php echo esc_html( $data['wp_version'] ); ?></li>
			<li><strong>PHP Version:</strong> <?php echo esc_html( $data['php_version'] ); ?></li>
			<li><strong>MySQL Version:</strong> <?php echo esc_html( $data['mysql'] ); ?></li>
			<li><strong>Server:</strong> <?php echo esc_html( $data['server'] ); ?></li>
			<li><strong>Memory Limit:</strong> <?php echo esc_html( $data['memory'] ); ?></li>
			<li><strong>Upload Limit:</strong> <?php echo esc_html( $data['upload'] ); ?></li>
			<li><strong>Timezone:</strong> <?php echo esc_html( $data['timezone'] ); ?></li>
			<li><strong>Language:</strong> <?php echo esc_html( $data['language'] ); ?></li>
		</ul>
		<?php
	}
}
