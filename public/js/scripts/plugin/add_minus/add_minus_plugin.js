(function($) {
    $.fn.Quantity = function (settings) {
        if(settings.operation == 'add') {
		  if(settings)
            if(settings.item_quantity >= 0) {
			if(settings.item_quantity != 99){
				settings.item_quantity++;
				if(settings.item_quantity < 10) {
					settings.targetDOM.html(settings.item_quantity);
					// settings.targetDOM.html('0'+settings.item_quantity);
					// settings.targetINPUT.val('0'+settings.item_quantity);
				} else {
					settings.targetDOM.html(settings.item_quantity);
					// settings.targetINPUT.val(settings.item_quantity);
				}
			}
                
            }
            return settings.item_quantity;
        } else if(settings.operation == 'minus') {
            if(settings.item_quantity >= 2) {
                settings.item_quantity--;
                if(settings.item_quantity < 10) {
                    settings.targetDOM.html(settings.item_quantity);
                    // settings.targetDOM.html('0'+settings.item_quantity);
                    // settings.targetINPUT.val('0'+settings.item_quantity);
                } else {
                    settings.targetDOM.html(settings.item_quantity);
                    // settings.targetINPUT.val(settings.item_quantity);
                }
            }
            return settings.item_quantity;
        } else {
            return false;
        }
    };
}(jQuery));