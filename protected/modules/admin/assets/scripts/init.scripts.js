
    <!-- Script to move navigation bar on scroll -->
    $(window).load(function (){
        var topBar = $('#navigation');
        var start  = topBar.offset().top;
        var fixed;
        $(window).scroll(function () {
            if(!fixed && (topBar.offset().top - $(window).scrollTop() < 0)){
                topBar.css('top', 0);
                topBar.css('position', 'fixed');
                topBar.css('width', $('#doc3').css('width'));
                topBar.css('opacity', '0.92');
                $("#hd").css('margin-bottom','38px');
                fixed = true;
            }else if(fixed && $(window).scrollTop() <= start){
                topBar.css('position', '');
                topBar.css('width', '');
                topBar.css('opacity', '1');
                $("#hd").css('margin-bottom','');
                fixed = false;
            }
        });
    });

    jQuery(document).ready(function(){
        $().UItoTop({ easingType: 'easeOutQuart' });
    });