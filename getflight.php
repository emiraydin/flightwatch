<?
class FlightStatus {

	private $airline, $flightNumber, $origin, $destination, $gate, $officialFlightNumber, $flightStatusType, $flightStatusDelay;

	function __construct($airline, $flightNumber) {
		require_once('lib/simple_html_dom.php');

		$this->airline = $airline;
		$this->flightNumber = $flightNumber;
		$today = date('Y-m-d');
		$url = 'http://mobile.flightstats.com/go/Mobile/flightStatusByFlight.do?airline=' . $this->airline . '&flightNumber=' . $this->flightNumber . '&departureDate=' . date('Y-m-d');
		$html = file_get_html($url);

		$box_array = $html->find('span[class=whiteContentBoxHeader]');
		$this->officialFlightNumber = trim(strip_tags($box_array[0])); 
		$this->origin = str_replace(' ', '', strip_tags($box_array[2]));
		$this->destination = str_replace(' ', '', strip_tags($box_array[3]));
		$this->gate = trim(strip_tags($html->find('div[class=fsByFlightGateTerminal]')[0]));
		$this->flightStatusType = trim(strip_tags($html->find('span[class=flightStatusType]')[0]));
		$this->flightStatusDelay = trim(strip_tags($html->find('span[class=flightStatusDelay]')[0]));
	}

	public function printJSON() {
		$arr = array(
			'airline' => $this->airline,
			'flightNumber' => $this->flightNumber,
			'officialFlightNumber' => $this->officialFlightNumber,
			'origin' => $this->origin,
			'destination' => $this->destination,
			'gate' => $this->gate,
			'flightStatusType' => $this->flightStatusType,
			'flightStatusDelay' => $this->flightStatusDelay
			);
		echo json_encode($arr);

	}

	function generateAccessKey() {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < 4; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}

}

header('Content-Type: application/json');
$newFlight = new FlightStatus($_GET['a'], $_GET['f']);
$newFlight->printJSON();

?>