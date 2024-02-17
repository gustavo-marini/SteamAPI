<?php

namespace Secco2112\SteamAPI;

class Environment {

	const BASE_URL = 'https://api.steampowered.com';


	public function getBaseUrl(): string {
		return self::BASE_URL;
	}

}