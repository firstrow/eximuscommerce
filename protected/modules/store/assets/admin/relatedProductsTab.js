
function AddRelatedProduct(el)
{
    var str = $(el).children("a").attr("href");
    var parts = str.split("/");
    var trclass = "relatedProductLine"+parts[0];

    if($("."+trclass).length == 0)
    {
        $("#relatedProductsTable").append("<tr class="+trclass+"><td>"+parts[0]+"</td><td>"+parts[1]+"</td><td>" +
            "<a href=''>"+deleteButtonText+"</a></td>" +
            "</tr>");
    }

    return false;
}
