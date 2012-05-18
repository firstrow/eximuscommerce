
$(document).ready(function(){
    $("body").append('<div id="orderPreviewBox"></div>');

    $("div").delegate(".productPreview", "mouseenter", function(el){
        // Load products
        $.ajax({
            url: '/admin/orders/orders/jsonOrderedProducts/id/'+$(this).attr('id'),
            dataType: 'json',
            success: function(data){
                var box = $("#orderPreviewBox");

                $(data).each(function(i, row){
                    $(box).append(i+1+'. <span class="name">'+row.name+'</span> '+row.price+' x '+row.quantity+'<br/>');
                });

                $("#orderPreviewBox")
                    .css('left', $(el).attr('pageX')-100)
                    .css('top', $(el).attr('pageY')+20)
                    .css('display','block');
                return false;
            }
        });
        return false;
    });

    // Hide on mouse out
    $("div").delegate(".productPreview", "mouseout", function(){
        $("#orderPreviewBox").html('').hide();
    });
});
