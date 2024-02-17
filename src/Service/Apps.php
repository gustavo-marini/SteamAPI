<?php

namespace Secco2112\SteamAPI\Service;

use Secco2112\SteamAPI\Client\Response\Apps\AppList;
use Secco2112\SteamAPI\Client\Response\Apps\ServersAtAddress;
use Secco2112\SteamAPI\Client\Response\Apps\UpToDateCheck;

class Apps extends AbstractService {

	const INTERFACE = 'ISteamApps';


	public function getAppList() {
		$this->setEndpoint('GetAppList');
		$this->setMethod('GET');
		$this->setVersion('v2');
		$this->exec();

		$response = $this->getResponse();

		return new AppList($response);
	}

	public function getServersAtAddress(string $address) {
		$this->setEndpoint('GetServersAtAddress');
		$this->setMethod('GET');
		$this->setQueryParams([
			'addr' => $address
		]);
		$this->setVersion('v1');
		$this->exec();

		$response = $this->getResponse();

		return new ServersAtAddress($response);
	}

	public function isUpToDate(int $appId, int $version) {
		$this->setEndpoint('UpToDateCheck');
		$this->setMethod('GET');
		$this->setQueryParams([
			'appid' => $appId,
			'version' => $version
		]);
		$this->setVersion('v1');
		$this->exec();

		$response = $this->getResponse();

		return new UpToDateCheck($response);
	}

}