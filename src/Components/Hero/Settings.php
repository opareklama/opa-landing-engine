<?php
namespace OPA\LandingEngine\Components\Hero;

/**
 * Settings for Hero Component
 */
class Settings {

	public static function register( $component, $page, $section ) {
		$prefix = $component->settings_prefix;

		// We would integrate with our FieldRegistry or FieldFactory here.
		// For the sake of this component, we simulate the settings registration.
		// In a full build, this would map directly to our tabbed admin UI array.

		add_settings_field(
			$prefix . 'enable',
			__( 'Enable Hero Section', 'opa-engine' ),
			[ self::class, 'render_checkbox' ],
			$page,
			$section,
			[ 'id' => $prefix . 'enable', 'component' => $component ]
		);

		add_settings_field(
			$prefix . 'badge',
			__( 'Badge Text', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => $prefix . 'badge', 'component' => $component ]
		);

		add_settings_field(
			$prefix . 'headline',
			__( 'Headline (H1)', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => $prefix . 'headline', 'component' => $component ]
		);

		add_settings_field(
			$prefix . 'description',
			__( 'Description', 'opa-engine' ),
			[ self::class, 'render_textarea' ],
			$page,
			$section,
			[ 'id' => $prefix . 'description', 'component' => $component ]
		);

		add_settings_field(
			$prefix . 'primary_button_label',
			__( 'Primary Button Label', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => $prefix . 'primary_button_label', 'component' => $component ]
		);

		add_settings_field(
			$prefix . 'primary_button_url',
			__( 'Primary Button URL', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => $prefix . 'primary_button_url', 'component' => $component ]
		);

		add_settings_field(
			$prefix . 'secondary_button_label',
			__( 'Secondary Button Label', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => $prefix . 'secondary_button_label', 'component' => $component ]
		);

		add_settings_field(
			$prefix . 'secondary_button_url',
			__( 'Secondary Button URL', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => $prefix . 'secondary_button_url', 'component' => $component ]
		);
		
		add_settings_field(
			$prefix . 'background_image',
			__( 'Background Image', 'opa-engine' ),
			[ self::class, 'render_media' ],
			$page,
			$section,
			[ 'id' => $prefix . 'background_image', 'component' => $component ]
		);

		add_settings_field(
			$prefix . 'mobile_background_image',
			__( 'Mobile Background Image', 'opa-engine' ),
			[ self::class, 'render_media' ],
			$page,
			$section,
			[ 'id' => $prefix . 'mobile_background_image', 'component' => $component ]
		);
	}

	public static function render_text( $args ) {
		$value = $args['component']->get_setting( str_replace( $args['component']->settings_prefix, '', $args['id'] ) );
		echo '<input type="text" id="' . esc_attr( $args['id'] ) . '" name="opa_home_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $value ) . '" class="regular-text">';
	}

	public static function render_checkbox( $args ) {
		$value = $args['component']->get_setting( str_replace( $args['component']->settings_prefix, '', $args['id'] ) );
		$checked = checked( '1', $value, false );
		echo '<input type="hidden" name="opa_home_settings[' . esc_attr( $args['id'] ) . ']" value="0">';
		echo '<input type="checkbox" id="' . esc_attr( $args['id'] ) . '" name="opa_home_settings[' . esc_attr( $args['id'] ) . ']" value="1" ' . $checked . '>';
	}

	public static function render_textarea( $args ) {
		$value = $args['component']->get_setting( str_replace( $args['component']->settings_prefix, '', $args['id'] ) );
		echo '<textarea id="' . esc_attr( $args['id'] ) . '" name="opa_home_settings[' . esc_attr( $args['id'] ) . ']" class="large-text" rows="5">' . esc_textarea( $value ) . '</textarea>';
	}

	public static function render_media( $args ) {
		$value = $args['component']->get_setting( str_replace( $args['component']->settings_prefix, '', $args['id'] ) );
		$id = esc_attr( $args['id'] );
		?>
		<div class="opa-media-uploader">
			<input type="text" id="<?php echo $id; ?>" name="opa_home_settings[<?php echo $id; ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text opa-media-input" style="margin-bottom: 5px; display: block;">
			<button type="button" class="button opa-media-button"><?php esc_html_e( 'Choose Image', 'opa-engine' ); ?></button>
		</div>
		<?php
	}
}
