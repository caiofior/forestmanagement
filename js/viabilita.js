/**
 * Viabilita functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Viabilità management
 */
$("#viabilita_list").prepend("<a id=\"viabilita_list_update\" style=\"display:none;\" data-basehref=\""+$("#viabilita_list").attr("action")+"\" data-update=\"content_viabilita_list\"></a>");
$("#search").keyup(function(){
   el = $("#viabilita_list_update"); 
   search = $("#search");
   el.attr("href",el.data("basehref")+"&search="+search.val());
   el.trigger("click");
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
/**
 * Manages autocomplete codinter cod coltu
 **/
function autocompleteCodInter () {
        $("#cod_inter_descr, #content_viabilita_e1 input.cod_inter").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_inter",
        select: function( event, ui ) {
            $("#cod_inter").val(ui.item.id );
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("cod_inter_descr").val("");
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
autocompleteCodInter ();
$(document).ajaxComplete(function() {
    autocompleteCodInter ();
});