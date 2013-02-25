
/**
 * Function executed after product added to cart
 */
function processCartResponse(data, textStatus, jqXHR)
{
    var productErrors = $('#productErrors');
    if(data.errors)
    {
        // Display errors
        productErrors.html(data.errors.join('<br/>')).show();
    }else{
        // Display "Successful message"
        productErrors.hide();
        reloadSmallCart();
        $.jGrowl("Товар успешно добавлен в корзину. <a href='/cart'>Перейти к оформлению</a>.", {position:"bottom-right"});
    }
}