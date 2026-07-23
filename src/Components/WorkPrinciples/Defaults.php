<?php
namespace OPA\LandingEngine\Components\WorkPrinciples;

class Defaults {
	public static function get_defaults() {
		return [
			'opa_work_enable'      => '1',
			'opa_work_badge'       => 'Kas įskaičiuota',
			'opa_work_title'       => 'Ką gaunate dirbdami su NT30?',
			'opa_work_desc'        => 'Dirbdami su NT30 gaunate ne tik profesionalų tarpininkavimą, bet ir visą paslaugų paketą, kuris padeda užtikrinti sklandų ir saugų jūsų buto pardavimo procesą.',
			'opa_work_image'       => '',
			'opa_work_features'  => [
				[
					'icon'        => 'users',
					'title'       => '3 pirkėjų pasiūlymai',
					'description' => 'Užtikriname mažiausiai tris realius pirkėjų pasiūlymus Jūsų turtui.',
				],
				[
					'icon'        => 'file-check',
					'title'       => 'Nemokamas vertinimas',
					'description' => 'Ataskaita Jūsų pirkėjui, perkančiam su banko paskola.',
				],
				[
					'icon'        => 'shield-check',
					'title'       => 'Saugus sandoris',
					'description' => 'Užtikriname, kad vertinimas atitiks sutartą sumą, kad sandoris nenutrūktų.',
				],
				[
					'icon'        => 'landmark',
					'title'       => 'Finansavimo pagalba',
					'description' => 'Mūsų brokeris padeda Jūsų pirkėjams sutvarkyti finansavimą banke.',
				],
				[
					'icon'        => 'megaphone',
					'title'       => 'Maksimali reklama',
					'description' => 'Objekto reklama ne tik Aruode, bet ir atskira reklama socialiniuose tinkluose su 500 eurų biudžetu.',
				],
				[
					'icon'        => 'file-text',
					'title'       => 'Dokumentų tvarkymas',
					'description' => 'Pilnas sutarčių ruošimas sklandžiam pardavimui.',
				],
				[
					'icon'        => 'clipboard-check',
					'title'       => 'Turto defektavimas',
					'description' => 'Padedame nustatyti ir aprašyti turto defektus, kad pirkėjas negalėtų ginčyti po sandorio.',
				],
			],
			'opa_work_btn_label'   => '',
			'opa_work_btn_url'     => '',
		];
	}
}
