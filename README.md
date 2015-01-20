FlightWatch
===========

Flight Watch is an application built at *@PennApps Winter 2014*. It lets you watch your flights on your Pebble watch.

Live at [flightwatch.org](http://flightwatch.org)

This repository includes the scrappy code that serves as a wrapper to FlightStatus API and bunch of other functionalities that form the FlightWatch API. The actual Pebble app is not in this repository.

**Note:** It was written in early 2014, and the changes I made in early 2015 are not improvements but changes to make the repo public.

`lib/Settings.php` should be added, it contains sensitive information and should look like this:
```php
<?
class Settings {
	public static $DB_HOST = "MYSQL_HOST";
	public static $DB_NAME = "MYSQL_DB_NAME";
	public static $DB_USER = "MYSQL_USER_NAME";
	public static $DB_PASSWORD = "MYSQL_PASSWORD";
}
?>
```