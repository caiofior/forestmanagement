/**
 * tavole functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Forest List management
 */
$("#tavole_list").prepend("<a id=\"tavole_list_update\" style=\"display:none;\" data-basehref=\""+$("#tavole_list").attr("action")+"\" data-update=\"content_tavole_list\"></a>");
$("#search").keyup(function(){
   el = $("#tavole_list_update"); 
   search = $("#search");
   tipo = $("#tipo");
   el.attr("href",el.data("basehref")+"&tipo="+tipo.val()+"&search="+search.val());
   el.trigger("click");
});
$("#tipo").change(function() {
    $("#search").trigger("keyup");
});
/**
 * Manages data table
 */
oTable = $("#table2").dataTable( {
        "oLanguage": {
            "sUrl": "js/DataTables/locale/it_IT.json"
        },
        "aoColumns": [
            { "bVisible": false, "sName": "objectid","sWidth": null},
            { "sName": "tariffa", "sClass": "editable", "sWidth": "20%"},
            { "sName": "d", "sClass": "editable", "sWidth": "20%" },
            { "sName": "h", "sClass": "editable", "sWidth": "20%" },
            { "sName": "v", "sClass": "editable", "sWidth": "20%"},
            { "sName": "azioni", "sWidth": "10%"}

        ],
         "fnDrawCallback": function () {
            
            
        },
        "bStateSave": true,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "tavole.php?action=table2data&codice="+$("#table2").data("codice")
});
$(document).on("click",".addrow",function (e) {
    url = "tavole.php?action=tableedit&elementid=new";
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
$(document).on("click","#tav .actions.delete",function() {
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellaolare la riga selezionata ?"+
                    " <a id=\"row_delete_confirm\"href=\""+el.attr("href")+"\" ><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"row_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#row_delete_confirm",function(){
     $.ajax({
        async:false,
        url: $(this).attr("href")
    });
   oTable.fnDraw();
   $.colorbox.close();
   return false;
});
$(document).on("click","#row_delete_cancel",function(){
   $.colorbox.close();
   return false;
});