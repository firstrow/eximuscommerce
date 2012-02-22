/**
 * Script for configurable products
 */

// Disable all dropdowns exclude first
$('.eavData:not(:first)').attr('disabled','disabled');

$('.eavData').change(function(){
    if($(this).val() == '---')
    {
        // If selected empty - reset all next dropdowns
        $(this).nextAll('.eavData').each(function(){
            $(this).find('option:first').attr('selected', 'selected');
            $(this).attr('disabled', 'disabled');
        });
        return;
    }

    var val = pconfPrepArray($(this).val().split('/'));

    // Disable all next
    $(this).nextAll('.eavData').attr('disabled', 'disabled');
    // Activate first closest
    $(this).nextAll('.eavData:first').removeAttr('disabled');

    $(this).nextAll('.eavData').each(function(){
        // Reset current selection
        $(this).find('option:first').attr('selected', 'selected');

        $(this).find('option').each(function(){
            var optionVals = pconfPrepArray($(this).val().split('/'));

            var found = false;
            // Check if one of previous values are present in current option
            $(val).each(function(i,el){
                if($.inArray(el, optionVals))
                    found = true;
            });

            if(!found)
                $(this).hide();
            else
                $(this).show();
        });
    });
});

$('.eavData:last').change(function(){
    var productId = parseInt($(this).val());
    if(productPrices[productId] != undefined)
    {
        $('#productPrice').html(productPrices[productId]);
    }
});

/**
 * Remove from array ampty values and '---'
 * @param arr
 */
function pconfPrepArray(arr)
{
    $.each(arr, function(i, v) {
        if(v == '' || v == '---') {
            arr.splice(i,1);
        }
    });
    return arr;
}