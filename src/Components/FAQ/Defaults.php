<?php
namespace OPA\LandingEngine\Components\FAQ;

class Defaults {
	public static function get() {
		return [
			'opa_faq_enable' => '1',
			'opa_faq_badge'  => 'DUK',
			'opa_faq_title'  => 'Dažniausiai užduodami klausimai',
			'opa_faq_desc'   => 'Atsakymai į dažniausiai užduodamus klausimus apie NT30 paslaugas ir buto pardavimo procesą.',
			'opa_faq_items'  => [
				[
					'question' => 'Kas yra NT30?',
					'answer'   => 'NT30 – tai profesionali nekilnojamojo turto paslauga, padedanti parduoti butą greitai, skaidriai ir be ilgalaikių įsipareigojimų.',
				],
				[
					'question' => 'Ką reiškia „3 realūs pirkėjų pasiūlymai per 30 dienų“?',
					'answer'   => 'Mūsų tikslas – per pirmąsias 30 dienų pateikti bent tris realius pirkėjų pasiūlymus. Galutinis rezultatas priklauso nuo rinkos situacijos ir jūsų turto ypatybių.',
				],
				[
					'question' => 'Ar privalau pasirašyti ilgalaikę sutartį?',
					'answer'   => 'Ne. Mes netaikome ilgalaikių įsipareigojimų. Jei pasiūlymai jūsų netenkina, galite nutraukti bendradarbiavimą.',
				],
				[
					'question' => 'Kas nutinka, jei pasiūlymai man netinka?',
					'answer'   => 'Sprendimą visada priimate jūs. Jei pasiūlymai neatitinka jūsų lūkesčių, galite jų atsisakyti.',
				],
				[
					'question' => 'Kiek kainuoja konsultacija?',
					'answer'   => 'Pirminė konsultacija yra visiškai nemokama.',
				],
				[
					'question' => 'Kokiuose miestuose dirbate?',
					'answer'   => 'Šiuo metu dirbame Vilniuje ir Kaune.',
				],
				[
					'question' => 'Kaip greitai su manimi susisieksite?',
					'answer'   => 'Dažniausiai su klientais susisiekiame per vieną darbo dieną po užklausos gavimo.',
				],
				[
					'question' => 'Kaip pradėti?',
					'answer'   => 'Užpildykite kontaktinę formą arba paskambinkite mums. Aptarsime jūsų situaciją ir pasiūlysime geriausią sprendimą.',
				],
			],
		];
	}
}
