<?php

namespace Secco2112\SteamAPI\Service;

use Secco2112\SteamAPI\API;
use Secco2112\SteamAPI\Cache\CacheExpiration;
use Secco2112\SteamAPI\Client\Request\RequestClient;

abstract class AbstractService {

	const INTERFACE = '';

	const DEFAULT_CACHE_EXPIRATION_TIME = CacheExpiration::THIRTY_MINUTES;


	/** @var API */
	private $api;

	/** @var RequestClient */
	private $requestClient;

	/** @var string */
	private $endpoint;

	/** @var int */
	private $cacheExpirationTime = self::DEFAULT_CACHE_EXPIRATION_TIME;

	/** @var string */
	private $method;

	/** @var array */
	private $queryParams;

	/** @var object */
	private $response;

	/** @var string */
	private $version;


	public function __construct(API $api) {
		$this->api = $api;
		$this->buildRequestClient();
	}

	private function buildRequestClient(): void {
		$this->requestClient = new RequestClient;
	}

	public function setEndpoint(string $endpoint): self {
		$this->endpoint = $endpoint;

		return $this;
	}

	public function setCacheExpirationTime(int $cacheExpirationTime): static {
		$this->cacheExpirationTime = $cacheExpirationTime;

		return $this;
	}

	public function setMethod(string $method): self {
		$this->method = $method;

		return $this;
	}

	public function setQueryParams(array $queryParams): self {
		$this->queryParams = $queryParams;

		return $this;
	}

	public function setResponse(object $response): self {
		$this->response = $response;

		return $this;
	}

	public function getResponse(): object {
		return $this->response;
	}

	public function setVersion(string $version): self {
		$this->version = $version;

		return $this;
	}

	private function buildRequestUrl(): string {
		$urlParts = [
			trim($this->api->environment()->getBaseUrl(), '/')
		];

		if (!empty(static::INTERFACE)) {
			$urlParts[] = static::INTERFACE;
		}

		if (!empty($this->endpoint)) {
			$urlParts[] = $this->endpoint;
		}

		if (!empty($this->version)) {
			$urlParts[] = $this->version;
		}

		return implode('/', $urlParts);
	}

	private function buildRequestQueryParams(): string {
		$params = [
			'key' => $this->api->auth()->getKey()
		];

		if (!empty($this->queryParams)) {
			$params = array_merge($params, $this->queryParams);
		}
		
		return '?' . http_build_query($params);
	}

	protected function exec(): void {
		$urlBase = $this->buildRequestUrl();
		$requestQueryParams = $this->buildRequestQueryParams();

		$finalRequestUrl = $urlBase . $requestQueryParams;

		$response = $this->tryRequestDataFromCache($finalRequestUrl);

		if ($response !== false) {
			$this->setResponse($response);
			return;
		}

		$response = $this->requestClient->request($this->method, $finalRequestUrl);

		$this->saveDataOnCacheStorages($response, $finalRequestUrl);

		$this->setResponse(json_decode($response));
	}

	private function tryRequestDataFromCache(string $requestUrl, array $additionalParams = []) {
		$cacheMiddlewares = $this->api->getCacheMiddlewares();

		if (empty($cacheMiddlewares)) {
			return false;
		}

		foreach ($cacheMiddlewares as $cacheMiddleware) {
			$cacheMiddleware->setup();
			$cacheKey = $cacheMiddleware->generateCacheKey($requestUrl, $additionalParams);

			$cachedData = $cacheMiddleware->getData($cacheKey);

			if ($cachedData !== false) {
				return json_decode(unserialize($cachedData));
			}
		}

		return false;
	}

	private function saveDataOnCacheStorages(string $data, string $requestUrl, array $additionalParams = []): void {
		$cacheMiddlewares = $this->api->getCacheMiddlewares();

		if (empty($cacheMiddlewares)) {
			return;
		}

		foreach ($cacheMiddlewares as $cacheMiddleware) {
			$cacheMiddleware->setup();
			$cacheKey = $cacheMiddleware->generateCacheKey($requestUrl, $additionalParams);

			$cacheMiddleware->store($cacheKey, serialize($data), $this->cacheExpirationTime);
		}
	}

}