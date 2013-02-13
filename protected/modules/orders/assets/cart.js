
/**
 * Activate +/- buttons
 */

$(document).ready(function(){
    $('button.plus').click(function(){
        var count = $(this).next('.count');
        $(count).val(parseInt($(count).val())+1);
        return false;
    });
    $('button.minus').click(function(){
        var count = $(this).prev('.count');
        var val   = parseInt($(count).val())-1;
        if(val < 1) val = 1;
        $(count).val(val);
        return false;
    });
});

/**
 * Recount total price on change delivery method
 * @param el
 */
function recountOrderTotalPrice(el)
{
    var total          = parseFloat(orderTotalPrice);
    var delivery_price = parseFloat($(el).attr('data-price'));
    var free_from      = parseFloat($(el).attr('data-free-from'));

    if(delivery_price > 0)
    {
        if(free_from > 0 && total > free_from)
        {
            // free delivery
        }else{
            total = total + delivery_price;
        }
    }

    $('#orderTotalPrice').html(total.toFixed(2));
}