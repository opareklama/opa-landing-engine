<?php
namespace OPA\Engine\Components\Footer;

class Settings {
	
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_menu' ], 21 );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	public function register_menu() {
		add_submenu_page(
			'opa-landing-engine',
			__( 'Footer Settings', 'opa-engine' ),
			__( 'Footer Settings', 'opa-engine' ),
			'manage_options',
			'opa-footer-settings',
			[ $this, 'render_page' ]
		);
	}

	public function register_settings() {
		$defaults = Defaults::get();
		register_setting( 'opa_footer_settings_group', 'opa_footer_settings' );

		add_settings_section(
			'opa_footer_general_section',
			__( 'Footer Configuration', 'opa-engine' ),
			null,
			'opa-footer-settings'
		);

		add_settings_field(
			'opa_footer_enable',
			__( 'Enable Footer', 'opa-engine' ),
			[ $this, 'render_checkbox' ],
			'opa-footer-settings',
			'opa_footer_general_section',
			[ 'id' => 'opa_footer_enable', 'default' => $defaults['opa_footer_enable'] ]
		);
		
		add_settings_field(
			'opa_footer_logo',
			__( 'Footer Logo URL', 'opa-engine' ),
			[ $this, 'render_image_upload' ],
			'opa-footer-settings',
			'opa_footer_general_section',
			[ 'id' => 'opa_footer_logo', 'default' => $defaults['opa_footer_logo'] ]
		);

		add_settings_field(
			'opa_footer_desc',
			__( 'Short Description', 'opa-engine' ),
			[ $this, 'render_textarea' ],
			'opa-footer-settings',
			'opa_footer_general_section',
			[ 'id' => 'opa_footer_desc', 'default' => $defaults['opa_footer_desc'] ]
		);

		add_settings_field(
			'opa_footer_phone',
			__( 'Phone', 'opa-engine' ),
			[ $this, 'render_text' ],
			'opa-footer-settings',
			'opa_footer_general_section',
			[ 'id' => 'opa_footer_phone', 'default' => $defaults['opa_footer_phone'] ]
		);

		add_settings_field(
			'opa_footer_email',
			__( 'Email', 'opa-engine' ),
			[ $this, 'render_text' ],
			'opa-footer-settings',
			'opa_footer_general_section',
			[ 'id' => 'opa_footer_email', 'default' => $defaults['opa_footer_email'] ]
		);

		add_settings_field(
			'opa_footer_location',
			__( 'Location', 'opa-engine' ),
			[ $this, 'render_text' ],
			'opa-footer-settings',
			'opa_footer_general_section',
			[ 'id' => 'opa_footer_location', 'default' => $defaults['opa_footer_location'] ]
		);

		add_settings_field(
			'opa_footer_copyright',
			__( 'Copyright Text', 'opa-engine' ),
			[ $this, 'render_text' ],
			'opa-footer-settings',
			'opa_footer_general_section',
			[ 'id' => 'opa_footer_copyright', 'default' => $defaults['opa_footer_copyright'] ]
		);

		add_settings_field(
			'opa_footer_designer_text',
			__( 'Designer Link Text', 'opa-engine' ),
			[ $this, 'render_text' ],
			'opa-footer-settings',
			'opa_footer_general_section',
			[ 'id' => 'opa_footer_designer_text', 'default' => $defaults['opa_footer_designer_text'] ]
		);

		add_settings_field(
			'opa_footer_designer_url',
			__( 'Designer Link URL', 'opa-engine' ),
			[ $this, 'render_text' ],
			'opa-footer-settings',
			'opa_footer_general_section',
			[ 'id' => 'opa_footer_designer_url', 'default' => $defaults['opa_footer_designer_url'] ]
		);
	}

	public function render_text( $args ) {
		$options = get_option( 'opa_footer_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		echo '<input type="text" id="' . esc_attr( $id ) . '" name="opa_footer_settings[' . esc_attr( $id ) . ']" value="' . esc_attr( $value ) . '" class="regular-text">';
	}

	public function render_textarea( $args ) {
		$options = get_option( 'opa_footer_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		echo '<textarea id="' . esc_attr( $id ) . '" name="opa_footer_settings[' . esc_attr( $id ) . ']" class="large-text" rows="3">' . esc_textarea( $value ) . '</textarea>';
	}

	public function render_checkbox( $args ) {
		$options = get_option( 'opa_footer_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '0';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		$checked = checked( '1', $value, false );
		echo '<input type="checkbox" id="' . esc_attr( $id ) . '" name="opa_footer_settings[' . esc_attr( $id ) . ']" value="1" ' . $checked . '>';
	}

	public function render_image_upload( $args ) {
		$options = get_option( 'opa_footer_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		
		echo '<div class="opa-media-upload-wrapper">';
		echo '<input type="text" id="' . esc_attr( $id ) . '" name="opa_footer_settings[' . esc_attr( $id ) . ']" value="' . esc_attr( $value ) . '" class="regular-text opa-media-url">';
		echo '<button type="button" class="button opa-upload-button">' . esc_html__( 'Upload Image', 'opa-engine' ) . '</button>';
		if ( ! empty( $value ) ) {
			echo '<div style="margin-top: 10px;"><img src="' . esc_url( $value ) . '" style="max-width: 150px; height: auto;" /></div>';
		}
		echo '</div>';
	}

	public function render_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Footer Settings', 'opa-engine' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'opa_footer_settings_group' );
				do_settings_sections( 'opa-footer-settings' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}
