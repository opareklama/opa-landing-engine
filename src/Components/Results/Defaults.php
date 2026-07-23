<?php
namespace OPA\LandingEngine\Components\Results;

class Defaults {
	public static function get() {
		return [
			'opa_results_enable'      => '1',
			'opa_results_badge'       => 'Rezultatai',
			'opa_results_title'       => 'Skaičiai, kuriais didžiuojamės',
			'opa_results_desc'        => 'Mūsų tikslas – ne pažadai, o realūs rezultatai.',
			'opa_results_stats'       => [
				[
					'number'      => '30',
					'suffix'      => 'Dienų',
					'title'       => 'Tikslinis pardavimo laikotarpis',
					'description' => 'Siekiame rezultatų per 30 dienų.',
				],
				[
					'number'      => '6',
					'suffix'      => '+',
					'title'       => 'Specialistai',
					'description' => 'Patyrusi komanda dirba jūsų naudai.',
				],
				[
					'number'      => '3',
					'suffix'      => '+',
					'title'       => 'Realūs pasiūlymai',
					'description' => 'Tikslas – bent 3 realūs pirkėjų pasiūlymai.',
				],
				[
					'number'      => '100',
					'suffix'      => '%',
					'title'       => 'Skaidrus procesas',
					'description' => 'Aiški komunikacija nuo pradžios iki pabaigos.',
				],
			],
		];
	}
}
