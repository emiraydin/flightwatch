var the_key = null;
ajax({ url: 'http://flightwatch.org/main.php?feature=generate_access_key', method: 'get', type: 'json', async: false }, function(data){
  simply.title('Welcome! Here is your access key: ' + data.access_key);
  the_key = data.access_key;
});

simply.title('Yo here it is again: ' + the_key);

// while(true) {
// 	ajax({ url: 'http://flightwatch.org/main.php?feature=confirm_access_key&access_key=' + the_key, method: 'get', type: 'json' }, function(data){
//   		if (data.confirmed==1) {

//   			// Get the flight number using the access key
//   			var airline, flight_no;
//   			ajax({ url: 'http://flightwatch.org/main.php?feature=get_flight_from_access_key&access_key=' + the_key, method: 'get', type: 'json', async: false }, function(data){
//   				simply.title(data.airline + ' ' + data.flightNumber + '\n' + data.flightStatusType + ": " + data.flightStatusDelay
//   					+ '\n' + 'GATE: ' + data.gate + '\n' + data.origin + ' to ' + data.destination);
// 			});

//   			break;
//   		}
// 	});
// }
