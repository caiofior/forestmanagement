/* 
 * Cadastral data controls
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Manages cadastral table
 */
oTable = $("#cadastral").dataTable( {
        "oLanguage": {
            "sUrl": "js/DataTables/locale/it_IT.json"
        },
        "aoColumns": [
            { "bVisible": false, "sName": "objectid","sWidth": null},
            { "sName": "foglio", "sClass": "editable", "sWidth": "4%"},
            { "sName": "particella", "sClass": "editable", "sWidth": "4%" },
            { "sName": "sup_tot_cat", "sClass": "editable", "sWidth": "4%" },
            { "sName": "catasto.sup_tot", "sClass": "editable", "sWidth": "4%"},
            { "sName": "sup_bosc", "sClass": "editable", "sWidth": "4%" },
            { "sName": "non_boscata",  "sWidth": "4%" },
            { "sName": "sup_non_bosc", "sWidth": "4%" },
            { "sName": "porz_perc", "sClass": "editable", "sWidth": "4%"},
            { "sName": "note", "sClass": "editable", "sWidth": "8%"},
            { "sName": "cod_part", "sWidth": "4%"},
            { "sName": "scheda_a.sup_tot", "sClass": "editable", "sWidth": "4%"},
            { "sName": "calcolo", "sWidth": "4%"},
            { "sName": "i1", "sClass": "editable", "sWidth": "4%"},
            { "sName": "i2", "sClass": "editable", "sWidth": "4%"},
            { "sName": "i3", "sWidth": "4%"},
            { "sName": "i4", "sWidth": "4%"},
            { "sName": "i5", "sWidth": "4%"},
            { "sName": "i6", "sWidth": "4%"},
            { "sName": "i7", "sWidth": "4%"},
            { "sName": "i8", "sClass": "editable", "sWidth": "4%"},
            { "sName": "i21", "sClass": "editable", "sWidth": "4%"},
            { "sName": "i22", "sClass": "editable", "sWidth": "4%"},
            { "sName": "azioni", "sWidth": "8%"}

        ],
         "fnDrawCallback": function () {
            $('#cadastral tbody td.editable').editable( function (value) {
                id = oTable.fnGetData(oTable.fnGetPosition( this )[0])[0];
                field = oTable.fnSettings().aoColumns[oTable.fnGetPosition( this )[2]].sName;
                url = "daticat.php?action=cadastratableedit&elementid="+id+"&field="+field;
                $.ajax({
                    async:false,
                    url: url,
                    data:{
                        id: $("#cadastral").data("objectid"),
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
            $("#cadastral tbody td input[type=checkbox]").change(function(){
                value="f";
                if (typeof $(this).attr("checked") == "undefined")
                    value="";
                id = oTable.fnGetData(oTable.fnGetPosition( $(this).parent("td")[0] )[0])[0];
                field = oTable.fnSettings().aoColumns[oTable.fnGetPosition($(this).parent("td")[0] )[2]].sName;
                url = "daticat.php?action=cadastratableedit&elementid="+id+"&field="+field;
                 $.ajax({
                    async:false,
                    url: url,
                    data:{
                        id: $("#cadastral").data("objectid"),
                        value:value
                    }
                });
                oTable.fnDraw();
            })
            $(".code_part").autocomplete({
                minLength: 0,
                source: "daticat.php?action=autocomplete_code_part&id="+$("#cadastral").data("objectid"),
                change: function( event, ui ) {
                        if ( ui.item ) {
                            value="f";
                            if (typeof $(this).attr("checked") == "undefined")
                                value="";
                            id = oTable.fnGetData(oTable.fnGetPosition( $(this).parent("td")[0] )[0])[0];
                            field = oTable.fnSettings().aoColumns[oTable.fnGetPosition($(this).parent("td")[0] )[2]].sName;
                            url = "daticat.php?action=cadastratableedit&elementid="+id+"&field="+field;
                             $.ajax({
                                async:false,
                                url: url,
                                data:{
                                    id: $("#cadastral").data("objectid"),
                                    value:$(this).val()
                                }
                            });
                            oTable.fnDraw();
                        }
                }
            }).focus(function() {
                $(this).val("").autocomplete("search","")
            });
            add = $(".addcadastral");
            if (add.length > 0)
                $("#cadastral_length").append(" ").append(add.remove().show());
            
        },
        "bStateSave": true,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "daticat.php?action=cadastraltable&id="+$("#cadastral").data("objectid")
});
$(document).on("click",".addcadastral",function (e) {
    url = "daticat.php?action=cadastratableedit&elementid=new";
                $.ajax({
                    async:false,
                    url: url,
                    data:{
                        id: $("#cadastral").data("objectid")
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
$(document).on("click",".surfacerecalc",function() {
    $.colorbox({
        "html"  :   
                    "Vuoi aggiornare la superficie forestale ?"+
                    " <a id=\"surfacerecalc_confirm\"href=\""+$(this).attr("href")+"&confirmed=1\" ><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"cadastral_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#surfacerecalc_confirm",function(){
     $.ajax({
        async:false,
        url: $(this).attr("href")
    });
   oTable.fnDraw();
   $.colorbox.close();
   return false;
});
$(document).on("click",".vercalc",function() {
    $.colorbox({
        "href"  : $(this).attr("href") ,
        "width" : 600,
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("submit","#vercalcform",function() {
    $("#vercalcerror").text("").hide();
    if ($("#method").val() == "") {
        $("#vercalcerror").text("Scegli uno dei due metodi di elaborazione").show();
        return false;
    }
    $.ajax({
        async:false,
        url: $(this).attr("action"),
        data: $(this).serializeArray(),
        dataType: "json",
        success: function (response) {
            
            if($.makeArray(response).length >0 ) {
                html = "";
                $.each(response,function (key, part){
                    html += "<strong>Particella "+key+"</strong><br/>";
                    $.each(part,function(key,value){
                        html += "Particella "+value+"<br/>";
                    });
                }) 
                $("#vercalcerror").html(html).show();
            }
            else
                 $('#cboxClose').remove();
        }
    });
   oTable.fnDraw();
   return false;
})
