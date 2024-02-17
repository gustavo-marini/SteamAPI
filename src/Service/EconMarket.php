<?php

namespace Secco2112\SteamAPI\Service;

class EconMarket extends AbstractService {

	const INTERFACE = 'IEconMarketService';


	public function getMarketEligibility(string $steamId) {
		$this->setEndpoint('GetMarketEligibility');
		$this->setMethod('GET');
		$this->setQueryParams([
			'steamid' => $steamId
		]);
		$this->setVersion('v1');
		$response = $this->exec();

		var_dump($response);
	}

}