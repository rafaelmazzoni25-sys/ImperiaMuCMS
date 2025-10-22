// JavaScript Document

var PopupAllowClose = true;

/*function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;

    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}*/

(function($)
{
	var methods =
	{
		defaults :
		{
			//realm: $CURUSER.selectedRealm,
			character: '',
			activeCategory: -1,
			activeSubCategory: -1,
			search: '',
			quality: -1,
			minlevel: 0,
			maxlevel: 255,
			havecurrency: false,
			selectedItem: 0,
		},

		init : function(options)
		{
			var $this = $(this);
			
			//if we have the element
			if ($this.length < 1)
			{
				return;
			}
			
			//If the init hasent been called yet
			if (typeof $this.data('WarcryStore') == 'undefined')
			{
				$this.data('WarcryStore', {config: null});

				//merge the defaults with the passed config				
				$this.data('WarcryStore').config = $.extend({}, methods.defaults, config);
			}
			else
			{
				//merge the old config with the passed one
				$this.data('WarcryStore').config = $.extend({}, $this.data('WarcryStore').config, config);
			}
			
			// Fix the popup
			$('.store_item_purchase_popup').appendTo('body');
			
			// Prepare the event handlers
			/*$('#store_form').submit(function(e)
			{
				$('.store_body').WarcryStore("ApplyFilters");
			
				return false;
			});*/
			
			/*$('#store_popup_form').submit(function(e)
			{
				$('.store_body').WarcryStore("PurchaseItemSubmit");
			
				return false;
			});*/
			
			$('#store_categories .store_category_button').click(function()
			{
				$('.store_body').WarcryStore("ActivateCategory", $(this));
					
				return false;
			});
			
			$('#store_categories .store_sub_category_button').click(function(e)
			{
				$('.store_body').WarcryStore("ActivateSubCategory", $(this));
					
				return false;
			});
			
			$('#store_form #store_search').on("keyup", function()
			{
				$('.store_body').data('WarcryStore').config.search = $(this).val();
			});
			
			$('#store_form #min_level').on("keyup", function()
			{
				$('.store_body').data('WarcryStore').config.minlevel = $(this).val();
			});
			
			$('#store_form #max_level').on("keyup", function()
			{
				$('.store_body').data('WarcryStore').config.maxlevel = $(this).val();
			});
			
			$('#store_form #store_quality').on('change', function()
			{
				$('.store_body').data('WarcryStore').config.quality = $(this).find('option:selected').val();
			});
			
			$('#store_form #store_character_select').on('change', function()
			{
				$('.store_body').data('WarcryStore').config.character = $(this).find('option:selected').val();
			});

			$('#store_form #store_have_currency').on('change', function()
			{
				if ($(this).prop('checked'))
				{
					$('.store_body').data('WarcryStore').config.havecurrency = true;
				}
				else
				{
					$('.store_body').data('WarcryStore').config.havecurrency = false;
				}
			});
			
			// Handle the popup closing
			$('.store_item_purchase_popup').click(function()
			{
				if (PopupAllowClose)
				{
					$('.store_body').data('WarcryStore').config.selectedItem = 0;
					$(this).fadeOut('fast');
				}
			});
			
			// Handles when to close the popup
			$(".store_popup_box").mouseenter(function()
			{
				PopupAllowClose = false;
			}).mouseleave(function()
			{
				PopupAllowClose = true;
			});
			
			var config = $this.data('WarcryStore').config;
		},
		
		ActivateCategory: function(element)
		{
			if ($(element).parent().attr('data-id').length == 0)
				return;
				
			var config = $(this).data('WarcryStore').config;
			var catId = parseInt($(element).parent().attr('data-id'));
			
			// find the current category
			var current = $("div[data-id='" + config.activeCategory +"']");
			
			// Check if we want to close/open the dropdown
			if (catId == config.activeCategory)
			{
				if (current.hasClass('open_category'))
				{
					$(this).WarcryStore("CloseCategory", catId);
				}
				else
				{
					$(this).WarcryStore("OpenCategory", catId);
				}
				
				return;
			}
			
			if (current.length > 0)
			{
				current.find('.store_category_button').removeClass("active_category");
				
				var subs = current.find('.store_sub_categories');
				// check if we have a dropdown list
				if (subs.length > 0)
				{
					// close the dropdown
					$(this).WarcryStore("CloseCategory", config.activeCategory);
					
					// check if we have an active sub category
					subs.find('.active_category').removeClass("active_category");
				}
			}
			
			// Enable the new one
			$(element).addClass("active_category");
			
			// open the list if we have one
			$(this).WarcryStore("OpenCategory", catId);
			
			// set config variables
			config.activeSubCategory = -1;
			config.activeCategory = catId;
		},
		
		ActivateSubCategory: function(element)
		{
			if ($(element).attr('data-id').length == 0)
				return;
				
			var config = $(this).data('WarcryStore').config;
			var catId = parseInt($(element).attr('data-id'));
			
			if (catId == config.activeSubCategory)
			{
				// Disable the sub
				config.activeSubCategory = -1;
				$(element).removeClass("active_category");
				return;
			}
			
			// check if we had previously active sub cat
			$(element).parent().find('.active_category').removeClass("active_category");
			
			// active it
			$(element).addClass('active_category');
			
			// set config variables
			config.activeSubCategory = catId;
		},
		
		CloseCategory: function(id)
		{
			var category = $("div[data-id='" + id +"']");
			
			if (category.length > 0)
			{
				var subs = category.find('.store_sub_categories');
				
				if (subs.length > 0)
				{
					subs.slideUp('fast', function()
					{
						// update the scroll bars
						$('.scrollable').tinyscrollbar_update();
					});
				}
				
				category.removeClass('open_category');
			}
		},
		
		OpenCategory: function(id)
		{
			var category = $("div[data-id='" + id +"']");
			
			if (category.length > 0)
			{
				var subs = category.find('.store_sub_categories');
				
				if (subs.length > 0)
				{
					subs.slideDown('fast', function()
					{
						// update the scroll bars
						$('.scrollable').tinyscrollbar_update();
					});
				}
				
				category.addClass('open_category');
			}
		},

  /*ApplyFilters: function()
		{
			var $this = $(this);
			var $config = $this.data('WarcryStore').config;

			// Check if we have the required filters to begin
			if ($config.search == "" && $config.activeCategory == -1)
			{
				$.fn.ImperiaAlertBox('open', '<p>Please select a category or enter a search to begin.</p>');
				return;
			}

			// Reload the store
			$(this).WarcryStore("LoadItems");
		},

		LoadItems: function()
		{
			var $this = $(this);
			var $config = $this.data('WarcryStore').config;

			$('.store_items_list .items').html('<li class="info">Loading...</li>');
			$('.store_items_list').tinyscrollbar_update();

			//get the results
			$.post("ajax.php?phase=2",
			{
				realm: $config.realm,
				character: $config.character,
				category: $config.activeCategory,
				subcategory: $config.activeSubCategory,
				search: $config.search,
				quality: $config.quality,
				minlevel: $config.minlevel,
				maxlevel: $config.maxlevel,
				havecurrency: $config.havecurrency,
			},
			function(data)
			{
				$('.items').html(data);

				// Refresh some stuff
				$('.store_items_list').tinyscrollbar_update();
				Tooltip.refresh();

				// Hook the purchase buttons
				$('#store_form .purchase_button').click(function()
				{
					$('.store_body').WarcryStore("PurchaseItem", $(this));

					return false;
				});
			});
		},

		PurchaseItem: function(element)
		{
			var $this = $(this);
			var $config = $this.data('WarcryStore').config;
			var id = $(element).attr('data-id');
			var priceGold = parseInt($(element).attr('data-price-gold'));
			var priceSilver = parseInt($(element).attr('data-price-silver'));

			// Check if a character is selected
			if ($config.character == '')
			{
				$.fn.ImperiaAlertBox('open', '<p>Please select a character first.</p>');
				return;
			}

			// prepare the popup
			var info = $(element).parent().clone(false);
			info.find('input[type="button"]').detach();
			info.find('#hover').detach();
			// clear up the content
			$('.popup_box_top').html("");
			// append the new content it
			$('.popup_box_top').append(info);
			// Refresh the tooltips couz this is a new clone
			Tooltip.refresh();

			// set the prices
			if (priceGold > 0)
			{
				$('.popup_currency_choice #gold').css('display', 'inline-block');
				$('.popup_currency_choice #gold').attr('data-amount', priceGold);
				$('.popup_currency_choice #gold p').html('<font color="#927a4b">' + priceGold + '</font> Gold Coins');
			}
			else
			{
				$('.popup_currency_choice #gold').css('display', 'none');
				$('.popup_currency_choice #gold').attr('data-amount', 0);
			}

			if (priceSilver > 0)
			{
				$('.popup_currency_choice #silver').css('display', 'inline-block');
				$('.popup_currency_choice #silver').attr('data-amount', priceSilver);
				$('.popup_currency_choice #silver p').html('<font color="#847f7a">' + priceSilver + '</font> Silver Coins');
			}
			else
			{
				$('.popup_currency_choice #silver').css('display', 'none');
				$('.popup_currency_choice #silver').attr('data-amount', 0);
			}

			// set the item id
			$config.selectedItem = id;

			$('.store_item_purchase_popup').fadeIn('fast');
		},

		PurchaseItemSubmit: function()
		{
			var $this = $(this);
			var $config = $this.data('WarcryStore').config;

			// check if we have selected item
			if ($config.selectedItem == 0)
				return;

			// Get the selected currency
			var currency = $('#store_popup_form input[type="radio"]:checked').val();
			var amount = $('#store_popup_form input[type="radio"]:checked').parent().attr('data-amount');

			// Make some checks before submiting
			$('.store_body').WarcryStore("verifyAmount", amount, currency);
		},

		verifyAmount: function(amount, currency)
        {
            var $this = $(this);
            var $config = $this.data('WarcryStore').config;

            //get the results
            $.get("ajax.php?phase=4",
            {
				silver: (currency == 'silver' ? amount : 0),
				gold: (currency == 'gold' ? amount : 0),
				realm: $config.realm,
			},
			function(data)
			{
				if (data == 'OK')
				{
					// Create a form and submit it
					var form = $('<form method="post" action="' + $BaseURL + '/execute.php?take=buyItems">' +
									'<input type="hidden" name="character" value="' + $config.character + '" />' +
									'<input type="hidden" name="items[0]" value="'+ $config.selectedItem +','+ currency +'" />' +
								 '</form>');

					form.appendTo('body');
					form.submit();
				}
				else
				{
					$('.store_body').data('WarcryStore').config.selectedItem = 0;

					$('.store_item_purchase_popup').fadeOut('fast', function()
					{
						//prompt the error
						$.fn.ImperiaAlertBox('open', '<p>' + data + '</p>');
					});
				}
			});
        }, */
	}
	
  	$.fn.WarcryStore = function(method)
  	{
  		if (methods[method])
		{
     		return methods[method].apply(this, Array.prototype.slice.call( arguments, 1 ));
    	}
		else if (typeof method === 'object' || ! method)
		{
      		return methods.init.apply(this, arguments);
    	}
		else
		{
      		$.error( 'Method ' +  method + ' does not exist on jQuery.WarcryStore');
    	}    
  	};

})(jQuery);
