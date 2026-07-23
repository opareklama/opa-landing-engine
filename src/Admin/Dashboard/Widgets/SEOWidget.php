<?php
namespace OPA\LandingEngine\Admin\Dashboard\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SEOWidget extends AbstractWidget {

	public function get_id() {
		return 'seo';
	}

	public function get_title() {
		return __( 'SEO Overview', 'opa-engine' );
	}

	public function get_icon() {
		return '<span class="dashicons dashicons-search"></span>';
	}

	protected function get_data() {
		$blog_public = get_option('blog_public');
		
		// Simple heuristic check for XML sitemap (Yoast, RankMath, etc often generate this)
		$sitemap_url = site_url('/sitemap_index.xml');
		
		// Check active SEO plugins
		$active_plugins = get_option('active_plugins', []);
		$seo_plugin = 'None Detected';
		
		foreach ($active_plugins as $plugin) {
			if ( strpos( strtolower($plugin), 'wordpress-seo' ) !== false ) {
				$seo_plugin = 'Yoast SEO';
			} elseif ( strpos( strtolower($plugin), 'seo-by-rank-math' ) !== false ) {
				$seo_plugin = 'Rank Math';
			} elseif ( strpos( strtolower($plugin), 'all-in-one-seo-pack' ) !== false ) {
				$seo_plugin = 'AIOSEO';
			}
		}

		return [
			'indexing'   => $blog_public == '1',
			'seo_plugin' => $seo_plugin,
		];
	}

	protected function render_content() {
		$data = $this->get_cached_data();
		?>
		<ul class="opa-dash-list">
			<li>
				<strong>Search Engine Visibility:</strong> 
				<?php if ( $data['indexing'] ) : ?>
					<span class="opa-status-text opa-status-text--green">Allowed</span>
				<?php else: ?>
					<span class="opa-status-text opa-status-text--red">Discouraged (Hidden)</span>
				<?php endif; ?>
			</li>
			<li><strong>SEO Plugin:</strong> <?php echo esc_html( $data['seo_plugin'] ); ?></li>
			<li><strong>Schema Support:</strong> <span class="opa-status-text opa-status-text--green">Native via Landing Engine</span></li>
			<li><strong>Robots.txt:</strong> Managed by WP</li>
		</ul>
		<?php
	}
}
