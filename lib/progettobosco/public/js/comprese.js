/**
 * Comprese functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
$("#compresa").prepend("<a id=\"content_comprese_list_update\" style=\"display:none;\" data-basehref=\""+$("#comprese_list").attr("action")+"\" data-update=\"content_comprese_list\"></a>");
$(document).on("change",".parameter, #search, .operator, .value,  #compresa", function () {
    trigger = $(this);
    parameters_url = $("#comprese_list").serialize();
    $("#todo").val("");
    el = $("#content_comprese_list_update");
    el.attr(
            "href",el.data("basehref")+"&"+parameters_url
    );
    el.click(); 
    
    
});
$("#search").keyup(function (){
    $("#search").change();
});
$("#add_filter").click(function() {
    $("#ajaxloader").show();
    el = $(this);
    data = $.extend({"action":"xhr_update"}, {"sequence":$("#sequence").val()},{"id":$("#id").val()},["content_comprese_filter"]);
    $.ajax({
        type: "GET",
        url: el.attr("href"),
        data: data,
        success: function(response) {
            $("#ajaxloader").hide();
            $.each(response, function(key,value) {
              if (typeof el.data("destination") != "undefined" && el.data("destination") != "")
                key=el.data("destination");
              $("#"+key).append(value);  
              $("#sequence").val($("#sequence").val()+1);
            });
        },
        error: function(jqXHR , textStatus,  errorThrown) {
            if (typeof DEBUG != 'undefined') {
                console.log(textStatus,errorThrown,$(jqXHR.responseText).text());
            }
            $("#ajaxloader").hide();
          },
        dataType: "json"
    });
   return false; 
});
$(document).on("click",".remove_filter",function () {
   $(this).parent("fieldset").remove();
   $("#search").change();
   return false; 
});
$(document).on("click","#add_all",function () {
    $("#todo").val("add_all");
    $("#search").change();
   return false; 
});
$(document).on("click","#remove_all",function () {
    $("#todo").val("remove_all");
    $("#search").change();
   return false; 
});
function draggable () {
    $(".working_circle_selected").hide();
    $(".working_circle_not_selected").show();
    if ($("#compresa").val() != "" ) {
        $(".working_circle_selected").show();
        $(".working_circle_not_selected").hide();
        $("#content_comprese_listall ul li").draggable({ 
            containment: "#main",
            revert: true
        });
        $("#content_comprese_listselected p").droppable({drop:function(event, ui) {
            el = $("#content_comprese_list_update");
            el.attr("href",el.data("basehref")+"&compresa="+$("#compresa").val()+"&add="+ui.draggable.attr("id"));
            el.click();
        }});
        $("#content_comprese_listselected ul li").draggable({ 
            containment: "#main",
            revert: true

        });
         $("#content_comprese_listall p").droppable({drop:function(event, ui) {
            el = $("#content_comprese_list_update");
            el.attr("href",el.data("basehref")+"&compresa="+$("#compresa").val()+"&remove="+ui.draggable.attr("id"));
            el.click();

        }});
    }
}
draggable ();
$(document).ajaxComplete(function() {
    draggable ();
});

