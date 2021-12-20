/**
 * User functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * User table 
 */
$("#user").dataTable( {
        "oLanguage": {
            "sUrl": "js/DataTables/locale/it_IT.json"
        },
        "aoColumns": [
            { "bVisible": false, "sName": "id"},
            { "sName": "username", "sWidth": "20%"},
            { "sName": "first_name", "sWidth": "10%" },
            { "sName": "phone", "sWidth": "10%" },
            { "sName": "address_city", "sWidth": "10%"},
            { "sName": "organization", "sWidth": "10%" },
            { "sName": "creation_datetime", "sWidth": "10%" },
            { "sName": "actions", "sWidth": "30%"}

        ],
        "bStateSave": true,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user.php"
});
$(document).on("click","#user .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare l'utente selezionato ?"+
                    " <a id=\"user_delete_confirm\"href=\""+el.attr("href")+"\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\"/> </a>"+
                    " <a id=\"user_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#user .edit",function(){
    el = $(this).parent("a");
    $.ajax({
         type: "POST",
         url: el.attr("href"),
         data: {"xhr":1},
         dataType: "json",
         success: function(response) {
             if (response == true) {
                 $("#user").dataTable().fnReloadAjax();
             }
         }
     });
   return false;
});
$(document).on("click","#user_delete_confirm",function(){
   el = $(this); 
   $.ajax({
            type: "POST",
            url: el.attr("href"),
            data: {"confirm":1,"xhr":1},
            dataType: "json",
            success: function(response) {
                if (response == true) {
                    $("#user").dataTable().fnReloadAjax();
                }
            }
   });
   $.colorbox.close();
   return false;
});
$(document).on("click","#user_delete_cancel",function(){
   $.colorbox.close();
   return false;
});
/**
 * Forest list management
 */
$("#forest_list").prepend("<a id=\"forest_list_update\" style=\"display:none;\" data-basehref=\""+$("#forest_list").attr("action")+"\" data-update=\"content_userManageForestlist\">Test</a>");
$("#descrizion").keyup(function(){
   el = $("#forest_list_update"); 
   search = $("#descrizion");
   regione = $("#regione");
   filter = $("#filter_owned");
   el.attr("href",el.data("basehref")+"&regione="+regione.val()+"&search="+search.val()+"&filter="+filter.attr("checked"));
   el.trigger("click");
});
$("#filter_owned").change(function() {
   $("#descrizion").trigger("keyup");
});
$("#regione").change(function() {
    $("#descrizion").val("");
    el = $("#forest_list_update"); 
    regione = $("#regione");
    filter = $("#filter_owned");
    el.attr("href",el.data("basehref")+"&regione="+regione.val()+"&filter="+filter.attr("checked"));
    el.trigger("click");
});
$("#current").on("focus",$("#current"),function() {
    $("#confirm_move, #cancel_move").show();
    return false;
});
$("#cancel_move").on("click",$("#cancel_move"),function(e) {
    $("#confirm_move, #cancel_move").hide();
   return false;
});
$("#confirm_move").on("click",$("#confirm_move"),function(e) {
   el = $("#forest_list_update"); 
   search = $("#descrizion");
   regione = $("#regione");
   filter = $("#filter_owned");
   current = $("#current");
   el.attr("href",el.data("basehref")+"&regione="+regione.val()+"&search="+search.val()+"&filter="+filter.attr("checked")+"&start="+current.val());
   el.trigger("click");
   return false;
  
});
