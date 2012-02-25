/**
 * Script for configurable products
 */

/**
 * Find all next object in DOM
 * Usage $('.selector').nextAllData(this).attr(...)
 * @param startFrom
 */
jQuery.fn.nextAllData = function(startFrom){
    var selectedObjects = this;
    var result = [];
    selectedObjects.each(function(i){
        if(this == startFrom) {
            result = selectedObjects.slice(i+1);
        }
    });
    return result;
};


// Disable all dropdowns exclude first
$('.eavData:not(:first)').attr('disabled','disabled');

$('.eavData').change(function(){
    if($(this).val() == '---' || $(this).val() == '0')
    {
        $('#configurable_id').val(0);

        // If selected empty - reset all next dropdowns
        $('.eavData').nextAllData(this).each(function(){
            $(this).find('option:first').attr('selected', 'selected');
            $(this).attr('disabled', 'disabled');
        });
        return;
    }

    var val = pconfPrepArray($(this).val().split('/'));

    // Disable all next
    $('.eavData').nextAllData(this).attr('disabled', 'disabled');
    // Activate first closest
    $('.eavData').nextAllData(this).first().removeAttr('disabled');

    $('.eavData').nextAllData(this).each(function(){
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

// Change price on last dropdown change
$('.eavData:last').change(function(){
    var productId = parseInt($(this).val());
    if(productPrices[productId] != undefined)
    {
        $('#configurable_id').val(productId);
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
        if(v == '' || v == '---' || v == '0' ){
            arr.splice(i,1);
        }
    });
    return arr;
}