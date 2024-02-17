<?php

namespace Secco2112\SteamAPI\Cache;

abstract class AbstractCacheMiddleware {

	const CACHE_KEY = 'SECCO2112_STEAM_API_CACHE_KEY';


	/** @var array */
	private $config = [];


	abstract public function setup(): void;

	abstract protected function validate(): bool;

	protected function setConfig(string $key, $data) {
		$this->config[$key] = $data;

		return $this;
	}

	protected function getConfig(string $key, $default = '') {
		return $this->config[$key] ?? $default;
	}

	protected function getAllConfigs(): array {
		return $this->config;
	}

	public function generateCacheKey(string $requestUrl, array $additionalParams = []): string {
		if (!empty($additionalParams)) {
			$requestUrl .= ':' . http_build_query($additionalParams);
		}

		$key = hash_hmac('sha256', $requestUrl, self::CACHE_KEY);

		return $key;
	}

}