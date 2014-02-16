ajax({ url: 'http://flightwatch.org/main.php?feature=generate_access_key', method: 'get', type: 'json' }, function(data){
  simply.title(data.taxId);
});