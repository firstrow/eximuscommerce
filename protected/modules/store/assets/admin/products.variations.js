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

function cloneVariantRow(el)
{
    var tableId = $(el).attr('rel');
    var baseRow = $(tableId + ' tbody tr')[0];
    $(baseRow).clone().removeClass('baseRow').show().appendTo($(tableId + ' tbody'));
    return false;
}

function deleteVariantRow(el)
{
    var table = el.parent().parent().parent().parent();
    el.parent().parent().remove();

    // Check if table has any rows
    if($(table).find('tbody tr').length == 0)
    {
        $(table).remove();
    }
    return false;
}