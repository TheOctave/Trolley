var app = require('express')();
var bodyParser = require("body-parser");
var http = require('http').Server(app);
var io = require('socket.io')(http);

var clients = [];
var clientPrefs = [];

app.use(bodyParser.urlencoded({extended: false}));
app.get('/', function(req, res) {
	res.send('<h1>Hello world</h1>');
});

io.on('connection', function(socket) {
	
	clients.push(socket);
	clientPrefs.push(null);
	console.log("new connection");
	
	socket.on('trolleyUpdate', function(data) {
		
	});
	
	/*
	* Handle update of trolleys in watch
	*/
	socket.on('trolleyWatch', function(data) {
		
		console.log(clientPrefs);
	});
	
	socket.on('initialTrolleys', function(data) {
		
		clientPrefs = data;
		console.log(clientPrefs);
	});
	
	/*
	* Handle disconnections
	*/
	socket.on('disconnect', function() {
		console.log('Client disconnected');
		clients.splice(clients.indexOf(socket), 1);
	});
});

app.post('/update', function(request, response) {
	var trolley = request.body.name;
	var latitude = request.body.latitude;
	var longitude = request.body.longitude;
	
	console.log(trolley);
	console.log(latitude);
	console.log(longitude);
	
	var trolleyData = {'trolley' : trolley, 'latitude' : latitude, 'longitude' : longitude};
	io.emit('coordinates', trolleyData);
	response.end();
});

app.post('/routeChange', function(request, response) {
	var trolley = request.body.name;
	var route = request.body.route;
	
	console.log(trolley);
	console.log(route);
	
	var trolleyData = {'trolley' : trolley, 'route' : route};
	io.emit('routeChange', trolleyData);
	response.end();
});

app.post('/stopTrolley', function(request, response) {
	var trolley = request.body.name;
	var route = request.body.route;
	
	console.log('stopping ' +trolley);
	
	var trolleyData = {'trolley' : trolley};
	io.emit('stopTrolley', trolleyData);
	response.end();
});

app.post('/addTrolley', function(request, response) {
	var trolley = request.body.name;
	var route = request.body.name;
	
	console.log(trolley);
	
	var trolleyData = {'trolley' : trolley, 'route' : route};
	io.emit('trolleyStopped', trolleyData);
	response.end();
});

http.listen(3000, function() {
	console.log('listening on *:3000');
});