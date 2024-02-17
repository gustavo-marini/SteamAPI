<?php

namespace Secco2112\SteamAPI\Client\Response\PlayerService;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class Badge extends AbstractResponse {

	public function init(object $response): void {
		$this->setAttribute('id', $response->badgeid);
		$this->setAttribute('level', $response->level);
		$this->setAttribute('completionAt', date('Y-m-d H:i:s', $response->completion_time));
		$this->setAttribute('XP', $response->xp);
		$this->setAttribute('scarcity', $response->scarcity);
	}

}