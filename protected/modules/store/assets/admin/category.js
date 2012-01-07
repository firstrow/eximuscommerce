/**
 * Scripts for js tree
 */

// Bind tree events
$('#StoreCategoryTree').bind('loaded.jstree', function (event, data) {
	// Open all nodes by default
	data.inst.open_all(-1);
}).delegate("a", "click", function (event) {
	// On link click get parent li ID and redirect to category update action
	var id = $(this).parent("li").attr('id').replace('StoreCategoryTreeNode_', '');
	window.location = '/admin/store/category/update/id/' + id;
});