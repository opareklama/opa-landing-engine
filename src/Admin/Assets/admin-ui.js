document.addEventListener('DOMContentLoaded', () => {
	// Tabbed Interface Logic
	const tabs = document.querySelectorAll('.opa-admin-tabs .nav-tab');
	const panels = document.querySelectorAll('.opa-tab-panel');

	tabs.forEach(tab => {
		tab.addEventListener('click', (e) => {
			e.preventDefault();
			
			// Remove active classes
			tabs.forEach(t => t.classList.remove('nav-tab-active'));
			panels.forEach(p => p.classList.remove('is-active'));
			
			// Add active class to clicked
			tab.classList.add('nav-tab-active');
			const targetId = tab.getAttribute('href');
			document.querySelector(targetId).classList.add('is-active');
		});
	});

	// Vanilla JS Drag & Drop API Logic
	const list = document.getElementById('opa-section-builder');
	if (!list) return;

	let draggedItem = null;

	list.addEventListener('dragstart', (e) => {
		if (e.target.classList.contains('opa-sortable-item')) {
			draggedItem = e.target;
			e.dataTransfer.effectAllowed = 'move';
			e.dataTransfer.setData('text/plain', e.target.dataset.id);
			setTimeout(() => e.target.classList.add('is-dragging'), 0);
		}
	});

	list.addEventListener('dragend', (e) => {
		if (e.target.classList.contains('opa-sortable-item')) {
			e.target.classList.remove('is-dragging');
			draggedItem = null;
			updateOrderInput();
		}
	});

	list.addEventListener('dragover', (e) => {
		e.preventDefault();
		e.dataTransfer.dropEffect = 'move';
		const targetItem = e.target.closest('.opa-sortable-item');
		
		if (targetItem && targetItem !== draggedItem) {
			const rect = targetItem.getBoundingClientRect();
			const midPoint = rect.top + rect.height / 2;
			
			if (e.clientY < midPoint) {
				list.insertBefore(draggedItem, targetItem);
			} else {
				list.insertBefore(draggedItem, targetItem.nextSibling);
			}
		}
	});

	// Function to update the hidden input with the new order
	function updateOrderInput() {
		const items = list.querySelectorAll('.opa-sortable-item');
		const orderArray = Array.from(items).map(item => item.dataset.id);
		const input = document.getElementById('opa-component-order');
		if (input) {
			input.value = orderArray.join(',');
		}
	}

	// WordPress Media Uploader Logic
	const mediaButtons = document.querySelectorAll('.opa-media-button');
	
	mediaButtons.forEach(button => {
		button.addEventListener('click', function(e) {
			e.preventDefault();
			const inputField = this.previousElementSibling;
			let frame;

			// If the media frame already exists, reopen it.
			if (frame) {
				frame.open();
				return;
			}

			// Create a new media frame
			frame = wp.media({
				title: 'Select or Upload Image',
				button: {
					text: 'Use this image'
				},
				multiple: false
			});

			// When an image is selected in the media frame...
			frame.on('select', function() {
				const attachment = frame.state().get('selection').first().toJSON();
				inputField.value = attachment.url;
			});

			frame.open();
		});
	});
});
