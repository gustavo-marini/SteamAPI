<?php

namespace Secco2112\SteamAPI\Client\Response\News;

use Secco2112\SteamAPI\Client\Response\AbstractResponse;

class NewsItem extends AbstractResponse {

	public function init(object $response): void {
		$this->setAttribute('gid', $response->gid);
		$this->setAttribute('title', $response->title);
		$this->setAttribute('url', $response->url);
		$this->setAttribute('isExternalUrl', $response->is_external_url);
		$this->setAttribute('author', $response->author);
		$this->setAttribute('contents', $response->contents);
		$this->setAttribute('feedLabel', $response->feedlabel);
		$this->setAttribute('date', date('Y-m-d H:i:s', $response->date));
		$this->setAttribute('feedName', $response->feedname);
		$this->setAttribute('feedType', $response->feed_type);
	}

}