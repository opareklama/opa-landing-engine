<?php
namespace OPA\LandingEngine\Admin\Dashboard\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SecurityWidget extends AbstractWidget {

	public function get_id() {
		return 'security';
	}

	public function get_title() {
		return __( 'Security', 'opa-engine' );
	}

	public function get_icon() {
		return '<span class="dashicons dashicons-shield"></span>';
	}

	protected function get_data() {
		return [
			'ssl'           => is_ssl(),
			'debug'         => defined('WP_DEBUG') && WP_DEBUG,
			'file_editing'  => !defined('DISALLOW_FILE_EDIT') || !DISALLOW_FILE_EDIT,
			'auto_updates'  => apply_filters('automatic_updater_disabled', false) === false,
			'wp_version'    => get_bloginfo('version'),
		];
	}

	protected function render_content() {
		$data = $this->get_cached_data();
		?>
		<ul class="opa-dash-list">
			<li>
				<strong>SSL Enabled:</strong> 
				<?php if ( $data['ssl'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Yes</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--red">No (Critical)</span>
				<?php endif; ?>
			</li>
			<li>
				<strong>Debug Logging:</strong> 
				<?php if ( ! $data['debug'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Disabled</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--yellow">Enabled (Exposed)</span>
				<?php endif; ?>
			</li>
			<li>
				<strong>File Editing (Admin):</strong> 
				<?php if ( ! $data['file_editing'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Disabled</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--yellow">Enabled</span>
				<?php endif; ?>
			</li>
			<li>
				<strong>Core Auto Updates:</strong> 
				<?php if ( $data['auto_updates'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Enabled</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--yellow">Disabled</span>
				<?php endif; ?>
			</li>
		</ul>
		<div class="opa-dash-alert opa-dash-alert--blue" style="margin-top: 15px;">
			<span class="dashicons dashicons-info"></span> Security checks are strictly read-only.
		</div>
		<?php
	}
}
