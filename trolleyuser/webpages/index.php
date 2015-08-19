<!DOCTYPE HTML>
<html>
    <head>
        <title>Trolley Tracker</title>
        <link rel="stylesheet" href="https//fonts.googleapis.com/css?family=Droid+Sans" type="text/css" />
        <link rel="stylesheet" href="resources/css/style.css" />
        <link rel="stylesheet" href="resources/css/reset.css" />
        <link rel="stylesheet" href="resources/css/tracker/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBOCszb8tQ-eUURQntRKXg-qEJP0DZlXh0"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.0/jquery.nicescroll.min.js"></script>
        <script type="text/javascript" src = "resources/js/map.js"></script>
        <script type="text/javascript" src = "resources/js/routes.js"></script>
        <script type="text/javascript" src="resources/js/tracker/main.js"></script>
    </head>
    <body>
        <div id ="headerWrapper">
            <div id ="topBar">
                <div id ="logo">
                    <img src="resources/icons/logo2.png" />
                </div>
                <div id = "selections">
                    <div id ="settings">
                        <img src="resources/icons/setting_icon.png" />
                        <div id = "settingsExpansion">
                            
                            <ul>
                                <li><a id = "locationOption" href = "#">Set Location</a></li>
                                <li><a id ="routeOption" href = "#">Set Route</a></li>
                                <li><a id ="trolleyOption" href = "#">Trolley Tracking Info</a></li>
                            </ul>
                            <div id ="selectionMarker"></div>
                        </div>
                    </div>
                    <div id="menu">
                    </div>
                </div>
            </div>
        </div>
        <div id ="contentWrapper">
            <div id ="greyMap"></div>
            <div id ="timer">
                <div id ="ETA">
                    <div id ="ETAHeader"><p>ETA</p></div>
                    <div id="ETATime">
                        <p>8<span class ="timeUnit">m</span>30<span class ="timeUnit">s</span></p>
                    </div>
                    <div id="tracking">
                        <p>Tracking:<span id="trackedTrolleySpan">Trolley A</span></p>
                    </div>
                </div>
                <div class ="locationInfo">
                    <div id ="currentLocation">
                        <img src ="resources/icons/location.png" />
                        <p>PDH</p>
                    </div>
                    <div class ="prevLocation">
                        <img src="resources/icons/prev.png" />
                        <p>Dorm Circle</p>
                    </div>
                    <div class="nextLocation">
                        <img src="resources/icons/next.png" />
                        <p>Olin</p>
                    </div>
                </div>
            </div>
            <div id="activities">
                <img src="resources/icons/unwrap.png" />
                <p>Activities</p>
            </div>
            <div id="dropdown">
                <div id ="dropdownScrollable"></div>
            </div>
        </div>
    </body>
</html>