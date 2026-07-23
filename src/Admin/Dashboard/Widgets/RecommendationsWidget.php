<?php
namespace OPA\LandingEngine\Admin\Dashboard\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RecommendationsWidget extends AbstractWidget {

	public function get_id() {
		return 'recommendations';
	}

	public function get_title() {
		return __( 'Recommendations', 'opa-engine' );
	}

	public function get_icon() {
		return '<span class="dashicons dashicons-lightbulb"></span>';
	}

	protected function get_data() {
		$recs = [];
		
		if ( ! function_exists( 'opcache_get_status' ) || ! opcache_get_status() ) {
			$recs[] = 'Enable PHP OPcache for better performance.';
		}
		
		if ( defined('WP_DEBUG') && WP_DEBUG ) {
			$recs[] = 'Disable WP_DEBUG in production (wp-config.php).';
		}
		
		if ( intval(ini_get('memory_limit')) < 256 ) {
			$recs[] = 'Increase WP_MEMORY_LIMIT to at least 256M.';
		}

		if ( version_compare(PHP_VERSION, '8.0', '<') ) {
			$recs[] = 'Update PHP to version 8.0 or higher for significant performance gains.';
		}
		
		if ( ! wp_using_ext_object_cache() ) {
			$recs[] = 'Enable a persistent Object Cache (Redis or Memcached).';
		}

		return $recs;
	}

	protected function render_content() {
		$recs = $this->get_cached_data();
		?>
		<div class="opa-dash-recommendations">
			<?php if ( empty( $recs ) ) : ?>
				<div class="opa-dash-alert opa-dash-alert--green">
					<span class="dashicons dashicons-yes"></span> Your environment is perfectly optimized!
				</div>
			<?php else : ?>
				<ul class="opa-dash-list opa-dash-list--bullets">
					<?php foreach ( $recs as $rec ) : ?>
						<li><?php echo esc_html( $rec ); ?></li>
					<?php endforeach; ?>
				</ul>
				<div class="opa-dash-alert opa-dash-alert--blue" style="margin-top: 15px;">
					<span class="dashicons dashicons-info"></span> These are read-only recommendations. Consult your host before making server changes.
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
