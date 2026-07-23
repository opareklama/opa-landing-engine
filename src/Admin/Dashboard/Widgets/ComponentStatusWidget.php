<?php
namespace OPA\LandingEngine\Admin\Dashboard\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ComponentStatusWidget extends AbstractWidget {

	public function get_id() {
		return 'components';
	}

	public function get_title() {
		return __( 'Component Status', 'opa-engine' );
	}

	public function get_icon() {
		return '<span class="dashicons dashicons-screenoptions"></span>';
	}

	protected function get_data() {
		$registry = \OPA\LandingEngine\Registry\ComponentRegistry::get_instance();
		$components = $registry->get_all();
		
		$status_list = [];
		foreach ( $components as $id => $class ) {
			$instance = new $class();
			$status_list[ $instance->get_name() ] = $instance->is_enabled() ? 'enabled' : 'disabled';
		}
		
		return $status_list;
	}

	protected function render_content() {
		$components = $this->get_cached_data();
		?>
		<ul class="opa-dash-list opa-dash-list--components">
			<?php foreach ( $components as $name => $status ) : 
				$color = $status === 'enabled' ? 'green' : 'gray';
				$icon  = $status === 'enabled' ? 'yes' : 'no';
			?>
				<li>
					<span class="opa-comp-name"><?php echo esc_html( $name ); ?></span>
					<span class="opa-badge opa-badge--<?php echo esc_attr( $color ); ?>">
						<span class="dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></span>
						<?php echo esc_html( ucfirst( $status ) ); ?>
					</span>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}
