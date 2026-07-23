<?php
namespace OPA\LandingEngine\Components\ContactCTA;

class Settings {
	public static function register( $component, $page, $section ) {
		$defaults = $component->get_defaults();

		add_settings_field(
			'opa_contact_enable',
			__( 'Enable Section', 'opa-engine' ),
			[ self::class, 'render_checkbox' ],
			$page,
			$section,
			[ 'id' => 'opa_contact_enable', 'default' => $defaults['opa_contact_enable'] ]
		);

		add_settings_field(
			'opa_contact_badge',
			__( 'Section Badge', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_contact_badge', 'default' => $defaults['opa_contact_badge'] ]
		);

		add_settings_field(
			'opa_contact_title',
			__( 'Section Title', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_contact_title', 'default' => $defaults['opa_contact_title'] ]
		);

		add_settings_field(
			'opa_contact_desc',
			__( 'Section Description', 'opa-engine' ),
			[ self::class, 'render_textarea' ],
			$page,
			$section,
			[ 'id' => 'opa_contact_desc', 'default' => $defaults['opa_contact_desc'] ]
		);

		add_settings_field(
			'opa_contact_shortcode',
			__( 'Form Shortcode', 'opa-engine' ),
			[ self::class, 'render_textarea_code' ],
			$page,
			$section,
			[ 'id' => 'opa_contact_shortcode', 'default' => $defaults['opa_contact_shortcode'], 'desc' => 'Paste your Contact Form 7 or Gravity Forms shortcode here.' ]
		);

		add_settings_field(
			'opa_contact_phone',
			__( 'Phone Number', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_contact_phone', 'default' => $defaults['opa_contact_phone'] ]
		);

		add_settings_field(
			'opa_contact_email',
			__( 'Email Address', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_contact_email', 'default' => $defaults['opa_contact_email'] ]
		);
	}

	public static function render_text( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		echo '<input type="text" id="' . esc_attr( $id ) . '" name="opa_home_settings[' . esc_attr( $id ) . ']" value="' . esc_attr( $value ) . '" class="regular-text">';
	}

	public static function render_textarea( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		echo '<textarea id="' . esc_attr( $id ) . '" name="opa_home_settings[' . esc_attr( $id ) . ']" class="large-text" rows="3">' . esc_textarea( $value ) . '</textarea>';
	}

	public static function render_textarea_code( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		$desc    = isset( $args['desc'] ) ? $args['desc'] : '';
		echo '<textarea id="' . esc_attr( $id ) . '" name="opa_home_settings[' . esc_attr( $id ) . ']" class="large-text code" rows="2">' . esc_textarea( $value ) . '</textarea>';
		if ( $desc ) echo '<p class="description">' . esc_html( $desc ) . '</p>';
	}

	public static function render_checkbox( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '0';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		$checked = checked( '1', $value, false );
		echo '<input type="hidden" name="opa_home_settings[' . esc_attr( $id ) . ']" value="0">';
		echo '<input type="checkbox" id="' . esc_attr( $id ) . '" name="opa_home_settings[' . esc_attr( $id ) . ']" value="1" ' . $checked . '>';
	}
}
