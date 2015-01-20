<?
class AccessKey {

	private $access_key, $connection;

	function __construct($access_key = NULL) {

		require_once("Settings.php");

		if ($access_key != NULL)
			$this->access_key = $access_key;

		$this->connection = new PDO("mysql:host=".Settings::$DB_HOST.";dbname=".Settings::$DB_NAME, Settings::$DB_USER, Settings::$DB_PASSWORD);


	}

	public function generateAccessKey() {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < 4; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    $this->access_key = $randomString;

	    $query = "INSERT INTO access_keys (the_key, date_created) VALUES ('".$this->access_key."', now())";
	    $sth = $this->connection->prepare($query);
		if ($sth->execute())
	    	return array('success' => 'yes', 'access_key' => $this->access_key);
	    else
	    	return array('success' => 'no');
	}

	public function addFlightToAccessKey($airline, $flight_no) {

		$query = "UPDATE access_keys SET airline = '". $airline. "', flight_no = ". $flight_no. " WHERE the_key='".$this->access_key."'";
	    $sth = $this->connection->prepare($query);

	    if ($sth->execute())
			return array('success' => 'yes');
		else
			return array('success' => 'no');

	}

	public function confirmAccessKey() {
		$query = "SELECT * FROM access_keys WHERE the_key = '".$this->access_key."' AND airline != ''"; // added recently
       	$sth = $this->connection->prepare($query);
	    $sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		if (count($result) > 0)
			return array('confirmed' => 1);
		else
			return array('confirmed' => 0);

	}

	public function destroyAccessKey() {

		$query = "DELETE FROM access_keys WHERE the_key ='".$this->access_key."'";
	    $sth = $this->connection->prepare($query);
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);

	   	if ($sth->execute())
			return array('success' => 'yes');
		else
			return array('success' => 'no');


	}

	public function getFlightFromAccessKey() {

		$query = "SELECT airline, flight_no FROM access_keys WHERE the_key = '".$this->access_key."'";
       	$sth = $this->connection->prepare($query);
	    $sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);

		require_once('lib/Flight.php');
		$flight = new Flight($result[0]['airline'], $result[0]['flight_no']);
		$result = $flight->getData();

		return $result;
		
	}

}
?>