<?php

namespace Secco2112\SteamAPI\Service;

use Secco2112\SteamAPI\Client\Response\User\FriendsList;
use Secco2112\SteamAPI\Client\Response\User\UserBans;

class User extends AbstractService {

	const INTERFACE = 'ISteamUser';


	public function getFriends(string $steamId, string $relationship = '') {
		$queryParams = [
			'steamid' => $steamId
		];

		if (!empty($relationship)) {
			$queryParams['relationship'] = $relationship;
		}
		
		$this->setEndpoint('GetFriendList');
		$this->setMethod('GET');
		$this->setQueryParams($queryParams);
		$this->setVersion('v1');
		$this->exec();

		$response = $this->getResponse();

		return new FriendsList($response);
	}

	public function getBans(string $steamId) {
		$this->setEndpoint('GetPlayerBans');
		$this->setMethod('GET');
		$this->setQueryParams([
			'steamids' => $steamId
		]);
		$this->setVersion('v1');
		$this->exec();

		$response = $this->getResponse();

		return new UserBans($response);
	}

}