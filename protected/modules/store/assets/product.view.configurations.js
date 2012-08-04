/**
 * Script for configurable products and variants
 */

// Disable all dropdowns exclude first
$('.eavData:not(:first)').attr('disabled','disabled');

$('.eavData').change(function(){
    $('#configurable_id').val(0);
    if($(this).val() == '---' || $(this).val() == '0')
    {
        recalculateProductPrice();
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
            var option = this;

            $(option).hide();
            // Check if one of previous values are present in current option
            $(val).each(function(i, el){
                if(optionVals.contains(el) || $(option).val() == '0'){
                    $(option).show();
                }
            });

        });
    });
});

// Change price on last dropdown change
$('.eavData:last').change(function(){
    var temp = '';
    $('.eavData').each(function(){
        temp = temp + $(this).val();
    });

    temp = pconfPrepArray(temp.split('/'));

    if(temp.length > 1){
        var productId = parseInt(find_duplicates(temp)[0]);
    }else{
        var productId = temp[0];
    }

    if(productPrices[productId] != undefined){
        $('#configurable_id').val(productId);
    }

    recalculateProductPrice();
});


// Process product variants.
// Calculate prices.
$(document).ready(function(){
    $('.variantData').change(function(){
        recalculateProductPrice(this);
    });
});

/**
 * Recalculate product price on change variant or configurable options.
 * Sum product price + variant prices + configurable prices.
 */
function recalculateProductPrice(el_clicked)
{
    var result = parseFloat($('#product_price').val());

    // Update price
    if(typeof(productPrices) != "undefined" && productPrices[$('#configurable_id').val()] != undefined){
        result = result + parseFloat(productPrices[$('#configurable_id').val()]);

        if($("#use_configurations").val() == '1')
            result = result - $('#product_price').val();
    }

    $('.variantData').each(function(){

        //if($(this).is('input:radio')==true && $(this).attr('checked')!='checked'){
        //    return;
		//}

        var variant_id = $(this).val();
        if(jsVariantsData[variant_id]){
            if(jsVariantsData[variant_id].price_type == "1"){
                // Price type is percent
                result = result + (result / 100 * parseFloat(jsVariantsData[variant_id].price));
            }else{
                result = result + parseFloat(jsVariantsData[variant_id].price);
            }
        }
    });

    // Apply current currency
    result = result * parseFloat($('#currency_rate').val());

    $('#productPrice').html(result.toFixed(2));
}

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

/**
 * Check if array contains value
 * @param obj
 */
Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
};

/**
 * Find duplicates in array
 * @param arr
 */
function find_duplicates(arr) {
    var len=arr.length,
        out=[],
        counts={};

    for (var i=0;i<len;i++) {
        var item = arr[i];
        var count = counts[item];
        counts[item] = counts[item] >= 1 ? counts[item] + 1 : 1;
    }

    for (var item in counts) {
        if(counts[item] > 1)
            out.push(item);
    }

    return out;
}

/**
 * Remove from array ampty values and '---'
 * @param arr
 */
function pconfPrepArray(arr)
{
    $.each(arr, function(i, v) {
        if(v == '' || v == '---' || v == '0'){
            arr.splice(i, 1);
        }
    });
    return arr;
}
