<?php

namespace Secco2112\SteamAPI\Client\Response\PlayerService;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class OwnedGame extends AbstractResponse {

	public function init(object $response): void {
		$this->setAttribute('appId', $response->appid);
		$this->setAttribute('name', $response->name);
		$this->setAttribute('icon', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/' . $response->appid . '/' . $response->img_icon_url . '.jpg');
		if ($response->rtime_last_played > 0) {
			$this->setAttribute('lastPlayedAt', date('Y-m-d H:i:s', $response->rtime_last_played));
		}

		$playtime = [
			'total' => $response->playtime_forever,
			'totalInHours' => round($response->playtime_forever / 60, 2),
			'lastTwoWeeks' => $response->playtime_2weeks,
			'os' => [
				'windows' => $response->playtime_windows_forever,
				'linux' => $response->playtime_linux_forever,
				'mac' => $response->playtime_mac_forever
			]
		];

		$this->setAttribute('playtime', $playtime);
	}

	public function getAppId(): int {
		return $this->getAttribute('appId');
	}

	public function getName(): string {
		return $this->getAttribute('name');
	}

	public function getIcon(): string {
		return $this->getAttribute('icon');
	}

	public function getLastPlayedAt(): string {
		return $this->getAttribute('lastPlayedAt');
	}

	public function getPlaytimeInfo(): array {
		return $this->getAttribute('playtime');
	}

}