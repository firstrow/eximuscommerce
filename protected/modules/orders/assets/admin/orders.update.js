
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
            reloadOrderedProducts(order_id);
            $.jGrowl(productSuccessAddedToOrder,{position:"bottom-right"});
        }
    });

    return false;
}

/**
 * Delete ordered product
 * @param product_id
 * @param order_id
 * @param token
 */
function deleteOrderedProduct(product_id, order_id, token)
{
    if(confirm(deleteQuestion))
    {
        $.ajax({
            url: "/admin/orders/orders/deleteProduct",
            type: "POST",
            data: {
                YII_CSRF_TOKEN: token,
                product_id: product_id
            },
            dataType: "html",
            success: function(){
                reloadOrderedProducts(order_id);
            }
        });
    }
}

/**
 * Update products list
 */
function reloadOrderedProducts(order_id)
{
    $('#orderedProducts').load('/admin/orders/orders/renderOrderedProducts/order_id/' + order_id);
}