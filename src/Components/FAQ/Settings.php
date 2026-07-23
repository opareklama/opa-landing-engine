<?php
namespace OPA\LandingEngine\Components\FAQ;

class Settings {
	public static function register( $component, $page, $section ) {
		$defaults = $component->get_defaults();

		add_settings_field(
			'opa_faq_enable',
			__( 'Enable Section', 'opa-engine' ),
			[ self::class, 'render_checkbox' ],
			$page,
			$section,
			[ 'id' => 'opa_faq_enable', 'default' => $defaults['opa_faq_enable'] ]
		);

		add_settings_field(
			'opa_faq_badge',
			__( 'Section Badge', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_faq_badge', 'default' => $defaults['opa_faq_badge'] ]
		);

		add_settings_field(
			'opa_faq_title',
			__( 'Section Title', 'opa-engine' ),
			[ self::class, 'render_text' ],
			$page,
			$section,
			[ 'id' => 'opa_faq_title', 'default' => $defaults['opa_faq_title'] ]
		);

		add_settings_field(
			'opa_faq_desc',
			__( 'Section Description', 'opa-engine' ),
			[ self::class, 'render_textarea' ],
			$page,
			$section,
			[ 'id' => 'opa_faq_desc', 'default' => $defaults['opa_faq_desc'] ]
		);

		add_settings_field(
			'opa_faq_items',
			__( 'FAQ Items (Unlimited)', 'opa-engine' ),
			[ self::class, 'render_repeater' ],
			$page,
			$section,
			[ 'id' => 'opa_faq_items', 'default' => $defaults['opa_faq_items'] ]
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

	public static function render_repeater( $args ) {
		$options = get_option( 'opa_home_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : [];
		$items   = isset( $options[ $id ] ) && is_array( $options[ $id ] ) ? $options[ $id ] : $default;
		
		if ( empty( $items ) ) {
			$items = [ [ 'question' => '', 'answer' => '' ] ];
		}

		?>
		<div class="opa-repeater" id="opa-faq-repeater" style="max-width: 800px;">
			<div class="opa-repeater-container">
				<?php foreach ( $items as $index => $item ) : ?>
					<div class="opa-repeater-row" style="display:flex; flex-wrap: wrap; gap:10px; margin-bottom:15px; background:#fff; padding:16px; border:1px solid #ccd0d4; border-radius:4px; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
						<div style="flex:1; display:flex; flex-direction:column; gap:10px;">
							<label style="font-weight:600;">Question</label>
							<input type="text" name="opa_home_settings[<?php echo esc_attr($id); ?>][<?php echo $index; ?>][question]" value="<?php echo esc_attr( $item['question'] ?? '' ); ?>" class="large-text" required>
							
							<label style="font-weight:600;">Answer</label>
							<textarea name="opa_home_settings[<?php echo esc_attr($id); ?>][<?php echo $index; ?>][answer]" rows="4" class="large-text" required><?php echo esc_textarea( $item['answer'] ?? '' ); ?></textarea>
						</div>
						<div style="display:flex; align-items:center;">
							<button type="button" class="button button-link-delete opa-repeater-remove" style="color:#a15; margin-left:10px;">&times; Remove</button>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<button type="button" class="button button-secondary opa-repeater-add" data-template="opa-faq-template">+ Add FAQ Item</button>
			
			<script type="text/template" id="opa-faq-template">
				<div class="opa-repeater-row" style="display:flex; flex-wrap: wrap; gap:10px; margin-bottom:15px; background:#fff; padding:16px; border:1px solid #ccd0d4; border-radius:4px; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
					<div style="flex:1; display:flex; flex-direction:column; gap:10px;">
						<label style="font-weight:600;">Question</label>
						<input type="text" name="opa_home_settings[<?php echo esc_attr($id); ?>][__INDEX__][question]" value="" class="large-text" required>
						
						<label style="font-weight:600;">Answer</label>
						<textarea name="opa_home_settings[<?php echo esc_attr($id); ?>][__INDEX__][answer]" rows="4" class="large-text" required></textarea>
					</div>
					<div style="display:flex; align-items:center;">
						<button type="button" class="button button-link-delete opa-repeater-remove" style="color:#a15; margin-left:10px;">&times; Remove</button>
					</div>
				</div>
			</script>
		</div>
		<script>
		jQuery(document).ready(function($) {
			$('#opa-faq-repeater').on('click', '.opa-repeater-add', function() {
				var template = $('#' + $(this).data('template')).html();
				var index = $(this).siblings('.opa-repeater-container').find('.opa-repeater-row').length;
				template = template.replace(/__INDEX__/g, index);
				$(this).siblings('.opa-repeater-container').append(template);
			});
			$('#opa-faq-repeater').on('click', '.opa-repeater-remove', function() {
				if (confirm('Are you sure you want to remove this item?')) {
					$(this).closest('.opa-repeater-row').remove();
				}
			});
		});
		</script>
		<?php
	}
}
