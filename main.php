<?
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-Type: application/json');

// Warning: This code was written during a Hackathon and needs more work.
// When using POST requests, take advantage of the request body for sending data.
$params = empty($_POST) ? $_GET : $_POST;

switch($params['feature']) {

	case 'get_flight_info':
		require_once('lib/Flight.php');
		$flight = new Flight($params['airline'], $params['flight_no']);
		$result = $flight->getData();
		break;
	case 'generate_access_key':
		require_once('lib/AccessKey.php');
		$key = new AccessKey();
		$result = $key->generateAccessKey();
		break;
	case 'add_flight_to_access_key':
		require_once('lib/AccessKey.php');
		$key = new AccessKey($params['access_key']);
		$result = $key->addFlightToAccessKey($params['airline'], $params['flight_no']);
		break;
	case 'get_flight_from_access_key':
		require_once('lib/AccessKey.php');
		$key = new AccessKey($params['access_key']);
		$result = $key->getFlightFromAccessKey();
		break;
	case 'confirm_access_key':
		require_once('lib/AccessKey.php');
		$key = new AccessKey($params['access_key']);
		$result = $key->confirmAccessKey();
		break;
	case 'destroy_access_key':
		require_once('lib/AccessKey.php');
		$key = new AccessKey($params['access_key']);
		$result = $key->destroyAccessKey();
		break;
}

// Print the end result
echo json_encode($result);

?>