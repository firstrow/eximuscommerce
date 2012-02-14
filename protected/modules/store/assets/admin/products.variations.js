// Products controller. Variations tab.

$(document).ready(function(){
    $("#addAttribute").click(function(){
        if($('#variantAttribute'+$('#variantAttribute').val()).length == 0)
        {
            $.ajax({
                url: "renderVariantTable",
                cache: false,
                data: {attr_id: $('#variantAttribute').val()},
                dataType: "html",
                success: function(data){
                    $('#variantsData').append(data);
                }
            });
        }
    });
});

/**
 * @param el clicked link
 */
function cloneVariantRow(el)
{
    var tableId = $(el).attr('rel');
    var baseRow = $(tableId + ' tbody tr')[0];
    $(baseRow).clone().removeClass('baseRow').show().appendTo($(tableId + ' tbody'));
    return false;
}

/**
 * @param el clicked link
 */
function deleteVariantRow(el)
{
    var table = el.parent().parent().parent().parent();
    el.parent().parent().remove();

    // Check if table has any rows and remove table.
    if($(table).find('tbody tr').length == 0)
    {
        $(table).remove();
    }
    return false;
}