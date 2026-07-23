<?php
namespace OPA\LandingEngine\Components\FAQ;

class Renderer {

	public static function render( $component ) {
		$defaults = $component->get_defaults();
		$options  = get_option( 'opa_home_settings', [] );

		$enable = $options['opa_faq_enable'] ?? $defaults['opa_faq_enable'];
		if ( $enable !== '1' ) {
			return;
		}

		$badge = $options['opa_faq_badge'] ?? $defaults['opa_faq_badge'];
		$title = $options['opa_faq_title'] ?? $defaults['opa_faq_title'];
		$desc  = $options['opa_faq_desc'] ?? $defaults['opa_faq_desc'];
		$items = $options['opa_faq_items'] ?? $defaults['opa_faq_items'];

		if ( empty( $items ) || ! is_array( $items ) ) {
			return;
		}

		// Generate JSON-LD Schema
		$schema_entities = [];
		foreach ( $items as $item ) {
			if ( empty( $item['question'] ) || empty( $item['answer'] ) ) continue;
			$schema_entities[] = [
				'@type'          => 'Question',
				'name'           => wp_strip_all_tags( $item['question'] ),
				'acceptedAnswer' => [
					'@type' => 'Answer',
					'text'  => wp_strip_all_tags( $item['answer'] )
				]
			];
		}

		if ( ! empty( $schema_entities ) ) {
			$schema = [
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => $schema_entities
			];
			echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE ) . '</script>';
		}
		?>
		<section class="opa-faq" id="faq">
			<div class="opa-faq__container">
				
				<div class="opa-faq__header">
					<?php if ( ! empty( $badge ) ) : ?>
						<div class="opa-faq__badge"><?php echo esc_html( $badge ); ?></div>
					<?php endif; ?>
					
					<h2 class="opa-faq__title"><?php echo esc_html( $title ); ?></h2>
					<p class="opa-faq__desc"><?php echo esc_html( $desc ); ?></p>
				</div>

				<div class="opa-faq__accordion">
					<?php foreach ( $items as $index => $item ) : 
						if ( empty( $item['question'] ) || empty( $item['answer'] ) ) continue;
						$is_open = ( $index === 0 ); // First item open by default
					?>
						<div class="opa-faq__item <?php echo $is_open ? 'is-active' : ''; ?>">
							<button class="opa-faq__trigger" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>" aria-controls="faq-content-<?php echo esc_attr( $index ); ?>">
								<span class="opa-faq__question"><?php echo esc_html( $item['question'] ); ?></span>
								<span class="opa-faq__icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
								</span>
							</button>
							<div class="opa-faq__content-wrapper" id="faq-content-<?php echo esc_attr( $index ); ?>" style="<?php echo $is_open ? 'height: auto;' : 'height: 0; overflow: hidden;'; ?>">
								<div class="opa-faq__content">
									<p><?php echo nl2br( esc_html( $item['answer'] ) ); ?></p>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</section>

		<script>
		document.addEventListener('DOMContentLoaded', function() {
			const triggers = document.querySelectorAll('.opa-faq__trigger');
			
			triggers.forEach(trigger => {
				trigger.addEventListener('click', function() {
					const parent = this.closest('.opa-faq__item');
					const wrapper = parent.querySelector('.opa-faq__content-wrapper');
					const content = parent.querySelector('.opa-faq__content');
					const isOpen = parent.classList.contains('is-active');

					// Close all others
					document.querySelectorAll('.opa-faq__item').forEach(item => {
						if (item !== parent && item.classList.contains('is-active')) {
							item.classList.remove('is-active');
							item.querySelector('.opa-faq__trigger').setAttribute('aria-expanded', 'false');
							const itemWrapper = item.querySelector('.opa-faq__content-wrapper');
							itemWrapper.style.height = itemWrapper.scrollHeight + 'px';
							// Trigger reflow
							itemWrapper.offsetHeight; 
							itemWrapper.style.height = '0px';
						}
					});

					if (isOpen) {
						// Close current
						parent.classList.remove('is-active');
						this.setAttribute('aria-expanded', 'false');
						wrapper.style.height = wrapper.scrollHeight + 'px';
						wrapper.offsetHeight; // Trigger reflow
						wrapper.style.height = '0px';
					} else {
						// Open current
						parent.classList.add('is-active');
						this.setAttribute('aria-expanded', 'true');
						wrapper.style.height = content.offsetHeight + 'px';
						
						// After animation, set to auto in case of resize
						wrapper.addEventListener('transitionend', function handler(e) {
							if (e.propertyName === 'height' && parent.classList.contains('is-active')) {
								wrapper.style.height = 'auto';
								wrapper.removeEventListener('transitionend', handler);
							}
						});
					}
				});
			});
		});
		</script>
		<?php
	}
}
