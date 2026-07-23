<?php
namespace OPA\Engine\Components\Footer;

class Defaults {
	public static function get() {
		return [
			'opa_footer_enable'        => '1',
			'opa_footer_logo'          => '',
			'opa_footer_desc'          => 'Profesionali nekilnojamojo turto paslauga.',
			'opa_footer_phone'         => '+370 608 88 894',
			'opa_footer_email'         => 'info@nt30.lt',
			'opa_footer_location'      => 'Vilnius, Kaunas',
			'opa_footer_copyright'     => '© 2026 NT30. Visos teisės saugomos.',
			'opa_footer_designer_text' => 'OPA Reklama',
			'opa_footer_designer_url'  => 'https://opareklama.lt',
		];
	}
}
