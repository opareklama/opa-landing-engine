<?php
namespace OPA\LandingEngine\Components\Process;

class Settings {
	public static function register( $component, $page, $section ) {
		$defaults = $component->get_defaults();

		add_settings_field(
			'opa_process_enable',
			__( 'Enable Section', 'opa-engine' ),
			[ self::class, 'render_checkbox' ],
			$page,
			$section,
			[ 'id' => 'opa_process_enable', 'default' => $defaults['opa_process_enable'] ]
		);

		add_settings_field(
			'opa_process_badge',
			__( 'Section Badge', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_process_badge', 'default' => $defaults['opa_process_badge'] ]
		);

		add_settings_field(
			'opa_process_title',
			__( 'Section Title', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_process_title', 'default' => $defaults['opa_process_title'] ]
		);

		add_settings_field(
			'opa_process_desc',
			__( 'Section Description', 'opa-engine' ),
			[ self::class, 'render_textarea' ],
			$page,
			$section,
			[ 'id' => 'opa_process_desc', 'default' => $defaults['opa_process_desc'] ]
		);

		add_settings_field(
			'opa_process_steps',
			__( 'Timeline Steps (6 Items)', 'opa-engine' ),
			[ self::class, 'render_steps' ],
			$page,
			$section,
			[ 'id' => 'opa_process_steps', 'default' => $defaults['opa_process_steps'] ]
		);

		add_settings_field(
			'opa_process_btn_label',
			__( 'Button Label', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_process_btn_label', 'default' => $defaults['opa_process_btn_label'] ]
		);

		add_settings_field(
			'opa_process_btn_url',
			__( 'Button URL', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_process_btn_url', 'default' => $defaults['opa_process_btn_url'] ]
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

	public static function render_steps( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : [];
		$items   = isset( $options[ $id ] ) && is_array( $options[ $id ] ) ? $options[ $id ] : $default;
		
		if ( empty( $items ) || count($items) < 6 ) {
			$items = $default;
		}

		?>
		<div class="opa-repeater" id="opa-process-repeater" style="max-width: 800px;">
			<div class="opa-repeater-container">
				<?php foreach ( $items as $index => $item ) : ?>
					<div class="opa-repeater-row" style="display:flex; flex-wrap: wrap; gap:10px; margin-bottom:15px; background:#fff; padding:16px; border:1px solid #ccd0d4; border-radius:4px; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
						<div style="width:100%; display:flex; flex-direction:column; gap:10px;">
							<label style="font-weight:600;">Step <?php echo sprintf('%02d', $index + 1); ?> Title</label>
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
}
