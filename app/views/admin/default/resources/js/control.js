$(document).ready(function(){
    $("#upload_image").hide();
    $("#txtareaVal").hide();    
    $(".settings_type").change(function(){
        if($(this).val() == "text"){
            $("#txtareaVal").hide();
            $("#upload_image").hide();
            $("#txtVal").show(); 
        } else if($(this).val() == "textarea"){
            $("#txtVal").hide();
            $("#upload_image").hide();
            $("#txtareaVal").show(); 
        } else if($(this).val() == "image"){
            $("#txtareaVal").hide();
            $("#txtVal").hide();
            $("#upload_image").show();   
        }
    });           
    $("#categoryArea").hide();
    $("#urlArea").hide();    
    $(".menuType").change(function(){
        if($(this).val() == "page"){
            $("#categoryArea").hide();
            $("#urlArea").hide();
            $("#pageArea").show(); 
        } else if($(this).val() == "category"){
            $("#pageArea").hide();
            $("#urlArea").hide();
            $("#categoryArea").show(); 
        } else if($(this).val() == "url"){
            $("#pageArea").hide();
            $("#categoryArea").hide();
            $("#urlArea").show();  
        }
    });           
       
    $(".editmenuType").change(function(){
        if($(this).val() == "page"){
            $("#editcategoryArea").hide();
            $("#editurlArea").hide();
            $("#editpageArea").show(); 
        } else if($(this).val() == "category"){
            $("#editpageArea").hide();
            $("#editurlArea").hide();
            $("#editcategoryArea").show(); 
        } else if($(this).val() == "url"){
            $("#editpageArea").hide();
            $("#editcategoryArea").hide();
            $("#editurlArea").show();  
        }
    });           
    $(".parentMenu").change(function(){
        if($(this).val()){
            $(".megamenuArea").css("display", "none");
        } else {
            $(".megamenuArea").show(); 
        } 
    });           
});
