
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

/**
 * Display window with all categories list.
 *
 * @param el_clicked
 */
function showCategoryAssignWindow(el_clicked)
{
    if($("#set_categories_dialog").length == 0)
    {
        var div =  $('<div id="set_categories_dialog"/>');
        $(div).css('max-height',$(window).height()-110+'px');
        $(div).attr('title', 'Назначить категории');
        $('body').append(div);
    }

    $('body').scrollTop(30);

    var dialog = $("#set_categories_dialog");
    dialog.load('/admin/store/products/renderCategoryAssignWindow');

    dialog.dialog({
        position:'top',
        modal: true,
        buttons: {
            "Переместить": function() {
                var checked = $("#CategoryAssignTreeDialog .jstree-checked");
                var ids = [];

                checked.each(function(key,el){
                    var id = $(el).attr('id').replace('CategoryAssignTreeDialogNode_', '');
                    ids.push(id);
                });

                if($("#CategoryAssignTreeDialog .jstree-clicked").parent().length == 0)
                {
                    $.jGrowl("На выбрана 'главная' категория. Кликните на название категории, чтобы сделать ее главной.",{position:"bottom-right"});
                    return;
                }

                $.ajax('/admin/store/products/assignCategories', {
                    type:"post",
                    data:{
                        YII_CSRF_TOKEN: $(el_clicked).attr('data-token'),
                        category_ids: ids,
                        main_category: $("#CategoryAssignTreeDialog .jstree-clicked").parent().attr('id').replace('CategoryAssignTreeDialogNode_', ''),
                        product_ids: $.fn.yiiGridView.getSelection('productsListGrid')
                    },
                    success: function(){
                        $(dialog).dialog("close");
                        $.jGrowl("Изменения сохранены",{position:"bottom-right"});
                    },
                    error: function(){
                        $.jGrowl("Ошибка", {position:"bottom-right"});
                    }
                });
            },
            "Отмена": function() {
                $( this ).dialog( "close" );
            }
        }
    });
}

function showDuplicateProductsWindow(link_clicked)
{
    if($("#duplicate_products_dialog").length == 0)
    {
        var div =  $('<div id="duplicate_products_dialog"/>');
        $(div).attr('title', 'Копировать');
        $('body').append(div);
    }

    var dialog = $("#duplicate_products_dialog");
    dialog.load('/admin/store/products/renderDuplicateProductsWindow');

    dialog.dialog({
        modal: true,
        buttons: {
            "Копировать": function() {
                $.ajax('/admin/store/products/duplicateProducts', {
                    type:"post",
                    data: {
                        YII_CSRF_TOKEN: $(link_clicked).attr('data-token'),
                        products: $.fn.yiiGridView.getSelection('productsListGrid'),
                        duplicate: $("#duplicate_products_dialog form").serialize()
                    },
                    success: function(data){
                        $(dialog).dialog("close");
                        $.jGrowl("Изменения сохранены. <a href='"+data+"'>Просмотреть копии продуктов.</a>",{position:"bottom-right"});
                    },
                    error: function(){
                        $.jGrowl("Ошибка", {position:"bottom-right"});
                    }
                });
            },
            "Отмена": function() {
                $( this ).dialog( "close" );
            }
        }
    });
}

function checkAllDuplicateAttributes(el)
{
    if($(el).prev().attr('checked'))
    {
        $('#duplicate_products_dialog form input').attr('checked', false);
        $(el).prev().attr('checked', false);
    }
    else
    {
        $('#duplicate_products_dialog form input').attr('checked', true);
        $(el).prev().attr('checked', true);
    }
}