ajax({ url: 'http://flightwatch.org/main.php?feature=generate_access_key', method: 'get', type: 'json'}, function(data){
  simply.title('Welcome! Here is your access key: ' + data.access_key);
  localStorage.setItem('access_key', data.access_key);
});

// simply.scrollable(true);

var count = parseInt(localStorage.getItem('count')) || 0;

simply.on('singleClick', function(e) {
  if (e.button === 'up') {
    simply.subtitle(++count);
  } else if (e.button === 'down') {
    simply.subtitle(--count);
  }
  localStorage.setItem('count', count);
});

simply.text({ title: 'Counter', subtitle: count });