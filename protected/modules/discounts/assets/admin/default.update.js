// Process checked categories
$("#discountUpdateForm").submit(function(){
    var checked = $("#StoreDiscountCategoryTree li.jstree-checked");
    checked.each(function(i, el){
        var cleanId = $(el).attr("id").replace('StoreDiscountCategoryTreeNode_', '');
        $("#discountUpdateForm").append('<input type="hidden" name="Discount[categories][]" value="' + cleanId + '" />');
    });
});

// Check node
;(function($) {
    $.fn.checkNode = function(id) {
        $(this).bind('loaded.jstree', function () {
            $(this).jstree('checkbox').check_node('#StoreDiscountCategoryTreeNode_' + id);
        });
    };
})(jQuery);