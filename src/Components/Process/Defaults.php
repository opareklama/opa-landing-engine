<?php
namespace OPA\LandingEngine\Components\Process;

class Defaults {
	public static function get() {
		return [
			'opa_process_enable'      => '1',
			'opa_process_badge'       => 'Procesas',
			'opa_process_title'       => 'Kaip vyksta visas procesas?',
			'opa_process_desc'        => 'Vos keli aiškūs žingsniai iki sėkmingo jūsų buto pardavimo.',
			'opa_process_btn_label'   => 'Pradėkime šiandien',
			'opa_process_btn_url'     => '#contact',
			'opa_process_steps'       => [
				[
					'title'       => 'Nemokama konsultacija',
					'description' => 'Susisiekiame, aptariame jūsų tikslus ir įvertiname situaciją.',
				],
				[
					'title'       => 'Turto įvertinimas',
					'description' => 'Atliekame profesionalų buto įvertinimą ir parengiame pardavimo strategiją.',
				],
				[
					'title'       => 'Paruošimas pardavimui',
					'description' => 'Parengiame skelbimus, nuotraukas ir visą reikalingą informaciją.',
				],
				[
					'title'       => 'Pirkėjų paieška',
					'description' => 'Aktyviai ieškome potencialių pirkėjų ir organizuojame apžiūras.',
				],
				[
					'title'       => 'Pasiūlymų pristatymas',
					'description' => 'Per 30 dienų siekiame pateikti bent 3 realius pirkėjų pasiūlymus.',
				],
				[
					'title'       => 'Sėkmingas sandoris',
					'description' => 'Padedame užbaigti visą pardavimo procesą saugiai ir sklandžiai.',
				],
			],
		];
	}
}
