<?php

namespace Secco2112\SteamAPI\Client\Response\PlayerService;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class Badges extends AbstractResponse {

	public function init(object $response): void {
		$dataResponse = $response->response;

		$badges = [];

		foreach ($dataResponse->badges as $badge) {
			$badges[] = new Badge($badge);
		}

		$this->setAttribute('badges', $badges);

		$this->setAttribute('totalXP', $dataResponse->player_xp);
		$this->setAttribute('userLevel', $dataResponse->player_level);
		$this->setAttribute('totalXPToLevelUp', $dataResponse->player_xp_needed_to_level_up);
		$this->setAttribute('totalXPCurrentLevel', $dataResponse->player_xp_needed_current_level);
	}

}