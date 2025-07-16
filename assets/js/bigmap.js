
var map = L.map('osmMapbig').setView([26.869166,75.810326], 8);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var popup = L.popup();
var mpoly = L.Polyline;

function draw_polylineall(latlngs,rname,lcolor){
    var polyline = L.polyline(latlngs, {color: lcolor}).addTo(map);
    polyline.bindPopup(rname);
    map.fitBounds(polyline.getBounds());
}
function place_structureall(locations,details){  
   
    for (var i = 0; i < locations.length; i++) { 
        var msg=details[i].toString().split(":");
        var nmsg= chainage(msg[0]) + ":" + msg[1]+"(" +msg[2]+")";
        var micon =true;
        if (msg[1].includes("Culvert")){ const mrk = new L.marker(locations[i], {icon: cicon}).bindPopup(nmsg.toString()).addTo(map);micon=false; }
        if (msg[1].includes("Junction")){ const mrk = new L.marker(locations[i], {icon: jicon}).bindPopup(nmsg.toString()).addTo(map);micon=false; }
        if(micon){ const mrk = new L.marker(locations[i], {icon: gicon}).bindPopup(nmsg.toString()).addTo(map); }
 
       
    }
}
function place_imagesall(locations,rem,pname){    
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
function onMapClick(e) {
    var l=e.latlng.toString();
       popup
        .setLatLng(e.latlng)
        .setContent("Chainage:" + Getdistance(l))
        .openOn(map);
}

function chainage(ch){
var d=(Math.round(ch*1000)/1000).toString();
var c=d.replace(".","+");
return c;
}
function get_distance_all(lat1,lat2,lon1,lon2)
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
function Getdistance(mcor) {
    var latlng=	mcor.split(","); 
    var lat=latlng[0].replace("LatLng(","");
    var lng=latlng[1].replace(")","");
    var lnth1=0;
    var lnth2=0;
    var mlength=0;
    var mlatlong='';
    var lat1=0;
    var lat2=0;
    var lng1=0;
    var lng2=0;
    var z= localStorage.getItem("loadedkml");
    var y=z.split('::');		
        for (var j=0;j<y.length;j++) {  
        var x = y[j].split(' ');
        var p=x[0].split(','); 
        lat1=p[1];lng1=p[0];
            for (var i=1;i<x.length-1;i++) {           
                 p=x[i].split(','); 
                 lat2=p[1];lng2=p[0];
                 lnth1=mlength+get_distance_all(lat1,lat,lng1,lng);
                 lnth2=mlength+get_distance_all(lat2,lat,lng2,lng);
                 mlength =mlength+get_distance_all(lat1,lat2,lng1,lng2);                
                 lat1=lat2;
                 lng1=lng2;
             if(lnth1<lnth2){break;}
            }   
        }
     var mych= chainage(lnth1/1000);  
        return mych;
}
map.on('click', onMapClick);
 