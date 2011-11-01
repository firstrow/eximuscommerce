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