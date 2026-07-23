<?php
namespace OPA\LandingEngine\Components\Hero;

/**
 * Default NT30 Dataset for Hero Component
 */
class Defaults {
	public static function get() {
		return [
			'enable' => '1',
			'badge' => '30 Dienų. 6 Specialistai. 3 Pirkėjų Pasiūlymai.',
			'headline' => 'Per 30 dienų gauname bent 3 realius pirkėjų pasiūlymus.',
			'description' => "Jokių ilgalaikių įsipareigojimų ir baudų už pasiūlymų atmetimą.\nJūs sprendžiate, kurį pasiūlymą priimti. Jei pasiūlymai netenkina, galite juos atmesti ir nutraukti bendradarbiavimą.",
			'primary_button_label' => 'Gauti nemokamą konsultaciją',
			'primary_button_url' => '#contact',
			'secondary_button_label' => '+370 608 88 894',
			'secondary_button_url' => 'tel:+37060888894',
			'trust_items' => [
				[ 'icon' => 'check', 'text' => '30 dienų procesas' ],
				[ 'icon' => 'check', 'text' => '6 specialistų komanda' ],
				[ 'icon' => 'check', 'text' => 'Bent 3 realūs pasiūlymai' ],
			],
			'overlay_enable' => '1',
			'overlay_color' => '#0F172A',
			'overlay_opacity' => '0.8',
			'animation' => 'fade-up',
		];
	}
}
