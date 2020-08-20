<?php
namespace GoogleApi;

use Carbon\Carbon;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

class GoogleApi {

	private $service;

	public function __construct() {
		$client = new Google_Client();
		$client->setApplicationName(APP_NAME);
		$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
		$client->setAccessType('offline');
		$client->setAuthConfig(AUTH_CONFIG_FILE);

		$service = new Google_Service_Sheets($client);
		$this->setService($service);
	}

	public function insertQuery($query, $type = 0) {
		$service = $this->getService();
		$range = $type === 0
			? MIN3_QUERY_LIST.'!A:F'
			: MIN10_QUERY_LIST.'!A:F';
		$values = [
			[
				"",
				Carbon::parse($query->item(QUERY_START)->nodeValue)
					->format('Y-m-d'),
				Carbon::parse($query->item(QUERY_START)->nodeValue)
					->format('H:i:s'),
				$query->item(QUERY)->nodeValue,
				$query->item(PID)->nodeValue,
				$query->item(USENAME)->nodeValue
			]
		];
		$body = new Google_Service_Sheets_ValueRange([
			'values' => $values
		]);
		$params = [
			'valueInputOption' => "USER_ENTERED"
		];
		$result = $service
			->spreadsheets_values
			->append(
				SPREAD_SHEET_ID,
				$range,
				$body,
				$params
			);

		return $result;
	}

	public function setService($service) {
		$this->service = $service;
	}

	public function getService() {
		return $this->service;
	}
}
