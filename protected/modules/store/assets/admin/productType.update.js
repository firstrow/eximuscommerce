
// On form submit select all options
$("#StoreProductTypeForm").submit(function(){
    $("#attributes option").attr('selected', 'selected');
});

// Connect lists
$("#allAttributes").delegate('option', 'click', function(){
    var clon = $(this).clone();
    $(this).remove();
    $(clon).appendTo($("#attributes"));
});
$("#attributes").delegate('option', 'click', function(){
    var clon = $(this).clone();
    $(this).remove();
    $(clon).appendTo($("#allAttributes"));
});

// Process checked categories
$("#StoreProductTypeForm").submit(function(){
    var checked = $("#StoreTypeCategoryTree li.jstree-checked");
    checked.each(function(i, el){
        var cleanId = $(el).attr("id").replace('StoreTypeCategoryTreeNode_', '');
        $("#StoreProductTypeForm").append('<input type="hidden" name="categories[]" value="' + cleanId + '" />');
    });
});

// Process main category
$('#StoreTypeCategoryTree').delegate("a", "click", function (event) {
    $('#StoreTypeCategoryTree').jstree('checkbox').check_node($(this));
    var id = $(this).parent("li").attr('id').replace('StoreTypeCategoryTreeNode_', '');
    $('#main_category').val(id);
});

// Check node
;(function($) {
    $.fn.checkNode = function(id) {
        $(this).bind('loaded.jstree', function () {
            $(this).jstree('checkbox').check_node('#StoreTypeCategoryTreeNode_' + id);
        });
    };
})(jQuery);
