<?php

namespace Secco2112\SteamAPI\Client\Response\Apps;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class ServerAtAddress extends AbstractResponse {

	public function init(object $response): void {
		$this->setAttribute('address', $response->addr);
		$this->setAttribute('gmsindex', $response->gmsindex);
		$this->setAttribute('steamId', $response->steamid);
		$this->setAttribute('appId', $response->appid);
		$this->setAttribute('gameDir', $response->gamedir);
		$this->setAttribute('region', $response->region);
		$this->setAttribute('secure', $response->secure);
		$this->setAttribute('lan', $response->lan);
		$this->setAttribute('gamePort', $response->gameport);
		$this->setAttribute('specPort', $response->specport);
	}

	public function getAddress(): string {
		return $this->getAttribute('address');
	}

	public function getGMSIndex(): int {
		return $this->getAttribute('gmsindex');
	}

	public function getSteamId(): string {
		return $this->getAttribute('steamId');
	}

	public function getAppId(): int {
		return $this->getAttribute('appId');
	}

	public function getGameDir(): string {
		return $this->getAttribute('gameDir');
	}

	public function getRegion(): int {
		return $this->getAttribute('region');
	}

	public function getSecure(): bool {
		return $this->getAttribute('secure');
	}

	public function getLan(): bool {
		return $this->getAttribute('lan');
	}

	public function getGamePort(): int {
		return $this->getAttribute('gamePort');
	}

	public function getSpecPort(): int {
		return $this->getAttribute('specPort');
	}

}