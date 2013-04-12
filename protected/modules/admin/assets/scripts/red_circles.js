/**
 * Display and prosess counters for orders and comments.
 */
$(function(){
    $('.hasRedCircle').each(function(i, el){
        $(el).append('<div class="circle_label"></div>');
    });

    setInterval(function(){
        reloadCounters();
    }, 5000);

    function reloadCounters()
    {
        $.getJSON('/admin/core/ajax/getCounters?' + Math.random(), function(data){
            if(data.orders > 0)
            {
                $('.circle-orders .circle_label').html(data.orders).show();
            }else{
                $('.circle-orders .circle_label').hide();
            }

            if(data.comments > 0)
            {
                $('.circle-comments .circle_label').html(data.comments).show();
            }else{
                $('.circle-comments .circle_label').hide();
            }
        });
    }

    reloadCounters();
});