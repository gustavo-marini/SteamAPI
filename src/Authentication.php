<?php

namespace Secco2112\SteamAPI;

class Authentication {

	private $key;


	public function setKey(string $key): self {
		$this->key = $key;

		return $this;
	}

	public function getKey(): string {
		return $this->key;
	}

}