<?php

namespace Secco2112\SteamAPI\Client\Request;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class RequestClient {

	/** @var Client */
	private $httpClient;

	public function __construct() {
		$this->httpClient = new Client([
			RequestOptions::HTTP_ERRORS => false,
			RequestOptions::VERIFY => false
		]);
	}

	public function request(string $method, string $url): string {
		$response = $this->httpClient->request($method, $url);

		return $response->getBody()->getContents();
	}

}