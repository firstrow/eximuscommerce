// Scripts for "Options" tab
$(function() {

    // Add new row
    $(".optionsEditTable .plusOne").click(function(){
        var option_name = Math.random();
        var row = $(".optionsEditTable .copyMe").clone().removeClass('copyMe');
        row.appendTo(".optionsEditTable tbody");
        row.find(".value").each(function(i, el){
            $(el).attr('name', 'options['+option_name+'][]');
        });
        return false;
    });

    // Delete row
    $(".optionsEditTable").delegate(".deleteRow", "click", function(){
        $(this).parent().parent().remove();

        if($(".optionsEditTable tbody tr").length == 1)
        {
            $(".optionsEditTable .plusOne").click();
        }
        return false;
    });

    // On change type toggle options tab
    $("#StoreAttribute_type").change(function(){
        toggleOptionsTab($(this));
    });
    $("#StoreAttribute_type").change();

    // Enable table rows sorting
    $(".optionsEditTable tbody").sortable();

    $("#attributeUpdateForm").submit(function(){
        var el = $("#StoreAttribute_type");
        if($(el).val() != 3 && $(el).val() != 4 && $(el).val() != 5 && $(el).val() != 6)
        {
            $(".optionsEditTable").remove();
        }
        return true;
    });

    /**
     * Show/hide options tab on type change
     * @param el
     */
    function toggleOptionsTab(el)
    {
        var optionsTab = $(".SidebarTabsControl li")[1];
        // Show options tab when type is dropdown or select
        if($(el).val() == 3 || $(el).val() == 4 || $(el).val() == 5 || $(el).val() == 6)
        {
            $(optionsTab).show();

            $(".field_use_in_filter").show();
            $(".field_select_many").show();
        }else{
            $(optionsTab).hide();
            $(".field_use_in_filter").hide();
            $(".field_select_many").hide();
        }
    }

});