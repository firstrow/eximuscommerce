
/**
 * @param el
 * @return {Boolean}
 * @constructor
 */
function AddRelatedProduct(el)
{
    var str = $(el).children("a").attr("href");
    var parts = str.split("/");
    var trclass = "relatedProductLine"+parts[0];

    if($("."+trclass).length == 0)
    {
        $("#relatedProductsTable").append("<tr class="+trclass+"><td>"+parts[0]+"</td><td>"+parts[1]+"</td><td>" +
            "<a href='#' onclick='return $(this).parent().parent().remove();'>"+deleteButtonText+"</a>" +
            "<input type='hidden' value='"+parts[0]+"' name='RelatedProductId[]'>" +
            "</td></tr>");
    }

    return false;
}
