<?php
namespace OPA\LandingEngine\Components\Results;

class Settings {
	public static function register( $component, $page, $section ) {
		$defaults = $component->get_defaults();

		add_settings_field(
			'opa_results_enable',
			__( 'Enable Section', 'opa-engine' ),
			[ self::class, 'render_checkbox' ],
			$page,
			$section,
			[ 'id' => 'opa_results_enable', 'default' => $defaults['opa_results_enable'] ]
		);

		add_settings_field(
			'opa_results_badge',
			__( 'Section Badge', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_results_badge', 'default' => $defaults['opa_results_badge'] ]
		);

		add_settings_field(
			'opa_results_title',
			__( 'Section Title', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_results_title', 'default' => $defaults['opa_results_title'] ]
		);

		add_settings_field(
			'opa_results_desc',
			__( 'Section Description', 'opa-engine' ),
			[ self::class, 'render_textarea' ],
			$page,
			$section,
			[ 'id' => 'opa_results_desc', 'default' => $defaults['opa_results_desc'] ]
		);

		add_settings_field(
			'opa_results_stats',
			__( 'Statistics Cards (4 Items)', 'opa-engine' ),
			[ self::class, 'render_stats' ],
			$page,
			$section,
			[ 'id' => 'opa_results_stats', 'default' => $defaults['opa_results_stats'] ]
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

	public static function render_stats( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : [];
		$items   = isset( $options[ $id ] ) && is_array( $options[ $id ] ) ? $options[ $id ] : $default;
		
		if ( empty( $items ) || count($items) < 4 ) {
			$items = $default;
		}

		?>
		<div class="opa-repeater" id="opa-results-repeater" style="max-width: 800px;">
			<div class="opa-repeater-container">
				<?php foreach ( $items as $index => $item ) : ?>
					<div class="opa-repeater-row" style="display:flex; flex-wrap: wrap; gap:10px; margin-bottom:15px; background:#fff; padding:16px; border:1px solid #ccd0d4; border-radius:4px; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
						<div style="width:100%; display:flex; flex-direction:column; gap:10px;">
							<div style="display: flex; gap: 20px;">
								<div style="flex: 1;">
									<label style="font-weight:600; display:block; margin-bottom:5px;">Large Number (digits only)</label>
									<input type="text" name="opa_home_settings[<?php echo esc_attr($id); ?>][<?php echo $index; ?>][number]" value="<?php echo esc_attr( $item['number'] ?? '' ); ?>" class="regular-text" style="width: 100%;">
								</div>
								<div style="flex: 1;">
									<label style="font-weight:600; display:block; margin-bottom:5px;">Suffix (+, %, Dienų)</label>
									<input type="text" name="opa_home_settings[<?php echo esc_attr($id); ?>][<?php echo $index; ?>][suffix]" value="<?php echo esc_attr( $item['suffix'] ?? '' ); ?>" class="regular-text" style="width: 100%;">
								</div>
							</div>
							
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
}
