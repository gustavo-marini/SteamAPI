<?php

namespace Secco2112\SteamAPI\Service;

use Secco2112\SteamAPI\Client\Response\PlayerService\Badges;
use Secco2112\SteamAPI\Client\Response\PlayerService\OwnedGames;
use Secco2112\SteamAPI\Client\Response\PlayerService\RecentlyPlayedGames;
use Secco2112\SteamAPI\Client\Response\PlayerService\SteamLevel;

class Player extends AbstractService {

	const INTERFACE = 'IPlayerService';


	public function getRecentlyPlayedGames(string $steamId) {
		$this->setEndpoint('GetRecentlyPlayedGames');
		$this->setMethod('GET');
		$this->setQueryParams([
			'steamid' => $steamId
		]);
		$this->setVersion('v1');
		$this->exec();

		$response = $this->getResponse();

		return new RecentlyPlayedGames($response);
	}

	public function getOwnedGames(string $steamId, bool $includesAppInfo = false, bool $includesFreeGames = false, array $appIds = []) {
		$this->setEndpoint('GetOwnedGames');
		$this->setMethod('GET');
		$this->setQueryParams([
			'steamid' => $steamId,
			'include_appinfo' => $includesAppInfo,
			'include_played_free_games' => $includesFreeGames,
			'appids_filter' => $appIds
		]);
		$this->setVersion('v1');
		$this->exec();

		$response = $this->getResponse();

		return new OwnedGames($response);
	}

	public function getSteamLevel(string $steamId) {
		$this->setEndpoint('GetSteamLevel');
		$this->setMethod('GET');
		$this->setQueryParams([
			'steamid' => $steamId
		]);
		$this->setVersion('v1');
		$this->exec();

		$response = $this->getResponse();

		return new SteamLevel($response);
	}

	public function getBadges(string $steamId) {
		$this->setEndpoint('GetBadges');
		$this->setMethod('GET');
		$this->setQueryParams([
			'steamid' => $steamId
		]);
		$this->setVersion('v1');
		$this->exec();

		$response = $this->getResponse();

		return new Badges($response);
	}

	public function getCommunityBadgeProgress(string $steamId, int $badgeId) {
		$this->setEndpoint('GetCommunityBadgeProgress');
		$this->setMethod('GET');
		$this->setQueryParams([
			'steamid' => $steamId,
			'badgeid' => $badgeId
		]);
		$this->setVersion('v1');
		$this->exec();

		$response = $this->getResponse();

		return $response;
	}

}