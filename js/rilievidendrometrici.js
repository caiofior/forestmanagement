/**
 * Relives functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
$("#selector").prepend("<a id=\"formx_update\" style=\"display:none;\" data-basehref=\""+$("#formX").attr("action")+"\" data-update=\"content_rilievidendrometrici_edit\"></a>");
$("#formX #tipo_ril").change(function() {
    $("#formx_update").attr("href",$("#formX").attr("action")+"&tipo_ril="+$(this).val()).trigger("click");
    return false;
});
