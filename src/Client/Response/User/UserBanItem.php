<?php

namespace Secco2112\SteamAPI\Client\Response\User;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class UserBanItem extends AbstractResponse {

	public function init(object $response): void {
		$this->setAttribute('steamId', $response->SteamId);
		$this->setAttribute('communityBanned', $response->CommunityBanned);
		$this->setAttribute('vacBanned', $response->VACBanned);
		$this->setAttribute('vacBansCount', $response->NumberOfVACBans);
		$this->setAttribute('daysSinceLastBan', $response->DaysSinceLastBan);
		$this->setAttribute('gameBansCount', $response->NumberOfGameBans);
		$this->setAttribute('economyBan', $response->EconomyBan);
	}

	public function getSteamId(): string {
		return $this->getAttribute('steamId');
	}

	public function isCommunityBanned(): bool {
		return $this->getAttribute('communityBanned');
	}

	public function isVACBanned(): bool {
		return $this->getAttribute('vacBanned');
	}

	public function getVACBansCount(): int {
		return $this->getAttribute('vacBansCount');
	}

	public function getDaysSinceLastBan(): int {
		return $this->getAttribute('daysSinceLastBan');
	}

	public function getGameBansCount(): int {
		return $this->getAttribute('gameBansCount');
	}

	public function getEconomyBan(): string {
		return $this->getAttribute('economyBan');
	}

}