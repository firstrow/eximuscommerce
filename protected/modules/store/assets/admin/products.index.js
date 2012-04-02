
// Init sidebar
if($.cookie('productsSidebarStatus') == 'hidden')
{
	productsHideSidebar();
}

// Init tree
$('#StoreCategoryTreeFilter').bind('loaded.jstree', function (event, data) {
	//data.inst.open_all(0);
}).delegate("a", "click", function (event) {
	try{
		var id = $(this).parent("li").attr('id').replace('StoreCategoryTreeFilterNode_', '');
	}catch(err){
		// 'All Categories' clicked
		var id = 0;
	}
	var obj = $('#productsListGrid .filters td')[0];
	$(obj).append('<input name="category" type="text" value="'+id+'">');
	$('#productsListGrid .filters :input').first().trigger('change');
});

/**
 * Toggle sidebar
 */
function productToggleSidebar()
{
	if($('#sidebar').css('display') == 'none')
	{
		$.cookie('productsSidebarStatus', 'visible', {expires: 31, path: '/'});
		$("#yui-main").children('.marright').addClass("yui-b");
		$("#sidebar").show();
	}
	else
		productsHideSidebar();
}

/**
 * Hide sidebar
 */
function productsHideSidebar()
{
	$.cookie('productsSidebarStatus', 'hidden', {expires: 31, path: '/'});
	$("#yui-main .yui-b").removeClass("yui-b");
	$("#sidebar").hide();
}