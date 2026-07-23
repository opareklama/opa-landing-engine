<?php
namespace OPA\LandingEngine\Admin\Dashboard\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ServerInfoWidget extends AbstractWidget {

	public function get_id() {
		return 'server';
	}

	public function get_title() {
		return __( 'Server Information', 'opa-engine' );
	}

	public function get_icon() {
		return '<span class="dashicons dashicons-networking"></span>';
	}

	protected function get_data() {
		$memory_usage = function_exists('memory_get_usage') ? round(memory_get_usage() / 1024 / 1024, 2) . ' MB' : 'N/A';
		
		$extensions = [];
		if (extension_loaded('curl')) $extensions[] = 'cURL';
		if (extension_loaded('mbstring')) $extensions[] = 'mbstring';
		if (extension_loaded('gd')) $extensions[] = 'GD';
		if (extension_loaded('imagick')) $extensions[] = 'Imagick';
		if (extension_loaded('zip')) $extensions[] = 'Zip';
		if (extension_loaded('exif')) $extensions[] = 'Exif';
		
		return [
			'os'             => PHP_OS,
			'max_execution'  => ini_get('max_execution_time'),
			'max_input_vars' => ini_get('max_input_vars'),
			'post_max_size'  => ini_get('post_max_size'),
			'upload_max'     => ini_get('upload_max_filesize'),
			'memory_limit'   => ini_get('memory_limit'),
			'memory_usage'   => $memory_usage,
			'extensions'     => implode(', ', $extensions),
		];
	}

	protected function render_content() {
		$data = $this->get_cached_data();
		?>
		<ul class="opa-dash-list">
			<li><strong>Operating System:</strong> <?php echo esc_html( $data['os'] ); ?></li>
			<li><strong>Max Execution Time:</strong> <?php echo esc_html( $data['max_execution'] ); ?>s</li>
			<li><strong>Max Input Vars:</strong> <?php echo esc_html( $data['max_input_vars'] ); ?></li>
			<li><strong>Post Max Size:</strong> <?php echo esc_html( $data['post_max_size'] ); ?></li>
			<li><strong>Upload Max Filesize:</strong> <?php echo esc_html( $data['upload_max'] ); ?></li>
			<li><strong>Memory Limit:</strong> <?php echo esc_html( $data['memory_limit'] ); ?></li>
			<li><strong>Current Memory Usage:</strong> <?php echo esc_html( $data['memory_usage'] ); ?></li>
			<li><strong>Key Extensions:</strong> <?php echo esc_html( $data['extensions'] ); ?></li>
		</ul>
		<?php
	}
}
