<?php

namespace Secco2112\SteamAPI\Cache\Middlewares;


use Secco2112\SteamAPI\Cache\AbstractCacheMiddleware;
use Secco2112\SteamAPI\Cache\ICacheMiddleware;

class RedisCacheMiddleware extends AbstractCacheMiddleware implements ICacheMiddleware {

    public function setup(): void {
		
	}

	protected function validate(): bool {
		return true;
	}

	public function getData(string $key) {
		
	}

	public function store(string $key, $data, int $expirationTime): void {
		
	}

}