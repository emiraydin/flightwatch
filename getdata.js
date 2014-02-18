ajax({ url: 'http://flightwatch.org/main.php?feature=generate_access_key', method: 'get', type: 'json' }, function(data){
  simply.title('Welcome! Here is your access key: ' + data.access_key);
  localStorage.setItem('access_key', data.access_key);
});

simply.scrollable(true);

while(true) {
	ajax({ url: 'http://flightwatch.org/main.php?feature=get_flight_from_access_key&access_key=' + localStorage.getItem('access_key'), method: 'get', type: 'json' }, function(data){
	  simply.title(data.airline + ' ' + data.flightNumber + '\n' + data.origin + ' to ' + data.destination + '\n'
	  	+ data.flightStatusType + '\nGATE: ' + data.gate + '\n', true);
	});
}