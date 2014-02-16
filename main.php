<?
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-Type: application/json');

$params = array_merge($_POST, $_GET);

switch($params['feature']) {

	case 'get_flight_info':
		require_once('Flight.php');
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