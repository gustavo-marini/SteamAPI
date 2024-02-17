<?php

namespace Secco2112\SteamAPI\Client\Response\PlayerService;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class OwnedGames extends AbstractResponse {

	public function init(object $response): void {
		$dataResponse = $response->response;

		$this->setAttribute('totalCount', $dataResponse->game_count);

		$games = [];
		foreach ($dataResponse->games as $game) {
			$games[] = new OwnedGame($game);
		}

		$this->setAttribute('games', $games);
	}

	public function getCount(): int {
		return $this->getAttribute('count');
	}

	public function getGames(): array {
		return $this->getAttribute('games');
	}

}