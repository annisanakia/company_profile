function resizeWindow(){
    if ($(window).width() >= 768) {
        $('.menu-vertical').removeClass("menu-collapsed");
        $('.menu-vertical').addClass("menu-expanded")
    }else{
        $('.menu-vertical').removeClass("menu-expanded");
        $('.menu-vertical').addClass("menu-collapsed");
    }
};
resizeWindow();
$(window).on('resize', function(){
    resizeWindow();
});
var nav_active = $('.menu-sub.active').closest('.menu-content').prev();
if(nav_active){
    nav_active.addClass('active');
    getOpen(nav_active);
}
function getOpen($this){
    console.log($('.menu-vertical').hasClass("menu-expanded"));
    if($('.menu-vertical').hasClass("menu-expanded")){
        if ($this.find(".arrow").hasClass("open")) {
            $this.find(".arrow").removeClass("open");
            $this.parent().removeClass("open");
        }else{
            $this.find(".arrow").addClass("open");
            $this.parent().addClass("open");
        }
    }
}
$('.nav-link').click(function(){
    getOpen($(this));
});
$('.nav-link.parent').click(function(e){
    e.preventDefault();
});
$('.navbar-toggle').click(function(){
    if ($('.menu-vertical').hasClass("menu-expanded")) {
        $('.menu-vertical').removeClass("menu-expanded");
        $('.menu-vertical').addClass("menu-collapsed");
    }else{
        $('.menu-vertical').removeClass("menu-collapsed");
        $('.menu-vertical').addClass("menu-expanded");
    }
});