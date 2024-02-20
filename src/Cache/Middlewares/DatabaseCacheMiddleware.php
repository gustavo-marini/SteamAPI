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
		$this->conn();
		$this->deleteExpiredCachedData();
		$this->createTableIfNotExists();
	}

	private function deleteExpiredCachedData(): void {
		$expiredCachedDataQuery = 'DELETE FROM ' . self::TABLE_NAME . ' WHERE expire_at < NOW()';

		$this->conn()->query($expiredCachedDataQuery);
	}

	private function createTableIfNotExists(): void {
		$createTableQuery = 'CREATE TABLE IF NOT EXISTS ' . self::TABLE_NAME . '
			(
				id int(11) AUTO_INCREMENT PRIMARY KEY,
				cache_key varchar(255) NOT NULL,
				cache_data mediumtext NOT NULL,
				expire_at datetime NOT NULL,
				created_at timestamp DEFAULT CURRENT_TIMESTAMP,
				updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
			)
		;';

		$this->conn()->query($createTableQuery);
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

	public function store(string $key, $data, int $expirationTime): void {
		$insertCachedDataQuery = 'INSERT INTO ' . self::TABLE_NAME . ' (cache_key, cache_data, expire_at) VALUES (?, ?, ?);';

		$expireAtTimestamp = time() + $expirationTime;
		$expireAtDatetime = gmdate('Y-m-d H:i:s', $expireAtTimestamp);

		$preparedStatement = $this->conn()->prepare($insertCachedDataQuery);
		$preparedStatement->bind_param('sss', $key, $data, $expireAtDatetime);
		$preparedStatement->execute();
	}

}