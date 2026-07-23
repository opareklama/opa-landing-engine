<?php
namespace OPA\LandingEngine\Admin\Dashboard\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LogsWidget extends AbstractWidget {

	public function get_id() {
		return 'logs';
	}

	public function get_title() {
		return __( 'Recent Logs', 'opa-engine' );
	}

	public function get_icon() {
		return '<span class="dashicons dashicons-media-text"></span>';
	}

	protected function get_data() {
		// Mocked logs or fetched from a real DB table if implemented
		// Currently OPA Engine does not store logs in DB. We will just show placeholder / read-only system events
		return [
			[
				'time'    => current_time('mysql'),
				'type'    => 'info',
				'message' => 'Dashboard accessed successfully.',
			],
			[
				'time'    => current_time('mysql'),
				'type'    => 'info',
				'message' => 'System environment verified.',
			]
		];
	}

	protected function render_content() {
		$logs = $this->get_cached_data();
		?>
		<div class="opa-dash-logs">
			<?php if ( empty( $logs ) ) : ?>
				<p>No recent logs found.</p>
			<?php else : ?>
				<?php foreach ( $logs as $log ) : 
					$color = $log['type'] === 'error' ? 'red' : ($log['type'] === 'warning' ? 'yellow' : 'blue');
				?>
					<div class="opa-dash-log-item">
						<span class="opa-log-time">[<?php echo esc_html( date('H:i', strtotime($log['time'])) ); ?>]</span>
						<span class="opa-badge opa-badge--<?php echo esc_attr( $color ); ?>"><?php echo esc_html( strtoupper($log['type']) ); ?></span>
						<span class="opa-log-msg"><?php echo esc_html( $log['message'] ); ?></span>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<?php
	}
}
