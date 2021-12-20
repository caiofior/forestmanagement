/**
 * User functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Forest Compartment list management
 */
$("#forestcompartment_list").prepend("<a id=\"forestcompartment_list_update\" style=\"display:none;\" data-basehref=\""+$("#forestcompartment_list").attr("action")+"\" data-update=\"content_bosco_forestcompartmentlist\"></a>");
$("#search").keyup(function(){
   el = $("#forestcompartment_list_update"); 
   search = $("#search");
   usosuolo = $("#usosuolo");
   codiope = $("#codiope");
   el.attr("href",el.data("basehref")+"&usosuolo="+usosuolo.val()+"&codiope="+codiope.val()+"&search="+search.val());
   el.trigger("click");
});
$("#usosuolo, #codiope").change(function() {
   $("#search").val("").trigger("keyup");
});
$(document).on("click","#content_bosco_forestcompartmentlist .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la particella selezionata ?"+
                    " <a id=\"bosco_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_bosco_forestcompartmentlist\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"bosco_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#content_bosco_forestcompartmentlist .addnew",function(){
    el = $(this).parent("a");
    $.colorbox({
        "href"  :   el.attr("href"),
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$("#formtab a").click(function(){
    $("#formtab > span").removeClass("active");
    $(this).parent("span").addClass("active");
});
$().ready(function () {
    $("input:not([type='radio']):not(.float_width)").css({
        width: "80%",
        margin: "0px",
        padding: "0px"
    });
    $(".scrollcontrols input:not([type='radio'])").css({
        width: "20%"
    });
    
})
