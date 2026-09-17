$(function(){

    $('#sidebarToggle').click(function(){

        $('#sidebar').toggleClass('collapsed');

        $('.dashboard-content').toggleClass('expanded');

    });

});

$('.has-sub > a').click(function(e){

    e.preventDefault();

    $(this).parent().toggleClass('open');

    $(this).next('.sub-menu').slideToggle(300);

});




$('#fullscreenBtn').click(function(){

if(!document.fullscreenElement){

document.documentElement.requestFullscreen();

}else{

document.exitFullscreen();

}

});


$('#darkMode').click(function(){

$('body').toggleClass('dark-mode');

});







/* ===========================
   SALES CHART
=========================== */

var salesOptions = {

series:[{

name:"Sales",

data:[35,48,40,65,55,70,88]

}],

chart:{

type:'area',

height:350,

toolbar:{show:false}

},

colors:['#FF8400'],

stroke:{

curve:'smooth',

width:4

},

fill:{

type:'gradient',

gradient:{

shadeIntensity:1,

opacityFrom:.45,

opacityTo:.05

}

},

dataLabels:{

enabled:false

},

grid:{

borderColor:'#eee'

},

xaxis:{

categories:[

'Mon',

'Tue',

'Wed',

'Thu',

'Fri',

'Sat',

'Sun'

]

}

};

new ApexCharts(

document.querySelector("#salesChart"),

salesOptions

).render();



/* ===========================
   ORDER STATUS
=========================== */

var orderOptions={

series:[45,28,18,9],

chart:{

type:'donut',

height:350

},

labels:[

'Completed',

'Pending',

'Shipping',

'Cancelled'

],

colors:[

'#FF8400',

'#10B981',

'#3B82F6',

'#EF4444'

],

legend:{

position:'bottom'

}

};

new ApexCharts(

document.querySelector("#orderChart"),

orderOptions

).render();
















if(document.getElementById("deliveryMap")){

var map=L.map('deliveryMap').setView([22.3569,91.7832],13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{

maxZoom:19,

attribution:'© OpenStreetMap'

}).addTo(map);

L.marker([22.3569,91.7832])

.addTo(map)

.bindPopup("Delivery Boy Location")

.openPopup();

}






// Rider Marker

var riderIcon=L.icon({

iconUrl:'https://cdn-icons-png.flaticon.com/512/684/684908.png',

iconSize:[40,40]

});

var rider=L.marker(

[22.3569,91.7832],

{

icon:riderIcon

}

).addTo(map)

.bindPopup("Delivery Boy");


// Customer Marker

var customer=L.marker(

[22.3680,91.8000]

).addTo(map)

.bindPopup("Customer");


// Route Line

var route=L.polyline(

[

[22.3569,91.7832],

[22.3680,91.8000]

],

{

color:'#FF8400',

weight:5

}

).addTo(map);

map.fitBounds(route.getBounds());


// ===========================================
setInterval(function(){

let eta=Math.floor(Math.random()*6)+8;

let distance=(Math.random()*2+1).toFixed(1);

let speed=Math.floor(Math.random()*15)+25;

$("#etaText").text(eta+" Min");

$("#distanceText").text(distance+" KM");

$("#speedText").text(speed+" km/h");

},5000);










var riderLat=22.3569;

var riderLng=91.7832;

var riderMarker=L.marker(

[riderLat,riderLng],

{

icon:riderIcon

}

).addTo(map);

setInterval(function(){

riderLat+=0.00025;

riderLng+=0.00018;

riderMarker.setLatLng([

riderLat,

riderLng

]);

},3000);









var statusList=[

"Order Confirmed",

"Picked Up",

"On The Way",

"Near Customer",

"Delivered"

];

var i=2;

setInterval(function(){

if(i<statusList.length){

$("#deliveryStatus").text(

statusList[i]

);

i++;

}

},10000);







$(".otp-input").on("keyup",function(){

if($(this).val()=="1234"){

alert("OTP Verified Successfully");

}

});












