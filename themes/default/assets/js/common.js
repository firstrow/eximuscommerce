/**
 * Common functions
 */

$(document).ready(function() {
    // Hide flash messages block
    $(".flash_messages .close").click(function(){
        $(".flash_messages").fadeOut();
    });

    // Search box
    var searchQuery = $("#searchQuery");
    var defText = searchQuery.val();
    searchQuery.focus(function(){
        if($(this).val()==defText)
            $(this).val('');
    });
    searchQuery.blur(function(){
        if($(this).val()=='')
            $(this).val(defText);
    });

});

/**
 * Add product to compare list and reload page
 * @param id
 * @return {Boolean}
 */
function addProductToCompare(id)
{
    $.get('/products/compare/add/'+id, function(response){
        window.location=window.location;
    });
    return false;
}

/**
 * Add product to wish list and reload page
 * @param id
 * @return {Boolean}
 */
function addProductToWishList(id)
{
    $.ajax({
        url: '/wishlist/add/'+id,
        statusCode: {
            302: function (data) {
                window.location='/users/login';
            },
            200: function()
            {
                window.location=window.location;
            }
        }
    });
    return false;
}

/**
 * Update cart data after product added.
 */
function reloadSmallCart()
{
    $("#cart").load('/cart/renderSmallCart');
}

/**
 * Add product to cart from list
 * @param data
 * @param textStatus
 * @param jqXHR
 * @param redirect
 */
function processCartResponseFromList(data, textStatus, jqXHR, redirect)
{
    var productErrors = $('#productErrors');
    if(data.errors)
    {
        window.location = redirect
    }else{
        reloadSmallCart();
        $('html, body').animate({scrollTop:0}, 'slow');
        $("#cart").fadeOut().fadeIn().fadeOut().fadeIn();
    }
}

/**
 * Rate product
 * @param id product id
 */
function rateProduct(id)
{
    var url = '/store/ajax/rateProduct/'+id;
    var rating = $('input[name=rating_'+id+']:checked').val();
    $('input[name=rating_'+id+']').rating('disable');
    $.ajax({
        url: url,
        data:{rating:rating}
    });

}

function applyCategorySorter(el)
{
    window.location = $(el).val();
}
