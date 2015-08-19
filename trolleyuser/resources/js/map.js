

var googleMap;
var routes = [];
var activeTrolleys = [];
var trolleys = [];
var activeTrolleyMarkers = [];
var trolleyStops = [];
var currentStop;

var socket;

/*
 * 
 * @param {associative array} obj
 * @returns size of associative array
 */
Object.size = function (obj) {
    var size = 0;
    var key;

    for (key in obj) {
        if (obj.hasOwnProperty(key))
            size++;
    }

    return size;
};

/* flags */
var routesSet = false;

$(function () {

    function initialize() {
        /*
         * 
         * @array
         * Set the properties of the map. the style is where we set the grey feature
         */
        var mapProperties = {
            center: new google.maps.LatLng(28.06356, -80.62114),
            zoom: 17,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [{"featureType": "landscape", "stylers": [{"saturation": -100}, {"lightness": 65}, {"visibility": "on"}]}, {"featureType": "poi", "stylers": [{"saturation": -100}, {"lightness": 51}, {"visibility": "simplified"}]}, {"featureType": "road.highway", "stylers": [{"saturation": -100}, {"visibility": "simplified"}]}, {"featureType": "road.arterial", "stylers": [{"saturation": -100}, {"lightness": 30}, {"visibility": "on"}]}, {"featureType": "road.local", "stylers": [{"saturation": -100}, {"lightness": 40}, {"visibility": "on"}]}, {"featureType": "transit", "stylers": [{"saturation": -100}, {"visibility": "simplified"}]}, {"featureType": "administrative.province", "stylers": [{"visibility": "off"}]}, {"featureType": "water", "elementType": "labels", "stylers": [{"visibility": "on"}, {"lightness": -25}, {"saturation": -100}]}, {"featureType": "water", "elementType": "geometry", "stylers": [{"hue": "#ffff00"}, {"lightness": -25}, {"saturation": -97}]}]
                    //styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
        };
        googleMap = new google.maps.Map(document.getElementById("greyMap"), mapProperties);

        /*
         * Set the trolley routes
         */
        setCampusRoute();
        setExtendedRoute();
        setNathanBiskRoute();
        setDowntownRoute();
        setInitialRoutes();

        /*
         * Init socket for communication with trolleys
         */
        initSocket();

        /*
         *  Get the trolleys and the trolley stops from the servver
         */
        fetchTrolleys();
        fetchStops();
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    /**
     * 
     * @param {String} name
     * @param {String} route
     * @returns {map_L33.trolleyObject}
     */
    function trolleyObject(name, route) {
        this.name = name;
        this.route = route;

        var active;
        var coordinates;

        this.setMarker = function (marker) {
            this.marker = marker;
        }

        this.setActive = function (boolean) {
            this.active = boolean;
        }

        this.setCoordinates = function (latitude, longitude) {
            this.coordinates = new google.maps.LatLng(latitude, longitude);
        }
    }

    /*
     * Gets the index of a trolley in a trolleyObject array, given the name of the trolley
     * @param {trolleyObject array} array
     * @param {String} trolley
     * @returns {Number} Index of trolley
     */
    function indexOfTrolley(array, trolley) {

        /*
         * The array being traversed is assumed to contain trolleyObjects
         * Violate this assumption and the function crumbles
         */
        for (var i = 0; i < array.length; i++) {

            if (array[i].name !== null && array[i].name === trolley)
                return i;
        }

        return -1;
    }


    /**
     * Initializes and handles the socket communication for the trolley services
     * @returns {undefined}
     */
    function initSocket() {

        socket = io.connect("http://localhost:3000");

        /*
         * Handle when a trolley's route changes
         */
        socket.on('routeChange', function (data) {

            var trolley = data.trolley;
            var route = data.route;

            if (trolley === null || route === null)
                return;

            var index = indexOfTrolley(trolleys, trolley);
            if (index >= 0) {

                console.log("route: " + route + ' ' + ', flag: ' + routes[route].flag);
                
                /*
                 * Update the count of the trolleys in the affected routes
                 */
                if (trolleys[index].active) {

                    routes[trolleys[index].route].count--;
                    console.log("From " + trolleys[index].route + " to " + route);
                }

                routes[route].count++;

                /*
                 * show live update of active trolley count if the route dropdown is active
                 */
                if (selectedSetting === 'route') {

                    var currentRoute = trolleys[index].route;
                    $('.' + currentRoute).html(routes[trolleys[index].route]['count'] + " trolleys active");
                    $('.' + route).html(routes[route]['count'] + " trolleys active");
                }

                trolleys[index].route = route;

                if (!trolleys[index].active)
                    trolleys[index].setActive(true);
            }

            console.log(index);
            console.log(data);
        });

        /*
         * Handle when a trolley has been disabled
         */
        socket.on('stopTrolley', function (data) {

            console.log('stopping trolley');
            var trolley = data.trolley;
            if (trolley === null)
                return;

            var index = indexOfTrolley(trolleys, trolley);
            
            /*
             * Update the count of the trolleys in the affected routes
             */
            if (index >= 0) {

                routes[trolleys[index].route].count--;

                trolleys[index].setActive(false);
            }

            console.log(data);
        });

        /*
         * Handle when a trolley's coordinates change
         */
        socket.on('coordinates', function (data) {

            var trolley = data.trolley;
            var longitude = data.longitude;
            var latitude = data.latitude;

            if (trolley === null || longitude === null || latitude === null)
                return;

            var index = indexOfTrolley(trolleys, trolley);
            /*
             * Update the coordinates of the trolleys
             */
            if (index >= 0) {

                trolleys[index].setCoordinates(data.latitude, data.longitude);
                trolleys[index].marker.setPosition(new google.maps.LatLng(data.latitude, data.longitude));
                console.log(data.latitude + ' ' + data.longitude);
            }
        });
    }


    /**
     *  Initializes the routes of the trolley
     * @returns {undefined}
     */
    function setInitialRoutes() {

        /*
         * Set the initialize routes to display in map
         * We display the campus route by default
         */
        routes['campus'] = {flag: true, name: 'Campus', count: 0};
        routes['extended'] = {flag: true, name: 'Campus (Extended)', count: 0};
        routes['downtown'] = {flag: false, name: 'Downtown Melbourne', count: 0};
        routes['nathanBisk'] = {flag: false, name: 'Nathan Bisk', count: 0};

        addCampusRoute();
        addExtendedRoute();

        console.log(routes);

        routesSet = true;
    }

    /*
     * Fetch the trolleys that are currently active (Unused in app)
     * @returns {undefined}
     */
    function fetchActiveTrolleys() {

        /*
         * Url for query
         * @type String
         */
        var activeTrolley = "http://localhost/trolleyquery/query_active";
        activeTrolley += "&campus=" + routes['campus']['flag'];
        activeTrolley += "&extended=" + routes['extended']['flag'];
        activeTrolley += "&nathanBisk=" + routes['nathanBisk']['flag'];
        activeTrolley += "&downtown=" + routes['downtown']['flag'];

        $.get(activeTrolley, function (data, status) {

            if (status === "success" && data.status === "success") {
                for (var i = 0; i < data.trolleys.length; i++) {

                    var trolley = data.trolleys[i];
                    if (indexOfTrolley(trolley) < 0) {
                        
                        var newTrolley = new trolleyObject(trolley.trolley_name, trolley.present_route);
                        
                        var marker = new google.maps.Marker({
                            position: null,
                            map: null,
                            icon: 'http://localhost/trolleyuser/resources/icons/trolley.png',
                            rotation: 170
                        });
                        
                        newTrolley.setMarker(marker);
                        
                        activeTrolleys.push(newTrolley);
                    }
                }

                console.log(activeTrolleys);
            }


        }, 'json');

        trolleyData = true;
    }
    
    /**
     * Fetch all trolleys and their attributes
     * @returns {undefined}
     */
    function fetchTrolleys() {

        /*
         * Query url
         * @type String
         */
        var activeTrolley = "http://localhost/trolleyquery/query_all";

        /*
         * Make ajax get call
         */
        $.get(activeTrolley, function (data, status) {

            console.log(data);
            if (status === "success" && data.status === "success") {
                for (var i = 0; i < data.trolleys.length; i++) {

                    var trolley = data.trolleys[i];
                    if (indexOfTrolley(trolley) < 0) {

                        /*
                         * Update affected routes
                         */
                        if (trolley.active === '1')
                            routes[trolley.present_route].count++;
                        /*
                         * Create trolley object for current trolley
                         * @type map_L33.trolleyObject
                         */
                        var currentTrolley = new trolleyObject(trolley.trolley_name, trolley.present_route);
                        
                        var marker = new google.maps.Marker({
                            position: null,
                            map: googleMap,
                            icon: 'http://localhost/trolleyuser/resources/icons/trolley.png',
                            rotation: 170
                        });
                        
                        /*
                         * Set attributes for current trolley
                         */
                        currentTrolley.setMarker(marker);
                        currentTrolley.setActive(trolley.active === '1' ? true : false);
                        trolleys.push(currentTrolley);
                    }
                }
            }


        }, 'json');
    }

    /**
     * Fetch the trolley stops from the database
     * @returns {undefined}
     */
    function fetchStops() {

        var trolleyStopsUrl = "http://localhost/trolleyquery/query_stops";
        $.get(trolleyStopsUrl, function (data, status) {

            if (status == "success" && data.status == "success") {

                /*
                 * Populate the trolley stops array
                 */
                for (var i = 0; i < data.stops.length; i++) {
                    var key = data.stops[i].key;
                    stopData = {name: data.stops[i].name,
                        alias: data.stops[i].alias,
                        flag: ((i == 0) ? true : false)};
                    if (i == 0)
                        currentStop = data.stops[i].key;

                    trolleyStops[key] = stopData;
                }
            }

        }, 'json');
    }
});
