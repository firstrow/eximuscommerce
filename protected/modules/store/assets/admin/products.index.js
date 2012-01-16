
$('#StoreCategoryTreeFilter').bind('loaded.jstree', function (event, data) {
	data.inst.open_all(-1);
}).delegate("a", "click", function (event) {
	var id = $(this).parent("li").attr('id').replace('StoreCategoryTreeFilterNode_', '');
	var obj = $('#productsListGrid .filters td')[0];
	$(obj).append('<input name="category" type="text" value="'+id+'">');
	$('#productsListGrid .filters :input').first().trigger('change');
});