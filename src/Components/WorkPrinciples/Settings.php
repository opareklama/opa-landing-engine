<?php
namespace OPA\LandingEngine\Components\WorkPrinciples;

class Settings {
	public static function register( $component, $page, $section ) {
		$defaults = $component->get_defaults();

		add_settings_field(
			'opa_work_enable',
			__( 'Enable Section', 'opa-engine' ),
			[ self::class, 'render_checkbox' ],
			$page,
			$section,
			[ 'id' => 'opa_work_enable', 'default' => $defaults['opa_work_enable'] ]
		);

		add_settings_field(
			'opa_work_badge',
			__( 'Section Badge', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_work_badge', 'default' => $defaults['opa_work_badge'] ]
		);

		add_settings_field(
			'opa_work_title',
			__( 'Section Title', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_work_title', 'default' => $defaults['opa_work_title'] ]
		);

		add_settings_field(
			'opa_work_desc',
			__( 'Section Description', 'opa-engine' ),
			[ self::class, 'render_textarea' ],
			$page,
			$section,
			[ 'id' => 'opa_work_desc', 'default' => $defaults['opa_work_desc'] ]
		);

		add_settings_field(
			'opa_work_image',
			__( 'Illustration Image', 'opa-engine' ),
			[ self::class, 'render_media' ],
			$page,
			$section,
			[ 'id' => 'opa_work_image', 'default' => $defaults['opa_work_image'] ]
		);

		add_settings_field(
			'opa_work_features',
			__( 'Features (7 Items)', 'opa-engine' ),
			[ self::class, 'render_principles' ],
			$page,
			$section,
			[ 'id' => 'opa_work_features', 'default' => $defaults['opa_work_features'] ]
		);

		add_settings_field(
			'opa_work_btn_label',
			__( 'Button Label', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_work_btn_label', 'default' => $defaults['opa_work_btn_label'] ]
		);

		add_settings_field(
			'opa_work_btn_url',
			__( 'Button URL', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_work_btn_url', 'default' => $defaults['opa_work_btn_url'] ]
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

	public static function render_checkbox( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '0';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		$checked = checked( '1', $value, false );
		echo '<input type="hidden" name="opa_home_settings[' . esc_attr( $id ) . ']" value="0">';
		echo '<input type="checkbox" id="' . esc_attr( $id ) . '" name="opa_home_settings[' . esc_attr( $id ) . ']" value="1" ' . $checked . '>';
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

	public static function render_principles( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : [];
		$items   = isset( $options[ $id ] ) && is_array( $options[ $id ] ) ? $options[ $id ] : $default;
		$defaults = $args['default'];
		
		$features = $options['opa_work_features'] ?? $defaults;

		echo '<div id="opa-work-principles-wrapper">';
		
		if ( ! empty( $features ) ) {
			foreach ( $features as $index => $item ) {
				$icon  = esc_attr( $item['icon'] ?? '' );
				$title = esc_attr( $item['title'] ?? '' );
				$desc  = esc_textarea( $item['description'] ?? '' );
				
				echo '<div class="opa-repeater-item" style="border:1px solid #ddd; padding: 15px; margin-bottom: 10px; background:#f9f9f9;">';
				echo '<h4>Feature ' . ( $index + 1 ) . '</h4>';
				
				echo '<p><label>Icon (users, file-check, shield-check, landmark, megaphone, file-text, clipboard-check)</label><br/>';
				echo '<input type="text" name="opa_home_settings[opa_work_features][' . $index . '][icon]" value="' . $icon . '" class="regular-text"></p>';
				
				echo '<p><label>Title</label><br/>';
				echo '<input type="text" name="opa_home_settings[opa_work_features][' . $index . '][title]" value="' . $title . '" class="regular-text"></p>';
				
				echo '<p><label>Description</label><br/>';
				echo '<textarea name="opa_home_settings[opa_work_features][' . $index . '][description]" rows="3" class="large-text">' . $desc . '</textarea></p>';
				
				echo '</div>';
			}
		}
		echo '</div>';
	}
}
