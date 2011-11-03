	// Grid view dropdown links code
	(function($){
	    $.fn.gridViewDropdown=function(){
	        return this.each(function(){
	            var menu = $(this);
	            menu.click(function(){
	            	if (menu.hasClass('active'))
	            	{
	            		// hide
	            		menu.removeClass('active');
	            		menu.next('.gridViewOptionsMenu').css('display', 'none');
	            	}else{
	            		// show
	            		menu.addClass('active');
	            		menu.next('.gridViewOptionsMenu').css('display', 'block');				            		
	            	}
	            });

				/* hide when clicked outside */
				$(document.body).bind('click',function(e) {
					if( !$(e.target).hasClass('gridViewOptions') && !$(e.target).hasClass('gridViewOptionsMenu') )
					{
	            		menu.removeClass('active');
	            		menu.next('.gridViewOptionsMenu').css('display', 'none');									
					}
				});
				            
	        });
	    }
	})(jQuery);

	function gridViewDropdownInit()
	{
		$('.gridViewOptions').gridViewDropdown();
	}

	$('document').ready(function(){
	  	gridViewDropdownInit();
	});

	// Clear fields code. 
	// Read more at http://www.yiiframework.com/extension/clear-filters-gridview/
	$.fn.clearFields = $.fn.clearInputs = function() {
	    return this.each(function() {
	        var t = this.type, tag = this.tagName.toLowerCase();
	        if (t == 'text' || t == 'password' || tag == 'textarea') {
	            this.value = '';
	        }
	        else if (t == 'checkbox' || t == 'radio') {
	            this.checked = false;
	        }
	        else if (tag == 'select') {
	            this.selectedIndex = -1;
	        }
	    });
	};

	function clearSGridViewFilter(id)
	{
	    try
	    {    
	        $('#'+ id +' :input').clearFields(); // this will clear all input in the current grid
	        $('#'+ id +' :input').first().trigger('change');// to submit the form
	        return false;
	    }
	    catch(e)
	    {
	        return false;
	    }
	}

	// Remember filter
	function loadSGridViewFilterById(gridId, filterId)
	{
		first = $('#'+ gridId +' :input').first();
		$("<input type='hidden' value='1' name='loadFilter'>").appendTo(first);
		first.trigger('change');
	}


	function saveSGridViewFilter(gridId)
	{
		// Get serialized grid attributes
		// Show promt
		// Save
		// Reload grid
		$("#mydialog").dialog("open"); return false;
	}