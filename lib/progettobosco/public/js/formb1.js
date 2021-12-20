/* 
 * Fom b1 controls
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Delete B1 form
 */
$(document).on("click",".deleteTab",function(){
    $.colorbox({
        "html"  :   "Vuoi cancellare la scheda selezionata ?"+
                    " <a id=\"deleteTab_confirm\"href=\""+$(this).attr("href")+"&deleteTab1=1\" ><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
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
 * Manages forest type description
 **/
$("#t_descriz").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=t&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#t").val(ui.item.id );
        $("#formB1").trigger("submit");
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#t_descriz").val($("#t_descriz").data("old-descriz"));
            }
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
});
/**
 * Manages structure description
 **/
$("#s_descriz").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=s&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#s").val(ui.item.id );
        $("#formB1").trigger("submit");
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#s_descriz").val($("#s_descriz").data("old-descriz"));
            }
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
});
$("#arboreecontainer").prepend("<a id=\"arboree_list_update\" style=\"display:none;\" href=\""+$("#formB1").attr("action")+"\" data-update=\"content_schedab_arboree\"></a>");
/**
 * Manages autocomplete arboree cod coltu
 **/
function autocompleteColtu () {
        $("#cod_coltu_descr, #content_schedab_arboree input").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_coltu&objectid="+$("#objectid").val(),
        select: function( event, ui ) {
            $("#cod_coltu").val(ui.item.id );
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#cod_coltu_descr").val("");
                }
                el = $(this);
                old = el.data("old-value");
                if (typeof old == "string" && el.val() != "" && el.val() != old) {
                    arboree_id = $(this).data("arboree-id");
                    $("#cod_coper_"+arboree_id).trigger("change");
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
autocompleteColtu ();
$(document).ajaxComplete(function() {
    autocompleteColtu ();
});
/**
 * Manages edit arboree cod_coper
 **/
$(document).on("change","#content_schedab_arboree select", function() {
    el = $("#newarboree .addnew").parent("a");
    arboree_id = $(this).data("arboree-id");
    data = {
        "xhr":1,
        "arboree_id":arboree_id,
        "cod_coltu" : $("#cod_coltu_"+arboree_id).val(),
        "cod_coper" : $("#cod_coper_"+arboree_id).val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                    $("#arboree_list_update").trigger("click");
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
 * Manages add new forest cover
 */
$(document).on("click","#newarboree .addnew",function(){
    status = false;
    el = $(this).parent("a");
    data = {
        "xhr":1,
        "cod_coltu" : $("#cod_coltu").val(),
        "cod_coper" : $("#cod_coper").val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                     $("#cod_coltu_descr").val("");
                     $("#cod_coltu").val("");
                     $("#cod_coper option").removeAttr("selected");
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
 * Manages delete forest cover
 **/
$(document).on("click","#content_schedab_arboree .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la specie selezionata ?"+
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab_arboree\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"codcover_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#codcover_delete_confirm",function(){
   $.colorbox.close();
});
$(document).on("click","#codcover_delete_cancel",function(){
   $.colorbox.close();
   return false;
});
$("#arbustivecontainer").prepend("<a id=\"arbustive_list_update\" style=\"display:none;\" href=\""+$("#formB1").attr("action")+"\" data-update=\"content_schedab_arbustive\"></a>");
/**
 * Manages autocomplete arbustive cod coltu
 **/
function autocompleteColtuAr () {
        $("#cod_coltu_ar_descr").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_coltu_ar&objectid="+$("#objectid").val(),
        select: function( event, ui ) {
            $("#cod_coltu_ar").val(ui.item.id )
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#cod_coltu_ar_descr").val("");
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
autocompleteColtuAr ();
$(document).ajaxComplete(function() {
    autocompleteColtuAr ();
});
/**
 * Manages add new shrub
 */
$(document).on("click","#newarbustive .addnew",function(){
    status = false;
    el = $(this).parent("a");
    data = {
        "xhr":1,
        "cod_coltu_ar" : $("#cod_coltu_ar").val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                     $("#cod_coltu_ar_descr").val("");
                     $("#cod_coltu_ar").val("");
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
 * Manages delete shrub
 **/
$(document).on("click","#content_schedab_arbustive .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la specie selezionata ?"+
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab_arbustive\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"codcover_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$("#erbaceecontainer").prepend("<a id=\"erbacee_list_update\" style=\"display:none;\" href=\""+$("#formB1").attr("action")+"\" data-update=\"content_schedab_erbacee\"></a>");
/**
 * Manages autocomplete erbacee cod coltu
 **/
function autocompleteColtuEr () {
        $("#cod_coltu_er_descr").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_coltu_er&objectid="+$("#objectid").val(),
        select: function( event, ui ) {
            $("#cod_coltu_er").val(ui.item.id )
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#cod_coltu_er_descr").val("");
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
autocompleteColtuEr ();
$(document).ajaxComplete(function() {
    autocompleteColtuEr ();
});
/**
 * Manages add new herbaceus
 */
$(document).on("click","#newerbacee .addnew",function(){
    status = false;
    el = $(this).parent("a");
    data = {
        "xhr":1,
        "cod_coltu_er" : $("#cod_coltu_er").val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                     $("#cod_coltu_er_descr").val("");
                     $("#cod_coltu_er").val("");
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
 * Manages delete herbaceus
 **/
$(document).on("click","#content_schedab_erbacee .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la specie selezionata ?"+
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab_erbacee\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"codcover_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
/**
 * Manages autocomplete nome scien
 **/
function autocompleteRennovationSpecie () {
        $("#spe_nov_descr").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_coltu&objectid="+$("#objectid").val(),
        select: function( event, ui ) {
            $("#spe_nov").val(ui.item.id );
            $("#formB1").trigger("submit");
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#spe_nov_descr").val("");
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
autocompleteRennovationSpecie ();
$(document).ajaxComplete(function() {
    autocompleteRennovationSpecie ();
});
$("#d_spec_container").prepend("<a id=\"d_spec_list_update\" style=\"display:none;\" href=\""+$("#formB1").attr("action")+"\" data-update=\"content_schedab_dspecieexitimation\"></a>");
/**
 * Manages autocomplete d spec cod coltu
 **/
function autocompleteColtuD () {
        $("#cod_coltu_d_descr, #content_schedab_dspecieexitimation input.arboree").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_coltu_d&objectid="+$("#objectid").val(),
        select: function( event, ui ) {
            $("#cod_coltu_d").val(ui.item.id )
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#cod_coltu_d_descr").val("");
                }
                el = $(this);
                old = el.data("old-value");
                if (typeof old == "string" && el.val() != "" && el.val() != old) {
                    arboree_id = $(this).data("arboree-id");
                    $("#cod_coper_d_"+arboree_id).trigger("change");
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
autocompleteColtuD ();
$(document).ajaxComplete(function() {
    autocompleteColtuD ();
});
/**
 * Manages edit arboree cod_coper
 **/
$(document).on("change","#content_schedab_dspecieexitimation input,#content_schedab_dspecieexitimation select", function() {
    el = $("#newdspecieexitimation .addnew").parent("a");
    arboree_id = $(this).data("arboree-id");
    data = {
        "xhr":1,
        "arboree_id":arboree_id,
        "cod_coltu" : $("#cod_coltu_d_"+arboree_id).val(),
        "cod_coper" : $("#cod_coper_d_"+arboree_id).val(),
        "massa_tot" : $("#massa_tot_"+arboree_id).val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                    $("#d_spec_container").trigger("click");
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
 * Manages add new forest cover
 */
$(document).on("click","#newdspecieexitimation .addnew",function(){
    status = false;
    el = $(this).parent("a");
    data = {
        "xhr":1,
        "cod_coltu" : $("#cod_coltu_d").val(),
        "cod_coper" : $("#cod_coper_d").val(),
        "massa_tot" : $("#massa_tot").val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                     $("#cod_coltu_d_descr").val("");
                     $("#cod_coltu_d").val("");
                     $("#massa_tot").val("");
                     $("#cod_coper_d option").removeAttr("selected");
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
 * Manages delete forest cover
 **/
$(document).on("click","#content_schedab_dspecieexitimation .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la specie selezionata ?"+
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab_dspecieexitimation\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"codcover_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$("#notescontainer").prepend("<a id=\"notes_list_update\" style=\"display:none;\" href=\""+$("#formB1").attr("action")+"\" data-update=\"content_schedab_note\"></a>");
/**
 * Manages autocomplete note code
 **/
function autocompleteCodeNote () {
        $("#cod_nota_descr, #content_schedab_note input").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_nota&archivio=schedab",
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
$(document).on("change","#content_schedab_note textarea", function() {
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
$(document).on("click","#content_schedab_note .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la nota selezionata ?"+
                    " <a id=\"note_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab_note\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
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
formAjax("#formB1",".formb1_errors");
$("fieldset > div > input,fieldset > input,fieldset > div > select").change(function () {
   $("#formB1").trigger("submit");
});
$("fieldset > div > input").dblclick(function () {
    $(this).val("");
});
$("fieldset").dblclick(function () {
    $(this).find("input:checkbox,input:radio").removeAttr("checked");
});