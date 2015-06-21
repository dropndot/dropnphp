// Custom js 

$(function(){
    $("#clock").MyDigitClock({
        fontSize: '14px',
        fontFamily: 'inherit',
        fontColor: '#334a57',
        fontWeight: 'normal',
        background: 'none',
        timeFormat: '{HH}<span id="ch1">:</span>{MM}<span id="ch2">:</span>{SS}',
        bShowHeartBeat: false,
        bAmPm:true
    }); 
    
    //Feature product on home page
    $("#featureProduct").jCarouselLite({
        speed: 800,
        visible: 5,
        btnNext: "#featureNextBtn",
        btnPrev: "#featurePrevBtn"
    });
    //Footer partner slider
    $("#footerSlider").jCarouselLite({
        speed: 800,
        visible: 5,
        btnNext: "#footerSliderNextBottom",
        btnPrev: "#footerSliderPrevBottom"
    });
    //Partner accordian
    $('.detailsPartnerInfo').hide();	
    $('.partnerList dd:first .detailsPartnerInfo').show();     
    $('.partnerList dd:first .shortPartnerInfo').addClass('shortPartnerInfoAlt');     
    $('.show_hide').click(function () {
        $(this).parents('.partnerList dd').find('.detailsPartnerInfo').toggle('slow');
        $(this).parents('.partnerList dd').find('.shortPartnerInfo').toggleClass('shortPartnerInfoAlt');	
    });
    
    // signin form 
    $('.signinbtn').click(function(){
        $('.searchFieldList').toggle();
    });
    $('.closebtn').click(function(){
        $('.signinForm').hide();
    });
    // Google map
    $('.viewMap').click(function(){        
        $('.mapDetails').toggle();
    });
    $('.closemap').click(function(){
        $('.mapDetails').hide();
    });
    
});
//Home slider
$(window).load(function() {
    $('#slider').flexslider({
        animation: "fade",
        controlNav: false,
        slideshow: true,
        slideshowSpeed: 5000
    });
});
$(window).load(function() {
    $('#newsSlider').flexslider({
        animation: "slide",
        controlNav: false,
        slideshow: true,
        slideshowSpeed: 5000
    });
});

