
/*
 * Route polylines
 */
var campusPolyline;
var extendedPolyline;
var nathanBiskPolyline;
var downtownPolyline;

function setCampusRoute() {
    var campusCoordinates = [
        new google.maps.LatLng(28.06356, -80.62114),
        new google.maps.LatLng(28.063841, -80.621132),
        new google.maps.LatLng(28.063841, -80.619934),
        new google.maps.LatLng(28.06406, -80.619926),
        new google.maps.LatLng(28.064098, -80.621033),
        new google.maps.LatLng(28.064087, -80.621315),
        new google.maps.LatLng(28.064098, -80.622566),
        new google.maps.LatLng(28.06424, -80.622574),
        new google.maps.LatLng(28.064224, -80.623215),
        new google.maps.LatLng(28.064137, -80.624138),
        new google.maps.LatLng(28.064005, -80.624146),
        new google.maps.LatLng(28.063978, -80.624908),
        new google.maps.LatLng(28.064735, -80.624947),
        new google.maps.LatLng(28.065689, -80.624901),
        new google.maps.LatLng(28.065834, -80.624901),
        new google.maps.LatLng(28.067291, -80.624908),
        new google.maps.LatLng(28.067347, -80.624741),
        new google.maps.LatLng(28.067453, -80.624641),
        new google.maps.LatLng(28.067616, -80.624626),
        new google.maps.LatLng(28.06782, -80.624657),
        new google.maps.LatLng(28.067875, -80.624702),
        new google.maps.LatLng(28.067966, -80.6249), // Outside Res Quad Loop


        new google.maps.LatLng(28.065828, -80.624924),
        new google.maps.LatLng(28.064734, -80.624977),
        new google.maps.LatLng(28.063869, -80.624931),
        new google.maps.LatLng(28.063889, -80.624222),
        new google.maps.LatLng(28.063946, -80.623512),
        new google.maps.LatLng(28.062449, -80.62355),
        new google.maps.LatLng(28.062378, -80.623505),
        new google.maps.LatLng(28.062037, -80.62352),
        new google.maps.LatLng(28.06204, -80.623032),
        new google.maps.LatLng(28.062929, -80.623032),
        new google.maps.LatLng(28.063999, -80.622978),
        new google.maps.LatLng(28.063974, -80.621323),
        new google.maps.LatLng(28.063955, -80.62114),
        new google.maps.LatLng(28.063944, -80.619949),
        new google.maps.LatLng(28.063086, -80.619949),
        new google.maps.LatLng(28.06307, -80.620331),
        new google.maps.LatLng(28.062929, -80.620522),
        new google.maps.LatLng(28.06287, -80.621147),
        new google.maps.LatLng(28.063551, -80.62114),
    ];

    campusPolyline = new google.maps.Polyline({
        path: campusCoordinates,
        strokeColor: "#660000",
        strokeOpacity: 0.6,
        strokeWeight: 9
    });
    campusPolyline.setMap(null);
}

function setExtendedRoute() {

    var extendedCoordinates = [
        new google.maps.LatLng(28.06356, -80.62114),
        new google.maps.LatLng(28.063841, -80.621132),
        new google.maps.LatLng(28.063841, -80.619934),
        new google.maps.LatLng(28.06406, -80.619926),
        new google.maps.LatLng(28.066475, -80.619873),
        new google.maps.LatLng(28.066484, -80.620399),
        new google.maps.LatLng(28.066494, -80.620728),
        new google.maps.LatLng(28.066343, -80.62075),
        new google.maps.LatLng(28.066196, -80.62075),
        new google.maps.LatLng(28.066196, -80.619919),
        new google.maps.LatLng(28.064091, -80.619965),
        new google.maps.LatLng(28.06406, -80.619926),
        new google.maps.LatLng(28.06406, -80.619926),
        new google.maps.LatLng(28.064098, -80.621033),
        new google.maps.LatLng(28.064087, -80.621315),
        new google.maps.LatLng(28.064098, -80.622566),
        new google.maps.LatLng(28.06424, -80.622574),
        new google.maps.LatLng(28.064224, -80.623215),
        new google.maps.LatLng(28.064137, -80.624138),
        new google.maps.LatLng(28.064005, -80.624146),
        new google.maps.LatLng(28.063978, -80.624908),
        new google.maps.LatLng(28.064735, -80.624947),
        new google.maps.LatLng(28.065689, -80.624901),
        ////


        new google.maps.LatLng(28.065834, -80.624901),
        new google.maps.LatLng(28.067291, -80.624908),
        new google.maps.LatLng(28.067347, -80.624741),
        new google.maps.LatLng(28.067453, -80.624641),
        new google.maps.LatLng(28.067616, -80.624626),
        new google.maps.LatLng(28.06782, -80.624657),
        new google.maps.LatLng(28.067875, -80.624702),
        new google.maps.LatLng(28.067966, -80.62492), // Outside Res Quad Loop


        new google.maps.LatLng(28.065828, -80.624924),
        new google.maps.LatLng(28.064734, -80.624977),
        new google.maps.LatLng(28.063869, -80.624931),
        new google.maps.LatLng(28.063889, -80.624222),
        new google.maps.LatLng(28.063946, -80.623512),
        new google.maps.LatLng(28.062449, -80.62355),
        new google.maps.LatLng(28.062378, -80.623505),
        new google.maps.LatLng(28.062037, -80.62352),
        /*---Harris Loop ----*/
        new google.maps.LatLng(28.061737, -80.62352),
        new google.maps.LatLng(28.061563, -80.62355),
        new google.maps.LatLng(28.061453, -80.623795),
        new google.maps.LatLng(28.061478, -80.62487),
        new google.maps.LatLng(28.061413, -80.624954),
        new google.maps.LatLng(28.061275, -80.624992),
        new google.maps.LatLng(28.061029, -80.625008),
        new google.maps.LatLng(28.06094, -80.62381),
        new google.maps.LatLng(28.060602, -80.62381),
        new google.maps.LatLng(28.06045, -80.623749),
        new google.maps.LatLng(28.060455, -80.622452),
        new google.maps.LatLng(28.060619, -80.622414),
        new google.maps.LatLng(28.060785, -80.62233),
        new google.maps.LatLng(28.060961, -80.622437),
        new google.maps.LatLng(28.0611, -80.622452),
        new google.maps.LatLng(28.061464, -80.622276),
        new google.maps.LatLng(28.061871, -80.622139),
        new google.maps.LatLng(28.06192, -80.62233),
        new google.maps.LatLng(28.061985, -80.622841),
        /*-------------------*/



        new google.maps.LatLng(28.06204, -80.623032),
        new google.maps.LatLng(28.062929, -80.623032),
        new google.maps.LatLng(28.063999, -80.622978),
        new google.maps.LatLng(28.063974, -80.621323),
        new google.maps.LatLng(28.063955, -80.62114),
        new google.maps.LatLng(28.063944, -80.619949),
        new google.maps.LatLng(28.063086, -80.619949),
        new google.maps.LatLng(28.06307, -80.620331),
        new google.maps.LatLng(28.062929, -80.620522),
        new google.maps.LatLng(28.06287, -80.621147),
        new google.maps.LatLng(28.063551, -80.62114),
    ]

    extendedPolyline = new google.maps.Polyline({
        path: extendedCoordinates,
        strokeColor: "#999999",
        strokeOpacity: 0.6,
        strokeWeight: 9
    });

    extendedPolyline.setMap(null);

}


function addTestRoute() {

    var COBCoordinates = [
        new google.maps.LatLng(28.065, -80.62114),
        new google.maps.LatLng(28.065, -80.6205),
        new google.maps.LatLng(28.065, -80.6198),
        new google.maps.LatLng(28.065, -80.619),
        new google.maps.LatLng(28.065000000439, -80.620099575119)
//		new google.maps.LatLng(28.06356, -80.62114),
//                new google.maps.LatLng(28.065, -80.6205),
//                new google.maps.LatLng(28.065, -80.6198),
//                
////                new google.maps.LatLng(28.06356, -80.62114),
////                new google.maps.LatLng(28.065, -80.6205),
////                new google.maps.LatLng(28.063244462943, -80.619934179137)
//                new google.maps.LatLng(28.06356, -80.619),
//                new google.maps.LatLng(28.065, -80.6198),
//                new google.maps.LatLng(28.064599593964, -80.620082904624),
//                new google.maps.LatLng(28.065, -80.6198),
//                new google.maps.LatLng(28.064526830147, -80.620134315142),
//                new google.maps.LatLng(28.065, -80.6198),
//                new google.maps.LatLng(28.065, -80.6205),
//                new google.maps.LatLng(28.064589059268, -80.620182408069),
//                new google.maps.LatLng(28.065, -80.6205),
//                new google.maps.LatLng(28.064526830147, -80.620134315142),
//                new google.maps.LatLng(28.0643, -80.6201),
//                new google.maps.LatLng(28.065000000437, -80.620205897448)
    ];

    var COBArrow = {
        path: 'M 5,5 15,5 10,-5 z',
        fillColor: '#996666',
        fillOpacity: 1,
        strokeWeight: 0,
        scale: 1.5,
        anchor: new google.maps.Point(10, 0)
    };

    nathanBiskPolyline = new google.maps.Polyline({
        path: COBCoordinates,
        strokeColor: "#996666",
        strokeOpacity: 1.0,
        strokeWeight: 4
    });
    nathanBiskPolyline.setMap(googleMap);
}

function setNathanBiskRoute() {

    var nathanBiskCoordinates = [
        //to College of Business //

        new google.maps.LatLng(28.06279, -80.623032), //PDH Stop, Going North
        new google.maps.LatLng(28.06397, -80.622993), //Panther PL & University
        new google.maps.LatLng(28.063987, -80.62205),
        new google.maps.LatLng(28.06395, -80.6214),
        new google.maps.LatLng(28.063928, -80.619944), /*
         new google.maps.LatLng(28.063086,-80.619949),
         new google.maps.LatLng(28.06307,-80.620331),*/

        /* start of commons */
        new google.maps.LatLng(28.063926, -80.619932),
        new google.maps.LatLng(28.063086, -80.619949),
        new google.maps.LatLng(28.06307, -80.620331),
        new google.maps.LatLng(28.062929, -80.620522),
        new google.maps.LatLng(28.06287, -80.621147),
        new google.maps.LatLng(28.06356, -80.62114),
        new google.maps.LatLng(28.06356, -80.62114),
        new google.maps.LatLng(28.063841, -80.621132),
        new google.maps.LatLng(28.063841, -80.619934),
        new google.maps.LatLng(28.06406, -80.619926),
        /* commons ends */

        /* University Blvd */
        new google.maps.LatLng(28.06408, -80.62103),
        new google.maps.LatLng(28.0640799, -80.62104),
        /*University Blvd ends */

        /* S Babcock St */
        new google.maps.LatLng(28.0640799, -80.621294),
        new google.maps.LatLng(28.07075, -80.621213),
        new google.maps.LatLng(28.07197, -80.621224),
        /* S Babcock St ends */

        /*Nathan Bisk */
        new google.maps.LatLng(28.07498, -80.62129),
        new google.maps.LatLng(28.07498, -80.62197),
        new google.maps.LatLng(28.07649, -80.62197),
        new google.maps.LatLng(28.07649, -80.62159),
        new google.maps.LatLng(28.07495, -80.6214),
        /* Nathan Bisk ends */

        /*S Babcock return */
        new google.maps.LatLng(28.07231, -80.62135),
        new google.maps.LatLng(28.07185, -80.621335),
        new google.maps.LatLng(28.0695, -80.62135),
        new google.maps.LatLng(28.06201, -80.62145),
        new google.maps.LatLng(28.061918, -80.62202),
        /*S Babcock ends */

        /*Panther Pl */
        new google.maps.LatLng(28.061884, -80.62215),
        new google.maps.LatLng(28.06192, -80.62233),
        new google.maps.LatLng(28.06198, -80.62284),
        new google.maps.LatLng(28.06204, -80.623036),
        new google.maps.LatLng(28.06279, -80.623032)
    ];

    nathanBiskPolyline = new google.maps.Polyline({
        path: nathanBiskCoordinates,
        strokeColor: "#996666",
        strokeOpacity: 0.7,
        strokeWeight: 9});
    nathanBiskPolyline.setMap(null);

}

// Add Downtown Route //
function setDowntownRoute() {
    var downtownCoordinates = [
        new google.maps.LatLng(28.076393, -80.6115),
        new google.maps.LatLng(28.07644, -80.6126),
        new google.maps.LatLng(28.07643, -80.61363),
        new google.maps.LatLng(28.06279, -80.623032), //PDH Stop, Going North
        new google.maps.LatLng(28.06397, -80.622993), //Panther PL & University
        new google.maps.LatLng(28.063987, -80.62205),
        new google.maps.LatLng(28.06395, -80.6214),
        new google.maps.LatLng(28.063928, -80.619944),
        /* start of commons */
        new google.maps.LatLng(28.063926, -80.619932),
        new google.maps.LatLng(28.063086, -80.619949),
        new google.maps.LatLng(28.06307, -80.620331),
        new google.maps.LatLng(28.062929, -80.620522),
        new google.maps.LatLng(28.06287, -80.621147),
        new google.maps.LatLng(28.06356, -80.62114),
        new google.maps.LatLng(28.06356, -80.62114),
        new google.maps.LatLng(28.063841, -80.621132),
        new google.maps.LatLng(28.063841, -80.619934),
        new google.maps.LatLng(28.06406, -80.619926),
        /* commons ends */

        /* University Blvd */
        new google.maps.LatLng(28.06408, -80.62103),
        new google.maps.LatLng(28.0640799, -80.62104),
        /*University Blvd ends */

        /* S Babcock St */
        new google.maps.LatLng(28.0640799, -80.621294),
        new google.maps.LatLng(28.07075, -80.621213),
        new google.maps.LatLng(28.07197, -80.621224),
        new google.maps.LatLng(28.075, -80.62129),
        new google.maps.LatLng(28.07528, -80.621355),
        new google.maps.LatLng(28.07652, -80.62139),
        new google.maps.LatLng(28.07856, -80.62143),
        /* S Babcock St ends */

        /*New Haven Ave */
        new google.maps.LatLng(28.078545, -80.618),
        new google.maps.LatLng(28.078556, -80.6178),
        new google.maps.LatLng(28.078562, -80.6177),
        new google.maps.LatLng(28.078627, -80.6173),
        new google.maps.LatLng(28.07867, -80.61716),
        new google.maps.LatLng(28.07867, -80.6169),
        new google.maps.LatLng(28.078661, -80.61673),
        new google.maps.LatLng(28.078651, -80.61667),
        new google.maps.LatLng(28.0786, -80.61647),
        new google.maps.LatLng(28.078585, -80.61637),
        new google.maps.LatLng(28.078583, -80.61627),
        new google.maps.LatLng(28.078598, -80.61606),
        new google.maps.LatLng(28.07844, -80.60678),
        new google.maps.LatLng(28.078414, -80.60605),
        new google.maps.LatLng(28.078273, -80.6046),
        new google.maps.LatLng(28.078273, -80.60447),
        /*New Haven Ave ends */

        /* Depot Dr */
        new google.maps.LatLng(28.078273, -80.60447),
        /* Depot Dr ends */

        /*E Melbourne Ave */
        new google.maps.LatLng(28.07706, -80.60384),
        new google.maps.LatLng(28.07698, -80.60396),
        new google.maps.LatLng(28.076935, -80.6042),
        new google.maps.LatLng(28.076911, -80.60467),
        new google.maps.LatLng(28.0768, -80.6055),
        new google.maps.LatLng(28.0766, -80.6059),
        new google.maps.LatLng(28.076523, -80.60627),
        new google.maps.LatLng(28.07636, -80.60782),
        new google.maps.LatLng(28.076356, -80.60882),
        new google.maps.LatLng(28.076393, -80.6115),
        new google.maps.LatLng(28.07644, -80.6126),
        new google.maps.LatLng(28.07643, -80.61363),
        new google.maps.LatLng(28.07643, -80.61369),
        new google.maps.LatLng(28.076482, -80.61733),
        new google.maps.LatLng(28.076482, -80.61832),
        new google.maps.LatLng(28.076503, -80.61934),
        new google.maps.LatLng(28.076485, -80.62037),
        /*E Melbourne Ave ends */

        /*S Babcock return */
        new google.maps.LatLng(28.07649, -80.621384),
        new google.maps.LatLng(28.07528, -80.621355),
        new google.maps.LatLng(28.075, -80.6214),
        new google.maps.LatLng(28.07231, -80.62135),
        new google.maps.LatLng(28.07185, -80.621335),
        new google.maps.LatLng(28.0695, -80.62135),
        new google.maps.LatLng(28.06201, -80.62145),
        new google.maps.LatLng(28.061918, -80.62202),
        /*S Babcock ends */

        /*Panther Pl */
        new google.maps.LatLng(28.061884, -80.62215),
        new google.maps.LatLng(28.06192, -80.62233),
        new google.maps.LatLng(28.06198, -80.62284),
        new google.maps.LatLng(28.06204, -80.623036),
        new google.maps.LatLng(28.06279, -80.623032)
    ];

    downtownPolyline = new google.maps.Polyline({
        path: downtownCoordinates,
        strokeColor: "#f29d1c",
        strokeOpacity: 0.7,
        strokeWeight: 9
    });
    downtownPolyline.setMap(null);
}

function addCampusRoute() {
    
    if (campusPolyline)
        campusPolyline.setMap(googleMap);
}

function addExtendedRoute() {
    
    if (extendedPolyline)
        extendedPolyline.setMap(googleMap);
}

function addNathanBiskRoute() {
    
    if (nathanBiskPolyline)
        nathanBiskPolyline.setMap(googleMap);
}

function addDowntownRoute() {
    
    if (downtownPolyline)
        downtownPolyline.setMap(googleMap);
}

function removeCampusRoute() {
    
    if (campusPolyline)
        campusPolyline.setMap(null);
}

function removeExtendedRoute() {
    
    if (extendedPolyline)
        extendedPolyline.setMap(null);
}

function removeNathanBiskRoute() {
    
    if (nathanBiskPolyline)
        nathanBiskPolyline.setMap(null);
}

function removeDowntownRoute() {
    
    if (downtownPolyline)
        downtownPolyline.setMap(null);
}