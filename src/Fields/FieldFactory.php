<?php
namespace OPA\Engine\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FieldFactory {

	public static function render( $type, $name, $value ) {
		switch ( $type ) {
			case 'text':
			case 'email':
			case 'number':
			case 'url':
				self::render_text( $type, $name, $value );
				break;
			case 'color':
				self::render_color( $name, $value );
				break;
			case 'checkbox':
				self::render_checkbox( $name, $value );
				break;
			default:
				echo esc_html__( 'Field type not supported.', 'opa-engine' );
				break;
		}
	}

	private static function render_text( $type, $name, $value ) {
		printf(
			'<input type="%s" name="%s" value="%s" class="regular-text" />',
			esc_attr( $type ),
			esc_attr( $name ),
			esc_attr( $value )
		);
	}

	private static function render_color( $name, $value ) {
		// Native HTML5 color picker for simplicity, or could use wp-color-picker
		printf(
			'<input type="color" name="%s" value="%s" />',
			esc_attr( $name ),
			esc_attr( $value )
		);
	}

	private static function render_checkbox( $name, $value ) {
		printf(
			'<input type="hidden" name="%1$s" value="0" /><input type="checkbox" name="%1$s" value="1" %2$s />',
			esc_attr( $name ),
			checked( 1, (int) $value, false )
		);
	}
}
