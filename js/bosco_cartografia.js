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

$(document).ready(function() {
        if ($('#map-canvas').length > 0) {

         mapboxgl.accessToken = 'pk.eyJ1IjoiZmxvcmFlaXQiLCJhIjoiY2pqOXJyOHF2MzlsODNwbzY5cDFldGIwcyJ9.ccN5GSNm1e58Y7CL3CjavQ';
         var map = new mapboxgl.Map({
            container: 'map-canvas',
            style: 'mapbox://styles/mapbox/outdoors-v9',
            center: [center["long"], center["lat"]],
            zoom: 8
         });
    }
});

