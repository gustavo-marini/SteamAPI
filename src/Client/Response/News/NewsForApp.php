<?php

namespace Secco2112\SteamAPI\Client\Response\News;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class NewsForApp extends AbstractResponse {

	public function init(object $response): void {
		if (!isset($response->appnews)) {
			return;
		}

		$dataResponse = $response->appnews;

		$this->setAttribute('count', $dataResponse->count);

		$news = [];

		foreach ($dataResponse->newsitems as $item) {
			$news[] = new NewsItem($item);
		}

		$this->setAttribute('news', $news);
	}

}