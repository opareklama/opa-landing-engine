<?php
namespace OPA\LandingEngine\Admin\Dashboard\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PerformanceWidget extends AbstractWidget {

	public function get_id() {
		return 'performance';
	}

	public function get_title() {
		return __( 'Performance', 'opa-engine' );
	}

	public function get_icon() {
		return '<span class="dashicons dashicons-performance"></span>';
	}

	protected function get_data() {
		$registry = \OPA\LandingEngine\Registry\ComponentRegistry::get_instance();
		$components = $registry->get_all();
		
		$total_css = 1; // Global CSS
		$total_js  = 1; // Global JS
		
		foreach ($components as $comp) {
			// In a real app we might inspect the registered assets for each component
			// For now, we estimate based on our architecture (each component has 1 CSS, 1 JS)
			$total_css++;
			$total_js++;
		}
		
		// Check for caching plugins
		$active_plugins = get_option('active_plugins', []);
		$has_cache = false;
		$has_optimizer = false;
		
		foreach ($active_plugins as $plugin) {
			if ( strpos( strtolower($plugin), 'cache' ) !== false || strpos( strtolower($plugin), 'rocket' ) !== false ) {
				$has_cache = true;
			}
			if ( strpos( strtolower($plugin), 'optimize' ) !== false || strpos( strtolower($plugin), 'smush' ) !== false ) {
				$has_optimizer = true;
			}
		}
		
		return [
			'css_files'      => $total_css,
			'js_files'       => $total_js,
			'total_assets'   => $total_css + $total_js,
			'lazy_loading'   => 'Native',
			'page_cache'     => $has_cache,
			'asset_optimize' => $has_optimizer,
		];
	}

	protected function render_content() {
		$data = $this->get_cached_data();
		?>
		<ul class="opa-dash-list">
			<li><strong>CSS Files:</strong> <?php echo esc_html( $data['css_files'] ); ?> (Estimated)</li>
			<li><strong>JS Files:</strong> <?php echo esc_html( $data['js_files'] ); ?> (Estimated)</li>
			<li><strong>Total Assets:</strong> <?php echo esc_html( $data['total_assets'] ); ?></li>
			<li><strong>Lazy Loading:</strong> <?php echo esc_html( $data['lazy_loading'] ); ?></li>
			<li>
				<strong>Page Cache:</strong> 
				<?php if ( $data['page_cache'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Active</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--yellow">None Detected</span>
				<?php endif; ?>
			</li>
			<li>
				<strong>Asset Optimization:</strong> 
				<?php if ( $data['asset_optimize'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Active</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--yellow">None Detected</span>
				<?php endif; ?>
			</li>
		</ul>
		<?php
	}
}
