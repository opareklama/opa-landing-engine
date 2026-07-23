<?php
namespace OPA\LandingEngine\Components\WhyNT30;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Defaults {
	public static function get() {
		return [
			'opa_why_title' => 'Kodėl NT30?',
			'opa_why_subtitle' => 'Parduokite savo butą greičiau, saugiau ir be nereikalingų įsipareigojimų.',
			'opa_why_features' => [
				[
					'icon' => 'clock',
					'title' => '30 dienų procesas',
					'description' => 'Mūsų tikslas – per 30 dienų pateikti bent 3 realius pirkėjų pasiūlymus.'
				],
				[
					'icon' => 'users',
					'title' => '6 specialistų komanda',
					'description' => 'Jūsų turtu rūpinasi patyrusių nekilnojamojo turto specialistų komanda.'
				],
				[
					'icon' => 'shield',
					'title' => 'Jokių ilgalaikių įsipareigojimų',
					'description' => 'Jūs nesate įpareigoti ilgalaikėmis sutartimis ir galite bet kada nutraukti bendradarbiavimą.'
				],
				[
					'icon' => 'check',
					'title' => 'Jūs priimate sprendimą',
					'description' => 'Tik jūs nusprendžiate, kurį pasiūlymą priimti. Jei pasiūlymai netenkina, galite jų atsisakyti.'
				]
			],
			'opa_why_btn_label' => 'Sužinoti daugiau',
			'opa_why_btn_url' => '#process'
		];
	}
}
