require(['jquery'],function($) {
	jQuery(document).on('click', '.data-grid td a', function() { 
		window.location.href = this.href; 
	});
});