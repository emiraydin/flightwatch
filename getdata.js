ajax({ url: 'http://flightwatch.org/api/AA-88/', method: 'get', type: 'json' }, function(data){
  simply.title(data.flightStatusType);
});