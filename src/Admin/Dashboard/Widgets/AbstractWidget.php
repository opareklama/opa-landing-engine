<?php
namespace OPA\LandingEngine\Admin\Dashboard\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class AbstractWidget {
	
	/**
	 * Get the unique ID of the widget.
	 *
	 * @return string
	 */
	abstract public function get_id();

	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	abstract public function get_title();

	/**
	 * Fetch raw data. Can be cached by the widget.
	 *
	 * @return mixed
	 */
	abstract protected function get_data();

	/**
	 * Get the widget icon (Dashicon or SVG).
	 *
	 * @return string
	 */
	public function get_icon() {
		return '<span class="dashicons dashicons-admin-generic"></span>';
	}

	/**
	 * Clear the cache for this widget.
	 */
	public function clear_cache() {
		delete_transient( 'opa_dash_' . $this->get_id() );
	}

	/**
	 * Wrapper to fetch data with transient caching.
	 *
	 * @param int $expiration Time in seconds (default 12 hours).
	 * @return mixed
	 */
	protected function get_cached_data( $expiration = 43200 ) {
		$cache_key = 'opa_dash_' . $this->get_id();
		$data      = get_transient( $cache_key );

		if ( false === $data ) {
			$data = $this->get_data();
			set_transient( $cache_key, $data, $expiration );
		}

		return $data;
	}

	/**
	 * Render the widget content.
	 */
	abstract protected function render_content();

	/**
	 * Render the full widget card.
	 */
	public function render() {
		?>
		<div class="opa-dash-card" id="opa-dash-card-<?php echo esc_attr( $this->get_id() ); ?>">
			<div class="opa-dash-card__header">
				<div class="opa-dash-card__title">
					<?php echo wp_kses_post( $this->get_icon() ); ?>
					<h3><?php echo esc_html( $this->get_title() ); ?></h3>
				</div>
			</div>
			<div class="opa-dash-card__content">
				<?php $this->render_content(); ?>
			</div>
		</div>
		<?php
	}
}
