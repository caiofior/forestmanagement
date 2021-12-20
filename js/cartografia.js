/**
 * Comprese functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
function initialize() {
mapOptions = {
    zoom: 8,
    mapTypeId: google.maps.MapTypeId.SATELLITE
};
if (typeof center != "undefined")
mapOptions = {
    zoom: 8,
    center: new google.maps.LatLng(center["lat"], center["long"]),
    mapTypeId: google.maps.MapTypeId.SATELLITE
};
map = new google.maps.Map($("#map-canvas")[0],mapOptions);
if (typeof center != "undefined") {
    georssLayer = new google.maps.KmlLayer(center["id_av"]);
    georssLayer.setMap(map);
}
}

function loadScript() {
    if($("#googlemapscript").length == 0) {
        $("<script/>", {
        type : "text/javascript",
        src: "https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize",
        id: "googlemapscript"
        }).appendTo("body");
    }
}

loadScript();

