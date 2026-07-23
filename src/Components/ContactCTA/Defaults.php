<?php
namespace OPA\LandingEngine\Components\ContactCTA;

class Defaults {
	public static function get() {
		return [
			'opa_contact_enable'    => '1',
			'opa_contact_badge'     => '',
			'opa_contact_title'     => 'Pasikalbėkime',
			'opa_contact_desc'      => 'Parduokite savo butą greičiau ir be ilgalaikių įsipareigojimų.',
			'opa_contact_shortcode' => '[contact-form-7 id="98ac196" title="NT30 – Konsultacijos forma"]',
			'opa_contact_phone'     => '+370 608 88 894',
			'opa_contact_email'     => 'info@nt30.lt',
		];
	}
}
