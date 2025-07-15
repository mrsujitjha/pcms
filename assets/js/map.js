
    var map = L.map('osmMap', { zoomControl:false }).setView([26.869166,75.810326], 8);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var marker = L.marker([26.869166,75.810326]).addTo(map);
    marker.bindPopup("RSHA");
    var popup = L.popup();
    var mpoly = L.Polyline;

    function draw_polyline(latlngs,rname,lcolor){  

    var polyline = L.polyline(latlngs, {color: lcolor}).addTo(map);
   
    polyline.bindPopup(rname);
    map.fitBounds(polyline.getBounds());

    }
    function place_structure(locations,details){  
    
        for (var i = 0; i < locations.length; i++) { 
            var msg=details[i].toString().split(":");
            var nmsg= chainage(msg[0]) + ":" + msg[1]+"(" +msg[2]+")";
            var micon =true;
            if (msg[1].includes("Culvert")){ const mrk = new L.marker(locations[i], {icon: cicon}).bindPopup(nmsg.toString()).addTo(map);micon=false; }
            if (msg[1].includes("Junction")){ const mrk = new L.marker(locations[i], {icon: jicon}).bindPopup(nmsg.toString()).addTo(map);micon=false; }
            if(micon){ const mrk = new L.marker(locations[i], {icon: gicon}).bindPopup(nmsg.toString()).addTo(map); }
        
        }
    }
    function place_images(locations,rem,pname){    
        for (var i = 0; i < locations.length; i++) {  
            var mpath=picpath+pname[i].toString();
            var photoImg = '<img src='+mpath+' height="150px" width="150px"/>' + "<br> <a href='" +mpath+ "'>"+rem[i] +"</a>";
            const mrk = new L.marker(locations[i], {icon: picon}).bindPopup(photoImg).addTo(map);
            }
        }
            
    var picon = L.icon({
        iconUrl:picture,
        iconSize:     [15, 15]
    });
    var cicon = L.icon({
        iconUrl:culvert,
        iconSize:     [15, 15]
    });
    var jicon = L.icon({
        iconUrl:junction,
        iconSize:     [10, 10]
    });
    var gicon = L.icon({
        iconUrl:general,
        iconSize:     [15, 15]
    });
    function chainage(ch){
    var a;
    var b;
    var c;
    a= Math.floor(ch);
    b=Math.round((ch-a)*1000);
    c=a+'+'+b;
    return c;
    }
    L.Control.Button= L.Control.extend({
        options: { position: 'topleft' },
        onAdd: function (map) {
            var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
            var button = L.DomUtil.create('img', 'leaflet-buttons-control-img', container);            
            L.DomEvent.disableClickPropagation(button);
            L.DomEvent.on(button, 'click', function(){window.location.href = fullmap;});
           // button.text="X";  
           button.setAttribute('src',zicon);
            container.title = "Zoom";
            return container;
        },
        onRemove: function(map) {},
    });   
     function get_distance(lat1,lat2,lon1,lon2)
     {
        
        const R = 6371e3; // metres
        const φ1 = lat1 * Math.PI/180; // φ, λ in radians
        const φ2 = lat2 * Math.PI/180;
        const Δφ = (lat2-lat1) * Math.PI/180;
        const Δλ = (lon2-lon1) * Math.PI/180;
        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        const d = R * c; 
        //alert(d);
        return d;
    }
    
    var control = new L.Control.Button().addTo(map);