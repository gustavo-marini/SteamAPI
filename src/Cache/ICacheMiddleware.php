<?php

namespace Secco2112\SteamAPI\Cache;

interface ICacheMiddleware {

	public function setup(): void;

	public function generateCacheKey(string $requestUrl, array $additionalParams = []): string;

	public function getData(string $key);

	public function store(string $key, $data): void;

}