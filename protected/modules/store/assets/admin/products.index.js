
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
	$(obj).append('<input name="category" type="hidden" value="'+id+'">');
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
	}else{
		productsHideSidebar();
	}
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

/**
 * Update selected comments status
 * @param status_id
 */
function setProductsStatus(status_id, el)
{
    $.ajax('/admin/store/products/updateIsActive', {
        type:"post",
        data:{
            YII_CSRF_TOKEN: $(el).attr('data-token'),
            ids: $.fn.yiiGridView.getSelection('productsListGrid'),
            status:status_id
        },
        success: function(data){
            $.fn.yiiGridView.update('productsListGrid');
            $.jGrowl(data);
        },
        error:function(XHR, textStatus, errorThrown){
            var err='';
            switch(textStatus) {
                case 'timeout':
                    err='The request timed out!';
                    break;
                case 'parsererror':
                    err='Parser error!';
                    break;
                case 'error':
                    if(XHR.status && !/^\s*$/.test(XHR.status))
                        err='Error ' + XHR.status;
                    else
                        err='Error';
                    if(XHR.responseText && !/^\s*$/.test(XHR.responseText))
                        err=err + ': ' + XHR.responseText;
                    break;
            }
            alert(err);
        }
    });
    return false;
}