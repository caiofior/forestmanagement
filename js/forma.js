/**
 * Form a controls
 */
$("#datasch").datepicker({dateFormat:"yy-mm-dd"});
/**
 * Manages comune description
 **/
$("#comune_descriz").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=municipality&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#comune").val(ui.item.id )
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#comune_descriz").val($("#comune_descriz").data("old-descriz"));
            }
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
});
/**
* Manages operator description
*/
$("#codiope_descriz").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=collector",
    select: function( event, ui ) {
        $("#codiope").val(ui.item.id )
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
});
$(document).on("change","#sup",function(){
   el = $(this);
   if (el.val()> 0)
       $("input[name=delimitata]").removeAttr("disabled");
   else
       $("input[name=delimitata]").attr("disabled","disabled");
});
$("#sup").trigger("change");
$("#notescontainer").prepend("<a id=\"notes_list_update\" style=\"display:none;\" href=\""+$("#formA").attr("action")+"\" data-update=\"content_schedaa_note\"></a>");
/**
 * Manages autocomplete note code
 **/
function autocompleteCodeNote () {
        $("#cod_nota_descr, #content_schedaa_note input").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_nota&archivio=schedaa",
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
$(document).on("change","#content_schedaa_note textarea", function() {
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
$(document).on("click","#content_schedaa_note .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la nota selezionata ?"+
                    " <a id=\"note_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedaa_note\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
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
/**
 * Manages cadastral table
 */
oTable = $("#cadastral").dataTable( {
        "oLanguage": {
            "sUrl": "js/DataTables/locale/it_IT.json"
        },
        "aoColumns": [
            { "bVisible": false, "sName": "objectid","sWidth": null},
            { "sName": "foglio", "sClass": "editable", "sWidth": "10%"},
            { "sName": "particella", "sClass": "editable", "sWidth": "10%" },
            { "sName": "sup_tot_cat", "sClass": "editable", "sWidth": "10%" },
            { "sName": "sup_tot", "sClass": "editable", "sWidth": "10%"},
            { "sName": "sup_bosc", "sClass": "editable", "sWidth": "10%" },
            { "sName": "sum_sup_non_bosc", "sClass": "editable", "sWidth": "10%" },
            { "sName": "porz_perc", "sClass": "editable", "sWidth": "10%" },
            { "sName": "note", "sClass": "editable", "sWidth": "10%"},
            { "sName": "actions", "sWidth": "20%"}

        ],
         "fnDrawCallback": function () {
            $('#cadastral tbody td.editable').editable( function (value) {
                id = oTable.fnGetData(oTable.fnGetPosition( this )[0])[0];
                field = oTable.fnSettings().aoColumns[oTable.fnGetPosition( this )[2]].sName;
                url = "bosco.php?task=forma&action=cadastratableedit&elementid="+id+"&field="+field;
                $.ajax({
                    async:false,
                    url: url,
                    data:{
                        id: $("#objectid").val(),
                        value:value
                    }
                });
                
                
                }, {
                indicator : "Salvataggio",
                placeholder   : "Clicca",
                callback: function(  ) {
                    
                    oTable.fnDraw();
                },
                "height": "8px"
            } );
            /**surf = $(".surfacerecalc");
            if (surf.length > 0)
                $("#cadastral_length").append(" ").append(surf.remove().show());**/
            $.get(
                "bosco.php?task=forma&action=cadastratablesummary"
                , {
                    id: $("#objectid").val()
                }, function (data) {
                    $.each(data, function (id,val){
                       $("#"+id).text(val); 
                    });
                },
                "json"
                
            );
            
        },
        "bStateSave": true,
        "bServerSide": true,
        "sAjaxSource": "bosco.php?task=forma&action=cadastraltable&id="+$("#objectid").val()
});
$(document).on("click",".addcadastral",function (e) {
    url = "bosco.php?task=forma&action=cadastratableedit&elementid=new";
                $.ajax({
                    async:false,
                    url: url,
                    data:{
                        id: $("#objectid").val()
                    }
                });
    oTable.fnDraw();
    return false;
});
$(document).on("click","#cadastral .actions.delete",function() {
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la particella catastale selezionata ?"+
                    " <a id=\"cadastral_delete_confirm\"href=\""+el.attr("href")+"\" ><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"cadastral_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#cadastral_delete_confirm",function(){
     $.ajax({
        async:false,
        url: $(this).attr("href")
    });
   oTable.fnDraw();
   $.colorbox.close();
   return false;
});
$(document).on("click","#cadastral_delete_cancel",function(){
   $.colorbox.close();
   return false;
});
$(document).on("click",".surfacerecalc",function (e) {
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi ricalcolare la superficie della particella catastale selezionata ?"+
                    " <a id=\"cadastral_recalc_confirm\"href=\""+el.attr("href")+"\" ><img src=\"images/empty.png\" title=\"Conferma ricalcolo\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"cadastral_recalc_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla ricalcolo\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });

    return false;
});
$(document).on("click","#cadastral_recalc_confirm",function(){
            $.ajax({
                async:false,
                url: "bosco.php?task=forma&action=updatesurface",
                data: {
                    id: $("#objectid").val()
                },
                success : function (data) {
                    $("#sup_tot").val(data);
                    $("#sup_tot1").val(data);
                }
            });
   $.colorbox.close();
   return false;
});
$(document).on("click","#cadastral_recalc_cancel",function(){
   $.colorbox.close();
   return false;
});
formAjax("#formA",".forma_errors");
$("fieldset > div > input,fieldset > input,fieldset > div > div > span > input").change(function () {
   $("#formA").trigger("submit");
});
$("fieldset > div > input").dblclick(function () {
    $(this).val("");
});
$("fieldset").dblclick(function () {
    $(this).find("input:checkbox,input:radio").removeAttr("checked");
});