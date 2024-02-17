<?php

namespace Secco2112\SteamAPI\Client\Response\Apps;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class ServersAtAddress extends AbstractResponse {

	public function init(object $response): void {
		$dataResponse = $response->response;

		$servers = [];
		if ($dataResponse->success) {
			foreach ($dataResponse->servers as $server) {
				$servers[] = new ServerAtAddress($server);
			}
		}

		$this->setAttribute('count', count($servers));
		$this->setAttribute('servers', $servers);
	}

	public function getCount(): int {
		return $this->getAttribute('count');
	}

	public function getServers(): array {
		return $this->getAttribute('servers');
	}

}