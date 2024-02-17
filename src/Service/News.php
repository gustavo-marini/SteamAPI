<?php

namespace Secco2112\SteamAPI\Service;

use Secco2112\SteamAPI\Client\Response\News\NewsForApp;

class News extends AbstractService {

	const INTERFACE = 'ISteamNews';


	public function getNewsForApp(int $appId, int $maxlength = 0, int $endDateTimestamp = 0, int $count = 20, array $feeds = []) {
		$queryParams = [
			'appid' => $appId,
			'maxlength' => $maxlength
		];

		if (!empty($endDateTimestamp)) {
			$queryParams['enddate'] = $endDateTimestamp;
		}

		if (!empty($count)) {
			$queryParams['count'] = $count;
		}

		if (!empty($feeds)) {
			$queryParams['feeds'] = implode(',', $feeds);
		}
		
		$this->setEndpoint('GetNewsForApp');
		$this->setMethod('GET');
		$this->setQueryParams($queryParams);
		$this->setVersion('v2');
		$this->exec();

		$response = $this->getResponse();

		return new NewsForApp($response);
	}

}