<?php

namespace Secco2112\SteamAPI\Client\Response\Apps;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class App extends AbstractResponse {

	public function init(object $response): void {
		$this->setAttribute('appId', $response->appid);
		$this->setAttribute('name', $response->name);
	}

	public function getAppId(): int {
		return $this->getAttribute('appId');
	}

	public function getName(): string {
		return $this->getAttribute('name');
	}

}