<?
class Flight {

	private $airline, $flightNumber, $origin, $destination, $gate, $flightStatusType, $flightStatusDelay;

	// Fetch data via FlightStatus API
	function __construct($airline, $flightNumber) {

		$this->airline = $airline;
		$this->flightNumber = $flightNumber;
		$today = date('Y-m-d');
		$url = 'https://api.flightstats.com/flex/flightstatus/rest/v2/json/flight/status/' . $this->airline . '/' . $this->flightNumber . '/dep/' . date('Y') . '/' . date('m') . '/' . date('d') . '?appId='.Settings::$FLIGHTSTATUS_APP_ID.'&appKey='.Settings::$FLIGHTSTATUS_API_KEY.'&utc=false';

		$request = file_get_contents($url);
		$result = json_decode($request);

		$delay = 0;
		$status = 'Unknown';

		$getStatus = $result->flightStatuses[0]->status;
		switch ($getStatus) {
			case 'A':
				$status = 'Airborne';
				break;
			case 'C':
				$status = 'Canceled';
				break;
			case 'D':
				$status = 'Delayed';
				break;
			case 'L':
				$status = 'Landed';
				break;
			case 'S':
				$planned = $result->flightStatuses[0]->operationalTimes->publishedDeparture->dateLocal;
				$current = $result->flightStatuses[0]->operationalTimes->scheduledGateDeparture->dateLocal;
				$p1 = strtotime($planned);
				$p2 = strtotime($current);
				if ($p1 != $p2) {
					$delay = ($p1 - $p2) / 60;
					$status = 'Delayed ' . $delay . ' minutes';
				} else {
					$status = 'On Time: '. date('H:i', $p1);
				}
				break;
		}


		$this->origin = $result->flightStatuses[0]->departureAirportFsCode;
		$this->destination = $result->flightStatuses[0]->arrivalAirportFsCode;
		$this->gate = $result->flightStatuses[0]->airportResources->departureGate;
		$this->flightStatusType = $status;
		$this->flightStatusDelay = $delay;
	}

	// Fetch data by parsing FlightStats HTML
	function alternativeConstruct($airline, $flightNumber) {
		require_once('includes/simple_html_dom.php');

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


	public function getData() {
		$arr = array(
			'airline' => $this->airline,
			'flightNumber' => $this->flightNumber,
			'origin' => $this->origin,
			'destination' => $this->destination,
			'gate' => $this->gate,
			'flightStatus' => $this->flightStatusType
		);
		return $arr;

	}

}

?>