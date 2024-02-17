<?php

namespace Secco2112\SteamAPI\Client\Response\User;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class FriendsList extends AbstractResponse {

	public function init(object $response): void {
		$dataResponse = $response->friendslist;

		$this->setAttribute('count', count($dataResponse->friends));

		$friends = [];

		foreach ($dataResponse->friends as $friend) {
			$friends[] = new Friend($friend);
		}

		$this->setAttribute('friends', $friends);
	}

	public function getCount(): int {
		return $this->getAttribute('count');
	}

	public function getFriends(): array {
		return $this->getAttribute('friends');
	}

}