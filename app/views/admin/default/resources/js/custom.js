// JavaScript Document

jQuery(function($){   
    $('.dpFormCheckAll').click(function (){
        $(this).parents('form:eq(0)').find(':checkbox').attr('checked',this.checked);
    });
    
    //Date picker
    $( '.datepicker' ).datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();
    
    //Sub menu 
    $('.ddsub-container').click(function(){
        $(this).parent('li').find('ul').toggle();
    });
    $('.selectednav ul').show();
});


