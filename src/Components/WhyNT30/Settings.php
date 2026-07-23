<?php
namespace OPA\LandingEngine\Components\WhyNT30;

use OPA\LandingEngine\Fields\FieldFactory;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings {

	public static function register( $component, $page, $section ) {
		$id = $component->get_id();
		$defaults = $component->get_defaults();

		add_settings_field(
			$id . '_enable',
			__( 'Enable Section', 'opa-engine' ),
			[ self::class, 'render_checkbox' ],
			$page,
			$section,
			[ 'id' => $id . '_enable', 'default' => '1' ]
		);

		add_settings_field(
			'opa_why_title',
			__( 'Section Title', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_why_title', 'default' => $defaults['opa_why_title'] ]
		);

		add_settings_field(
			'opa_why_subtitle',
			__( 'Section Subtitle', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_why_subtitle', 'default' => $defaults['opa_why_subtitle'] ]
		);

		add_settings_field(
			'opa_why_features',
			__( 'Feature Cards', 'opa-engine' ),
			[ self::class, 'render_repeater' ],
			$page,
			$section,
			[ 'id' => 'opa_why_features', 'default' => $defaults['opa_why_features'] ]
		);

		add_settings_field(
			'opa_why_btn_label',
			__( 'Button Label', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_why_btn_label', 'default' => $defaults['opa_why_btn_label'] ]
		);

		add_settings_field(
			'opa_why_btn_url',
			__( 'Button URL', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_why_btn_url', 'default' => $defaults['opa_why_btn_url'] ]
		);

		add_settings_field(
			'opa_why_bg_image',
			__( 'Background Sketch Image', 'opa-engine' ),
			[ self::class, 'render_media' ],
			$page,
			$section,
			[ 'id' => 'opa_why_bg_image', 'default' => '' ]
		);
	}

	public static function render_text( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		
		echo '<input type="text" id="' . esc_attr( $id ) . '" name="opa_home_settings[' . esc_attr( $id ) . ']" value="' . esc_attr( $value ) . '" class="regular-text">';
	}

	public static function render_checkbox( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '0';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		
		$checked = checked( '1', $value, false );
		echo '<input type="hidden" name="opa_home_settings[' . esc_attr( $id ) . ']" value="0">';
		echo '<input type="hidden" name="opa_home_settings[' . esc_attr( $id ) . ']" value="0">';
		echo '<input type="checkbox" id="' . esc_attr( $id ) . '" name="opa_home_settings[' . esc_attr( $id ) . ']" value="1" ' . $checked . '>';
	}

	public static function render_repeater( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : [];
		$items   = isset( $options[ $id ] ) && is_array( $options[ $id ] ) ? $options[ $id ] : $default;
		
		if ( empty( $items ) ) {
			$items = $default;
		}

		?>
		<div class="opa-repeater" id="opa-whynt30-repeater" style="max-width: 800px;">
			<div class="opa-repeater-container" id="opa-whynt30-items-container">
				<?php foreach ( $items as $index => $item ) : ?>
					<div class="opa-repeater-row" style="display:flex; flex-wrap: wrap; gap:10px; margin-bottom:15px; background:#fff; padding:16px; border:1px solid #ccd0d4; border-radius:4px; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
						<div style="width:100%; display:flex; flex-direction:column; gap:10px;">
							<label style="font-weight:600;">Icon (clock, users, shield, check)</label>
							<input type="text" name="opa_home_settings[<?php echo esc_attr($id); ?>][<?php echo $index; ?>][icon]" value="<?php echo esc_attr( $item['icon'] ?? 'check' ); ?>" class="regular-text">
							
							<label style="font-weight:600;">Title</label>
							<input type="text" name="opa_home_settings[<?php echo esc_attr($id); ?>][<?php echo $index; ?>][title]" value="<?php echo esc_attr( $item['title'] ?? '' ); ?>" class="large-text">
							
							<label style="font-weight:600;">Description</label>
							<textarea name="opa_home_settings[<?php echo esc_attr($id); ?>][<?php echo $index; ?>][description]" rows="3" class="large-text"><?php echo esc_textarea( $item['description'] ?? '' ); ?></textarea>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	public static function render_media( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		?>
		<div class="opa-media-uploader">
			<input type="text" id="<?php echo esc_attr($id); ?>" name="opa_home_settings[<?php echo esc_attr($id); ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text opa-media-input" style="margin-bottom: 5px; display: block;">
			<button type="button" class="button opa-media-button"><?php esc_html_e( 'Choose Image', 'opa-engine' ); ?></button>
		</div>
		<?php
	}
}
