/* 
 * Form N controls
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Delete N form
 */
$(document).on("click",".deleteTab",function(){
    $.colorbox({
        "html"  :   "Vuoi cancellare la scheda selezionata ?"+
                    " <a id=\"deleteTab_confirm\"href=\""+$(this).attr("href")+"&deleteTab3=1\" ><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"deleteTab_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#deleteTab_confirm",function(){
   $.colorbox.close();
});
$(document).on("click","#deleteTab_cancel",function(){
   $.colorbox.close();
   return false;
});
/**
 * Manages autocomplete note code
 **/
function autocompleteCodeNote () {
        $("#cod_nota_descr, #content_schedan_note input").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_nota&archivio=schedan",
        select: function( event, ui ) {
            $("#cod_nota").val(ui.item.id )
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#cod_nota_descr").val("");
                }
                el = $(this);
                old = el.data("old-value");
                if (typeof old == "string" && el.val() != "" && el.val() != old) {
                    note_id = $(this).data("note-id");
                    $("#text_nota_"+note_id).trigger("change");
                }
        }
    }).focus(function() {
        $(this).val("").autocomplete("search","")
    }).blur(function () {
        el = $(this);
        old = el.data("old-value");
        if (typeof old == "string" && el.val() == "") {
            el.val(old);
        }
    });
}
autocompleteCodeNote ();
$(document).ajaxComplete(function() {
    autocompleteCodeNote ();
});
/**
 * Manages edit note text
 **/
$(document).on("change","#content_schedan_note textarea", function() {
    el = $("#newnote .addnew").parent("a");
    note_id = $(this).data("note-id");
    data = {
        "xhr":1,
        "note_id":note_id,
        "cod_nota" : $("#cod_nota_"+note_id).val(),
        "text_nota" : $("#text_nota_"+note_id).val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                    $("#notes_list_update").trigger("click");
                    status = true;
                }
                else {
                    $.each(response["names"], function(id,val) {
                        $("#"+val).addClass("error");
                    });
                    $("#ajaxloader").hide();
                }
                
            },
            error: function(jqXHR , textStatus,  errorThrown) {
                $("#ajaxloader").hide();
            }
        });
     
        return status;
    
});
/**
 * Manages add new note
 */
$(document).on("click","#newnote .addnew",function(){
    status = false;
    el = $(this).parent("a");
    data = {
        "xhr":1,
        "cod_nota" : $("#cod_nota").val(),
        "text_nota" : $("#text_nota").val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                     $("#cod_nota_descr").val("");
                     $("#cod_nota").val("");
                     $("#text_nota").val("");
                    status = true;
                }
                else {
                    $.each(response["names"], function(id,val) {
                        $("#"+val).addClass("error");
                    });
                    $("#ajaxloader").hide();
                }
                
            },
            error: function(jqXHR , textStatus,  errorThrown) {
                $("#ajaxloader").hide();
            }
        });
     
        return status;  
    
    
});
/**
 * Manages delete note
 **/
$(document).on("click","#content_schedan_note .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la nota selezionata ?"+
                    " <a id=\"note_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab3_note\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"note_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#note_delete_confirm",function(){
   $.colorbox.close();
});
$(document).on("click","#note_delete_cancel",function(){
   $.colorbox.close();
   return false;
});
formAjax("#formN",".formn_errors");
$("fieldset > div > input,fieldset > input,fieldset > div > select").change(function () {
   $("#formB3").trigger("submit");
});
$("fieldset > div > input").dblclick(function () {
    $(this).val("");
});
$("fieldset").dblclick(function () {
    $(this).find("input:checkbox,input:radio").removeAttr("checked");
});

