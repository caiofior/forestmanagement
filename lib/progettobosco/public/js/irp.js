/**
 * IRP
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Manages IRP table
 */
oTable = $("#irp").dataTable( {
        "oLanguage": {
            "sUrl": "js/DataTables/locale/it_IT.json"
        },
        "aoColumns": [
            { "bVisible": false, "sName": "objectid","sWidth": null},
            { "sName": "n_ads", "sClass": "editable", "sWidth": "10%"},
            { "sName": "n_alb_cont", "sClass": "editable", "sWidth": "10%" },
            { "sName": "h1", "sClass": "editable", "sWidth": "5%" },
            { "sName": "h2", "sClass": "editable", "sWidth": "5%"},
            { "sName": "h3", "sClass": "editable", "sWidth": "5%" },
            { "sName": "h4", "sClass": "editable", "sWidth": "5%" },
            { "sName": "h5", "sClass": "editable","sWidth": "5%" },
            { "sName": "d1", "sClass": "editable", "sWidth": "5%"},
            { "sName": "d2", "sClass": "editable", "sWidth": "5%"},
            { "sName": "d3", "sClass": "editable", "sWidth": "5%"},
            { "sName": "d4", "sClass": "editable", "sWidth": "5%"},
            { "sName": "d5", "sClass": "editable", "sWidth": "5%"},
            { "sName": "d6", "sClass": "editable", "sWidth": "5%"},
            { "sName": "d7", "sClass": "editable", "sWidth": "5%"},
            { "sName": "azioni", "sWidth": "10%"}

        ],
         "fnDrawCallback": function () {
            $('#irp tbody td.editable').editable( function (value) {
                id = oTable.fnGetData(oTable.fnGetPosition( this )[0])[0];
                field = oTable.fnSettings().aoColumns[oTable.fnGetPosition( this )[2]].sName;
                url = "bosco.php?task=irp&action=tableedit&elementid="+id+"&field="+field;
                $.ajax({
                    async:false,
                    url: url,
                    data:{
                        id: $("#irp").data("objectid"),
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
                      
            add = $(".addcadastral");
            if (add.length > 0)
                $("#cadastral_length").append(" ").append(add.remove().show());
            
        },
        "bStateSave": true,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "bosco.php?task=irp&action=tabledata&id="+$("#irp").data("objectid")
});
$(document).on("click",".addirp",function (e) {
    url = "bosco.php?task=irp&action=tableedit&elementid=new";
                $.ajax({
                    async:false,
                    url: url,
                    data:{
                        id: $("#irp").data("objectid")
                    }
                });
    oTable.fnDraw();
    return false;
});
$(document).on("click","#irp .actions.delete",function() {
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la il rilievo selezionato ?"+
                    " <a id=\"irp_delete_confirm\"href=\""+el.attr("href")+"\" ><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"irp_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#irp_delete_confirm",function(){
     $.ajax({
        async:false,
        url: $(this).attr("href")
    });
   oTable.fnDraw();
   $.colorbox.close();
   return false;
});
$(document).on("click","#irp_delete_cancel",function(){
   $.colorbox.close();
   return false;
});