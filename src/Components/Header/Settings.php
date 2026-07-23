<?php
namespace OPA\Engine\Components\Header;

use OPA\Engine\Fields\FieldFactory;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings {

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_menu' ], 20 );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	public function register_menu() {
		add_submenu_page(
			'opa-landing-engine',
			__( 'Header Settings', 'opa-engine' ),
			__( 'Header Settings', 'opa-engine' ),
			'manage_options',
			'opa-header-settings',
			[ $this, 'render_page' ]
		);
	}

	public function register_settings() {
		register_setting( 'opa_header_settings_group', 'opa_header_settings' );

		// General Section
		add_settings_section(
			'opa_header_general_section',
			__( 'General Configuration', 'opa-engine' ),
			null,
			'opa-header-settings'
		);

		add_settings_field(
			'opa_header_enable',
			__( 'Enable Custom Header', 'opa-engine' ),
			[ $this, 'render_field' ],
			'opa-header-settings',
			'opa_header_general_section',
			[
				'id'      => 'opa_header_enable',
				'type'    => 'checkbox',
				'default' => '1',
				'desc'    => __( 'If disabled, the active theme\'s default header will be shown.', 'opa-engine' )
			]
		);
		
		add_settings_field(
			'opa_header_sticky',
			__( 'Sticky Header', 'opa-engine' ),
			[ $this, 'render_field' ],
			'opa-header-settings',
			'opa_header_general_section',
			[
				'id'      => 'opa_header_sticky',
				'type'    => 'checkbox',
				'default' => '1',
			]
		);

		// Content Section
		add_settings_section(
			'opa_header_content_section',
			__( 'Header Content', 'opa-engine' ),
			null,
			'opa-header-settings'
		);

		add_settings_field(
			'opa_header_transparent',
			__( 'Transparent Header', 'opa-engine' ),
			[ $this, 'render_checkbox' ],
			'opa-header-settings',
			'opa_header_general_section',
			[
				'id'      => 'opa_header_transparent',
				'default' => '1',
				'desc'    => __( 'Overlays the header on top of the hero section.', 'opa-engine' )
			]
		);

		add_settings_field(
			'opa_header_logo_text',
			__( 'Logo Text', 'opa-engine' ),
			[ $this, 'render_field' ],
			'opa-header-settings',
			'opa_header_content_section',
			[
				'id'      => 'opa_header_logo_text',
				'type'    => 'text',
				'default' => 'NT30',
			]
		);

		add_settings_field(
			'opa_header_menu_items',
			__( 'Menu Items', 'opa-engine' ),
			[ $this, 'render_menu_repeater' ],
			'opa-header-settings',
			'opa_header_content_section',
			[
				'id'      => 'opa_header_menu_items',
				'default' => "Pradžia | #pradzia\nKodėl NT30 | #why-nt30\nProcesas | #process\nRezultatai | #results\nDUK | #faq\nKontaktai | #contact",
				'desc'    => __( 'Enter one item per line in format: Label | URL', 'opa-engine' )
			]
		);

		add_settings_field(
			'opa_header_phone',
			__( 'Phone Number', 'opa-engine' ),
			[ $this, 'render_field' ],
			'opa-header-settings',
			'opa_header_content_section',
			[
				'id'      => 'opa_header_phone',
				'type'    => 'text',
				'default' => '+370 608 88 894',
			]
		);

		add_settings_field(
			'opa_header_cta_text',
			__( 'CTA Button Text', 'opa-engine' ),
			[ $this, 'render_field' ],
			'opa-header-settings',
			'opa_header_content_section',
			[
				'id'      => 'opa_header_cta_text',
				'type'    => 'text',
				'default' => 'Gauti nemokamą konsultaciją',
			]
		);

		add_settings_field(
			'opa_header_cta_url',
			__( 'CTA Button URL', 'opa-engine' ),
			[ $this, 'render_field' ],
			'opa-header-settings',
			'opa_header_content_section',
			[
				'id'      => 'opa_header_cta_url',
				'type'    => 'text',
				'default' => '#contact',
			]
		);
	}

	public function render_field( $args ) {
		$options = get_option( 'opa_header_settings' );
		$id      = $args['id'];
		$type    = $args['type'];
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		
		FieldFactory::render( $type, 'opa_header_settings[' . $id . ']', $value, $args );
	}

	public function render_menu_repeater( $args ) {
		$options = get_option( 'opa_header_settings' );
		$id      = $args['id'];
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : '';
		
		$items = [];
		if ( is_array( $value ) ) {
			$items = $value;
		} elseif ( is_string( $value ) && ! empty( $value ) ) {
			// Parse legacy string
			$lines = explode( "\n", str_replace( "\r", "", $value ) );
			foreach ( $lines as $line ) {
				if ( empty( trim( $line ) ) ) continue;
				$parts = explode( '|', $line );
				if ( count( $parts ) >= 2 ) {
					$items[] = [ 'label' => trim( $parts[0] ), 'url' => trim( $parts[1] ) ];
				}
			}
		}

		if ( empty( $items ) ) {
			$items = [
				['label' => 'Pradžia', 'url' => '#pradzia']
			];
		}

		?>
		<div class="opa-menu-repeater" id="opa-menu-repeater" style="max-width: 600px;">
			<div class="opa-menu-items-container" id="opa-menu-items-container">
				<?php foreach ( $items as $index => $item ) : ?>
					<div class="opa-menu-item-row" style="display:flex; gap:10px; margin-bottom:10px; align-items:center; background:#fff; padding:12px; border:1px solid #ccd0d4; border-radius:4px; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
						<span class="dashicons dashicons-menu opa-drag-handle" style="cursor:move; color:#888;"></span>
						<input type="text" name="opa_header_settings[<?php echo esc_attr($id); ?>][<?php echo $index; ?>][label]" value="<?php echo esc_attr( $item['label'] ?? '' ); ?>" placeholder="Label" class="regular-text" style="flex:1;">
						<input type="text" name="opa_header_settings[<?php echo esc_attr($id); ?>][<?php echo $index; ?>][url]" value="<?php echo esc_attr( $item['url'] ?? '' ); ?>" placeholder="#section-id or URL" class="regular-text" style="flex:1;">
						<button type="button" class="button opa-remove-menu-item" style="color:#d63638; border-color:#d63638;">&times;</button>
					</div>
				<?php endforeach; ?>
			</div>
			<button type="button" class="button button-primary opa-add-menu-item" id="opa-add-menu-item">+ Add Menu Item</button>
		</div>

		<script>
		document.addEventListener('DOMContentLoaded', function() {
			const container = document.getElementById('opa-menu-items-container');
			const addButton = document.getElementById('opa-add-menu-item');
			let rowIndex = <?php echo count($items); ?>;

			addButton.addEventListener('click', function(e) {
				e.preventDefault();
				const row = document.createElement('div');
				row.className = 'opa-menu-item-row';
				row.style.cssText = 'display:flex; gap:10px; margin-bottom:10px; align-items:center; background:#fff; padding:12px; border:1px solid #ccd0d4; border-radius:4px; box-shadow: 0 1px 1px rgba(0,0,0,.04);';
				
				row.innerHTML = `
					<span class="dashicons dashicons-menu opa-drag-handle" style="cursor:move; color:#888;"></span>
					<input type="text" name="opa_header_settings[<?php echo esc_attr($id); ?>][${rowIndex}][label]" value="" placeholder="Label" class="regular-text" style="flex:1;">
					<input type="text" name="opa_header_settings[<?php echo esc_attr($id); ?>][${rowIndex}][url]" value="" placeholder="#section-id or URL" class="regular-text" style="flex:1;">
					<button type="button" class="button opa-remove-menu-item" style="color:#d63638; border-color:#d63638;">&times;</button>
				`;
				
				container.appendChild(row);
				rowIndex++;
			});

			container.addEventListener('click', function(e) {
				if (e.target.classList.contains('opa-remove-menu-item')) {
					e.preventDefault();
					e.target.closest('.opa-menu-item-row').remove();
				}
			});

			// Optional: If jQuery UI Sortable is loaded by WordPress
			if (typeof jQuery !== 'undefined' && typeof jQuery.ui !== 'undefined' && typeof jQuery.ui.sortable !== 'undefined') {
				jQuery('#opa-menu-items-container').sortable({
					handle: '.opa-drag-handle',
					axis: 'y',
					update: function(event, ui) {
						// Reindex names after sort
						jQuery('#opa-menu-items-container .opa-menu-item-row').each(function(index) {
							jQuery(this).find('input').each(function() {
								let name = jQuery(this).attr('name');
								name = name.replace(/\[\d+\]/, '[' + index + ']');
								jQuery(this).attr('name', name);
							});
						});
					}
				});
			}
		});
		</script>
		<?php
	}

	public function render_checkbox( $args ) {
		$options = get_option( 'opa_header_settings' );
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '0';
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $default;
		
		$checked = checked( '1', $value, false );
		echo '<input type="hidden" name="opa_header_settings[' . esc_attr( $id ) . ']" value="0">';
		echo '<input type="checkbox" id="' . esc_attr( $id ) . '" name="opa_header_settings[' . esc_attr( $id ) . ']" value="1" ' . $checked . '>';
		if ( isset( $args['desc'] ) ) {
			echo '<p class="description">' . esc_html( $args['desc'] ) . '</p>';
		}
	}

	public function render_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Header Settings', 'opa-engine' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'opa_header_settings_group' );
				do_settings_sections( 'opa-header-settings' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}
