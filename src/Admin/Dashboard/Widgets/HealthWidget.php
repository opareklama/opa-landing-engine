<?php
namespace OPA\LandingEngine\Admin\Dashboard\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class HealthWidget extends AbstractWidget {

	public function get_id() {
		return 'health';
	}

	public function get_title() {
		return __( 'Website Health', 'opa-engine' );
	}

	public function get_icon() {
		return '<span class="dashicons dashicons-heart"></span>';
	}

	protected function get_data() {
		// Read-only checks
		$upload_dir = wp_upload_dir();
		$can_upload = wp_is_writable( $upload_dir['basedir'] );
		
		$is_ssl = is_ssl();
		$debug_on = defined('WP_DEBUG') && WP_DEBUG;
		$memory_ok = intval(ini_get('memory_limit')) >= 128;
		$php_ok = version_compare(PHP_VERSION, '7.4', '>=');
		$permalinks = get_option('permalink_structure') ? true : false;
		
		return [
			'uploads_writable' => $can_upload,
			'ssl'              => $is_ssl,
			'debug'            => $debug_on,
			'memory_ok'        => $memory_ok,
			'php_ok'           => $php_ok,
			'permalinks'       => $permalinks,
		];
	}

	protected function render_content() {
		$data = $this->get_cached_data();
		?>
		<ul class="opa-dash-list">
			<li>
				<strong>File Permissions:</strong> 
				<?php if ( $data['uploads_writable'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Healthy</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--red">Uploads Not Writable</span>
				<?php endif; ?>
			</li>
			<li>
				<strong>SSL Status:</strong> 
				<?php if ( $data['ssl'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Secured</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--red">Not Secure</span>
				<?php endif; ?>
			</li>
			<li>
				<strong>Debug Mode:</strong> 
				<?php if ( ! $data['debug'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Disabled</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--yellow">Enabled (Warning)</span>
				<?php endif; ?>
			</li>
			<li>
				<strong>Memory Limit:</strong> 
				<?php if ( $data['memory_ok'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Healthy</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--yellow">Low</span>
				<?php endif; ?>
			</li>
			<li>
				<strong>PHP Version:</strong> 
				<?php if ( $data['php_ok'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Supported</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--red">Outdated</span>
				<?php endif; ?>
			</li>
			<li>
				<strong>Permalinks:</strong> 
				<?php if ( $data['permalinks'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Active</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--red">Default (Warning)</span>
				<?php endif; ?>
			</li>
		</ul>
		<?php
	}
}
