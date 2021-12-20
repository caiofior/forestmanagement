/**
 * Relives functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Data field
 */
$("#data").datepicker({dateFormat:"yy-mm-dd"});
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
