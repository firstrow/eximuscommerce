
// Process checked categories
$("#productUpdateForm").submit(function(){
	var checked = $("#StoreCategoryTree li.jstree-checked");
	checked.each(function(i, el){
		var cleanId = $(el).attr("id").replace('StoreCategoryTreeNode_', '');
		$("#productUpdateForm").append('<input type="hidden" name="categories[]" value="' + cleanId + '" />');
	});
});

$('#StoreCategoryTree').delegate("a", "click", function (event) {
	$('#StoreCategoryTree').jstree('checkbox').check_node($(this));
	var id = $(this).parent("li").attr('id').replace('StoreCategoryTreeNode_', '');
	$('#main_category').val(id);
});

// Check node
;(function($) {
	$.fn.checkNode = function(id) {
		$(this).bind('loaded.jstree', function () {
			$(this).jstree('checkbox').check_node('#StoreCategoryTreeNode_' + id);
		});
	};
})(jQuery);

// On change `use configurations` select - load available attributes
$('#StoreProduct_use_configurations, #StoreProduct_type_id').change(function(){
	var attrs_block = $('#availableAttributes');
	var type_id = $('#StoreProduct_type_id').val();
	attrs_block.html('');

	if($('#StoreProduct_use_configurations').val() == '0') return;

	$.getJSON('/admin/store/products/loadConfigurableOptions/?type_id='+type_id, function(data){
		var items = [];

		$.each(data, function(key, option) {
			items.push('<li style="clear: both;"><label><input type="checkbox" name="StoreProduct[configurable_attributes][]" value="' + option.id + '" name=""> ' + option.title + '</label></li>');
		});

		$('<ul/>', {
			'class': 'rowInput',
			html: items.join('')
		}).appendTo(attrs_block);
	});
});