/**
 * Forest compartment description functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
$("#recreate_description").click(function () {
    $.ajax({
        type: "GET",
        url: $("#formDescrizione").attr("action"),
        data: {'action':'generate'},
        success: function(response) {
            $("#descrizione").val(response);
        }
    });
    return false;
});