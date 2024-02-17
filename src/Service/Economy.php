<?php

namespace Secco2112\SteamAPI\Service;

class Economy extends AbstractService {

	const INTERFACE = 'ISteamEconomy';


	public function getAssetPrices(int $appId, string $currency = '', string $language = '') {
		$queryParams = [
			'appid' => $appId
		];

		if (!empty($currency)) {
			$queryParams['currency'] = $currency;
		}

		if (!empty($language)) {
			$queryParams['language'] = $language;
		}
		
		$this->setEndpoint('GetAssetPrices');
		$this->setMethod('GET');
		$this->setQueryParams($queryParams);
		$this->setVersion('v1');
		$this->exec();

		$response = $this->getResponse();

		dd($response);
	}

}