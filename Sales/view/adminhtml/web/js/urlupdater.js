require(['jquery'],function($){
 
	 jQuery(document).on('mouseover', '.data-grid td a', function() { 
	 	
	 		var createdAtKey = jQuery( ".admin__current-filters-list span" ).eq(0).text();
			createdAtKey = createdAtKey.slice(0,-1); //убирает : в конце
			if (this.href.search(createdAtKey.toLowerCase()) == -1) {
			var createdAtValue = jQuery( ".admin__current-filters-list span" ).eq(1).text();
			createdAtValue = createdAtValue.replace(/\s/g, '');
			createdAtValue = createdAtValue.replace(/\//g, '_');
			var resultUrl = this.href.concat(createdAtKey,'/',createdAtValue);
	 		jQuery(this).attr("href",resultUrl);
	 	}
	 });
	
	jQuery(document).on('click', '.data-grid td a', function() { 
		window.location.href = this.href; 
	});
});
