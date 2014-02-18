ajax({ url: 'http://flightwatch.dev/main.php?feature=get_flight_from_access_key&access_key=73hp', method: 'get', type: 'json' }, function(data){
  simply.title(data.airline + ' ' + data.flightNumber + '\n' + data.origin + ' to ' + data.destination + '\n'
  	+ data.flightStatusType + '\nGATE: ' + data.gate + '\n');
});