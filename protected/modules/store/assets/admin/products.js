
// Process checked categories
$("#productUpdateForm").submit(function(){
	var checked = $("#StoreCategoryTree li.jstree-checked");
	checked.each(function(i, el){
		var cleanId = $(el).attr("id").replace('StoreCategoryTreeNode_', '');
		$("#productUpdateForm").append('<input type="hidden" name="categories[]" value="' + cleanId + '" />');
	});
});