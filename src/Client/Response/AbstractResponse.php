<?php

namespace Secco2112\SteamAPI\Client\Response;

abstract class AbstractResponse {

	/** @var array */
	private $data;


	public function __construct(object $response) {
		$this->init($response);
	}

	abstract function init(object $response): void;

	protected function setAttribute(string $key, $data): self {
		if (!is_null($data)) {
			$this->data[$key] = $data;
		}

		return $this;
	}

	protected function getAttribute(string $key) {
		return $this->data[$key] ?? '';
	}

	public function __get($name) {
		return $this->data[$name] ?? '';
	}

}