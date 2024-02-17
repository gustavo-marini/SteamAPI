<?php

namespace Secco2112\SteamAPI\Client\Response\User;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class UserBans extends AbstractResponse {

	public function init(object $response): void {
		$players = [];

		foreach ($response->players as $player) {
			$players[] = new UserBanItem($player);
		}

		$this->setAttribute('players', $players);
	}

	public function getPlayers(): array {
		return $this->getAttribute('players');
	}

}