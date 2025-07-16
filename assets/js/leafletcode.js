var map = L.map('osmMap').setView([26.869166,75.810326], 8);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
var marker = L.marker([26.869166,75.810326]).addTo(map);
marker.bindPopup("<b>Hello!</b><br>This Is RSHA.").openPopup();//.openpopup auto start popup
var popup = L.popup()
    .setLatLng([26.869166,75.810326])
    .setContent("I am a standalone popup.")
    .openOn(map);

  function onMapClick(e) {
      alert("You clicked the map at " + e.latlng);
  }
var popup = L.popup();
function onMapClick2(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString())
        .openOn(map);
}

function draw_polyline(latlngs){ 
    for (var i = 0; i <latlngs.length; i++) {
      var marker = L.marker(latlngs[i]).addTo(map);
    }
    
  var polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
  map.fitBounds(polyline.getBounds());
  
  
  }
map.on('click', onMapClick);
map.on('click', onMapClick2);

///put watermark icon on map

L.Control.Watermark = L.Control.extend({
  onAdd: function(map) {
      var img = L.DomUtil.create('img');
      img.src = picture;
      img.style.width = '20px';        
      return img;
  },
  onRemove: function(map) {
      // Nothing to do here
  }
});
L.control.watermark = function(opts) {
  return new L.Control.Watermark(opts);
}
L.control.watermark({ position: 'topright' }).addTo(map);