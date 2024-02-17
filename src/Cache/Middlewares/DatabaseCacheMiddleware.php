<?php

namespace Secco2112\SteamAPI\Cache\Middlewares;

use mysqli;
use Secco2112\SteamAPI\Cache\AbstractCacheMiddleware;
use Secco2112\SteamAPI\Cache\ICacheMiddleware;

class DatabaseCacheMiddleware extends AbstractCacheMiddleware implements ICacheMiddleware {

	const TABLE_NAME = 'steam_api_cache';


	/** @var mysqli */
	private $conn = null;


	private function conn(): mysqli {
		if (empty($this->conn)) {
			$this->conn = new mysqli(
				$this->getConfig('host'),
				$this->getConfig('username'),
				$this->getConfig('password'),
				$this->getConfig('databaseName'),
				$this->getConfig('port', null)
			);
		}

		return $this->conn;
	}

	public function setHost(string $host): self {
		$this->setConfig('host', $host);

		return $this;
	}

	public function setPort(int $port): self {
		$this->setConfig('port', $port);

		return $this;
	}

	public function setUsername(string $username): self {
		$this->setConfig('username', $username);

		return $this;
	}

	public function setPassword(string $password): self {
		$this->setConfig('password', $password);

		return $this;
	}

	public function setDatabaseName(string $databaseName): self {
		$this->setConfig('databaseName', $databaseName);

		return $this;
	}

	public function setup(): void {
		$connection = $this->conn();
		$this->createTableIfNotExists();
	}

	private function createTableIfNotExists(): void {
		$connection = $this->conn();
		
		$createTableQuery = 'CREATE TABLE IF NOT EXISTS ' . self::TABLE_NAME . '
			(
				id int(11) AUTO_INCREMENT PRIMARY KEY,
				cache_key varchar(255) NOT NULL,
				cache_data mediumtext NOT NULL,
				created_at timestamp DEFAULT CURRENT_TIMESTAMP,
				updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
			)
		;';

		$this->conn->query($createTableQuery);
	}

	protected function validate(): bool {
		return true;
	}

	public function getData(string $key) {
		if (!$this->validate()) {
			// TO-DO Add validation logic
		}

		$selectCachedDataQuery = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE cache_key = "' . $key . '"';

		$result = $this->conn()->query($selectCachedDataQuery);
		if ($result->num_rows == 0) {
			return false;
		}

		$resultData = $result->fetch_all(MYSQLI_ASSOC);

		return $resultData[0]['cache_data'] ?? false;
	}

	public function store(string $key, $data): void {
		$insertCachedDataQuery = 'INSERT INTO ' . self::TABLE_NAME . ' (cache_key, cache_data) VALUES (?, ?);';

		$preparedStatement = $this->conn()->prepare($insertCachedDataQuery);
		$preparedStatement->bind_param('ss', $key, $data);
		$preparedStatement->execute();
	}

}