<?php

namespace Secco2112\SteamAPI\Client\Response\PlayerService;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class PlayedGame extends AbstractResponse {

	public function init(object $response): void {
		$this->setAttribute('appId', $response->appid);
		$this->setAttribute('name', $response->name);
		$this->setAttribute('icon', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/' . $response->appid . '/' . $response->img_icon_url . '.jpg');

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
		return $this->getAttribute('appId');
	}

	public function getPlaytimeInfo(): array {
		return $this->getAttribute('playtime');
	}

}