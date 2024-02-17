<?php

namespace Secco2112\SteamAPI\Client\Response\PlayerService;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class RecentlyPlayedGames extends AbstractResponse {

	public function init(object $response): void {
		$dataResponse = $response->response;

		$this->setAttribute('totalCount', $dataResponse->total_count);

		$games = [];
		foreach ($dataResponse->games as $game) {
			$games[] = new PlayedGame($game);
		}

		$this->setAttribute('games', $games);
	}

	public function getTotalCount(): int {
		return $this->getAttribute('totalCount');
	}

	public function getGames(): array {
		return $this->getAttribute('games');
	}

}