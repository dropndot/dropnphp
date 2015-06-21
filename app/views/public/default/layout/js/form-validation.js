// sidebar newslatter validation
function sidebarnewslatter() {   
 var txtemail = document.getElementById('email').value;  
 if (txtemail == ''){
    alert('Please enter email address.');
    document.getElementById('email').value='';
    document.sform.email.focus(); 
    return false;       
 }
 var stremail = txtemail;
 var emailchar = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
 if (!(emailchar.test(stremail))) {
   alert('Please enter your valid email address.');
   document.getElementById('email').value='';
   document.sform.email.focus();
   return false;
 }
 document.sform.submit();
return true;
}
// end function
// Footer newslatter validation
function footernewslatter() {   
 var txtemail = document.getElementById('femail').value;  
 if (txtemail == ''){
    alert('Please enter email address.');
    document.getElementById('femail').value='';
    document.newslatter.email.focus(); 
    return false;       
 }
 var stremail = txtemail;
 var emailchar = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
 if (!(emailchar.test(stremail))) {
   alert('Please enter your valid email address.');
   document.getElementById('femail').value='';
   document.newslatter.email.focus();
   return false;
 }
 document.newslatter.submit();
return true;
}
// end function

