$(document).ready(function() {
    $( window ).on('scroll', function() {
        var siderWidth = $('.sidebar').width();

        var sidebarpos = parseInt($(window).scrollTop()),windowhght = parseInt($(window).height());

        var sidebarleft = parseInt($(".sidebar").offset().left), 

        sidebarHght=parseInt($(".sidebar").outerHeight()),

        sidebartop=parseInt($(".postDetailContent").offset().top),
            
        otherSeriesTop=($(".newBornSection").offset())?(parseInt($(".newBornSection").offset().top)):0,

        bodyhght = parseInt($("body").height());
        
        
        if(otherSeriesTop == 0){
            if ((sidebarpos > (sidebarHght + sidebartop) - windowhght)) {
                if($(window).width()>800){
                    $(".sidebar").css({
                        "position":"fixed",
                        "left":sidebarleft,
                        "width": siderWidth + 'px',
                        "top":-(sidebarHght-windowhght+20)
                    });
                }
            }else {
                $(".sidebar").css({
                    "position":"relative",
                    "left":0,
                    "top":0
                });
            }
        }else{
            if ((sidebarpos > (sidebarHght + sidebartop) - windowhght) && (sidebarpos < (otherSeriesTop + 50) - windowhght)) {
                if($(window).width()>800){
                    $(".sidebar").css({
                        "position":"fixed",
                        "left":sidebarleft,
                        "width": siderWidth + 'px',
                        "top":-(sidebarHght-windowhght+20)
                    });
                }
            }else {
                $(".sidebar").css({
                    "position":"relative",
                    "left":0,
                    "top":0
                });
            }
        }
    });
});

/*$(window).on('orientationchange', function(){
    
    $( window ).on('scroll', function() {
        var siderWidth = $('.sidebar').width();

        var sidebarpos = parseInt($(window).scrollTop()),windowhght = parseInt($(window).height());

        var sidebarleft = parseInt($(".sidebar").offset().left), 

        sidebarHght=parseInt($(".sidebar").outerHeight()),

        sidebartop=parseInt($(".postDetailContent").offset().top),

        bodyhght = parseInt($("body").height());
        
        $(".sidebar").css({
            "position":"relative",
            "width": siderWidth + 'px',
            "left":0,
            "top":0
        });

        if (sidebarpos > (sidebarHght + sidebartop) - windowhght) {
            if($(window).width()>800){
                $(".sidebar").css({
                    "position":"fixed",
                    "left":sidebarleft,
                    "width": siderWidth + 'px',
                    "top":-(sidebarHght-windowhght+20)
                });
            }
        } else {
            $(".sidebar").css({
                "position":"relative",
                "left":0,
                "top":0
            });
        }
    });
});

$(window).on('resize', function(){
    
    $( window ).on('scroll', function() {    
        var siderWidth = $('.sidebar').width();

        var sidebarpos = parseInt($(window).scrollTop()),windowhght = parseInt($(window).height());

        var sidebarleft = parseInt($(".sidebar").offset().left), 

        sidebarHght=parseInt($(".sidebar").outerHeight()),

        sidebartop=parseInt($(".postDetailContent").offset().top),

        bodyhght = parseInt($("body").height());
        
        $(".sidebar").css({
            "position":"relative",
            "width": siderWidth + 'px',
            "left":0,
            "top":0
        });

        if (sidebarpos > (sidebarHght + sidebartop) - windowhght) {
            if($(window).width()>800){
                $(".sidebar").css({
                    "position":"fixed",
                    "left":sidebarleft,
                    "width": siderWidth + 'px',
                    "top":-(sidebarHght-windowhght+20)
                });
            }
        } else {
            $(".sidebar").css({
                "position":"relative",
                "left":0,
                "top":0
            });
        }
    });
});*/