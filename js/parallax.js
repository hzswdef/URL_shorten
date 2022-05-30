$(".wrap").mousemove(function(e) {
    var _ = $(".wrap");
    
    var relX = 50 + (e.pageX / 512) - (_.width() / 1024);
    var relY = 50 + (e.pageY / 32) - (_.height() / 64);
    //alert(relX + ' ' + relY);
    
    TweenMax.to(".wrap", 1, {
        'background-position': relX + '% ' + relY + '%'
    });
});