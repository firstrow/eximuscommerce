
/**
 * Show dialog
 * @param order_id
 */
function openAddProductDialog(order_id)
{
    $( "#dialog-modal").dialog({
        width: '90%',
        modal: true
    });
}

/**
 * Add product to order
 * @param el TR
 */
function addProductToOrder(el, order_id, token)
{
    var product_id = $(el).children('a').attr('href');
    var quantity = $('#count_' + product_id).val();

    $.ajax({
        url: "/admin/orders/orders/addProduct",
        type: "POST",
        data: {
            YII_CSRF_TOKEN: token,
            order_id: order_id,
            product_id: product_id,
            quantity: quantity
        },
        dataType: "html",
        success: function(){
            // reload product list
        },
        error: function(){
            alert('error');
        }
    });

    return false;
}