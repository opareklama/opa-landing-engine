jQuery(document).ready(function($) {
	$('.opa-dash-refresh-btn').on('click', function(e) {
		e.preventDefault();
		
		var $btn = $(this);
		var originalText = $btn.html();
		
		$btn.html('<span class="dashicons dashicons-update-alt" style="animation: spin 1s linear infinite;"></span> Refreshing...');
		$btn.prop('disabled', true);
		
		$.ajax({
			url: opaDashParams.ajax_url,
			type: 'POST',
			data: {
				action: 'opa_dash_refresh',
				nonce: opaDashParams.nonce
			},
			success: function(response) {
				if (response.success) {
					// Reload page to show fresh data
					window.location.reload();
				} else {
					alert('Error refreshing dashboard data.');
					$btn.html(originalText);
					$btn.prop('disabled', false);
				}
			},
			error: function() {
				alert('Server error occurred while refreshing.');
				$btn.html(originalText);
				$btn.prop('disabled', false);
			}
		});
	});
});

/* Simple CSS animation injected for the spinner */
var style = document.createElement('style');
style.innerHTML = '@keyframes spin { 100% { transform: rotate(360deg); } }';
document.head.appendChild(style);
