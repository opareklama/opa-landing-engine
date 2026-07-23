<?php
namespace OPA\LandingEngine\Admin\Dashboard\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UpdateCenterWidget extends AbstractWidget {

	public function get_id() {
		return 'updates';
	}

	public function get_title() {
		return __( 'Update Center', 'opa-engine' );
	}

	public function get_icon() {
		return '<span class="dashicons dashicons-update"></span>';
	}

	protected function get_data() {
		$core_updates = get_site_transient('update_core');
		$plugin_updates = get_site_transient('update_plugins');
		$theme_updates = get_site_transient('update_themes');
		
		$core_pending = 0;
		if ( isset($core_updates->updates) && is_array($core_updates->updates) ) {
			foreach ( $core_updates->updates as $update ) {
				if ( $update->response === 'upgrade' ) {
					$core_pending++;
				}
			}
		}
		
		$plugins_pending = isset($plugin_updates->response) ? count($plugin_updates->response) : 0;
		$themes_pending = isset($theme_updates->response) ? count($theme_updates->response) : 0;
		
		return [
			'core'    => $core_pending,
			'plugins' => $plugins_pending,
			'themes'  => $themes_pending,
		];
	}

	protected function render_content() {
		$data = $this->get_cached_data();
		?>
		<ul class="opa-dash-list">
			<li>
				<strong>WordPress Updates:</strong> 
				<?php if ( $data['core'] > 0 ) : ?>
					<span class="opa-badge opa-badge--yellow"><?php echo esc_html( $data['core'] ); ?> Available</span>
				<?php else: ?>
					<span class="opa-badge opa-badge--green">Up to date</span>
				<?php endif; ?>
			</li>
			<li>
				<strong>Plugin Updates:</strong> 
				<?php if ( $data['plugins'] > 0 ) : ?>
					<span class="opa-badge opa-badge--yellow"><?php echo esc_html( $data['plugins'] ); ?> Available</span>
				<?php else: ?>
					<span class="opa-badge opa-badge--green">Up to date</span>
				<?php endif; ?>
			</li>
			<li>
				<strong>Theme Updates:</strong> 
				<?php if ( $data['themes'] > 0 ) : ?>
					<span class="opa-badge opa-badge--yellow"><?php echo esc_html( $data['themes'] ); ?> Available</span>
				<?php else: ?>
					<span class="opa-badge opa-badge--green">Up to date</span>
				<?php endif; ?>
			</li>
		</ul>
		<div class="opa-dash-alert opa-dash-alert--blue" style="margin-top: 15px;">
			<span class="dashicons dashicons-info"></span> Manage updates safely from the WordPress Updates page.
		</div>
		<?php
	}
}
