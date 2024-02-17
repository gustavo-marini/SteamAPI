<?php

namespace Secco2112\SteamAPI;

use Secco2112\SteamAPI\Cache\ICacheMiddleware;
use Secco2112\SteamAPI\Service\Apps;
use Secco2112\SteamAPI\Service\EconMarket;
use Secco2112\SteamAPI\Service\Economy;
use Secco2112\SteamAPI\Service\News;
use Secco2112\SteamAPI\Service\Player;
use Secco2112\SteamAPI\Service\User;

class API {

	/** @var Authentication */
	private $authentication;

	/** @var Environment */
	private $environment;

	/** @var ICacheMiddleware[] */
	private $cacheMiddlewares = [];

	public function __construct() {
		$this->authentication = new Authentication;
		$this->environment = new Environment;
	}

	public function auth(?string $key = null): Authentication {
		if ($key) {
			$this->authentication->setKey($key);
		}

		return $this->authentication;
	}

	public function environment(): Environment {
		return $this->environment;
	}

	public function addCacheMiddleware(ICacheMiddleware $cacheMiddleware): self {
		$this->cacheMiddlewares[] = $cacheMiddleware;

		return $this;
	}

	/**
	 * @return ICacheMiddleware[]
	 */
	public function getCacheMiddlewares(): array {
		return $this->cacheMiddlewares;
	}

	public function apps(): Apps {
		return new Apps($this);
	}

	public function econMarket(): EconMarket {
		return new EconMarket($this);
	}

	public function economy(): Economy {
		return new Economy($this);
	}

	public function news(): News {
		return new News($this);
	}

	public function player(): Player {
		return new Player($this);
	}

	public function user(): User {
		return new User($this);
	}

}