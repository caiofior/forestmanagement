/* 
 * New form a 
 */
$("#cod_part").focus(function() {
    $(".new_forma_error").hide();
})
.keyup(function() {
   $.ajax({
     url: $("#newcodepart").attr("action"),
     data: {
         cod_part:$("#cod_part").val()
     },
     success: function(data) {
         if (data) {
             $("#new_forma").removeAttr("disabled");
             $(".new_forma_error").addClass("succesfull").text("Il codice è corretto").show();
         }
         else {
             $("#new_forma").attr("disabled","disabled");
             $(".new_forma_error").removeClass("succesfull").text("È già presente una particella con questo codice").show();
         }
     }
   }); 
});

