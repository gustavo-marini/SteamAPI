<?php

namespace Secco2112\SteamAPI\Client\Response\User;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class Friend extends AbstractResponse {

	public function init(object $response): void {
		$this->setAttribute('steamId', $response->steamid);
		$this->setAttribute('relationship', $response->relationship);
		$this->setAttribute('friendsSince', date('Y-m-d H:i:s', $response->friend_since));
	}

	public function getSteamId(): string {
		return $this->getAttribute('steamId');
	}

	public function getRelationship(): string {
		return $this->getAttribute('relationship');
	}

	public function getFriendsSince(): string {
		return $this->getAttribute('friendsSince');
	}

}