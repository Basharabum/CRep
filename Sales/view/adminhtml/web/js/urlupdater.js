require(['jquery'],function($){
 
	 jQuery(document).on('mouseover', '.data-grid td a', function() { 

	 		var i = 0;
	 		var createdAtKey = jQuery( ".admin__current-filters-list span" ).eq(i).text();
	 		if (createdAtKey !== "") {
	 			//если список фильтров не пуст
		 		while ( (createdAtKey !== "Created:")) {
		 			//пока не найден span фильтра с датой

					createdAtKey = jQuery( ".admin__current-filters-list span" ).eq(++i).text();
					if (createdAtKey == "")
		 			{return;}
				}
				
				createdAtKey = "created_at";
				
				if (this.href.search(createdAtKey.toLowerCase()) == -1) {
					//фильтр еще не записан в ссылку
					var createdAtValue = jQuery( ".admin__current-filters-list span" ).eq(++i).text();
					createdAtValue = createdAtValue.replace(/\s/g, '');
					createdAtValue = createdAtValue.replace(/\//g, '_');
					var resultUrl = this.href.concat(createdAtKey,'/',createdAtValue);
			 		jQuery(this).attr("href",resultUrl);
		 		}
	 		}
	 });
	
	
});
