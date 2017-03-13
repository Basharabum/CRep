require(['jquery'],function($) {
	jQuery(document).on('click','.action-remove',function() {
                var params = [];
                var target = require('uiRegistry').get('crep_sales_product_listing.crep_sales_product_listing_data_source')
                if (target && typeof target === 'object') {                                     
                    target.set('params.t ', Date.now());                
            }
	});
});