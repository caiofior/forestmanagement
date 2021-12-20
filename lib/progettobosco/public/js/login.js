/**
 * Home functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */

 formAjax("#login_form",".login_messages");
 formAjax("#recoverpassword_form",".recoverpassword_messages");
 defaultInputValue("#username","Nome utente (email)");
 $(document).on("click",".password_recover",function(){
     $("#passwordrecover_container").show();
     $(window).scrollTop($("#passwordrecover_container").offset().top);
     return false; 
 });
 /**
  * Set focus to the top
  */
$(document).on("click", "a[data-update]",function () {
    $(window).scrollTop(0);
});
$(document).on("click", "#remove_profile",function () {
    $.colorbox({
        "html"  :   "Rimuovere il tuo profilo ?"+
                    " <a id=\"remove_profile_confirm\"href=\""+$(this).attr("href")+"\" ><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"remove_profile_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
    return false;
});
$(document).on("click","#remove_profile_confirm",function(){
   $.colorbox.close();
});
$(document).on("click","#remove_profile_cancel",function(){
   $.colorbox.close();
   return false;
});