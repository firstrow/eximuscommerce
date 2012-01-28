
// On form submit select all options
$("#StoreProductTypeForm").submit(function(){
    $("#attributes option").attr('selected', 'selected');
});

// Connect lists
$("#allAttributes").delegate('option', 'click', function(){
    var clon = $(this).clone();
    $(this).remove();
    $(clon).appendTo($("#attributes"));
});
$("#attributes").delegate('option', 'click', function(){
    var clon = $(this).clone();
    $(this).remove();
    $(clon).appendTo($("#allAttributes"));
});