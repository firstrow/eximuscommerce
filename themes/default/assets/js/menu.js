
// Fix menu for Firefox due to
// "The effect of 'position:relative' on ...table-cell... elements is undefined. "
$(document).ready(function(){
    if($.browser.mozilla)
    {
        var items = $("ul.dropdown>li");
        items.css('display', 'block')
            .css('float', 'left')
            .css('width', 979 / items.length);
    }
});