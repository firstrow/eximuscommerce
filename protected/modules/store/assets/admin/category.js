/**
 * Scripts for js tree
 */

// Bind tree events
$('#StoreCategoryTree').bind('loaded.jstree', function (event, data) {
	// Open all nodes by default
	data.inst.open_all(-11);
}).delegate("a", "click", function (event) {
	// On link click get parent li ID and redirect to category update action
	var id = $(this).parent("li").attr('id').replace('StoreCategoryTreeNode_', '');
	window.location = '/admin/store/category/update/id/' + id;
}).bind("move_node.jstree", function (e, data) {
	data.rslt.o.each(function (i) {
		$.ajax({
			async : false,
			type: 'GET',
			url: "/admin/store/category/moveNode",
			data : {
				"id" : $(this).attr("id").replace('StoreCategoryTreeNode_',''),
				"ref" : data.rslt.cr === -1 ? 1 : data.rslt.np.attr("id").replace('StoreCategoryTreeNode_',''),
				"position" : data.rslt.cp + i
			}
//            success : function (r) {
//            }
		});
	});
});

function CategoryRedirectToFront(obj)
{
    var id = $(obj).attr("id").replace('StoreCategoryTreeNode_','');
    window.open('/admin/store/category/redirect/id/'+id, '_blank');
}

function CategoryRedirectToAdminProducts(obj)
{
    var id = $(obj).attr("id").replace('StoreCategoryTreeNode_','');
    window.location = '/admin/store/products/?category='+id;
}