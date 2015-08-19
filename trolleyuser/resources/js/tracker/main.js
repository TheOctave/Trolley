var smallMap;
var selectedSetting = "";

$(function(){
    
    /*
     * Base variable for dropdown
     */
    var baseDropdownHeight = 252;
    var droppedDown = false;
    
    /*
     * TODO: this should replace the selectedSetting variable in function
     * Dropdown Settings. Indicates which dropdown option is selected
     */
    var settings = {
        location : false,
        route : false,
        trolley : false
    };
    
    /**
     * 
     * @returns {undefined}
     * Sizes the divs on window resize
     */
    function sizeDivs() {
        var headerHeight = $("#headerWrapper").height();
        var height = $(window).height() - headerHeight;
        $("#contentWrapper").css('height', height + 'px');
        var right = ($(window).width() - 960) / 2;
        $("#timer").css('right', (right + 260) + 'px');
        $("#activities").css('right', right + 'px');
    }
    
    sizeDivs();
    $(window).resize(function() {
        sizeDivs();
    });
    
    function wait(variable) {
        
       var counter = 0;
       while (!variable && counter < 1000000000) {
           counter++;
       };
       
       if (variable >= 1000000000) {
           alert("Could not load element " + variable);
           return;
       }
    }
    
    /**
     * Collapses the dropdown menu
     * @returns {undefined}
     */
    function removeDropdown() {
        
        $("#dropdownScrollable").html("");
        $("#selectionMarker").css('visibility', 'hidden');
        $("#selectionMarker").css('left', 0);
        $("#selectionMarker").css('width', 0);
        $("#settingsExpansion").height($("#settingsExpansion").height() - 3);
        $("#dropdown").css('visibility', 'hidden');
        droppedDown = false;
        selectedSetting = "";
    }
    
    /*
     * Set 'settings' array
     */
    function setSettings(key) {
        
        if (selectedSetting != "")
            settings[selectedSetting] = false;
        settings[key] = true;
        selectedSetting = key;
    }
   
   /**
    * Add the dropdown for trolley location
    * @returns {undefined}
    */
   function addLocationDropdown() {
       
       wait(trolleyStops);
       
       var content = "";
       counter = 0;
       var len = Object.size(trolleyStops);
       
       /*
        * Populate the location dropdown list with the location data
        */
       for (var key in trolleyStops) {
           
           content  +=  '<div class = "locationItem">'
                            + '<a href ="#" class = "locationPryLink"><div class = "location">'
                                + '<p class = "locationName">' + trolleyStops[key]['name'] + '</p>'
                                + '<p class = "locationETA">' + counter + 'm 30s</p>'
                            + '</div></a>'
                            + '<div class = "settingsActions">'
                                + (!trolleyStops[key]['flag'] ? '<a class = "selectLink" href = "#">' : '')
                                + '<div class = "settingsSelectButton ' + (trolleyStops[key]['flag'] ? 'selected' : '') + '" key = "' + key + '">' + (trolleyStops[key]['flag'] ? 'SELECTED' : 'SELECT') + '</div>'
                                +(!trolleyStops[key]['flag'] ? '</a>' : '')
                            + '</div>'
                        + '</div>';
                
            if (counter < len - 1)
                content += '<div class = "hr"></div>';
            counter++;
        }
           
        
        /*
         * Style the dropdown
         */
        $("#dropdownScrollable").html(content);
        var right = ($(window).width() - 960) / 2;
        $("#dropdown").css('top', 0 + 'px');
        $("#dropdown").css('right', right + 'px');
        $("#dropdown").css('padding', '8px 0 8px 0');
        $("#dropdown").css('visibility', 'visible');
        $("#dropdownScrollable").niceScroll({ autohidemode: true });
        
   }
   
   /*
    * Add the dropdown for the routes list
    * @returns {undefined}
    */
   function addRouteDropdown() {
       
       wait(routes);
       
       var content = "";
       counter = 0;
       var len = Object.size(routes);
       /*
        * Populate the route dropdown list with route data
        */
       for (var key in routes) {
           
           content  +=  '<div class = "routeItem">'
                            + '<a href ="#" class = "routePryLink"><div class = "route">'
                                + '<p class = "routeName">' + routes[key]['name'] +'</p>'
                                + '<p class = "activeTrolleys ' + key + '">' + routes[key].count + ' trolleys active</p>'
                            + '</div></a>'
                            + '<div class = "settingsActions">'
                                + '<a href = "#" class = "checkbox"><img src = "resources/icons/' + (routes[key]['flag'] ? 'checkedbox' : 'checkbox') + '.png" class = "checkBoxImage" key = "' + key + '" /></a>'
                            + '</div></a>'
                        + '</div>';
                
            if (counter < len - 1)
                content += '<div class = "hr"></div>';
            counter++;
       }
           
        
        /*
         * Style the dropdown
         */
        $("#dropdownScrollable").html(content);
        var right = ($(window).width() - 960) / 2;
        $("#dropdown").css('top', 0 + 'px');
        $("#dropdown").css('right', right + 'px');
        $("#dropdown").css('padding', '8px 0 8px 0');
        $("#dropdown").css('visibility', 'visible');
        $("#dropdownScrollable").css('height', baseDropdownHeight + 'px');
        $("#dropdownScrollable").niceScroll({ autohidemode: true });
    }
   
   /*
    * Add the dropdown for the trolley list
    */
   function addTrolleyDropdown() {
       
       /*
        * Populate the trolley dropdown with the trolley data
        */
       var content = '<div class = "trolleyItem">'
                        + '<a href ="#" class = "trolleyPryLink"><div class = "trolley">'
                            + '<img src = "resources/icons/trolley_pic.png" />'
                            + '<div class = "trolleyDesc">'
                            + '<p class = "trolleyName">Trolley A</p>'
                            + '<p class = "activeTrolleys">3 trolleys active</p>'
                            + '</div>'
                        + '</div></a>'
                        + '<div class = "settingsActions">'
                        + '</div>'
                        + '<div class = "locationInfo">'
                        +   '<div class="prevLocation">'
                        +       '<img src="resources/icons/prev.png" />'
                        +       '<p>Dorm Circle</p>'
                        +   '</div>'
                        +   '<div class="nextLocation">'
                        +       '<img src="resources/icons/next.png" />'
                        +       '<p>Olin</p>'
                        +   '</div>'
                        + '</div>'
                    + '</div>';
        
        content += '<div class = "hr"></div>';
        content += '<div class = "trolleyItem">'
                        + '<a href ="#" class = "trolleyPryLink"><div class = "trolley">'
                            + '<img src = "resources/icons/trolley_pic.png" />'
                            + '<div class = "trolleyDesc">'
                            + '<p class = "trolleyName">Trolley B</p>'
                            + '<p class = "activeTrolleys">3 trolleys active</p>'
                            + '</div>'
                        + '</div></a>'
                        + '<div class = "settingsActions">'
                        + '</div>'
                        + '<div class = "locationInfo">'
                        +   '<div class="prevLocation">'
                        +       '<img src="resources/icons/prev.png" />'
                        +       '<p>Dorm Circle</p>'
                        +   '</div>'
                        +   '<div class="nextLocation">'
                        +       '<img src="resources/icons/next.png" />'
                        +       '<p>Olin</p>'
                        +   '</div>'
                        + '</div>'
                    + '</div>';
           
        content += '<div class = "hr"></div>';
        content += '<div class = "trolleyItem">'
                        + '<a href ="#" class = "trolleyPryLink"><div class = "trolley">'
                            + '<img src = "resources/icons/trolley_pic.png" />'
                            + '<div class = "trolleyDesc">'
                            + '<p class = "trolleyName">Trolley C</p>'
                            + '<p class = "activeTrolleys">3 trolleys active</p>'
                            + '</div>'
                        + '</div></a>'
                        + '<div class = "settingsActions">'
                        + '</div>'
                        + '<div class = "locationInfo">'
                        +   '<div class="prevLocation">'
                        +       '<img src="resources/icons/prev.png" />'
                        +       '<p>Dorm Circle</p>'
                        +   '</div>'
                        +   '<div class="nextLocation">'
                        +       '<img src="resources/icons/next.png" />'
                        +       '<p>Olin</p>'
                        +   '</div>'
                        + '</div>'
                    + '</div>';
           
        content += '<div class = "hr"></div>';
        content += '<div class = "trolleyItem">'
                        + '<a href ="#" class = "trolleyPryLink"><div class = "trolley">'
                            + '<img src = "resources/icons/trolley_pic.png" />'
                            + '<div class = "trolleyDesc">'
                            + '<p class = "trolleyName">Trolley D</p>'
                            + '<p class = "activeTrolleys">3 trolleys active</p>'
                            + '</div>'
                        + '</div></a>'
                        + '<div class = "settingsActions">'
                        + '</div>'
                        + '<div class = "locationInfo">'
                        +   '<div class="prevLocation">'
                        +       '<img src="resources/icons/prev.png" />'
                        +       '<p>Dorm Circle</p>'
                        +   '</div>'
                        +   '<div class="nextLocation">'
                        +       '<img src="resources/icons/next.png" />'
                        +       '<p>Olin</p>'
                        +   '</div>'
                        + '</div>'
                    + '</div>';
           
        
        /*
         * Style the dropdown
         */
        $("#dropdownScrollable").html(content);
        var right = ($(window).width() - 960) / 2;
        $("#dropdown").css('top', 0 + 'px');
        $("#dropdown").css('right', right + 'px');
        $("#dropdown").css('padding', '8px 0 8px 0');
        $("#dropdown").css('visibility', 'visible');
        $("#dropdownScrollable").niceScroll({ autohidemode: true });
   }
   
   /**
    * Create a map view for the dropdown pry
    * @param {String} divClass, indicates the active dropdown
    * @returns {undefined}
    */
   function dropdownMap(divClass) {
       
        var mapProperties = {
             center: new google.maps.LatLng(28.064,-80.6244),
             zoom: 17,
             mapTypeId: google.maps.MapTypeId.ROADMAP,
             styles: [{"featureType":"all","elementType":"labels","stylers":[{"visibility":"on"}]},{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#c4c4c4"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text.fill","stylers":[{"color":"#707070"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21},{"visibility":"on"}]},{"featureType":"poi.business","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#be2026"},{"lightness":"0"},{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"labels.text.stroke","stylers":[{"visibility":"off"},{"hue":"#ff000a"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#575757"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.stroke","stylers":[{"color":"#2c2c2c"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#999999"}]},{"featureType":"road.local","elementType":"labels.text.stroke","stylers":[{"saturation":"-52"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]
        };
        $("#dropdown").css('padding-bottom', 0);
        smallMap = new google.maps.Map(document.getElementsByClassName(divClass)[0], mapProperties);
   }
   
   /**
    * The little line that goes to indicate a selected dropdown
    * @param {String} selection
    * @param {Number} leftOffset
    * @returns {undefined}
    */
   function setSelectedOptionIndicator(selection, leftOffset) {
       
        if (!droppedDown) {
            $("#settingsExpansion").height($("#settingsExpansion").height() + 3);
            droppedDown = true;
        }
            
        $("#selectionMarker").css('bottom', 0);
        $("#selectionMarker").fadeIn();
        $("#selectionMarker").css('visibility', 'visible');
        $("#selectionMarker").animate({
            left: leftOffset,
            width: $(selection).outerWidth()
        });
   }
   
   /*
    * Select action when location dropdown option is clicked
    */
   $("#locationOption").click(function(e) {
       
       e.preventDefault();
       
       /*
        * Toggle click
        */
       if (selectedSetting == "location") {
           removeDropdown();
           return;
       } else {
           setSettings("location");
       }
       
       /*
        * Add dropdown
        */
       setSelectedOptionIndicator(this, 10);
       $("#dropdown").height(baseDropdownHeight);
       $("#dropdown").css('padding', '8px 0 8px 0');
       addLocationDropdown();
       return false;
   });
   
   /*
    * Select action when route dropdown option is clicked
    */
    $("#routeOption").click(function(e) {
       
       e.preventDefault();
       
       /*
        * Toggle click
        */
       if (selectedSetting == "route") {
           removeDropdown();
           return;
       } else {
           setSettings("route");
       }
       
       /*
        * Add dropdown
        */
       setSelectedOptionIndicator(this, 136);
       $("#dropdown").height(baseDropdownHeight);
       $("#dropdown").css('padding', '8px 0 8px 0');
       addRouteDropdown();
       return false;
   });
   
   /*
    * Select action when trolley dropdown option is clicked
    */
   $("#trolleyOption").click(function(e) {
       
       e.preventDefault();
       
       /*
        * Toggle click
        */
       if (selectedSetting == "trolley") {
           removeDropdown();
           return;
       } else {
           setSettings("trolley");
       }
       
       /*
        * Add dropdown
        */
       setSelectedOptionIndicator(this, 236);
       $("#dropdown").height(baseDropdownHeight);
       $("#dropdown").css('padding', '8px 0 8px 0');
       addTrolleyDropdown();
       return false;
   });
   
   /*
    * Handle the mouse hover actions for a list item in the location dropdown
    */
   $("body").on({
       mouseenter: function(e){
            e.stopPropagation();
            var actions = $(this).find('.settingsActions');
            
            if (actions) {
                actions.append('<a href ="#" class = "locationPryLink"><img src="resources/icons/drop.png" class = "dropdownIcon" /></a>');
            }
       },
       mouseleave: function(e){
            e.stopPropagation();
            var actions = $(this).find('.settingsActions');
            var dropdownIcon = actions.find('.locationPryLink');
            
            if (actions) {
                dropdownIcon.remove();
            }
       },
       click: function(e){
           
       }
   }, ".locationItem");
   
   /*
    * Handle the mouse hover actions for a list item in the route dropdown
    */
   $("body").on({
       mouseenter: function(e){
            e.stopPropagation();
            var actions = $(this).find('.settingsActions');
            
            if (actions) {
                actions.append('<a href ="#" class = "routePryLink"><img src="resources/icons/drop.png" class = "dropdownIcon" /></a>');
            }
       },
       mouseleave: function(e){
            e.stopPropagation();
            var actions = $(this).find('.settingsActions');
            var dropdownIcon = actions.find('.routePryLink');
            
            if (actions) {
                dropdownIcon.remove();
            }
       },
       click: function(e){
           
       }
   }, ".routeItem");
   
   /*
    * Handle the mouse hover actions for a list item in the trolley dropdown
    */
   $("body").on({
       mouseenter: function(e){
            e.stopPropagation();
            var actions = $(this).find('.settingsActions');
            
            if (actions) {
                actions.append('<a href ="#" class = "trolleyPryLink"><img src="resources/icons/drop.png" class = "dropdownIcon" /></a>');
            }
       },
       mouseleave: function(e){
            e.stopPropagation();
            var actions = $(this).find('.settingsActions');
            var dropdownIcon = actions.find('.trolleyPryLink');
            
            if (actions) {
                dropdownIcon.remove();
            }
       },
       click: function(e){
           
       }
   }, ".trolleyItem");
   
   /*
    * Handle a click action on a location dropdown item
    */
   $("body").on("click", ".locationItem a.locationPryLink", function(e) {
       e.preventDefault();
       var locationItem = $(this).closest('.locationItem');
       $("#dropdownScrollable").html(locationItem);
       var mapDiv = '<div class = "locationMap"></div>';
       $("#dropdownScrollable").append(mapDiv);
       dropdownMap("locationMap");
       $("#dropdownScrollable").height(locationItem.outerHeight(true) + $(".locationMap").outerHeight(true));
       $("#dropdown").height($("#dropdownScrollable").height());
       return false;
   });
   
   /*
    * Handle a click action on a route dropdown item
    */
   $("body").on("click", ".routeItem a.routePryLink", function(e){
      e.preventDefault();
      var routeItem = $(this).closest('.routeItem');
      $("#dropdownScrollable").html(routeItem);
      var mapDiv = '<div class = "routeMap"></div>';
      $("#dropdownScrollable").append(mapDiv);
      dropdownMap("routeMap");
      $("#dropdownScrollable").height(routeItem.outerHeight(true) + $(".routeMap").outerHeight(true));
      $("#dropdown").height($("#dropdownScrollable").height());
      return false;
   });
   
   /*
    * Handle a click action on a trolley dropdown item
    */
   $("body").on("click", ".trolleyItem a.trolleyPryLink", function(e){
      e.preventDefault();
      var trolleyItem = $(this).closest('.trolleyItem');
      $("#dropdownScrollable").html(trolleyItem);
      var mapDiv = '<div class = "trolleyMap"></div>';
      $("#dropdownScrollable").append(mapDiv);
      dropdownMap("trolleyMap");
      $("#dropdownScrollable").height(trolleyItem.outerHeight(true) + $(".trolleyMap").outerHeight(true));
      $("#dropdown").height($("#dropdownScrollable").height());
      return false;
   });
   
   /*
    * Control the custom checkbox for the route dropdown
    */
   $("body").on("click", ".checkbox", function(e){
       
       if (!socket) {
           alert("Socket not set yet");
       }
       
        e.preventDefault();
        var checkbox = $(this).find(".checkBoxImage");
        var key = checkbox.attr("key");
        if (routes[key]['flag']) {
            
            checkbox.attr("src", "resources/icons/checkbox.png");
            routes[key]['flag'] = false;
            if (key === 'campus') {
                
                removeCampusRoute();
            } else if (key === 'extended') {
                
                removeExtendedRoute();
            } else if (key === 'nathanBisk') {
                
                removeNathanBiskRoute();
            } else if (key === 'downtown') {
                
                removeDowntownRoute();
            }
        } else {
            
            checkbox.attr("src", "resources/icons/checkedbox.png");
            routes[key]['flag'] = true;
            
            if (key === 'campus') {
                
                addCampusRoute();
            } else if (key === 'extended') {
                
                addExtendedRoute();
            } else if (key === 'nathanBisk') {
                
                addNathanBiskRoute();
            } else if (key === 'downtown') {
                
                addDowntownRoute();
            }
        }
        
        return false;
   });
   
   /*
    * Handle the selection of a location
    */
   $("body").on("click", ".settingsActions .selectLink", function(e) {
       
        e.preventDefault();
        trolleyStops[currentStop]['flag'] = false;
        var currentSelected = $(".settingsActions .selected");
        var currentSelectedReplacement = '<a class = "selectLink" href = "#">'
                                            + '<div class = "settingsSelectButton" key = "' + currentStop + '">SELECT</div>'
                                        +'</a>';
        currentSelected.parent().html(currentSelectedReplacement);
        
        $(".settingsActions .selected").removeClass("selected");
        var newlySelected = $(this).find('.settingsSelectButton');
        var parent = $(this).parent();
        
        var newKey = newlySelected.attr("key");
        trolleyStops[newKey]['flag'] = true;
        var newContent = '<div class = "settingsSelectButton selected" key = "' + newKey + '">' + 'SELECTED' + '</div>'
        parent.html(newContent);
        
        currentStop = newlySelected.attr("key");
        
        return false;
   });
});
