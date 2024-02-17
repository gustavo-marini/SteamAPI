<?php

namespace Secco2112\SteamAPI\Client\Response\Apps;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class AppList extends AbstractResponse {

	public function init(object $response): void {
		$appList = $response->applist->apps;

		$this->setAttribute('count', count($appList));

		$apps = [];

		foreach ($appList as $app) {
			$apps[] = new App($app);
		}

		$this->setAttribute('apps', $apps);
	}

	public function getCount(): int {
		return $this->getAttribute('count');
	}

	public function getApps(): array {
		return $this->getAttribute('apps');
	}

}