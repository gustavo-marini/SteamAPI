<?php

namespace Secco2112\SteamAPI\Client\Response\PlayerService;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class SteamLevel extends AbstractResponse {

	public function init(object $response): void {
		$this->setAttribute('level', $response->response->player_level);
	}

	public function getLevel(): int {
		return $this->getAttribute('level');
	}

}